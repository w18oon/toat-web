<?php

namespace App\Repositories\IE;

// use App\InterfaceAP;
use App\InterfaceAPHeader;
use App\InterfaceAPLine;

use App\GLCodeCombination;
use App\AccountInfo;
use App\Currency;
use App\VAT;
use App\User;
use App\Vendor;
use App\CACategory;
use App\SubCategory;
use App\InterfaceAP;

use App\GLPeriodStatus;
use App\APInvoice;

class InterfaceRepo
{
    // PRE-PAYMENT
	public static function prePayment($parent,$processType)
    {
        \DB::beginTransaction();
        try {

            // CASH-ADVANCE (PRE-PAYMENT)

            $now = date('Y-m-d');

        	// INSERT HEAD
            $interfaceHeader = new InterfaceAPHeader();
            $interfaceHeader->invoice_number = $parent->document_no;
            $interfaceHeader->apply_invoice_number = null;
            $interfaceHeader->request_type = $processType;
            $interfaceHeader->request_id = $parent->id;
            $interfaceHeader->org_id = $parent->org_id;
            $interfaceHeader->description = $parent->purpose;
            $interfaceHeader->due_date = $parent->due_date;
            $interfaceHeader->invoice_date = $now;
            $interfaceHeader->gl_date = $now;
            $interfaceHeader->vendor_id = $parent->user->employee->vendor_id;
            $interfaceHeader->vendor_site_id = $parent->user->employee->vendor_site_id;
            $interfaceHeader->currency = $parent->currency_id;
            $interfaceHeader->invoice_type = 'INV';
            $interfaceHeader->payment_method_code = $parent->payment_method_id;
            $interfaceHeader->term_id = $parent->user->employee->terms_id;
            $interfaceHeader->invoice_amount = $parent->amount;
            $interfaceHeader->accts_pay_code_combination_id = $parent->user->employee->accts_pay_code_combination_id;

            $interfaceHeader->tax_flag = 'N';
            $interfaceHeader->interface_status = 'P';
            $interfaceHeader->interface_message = null;

            // VALIDATE BEFORE INSERT TO INTERFACE TABLE
            self::validatePeriodIsOpen($interfaceHeader->org_id, $now);
            self::validateDuplicateInvoiceNumber($interfaceHeader->org_id, $interfaceHeader->invoice_number);

            $interfaceHeader->save();

            // INSERT LINE
            $interfaceLine = new InterfaceAPLine();
            $interfaceLine->interface_ap_header_id = $interfaceHeader->id;
            $interfaceLine->request_receipt_id = null;
            $interfaceLine->request_receipt_line_id = null;
            $interfaceLine->org_id = $parent->org_id;
            $interfaceLine->line_group_number = null;
            $interfaceLine->line_number = '1';
            // receipt_number | sub_category_name | justification
            $lineDescription = self::concatLineDescription(null,$parent->subCategory->name,null);
            $interfaceLine->description = $lineDescription;
            // PRE-PAYMENT COMBINE GL ACCOUNT WHEN INTERFACE
            $lineSegmants = self::composeGLCodeCombinationSegments($parent->subCategory->branch_code,$parent->subCategory->department_code,$parent->subCategory->account_code,$parent->subCategory->sub_account_code,null,null);
            $glCodeCombination = self::getGLCodeCombinationOfEmpBySegments($parent->user->employee,$lineSegmants);
            $concatenatedSegments = $glCodeCombination['concatenated_segments'];
            $lineDistAcctId = $glCodeCombination['code_combination_id'];
            $interfaceLine->concatenated_segments = $concatenatedSegments;
            $interfaceLine->dist_acct_id = $lineDistAcctId;
            $interfaceLine->invoice_number = $interfaceHeader->invoice_number;
            $interfaceLine->accounting_date = $now;
            $interfaceLine->quantity_invoiced = 1;
            $interfaceLine->unit_price = $parent->amount;
            $interfaceLine->line_amt = $parent->amount;
            $interfaceLine->inventory_item_id = null;
            $interfaceLine->unit_of_meas_lookup_code = null;
            $interfaceLine->wht_amt = null;
            $interfaceLine->pay_awt_group_id = null;
            $interfaceLine->tax_amt = null;
            $interfaceLine->tax_rate_code = null;
            $interfaceLine->tax_classification_code = null;
            $interfaceLine->tax_regime_code = null;
            $interfaceLine->tax = null;
            $interfaceLine->tax_status_code = null;
            $interfaceLine->actual_vendor_name = null;
            $interfaceLine->actual_vendor_tax_id = null;
            $interfaceLine->actual_vendor_branch_name = null;
            $interfaceLine->establishment_id = null;
            $interfaceLine->establishment_name = null;

            $interfaceLine->interface_status = 'P';
            $interfaceLine->interface_message = null;
            $interfaceLine->save();

        } catch (\Exception $e) {
            \DB::rollBack();
        	throw new \Exception($e->getMessage(), 1);
        }
        \DB::commit();

    }

