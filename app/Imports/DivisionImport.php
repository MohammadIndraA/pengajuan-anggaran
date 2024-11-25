<?php

namespace App\Imports;

use App\Models\DivisionImport as ModelsDivisionImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DivisionImport implements ToCollection
{
     /**
    * @param Collection $collection
    */
    protected $id;  
    protected $total = 0; // Tambahkan properti untuk menyimpan total  

    public function __construct($id)  
    {  
        $this->id = $id;  
    }  

    public function collection(Collection $collection)  
    {  
        $index = 1;  
        foreach ($collection as $row) {  
            if ($index > 1) {  
                $data['no'] = $row[0];  
                $data['program'] = $row[1];  
                $data['activity'] = $row[2];  
                $data['kro'] = $row[3];  
                $data['ro'] = $row[4];  
                $data['component'] = $row[5];  
                $data['unit'] = $row[6];  
                $data['qty'] = $row[7];  
                $data['subtotal'] = $row[8];  
                $data['total'] = $row[7] * $row[8];  
                $data['division_budget_request_id'] = $this->id;  

                ModelsDivisionImport::create($data);  
                $this->total += $data['total']; // Tambahkan total ke properti  
            }  
            $index++;  
        }  
    }  

    public function getTotal(){  
        return $this->total;  
    }
}
