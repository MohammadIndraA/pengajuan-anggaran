<?php  

namespace App\Imports;  

use App\Models\ProvinceImport as ModelsProvinceImport;  
use Illuminate\Support\Collection;  
use Maatwebsite\Excel\Concerns\ToCollection;  
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProvinceImport implements ToCollection, WithCalculatedFormulas
{  
    protected $id;  
    protected $total = 0; // Tambahkan properti untuk menyimpan total  

    public function __construct($id)  
    {  
        $this->id = $id;  
    }  

    public function collection(Collection $collection)
    {
        $index = 7;
        $komponen = [];
        $currentkomponenIndex = -1;
        $currentPointIndex = -1;
        $currentDetailIndex = -1;
        $currentKppnIndex = -1;
        $currentKppnKategoriIndex = -1;
    
        foreach ($collection as $row) {
            if ($index > 7) {
                // Process komponen (length 3)
                if (isset($row[0]) && (strlen(trim($row[0])) == 1 || strlen(trim($row[0])) == 2) && is_numeric(trim($row[0]))) { 
                    $currentkomponenIndex++;
                    $currentPointIndex = -1;
                    $subtotal = $row[6]; 
                    $komponen[$currentkomponenIndex] = [
                        'code' => $row[0],  
                        'name' => $row[1] ?? null,
                        'qty' => $row[2] ?? null,
                        'satuan' => $row[3] ?? null,
                        'subtotal' => $subtotal,
                        'sub_komponen' => []
                    ];
                }                
                // Process Point (length 1)
                elseif (isset($row[0]) && strlen(trim($row[0])) == 1) {
                    if ($currentkomponenIndex >= 0) {
                        $currentPointIndex++;
                        $currentDetailIndex = -1;
                        $komponen[$currentkomponenIndex]['sub_komponen'][$currentPointIndex] = [
                            'code' => $row[0],
                            'name' => $row[1] ?? null,
                            'subtotal' => $row[6] ?? null,
                            'poin_sub_komponen' => []
                        ];
                    }
                }
                
                // Process Detail (length 6)
                elseif (isset($row[0]) && strlen(trim($row[0])) == 6) {
                    if ($currentPointIndex >= 0) {
                        $currentDetailIndex++;
                        $currentKppnIndex = -1;
                        $komponen[$currentkomponenIndex]['sub_komponen'][$currentPointIndex]['poin_sub_komponen'][$currentDetailIndex] = [
                            'code' => $row[0],
                            'name' => $row[1] ?? null,
                            'subtotal' => $row[6] ?? null,
                            'wilayah' => []
                        ];
                    }
                }
                
                // Process KPPN
                elseif (isset($row[1]) && substr($row[1], 0, 1) === '>') {
                    if ($currentDetailIndex >= 0) {
                        $currentKppnIndex++;
                        $currentKppnKategoriIndex = -1;
                        $komponen[$currentkomponenIndex]['sub_komponen'][$currentPointIndex]['poin_sub_komponen'][$currentDetailIndex]['wilayah'][$currentKppnIndex] = [
                            'name' => $row[1] ?? null,
                            'subtotal' => $row[6] ?? null,
                            'sub_wilayah' => []
                        ];
                    }
                }
                
                // Process KPPN Kategori
                elseif (isset($row[1]) && substr($row[1], 0, 1) === '-') {
                    if ($currentKppnIndex >= 0) {
                        $currentKppnKategoriIndex++;
                        $komponen[$currentkomponenIndex]['sub_komponen'][$currentPointIndex]['poin_sub_komponen'][$currentDetailIndex]['wilayah'][$currentKppnIndex]['sub_wilayah'][$currentKppnKategoriIndex] = [
                            'name' => $row[1] ?? null,
                            'qty' => $row[2] ?? null,
                            'satuan' => $row[3] ?? null,
                            'subtotal' => $row[5] ?? null,
                            'verifikasi' =>(float) $row[2] * (float)$row[5],
                            'validasi' => (float)$row[6] == (float)$row[2] * (float)$row[5] ? 'Sesuai' : 'Tidak Sesuai',
                            'total' => $row[6] ?? null,
                        ];
                    }
                }
            }
            $index++;
        }
        
        // return $komponen;
        dd($komponen);
    }

    public function getTotal(){  
        return $this->total;  
    }  
}
