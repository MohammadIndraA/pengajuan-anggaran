<?php

namespace App\Exports;

use App\Models\DepartementImport;
use App\Models\DivisionImport;
use App\Models\ProvinceImport;
use App\Models\RegencyImport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengajuanAanggaranExport implements FromArray, WithHeadings
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
    // public function collection()
    // {
    //     if ($this->type == "province") {
    //         $data = ProvinceImport::where('province_budget_request_id', $this->id)->get();
    //     }
    //     if ($this->type == "regency") {
    //         $data = RegencyImport::where('regency_budget_request_id', $this->id)->get();
    //     }
    //     if ($this->type == "departement") {
    //         $data = DepartementImport::where('departement_budget_request_id', $this->id)->get();
    //     }
    //     return $data;
    // }

    public function array(): array
    {
        $data = [];

        if ($this->type == "province") {
            $data = ProvinceImport::where('province_budget_request_id', $this->id)->get();
        } elseif ($this->type == "regency") {
            $data = RegencyImport::where('regency_budget_request_id', $this->id)->get();
        } elseif ($this->type == "departement") {
            $data = DepartementImport::where('departement_budget_request_id', $this->id)->get();
        }elseif($this->type == "division"){
            $data = DivisionImport::where('division_budget_request_id', $this->id)->get();
        }

        // Pilih field yang akan diekspor
        return $data->map(function ($item) {
            return [
                'no' => $item->no,
                'program' => $item->program,
                'kegiatan' => $item->activity,
                'kro' => $item->kro,
                'ro' => $item->ro,
                'satuan' => $item->unit,
                'komponen' => $item->component,
                'qty' => $item->qty,
                'subtotal' => $item->subtotal,
                'total' => $item->total,
            ];
        })->toArray();
    }


    public function headings(): array
    {
        // Definisikan header kolom
        return [
            'No',
            'Program',
            'Kegiatan',
            'KRO',
            'RO',
            'Satuan',
            'Komponen',
            'Qty',
            'Subtotal',
            'Total',
        ];
    }
}
