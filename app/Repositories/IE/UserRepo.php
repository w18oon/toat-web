<?php 

namespace App\Repositories\IE;

use App\Employee;
use App\User;

class UserRepo
{
    public static function sync($oraclePersonId)
    {
        if(!$oraclePersonId){ return ; }
        // CHECK USER IS ALREADY EXIST OR NOT
        $user = User::where('oracle_person_id',$oraclePersonId)->first();
        $employee = Employee::where('person_id',$oraclePersonId)->first();
        // IF FOUND USER IN WEB SYSTEM >> SYNC USER DATA
        if($user && $employee){
            $user->name = $employee->full_name;
            $user->org_id = $employee->org_id;
            $user->save();
            return $user;
        }else{
            // IF NOT FOUND USER >> GET DATA FROM ORACLE TO CREATE NEW  
            if($employee){
                $newUser = new User();
                $newUser->oracle_person_id = $employee->person_id;
                $newUser->name = $employee->full_name;
                $newUser->username = $employee->ad_user_name;
                $newUser->email = $employee->email_address;
                $newUser->org_id = $employee->org_id;
                $newUser->role = 'user';
                $newUser->password = bcrypt('11111111');
                $newUser->active = true;
                $newUser->save();
                return $newUser;
            }
        }
        return ;
    }

    // THIS FUNCTION MAY USE TIME FOR A WHILE
    public static function syncAll()
    {
        $employees = Employee::orderBy('employee_number')->get();
        foreach($employees as $employee){
            if($employee->person_id){
                // CHECK USER IS ALREADY EXIST OR NOT
                $user = User::where('oracle_person_id',$employee->person_id)->first();
                // IF FOUND USER IN WEB SYSTEM >> SYNC USER DATA
                if($user && $employee){
                    $user->name = $employee->full_name;
                    $user->org_id = $employee->org_id;
                    $user->save();
                }else{
                    // IF NOT FOUND USER >> GET DATA FROM ORACLE TO CREATE NEW  
                    if($employee){
                        $newUser = new User();
                        $newUser->oracle_person_id = $employee->person_id;
                        $newUser->name = $employee->full_name;
                        $newUser->username = $employee->ad_user_name;
                        $newUser->email = $employee->email_address;
                        $newUser->org_id = $employee->org_id;
                        $newUser->role = 'user';
                        $newUser->password = bcrypt('11111111');
                        $newUser->active = true;
                        $newUser->save();
                        $newUser->save();
                    }
                }
            }
        }
    }

}
