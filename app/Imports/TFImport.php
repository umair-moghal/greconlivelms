<?php

namespace App\Imports;

use App\TfExcel;

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

class TfImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation

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
            'label'             => 'required|max:255',
            'correct'            => 'required',
        ];
 
    }
 
    public function customValidationMessages()
    {
    return [
        'label.required'    => 'Question Label is required!',
        'correct.required'    => 'Question Options are required!',
       ];
  }

  	public $rows = 0;

    public function model(array $row)
    {
    	++$this->rows;
        $carray = $row['correct'];
        if($carray == 0)
        {
            $correct = 'false';
        }
        else
        {
            $correct = 'true';
        }

        $opts = array(
            'true' => 'true',
            'false' => 'false',
            'correct' => $correct,
        );
        $optins = serialize($opts);

        return new TfExcel([
            'label'   => $row['label'],
            'options'   => $optins,
            'type'   => 't/f',
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
