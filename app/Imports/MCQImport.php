<?php

namespace App\Imports;

use App\McqExcel;

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

class MCQImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation

{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */



    public function rules(): array
    {
        return [
            // 'label'             => 'required|max:255',
            // 'option1'            => 'required',
        ];
 
    }
 
    public function customValidationMessages()
    {
    return [
        // 'label.required'    => 'Question Label is required!',
        // 'option1.required'    => 'Question Options are required!',
       ];
  }

  	public $rows = 0;

    public function model(array $row)
    {
    	++$this->rows;
        $myarray = $row['correct'];
        $correct = explode(',', $myarray);
        $opts = array(
            'opt1' => $row['option1'],
            'opt2' => $row['option2'],
            'opt3' => $row['option3'],
            'opt4' => $row['option4'],
            'correct' => $correct,
        );
        $optins = serialize($opts);

        return new McqExcel([
            'label'   => $row['label'],
            'options'   => $optins,
            'type'   => 'mcq',
        ]);

    }


    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function onError(Throwable $error)
    {

    }
}
