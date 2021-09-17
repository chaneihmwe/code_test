<?php

namespace App\Helper;
use App\Employee;

class General {

    public static function generatePassword($length = 8) {
        $characters = '0123456789!@#$%^&*()abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_password = '';
        for ($i = 0; $i < $length; $i++) {
            $random_password .= $characters[rand(0, $characters_length - 1)];
        }
        return $random_password;
    }
    public static function search($company_id, $department_id, $name, $staff_id) {
        $name = ($name == null) ? '' : $name;
        $staff_id = ($staff_id == null) ? '' : $staff_id;

        if ($company_id != null && $department_id != null) {

            $employees = Employee::whereHas('departments', function ($query) use ($department_id) {
                return $query->where('department_id', $department_id);
            })->whereHas('user', function ($query) use ($name) {
                return $query->where('user_name', 'LIKE' ,"%$name%");
            })->where([
                ['company_id', '=', $company_id],
                ['staffId', 'LIKE', "%$staff_id%"],
            ])->paginate(10);

        }elseif ($company_id != null) {

            $employees = Employee::whereHas('user', function ($query) use ($name) {
                return $query->where('user_name', 'LIKE' ,"%$name%");
            })->where([
                ['company_id', '=', $company_id],
                ['staffId', 'LIKE', "%$staff_id%"],
            ])->paginate(10);

        }elseif ($department_id != null) {

            $employees = Employee::whereHas('departments', function ($query) use ($department_id) {
                return $query->where('department_id', $department_id);
            })->whereHas('user', function ($query) use ($name) {
                return $query->where('user_name', 'LIKE' ,"%$name%");
            })->where([
                ['staffId', 'LIKE', "%$staff_id%"],
            ])->paginate(10);
            
        }else {

            $employees = Employee::whereHas('user', function ($query) use ($name) {
                return $query->where('user_name', 'LIKE' ,"%$name%");
            })->where([
                ['staffId', 'LIKE', "%$staff_id%"],
            ])->paginate(10);

        }
        return $employees;
    }
}