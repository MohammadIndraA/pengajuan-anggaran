<?php

namespace App\Imports;

use App\Models\Activity;
use App\Models\Budget;
use App\Models\Component;
use App\Models\Kro;
use App\Models\PointSubComponent;
use App\Models\Program;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\RegencyImport as ModelRegencyImport;
use App\Models\Ro;
use App\Models\SubComponent;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;

class RegencyImport implements ToCollection
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

        // Buat Program
        $program = Program::create([
            'program_code' => $collection[0][0],
            'program_name' => $collection[0][3],
        ]);

        // Buat atau Perbarui Activity
        $activity = Activity::updateOrCreate(
            ['activity_code' => $collection[1][0]],
            ['activity_name' => $collection[1][3]]
        );

        // Buat atau Perbarui Kro
        $kro = Kro::updateOrCreate(
            ['kro_code' => $collection[2][0]],
            ['kro_name' => $collection[2][3]]
        );

        // Buat atau Perbarui Ro
        $ro = Ro::updateOrCreate(
            ['ro_code' => $collection[4][0]],
            ['ro_name' => $collection[4][3]]
        );

        $prog = Budget::create([
            'budget' => $collection[0][9],
            'program_id' => $program->id,
        ]);
        $this->total += $prog->budget;

       $ac = Budget::create([
            'budget' => $collection[1][9],
            'activity_id' => $activity->id,
        ]);
        $this->total+= $ac->budget;

       $kr = Budget::create([
            'budget' => $collection[2][9],
            'kro_id' => $kro->id,
        ]);
        $this->total+= $kr->budget;


       $r =  Budget::create([
            'budget' => $collection[4][9],
            'ro_id' => $ro->id,
        ]);
        $this->total+= $r->budget;


        $index = 5;
        $currentSubkomponen = null;
        $currentPoint = null;
        $currentDetail = null;
        $currentKppn = null;
        $currentKppnKategori = null;
    
        foreach ($collection as $row) {
            if ($index > 5) {
                // Process Subkomponen
                if (isset($row[0]) && strlen(trim($row[0])) == 3) {
                    $currentSubkomponenData = [
                        'sub_component_code' => $row[0],
                        'sub_component_name' => $row[3] ?? null,
                        'budget' => $row[9] ?? null,
                        'komponen_utama' => $row[10] ?? null,
                        'satuan' => $row[11] ?? null,
                        'kro_id' => $kro->id,
                        'ro_id' => $ro->id,
                        'program_id' => $program->id,
                        'activity_id' => $activity->id,
                    ];
                    
                    if (Auth::user()->role == "regency") {
                        $currentSubkomponenData['regency_budget_request_id'] = $this->id;
                    } elseif (Auth::user()->role == "province") {
                        $currentSubkomponenData['province_budget_request_id'] = $this->id;
                    } elseif (Auth::user()->role == "departement") {
                        $currentSubkomponenData['departement_budget_request_id'] = $this->id;
                    }else {
                        $currentSubkomponenData['division_budget_request_id'] = $this->id;
                        
                    }
                    
                    $currentSubkomponen = SubComponent::create($currentSubkomponenData);
                    
                }
                
                // Process Point
                elseif (isset($row[0]) && strlen(trim($row[0])) == 1 && $currentSubkomponen) {
                    $currentPoint = $currentSubkomponen->points()->create([
                        'point_sub_component_code' => $row[0],
                        'point_sub_component_name' => $row[3] ?? null,
                        'budget' => $row[9] ?? null,
                        // 'sub_component_id' => $currentSubkomponen->id,
                    ]);
                }
                
                // Process Detail
                elseif (isset($row[0]) && strlen(trim($row[0])) == 6 && $currentPoint) {
                    $currentDetail = $currentPoint->details()->create([
                        'sub_poin_sub_component_code' => $row[0],
                        'sub_poin_sub_component_name' => $row[3] ?? null,
                        'budget' => $row[9] ?? null,
                        'komponen_utama' => $row[10] ?? null,
                        'sumber_dana' => $row[11] ?? null,
                        // 'point_sub_component_id' => $currentPoint->id,
                    ]);
                }
                
                // Process KPPN
                elseif (isset($row[3]) && str_starts_with(trim($row[3]), '(KPPN') && $currentDetail) {
                    $currentKppn = $currentDetail->kppns()->create([
                        'kppn_name' => $row[3] ?? null,
                        // 'sub_poin_sub_components' => $currentDetail->id,
                    ]);
                }
                
                // Process KPPN Kategori
                elseif (isset($row[3]) && in_array(trim($row[3]), ['>', ' >', '> ', ' > ']) && $currentKppn) {
                    $currentKppnKategori = $currentKppn->kppnKategoris()->create([
                        'point_kppn_name' => $row[4] ?? null,
                        'subtotal' => $row[9] ?? null,
                        // 'kppn_id' => $currentKppn->id,
                    ]);
                }
                
                // Process KPPN Detail
                elseif (isset($row[3]) && in_array(trim($row[3]), ['-', ' -', '- ', ' - ']) && $currentKppnKategori) {
                    $currentKppnKategori->kppnDetails()->create([
                        'sub_poin_sub_kppn_name' => $row[4] ?? null,
                        'satuan' => $row[6] ?? null,
                        'subtotal' => $row[7] ?? null,
                        'budget' => $row[9] ?? null,
                        // 'point_kppn_id' => $currentKppnKategori->id,
                    ]);
                }
                $this->total += (float) $row[9];
            }
            $index++;
        }
    }
    public function getTotal(){  
        return $this->total;  
    }  
}
