<?php

namespace App\Exports;

use App\Models\DepartementImport;
use App\Models\ProvinceImport;
use App\Models\RegencyImport;
use Maatwebsite\Excel\Concerns\FromCollection;

class PengajuanAanggaranExport implements FromCollection
{
     /**
    * @param Collection $collection
    */
    protected $id;  
    protected $type;  
    protected $total = []; // Tambahkan properti untuk menyimpan total  

    public function __construct($id,$type)  
    {  
        $this->id = $id;  
        $this->type = $type;
    }
    public function collection()
    {
        if ($this->type == "province") {
            $data = ProvinceImport::where('province_budget_request_id', $this->id)->get();
        }
        if ($this->type == "regency") {
            $data = RegencyImport::where('regency_budget_request_id', $this->id)->get();
        }
        if ($this->type == "departement") {
            $data = DepartementImport::where('departement_budget_request_id', $this->id)->get();
        }
        return $data;
    }
}