    // INTERFACE INVOICE & APPLY PRE-PAYMENT
    public static function invoice($parent,$processType)
    {
    	// processType = 'REIMBURSEMENT' (INVOICE) || 'CLEARING' (APPLY PRE-PAYMENT)
        \DB::beginTransaction();
        try {

            $now = date('Y-m-d');

        	// INSERT HEAD
        	$interfaceHeader = new InterfaceAPHeader();
            if($processType == 'REIMBURSEMENT' || $processType == 'INVOICE'){
                // INVOICE
                $interfaceHeader->invoice_number = $parent->document_no;
                $interfaceHeader->apply_invoice_number = null;
            }elseif($processType == 'CLEARING'){
                // APPLY PRE-PAYMENT
                // CHECK CASH ADVANCE STATUS BEFORE CLEARING
                // $cashAdvanceInvoiceStatus = InterfaceAP::getInvoiceApprovalStatus($parent->org_id,$parent->document_no);
                // if(!$cashAdvanceInvoiceStatus){
                //     throw new \Exception("Error : Not found cash advance # \"".$parent->document_no."\" in oracle erp system, please contact administrator to resolve this issue.", 1);
                // }else{
                //     if(strtoupper($cashAdvanceInvoiceStatus[0]->status) != 'AVAILABLE'){
                //         throw new \Exception("Error : Cash advance # \"".$parent->document_no."\" invoice status is not available (now = ".$cashAdvanceInvoiceStatus[0]->status." ), please contact administrator to resolve this issue.", 1);
                //     }
                // }
                $interfaceHeader->invoice_number = $parent->clearing_document_no;
                $interfaceHeader->apply_invoice_number = $parent->document_no;
            }
        	$interfaceHeader->request_type = $processType;
			$interfaceHeader->request_id = $parent->id;
			$interfaceHeader->org_id = $parent->org_id;
            $interfaceHeader->description = $parent->purpose;
            $interfaceHeader->due_date = null;
			$interfaceHeader->invoice_date = $now;
			$interfaceHeader->gl_date = $now;
			$interfaceHeader->vendor_id = $parent->user->employee->vendor_id;
			$interfaceHeader->vendor_site_id = $parent->user->employee->vendor_site_id;
			$interfaceHeader->currency = $parent->currency_id;
			$interfaceHeader->invoice_type = 'INV';
            $interfaceHeader->payment_method_code = $parent->user->employee->payment_method_code;
			$interfaceHeader->term_id = $parent->user->employee->terms_id;
			$interfaceHeader->invoice_amount = $parent->total_receipt_amount;
            $interfaceHeader->accts_pay_code_combination_id = $parent->user->employee->accts_pay_code_combination_id;
            $interfaceHeader->tax_flag = 'N';
			$interfaceHeader->interface_status = 'P';
            $interfaceHeader->interface_message = null;

            // VALIDATE BEFORE INSERT TO INTERFACE TABLE
            self::validatePeriodIsOpen($interfaceHeader->org_id, $now);
            self::validateDuplicateInvoiceNumber($interfaceHeader->org_id, $interfaceHeader->invoice_number);

			$interfaceHeader->save();

			// INSERT LINES
			if( count($parent->receipts) > 0 ){
                $taxFlag = 'N';
				$interfaceLineNumber = 0;

				foreach ($parent->receipts as $key => $receipt) {

					if( count($receipt->lines) > 0) {

						foreach ($receipt->lines as $key => $line) {
							$interfaceLineNumber++;

                            $lineSubCategory = SubCategory::find($line->sub_category_id);

							$interfaceLine = new InterfaceAPLine();
                            $interfaceLine->interface_ap_header_id = $interfaceHeader->id;
                            $interfaceLine->request_receipt_id = $receipt->id;
                            $interfaceLine->request_receipt_line_id = $line->id;
                            $interfaceLine->org_id = $parent->org_id;
                            $interfaceLine->line_group_number = null;
                            $interfaceLine->line_number = $interfaceLineNumber;
                            // RECEIPT_NUMBER | SUB_CATEGORY_NAME | JUSTIFICATION
                            $lineDescription = self::concatLineDescription($receipt->receipt_number,$lineSubCategory->name,$receipt->description);
                            $interfaceLine->description = $lineDescription;
                            // INVOICE & APPLY PRE-PAYMENT COMBINE GL ACCOUNT WHEN SEND REQUEST
                            $interfaceLine->concatenated_segments = $line->concatenated_segments;
                            $interfaceLine->dist_acct_id = $line->code_combination_id;
                            $interfaceLine->invoice_number = $interfaceHeader->invoice_number;
                            $interfaceLine->accounting_date = $now;
                            $interfaceLine->quantity_invoiced = 1;
                            $totalPrimaryAmount = (float)$line->total_primary_amount_inc_vat - (float)$line->primary_vat_amount;
                            $interfaceLine->unit_price = $totalPrimaryAmount;
                            $interfaceLine->line_amt = $totalPrimaryAmount;
                            $interfaceLine->inventory_item_id = null;
                            $interfaceLine->unit_of_meas_lookup_code = null;
                            $interfaceLine->wht_amt = null;
                            $interfaceLine->pay_awt_group_id = $line->pay_awt_group_id;
                            $interfaceLine->tax_amt = $line->primary_vat_amount;
                            $interfaceLine->tax_rate_code = $line->vat_id;
                            $interfaceLine->tax_classification_code = $line->vat_id;

                            if($line->vat_id){
                                $taxFlag = 'Y';
                                $taxVAT = VAT::where('tax_rate_code',$line->vat_id)->whereOrgId($parent->org_id)->first();
                                $interfaceLine->tax_regime_code = $taxVAT->tax_regime_code;
                                $interfaceLine->tax = $taxVAT->tax;
                                $interfaceLine->tax_status_code = $taxVAT->tax_status_code;
                            }

                            if($receipt->vendor_id){
                                if($receipt->vendor_id == 'other'){
                                    $interfaceLine->actual_vendor_name = $receipt->vendor_name;
                                    $interfaceLine->actual_vendor_tax_id = $receipt->vendor_tax_id;
                                    $interfaceLine->actual_vendor_branch_name = $receipt->vendor_branch_name;
                                }else{
                                    $vendor = Vendor::whereOrgId($parent->org_id)->where('vendor_id',$receipt->vendor_id)->first();
                                    if($vendor){
                                        $interfaceLine->actual_vendor_name = $vendor->vendor_name;
                                        $interfaceLine->actual_vendor_tax_id = $vendor->tax_id;
                                        $interfaceLine->actual_vendor_branch_name = $vendor->branch_number;
                                    }
                                }
                            }

                            $interfaceLine->establishment_id = $receipt->establishment_id;
                            $interfaceLine->establishment_name = $receipt->establishment_name;

                            $interfaceLine->interface_status = 'P';
                            $interfaceLine->interface_message = null;
                            $interfaceLine->save();
						}
					}
				}

                ////////////////////////////////////////////////////////////////////////////
                // IF CASH ADVANCE > CLEARING => AUTO ADD AP INF LINE FOR DIFFERENCE AMOUNT
                if($processType == 'CLEARING'){

                    $cashAdvanceAmount = $parent->amount;
                    $clearingAmount = $parent->total_receipt_amount;

                    if((float)$cashAdvanceAmount > (float)$clearingAmount){

                        // UPDATE INVOICE AMOUT EQUAL TO CASH ADVANCE AMOUNT (APPLY FULL)
                        $interfaceHeader->invoice_amount = (float)$cashAdvanceAmount;
                        $interfaceHeader->save();

                        $subCategoryAdvanceOver = SubCategory::advanceOver()->first();

                        $diffAmount = (float)$cashAdvanceAmount - (float)$clearingAmount;

                        $interfaceLineNumber++;

                        $interfaceLine = new InterfaceAPLine();
                        $interfaceLine->interface_ap_header_id = $interfaceHeader->id;
                        $interfaceLine->request_receipt_id = null;
                        $interfaceLine->request_receipt_line_id = null;
                        $interfaceLine->org_id = $parent->org_id;
                        $interfaceLine->line_group_number = null;
                        $interfaceLine->line_number = $interfaceLineNumber;

                        // SUB_CATEGORY_NAME
                        $interfaceLine->description = $subCategoryAdvanceOver->name;

                        // INVOICE & APPLY PRE-PAYMENT COMBINE GL ACCOUNT WHEN SEND REQUEST
                        $lineSegmants = self::composeGLCodeCombinationSegments($subCategoryAdvanceOver->branch_code,$subCategoryAdvanceOver->department_code,$subCategoryAdvanceOver->account_code,$subCategoryAdvanceOver->sub_account_code,null,null);
                        $glCodeCombination = self::getGLCodeCombinationOfEmpBySegments($parent->user->employee,$lineSegmants);
                        $concatenatedSegments = $glCodeCombination['concatenated_segments'];
                        $lineDistAcctId = $glCodeCombination['code_combination_id'];
                        $interfaceLine->concatenated_segments = $concatenatedSegments;
                        $interfaceLine->dist_acct_id = $lineDistAcctId;

                        $interfaceLine->invoice_number = $interfaceHeader->invoice_number;
                        $interfaceLine->accounting_date = $now;
                        $interfaceLine->quantity_invoiced = 1;

                        $interfaceLine->unit_price = $diffAmount;
                        $interfaceLine->line_amt = $diffAmount;

                        $interfaceLine->inventory_item_id = null;
                        $interfaceLine->unit_of_meas_lookup_code = null;
                        $interfaceLine->wht_amt = null;
                        $interfaceLine->pay_awt_group_id = null;
                        $interfaceLine->tax_amt = null;
                        $interfaceLine->tax_rate_code = null;
                        $interfaceLine->tax_classification_code = null;
                        $interfaceLine->tax_regime_code = null;
                        $interfaceLine->tax = null;
                        $interfaceLine->tax_status_code = null;

                        $interfaceLine->actual_vendor_name = null;
                        $interfaceLine->actual_vendor_tax_id = null;
                        $interfaceLine->actual_vendor_branch_name = null;

                        $interfaceLine->establishment_id = null;
                        $interfaceLine->establishment_name = null;

                        $interfaceLine->interface_status = 'P';
                        $interfaceLine->interface_message = null;
                        $interfaceLine->save();

                    }
                }
			}
            // UPDATE HEAD TAX FLAG
            $interfaceHeader->tax_flag = $taxFlag;
            $interfaceHeader->save();

        } catch (\Exception $e) {
            \DB::rollBack();
        	throw new \Exception($e->getMessage(), 1);
        }
        \DB::commit();

    }

