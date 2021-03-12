<?php

namespace App\Imports;

use App\CodesData;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class ProjectsImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation

{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */



    public function rules(): array
    {
        // return [
        //     'name'             => 'required|max:35',
        //     'email'            => 'required|email|unique:users,email',
        //     'password'         => 'required',
        //     'phone'            => 'required',
        //     // 'phone'            => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        //     'gender'           => 'required',
        //     'address'          => 'required',
            
        //     'home_address'           => 'required',
        //     'parent_first_name'           => 'required',
        //     'parent_last_name'           => 'required',
        //     'parent_email'           => 'required|email|unique:students,parent_email',
     
        // ];
 
    }
 
    public function customValidationMessages()
    {
    return [


            // All Email Validation for Student Email
        'email.required'    => 'Student  Email must not be empty!',
        'parent_email.required'    => 'Parent  Email must not be empty!',
        'email.email'       => 'Incorrect email address!',
        'email.unique'      => 'The Student email has already been used.',
        'parent_email.unique'      => 'The Parent email has already been used.',


        #Max Lenght Validation
        // 'name.required'               => 'Student name must not be empty!',
        // 'name.max'                    => 'The maximun length of The Student name must not exceed :max',
       
       
        'address.required'            => 'Address  must not be empty!',
        'home_address.required'            => 'Address  must not be empty!',
        // 'address.max'                 => 'The maximun length of The Address must not exceed :max',


        #Max Length with Contact Numeric Student
        'phone.required'      => 'Phone must not be empty!',
        // 'phone.regex'         => 'Incorrect format of Student Contact',

       ];
  }

    public function model(array $row)
    {
         $school_id = Auth::user()->id;
         $row['sch_id'] = $school_id;
         // dd($row['sch_id']);
          $excl_stds = array(
              'name' => $row['name'],
              'email' => $row['email'],
              'password' => $row['password'],
              'contact' => $row['phone'],
              'role_id' => 5,
          );
        $excel_student = DB::table('users')->insertGetId($excl_stds);
        return new CodesData([
            'last_name'     => $row['last_name'],
            's_u_id'     => $excel_student,
            'school_id'     => $row['sch_id'],
             'record_no'   => $row['record_no'],
             'gender'   => $row['gender'],
             'grade_level'   => $row['grade_level'],
             'home_address'   => $row['home_address'],
             'alergy'   => $row['alergy'],
             'iep'   => $row['iep'],
             'parent_first_name'   => $row['parent_first_name'],
             'parent_last_name'   => $row['parent_last_name'],
             'address'   => $row['address'],
             'phone'   => $row['phone'],
             'relation'   => $row['relation'],
             'parent_email'   => $row['parent_email'],
        ]);
    }
    public function onError(Throwable $error)
    {

    }
}
