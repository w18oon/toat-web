<?php

namespace App\Repositories\IE;

use App\Repositories\ApprovalRepo;

use App\CashAdvance;
use App\Reimbursement;
use Mail;
use Validator;

class MailRepo
{
    // ####################
    // ### Request Type ###
    // CASH-ADVANCE
    // CLEARING
    // REIMBURSEMENT
    // INVOICE
    // ####################

    public static function sendRequest($requestType,$request,$receivers,$ccReceivers,$reason = null,$toFinanceDept = null)
    {
        if(count($receivers) > 0){
            $data = self::templateSendRequest($requestType,$request,$receivers,$reason,$toFinanceDept);
            Mail::queue($data['view'], $data, function($message) use ($receivers,$ccReceivers,$data) {
                foreach($receivers as $receiver){
                    if($receiver['email']){
                        $message->to($receiver['email'],$receiver['name'])->subject($data['subject']);
                    }
                }
                foreach($ccReceivers as $ccReceiver){
                    $message->cc($ccReceiver['email']);
                }
            });
        }
    }

    public static function approverProcess($requestType,$request,$actionType,$receivers,$ccReceivers,$reason = null,$toFinanceDept = null)
    {
        if(count($receivers) > 0){
            $data = self::templateApproverProcess($requestType,$request,$actionType,$receivers,$reason,$toFinanceDept);
            Mail::queue($data['view'], $data, function($message) use ($receivers,$ccReceivers,$data) {
                foreach($receivers as $receiver){
                    if($receiver['email']){
                        $message->to($receiver['email'],$receiver['name'])->subject($data['subject']);
                    }
                }
                foreach($ccReceivers as $ccReceiver){
                    $message->cc($ccReceiver['email']);
                }
            });
        }
    }

    public static function financeProcess($requestType,$request,$actionType,$receivers,$ccReceivers,$reason = null)
    {
        if(count($receivers) > 0){
            $data = self::templateFinanceProcess($requestType,$request,$actionType,$receivers,$reason);
            Mail::queue($data['view'], $data, function($message) use ($receivers,$ccReceivers,$data) {
                foreach($receivers as $receiver){
                    if($receiver['email']){
                        $message->to($receiver['email'],$receiver['name'])->subject($data['subject']);
                    }
                }
                foreach($ccReceivers as $ccReceiver){
                    $message->cc($ccReceiver['email']);
                }
            });
        }
    }

    public static function unblock($requestType,$request,$receivers,$ccReceivers,$reason)
    {
        if(count($receivers) > 0){
            $data = self::templateUnblock($requestType,$request,$receivers,$reason);
            Mail::queue($data['view'], $data, function($message) use ($receivers,$ccReceivers,$data) {
                foreach($receivers as $receiver){
                    if($receiver['email']){
                        $message->to($receiver['email'],$receiver['name'])->subject($data['subject']);
                    }
                }
                foreach($ccReceivers as $ccReceiver){
                    $message->cc($ccReceiver['email']);
                }
            });
        }
    }

