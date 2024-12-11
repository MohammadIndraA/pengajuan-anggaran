<?php  

namespace App\Imports;

use App\Models\Activity;
use App\Models\Budget;
use App\Models\Component;
use App\Models\Kro;
use App\Models\Program;
use App\Models\ProvinceImport as ModelsProvinceImport;
use App\Models\Ro;
use App\Models\Satker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
          // Buat Satker
        $satker = Satker::create([
            'wilayah_name' => $collection[0][1],
            'wilayah_total' => $collection[0][6],
            'satker_name' => $collection[2][1],
            'satker_total' => $collection[2][6],
        ]);
        $this->total += $collection[0][6];
          // Buat Program
        $program = Program::create([
            'program_code' => $collection[3][0],
            'program_name' => $collection[3][1],
        ]);

        // Buat atau Perbarui Activity
          $activity =  Activity::create(
            ['activity_code' => $collection[4][0],
            'activity_name' => $collection[4][1]
            ]
        );

        // Buat atau Perbarui Kro
        $kro = Kro::create(
            ['kro_code' => $collection[5][0],
            'kro_name' => $collection[5][1]]
        );

        // Buat atau Perbarui Ro
        $ro = Ro::create(
            ['ro_code' => $collection[6][0],
            'ro_name' => $collection[6][1]]
        );

        Budget::create([
            'budget' => $collection[3][6],
            'program_id' => $program->id,
        ]);

       Budget::create([
            'budget' => $collection[4][6],
            'activity_id' => $activity->id,
        ]);

       Budget::create([
            'budget' => $collection[5][6],
            'kro_id' => $kro->id,
        ]);


        Budget::create([
            'budget' => $collection[6][6],
            'ro_id' => $ro->id,
        ]);


        $index = 7;
        $currentkomponenIndex = -1;
        $currentPointIndex = -1;
        $currentDetailIndex = -1;
        $currentKppnIndex = -1;
        $currentKppnKategoriIndex = -1;
    
        $komponen = null;
        $subKomponen = null;
        $poinSubKomponen = null;
        $wilayah = null;

        foreach ($collection as $row) {
            if ($index > 7) {
                // Process komponen (length 1 dan 2 dan itu number)
                if (isset($row[0]) && (strlen(trim($row[0])) == 1 || strlen(trim($row[0])) == 2) && is_numeric(trim($row[0]))) { 
                    $currentkomponenIndex++;
                    $currentPointIndex = -1;
                    $subtotal = $row[6]; 
                    $data = [
                        'component_code' => $row[0],  
                        'component_name' => $row[1] ?? null,
                        'qty' => $row[2] ?? null,
                        'satuan' => $row[3] ?? null,
                        'validasi_isi' => $row[2] || $row[3] == null ? 'Sesuai' : 'Tidak Sesuai',
                        'total' => $subtotal,
                        'kro_id' => $kro->id,
                        'ro_id' => $ro->id,
                        'program_id' => $program->id,
                        'activity_id' => $activity->id,
                        'satker_id' => $satker->id
                    ];
                    if (Auth::user()->role == "regency") {
                        $data['regency_budget_request_id'] = $this->id;
                    } elseif (Auth::user()->role == "province") {
                        $data['province_budget_request_id'] = $this->id;
                    } elseif (Auth::user()->role == "departement") {
                        $data['departement_budget_request_id'] = $this->id;
                    }else {
                        $data['division_budget_request_id'] = $this->id;
                        
                    }
                    $komponen = Component::create($data);    
                }                
                // Process Point (length 1)
                elseif (isset($row[0]) && strlen(trim($row[0])) == 1 && ctype_alpha(trim($row[0]))) {
                    if ($currentkomponenIndex >= 0) {
                        $currentPointIndex++;
                        $currentDetailIndex = -1;
                        $subKomponen = $komponen->subKomponen()->create([
                            'sub_component_code' => $row[0],
                            'sub_component_name' => $row[1] ?? null,
                            'total' => $row[6] ?? 0,
                            'validasi_total' => $row[6] == null || $row[6] == 0 ? 'Tidak Sesuai' : 'Sesuai',
                        ]);
                    }
                }
                
                // Process Detail (length 6)
                elseif (isset($row[0]) && strlen(trim($row[0])) == 6) {
                    if ($currentPointIndex >= 0) {
                        $currentDetailIndex++;
                        $currentKppnIndex = -1;
                        $poinSubKomponen = $subKomponen->poinSubComponent()->create([
                            'point_sub_component_code' => $row[0],
                            'point_sub_component_name' => $row[1] ?? null,
                            'total' => $row[6] ?? 0,
                            'validasi_total' => $row[6] == null || $row[6] == 0 ? 'Tidak Sesuai' : 'Sesuai',
                        ]);
                    }
                }
                
                // Process KPPN
                elseif (isset($row[1]) && substr($row[1], 0, 1) === '>') {
                    if ($currentDetailIndex >= 0) {
                        $currentKppnIndex++;
                        $currentKppnKategoriIndex = -1;
                        $wilayah = $poinSubKomponen->wilayah()->create([
                            'wilayah_name' => $row[1] ?? null,
                            'total' => $row[6] ?? 0,
                            'validasi_total' => $row[6] == null || $row[6] == 0 ? 'Tidak Sesuai' : 'Sesuai',
                        ]);
                    }
                }
                
                // Process KPPN Kategori
                elseif (isset($row[1]) && substr($row[1], 0, 1) === '-') {
                    if ($currentKppnIndex >= 0) {
                        $currentKppnKategoriIndex++;
                        $wilayah->subWilayah()->create([
                            'sub_wilayah_name' => $row[1] ?? null,
                            'qty' => $row[2] ?? null,
                            'satuan' => $row[3] ?? null,
                            'sub_total' => $row[5] ?? null,
                            'validasi_isi' => $row[2] || $row[3] == null ? 'Sesuai' : 'Tidak Sesuai',
                            'verifikasi' =>(float) $row[2] * (float)$row[5],
                            'validasi_total' => (float)$row[6] == (float)$row[2] * (float)$row[5] ? 'Sesuai' : 'Tidak Sesuai',
                            'total' => $row[6] ?? 0,
                        ]);
                    }
                }
            }
            $index++;
        }
        
        return $komponen;
        // dd($komponen);
    }

    public function getTotal(){  
        return $this->total;  
    }  
}
