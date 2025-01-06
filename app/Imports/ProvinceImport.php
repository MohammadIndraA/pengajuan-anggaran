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
    protected $total = 0;

    public function __construct($id)  
    {  
        $this->id = $id;  
    }  

    public function collection(Collection $collection)
    {
        // Check if collection is empty
        if ($collection->isEmpty()) {
            return null;
        }

        // Buat Satker
        $satker = Satker::create([
            'wilayah_name' => $collection[0][1],
            'wilayah_total' => $collection[0][6],
            'satker_name' => $collection[2][1],
            'satker_total' => $collection[2][6] ?? 0,
        ]);
        $this->total += $collection[0][6];

        // Buat Program
        $program = Program::create([
            'program_code' => $collection[3][0],
            'program_name' => $collection[3][1],
            'total' => $collection[3][6] ?? 0,
        ]);

        // Buat Activity
        $activity = Activity::create([
            'activity_code' => $collection[4][0],
            'activity_name' => $collection[4][1],
            'total' => $collection[4][6] ?? 0
        ]);

        // Buat Kro
        $kro = Kro::create([
            'kro_code' => $collection[5][0],
            'kro_name' => $collection[5][1],
            'qty' => $collection[5][2] ?? null,  
            'satuan' => $collection[5][3] ?? null,  
            'validasi_isi' => $collection[5][2] == null || trim($collection[5][3]) == '-' || 
                            trim($collection[5][2]) == '-' || $collection[5][3] == null ? 'Tidak Sesuai' : 'Sesuai',  
            'total' => $collection[5][6] ?? 0,
        ]);

        // Buat Ro
        $ro = Ro::create([
            'ro_code' => $collection[6][0],
            'ro_name' => $collection[6][1],
            'qty' => $collection[6][2] ?? null,  
            'satuan' => $collection[6][3] ?? null,  
            'validasi_isi' => $collection[6][2] == null || trim($collection[6][2]) == '-' || 
                            trim($collection[6][3]) == '-' || $collection[6][3] == null ? 'Tidak Sesuai' : 'Sesuai',  
            'total' => $collection[6][6] ?? 0,
        ]);

        $currentkomponenIndex = -1;
        $currentPointIndex = -1;
        $currentSubKomponenIndex = -1;
        $currentWilayahIndex = -1;
        $lastWilayah = null;
        $komponen = null;
        $subKomponen = null;
        $poinSubKomponen = null;

        // Start processing from the beginning of the collection
        foreach ($collection as $index => $row) {
            // Skip empty rows
            if (empty($row[0]) && empty($row[1])) {
                continue;
            }

            // Process Komponen
            if (isset($row[0]) && (strlen(trim($row[0])) == 1 || strlen(trim($row[0])) == 2) && is_numeric(trim($row[0]))) {
                $currentkomponenIndex++;
                $componentData = [
                    'component_code' => $row[0],
                    'component_name' => $row[1] ?? null,
                    'qty' => $row[2] ?? null,
                    'satuan' => $row[3] ?? null,
                    'validasi_isi' => $row[2] || $row[3] == null || trim($row[6]) == '-' ? 'Sesuai' : 'Tidak Sesuai',
                    'total' => $row[6],
                    'kro_id' => $kro->id,
                    'ro_id' => $ro->id,
                    'program_id' => $program->id,
                    'activity_id' => $activity->id,
                    'satker_id' => $satker->id,
                    'budget_request_id' => $this->id,
                ];

                // Set the appropriate budget request ID based on user role
                if (Auth::user()->role == "regency") {
                    $componentData['regency_budget_request_id'] = $this->id;
                } elseif (Auth::user()->role == "province") {
                    $componentData['province_budget_request_id'] = $this->id;
                } elseif (Auth::user()->role == "departement") {
                    $componentData['departement_budget_request_id'] = $this->id;
                } else {
                    $componentData['division_budget_request_id'] = $this->id;
                }
                $komponen = Component::create($componentData);
            }
            // Process Sub Komponen
            elseif (isset($row[0]) && strlen(trim($row[0])) == 1 && ctype_alpha(trim($row[0]))) {
                if ($currentkomponenIndex >= 0) {
                    $currentSubKomponenIndex++;
                    $subKomponen = $komponen->subKomponen()->create([
                        'sub_component_code' => $row[0],
                        'sub_component_name' => $row[1] ?? null,
                        'total' => $row[6] ?: 0,
                        'validasi_total' => $row[6] == null || $row[6] == 0 || trim($row[6]) == '-' ? 'Tidak Sesuai' : 'Sesuai',
                    ]);
                    $poinSubKomponen = null;
                }
            }
            // Process Poin Sub Komponen
            elseif (isset($row[0]) && strlen(trim($row[0])) == 6) {
                if ($currentSubKomponenIndex >= 0) {
                    $currentPointIndex++;
                    $poinSubKomponen = $subKomponen->poinSubComponent()->create([
                        'point_sub_component_code' => $row[0],
                        'point_sub_component_name' => $row[1] ?? null,
                        'total' => $row[6] ?: 0,
                        'validasi_total' => ($row[6] == null || $row[6] == 0 || trim($row[6]) == '-') ? 'Tidak Sesuai' : 'Sesuai',
                    ]);
                }
            }
            // Process Wilayah
            elseif (isset($row[1]) && substr(trim($row[1]), 0, 1) === '>') {
                if (isset($poinSubKomponen) && $currentPointIndex >= 0) {
                    $lastWilayah = $poinSubKomponen->wilayah()->create([
                        'wilayah_name' => $row[1],
                        'total' => $row[6] ?: 0,
                        'validasi_total' => ($row[6] == null || $row[6] == 0 || trim($row[6]) == '-') ? 'Tidak Sesuai' : 'Sesuai',
                    ]);
                }
            }
            // Process Sub Wilayah
            elseif (isset($row[1]) && substr(trim($row[1]), 0, 1) === '-') {
                $subWilayahData = [
                    'sub_wilayah_name' => $row[1],
                    'qty' => $row[2] ?? null,
                    'satuan' => $row[3] ?? null,
                    'sub_total' => $row[5] ?? null,
                    'validasi_isi' => $row[2] == null || $row[3] == null || trim($row[2]) == '-' || trim($row[3]) == '-' ? 'Tidak Sesuai' : 'Sesuai',
                    'verifikasi' => (float)($row[2] ?? 0) * (float)($row[5] ?? 0),
                    'validasi_total' => ((float)($row[6] ?? 0) == (float)($row[2] ?? 0) * (float)($row[5] ?? 0)) || $row[6] == '-' ? 'Sesuai' : 'Tidak Sesuai',
                    'total' => $row[6] ?: 0,
                ];

                if ($lastWilayah) {
                    $lastWilayah->subWilayah()->create($subWilayahData);
                } elseif (isset($poinSubKomponen)) {
                    $poinSubKomponen->subWilayahComponent()->create($subWilayahData);
                }
            }
        }

        return $komponen;
    }

    public function getTotal()
    {
        return $this->total;
    }
}
