<?php

namespace App\Exports;

use App\Models\Component;
use App\Models\DepartementImport;
use App\Models\DivisionImport;
use App\Models\ProvinceImport;
use App\Models\RegencyImport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;  
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;  
use Maatwebsite\Excel\Concerns\ShouldAutoSize;  
use Illuminate\Http\Request;

class PengajuanAanggaranExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
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
        // Mengambil data pertin dengan ID sesuai tipe  
        if ($this->type == "province") {  
            $model = 'province_budget_requests';  
            $provinceData = Component::with(['subKomponen.poinSubComponent.wilayah.subWilayah'])  
                ->withFullDetails($model, 'province_budget_request_id', $this->id)  
                ->get();  
        } elseif ($this->type == "regency") {  
            $model = 'regency_budget_requests';
            $provinceData =  Component::with(['subKomponen.poinSubComponent.wilayah.subWilayah'])            
            ->withFullDetails($model, 'regency_budget_request_id', $this->id)
            ->get();
        } elseif ($this->type == "departement") {  
            $model = 'departement_budget_requests';
            $provinceData =  Component::with(['subKomponen.poinSubComponent.wilayah.subWilayah'])
            ->withFullDetails($model, 'departement_budget_request_id', $this->id)
            ->get(); 
        } elseif ($this->type == "division") {  
            $model = 'division_budget_requests';
            $provinceData =  Component::with(['subKomponen.poinSubComponent.wilayah.subWilayah'])
            ->withFullDetails($model, 'division_budget_request_id', $this->id)
            ->get();  
        } else  {
            $provinceData = null; // Inisialisasi variabel $provinceData
            if (request()->is('pengajuan-anggaran-departement/regency')) {
                $model = 'regency_budget_requests';
                $requestId = 'regency_budget_request_id';
            } elseif (request()->is('pengajuan-anggaran-departement/province')) {
                $model = 'province_budget_requests';
                $requestId = 'province_budget_request_id';
            } elseif (request()->is('pengajuan-anggaran-departement/division')) {
                $model = 'division_budget_requests';
                $requestId = 'division_budget_request_id';
            } elseif (request()->is('pengajuan-anggaran-departement/departement')) {
                $model = 'departement_budget_requests';
                $requestId = 'departement_budget_request_id';
            }
        
            if (isset($model) && isset($requestId)) {
                $provinceData = Component::with(['subKomponen.poinSubComponent.wilayah.subWilayah'])
                    ->withFullDetails($model, $requestId, $this->id)
                    ->get();
            }
            dd($provinceData);
        }        
        // Ambil data dengan relasi  
        // Menambahkan baris wilayah  
        $data[] = [  
            'code' => '',  
            'name' => $provinceData[0]->wilayah_name,  
            'volume_qty' => '',  
            'volume_unit' => '',  
            'price' => '',  
            'total' => $provinceData[0]->wilayah_total,  
        ];  

        // Menambahkan baris Satker  
        $data[] = [  
            'code' => '',  
            'name' => $provinceData[0]->satker_name,  
            'volume_qty' => '',  
            'volume_unit' => '',  
            'price' => '',    
            'total' => $provinceData[0]->satker_total,  
        ];  

        // Menambahkan baris Program  
        $data[] = [  
            'code' => '025.09.WA',  
            'name' => $provinceData[0]->program_name,  
            'volume_qty' => '',  
            'volume_unit' => '',    
            'price' => 'Rp. ' . $provinceData[0]->program_total,  
            'total' => 'Rp. ' . $provinceData[0]->program_total,  
        ];  

        // Menambahkan baris Kegiatan  
        $data[] = [  
            'code' => '2150',  
            'name' => $provinceData[0]->activity_name,  
            'volume_qty' => '7',  
            'volume_unit' => 'Layanan',    
            'price' => 'Rp. ' . $provinceData[0]->activity_price,  
            'total' => 'Rp. ' . $provinceData[0]->activity_total,  
        ];  

        // Menambahkan baris KRO  
        $data[] = [  
            'code' => '2150.EBA.956',  
            'name' => $provinceData[0]->kro_name,  
            'volume_qty' => '1',  
            'volume_unit' => 'Layanan',    
            'price' => '',  
            'total' => 'Rp. ' . $provinceData[0]->kro_total,  
        ];  

        // Menambahkan baris RO  
        $data[] = [  
            'code' => '051',  
            'name' => $provinceData[0]->ro_name,  
            'volume_qty' => '',  
            'volume_unit' => '',    
            'price' => '',  
            'total' => 'Rp. ' . $provinceData[0]->ro_total,  
        ];  
        foreach ($provinceData as $item) {  
            // Menyertakan Components jika ada  
           
                $data[] = [  
                    'code' => $item->component_code,  
                    'name' => $item->component_name,  
                    'volume_qty' => '',  
                    'volume_unit' => '',    
                    'price' => '',  
                    'total' => 'Rp. ' . $item->total,  
                ];  
    
                // Menyertakan subKomponen  
                foreach ($item->subKomponen as $subComponent) {  
                    $data[] = [  
                        'code' => $subComponent->sub_component_code,  
                        'name' => $subComponent->sub_component_name,  
                        'volume_qty' => '',  
                        'volume_unit' => '',    
                        'price' => '',  
                        'total' => 'Rp. ' . $subComponent->total,  
                    ];  
                    
                    // Menyertakan poinSubComponent  
                    foreach ($subComponent->poinSubComponent as $point) {  
                        $data[] = [  
                            'code' => $point->point_sub_component_code,  
                            'name' => $point->point_sub_component_name,  
                            'volume_qty' => '',  
                            'volume_unit' => '',    
                            'price' => '',
                            'total' => 'Rp. ' . $point->total,  
                        ];  
                        // if ($point->subWilayahComponent != null) {
                        //     foreach ($point->subWilayahComponent as $value) {
                        //         $data[] = [  
                        //             'code' => '',  
                        //             'name' => $value->sub_wilayah_name,  
                        //             'volume_qty' => $value->qty,  
                        //             'volume_unit' => $value->satuan,    
                        //             'price' => 'Rp. ' . $value->sub_total,  
                        //             'total' => 'Rp. ' . $value->total,  
                        //         ];  
                        //     }
                        // }
                        // Menyertakan wilayah jika ada  
                        foreach ($point->wilayah as $region) {  
                            $data[] = [  
                                'code' => '',  
                                'name' => $region->wilayah_name,  
                                'volume_qty' => '',  
                                'volume_unit' => '',    
                                'price' => '',  
                                'total' => 'Rp. ' . $region->total,  
                            ];  
    
                            // Menyertakan subWilayah jika ada  
                            foreach ($region->subWilayah as $subRegion) {  
                                $data[] = [  
                                    'code' => '',  
                                    'name' => $subRegion->sub_wilayah_name,  
                                    'volume_qty' => $subRegion->qty,  
                                    'volume_unit' => $subRegion->satuan,    
                                    'price' => 'Rp. ' . $subRegion->sub_total,  
                                    'total' => 'Rp. ' . $subRegion->total,  
                                ];  
                            }  
                        }  
                    }  
                }  
            } 
    
        return $data;  
    }


    public function headings(): array  
    {  
        return [  
            'Code',  
            'Wilayah/Satker/Program/Kegiatan/KRO/RO/Komponen',  
           'Volume',
            '',  
            'Satuan Harga',  
            'Jumlah',  
        ];  
    }




    public function map($row): array { 
        return [ 
            $row->code,
            $row->name,
             $row->volume,
             $row->volume,
             $row->satuan_harga,
             $row->jumlah 
            ]; 
        }

        public function styles(Worksheet $sheet)  
        {  
            // Bold and change color for header  
            $sheet->mergeCells('C1:D1'); // Menggabungkan sel untuk kolom Volume 
            $sheet->getStyle('A1:F1')->applyFromArray([ 
                'alignment' => [ 
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
                ], 
                'font' => [ 'bold' => true, 
            ], ]);
        
            $rowCount = $sheet->getHighestRow(); // Get the number of rows  
            for ($row = 2; $row <= $rowCount; $row++) {  
                // Get values from the Price and Total columns  
                $priceValue = $sheet->getCell('E' . $row)->getValue(); // Price  
                $totalValue = $sheet->getCell('F' . $row)->getValue(); // Total  
        
                // Apply style for the Price column if conditions match  
                if ($this->shouldStyle($priceValue)) {  
                    $sheet->getStyle('E' . $row)->applyFromArray([  
                        'font' => [  
                            'bold' => true,  
                            'color' => ['argb' => 'FFFF0000'], // Red for text  
                        ],  
                        'fill' => [  
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,  
                            'startColor' => ['argb' => 'FFFFCCCC'], // Light red for background  
                        ],  
                    ]);  
                }  
        
                // Apply style for the Total column if conditions match  
                if ($this->shouldStyle($totalValue)) {  
                    $sheet->getStyle('F' . $row)->applyFromArray([  
                        'font' => [  
                            'bold' => true,  
                            'color' => ['argb' => 'FFFF0000'], // Red for text  
                        ],  
                        'fill' => [  
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,  
                            'startColor' => ['argb' => 'FFFFCCCC'], // Light red for background  
                        ],  
                    ]);  
                }  
            }  
        }  
        
        private function shouldStyle($value)  
        {  
                    // Jika nilai kosong atau null, return false
            if ($value === null || $value === '') {
                return false;
            }
            $Rp = 'Rp. ';  
            return $value == 0 || $value == $Rp || $value == $Rp . '-' || $value == $Rp . '0' || 
                   $value == $Rp . '0-' || $value == '-' || $value == '0' || $value == '0-';  
        }
}
