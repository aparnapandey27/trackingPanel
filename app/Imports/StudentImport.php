<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use App\Mail\Student\AccountCreateApprove;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if the record with certain column value already exists
        $email = strval($row[1] ?? ''); 
        $phone = strval($row[2] ?? ''); 
        
        if ((!empty($email)) & (!empty($phone))) {
        $existingEmail = User::where('email',$email)->first();
        $existingPhone = User::where('phone',$phone)->first();
        if (!$existingEmail & !$existingPhone) {
            $student= new User([
                'role' => 'student',
                'company' => strval($row[3]),
                'name' => strval($row[0]),
                'email' => $email,
                'phone' => $phone,
                'status'=> 1,
                'password'=> Hash::make(12345678)
              ]);
               //Mail::to($student)->send(new AccountCreateApprove($student));
              return $student;
              
        }
        return null; 
    }
    return null;
    }
    
   
    
}