    private static function concatLineDescription($receiptNumber,$categoryName,$description)
    {
        $arrConcat = [];
        $concatenatedDescription = '';
        if($receiptNumber){
            array_push($arrConcat, $receiptNumber);
        }
        if($categoryName){
            array_push($arrConcat, $categoryName);
        }
        if($description){
            array_push($arrConcat, $description);
        }
        if( count($arrConcat) > 0 ){
            $concatenatedDescription = implode(" | ",$arrConcat);
        }

        return $concatenatedDescription;
    }

    public static function composeGLCodeCombinationSegments($branch,$department,$accountCode,$subAccountCode,$project,$interCompany)
    {
        $codeCombinationId = null;
        $segments = [];

        // SEGMENT1
        $segments[1] = null;
        // SEGMENT2
        $segments[2] = null;
        if($branch){
            $segments[2] = $branch;
        }
        // SEGMENT3
        $segments[3] = null;
        if($department){
            $segments[3] = $department;
        }
        // SEGMENT4
        $segments[4] = null;
        // SEGMENT5
        $segments[5] = null;

        // SEGMENT6
        $segments[6] = null;
        if($accountCode){
            $segments[6] = $accountCode;
        }

        // SEGMENT7
        $segments[7] = null;
        if($subAccountCode){
            $segments[7] = $subAccountCode;
        }

        // SEGMENT8
        $segments[8] = null;
        if($project){
            $segments[8] = $project;
        }

        // SEGMENT9
        $segments[9] = null;
        if($interCompany){
            $segments[9] = $interCompany;
        }

        // SEGMENT10
        $segments[10] = null;
        // SEGMENT11
        $segments[11] = null;
        // SEGMENT12
        $segments[12] = null;

        return $segments;

    }

