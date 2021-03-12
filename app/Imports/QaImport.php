<?php

namespace App\Imports;

use App\QaExcel;

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

class QaImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation

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
            'options'            => 'required',
        ];
 
    }
 
    public function customValidationMessages()
    {
    return [
        'label.required'    => 'Question Label is required!',
        'options.required'    => 'Question Options are required!',
       ];
  }

  	public $rows = 0;

    public function model(array $row)
    {
    	++$this->rows;

        return new QaExcel([
            'options'   => $row['options'],
            'label'   => $row['label'],
            'type'   => 'question/answer',
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