    private static function templateSendRequest($requestType,$request,$receivers,$reason,$toFinanceDept)
    {

        $additionDesc = self::getAdditionDesc($request);
        $receiverNames = '';
        if($toFinanceDept){
            $receiverNames = 'Finance Dept.';
        }else{
            $receiverNames = $receivers ? implode(', ', array_map(function($receiver){
                                                  return $receiver['name'];
                                                }, $receivers)) : '';
        }
        $emailDescription = '';

        // CASH-ADVANCE SEND REQUEST
        if($requestType == 'CASH-ADVANCE'){

            if($toFinanceDept){
                $emailDescription = $request->user->name.' send cash advance request'. ($additionDesc ? ' but'.$additionDesc : '') .'.';
            }else{
                $emailDescription = $request->user->name.' send cash advance request to you for approval'. ($additionDesc ? ' but'.$additionDesc : '') .'.';
            }

            $data = [
                'view'          =>  'emails.template_with_reason',
                'subject'       =>  '[CASH ADVANCE]['.$request->document_no.'] Send Request',
                'title'         =>  'CASH-ADVANCE #'.$request->document_no.' REQUEST WAS SENT.',
                'description'   =>  $emailDescription,
                'reason'        =>  $reason,
                'requestId'     =>  $request->id,
                'receiverNames' =>  $receiverNames
            ];
        }

        // CLEARING SEND REQUEST
        if($requestType == 'CLEARING'){

            if($toFinanceDept){
                $emailDescription = $request->user->name.' send clearing cash advance request'. ($additionDesc ? ' but'.$additionDesc : '') .'.';
            }else{
                $emailDescription = $request->user->name.' send clearing cash advance request to you for approval'. ($additionDesc ? ' but'.$additionDesc : '') .'.';
            }

            $data = [
                'view'          =>  'emails.template_with_reason',
                'subject'       =>  '[CLEARING]['.$request->clearing_document_no.'] Send Request',
                'title'         =>  'CLEARING #'.$request->clearing_document_no.' REQUEST WAS SENT.',
                'description'   =>  $emailDescription,
                'reason'        =>  $reason,
                'requestId'     =>  $request->id,
                'receiverNames' =>  $receiverNames
            ];
        }

        // REIMBURSEMENT SEND REQUEST
        if($requestType == 'REIMBURSEMENT'){

            if($toFinanceDept){
                $emailDescription = $request->user->name.' send reimbursement request'. ($additionDesc ? ' but'.$additionDesc : '') .'.';
            }else{
                $emailDescription = $request->user->name.' send reimbursement request to you for approval'. ($additionDesc ? ' but'.$additionDesc : '') .'.';
            }

            $data = [
                'view'          =>  'emails.template_with_reason',
                'subject'       =>  '[REIMBURSEMENT]['.$request->document_no.'] Send Request',
                'title'         =>  'REIMBURSEMENT #'.$request->document_no.' REQUEST WAS SENT.',
                'description'   =>  $emailDescription,
                'reason'        =>  $reason,
                'requestId'     =>  $request->id,
                'receiverNames' =>  $receiverNames
            ];
        }

        // INVOICE SEND REQUEST
        if($requestType == 'INVOICE'){

            if($toFinanceDept){
                $emailDescription = $request->user->name.' send invoice request'. ($additionDesc ? ' but'.$additionDesc : '') .'.';
            }else{
                $emailDescription = $request->user->name.' send invoice request to you for approval'. ($additionDesc ? ' but'.$additionDesc : '') .'.';
            }

            $data = [
                'view'          =>  'emails.template_with_reason',
                'subject'       =>  '[INVOICE]['.$request->document_no.'] Send Request',
                'title'         =>  'INVOICE #'.$request->document_no.' REQUEST WAS SENT.',
                'description'   =>  $emailDescription,
                'reason'        =>  $reason,
                'requestId'     =>  $request->id,
                'receiverNames' =>  $receiverNames
            ];
        }

        return $data;
    }