    public static function getGLCodeCombinationOfEmpBySegments($employee,$segments)
    {
    	// DEFAULT CONCATENATED SEGMENTS
    	$concatenatedSegments = $employee->concatenated_segments;

        $result = ['concatenated_segments'  =>  '',
                   'code_combination_id'    =>  ''];

    	if(count($segments) == 12) {
    		if(!$segments[1]){
    			$segments[1] = $employee->segment1;
    		}
    		if(!$segments[2]){
    			$segments[2] = $employee->segment2;
    		}
    		if(!$segments[3]){
    			$segments[3] = $employee->segment3;
    		}
    		if(!$segments[4]){
    			$segments[4] = $employee->segment4;
    		}
    		if(!$segments[5]){
    			$segments[5] = $employee->segment5;
    		}
    		if(!$segments[6]){
    			$segments[6] = $employee->segment6;
    		}
    		if(!$segments[7]){
    			$segments[7] = $employee->segment7;
    		}
    		if(!$segments[8]){
    			$segments[8] = $employee->segment8;
    		}
    		if(!$segments[9]){
    			$segments[9] = $employee->segment9;
    		}
    		if(!$segments[10]){
    			$segments[10] = $employee->segment10;
    		}
    		if(!$segments[11]){
    			$segments[11] = $employee->segment11;
    		}
    		if(!$segments[12]){
    			$segments[12] = $employee->segment12;
    		}

            // CONCAT SEGMENTS
    		$concatenatedSegments = $segments[1].'.'.$segments[2].'.'.$segments[3].'.'.$segments[4].'.'.$segments[5].'.'.$segments[6].'.'.$segments[7].'.'.$segments[8].'.'.$segments[9].'.'.$segments[10].'.'.$segments[11].'.'.$segments[12];


            // THIS ACCOUNT SEGMENT ALREADY COMBINED IN ORACLE ERP ?
        	// $glCodeCombination = GLCodeCombination::select('code_combination_id')->where('chart_of_accounts_id',$employee->chart_of_accounts_id)->where('concatenated_segments',$concatenatedSegments)->first();

            $glCodeCombination = GLCodeCombination::select('code_combination_id')->first();

            // dd($concatenatedSegments);

            // IF NOT ALREADY COMBINED
        	// if(!$glCodeCombination){

         //        // CHECK GL VALIDATION RULE
         //        $dataGLValid = self::composeDataForCheckGLValidationRule($employee->org_id,$concatenatedSegments,$segments);
         //        $resultGLValid = GLCodeCombination::callCheckGLValidationRule($dataGLValid);

         //        // IF INVALID GL VALIDATION RULE
         //        if($resultGLValid['status'] == 'E'){

         //            throw new \Exception("Error : ".$resultGLValid['err_msg'].", please contact administrator to resolve this issue.", 1);

         //        // IF PASSED GL VALIDATION RULE
         //        }elseif($resultGLValid['status'] == 'S'){

         //            // CALL PACKAGE AUTO-COMBINE
         //            $CCID = GLCodeCombination::autoCombine($concatenatedSegments,$employee->org_id);

         //            // QUERY GET DATA AFTER AUTO-COMBINE
         //            $glCodeCombination = GLCodeCombination::select('code_combination_id')->where('chart_of_accounts_id',$employee->chart_of_accounts_id)->where('concatenated_segments',$concatenatedSegments)->first();

         //            if($glCodeCombination){
         //                $codeCombinationId = $glCodeCombination->code_combination_id;
         //                $result = [ 'concatenated_segments'  =>  $concatenatedSegments,
         //                        'code_combination_id'    =>  $codeCombinationId];
         //            }else{
         //                throw new \Exception("Error : Can not auto combine general ledger account, please contact administrator to resolve this issue.", 1);
         //            }
         //        }

        	// }else{

            $codeCombinationId = $glCodeCombination->code_combination_id;
            $result = [ 'concatenated_segments'  =>  $concatenatedSegments,
                        'code_combination_id'    =>  $codeCombinationId];

            // }
        }

    	return $result;
    }

