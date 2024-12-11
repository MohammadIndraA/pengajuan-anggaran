<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Component;
use App\Models\Departement;
use App\Models\FundingSource;
use App\Models\Kro;
use App\Models\Program;
use App\Models\Province;
use App\Models\RegencyCity;
use App\Models\Ro;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $jsonDataProvinsi = json_decode(file_get_contents(public_path('json/provinsi.json')), true);  
        $jsonDataKabupatenKota = json_decode(file_get_contents(public_path('json/kabupaten_kota.json')), true);  
        
        echo "Memulai proses seeder data Provinsi...\n";  
        foreach ($jsonDataProvinsi as $value) {  
            Province::create([  
                'id' => $value['id'],  
                'name' => $value['name'],  
            ]);  
        }  
        echo "Selesai seeder data Provinsi...\n";  
        echo "\n";  
        
        echo "Memulai proses seeder data Kabupaten/Kota...\n";  
        foreach ($jsonDataKabupatenKota as $value) {  
            RegencyCity::create([  
                'id' => $value['id'],  
                'name' => ucfirst($value['type']) .' '. ucfirst($value['name']),  
                'province_id' => $value['provinsi_id']  
            ]);  
        }  
        echo "Selesai seeder data Kabupaten/Kota...\n";  
        echo "\n";

        // // departement

        // $departemen = [ ['departement_code' => 1, 'departement_name' => 'HR'],
        //  ['departement_code' => 2, 'departement_name' => 'Finance'],
        //  ['departement_code' => 3, 'departement_name' => 'IT'],
        //  ['departement_code' => 4, 'departement_name' => 'Marketing'],
        //  ['departement_code' => 5, 'departement_name' => 'Sales'],
        //  ['departement_code' => 6, 'departement_name' => 'HR'],
        //  ['departement_code' => 7, 'departement_name' => 'Finance'],
        //  ['departement_code' => 8, 'departement_name' => 'IT'],
        //  ['departement_code' => 9, 'departement_name' => 'Marketing'],
        //  ['departement_code' => 10, 'departement_name' => 'Sales'],
        //  ];

        //   // Iterasi untuk membuat data
        // echo "Memulai proses seeder data Departemen...\n";
        // foreach ($departemen as $dp) {
        //     Departement::create($dp);
        // }
        // echo "Done seeder data Departemen...\n";



        // Tabel User
        
        $roles = ['division', 'pusat', 'province', 'regency', 'departement'];  

        echo "Memulai proses seeder data User...\n";
        foreach ($roles as $role) {  
            User::factory()->create([  
                'name' => $role,  
                'username' => $role,  
                'region' => fake()->address(),
                'email' => $role . '@mail.com',  
                'password' => Hash::make($role),  
                'role' => $role,
                'province_id' => 9,
               'regency_city_id' => $role === 'province' ? null : 291,
            ]);  
        }  

    //     $regens = RegencyCity::where('province_id', 9)->get();

    //     foreach ($regens as $regen) {
    //         User::create([
    //             'name' => $regen->name,
    //             'username' => $regen->name,
    //             'region' => fake()->address(),
    //             'email' => str_replace(' ', '', $regen->name) . '@mail.com',
    //             'password' => Hash::make('password'),
    //             'email_verified_at' => now(),
    //             'role' => 'regency',
    //             'province_id' => 9,
    //             'regency_city_id' => $regen->id,
    //             'remember_token' => Str::random(10),
    //         ]);
    //     }

    //     echo "Done seeder data User...\n";


    //     // Tabel Program
    //     echo "Memulai proses seeder data Program...\n";
    //     Program::create([
    //         'program_code' => '02509DC',
    //         'program_name' => 'Program Kerukunan Umat dan Layanan Kehidupan Beragama',
    //     ]);
    //     Program::create([
    //         'program_code' => '02509WA',
    //         'program_name' => 'Program Dukungan Manajemen',
    //     ]);
    //     echo "Done seeder data Program...\n";

    //         // Data Activity
    //     $activityData = [
    //         ['activity_code' => '2126', 'activity_name' => 'Pembinaan Umrah dan Haji Khusus'],
    //         ['activity_code' => '2147', 'activity_name' => 'Pelayanan Haji Dalam Negeri'],
    //         ['activity_code' => '2148', 'activity_name' => 'Pembinaan Haji'],
    //         ['activity_code' => '2149', 'activity_name' => 'Pengelolaan Dana Haji dan Sistem Informasi Haji'],
    //         ['activity_code' => '5310', 'activity_name' => 'Pelayanan Haji Luar Negeri'],
    //         ['activity_code' => '2150', 'activity_name' => 'Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya Penyelenggaraan Haji dan Umrah'],
    //     ];

    //     // Iterasi untuk membuat data
    //     echo "Memulai proses seeder data Activity...\n";
    //     foreach ($activityData as $activity) {
    //         Activity::create($activity);
    //     }
    //     echo "Done seeder data Activity...\n";

      
    //     // Data KRO
    //     $kroData = [
    //         ['kro_code' => '2126QDB', 'kro_name' => 'Fasilitasi dan Pembinaan Lembaga'],
    //         ['kro_code' => '2147QAA', 'kro_name' => 'Pelayanan Publik kepada masyarakat'],
    //         ['kro_code' => '2147QAH', 'kro_name' => 'Pelayanan Publik Lainnya'],
    //         ['kro_code' => '2148QDC', 'kro_name' => 'Fasilitasi dan Pembinaan Masyarakat'],
    //         ['kro_code' => '2149QMA', 'kro_name' => 'Data dan Informasi Publik'],
    //         ['kro_code' => '2149UAH', 'kro_name' => 'Pengelolaan Keuangan Negara'],
    //         ['kro_code' => '5310QDC', 'kro_name' => 'Fasilitasi dan Pembinaan Masyarakat'],
    //         ['kro_code' => '2150EBA', 'kro_name' => 'Layanan Dukungan Manajemen Internal'],
    //         ['kro_code' => '2150EBC', 'kro_name' => 'Layanan Manajemen SDM Internal'],
    //         ['kro_code' => '2150EBD', 'kro_name' => 'Layanan Manajemen Kinerja Internal'],
    //     ];

    //     // Iterasi untuk membuat data
    //     echo "Memulai proses seeder data KRO...\n";
    //     foreach ($kroData as $kro) {
    //         Kro::create($kro);
    //     }
    //     echo "Done seeder data KRO...\n";


    //    // Data RO
    //     $roData = [
    //         ['ro_code' => '2126QDB001', 'ro_name' => 'Lembaga Penyelenggara Ibadah Umrah yang Terbina'],
    //         ['ro_code' => '2126QDB002', 'ro_name' => 'Lembaga Penyelenggara Ibadah Haji Khusus yang Terbina'],
    //         ['ro_code' => '2147QAA001', 'ro_name' => 'Layanan Administrasi Haji Dalam Negeri'],
    //         ['ro_code' => '2147QAH001', 'ro_name' => 'Asrama Haji yang Profesional Melayani'],
    //         ['ro_code' => '2147QAH002', 'ro_name' => 'Pusat Layanan Haji dan Umrah Terpadu yang Profesional Melayani'],
    //         ['ro_code' => '2148QAH001', 'ro_name' => 'Advokasi Haji'],
    //         ['ro_code' => '2148QDC001', 'ro_name' => 'Petugas Haji yang Profesional'],
    //         ['ro_code' => '2149QMA001', 'ro_name' => 'Sistem Informasi Haji yang Handal'],
    //         ['ro_code' => '2149UAH001', 'ro_name' => 'Laporan Keuangan Haji yang Akuntabel'],
    //         ['ro_code' => '5310QDC001', 'ro_name' => 'Layanan Administrasi Haji Luar Negeri'],
    //         ['ro_code' => '2150EBA956', 'ro_name' => 'Layanan BMN'],
    //         ['ro_code' => '2150EBA957', 'ro_name' => 'Layanan Hukum'],
    //         ['ro_code' => '2150EBA958', 'ro_name' => 'Layanan Hubungan Masyarakat'],
    //         ['ro_code' => '2150EBA959', 'ro_name' => 'Layanan Protokoler'],
    //         ['ro_code' => '2150EBA960', 'ro_name' => 'Layanan Organisasi dan Tata Kelola Internal'],
    //         ['ro_code' => '2150EBA962', 'ro_name' => 'Layanan Umum'],
    //         ['ro_code' => '2150EBA994', 'ro_name' => 'Layanan Perkantoran'],
    //         ['ro_code' => '2150EBB951', 'ro_name' => 'Layanan Sarana Internal'],
    //         ['ro_code' => '2150EBC954', 'ro_name' => 'Layanan Manajemen SDM'],
    //         ['ro_code' => '2150EBD952', 'ro_name' => 'Layanan Perencanaan dan Penganggaran'],
    //         ['ro_code' => '2150EBD953', 'ro_name' => 'Layanan Pemantauan dan Evaluasi'],
    //         ['ro_code' => '2150EBD955', 'ro_name' => 'Layanan Manajemen Keuangan'],
    //     ];

    //     // Iterasi untuk membuat data
    //     echo "Memulai proses seeder data RO...\n";
    //     foreach ($roData as $ro) {
    //         Ro::create($ro);
    //     }
    //     echo "Done seeder data RO...\n";


    //     // Unit
    //     echo "Memulai proses seeder data Funding Source...\n";
    //      FundingSource::create([
    //         'funding_source_code' => 'FS'. random_int(5,6),
    //         'funding_source_name' => 'RM',
    //     ]);
    //     FundingSource::create([
    //         'funding_source_code' =>'FS'. random_int(5,6),
    //         'funding_source_name' => 'PNBP',
    //     ]);
    //     echo "Done seeder data Funding Source...\n";

    //     // Unit
    //     echo "Memulai proses seeder data Unit...\n";
    //     Unit::create([
    //         'unit_code' => 'UT'. random_int(5,6),
    //         'unit_name' => 'Lembaga',
    //     ]);
    //     echo "Done seeder data Unit...\n";

    //     // komponent
    //   $componentsData = [ 
    //     ['component_code' => '2126QDB001051','component_name' => 'Pengelolaan Perizinan Penyelenggara Perjalanan Ibadah Umrah'],
    //      ['component_code' => '2126QDB001052','component_name' => 'Akreditasi Penyelenggara Perjalanan Ibadah Umrah',
    //         ],
    //      ['component_code' => '2126QDB001053','component_name' => 'Pembinaan Penyelenggara Perjalanan Ibadah Umrah',],
    //      ['component_code' => '2126QDB001054','component_name' => 'Pemantauan dan Pengawasan Penyelenggara Perjalanan Ibadah Umrah',],
    //      ['component_code' => '2126QDB001055','component_name' => 'Identifikasi dan Pemetaan Masalah Penyelenggara Perjalanan Ibadah Umrah',],
    //      ['component_code' => '2126QDB001056','component_name' => 'Penanganan Masalah Penyelenggara Perjalanan Ibadah Umrah',],
    //      ['component_code' => '2126QDB002051','component_name' => 'Pengelolaan Perizinan Penyelenggara Ibadah Haji Khusus',],
    //      ['component_code' => '2126QDB002052','component_name' => 'Akreditasi Penyelenggara Ibadah Haji Khusus',],
    //      ['component_code' => '2126QDB002053','component_name' => 'Pendaftaran dan Pembatalan Haji Khusus',],
    //      ['component_code' => '2126QDB002054','component_name' => 'Dokumen dan Perlengkapan Ibadah Haji Khusus',],
    //      ['component_code' => '2126QDB002055','component_name' => 'Pembinaan dan Peningkatan Kualitas Penyelenggara Ibadah Haji Khusus',],
    //      ['component_code' => '2126QDB002056','component_name' => 'Pemantauan dan Pengawasan Penyelenggara Ibadah Haji Khusus',],
    //      ['component_code' => '2126QDB002057','component_name' => 'Identifikasi dan Pemetaan Masalah Penyelenggara Ibadah Haji Khusus',],
    //      ['component_code' => '2126QDB002058','component_name' => 'Penanganan Masalah Penyelenggara Ibadah Haji Khusus',],
    //      ['component_code' => '2147QAA001051','component_name' => 'Penyempurnaan Kebijakan Pendaftaran dan Pembatalan Haji Reguler',],
    //      ['component_code' => '2147QAA001052','component_name' => 'Sosialisasi Kebijakan Pendaftaran dan Pembatalan Haji reguler',],
    //      ['component_code' => '2147QAA001053','component_name' => 'Pengelolaan Pelayanan Pendaftaran dan Pembatalan Haji Reguler',],
    //      ['component_code' => '2147QAA001054','component_name' => 'Konsolidasi dan Verifikasi Data Jemaah Haji Reguler',],
    //      ['component_code' => '2147QAA001055','component_name' => 'Sosialisasi/Orientasi Penyelesaian Dokumen dan Perlengkapan Haji',],
    //      ['component_code' => '2147QAA001056','component_name' => 'Pengelolaan Pelayanan Pemvisaan Haji',],
    //      ['component_code' => '2147QAA001057','component_name' => 'Penyelesaian Dokumen/Perlengkapan Jemaah Haji di Tingkat Kab/Kota',],
    //      ['component_code' => '2147QAA001058','component_name' => 'Penyelesaian Dokumen/Perlengkapan Jemaah Haji di Tingkat Provinsi',],
    //      ['component_code' => '2147QAA001059','component_name' => 'Penyelesaian Dokumen/Perlengkapan Jemaah Haji di Tingkat Pusat',],
    //      ['component_code' => '2147QAA001060','component_name' => 'Penyiapan Transportasi Udara Jemaah Haji',],
    //      ['component_code' => '2147QAA001061','component_name' => 'Penyusunan dan Pembahasan Asuransi Haji',],
    //      ['component_code' => '2147QAA001062','component_name' => 'Konsolidasi dan Verifikasi Data Angkutan Udara Jemaah Haji',],
    //      ['component_code' => '2147QAA001063','component_name' => 'Pelayanan Pemberangkatan/Pemulangan Jemaah',],
    //      ['component_code' => '2147QAH001051','component_name' => 'Penyiapan Asrama Haji',],
    //      ['component_code' => '2147QAH001052','component_name' => 'Pelayanan Asrama Haji',],
    //      ['component_code' => '2147QAH001053','component_name' => 'Revitalisasi dan Pengembangan Asrama Haji',],
    //      ['component_code' => '2147QAH001054','component_name' => 'Monitoring dan Evaluasi Asrama Haji',],
    //      ['component_code' => '2147QAH002051','component_name' => 'Revitalisasi dan Pembangunan Pusat Layanan Haji dan Umrah Terpadu',],
    //      ['component_code' => '2147QAH002052','component_name' => 'Pengelolaaan Pusat Layanan Haji dan Umrah Terpadu',],
    //      ['component_code' => '2148QAH001051','component_name' => 'Identifikasi dan Pemetaan Masalah Haji',],
    //      ['component_code' => '2148QAH001052','component_name' => 'Penanganan Masalah Haji',],
    //      ['component_code' => '2148QDC001051','component_name' => 'Rekrutmen/Seleksi PPIH Kloter',],
    //      ['component_code' => '2148QDC001052','component_name' => 'Rekrutmen/Seleksi PPIH Non Kloter',],
    //      ['component_code' => '2148QDC001053','component_name' => 'Rekrutmen/Seleksi PPIH Tenaga Musiman',],
    //      ['component_code' => '2148QDC001054','component_name' => 'Rekrutmen/Seleksi Petugas TPHD',],
    //      ['component_code' => '2148QDC001055','component_name' => 'Dokumen dan Perlengkapan PPIH Kloter',],
    //      ['component_code' => '2148QDC001056','component_name' => 'Dokumen dan Perlengkapan PPIH Non Kloter',],
    //      ['component_code' => '2148QDC001057','component_name' => 'Dokumen dan Perlengkapan PPIH Tenaga Musiman',],
    //      ['component_code' => '2148QDC001058','component_name' => 'Dokumen dan Perlengkapan PPIH Embarkasi',],
    //      ['component_code' => '2148QDC001059','component_name' => 'Dokumen dan Perlengkapan PPIH Embarkasi Antara',],
    //      ['component_code' => '2148QDC001060','component_name' => 'Dokumen dan Perlengkapan PPIH Embarkasi Transit',],
    //      ['component_code' => '2148QDC001061','component_name' => 'Pelatihan dan pembekalan PPIH Kloter',],
    //      ['component_code' => '2148QDC001062','component_name' => 'Pelatihan dan pembekalan PPIH Non Kloter',],
    //      ['component_code' => '2148QDC001063','component_name' => 'Pelatihan dan pembekalan PPIH Tenaga Musiman',],
    //      ['component_code' => '2148QDC001064','component_name' => 'Operasional PPIH Kloter',],
    //      ['component_code' => '2148QDC001065','component_name' => 'Operasional PPIH Non Kloter',],
    //      ['component_code' => '2148QDC001066','component_name' => 'Operasional PPIH Tenaga Musiman',],
    //      ['component_code' => '2148QDC001067','component_name' => 'Operasional PPIH Embarkasi',],
    //      ['component_code' => '2148QDC001068','component_name' => 'Operasional PPIH Embarkasi Antara',],
    //      ['component_code' => 'Operasional' , "component_name"=>'PPIH Embarkasi Transit'],
    //     ['component_code' => '2148QDC001070','component_name' => 'Akomodasi PPIH Kloter',],
    //      ['component_code' => '2148QDC001071','component_name' => 'Akomodasi PPIH Non Kloter',],
    //      ['component_code' => '2148QDC001072','component_name' => 'Akomodasi PPIH Tenaga Musiman',],
    //      ['component_code' => '2148QDC001073','component_name' => 'Konsumsi PPIH Kloter',],
    //      ['component_code' => '2148QDC001074','component_name' => 'Konsumsi PPIH Non Kloter',],
    //      ['component_code' => '2148QDC001075','component_name' => 'Konsumsi PPIH Tenaga Musiman',],
    //      ['component_code' => '2148QDC001076','component_name' => 'Transportasi PPIH Kloter',],
    //      ['component_code' => '2148QDC001077','component_name' => 'Transportasi PPIH Non Kloter',],
    //      ['component_code' => '2148QDC001078','component_name' => 'Transportasi PPIH Tenaga Musiman',],
    //      ['component_code' => '2148QDC001079','component_name' => 'Evaluasi Teknis Petugas Panitia Penyelenggara Ibadah Haji Arab Saudi',],
    //      ['component_code' => '2148QDC001080','component_name' => 'Koordinasi Penyelenggaraan Ibadah Haji Luar Negeri',],
    //      ['component_code' => '2148QDC002051','component_name' => 'Bimbingan Jemaah Haji Reguler',],
    //      ['component_code' => '2148QDC002052','component_name' => 'Sertifikasi penyuluh dan pembimbing manasik haji',],
    //      ['component_code' => '2148QDC002053','component_name' => 'Pembinaan kelompok bimbingan',],
    //      ['component_code' => '2149QMA001051','component_name' => 'Pengelolaan Infrastruktur',],
    //      ['component_code' => '2149QMA001052','component_name' => 'Pengembangan Database Haji',],
    //      ['component_code' => '2149QMA001053','component_name' => 'Pengembangan Sistem Informasi Haji',],
    //      ['component_code' => '2149UAH001051','component_name' => 'Perencanaan Anggaran Operasional Haji',],
    //      ['component_code' => '2149UAH001052','component_name' => 'Pengelolaan Aset Haji',],
    //      ['component_code' => '2149UAH001053','component_name' => 'Monitoring dan Evaluasi Anggaran Operasional Haji',],
    //      ['component_code' => '2149UAH001054','component_name' => 'Pelaksanaan Anggaran dan Perbendaharaan Haji',],
    //      ['component_code' => '2149UAH001056','component_name' => 'Pelaporan Keuangan Operasional Haji',],
    //      ['component_code' => '5310QDC001051','component_name' => 'Seleksi Perusahaan Penyedia Akomodasi Jemaah Haji Indonesia di Arab Saudi',],
    //      ['component_code' => '5310QDC001052','component_name' => 'Seleksi Perusahaan Penyedia Konsumsi Jemaah Haji Indonesia di Arab Saudi',],
    //      ['component_code' => '5310QDC001053','component_name' => 'Seleksi Perusahaan Penyedia Transportasi Jemaah Haji Indonesia di Arab Saudi',],
    //      ['component_code' => '2150EBA956051','component_name' => 'Pengelolaan BMN dan Perlengkapan',],
    //      ['component_code' => '2150EBA957051','component_name' => 'Layanan Hukum dan Peraturan Perundang-Undangan',],
    //      ['component_code' => '2150EBA957052','component_name' => 'Penyelesaian Tindak Lanjut Hasil Temuan Pemeriksaan',],
    //      ['component_code' => '2150EBA958051','component_name' => 'Pameran/event penyelenggaraan haji/umrah',],
    //      ['component_code' => '2150EBA958052','component_name' => 'Pengelolaan Media Publikasi Informasi Haji dan Umrah',],
    //      ['component_code' => '2150EBA958053','component_name' => 'Penyebaran Informasi Haji dan Umrah',],
    //      ['component_code' => '2150EBA959051','component_name' => 'Pelayanan Protokoler',],
    //      ['component_code' => '2150EBA960051','component_name' => 'Pelayanan Organisasi, Tata Laksana, dan Reformasi Birokrasi',],
    //      ['component_code' => '2150EBA962051','component_name' => 'Rapat Kerja Nasional Penyelenggaraan Haji',],
    //      ['component_code' => '2150EBA962052','component_name' => 'Koordinasi penyelenggaraan ibadah haji',],
    //      ['component_code' => '2150EBA962053','component_name' => 'Pelayanan Umum dan Rumah Tangga',],
    //      ['component_code' => '2150EBA962054','component_name' => 'Pengelolaan Ketatausahaan',],
    //      ['component_code' => '2150EBA962055','component_name' => 'Layanan Dukungan Manajemen Eselon II',],
    //      ['component_code' => '2150EBA994001','component_name' => 'Gaji dan Tunjangan',],
    //      ['component_code' => '2150EBA994002','component_name' => 'Operasional dan Pemeliharaan Kantor',],
    //      ['component_code' => '2150EBB951051','component_name' => 'Pengadaan Perangkat Pengolah Data dan Komunikasi',],
    //      ['component_code' => '2150EBB951052','component_name' => 'Pengadaan Peralatan dan Fasilitas Perkantoran',],
    //      ['component_code' => '2150EBB951053','component_name' => 'Pengadaan Kendaraan Bermotor',],
    //      ['component_code' => '2150EBB951054','component_name' => 'Pembangunan/Renovasi gedung dan bangunan',],
    //      ['component_code' => '2150EBC954051','component_name' => 'Pengelolaan Kepegawaian',],
    //      ['component_code' => '2150EBD952051','component_name' => 'Penyusunan Perencanaan Program dan Anggaran',],
    //      ['component_code' => '2150EBD952052','component_name' => 'Pengelolaan Rencana Program dan Anggaran',],
    //      ['component_code' => '2150EBD953051','component_name' => 'Evaluasi dan Pelaporan Program',],
    //      ['component_code' => '2150EBD955051','component_name' => 'Pelaksananaan Anggaran dan Perbendaharaan',],
    //      ['component_code' => '2150EBD955052','component_name' => 'Verifikasi Anggaran dan Perbendaharaan',],
    //      ['component_code' => '2150EBD955053','component_name' => 'Layanan Administrasi PNBP',],
    //      ['component_code' => '2150EBD955054','component_name' => 'Pengelolaan PNBP',],
    //      ['component_code' =>'2150EBD955055','component_name' => 'Pengelolaan Laporan Keuangan',]
    // ];

    //     // Iterasi untuk membuat data 
    //     echo "Memulai proses seeder data Component...\n";
    //     foreach ($componentsData as $cp) { 
    //         Component::create($cp);
    //      }
    //     echo "Done seeder data Component...\n";

    }
}
