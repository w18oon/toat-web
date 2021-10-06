<?php

    function activeIcon($active)
    {
        if($active){ 
        	return '<span class="label label-primary">Active</span>'; 
        }else{
        	return '<span class="label label-default">Inactive</span>';
        }
    }

    function activeMiniIcon($active)
    {
        if($active){ 
            return '<i class="fa fa-circle text-navy"></i>'; 
        }else{
            return '<i class="fa fa-circle "></i>';
        }
    }

    function checkCircleIcon($check)
    {
        if($check){ 
        	return '<i class="fa fa-check text-navy"></i>'; 
        }else{
        	return '';
        }
    }

    function statusIconCA($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                $result = '<span class="label-status label-default text-white"> NEW REQUEST </span>';
                break;
            case "BLOCKED":
                $result = '<span class="label-status btn-danger btn-outline"> BLOCKED </span>';
                break;
            case "APPROVER_DECISION":
                $result = '<span class="label-status label-warning text-white"> APPROVER DECISION </span>';
                break;
            case "APPROVER_REJECTED":
                $result = '<span class="label-status label-danger text-white"> APPROVER REJECTED </span>';
                break;
            case "FINANCE_PROCESS":
                $result = '<span class="label-status label-warning text-white"> FINANCE PROCESS </span>';
                break;
            case "FINANCE_REJECTED":
                $result = '<span class="label-status label-danger text-white"> FINANCE REJECTED </span>';
                break;
            case "APPROVED":
                $result = '<span class="label-status label-success text-white"> APPROVED </span>';
                break;
            case "CLEARING_REQUEST":
                $result = '<span class="label-status label-default text-white"> CLEARING REQUEST </span>';
                break;
            case "CLEARING_APPROVER_DECISION":
                $result = '<span class="label-status label-warning text-white"> CLEARING APPROVER DECISION </span>';
                break;
            case "CLEARING_APPROVER_REJECTED":
                $result = '<span class="label-status label-danger text-white"> CLEARING APPROVER REJECTED </span>';
                break;
            case "CLEARING_FINANCE_PROCESS":
                $result = '<span class="label-status label-warning text-white"> CLEARING FINANCE PROCESS </span>';
                break;
            case "CLEARING_FINANCE_REJECTED":
                $result = '<span class="label-status label-danger text-white"> CLEARING FINANCE REJECTED </span>';
                break;
            case "CLEARED":
                $result = '<span class="label-status btn-success btn-outline"> CLEARED </span>';
                break;
            case "CANCELLED":
                $result = '<span class="label-status label-danger text-white"> CANCELLED </span>';
                break;
        }
        return $result;
    }

    function statusIconREIM($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                $result = '<span class="label-status label-default text-white"> NEW REQUEST </span>';
                break;
            case "BLOCKED":
                $result = '<span class="label-status btn-danger btn-outline"> BLOCKED </span>';
                break;
            case "APPROVER_DECISION":
                $result = '<span class="label-status label-warning text-white"> APPROVER DECISION </span>';
                break;
            case "APPROVER_REJECTED":
                $result = '<span class="label-status label-danger text-white"> APPROVER REJECTED </span>';
                break;
            case "APPROVED":
                $result = '<span class="label-status label-success text-white"> APPROVED </span>';
                break;
            case "CANCELLED":
                $result = '<span class="label-status label-danger text-white"> CANCELLED </span>';
                break;
        }
        return $result;
    }

    function statusIconINVOICE($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                $result = '<span class="label-status label-default text-white"> NEW REQUEST </span>';
                break;
            case "BLOCKED":
                $result = '<span class="label-status btn-danger btn-outline"> BLOCKED </span>';
                break;
            case "APPROVER_DECISION":
                $result = '<span class="label-status label-warning text-white"> APPROVER DECISION </span>';
                break;
            case "APPROVER_REJECTED":
                $result = '<span class="label-status label-danger text-white"> APPROVER REJECTED </span>';
                break;
            case "APPROVED":
                $result = '<span class="label-status label-success text-white"> APPROVED </span>';
                break;
            case "CANCELLED":
                $result = '<span class="label-status label-danger text-white"> CANCELLED </span>';
                break;
        }
        return $result;
    }

    function statusMiniIconCA($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                // $result = '<span class="label-status label-default text-white" title="NEW REQUEST"> &nbsp; </span>';
                $result = '<i class="fa fa-circle" title="NEW REQUEST"></i>';
                break;
            case "BLOCKED":
                // $result = '<span class="label-status btn-danger btn-outline" title="BLOCKED"> &nbsp; </span>';
                $result = '<i class="fa fa-ban text-danger" title="BLOCKED"></i>';
                break;
            case "APPROVER_DECISION":
                // $result = '<span class="label-status label-warning text-white" title="APPROVER DECISION"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-warning" title="APPROVER DECISION"></i>';
                break;
            case "APPROVER_REJECTED":
                // $result = '<span class="label-status label-danger text-white" title="APPROVER REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-danger" title="APPROVER REJECTED"></i>';
                break;
            case "FINANCE_PROCESS":
                // $result = '<span class="label-status label-warning text-white" title="FINANCE PROCESS"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-warning" title="FINANCE PROCESS"></i>';
                break;
            case "FINANCE_REJECTED":
                // $result = '<span class="label-status label-danger text-white" title="FINANCE REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-danger" title="FINANCE REJECTED"></i>';
                break;
            case "APPROVED":
                // $result = '<span class="label-status label-success text-white" title="APPROVED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle text-success" title="APPROVED"></i>';
                break;
            case "CLEARING_REQUEST":
                // $result = '<span class="label-status label-default text-white" title="CLEARING REQUEST"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o" title="CLEARING REQUEST"></i>';
                break;
            case "CLEARING_APPROVER_DECISION":
                // $result = '<span class="label-status label-warning text-white" title="CLEARING APPROVER DECISION"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o text-warning" title="CLEARING APPROVER DECISION"></i>';
                break;
            case "CLEARING_APPROVER_REJECTED":
                // $result = '<span class="label-status label-danger text-white" title="CLEARING APPROVER REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o text-danger" title="CLEARING APPROVER REJECTED"></i>';
                break;
            case "CLEARING_FINANCE_PROCESS":
                // $result = '<span class="label-status label-warning text-white" title="CLEARING FINANCE PROCESS"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o text-warning" title="CLEARING FINANCE PROCESS"></i>';
                break;
            case "CLEARING_FINANCE_REJECTED":
                // $result = '<span class="label-status label-danger text-white" title="CLEARING FINANCE REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle-o text-danger" title="CLEARING FINANCE REJECTED"></i>';
                break;
            case "CLEARED":
                // $result = '<span class="label-status btn-success btn-outline" title="CLEARED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle-o text-success" title="CLEARED"></i>';
                break;
            case "CANCELLED":
                // $result = '<span class="label-status label-danger text-white" title="CANCELLED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle text-danger" title="CANCELLED"></i>';
                break;
        }
        return $result;
    }

    function statusMiniIconREIM($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                // $result = '<span class="label-status label-default text-white" title="NEW REQUEST"> &nbsp; </span>';
                $result = '<i class="fa fa-circle" title="NEW REQUEST"></i>';
                break;
            case "BLOCKED":
                // $result = '<span class="label-status btn-danger btn-outline" title="BLOCKED"> &nbsp; </span>';
                $result = '<i class="fa fa-ban text-danger" title="BLOCKED"></i>';
                break;
            case "APPROVER_DECISION":
                // $result = '<span class="label-status label-warning text-white" title="APPROVER DECISION"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-warning" title="APPROVER DECISION"></i>';
                break;
            case "APPROVER_REJECTED":
                // $result = '<span class="label-status label-danger text-white" title="APPROVER REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-danger" title="APPROVER REJECTED"></i>';
                break;
            case "APPROVED":
                // $result = '<span class="label-status label-success text-white" title="APPROVED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-success" title="APPROVED"></i>';
                break;
            case "CANCELLED":
                // $result = '<span class="label-status label-danger text-white" title="CANCELLED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle text-danger" title="CANCELLED"></i>';
                break;
        }
        return $result;
    }

    function statusMiniIconINVOICE($status)
    {
        $result = "";
        switch ($status) {
            case "NEW_REQUEST":
                // $result = '<span class="label-status label-default text-white" title="NEW REQUEST"> &nbsp; </span>';
                $result = '<i class="fa fa-circle" title="NEW REQUEST"></i>';
                break;
            case "BLOCKED":
                // $result = '<span class="label-status btn-danger btn-outline" title="BLOCKED"> &nbsp; </span>';
                $result = '<i class="fa fa-ban text-danger" title="BLOCKED"></i>';
                break;
            case "APPROVER_DECISION":
                // $result = '<span class="label-status label-warning text-white" title="APPROVER DECISION"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-warning" title="APPROVER DECISION"></i>';
                break;
            case "APPROVER_REJECTED":
                // $result = '<span class="label-status label-danger text-white" title="APPROVER REJECTED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-danger" title="APPROVER REJECTED"></i>';
                break;
            case "APPROVED":
                // $result = '<span class="label-status label-success text-white" title="APPROVED"> &nbsp; </span>';
                $result = '<i class="fa fa-circle text-success" title="APPROVED"></i>';
                break;
            case "CANCELLED":
                // $result = '<span class="label-status label-danger text-white" title="CANCELLED"> &nbsp; </span>';
                $result = '<i class="fa fa-check-circle text-danger" title="CANCELLED"></i>';
                break;
        }
        return $result;
    }

    function statusIconInterface($status)
    {
        $result = "";
        switch ($status) {
            case "P":
                $result = '<span class="label-status btn-warning btn-outline"> PENDING... </span>';
                break;
            case "S":
                $result = '<span class="label-status btn-success btn-outline"> SUCCESS </span>';
                break;
            case "E":
                $result = '<span class="label-status btn-danger btn-outline"> ERROR </span>';
                break;
        }
        return $result;
    }

    function statusMiniIconInterface($status)
    {
        $result = "";
        switch ($status) {
            case "P":
                // $result = '<span class="label-status btn-warning btn-outline"> PENDING... </span>';
                $result = '<i class="fa fa-spinner text-warning" title="PENDING..."></i>';
                break;
            case "S":
                // $result = '<span class="label-status btn-success btn-outline"> SUCCESS </span>';
                $result = '<i class="fa fa-check-circle text-success" title="SUCCESS"></i>';
                break;
            case "E":
                // $result = '<span class="label-status btn-danger btn-outline"> ERROR </span>';
                $result = '<i class="fa fa-times-circle text-danger" title="ERROR"></i>';
                break;
        }
        return $result;
    }