    private static function composeDataForCheckGLValidationRule($orgId,$concatenatedSegments,$segments)
    {
        $data = ['org_id'               =>  $orgId,
                'concatenated_segments' =>  $concatenatedSegments,
                'segment1'              =>  $segments[1],
                'segment2'              =>  $segments[2],
                'segment3'              =>  $segments[3],
                'segment4'              =>  $segments[4],
                'segment5'              =>  $segments[5],
                'segment6'              =>  $segments[6],
                'segment7'              =>  $segments[7],
                'segment8'              =>  $segments[8],
                'segment9'              =>  $segments[9],
                'segment10'             =>  $segments[10],
                'segment11'             =>  $segments[11],
                'segment12'             =>  $segments[12]];

        return $data;
    }

    public static function validatePeriodIsOpen($orgId, $date)
    {
        // $GLPeriodOpened = GLPeriodStatus::getGLPeriodStatusOpenByDate($orgId,date('Y-m-d'));
        // $APPeriodOpened = GLPeriodStatus::getAPPeriodStatusOpenByDate($orgId,date('Y-m-d'));

        $GLPeriodOpened = GLPeriodStatus::getGLPeriodStatusOpenByDate($orgId,date("Y-m-d", strtotime("+1 month", strtotime(date('Y-m-d')))));
        $APPeriodOpened = GLPeriodStatus::getAPPeriodStatusOpenByDate($orgId,date("Y-m-d", strtotime("+1 month", strtotime(date('Y-m-d')))));

        if(!$GLPeriodOpened && !$APPeriodOpened){
            throw new \Exception('GL & AP Period Status Is Closing, please contact administrator to solve this issue.', 1);
        }else if(!$GLPeriodOpened){
            throw new \Exception('GL Period Status Is Closing, please contact administrator to solve this issue.', 1);
        }else if(!$APPeriodOpened){
            throw new \Exception('AP Period Status Is Closing, please contact administrator to solve this issue.', 1);
        }
    }

    public static function validateDuplicateInvoiceNumber($orgId, $invoiceNumber)
    {
        // $apInvoice = APInvoice::where('invoice_num',$invoiceNumber)
        //                     ->where('org_id',$orgId)
        //                     ->first();
        // if($apInvoice){
        //     throw new \Exception('Invoice # '.$invoiceNumber.' : is already used, please contact administrator to solve this issue.', 1);
        // }
    }
}