    private static function templateApproverProcess($requestType,$request,$actionType,$receivers,$reason,$toFinanceDept)
    {
        $receiverNames = '';
        if($toFinanceDept){
            $receiverNames = 'Finance Dept.';
        }else{
            $receiverNames = $receivers ? implode(', ', array_map(function($receiver){
                                                  return $receiver['name'];
                                                }, $receivers)) : '';
        }

        // CASH-ADVANCE APPROVER PROCESS
        if($requestType == 'CASH-ADVANCE'){
            // APPROVER APPROVE
            if($actionType =='APPROVE'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CASH ADVANCE]['.$request->document_no.'] Approved',
                    'title'         =>  'CASH-ADVANCE #'.$request->document_no.' REQUEST WAS APPROVED.',
                    'description'   =>  \Auth::user()->name.' approved cash advance request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
            // APPROVER SENDBACK
            if($actionType =='SENDBACK'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CASH ADVANCE]['.$request->document_no.'] Sent back',
                    'title'         =>  'CASH-ADVANCE #'.$request->document_no.' REQUEST WAS SENT BACK.',
                    'description'   =>  \Auth::user()->name.' sent back cash advance request to requester for edit.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
            // APPROVER REJECT
            if($actionType =='REJECT'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CASH ADVANCE]['.$request->document_no.'] Rejected',
                    'title'         =>  'CASH-ADVANCE #'.$request->document_no.' REQUEST WAS REJECTED.',
                    'description'   =>  \Auth::user()->name.' rejected cash advance request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
        }

        // CLEARING APPROVER PROCESS
        if($requestType == 'CLEARING'){

            $additionDesc = self::getAdditionDesc($request);

            // APPROVER APPROVE
            if($actionType =='APPROVE'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CLEARING]['.$request->clearing_document_no.'] Approved',
                    'title'         =>  'CLEARING #'.$request->clearing_document_no.' REQUEST WAS APPROVED.',
                    'description'   =>  \Auth::user()->name.' approved clearing cash advance'.$additionDesc.' request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
            // APPROVER SENDBACK
            if($actionType =='SENDBACK'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CLEARING]['.$request->clearing_document_no.'] Sent back',
                    'title'         =>  'CLEARING #'.$request->clearing_document_no.' REQUEST WAS SENT BACK.',
                    'description'   =>  \Auth::user()->name.' sent back cash clearing advance'.$additionDesc.' request to requester for edit.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
        }

        // REIMBURSEMENT APPROVER PROCESS
        if($requestType == 'REIMBURSEMENT'){

            $additionDesc = self::getAdditionDesc($request);

            // APPROVER APPROVE
            if($actionType =='APPROVE'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[REIMBURSEMENT]['.$request->document_no.'] Approved',
                    'title'         =>  'REIMBURSEMENT #'.$request->document_no.' REQUEST WAS APPROVED.',
                    'description'   =>  \Auth::user()->name.' approved reimbursement'.$additionDesc.' request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
            // APPROVER SENDBACK
            if($actionType =='SENDBACK'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[REIMBURSEMENT]['.$request->document_no.'] Sent back',
                    'title'         =>  'REIMBURSEMENT #'.$request->document_no.' REQUEST WAS SENT BACK.',
                    'description'   =>  \Auth::user()->name.' sent back reimbursement'.$additionDesc.' request to requester for edit.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
            // APPROVER REJECT
            if($actionType =='REJECT'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[REIMBURSEMENT]['.$request->document_no.'] Rejected',
                    'title'         =>  'REIMBURSEMENT #'.$request->document_no.' REQUEST WAS REJECTED.',
                    'description'   =>  \Auth::user()->name.' rejected reimbursement'.$additionDesc.' request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
        }

        // INVOICE APPROVER PROCESS
        if($requestType == 'INVOICE'){

            $additionDesc = self::getAdditionDesc($request);

            // APPROVER APPROVE
            if($actionType =='APPROVE'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[INVOICE]['.$request->document_no.'] Approved',
                    'title'         =>  'INVOICE #'.$request->document_no.' REQUEST WAS APPROVED.',
                    'description'   =>  \Auth::user()->name.' approved invoice'.$additionDesc.' request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
            // APPROVER SENDBACK
            if($actionType =='SENDBACK'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[INVOICE]['.$request->document_no.'] Sent back',
                    'title'         =>  'INVOICE #'.$request->document_no.' REQUEST WAS SENT BACK.',
                    'description'   =>  \Auth::user()->name.' sent back invoice'.$additionDesc.' request to requester for edit.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
            // APPROVER REJECT
            if($actionType =='REJECT'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[INVOICE]['.$request->document_no.'] Rejected',
                    'title'         =>  'INVOICE #'.$request->document_no.' REQUEST WAS REJECTED.',
                    'description'   =>  \Auth::user()->name.' rejected invoice'.$additionDesc.' request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receiverNames
                ];
            }
        }

        return $data;

    }

    private static function templateFinanceProcess($requestType,$request,$actionType,$receivers,$reason)
    {
        // CASH-ADVANCE FINANCE PROCESS
        if($requestType == 'CASH-ADVANCE'){
            // FINANCE APPROVE
            if($actionType =='APPROVE'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CASH ADVANCE]['.$request->document_no.'] Approved',
                    'title'         =>  'CASH-ADVANCE #'.$request->document_no.' REQUEST WAS APPROVED.',
                    'description'   =>  'Finance Dept. approved cash advance request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receivers ? implode(', ', array_map(function($receiver){
                                                      return $receiver['name'];
                                                    }, $receivers)) : ''
                ];
            }
            // FINANCE SENDBACK
            if($actionType =='SENDBACK'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CASH ADVANCE]['.$request->document_no.'] Sent back',
                    'title'         =>  'CASH-ADVANCE #'.$request->document_no.' REQUEST WAS SENT BACK.',
                    'description'   =>  'Finance Dept. sent back cash advance request to requester for edit.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receivers ? implode(', ', array_map(function($receiver){
                                                      return $receiver['name'];
                                                    }, $receivers)) : ''
                ];
            }
            // FINANCE REJECT
            if($actionType =='REJECT'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CASH ADVANCE]['.$request->document_no.'] Rejected',
                    'title'         =>  'CASH-ADVANCE #'.$request->document_no.' REQUEST WAS REJECTED.',
                    'description'   =>  'Finance Dept. rejected cash advance request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receivers ? implode(', ', array_map(function($receiver){
                                                      return $receiver['name'];
                                                    }, $receivers)) : ''
                ];
            }
        }

        // CLEARING FINANCE PROCESS
        if($requestType == 'CLEARING'){

            $additionDesc = self::getAdditionDesc($request);

            // FINANCE APPROVE
            if($actionType =='APPROVE'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CLEARING]['.$request->clearing_document_no.'] Approved',
                    'title'         =>  'CLEARING #'.$request->clearing_document_no.' REQUEST WAS APPROVED.',
                    'description'   =>  'Finance Dept. approved clearing cash advance'.$additionDesc.' request.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receivers ? implode(', ', array_map(function($receiver){
                                                      return $receiver['name'];
                                                    }, $receivers)) : ''
                ];
            }
            // FINANCE SENDBACK
            if($actionType =='SENDBACK'){
                $data = [
                    'view'          =>  'emails.template_with_reason',
                    'subject'       =>  '[CLEARING]['.$request->clearing_document_no.'] Sent back',
                    'title'         =>  'CLEARING #'.$request->clearing_document_no.' REQUEST WAS SENT BACK.',
                    'description'   =>  'Finance Dept. sent back cash clearing advance'.$additionDesc.' request to requester for edit.',
                    'reason'        =>  $reason,
                    'requestId'     =>  $request->id,
                    'receiverNames' =>  $receivers ? implode(', ', array_map(function($receiver){
                                                      return $receiver['name'];
                                                    }, $receivers)) : ''
                ];
            }
        }

        return $data;
    }

    private static function templateUnblock($requestType,$request,$receivers,$reason)
    {
        // CASH-ADVANCE UNBLOCK
        if($requestType == 'CASH-ADVANCE'){
            $data = [
                'view'          =>  'emails.template_with_reason',
                'subject'       =>  '[CASH ADVANCE]['.$request->document_no.'] Unblocked',
                'title'         =>  'CASH-ADVANCE #'.$request->document_no.' REQUEST WAS UNBLOCKED.',
                'description'   =>  'Finance Dept. unblocked your cash advance request, now you can send this request to approver.',
                'reason'        =>  $reason,
                'requestId'     =>  $request->id,
                'receiverNames' =>  $receivers ? implode(', ', array_map(function($receiver){
                                                  return $receiver['name'];
                                                }, $receivers)) : ''
            ];
        }

        // REIMBURSEMENT UNBLOCK
        if($requestType == 'REIMBURSEMENT'){
            $data = [
                'view'          =>  'emails.template_with_reason',
                'subject'       =>  '[REIMBURSEMENT]['.$request->document_no.'] Unblocked',
                'title'         =>  'REIMBURSEMENT #'.$request->document_no.' REQUEST WAS UNBLOCKED.',
                'description'   =>  'Finance Dept. unblocked your reimbursement request, now you can send this request to approver.',
                'reason'        =>  $reason,
                'requestId'     =>  $request->id,
                'receiverNames' =>  $receivers ? implode(', ', array_map(function($receiver){
                                                  return $receiver['name'];
                                                }, $receivers)) : ''
            ];
        }

        // INVOICE UNBLOCK
        if($requestType == 'INVOICE'){
            $data = [
                'view'          =>  'emails.template_with_reason',
                'subject'       =>  '[INVOICE]['.$request->document_no.'] Unblocked',
                'title'         =>  'INVOICE #'.$request->document_no.' REQUEST WAS UNBLOCKED.',
                'description'   =>  'Finance Dept. unblocked your invoice request, now you can send this request to approver.',
                'reason'        =>  $reason,
                'requestId'     =>  $request->id,
                'receiverNames' =>  $receivers ? implode(', ', array_map(function($receiver){
                                                  return $receiver['name'];
                                                }, $receivers)) : ''
            ];
        }

        return $data;
    }

    // $userData can be => Collection of App\User || App\User || userId
    public static function composeReceivers($userData)
    {
        $receivers = [];
        if(!$userData){ return $receivers; }

        // Collection of App\User
        if(isEloquentCollection($userData)) {
            if(count($userData)>0){
                foreach ($userData as $key => $user) {
                    if($user->employee){
                        if($user->employee->email_address){
                            array_push($receivers, ['email' =>  $user->employee->email_address,
                                                    'name'  =>  $user->employee->first_name]);
                        }
                    }
                }
            }
        }else{
            // userId
            if(is_numeric($userData)){
                $user = User::find($userData);
                if($user){
                    if($user->employee){
                        if($user->employee->email_address){
                            array_push($receivers, ['email' =>  $user->employee->email_address,
                                                    'name'  =>  $user->employee->first_name]);
                        }
                    }
                }
            // App\User
            }else{
                if($userData->employee){
                    if($userData->employee->email_address){
                        array_push($receivers, ['email' =>  $userData->employee->email_address,
                                            'name'  =>  $userData->employee->first_name]);
                    }
                }
            }
        }

        return $receivers;
    }

    private static function getAdditionDesc($request)
    {
        $additionDesc = '';
        if($request->over_budget && $request->exceed_policy){
            $additionDesc = ' over budget and exceed policy';
        }elseif($request->over_budget){
            $additionDesc = ' over budget';
        }elseif($request->exceed_policy){
            $additionDesc = ' exceed policy';
        }
        return $additionDesc;
    }

}
