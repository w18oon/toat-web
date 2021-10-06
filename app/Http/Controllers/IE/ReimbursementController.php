<?php

namespace App\Http\Controllers\IE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\IE\AttachmentRepo;
use App\Repositories\IE\ActivityLogRepo;
use App\Repositories\IE\RequestRepo;
use App\Repositories\IE\ApprovalRepo;
use App\Repositories\IE\MailRepo;
use App\Repositories\IE\InterfaceRepo;

use App\Models\IE\Reimbursement;
use App\Models\IE\Preference;
use App\Models\IE\Employee;
use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\SubCategoryInfo;
use App\Models\IE\Currency;
use App\Models\IE\Location;
use App\Models\IE\Establishment;
use App\Models\IE\Vendor;
use App\Models\IE\FNDListOfValues;
use App\Models\IE\Receipt;
use App\Models\IE\ReceiptLine;
use App\Models\IE\ReceiptLineInfo;
use App\Models\IE\PaymentMethod;
use App\Models\IE\User;

use Carbon\Carbon;

class ReimbursementController extends Controller
{
    protected $perPage = 10;
    protected $orgId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->orgId = \Auth::user()->org_id;
            return $next($request);
        });
    }

    public function index()
    {
        $search = [];
        $reims = Reimbursement::orderBy('created_at','desc')
                        ->whereOrgId(81)
                        // ->whereUserId(\Auth::user()->id)
                        ->with('user')
                        ->paginate($this->perPage);
        $allowDuplicate = true;

        return view('ie.reimbursements.index',
                        compact('reims',
                                'search',
                                'allowDuplicate'));
    }

    public function indexPending()
    {
        $search = [];
        $reims = Reimbursement::orderBy('created_at','desc')
                        ->whereOrgId($this->orgId)
                        ->ByPendingUser(\Auth::user()->id)
                        ->with('user')
                        ->paginate($this->perPage);

        return view('ie.reimbursements.index_pending',
                        compact('reims',
                                'search'));
    }

    public function create()
    {
        // $userId = auth()->user()->id;
        $userId = -1;
        // GET PENDING TRASACTION
        $pendingRequestLists = RequestRepo::getPendingOverLimitDayRequest($userId);

        return view('ie.reimbursements.create',
                        compact('pendingRequestLists'
                                ));
    }

    public function store(Request $request)
    {
        dd('xxx', request()->all());
        // GET PENDING TRASACTION
        $pendingRequestLists = RequestRepo::getPendingOverLimitDayRequest(\Auth::user()->id);

        \DB::beginTransaction();
        try {
            // CREATE REIMBURSEMENT
            $reim = new Reimbursement();
            $reim->org_id = $this->orgId;
            // $reim->organization_id = \Auth::user()->employee->organization_id;
            $reim->document_no = Reimbursement::genDocumentNo($this->orgId);
            $reim->user_id = \Auth::user()->id;
            // $reim->position_id = $request->position_id;

            $reim->currency_id  = Preference::getBaseCurrency($this->orgId);
            $reim->purpose  = trim($request->purpose);
            if(count($pendingRequestLists) == 0){
                $reim->status = "NEW_REQUEST";
            }else{ // BLOCKED IF HAS PENDING REQUEST
                $reim->status = "BLOCKED";
            }
            $reim->save();

            // FILE ATTACHMENTS
            if($request->file('file')){
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($reim, $request->file('file'));
            }

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($reim, ActivityLogRepo::getActivityMessage('NEW_REQUEST'));

            // SUCCESS CREATE REIMBURSEMENT
            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                $result['reimId'] = $reim->id;
                return $result;
            }else{
                return redirect()->route('ie.reimbursements.show',['reimId'=>$reim->id]);
            }

        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                // throw new \Exception($e->getMessage(), 1);
                \Log::error($e->getMessage());
                return abort('403');
            }
        }
    }

    public function update(Request $request, $reimId)
    {
        \DB::beginTransaction();
        try {

            $reim = Reimbursement::find($reimId);
            $reim->purpose  = trim($request->purpose);
            $reim->save();

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->route('ie.reimbursements.show',['reimId'=>$reim->id]);
    }

    public function duplicate(Request $request, $reimId)
    {
        // GET PENDING TRASACTION
        $pendingRequestLists = RequestRepo::getPendingOverLimitDayRequest(\Auth::user()->id);

        \DB::beginTransaction();
        try {

            $reim = Reimbursement::find($reimId);

            ////////////////////////////
            // DUPLICATE REIMBURSEMENT
            $newReim = new Reimbursement();
            $newReim->org_id = $this->orgId;
            // $newReim->organization_id = \Auth::user()->employee->organization_id;
            $newReim->document_no = Reimbursement::genDocumentNo($this->orgId);
            $newReim->user_id = \Auth::user()->id;
            // $newReim->position_id = $request->position_id;

            $newReim->currency_id  = Preference::getBaseCurrency($this->orgId);
            $newReim->purpose  = trim($request->purpose);
            if(count($pendingRequestLists) == 0){
                $newReim->status = "NEW_REQUEST";
            }else{ // BLOCKED IF HAS PENDING REQUEST
                $newReim->status = "BLOCKED";
            }
            $newReim->save();

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($newReim, ActivityLogRepo::getActivityMessage('NEW_REQUEST'));

            ////////////////////////////
            // DUPLICATE RECEIPT DATA
            $receipts = $reim->receipts;
            foreach ($receipts as $key => $receipt) {

                $newReceipt = new Receipt();
                $newReceipt->receipt_number = $receipt->receipt_number;
                $newReceipt->receipt_date = $receipt->receipt_date;
                $newReceipt->location_id = $receipt->location_id;
                $newReceipt->currency_id = $receipt->currency_id;
                $newReceipt->exchange_rate = $receipt->exchange_rate;
                $newReceipt->establishment_id = $receipt->establishment_id;
                $newReceipt->establishment_name = $receipt->establishment_name;
                $newReceipt->vendor_id = $receipt->vendor_id;
                $newReceipt->vendor_name = $receipt->vendor_name;
                $newReceipt->vendor_tax_id = $receipt->vendor_tax_id;
                $newReceipt->vendor_branch_name = $receipt->vendor_branch_name;
                $newReceipt->jusification = $receipt->jusification;
                $newReceipt->project = $receipt->project;
                $newReceipt->job = $receipt->job;
                $newReceipt->recharge = $receipt->recharge;
                // SAVE RECEIPT DATA
                $newReim->receipts()->save($newReceipt);

                /////////////////////////////////
                // DUPLICATE RECEIPT LINES DATA
                $receiptLines = $receipt->lines;
                foreach($receiptLines as $receiptLine){

                    // DUPLICATE RECEIPT LINE DATA
                    $newReceiptLine = new ReceiptLine();
                    $newReceiptLine->receipt_id = $newReceipt->id;
                    $newReceiptLine->branch_code = $receiptLine->branch_code;
                    $newReceiptLine->department_code = $receiptLine->department_code;
                    $newReceiptLine->category_id = $receiptLine->category_id;
                    $newReceiptLine->sub_category_id = $receiptLine->sub_category_id;
                    // QUANTITY & AMOUNT
                    $newReceiptLine->quantity = $receiptLine->quantity;
                    $newReceiptLine->second_quantity = $receiptLine->second_quantity;
                    $newReceiptLine->transaction_quantity = $receiptLine->transaction_quantity;
                    $newReceiptLine->amount = $receiptLine->amount;
                    $newReceiptLine->amount_inc_vat = $receiptLine->amount_inc_vat;
                    $newReceiptLine->total_amount = $receiptLine->total_amount;
                    $newReceiptLine->total_amount_inc_vat = $receiptLine->total_amount_inc_vat;
                    $newReceiptLine->policy_id = $receiptLine->policy_id;
                    $newReceiptLine->rate_id = $receiptLine->rate_id;
                    $newReceiptLine->mileage_unit_id = $receiptLine->mileage_unit_id;
                    $newReceiptLine->mileage_distance = $receiptLine->mileage_distance;
                    $newReceiptLine->mileage_start = $receiptLine->mileage_start;
                    $newReceiptLine->mileage_end = $receiptLine->mileage_end;
                    $newReceiptLine->primary_amount = $receiptLine->primary_amount;
                    $newReceiptLine->primary_amount_inc_vat = $receiptLine->primary_amount_inc_vat;
                    // PRIMARY => CALCULATE (WITH EXCHANGE RATE) TO BASE CURRENCY
                    $newReceiptLine->total_primary_amount = $receiptLine->total_primary_amount;
                    $newReceiptLine->total_primary_amount_inc_vat = $receiptLine->total_primary_amount_inc_vat;
                    // VAT
                    $newReceiptLine->vat_id = $receiptLine->vat_id;
                    $newReceiptLine->vat_amount = $receiptLine->vat_amount;
                    $newReceiptLine->primary_vat_amount = $receiptLine->primary_vat_amount;

                    // GL ACCOUNT COMBINATION WILL SET WHEN SEND REQUEST
                    $newReceiptLine->code_combination_id = null;
                    $newReceiptLine->concatenated_segments = null;

                    $newReceiptLine->save();

                    // DUPLICATE RECEIPT LINE INFORMATIONS
                    $infos = SubCategoryInfo::where('sub_category_id',$newReceiptLine->sub_category_id)
                                ->active()
                                ->get();

                    if(count($infos)>0){

                        $subCategoryInfos = $receiptLine->infos->pluck('description','sub_category_info_id')->all();

                        foreach($infos as $info){
                            if(array_key_exists($info->id, $subCategoryInfos)){
                                $newReceiptLineInfo = new ReceiptLineInfo();
                                $newReceiptLineInfo->receipt_id = $newReceipt->id;
                                $newReceiptLineInfo->receipt_line_id = $newReceiptLine->id;
                                $newReceiptLineInfo->sub_category_id = $newReceiptLine->sub_category_id;
                                $newReceiptLineInfo->sub_category_info_id = $info->id;
                                $newReceiptLineInfo->description = $subCategoryInfos[$info->id];
                                $newReceiptLineInfo->save();
                            }
                        }
                    }

                }
            }

            // SUCCESS CREATE REIMBURSEMENT
            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                $result['reimId'] = $newReim->id;
                return $result;
            }else{
                return redirect()->route('ie.reimbursements.show',['reimId'=>$newReim->id]);
            }

        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                // throw new \Exception($e->getMessage(), 1);
                \Log::error($e->getMessage());
                return abort('403');
            }
        }
    }

    public function show($reimId)
    {
        // GET REIM DATA
        $reim = Reimbursement::find($reimId);
        if(!$reim){ abort(404); }
        if(!$reim->isRelatedUser()){ abort(404); }

        $reimTotalAmount = $reim->total_receipt_amount + 0;
        // GET ACTIVITY LOG
        $activityLogs = $reim->activityLogs;
        // GET PENDING TRASACTION
        $pendingRequestLists = RequestRepo::getPendingOverLimitDayRequest(\Auth::user()->id);

        // DATA FOR RECEIPT
        $receipts = $reim->receipts;
        $receiptParentId = $reimId;
        $categoryLists = Category::active()
                                // ->whereOrgId($this->orgId)
                                ->pluck('name','id')
                                ->all();
        $currencyLists = Currency::pluck('currency_code','currency_code')->all();
        $parentCurrencyId = $reim->currency_id;
        $receiptType = 'REIMBURSEMENT';
        $locations = Location::accessibleOrg($this->orgId)
                                ->active()->get();
        $locationLists = Location::accessibleOrg($this->orgId)
                                    ->active()->pluck('name','id')->all();
        // change in production when set location establishment
        $defaultEstablishmentId = $reim->user->employee->establishment_id;
        $establishmentLists = Establishment::whereOrgId($this->orgId)->pluck('establishment_name','establishment_id')->all();
        $vendorLists = Vendor::notEmp()->whereOrgId($this->orgId)->pluck('vendor_name','vendor_id')->all();
        $projectLists = FNDListOfValues::select(\DB::raw("CONCAT(description,' (',flex_value,')') AS full_description"),'flex_value')->project()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $rechargeLists = FNDListOfValues::select(\DB::raw("CONCAT(description,' (',flex_value,')') AS full_description"),'flex_value')->interCompany()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        $branchLists = FNDListOfValues::select(\DB::raw("CONCAT(description,' (',flex_value,')') AS full_description"),'flex_value')->branch($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("CONCAT(description,' (',flex_value,')') AS full_description"),'flex_value')->department($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        return view('ie.reimbursements.show',
                        compact('reim',
                                'reimTotalAmount',
                                'pendingRequestLists',
                                'activityLogs',
                                'receipts',
                                'receiptParentId',
                                'categoryLists',
                                'parentCurrencyId',
                                'currencyLists',
                                'receiptType',
                                'locations',
                                'locationLists',
                                'defaultEstablishmentId',
                                'establishmentLists',
                                'vendorLists',
                                'projectLists',
                                'rechargeLists',
                                'branchLists',
                                'departmentLists'
                                ));
    }

    public function setStatus(Request $request, $reimId)
    {
        $activity = $request->activity;
        $reason = '';
        if($request->reason){
            $reason = $request->reason;
        }
        // Get REIM Data
        $reim = Reimbursement::find($reimId);

        // FILE ATTACHMENTS
        if($request->file('file')){
            $attachmentRepo = new AttachmentRepo;
            $attachmentRepo->create($reim, $request->file('file'));
        }

        // Check Permission for Approve
        if(!self::hasPermissionSetStatus($reim,$activity)){  abort(403);  }

        \DB::beginTransaction();
        try {
            // Set STATUS (approve,reject,sendback)
            switch ($activity) {

                // #### REIM REQUEST ####
                case "UNBLOCK":
                    $reim->status = 'NEW_REQUEST';
                    $reim->save();
                    break;
                case "SEND_REQUEST":
                    // SET OVER BUDGET & EXCEED POLICY
                    $resultOverBudget = RequestRepo::validateIsNotOverBudget($reim);
                    $resultExceedPolicy = RequestRepo::validateIsNotExceedPolicy($reim);
                    $reim->over_budget = !$resultOverBudget['valid'];
                    $reim->exceed_policy = !$resultExceedPolicy['valid'];
                    $reim->save();
                    // CHECK FOUND APPROVER OR NOT ?
                    $nextApprover = ApprovalRepo::getNextApprover($reim,'REIMBURSEMENT');
                    if($nextApprover){ // IF FOUND NEXT APPROVER SET STATUS = 'APPROVER_DECISION'
                        $reim->status = 'APPROVER_DECISION';
                        $reim->next_approver_id = $nextApprover['user_id'];
                        $reim->save();
                    }else{ // IF NOT FOUND NEXT APPROVER AUTO SET STATUS TO
                        $reim->status = 'APPROVED';
                        $reim->next_approver_id = null;
                        $reim->save();
                        // INTERFACE TO ORACLE AP INVOICE
                        $interfaceResult = InterfaceRepo::invoice($reim,'REIMBURSEMENT');
                    }
                    break;
                case "APPROVER_APPROVE":
                    // DO APPROVE PROCESS
                    $approvalRepo = new ApprovalRepo;
                    $approvalRepo->approve($reim,'REIMBURSEMENT','APPROVER');
                    // CHECK FOUND NEXT APPROVER OR NOT ?
                    $nextApprover = ApprovalRepo::getNextApprover($reim,'REIMBURSEMENT');
                    if($nextApprover){ // IF FOUND NEXT APPROVER SET STATUS = 'APPROVER_DECISION'
                        $reim->next_approver_id = $nextApprover['user_id'];
                        $reim->save();
                    }else{ // IF NOT FOUND NEXT APPROVER SET STATUS = 'APPROVED'
                        $reim->status = 'APPROVED';
                        $reim->next_approver_id = null;
                        $reim->save();
                        // INTERFACE TO ORACLE AP INVOICE
                        $interfaceResult = InterfaceRepo::invoice($reim,'REIMBURSEMENT');
                    }
                    break;
                case "APPROVER_SENDBACK":
                    // SET STATUS BACK TO 'NEW_REQUEST'
                    $reim->status = 'NEW_REQUEST';
                    $reim->next_approver_id = null;
                    $reim->over_budget = null;
                    $reim->exceed_policy = null;
                    $reim->save();
                    break;
                case "APPROVER_REJECT":
                    $reim->status = 'APPROVER_REJECTED';
                    $reim->save();
                    break;
                case "CANCEL_REQUEST":
                    // SET STATUS TO 'CANCELLED'
                    $reim->status = 'CANCELLED';
                    $reim->save();
                    break;
            }

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($reim, ActivityLogRepo::getActivityMessage($activity,$reim),$reason);

            // RESET APPROVAL (ACTIVITY SENDBACK ONLY)
            self::resetApproval($activity,$reim);

            // SEND EMAIL
            self::sendEmailByActivity($activity,$reim,$reason);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());

            return redirect()->route('ie.reimbursements.show',['reimId'=>$reimId])->withErrors([$e->getMessage()]);;
        }
        \DB::commit();

        // REDIRECT AFTER SET STATUS
        return redirect()->route('ie.reimbursements.show',['reimId'=>$reimId]);

    }

    public function addAttachment(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);

        \DB::beginTransaction();
        try {

            if($request->file('file')){
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($reim, $request->file('file'));
            }

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->route('ie.reimbursements.show',['reimId'=>$reim->id]);
        // return redirect()->back();
    }

    //////////////////////////
    //// GET TOTAL AMOUNT
    public function getTotalAmount(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        if(!$reim){ throw new Exception("Error Processing Request", 1); }
        $reimTotalAmount = $reim->total_receipt_amount + 0;
        return number_format($reimTotalAmount,2);
    }

    //////////////////////////////////
    //// COMBINE GL CODE COMBINATION
    public function combineReceiptGLCodeCombination(Request $request, $reimId)
    {
        try {

            $reim = Reimbursement::find($reimId);
            if(!$reim){
                throw new \Exception("Not found reimbursement data.", 1);
            }
            $result = RequestRepo::combineReceiptGLCodeCombination($reim);

        } catch (\Exception $e) {
            if($request->ajax()){
                return \Response::json(['status'                =>  'error',
                                        'err_msg'               =>  $e->getMessage(),
                                        'err_receipt_line_id'   =>  null], 200);
            }else{
                throw new \Exception($e->getMessage(), 1);
            }
        }

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return redirect()->back();
        }
    }

    //////////////////////////
    //// CHECK OVER BUDGET
    public function checkOverBudget(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        if(!$reim){
            throw new \Exception("Not found reimbursement data.", 1);
        }
        $result = RequestRepo::validateIsNotOverBudget($reim);

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }

    //////////////////////////
    //// CHECK EXCEED POLICY
    public function checkExceedPolicy(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        if(!$reim){
            throw new \Exception("Not found reimbursement data.", 1);
        }
        $result = RequestRepo::validateIsNotExceedPolicy($reim);

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }

    //////////////////////////////
    //// validateReceipt
    public function validateReceipt(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        if(!$reim){
            throw new \Exception("Not found reimbursement data.", 1);
        }
        $result = RequestRepo::validateReceipt($reim);

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }

    public function formSendRequestWithReason(Request $request, $reimId)
    {
        $title = ''; $text = '';
        $reim = Reimbursement::find($reimId);
        if(!$reim){ return ; }

        $resultOverBudget = RequestRepo::validateIsNotOverBudget($reim);
        $resultExceedPolicy = RequestRepo::validateIsNotExceedPolicy($reim);
        $notOverBudget = $resultOverBudget['valid'];
        $notExceedPolicy = $resultExceedPolicy['valid'];
        if(!$notOverBudget && !$notExceedPolicy){
            $title = 'Request Over Budget & Exceed Policy !';
            $text = 'please enter reason for request over budget and exceed policy, please contact HR for approval and <strong><u>send the original receipt and supporting document to Accounting Dept. (กรุณาส่งเอกสารให้แผนกบัญชีเพื่อดำเนินการ)</u></strong>.';
        }elseif(!$notOverBudget){
            $title = 'Request Over Budget !';
            $text = 'please enter reason for request over budget, please contact HR for approval and <strong><u>send the original receipt and supporting document to Accounting Dept. (กรุณาส่งเอกสารให้แผนกบัญชีเพื่อดำเนินการ)</u></strong>.';
        }elseif(!$notExceedPolicy){
            $title = 'Request Exceed Policy !';
            $text = 'please enter reason for request exceed policy please contact HR for approval and <strong><u>send the original receipt and supporting document to Accounting Dept. (กรุณาส่งเอกสารให้แผนกบัญชีเพื่อดำเนินการ)</u></strong>.';
        }

        return view('ie.reimbursements.show._form_send_request_with_reason',
                        compact('reim','title','text'));

    }

    private static function hasPermissionSetStatus($reim,$activity)
    {
        $permit = false;
        switch ($activity) {
            case "UNBLOCK":
                if($reim->status == 'BLOCKED'
                    && \Auth::user()->isUnblocker()){
                    $permit = true;
                }
                break;
            case "SEND_REQUEST":
                if($reim->status == 'NEW_REQUEST'
                    && $reim->isRequester()){
                    $permit = true;
                }
                break;
            case "APPROVER_APPROVE":
                if($reim->status == 'APPROVER_DECISION'
                    && $reim->isNextApprover()){
                    $permit = true;
                }
                break;
            case "APPROVER_SENDBACK":
                if($reim->status == 'APPROVER_DECISION'
                    && $reim->isNextApprover()){
                    $permit = true;
                }
                break;
            case "APPROVER_REJECT":
                if($reim->status == 'APPROVER_DECISION'
                    && $reim->isNextApprover()){
                    $permit = true;
                }
                break;
            case "CANCEL_REQUEST":
                if(($reim->status == 'NEW_REQUEST' || $reim->status == 'BLOCKED')
                    && $reim->isRequester()){
                    $permit = true;
                }
                break;
        }
        return $permit;
    }

    private static function resetApproval($activity,$reim)
    {
        switch ($activity) {
            case "APPROVER_SENDBACK":
                // RESET RECENT APPROVAL PROCESS
                $approvalRepo = new ApprovalRepo;
                $approvalRepo->reset($reim,'REIMBURSEMENT');
                break;
        }
    }

    private static function sendEmailByActivity($activity,$reim,$reason)
    {
        $financeUsers = User::active()->isFinance()->get(); // FINANCE
        $composedFinanceUsers = MailRepo::composeReceivers($financeUsers);

        switch ($activity) {

            // #### REIM REQUEST ####
            case "UNBLOCK":

                $receivers = MailRepo::composeReceivers($reim->user); // REQUESTER
                $ccReceivers = MailRepo::composeReceivers($financeUsers); // FINANCE

                MailRepo::unblock('REIMBURSEMENT',$reim,$receivers,$ccReceivers,$reason);

                break;

            case "SEND_REQUEST":

                $ccReceivers = MailRepo::composeReceivers(\Auth::user()); // REQUESTER

                if($reim->approver){
                    // IF HAVE APPROVER
                    $receivers = MailRepo::composeReceivers($reim->approver); // NEXT APPROVER
                    if(count($composedFinanceUsers) > 0){
                        foreach ($composedFinanceUsers as $composedFinanceUser) {
                            array_push($ccReceivers, $composedFinanceUser);
                        }
                    }
                    MailRepo::sendRequest('REIMBURSEMENT',$reim,$receivers,$ccReceivers,$reason);
                }else{
                    // IF NOT HAVE APPROVER
                    $receivers = MailRepo::composeReceivers($financeUsers);
                    MailRepo::sendRequest('REIMBURSEMENT',$reim,$receivers,$ccReceivers,$reason,'TO-FINANCE-DEPT');
                }

                break;

            case "APPROVER_APPROVE":

                // IF FOUND NEXT APPROVER
                if($reim->next_approver_id){
                    $receivers = MailRepo::composeReceivers($reim->approver); // NEXT APPROVER
                    $ccReceivers = MailRepo::composeReceivers($reim->user); // REQUESTER
                    $relatedApprovers = ApprovalRepo::getRelatedApprovers($reim,'REIMBURSEMENT','APPROVER'); // RELATED APPROVERS
                    $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                    if(count($relatedApproverCCReceivers) > 0){
                        foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                            array_push($ccReceivers, $relatedApproverCCReceiver);
                        }
                    }
                // IF APPROVER APPROVE COMPLETED
                }else{
                    $receivers = MailRepo::composeReceivers($reim->user); // REQUESTER;
                    $relatedApprovers = ApprovalRepo::getRelatedApprovers($reim,'REIMBURSEMENT','APPROVER'); // RELATED APPROVERS
                    $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                }
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('REIMBURSEMENT',$reim,'APPROVE',$receivers,$ccReceivers,$reason);

                break;

            case "APPROVER_SENDBACK":

                $receivers = MailRepo::composeReceivers($reim->user); // REQUESTER;
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($reim,'REIMBURSEMENT','APPROVER'); // RELATED APPROVERS
                $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('REIMBURSEMENT',$reim,'SENDBACK',$receivers,$ccReceivers,$reason);

                break;

            case "APPROVER_REJECT":

                $receivers = MailRepo::composeReceivers($reim->user); // REQUESTER;
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($reim,'REIMBURSEMENT','APPROVER'); // RELATED APPROVERS
                $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('REIMBURSEMENT',$reim,'REJECT',$receivers,$ccReceivers,$reason);

                break;

        }

    }

    public function export(Request $request)
    {
        $yearShowing = $request->year_showing;
        $search = [
            'document_no'=>$request->document_no,
            'status'=>$request->status
        ];
        $search_date = [
            'date_from'=>$request->date_from,
            'date_to'=>$request->date_to
        ];
        $reims = Reimbursement::orderBy('created_at','desc')
                        ->whereOrgId($this->orgId)
                        ->byRelatedUser()
                        ->byYearShowing($yearShowing)
                        ->with('user')
                        ->search($search,$search_date)
                        ->get();
        // if(!$reims){ abort(403); }

        $establishmentLists = Establishment::whereOrgId($this->orgId)->pluck('establishment_name','establishment_id')->all();
        $vendorLists = Vendor::notEmp()->whereOrgId($this->orgId)->pluck('vendor_name','vendor_id')->all();
        // $projectLists = FNDListOfValues::select(\DB::raw("description || ' (' || flex_value || ')' AS full_description"),'flex_value')->project()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        // $rechargeLists = FNDListOfValues::select(\DB::raw("description || ' (' || flex_value || ')' AS full_description"),'flex_value')->interCompany()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        $branchLists = FNDListOfValues::select(\DB::raw("description || ' (' || flex_value || ')' AS full_description"),'flex_value')->branch($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("description || ' (' || flex_value || ')' AS full_description"),'flex_value')->department($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();


        \Excel::create('RE_'.Carbon::now(), function($excel) use ($reims,$establishmentLists,$vendorLists,$branchLists,$departmentLists) {

            $excel->sheet('Report', function($sheet) use ($reims,$establishmentLists,$vendorLists,$branchLists,$departmentLists) {

                $sheet->loadView('ie.reimbursements.export._template', compact('reims','establishmentLists','vendorLists','projectLists','rechargeLists','branchLists','departmentLists'));

            });

        })->export('xlsx');
    }
}
