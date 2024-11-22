<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Component;
use App\Models\Departement;
use App\Models\Kro;
use App\Models\Program;
use App\Models\Province;
use App\Models\RegencyCity;
use App\Models\Ro;
use App\Models\Unit;
use App\Models\User;
use GuzzleHttp\Promise\Create;
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

        // Regency
        $regencyData = [
            ['name' =>"Kab. Simeulue"],
            ['name' =>"Kab. Aceh Singkil"],
            ['name' =>"Kab. Aceh Selatan"],
            ['name' =>"Kab. Aceh Tenggara"],
            ['name' =>"Kab. Aceh Timur"],
            ['name' =>"Kab. Aceh Tengah"],
            ['name' =>"Kab. Aceh Barat"],
            ['name' =>"Kab. Aceh Besar"],
            ['name' =>"Kab. Pidie"],
            ['name' =>"Kab. Bireuen"],
            ['name' =>"Kab. Aceh Utara"],
            ['name' =>"Kab. Aceh Barat Daya"],
            ['name' =>"Kab. Gayo Lues"],
            ['name' =>"Kab. Aceh Tamiang"],
            ['name' =>"Kab. Nagan Raya"],
            ['name' =>"Kab. Aceh Jaya"],
            ['name' =>"Kab. Bener Meriah"],
            ['name' =>"Kab. Pidie Jaya"],
            ['name' =>"Kota Banda Aceh"],
            ['name' =>"Kota Sabang"],
            ['name' =>"Kota Langsa"],
            ['name' =>"Kota Lhokseumawe"],
            ['name' =>"Kota Subulussalam"],
            ['name' =>"Kab. Nias"],
            ['name' =>"Kab. Mandailing Natal"],
            ['name' =>"Kab. Tapanuli Selatan"],
            ['name' =>"Kab. Tapanuli Tengah"],
            ['name' =>"Kab. Tapanuli Utara"],
            ['name' =>"Kab. Toba Samosir"],
            ['name' =>"Kab. Labuhan Batu"],
            ['name' =>"Kab. Asahan"],
            ['name' =>"Kab. Simalungun"],
            ['name' =>"Kab. Dairi"],
            ['name' =>"Kab. Karo"],
            ['name' =>"Kab. Deli Serdang"],
            ['name' =>"Kab. Langkat"],
            ['name' =>"Kab. Nias Selatan"],
            ['name' =>"Kab. Humbang Hasundutan"],
            ['name' =>"Kab. Pakpak Bharat"],
            ['name' =>"Kab. Samosir"],
            ['name' =>"Kab. Serdang Bedagai"],
            ['name' =>"Kab. Batu Bara"],
            ['name' =>"Kab. Padang Lawas Utara"],
            ['name' =>"Kab. Padang Lawas"],
            ['name' =>"Kab. Labuhan Batu Selatan"],
            ['name' =>"Kab. Labuhan Batu Utara"],
            ['name' =>"Kab. Nias Utara"],
            ['name' =>"Kab. Nias Barat"],
            ['name' =>"Kota Sibolga"],
            ['name' =>"Kota Tanjung Balai"],
            ['name' =>"Kota Pematang Siantar"],
            ['name' =>"Kota Tebing Tinggi"],
            ['name' =>"Kota Medan"],
            ['name' =>"Kota Binjai"],
            ['name' =>"Kota Padangsidimpuan"],
            ['name' =>"Kota Gunungsitoli"],
            ['name' =>"Kab. Kepulauan Mentawai"],
            ['name' =>"Kab. Pesisir Selatan"],
            ['name' =>"Kab. Solok"],
            ['name' =>"Kab. Sijunjung"],
            ['name' =>"Kab. Tanah Datar"],
            ['name' =>"Kab. Padang Pariaman"],
            ['name' =>"Kab. Agam"],
            ['name' =>"Kab. Lima Puluh Kota"],
            ['name' =>"Kab. Pasaman"],
            ['name' =>"Kab. Solok Selatan"],
            ['name' =>"Kab. Dharmasraya"],
            ['name' =>"Kab. Pasaman Barat"],
            ['name' =>"Kota Padang"],
            ['name' =>"Kota Solok"],
            ['name' =>"Kota Sawah Lunto"],
            ['name' =>"Kota Padang Panjang"],
            ['name' =>"Kota Bukittinggi"],
            ['name' =>"Kota Payakumbuh"],
            ['name' =>"Kota Pariaman"],
            ['name' =>"Kab. Kuantan Singingi"],
            ['name' =>"Kab. Indragiri Hulu"],
            ['name' =>"Kab. Indragiri Hilir"],
            ['name' =>"Kab. Pelalawan"],
            ['name' =>"Kab. S I A K"],
            ['name' =>"Kab. Kampar"],
            ['name' =>"Kab. Rokan Hulu"],
            ['name' =>"Kab. Bengkalis"],
            ['name' =>"Kab. Rokan Hilir"],
            ['name' =>"Kab. Kepulauan Meranti"],
            ['name' =>"Kota Pekanbaru"],
            ['name' =>"Kota D U M A I"],
            ['name' =>"Kab. Kerinci"],
            ['name' =>"Kab. Merangin"],
            ['name' =>"Kab. Sarolangun"],
            ['name' =>"Kab. Batang Hari"],
            ['name' =>"Kab. Muaro Jambi"],
            ['name' =>"Kab. Tanjung Jabung Timur"],
            ['name' =>"Kab. Tanjung Jabung Barat"],
            ['name' =>"Kab. Tebo"],
            ['name' =>"Kab. Bungo"],
            ['name' =>"Kota Jambi"],
            ['name' =>"Kota Sungai Penuh"],
            ['name' =>"Kab. Ogan Komering Ulu"],
            ['name' =>"Kab. Ogan Komering Ilir"],
            ['name' =>"Kab. Muara Enim"],
            ['name' =>"Kab. Lahat"],
            ['name' =>"Kab. Musi Rawas"],
            ['name' =>"Kab. Musi Banyuasin"],
            ['name' =>"Kab. Banyu Asin"],
            ['name' =>"Kab. Ogan Komering Ulu Selatan"],
            ['name' =>"Kab. Ogan Komering Ulu Timur"],
            ['name' =>"Kab. Ogan Ilir"],
            ['name' =>"Kab. Empat Lawang"],
            ['name' =>"Kota Palembang"],
            ['name' =>"Kota Prabumulih"],
            ['name' =>"Kota Pagar Alam"],
            ['name' =>"Kota Lubuklinggau"],
            ['name' =>"Kab. Bengkulu Selatan"],
            ['name' =>"Kab. Rejang Lebong"],
            ['name' =>"Kab. Bengkulu Utara"],
            ['name' =>"Kab. Kaur"],
            ['name' =>"Kab. Seluma"],
            ['name' =>"Kab. Mukomuko"],
            ['name' =>"Kab. Lebong"],
            ['name' =>"Kab. Kepahiang"],
            ['name' =>"Kab. Bengkulu Tengah"],
            ['name' =>"Kota Bengkulu"],
            ['name' =>"Kab. Lampung Barat"],
            ['name' =>"Kab. Tanggamus"],
            ['name' =>"Kab. Lampung Selatan"],
            ['name' =>"Kab. Lampung Timur"],
            ['name' =>"Kab. Lampung Tengah"],
            ['name' =>"Kab. Lampung Utara"],
            ['name' =>"Kab. Way Kanan"],
            ['name' =>"Kab. Tulangbawang"],
            ['name' =>"Kab. Pesawaran"],
            ['name' =>"Kab. Pringsewu"],
            ['name' =>"Kab. Mesuji"],
            ['name' =>"Kab. Tulang Bawang Barat"],
            ['name' =>"Kab. Pesisir Barat"],
            ['name' =>"Kota Bandar Lampung"],
            ['name' =>"Kota Metro"],
            ['name' =>"Kab. Bangka"],
            ['name' =>"Kab. Belitung"],
            ['name' =>"Kab. Bangka Barat"],
            ['name' =>"Kab. Bangka Tengah"],
            ['name' =>"Kab. Bangka Selatan"],
            ['name' =>"Kab. Belitung Timur"],
            ['name' =>"Kota Pangkal Pinang"],
            ['name' =>"Kab. Karimun"],
            ['name' =>"Kab. Bintan"],
            ['name' =>"Kab. Natuna"],
            ['name' =>"Kab. Lingga"],
            ['name' =>"Kab. Kepulauan Anambas"],
            ['name' =>"Kota B A T A M"],
            ['name' =>"Kota Tanjung Pinang"],
            ['name' =>"Kab. Kepulauan Seribu"],
            ['name' =>"Kota Jakarta Selatan"],
            ['name' =>"Kota Jakarta Timur"],
            ['name' =>"Kota Jakarta Pusat"],
            ['name' =>"Kota Jakarta Barat"],
            ['name' =>"Kota Jakarta Utara"],
            ['name' =>"Kab. Bogor"],
            ['name' =>"Kab. Sukabumi"],
            ['name' =>"Kab. Cianjur"],
            ['name' =>"Kab. Bandung"],
            ['name' =>"Kab. Garut"],
            ['name' =>"Kab. Tasikmalaya"],
            ['name' =>"Kab. Ciamis"],
            ['name' =>"Kab. Kuningan"],
            ['name' =>"Kab. Cirebon"],
            ['name' =>"Kab. Majalengka"],
            ['name' =>"Kab. Sumedang"],
            ['name' =>"Kab. Indramayu"],
            ['name' =>"Kab. Subang"],
            ['name' =>"Kab. Purwakarta"],
            ['name' =>"Kab. Karawang"],
            ['name' =>"Kab. Bekasi"],
            ['name' =>"Kab. Bandung Barat"],
            ['name' =>"Kab. Pangandaran"],
            ['name' =>"Kota Bogor"],
            ['name' =>"Kota Sukabumi"],
            ['name' =>"Kota Bandung"],
            ['name' =>"Kota Cirebon"],
            ['name' =>"Kota Bekasi"],
            ['name' =>"Kota Depok"],
            ['name' =>"Kota Cimahi"],
            ['name' =>"Kota Tasikmalaya"],
            ['name' =>"Kota Banjar"],
            ['name' =>"Kab. Cilacap"],
            ['name' =>"Kab. Banyumas"],
            ['name' =>"Kab. Purbalingga"],
            ['name' =>"Kab. Banjarnegara"],
            ['name' =>"Kab. Kebumen"],
            ['name' =>"Kab. Purworejo"],
            ['name' =>"Kab. Wonosobo"],
            ['name' =>"Kab. Magelang"],
            ['name' =>"Kab. Boyolali"],
            ['name' =>"Kab. Klaten"],
            ['name' =>"Kab. Sukoharjo"],
            ['name' =>"Kab. Wonogiri"],
            ['name' =>"Kab. Karanganyar"],
            ['name' =>"Kab. Sragen"],
            ['name' =>"Kab. Grobogan"],
            ['name' =>"Kab. Blora"],
            ['name' =>"Kab. Rembang"],
            ['name' =>"Kab. Pati"],
            ['name' =>"Kab. Kudus"],
            ['name' =>"Kab. Jepara"],
            ['name' =>"Kab. Demak"],
            ['name' =>"Kab. Semarang"],
            ['name' =>"Kab. Temanggung"],
            ['name' =>"Kab. Kendal"],
            ['name' =>"Kab. Batang"],
            ['name' =>"Kab. Pekalongan"],
            ['name' =>"Kab. Pemalang"],
            ['name' =>"Kab. Tegal"],
            ['name' =>"Kab. Brebes"],
            ['name' =>"Kota Magelang"],
            ['name' =>"Kota Surakarta"],
            ['name' =>"Kota Salatiga"],
            ['name' =>"Kota Semarang"],
            ['name' =>"Kota Pekalongan"],
            ['name' =>"Kota Tegal"],
            ['name' =>"Kab. Kulon Progo"],
            ['name' =>"Kab. Bantul"],
            ['name' =>"Kab. Gunung Kidul"],
            ['name' =>"Kab. Sleman"],
            ['name' =>"Kota Yogyakarta"],
            ['name' =>"Kab. Pacitan"],
            ['name' =>"Kab. Ponorogo"],
            ['name' =>"Kab. Trenggalek"],
            ['name' =>"Kab. Tulungagung"],
            ['name' =>"Kab. Blitar"],
            ['name' =>"Kab. Kediri"],
            ['name' =>"Kab. Malang"],
            ['name' =>"Kab. Lumajang"],
            ['name' =>"Kab. Jember"],
            ['name' =>"Kab. Banyuwangi"],
            ['name' =>"Kab. Bondowoso"],
            ['name' =>"Kab. Situbondo"],
            ['name' =>"Kab. Probolinggo"],
            ['name' =>"Kab. Pasuruan"],
            ['name' =>"Kab. Sidoarjo"],
            ['name' =>"Kab. Mojokerto"],
            ['name' =>"Kab. Jombang"],
            ['name' =>"Kab. Nganjuk"],
            ['name' =>"Kab. Madiun"],
            ['name' =>"Kab. Magetan"],
            ['name' =>"Kab. Ngawi"],
            ['name' =>"Kab. Bojonegoro"],
            ['name' =>"Kab. Tuban"],
            ['name' =>"Kab. Lamongan"],
            ['name' =>"Kab. Gresik"],
            ['name' =>"Kab. Bangkalan"],
            ['name' =>"Kab. Sampang"],
            ['name' =>"Kab. Pamekasan"],
            ['name' =>"Kab. Sumenep"],
            ['name' =>"Kota Kediri"],
            ['name' =>"Kota Blitar"],
            ['name' =>"Kota Malang"],
            ['name' =>"Kota Probolinggo"],
            ['name' =>"Kota Pasuruan"],
            ['name' =>"Kota Mojokerto"],
            ['name' =>"Kota Madiun"],
            ['name' =>"Kota Surabaya"],
            ['name' =>"Kota Batu"],
            ['name' =>"Kab. Pandeglang"],
            ['name' =>"Kab. Lebak"],
            ['name' =>"Kab. Tangerang"],
            ['name' =>"Kab. Serang"],
            ['name' =>"Kota Tangerang"],
            ['name' =>"Kota Cilegon"],
            ['name' =>"Kota Serang"],
            ['name' =>"Kota Tangerang Selatan"],
            ['name' =>"Kab. Jembrana"],
            ['name' =>"Kab. Tabanan"],
            ['name' =>"Kab. Badung"],
            ['name' =>"Kab. Gianyar"],
            ['name' =>"Kab. Klungkung"],
            ['name' =>"Kab. Bangli"],
            ['name' =>"Kab. Karang Asem"],
            ['name' =>"Kab. Buleleng"],
            ['name' =>"Kota Denpasar"],
            ['name' =>"Kab. Lombok Barat"],
            ['name' =>"Kab. Lombok Tengah"],
            ['name' =>"Kab. Lombok Timur"],
            ['name' =>"Kab. Sumbawa"],
            ['name' =>"Kab. Dompu"],
            ['name' =>"Kab. Bima"],
            ['name' =>"Kab. Sumbawa Barat"],
            ['name' =>"Kab. Lombok Utara"],
            ['name' =>"Kota Mataram"],
            ['name' =>"Kota Bima"],
            ['name' =>"Kab. Sumba Barat"],
            ['name' =>"Kab. Sumba Timur"],
            ['name' =>"Kab. Kupang"],
            ['name' =>"Kab. Timor Tengah Selatan"],
            ['name' =>"Kab. Timor Tengah Utara"],
            ['name' =>"Kab. Belu"],
            ['name' =>"Kab. Alor"],
            ['name' =>"Kab. Lembata"],
            ['name' =>"Kab. Flores Timur"],
            ['name' =>"Kab. Sikka"],
            ['name' =>"Kab. Ende"],
            ['name' =>"Kab. Ngada"],
            ['name' =>"Kab. Manggarai"],
            ['name' =>"Kab. Rote Ndao"],
            ['name' =>"Kab. Manggarai Barat"],
            ['name' =>"Kab. Sumba Tengah"],
            ['name' =>"Kab. Sumba Barat Daya"],
            ['name' =>"Kab. Nagekeo"],
            ['name' =>"Kab. Manggarai Timur"],
            ['name' =>"Kab. Sabu Raijua"],
            ['name' =>"Kota Kupang"],
            ['name' =>"Kab. Sambas"],
            ['name' =>"Kab. Bengkayang"],
            ['name' =>"Kab. Landak"],
            ['name' =>"Kab. Pontianak"],
            ['name' =>"Kab. Sanggau"],
            ['name' =>"Kab. Ketapang"],
            ['name' =>"Kab. Sintang"],
            ['name' =>"Kab. Kapuas Hulu"],
            ['name' =>"Kab. Sekadau"],
            ['name' =>"Kab. Melawi"],
            ['name' =>"Kab. Kayong Utara"],
            ['name' =>"Kab. Kubu Raya"],
            ['name' =>"Kota Pontianak"],
            ['name' =>"Kota Singkawang"],
            ['name' =>"Kab. Kotawaringin Barat"],
            ['name' =>"Kab. Kotawaringin Timur"],
            ['name' =>"Kab. Kapuas"],
            ['name' =>"Kab. Barito Selatan"],
            ['name' =>"Kab. Barito Utara"],
            ['name' =>"Kab. Sukamara"],
            ['name' =>"Kab. Lamandau"],
            ['name' =>"Kab. Seruyan"],
            ['name' =>"Kab. Katingan"],
            ['name' =>"Kab. Pulang Pisau"],
            ['name' =>"Kab. Gunung Mas"],
            ['name' =>"Kab. Barito Timur"],
            ['name' =>"Kab. Murung Raya"],
            ['name' =>"Kota Palangka Raya"],
            ['name' =>"Kab. Tanah Laut"],
            ['name' =>"Kab. Kota Baru"],
            ['name' =>"Kab. Banjar"],
            ['name' =>"Kab. Barito Kuala"],
            ['name' =>"Kab. Tapin"],
            ['name' =>"Kab. Hulu Sungai Selatan"],
            ['name' =>"Kab. Hulu Sungai Tengah"],
            ['name' =>"Kab. Hulu Sungai Utara"],
            ['name' =>"Kab. Tabalong"],
            ['name' =>"Kab. Tanah Bumbu"],
            ['name' =>"Kab. Balangan"],
            ['name' =>"Kota Banjarmasin"],
            ['name' =>"Kota Banjar Baru"],
            ['name' =>"Kab. Paser"],
            ['name' =>"Kab. Kutai Barat"],
            ['name' =>"Kab. Kutai Kartanegara"],
            ['name' =>"Kab. Kutai Timur"],
            ['name' =>"Kab. Berau"],
            ['name' =>"Kab. Penajam Paser Utara"],
            ['name' =>"Kota Balikpapan"],
            ['name' =>"Kota Samarinda"],
            ['name' =>"Kota Bontang"],
            ['name' =>"Kab. Malinau"],
            ['name' =>"Kab. Bulungan"],
            ['name' =>"Kab. Tana Tidung"],
            ['name' =>"Kab. Nunukan"],
            ['name' =>"Kota Tarakan"],
            ['name' =>"Kab. Bolaang Mongondow"],
            ['name' =>"Kab. Minahasa"],
            ['name' =>"Kab. Kepulauan Sangihe"],
            ['name' =>"Kab. Kepulauan Talaud"],
            ['name' =>"Kab. Minahasa Selatan"],
            ['name' =>"Kab. Minahasa Utara"],
            ['name' =>"Kab. Bolaang Mongondow Utara"],
            ['name' =>"Kab. Siau Tagulandang Biaro"],
            ['name' =>"Kab. Minahasa Tenggara"],
            ['name' =>"Kab. Bolaang Mongondow Selatan"],
            ['name' =>"Kab. Bolaang Mongondow Timur"],
            ['name' =>"Kota Manado"],
            ['name' =>"Kota Bitung"],
            ['name' =>"Kota Tomohon"],
            ['name' =>"Kota Kotamobagu"],
            ['name' =>"Kab. Banggai Kepulauan"],
            ['name' =>"Kab. Banggai"],
            ['name' =>"Kab. Morowali"],
            ['name' =>"Kab. Poso"],
            ['name' =>"Kab. Donggala"],
            ['name' =>"Kab. Toli-toli"],
            ['name' =>"Kab. Buol"],
            ['name' =>"Kab. Parigi Moutong"],
            ['name' =>"Kab. Tojo Una-una"],
            ['name' =>"Kab. Sigi"],
            ['name' =>"Kota Palu"],
            ['name' =>"Kab. Kepulauan Selayar"],
            ['name' =>"Kab. Bulukumba"],
            ['name' =>"Kab. Bantaeng"],
            ['name' =>"Kab. Jeneponto"],
            ['name' =>"Kab. Takalar"],
            ['name' =>"Kab. Gowa"],
            ['name' =>"Kab. Sinjai"],
            ['name' =>"Kab. Maros"],
            ['name' =>"Kab. Pangkajene Dan Kepulauan"],
            ['name' =>"Kab. Barru"],
            ['name' =>"Kab. Bone"],
            ['name' =>"Kab. Soppeng"],
            ['name' =>"Kab. Wajo"],
            ['name' =>"Kab. Sidenreng Rappang"],
            ['name' =>"Kab. Pinrang"],
            ['name' =>"Kab. Enrekang"],
            ['name' =>"Kab. Luwu"],
            ['name' =>"Kab. Tana Toraja"],
            ['name' =>"Kab. Luwu Utara"],
            ['name' =>"Kab. Luwu Timur"],
            ['name' =>"Kab. Toraja Utara"],
            ['name' =>"Kota Makassar"],
            ['name' =>"Kota Parepare"],
            ['name' =>"Kota Palopo"],
            ['name' =>"Kab. Buton"],
            ['name' =>"Kab. Muna"],
            ['name' =>"Kab. Konawe"],
            ['name' =>"Kab. Kolaka"],
            ['name' =>"Kab. Konawe Selatan"],
            ['name' =>"Kab. Bombana"],
            ['name' =>"Kab. Wakatobi"],
            ['name' =>"Kab. Kolaka Utara"],
            ['name' =>"Kab. Buton Utara"],
            ['name' =>"Kab. Konawe Utara"],
            ['name' =>"Kota Kendari"],
            ['name' =>"Kota Baubau"],
            ['name' =>"Kab. Boalemo"],
            ['name' =>"Kab. Gorontalo"],
            ['name' =>"Kab. Pohuwato"],
            ['name' =>"Kab. Bone Bolango"],
            ['name' =>"Kab. Gorontalo Utara"],
            ['name' =>"Kota Gorontalo"],
            ['name' =>"Kab. Majene"],
            ['name' =>"Kab. Polewali Mandar"],
            ['name' =>"Kab. Mamasa"],
            ['name' =>"Kab. Mamuju"],
            ['name' =>"Kab. Mamuju Utara"],
            ['name' =>"Kab. Maluku Tenggara Barat"],
            ['name' =>"Kab. Maluku Tenggara"],
            ['name' =>"Kab. Maluku Tengah"],
            ['name' =>"Kab. Buru"],
            ['name' =>"Kab. Kepulauan Aru"],
            ['name' =>"Kab. Seram Bagian Barat"],
            ['name' =>"Kab. Seram Bagian Timur"],
            ['name' =>"Kab. Maluku Barat Daya"],
            ['name' =>"Kab. Buru Selatan"],
            ['name' =>"Kota Ambon"],
            ['name' =>"Kota Tual"],
            ['name' =>"Kab. Halmahera Barat"],
            ['name' =>"Kab. Halmahera Tengah"],
            ['name' =>"Kab. Kepulauan Sula"],
            ['name' =>"Kab. Halmahera Selatan"],
            ['name' =>"Kab. Halmahera Utara"],
            ['name' =>"Kab. Halmahera Timur"],
            ['name' =>"Kab. Pulau Morotai"],
            ['name' =>"Kota Ternate"],
            ['name' =>"Kota Tidore Kepulauan"],
            ['name' =>"Kab. Fakfak"],
            ['name' =>"Kab. Kaimana"],
            ['name' =>"Kab. Teluk Wondama"],
            ['name' =>"Kab. Teluk Bintuni"],
            ['name' =>"Kab. Manokwari"],
            ['name' =>"Kab. Sorong Selatan"],
            ['name' =>"Kab. Sorong"],
            ['name' =>"Kab. Raja Ampat"],
            ['name' =>"Kab. Tambrauw"],
            ['name' =>"Kab. Maybrat"],
            ['name' =>"Kota Sorong"],
            ['name' =>"Kab. Merauke"],
            ['name' =>"Kab. Jayawijaya"],
            ['name' =>"Kab. Jayapura"],
            ['name' =>"Kab. Nabire"],
            ['name' =>"Kab. Kepulauan Yapen"],
            ['name' =>"Kab. Biak Numfor"],
            ['name' =>"Kab. Paniai"],
            ['name' =>"Kab. Puncak Jaya"],
            ['name' =>"Kab. Mimika"],
            ['name' =>"Kab. Boven Digoel"],
            ['name' =>"Kab. Mappi"],
            ['name' =>"Kab. Asmat"],
            ['name' =>"Kab. Yahukimo"],
            ['name' =>"Kab. Pegunungan Bintang"],
            ['name' =>"Kab. Tolikara"],
            ['name' =>"Kab. Sarmi"],
            ['name' =>"Kab. Keerom"],
            ['name' =>"Kab. Waropen"],
            ['name' =>"Kab. Supiori"],
            ['name' =>"Kab. Mamberamo Raya"],
            ['name' =>"Kab. Nduga"],
            ['name' =>"Kab. Lanny Jaya"],
            ['name' =>"Kab. Mamberamo Tengah"],
            ['name' =>"Kab. Yalimo"],
            ['name' =>"Kab. Puncak"],
            ['name' =>"Kab. Dogiyai"],
            ['name' =>"Kab. Intan Jaya"],
            ['name' =>"Kab. Deiyai"],
            ['name' =>"Kota Jayapura"],
       ];
          // Iterasi untuk membuat data
          foreach ($regencyData as $rd) {
            RegencyCity::create($rd);
        }


        // Province
       $provinceData = [ ['name' => 'Aceh'],
        ['name' => 'Sumatera Utara'],
        ['name' => 'Sumatera Barat'],
        ['name' => 'Riau'],
        ['name' => 'Jambi'],
        ['name' => 'Sumatera Selatan'],
        ['name' => 'Bengkulu'],
        ['name' => 'Lampung'],
        ['name' => 'Kepulauan Bangka Belitung'],
        ['name' => 'Kepulauan Riau'],
        ['name' => 'Dki Jakarta'],
        ['name' => 'Jawa Barat'],
        ['name' => 'Jawa Tengah'],
        ['name' => 'Di Yogyakarta'],
        ['name' => 'Jawa Timur'],
        ['name' => 'Banten'],
        ['name' => 'Bali'],
        ['name' => 'Nusa Tenggara Barat'],
        ['name' => 'Nusa Tenggara Timur'],
        ['name' => 'Kalimantan Barat'],
        ['name' => 'Kalimantan Tengah'],
        ['name' => 'Kalimantan Selatan'],
        ['name' => 'Kalimantan Timur'],
        ['name' => 'Kalimantan Utara'],
        ['name' => 'Sulawesi Utara'],
        ['name' => 'Sulawesi Tengah'],
        ['name' => 'Sulawesi Selatan'],
        ['name' => 'Sulawesi Tenggara'],
        ['name' => 'Gorontalo'],
        ['name' => 'Sulawesi Barat'],
        ['name' => 'Maluku'],
        ['name' => 'Maluku Utara'],
        ['name' => 'Papua Barat'],
        ['name' => 'Papua'] ];
        // Iterasi untuk membuat data
        foreach ($provinceData as $pc) {
            Province::create($pc);
        }


        // departement

        $departemen = [ ['departement_code' => 1, 'departement_name' => 'HR'],
         ['departement_code' => 2, 'departement_name' => 'Finance'],
         ['departement_code' => 3, 'departement_name' => 'IT'],
         ['departement_code' => 4, 'departement_name' => 'Marketing'],
         ['departement_code' => 5, 'departement_name' => 'Sales'],
         ['departement_code' => 6, 'departement_name' => 'HR'],
         ['departement_code' => 7, 'departement_name' => 'Finance'],
         ['departement_code' => 8, 'departement_name' => 'IT'],
         ['departement_code' => 9, 'departement_name' => 'Marketing'],
         ['departement_code' => 10, 'departement_name' => 'Sales'],
         ];

          // Iterasi untuk membuat data
        foreach ($departemen as $dp) {
            Departement::create($dp);
        }



        // Tabel User
        $roles = ['admin', 'pusat', 'province', 'regency', 'departement'];  
        $prov = Province::inRandomOrder()->first()->id;
        $regen = RegencyCity::inRandomOrder()->first()->id;
        $dev = Departement::inRandomOrder()->first()->id;
        foreach ($roles as $role) {  
            User::factory()->create([  
                'name' => $role,  
                'username' => $role,  
                'region' => fake()->address(),
                'email' => $role . '@mail.com',  
                'password' => Hash::make($role),  
                'role' => $role,
                'province_id' => $prov,
                'regency_city_id' => $regen,
                'departement_id' => $dev,  
            ]);  
        }  


        // Tabel Program
        Program::create([
            'program_code' => '02509DC',
            'program_name' => 'Program Kerukunan Umat dan Layanan Kehidupan Beragama',
        ]);
        Program::create([
            'program_code' => '02509WA',
            'program_name' => 'Program Dukungan Manajemen',
        ]);

            // Data Activity
        $activityData = [
            ['activity_code' => '2126', 'activity_name' => 'Pembinaan Umrah dan Haji Khusus'],
            ['activity_code' => '2147', 'activity_name' => 'Pelayanan Haji Dalam Negeri'],
            ['activity_code' => '2148', 'activity_name' => 'Pembinaan Haji'],
            ['activity_code' => '2149', 'activity_name' => 'Pengelolaan Dana Haji dan Sistem Informasi Haji'],
            ['activity_code' => '5310', 'activity_name' => 'Pelayanan Haji Luar Negeri'],
            ['activity_code' => '2150', 'activity_name' => 'Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya Penyelenggaraan Haji dan Umrah'],
        ];

        // Iterasi untuk membuat data
        foreach ($activityData as $activity) {
            Activity::create($activity);
        }

      
        // Data KRO
        $kroData = [
            ['kro_code' => '2126QDB', 'kro_name' => 'Fasilitasi dan Pembinaan Lembaga'],
            ['kro_code' => '2147QAA', 'kro_name' => 'Pelayanan Publik kepada masyarakat'],
            ['kro_code' => '2147QAH', 'kro_name' => 'Pelayanan Publik Lainnya'],
            ['kro_code' => '2148QDC', 'kro_name' => 'Fasilitasi dan Pembinaan Masyarakat'],
            ['kro_code' => '2149QMA', 'kro_name' => 'Data dan Informasi Publik'],
            ['kro_code' => '2149UAH', 'kro_name' => 'Pengelolaan Keuangan Negara'],
            ['kro_code' => '5310QDC', 'kro_name' => 'Fasilitasi dan Pembinaan Masyarakat'],
            ['kro_code' => '2150EBA', 'kro_name' => 'Layanan Dukungan Manajemen Internal'],
            ['kro_code' => '2150EBC', 'kro_name' => 'Layanan Manajemen SDM Internal'],
            ['kro_code' => '2150EBD', 'kro_name' => 'Layanan Manajemen Kinerja Internal'],
        ];

        // Iterasi untuk membuat data
        foreach ($kroData as $kro) {
            Kro::create($kro);
        }


       // Data RO
        $roData = [
            ['ro_code' => '2126QDB001', 'ro_name' => 'Lembaga Penyelenggara Ibadah Umrah yang Terbina'],
            ['ro_code' => '2126QDB002', 'ro_name' => 'Lembaga Penyelenggara Ibadah Haji Khusus yang Terbina'],
            ['ro_code' => '2147QAA001', 'ro_name' => 'Layanan Administrasi Haji Dalam Negeri'],
            ['ro_code' => '2147QAH001', 'ro_name' => 'Asrama Haji yang Profesional Melayani'],
            ['ro_code' => '2147QAH002', 'ro_name' => 'Pusat Layanan Haji dan Umrah Terpadu yang Profesional Melayani'],
            ['ro_code' => '2148QAH001', 'ro_name' => 'Advokasi Haji'],
            ['ro_code' => '2148QDC001', 'ro_name' => 'Petugas Haji yang Profesional'],
            ['ro_code' => '2149QMA001', 'ro_name' => 'Sistem Informasi Haji yang Handal'],
            ['ro_code' => '2149UAH001', 'ro_name' => 'Laporan Keuangan Haji yang Akuntabel'],
            ['ro_code' => '5310QDC001', 'ro_name' => 'Layanan Administrasi Haji Luar Negeri'],
            ['ro_code' => '2150EBA956', 'ro_name' => 'Layanan BMN'],
            ['ro_code' => '2150EBA957', 'ro_name' => 'Layanan Hukum'],
            ['ro_code' => '2150EBA958', 'ro_name' => 'Layanan Hubungan Masyarakat'],
            ['ro_code' => '2150EBA959', 'ro_name' => 'Layanan Protokoler'],
            ['ro_code' => '2150EBA960', 'ro_name' => 'Layanan Organisasi dan Tata Kelola Internal'],
            ['ro_code' => '2150EBA962', 'ro_name' => 'Layanan Umum'],
            ['ro_code' => '2150EBA994', 'ro_name' => 'Layanan Perkantoran'],
            ['ro_code' => '2150EBB951', 'ro_name' => 'Layanan Sarana Internal'],
            ['ro_code' => '2150EBC954', 'ro_name' => 'Layanan Manajemen SDM'],
            ['ro_code' => '2150EBD952', 'ro_name' => 'Layanan Perencanaan dan Penganggaran'],
            ['ro_code' => '2150EBD953', 'ro_name' => 'Layanan Pemantauan dan Evaluasi'],
            ['ro_code' => '2150EBD955', 'ro_name' => 'Layanan Manajemen Keuangan'],
        ];

        // Iterasi untuk membuat data
        foreach ($roData as $ro) {
            Ro::create($ro);
        }

        // Unit
         Unit::create([
            'unit_code' => 'UT'. random_int(5,6),
            'unit_name' => 'RM',
        ]);
        Unit::create([
            'unit_code' =>'UT'. random_int(5,6),
            'unit_name' => 'PNBP',
        ]);

        // 
        Unit::create([
            'unit_code' =>'UT'. random_int(5,6),
            'unit_name' => 'PNBP',
        ]);
        // komponent
    //   $componentsData = [ 
    //     [
    //         'component_code' => '2126QDB001051',
    //         'component_name' => 'Pengelolaan Perizinan Penyelenggara Perjalanan Ibadah Umrah',
    //         ],
    //      [
    //          'component_code' => '2126QDB001052',
    //         'component_name' => 'Akreditasi Penyelenggara Perjalanan Ibadah Umrah',
    //         ],
    //      [
    //          'component_code' => '2126QDB001053',
    //         'component_name' => 'Pembinaan Penyelenggara Perjalanan Ibadah Umrah',
    //         ],
    //      [
    //          'component_code' => '2126QDB001054',
    //         'component_name' => 'Pemantauan dan Pengawasan Penyelenggara Perjalanan Ibadah Umrah',
    //         ],
    //      [
    //          'component_code' => '2126QDB001055',
    //         'component_name' => 'Identifikasi dan Pemetaan Masalah Penyelenggara Perjalanan Ibadah Umrah',
    //         ],
    //      [
    //          'component_code' => '2126QDB001056',
    //         'component_name' => 'Penanganan Masalah Penyelenggara Perjalanan Ibadah Umrah',
    //         ],
    //      [
    //          'component_code' => '2126QDB002051',
    //         'component_name' => 'Pengelolaan Perizinan Penyelenggara Ibadah Haji Khusus',
    //         ],
    //      [
    //          'component_code' => '2126QDB002052',
    //         'component_name' => 'Akreditasi Penyelenggara Ibadah Haji Khusus',
    //         ],
    //      [
    //          'component_code' => '2126QDB002053',
    //         'component_name' => 'Pendaftaran dan Pembatalan Haji Khusus',
    //         ],
    //      [
    //          'component_code' => '2126QDB002054',
    //         'component_name' => 'Dokumen dan Perlengkapan Ibadah Haji Khusus',
    //         ],
    //      [
    //          'component_code' => '2126QDB002055',
    //         'component_name' => 'Pembinaan dan Peningkatan Kualitas Penyelenggara Ibadah Haji Khusus',
    //         ],
    //      [
    //          'component_code' => '2126QDB002056',
    //         'component_name' => 'Pemantauan dan Pengawasan Penyelenggara Ibadah Haji Khusus',
    //         ],
    //      [
    //          'component_code' => '2126QDB002057',
    //         'component_name' => 'Identifikasi dan Pemetaan Masalah Penyelenggara Ibadah Haji Khusus',
    //         ],
    //      [
    //          'component_code' => '2126QDB002058',
    //         'component_name' => 'Penanganan Masalah Penyelenggara Ibadah Haji Khusus',
    //         ],
    //      [
    //          'component_code' => '2147QAA001051',
    //         'component_name' => 'Penyempurnaan Kebijakan Pendaftaran dan Pembatalan Haji Reguler',
    //         ],
    //      [
    //          'component_code' => '2147QAA001052',
    //         'component_name' => 'Sosialisasi Kebijakan Pendaftaran dan Pembatalan Haji reguler',
    //         ],
    //      [
    //          'component_code' => '2147QAA001053',
    //         'component_name' => 'Pengelolaan Pelayanan Pendaftaran dan Pembatalan Haji Reguler',
    //         ],
    //      [
    //          'component_code' => '2147QAA001054',
    //         'component_name' => 'Konsolidasi dan Verifikasi Data Jemaah Haji Reguler',
    //         ],
    //      [
    //          'component_code' => '2147QAA001055',
    //         'component_name' => 'Sosialisasi/Orientasi Penyelesaian Dokumen dan Perlengkapan Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAA001056',
    //         'component_name' => 'Pengelolaan Pelayanan Pemvisaan Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAA001057',
    //         'component_name' => 'Penyelesaian Dokumen/Perlengkapan Jemaah Haji di Tingkat Kab/Kota',
    //         ],
    //      [
    //          'component_code' => '2147QAA001058',
    //         'component_name' => 'Penyelesaian Dokumen/Perlengkapan Jemaah Haji di Tingkat Provinsi',
    //         ],
    //      [
    //          'component_code' => '2147QAA001059',
    //         'component_name' => 'Penyelesaian Dokumen/Perlengkapan Jemaah Haji di Tingkat Pusat',
    //         ],
    //      [
    //          'component_code' => '2147QAA001060',
    //         'component_name' => 'Penyiapan Transportasi Udara Jemaah Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAA001061',
    //         'component_name' => 'Penyusunan dan Pembahasan Asuransi Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAA001062',
    //         'component_name' => 'Konsolidasi dan Verifikasi Data Angkutan Udara Jemaah Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAA001063',
    //         'component_name' => 'Pelayanan Pemberangkatan/Pemulangan Jemaah',
    //         ],
    //      [
    //          'component_code' => '2147QAH001051',
    //         'component_name' => 'Penyiapan Asrama Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAH001052',
    //         'component_name' => 'Pelayanan Asrama Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAH001053',
    //         'component_name' => 'Revitalisasi dan Pengembangan Asrama Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAH001054',
    //         'component_name' => 'Monitoring dan Evaluasi Asrama Haji',
    //         ],
    //      [
    //          'component_code' => '2147QAH002051',
    //         'component_name' => 'Revitalisasi dan Pembangunan Pusat Layanan Haji dan Umrah Terpadu',
    //         ],
    //      [
    //          'component_code' => '2147QAH002052',
    //         'component_name' => 'Pengelolaaan Pusat Layanan Haji dan Umrah Terpadu',
    //         ],
    //      [
    //          'component_code' => '2148QAH001051',
    //         'component_name' => 'Identifikasi dan Pemetaan Masalah Haji',
    //         ],
    //      [
    //          'component_code' => '2148QAH001052',
    //         'component_name' => 'Penanganan Masalah Haji',
    //         ],
    //      [
    //          'component_code' => '2148QDC001051',
    //         'component_name' => 'Rekrutmen/Seleksi PPIH Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001052',
    //         'component_name' => 'Rekrutmen/Seleksi PPIH Non Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001053',
    //         'component_name' => 'Rekrutmen/Seleksi PPIH Tenaga Musiman',
    //         ],
    //      [
    //          'component_code' => '2148QDC001054',
    //         'component_name' => 'Rekrutmen/Seleksi Petugas TPHD',
    //         ],
    //      [
    //          'component_code' => '2148QDC001055',
    //         'component_name' => 'Dokumen dan Perlengkapan PPIH Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001056',
    //         'component_name' => 'Dokumen dan Perlengkapan PPIH Non Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001057',
    //         'component_name' => 'Dokumen dan Perlengkapan PPIH Tenaga Musiman',
    //         ],
    //      [
    //          'component_code' => '2148QDC001058',
    //         'component_name' => 'Dokumen dan Perlengkapan PPIH Embarkasi',
    //         ],
    //      [
    //          'component_code' => '2148QDC001059',
    //         'component_name' => 'Dokumen dan Perlengkapan PPIH Embarkasi Antara',
    //         ],
    //      [
    //          'component_code' => '2148QDC001060',
    //         'component_name' => 'Dokumen dan Perlengkapan PPIH Embarkasi Transit',
    //         ],
    //      [
    //          'component_code' => '2148QDC001061',
    //         'component_name' => 'Pelatihan dan pembekalan PPIH Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001062',
    //         'component_name' => 'Pelatihan dan pembekalan PPIH Non Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001063',
    //         'component_name' => 'Pelatihan dan pembekalan PPIH Tenaga Musiman',
    //         ],
    //      [
    //          'component_code' => '2148QDC001064',
    //         'component_name' => 'Operasional PPIH Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001065',
    //         'component_name' => 'Operasional PPIH Non Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001066',
    //         'component_name' => 'Operasional PPIH Tenaga Musiman',
    //         ],
    //      [
    //          'component_code' => '2148QDC001067',
    //         'component_name' => 'Operasional PPIH Embarkasi',
    //         ],
    //      [
    //          'component_code' => '2148QDC001068',
    //         'component_name' => 'Operasional PPIH Embarkasi Antara',
    //         ],
    //      [
    //         'component_name' => 'Operasional ,PPIH Embarkasi Transit'
    //     ],
    //     [
    //         'component_code' => '2148QDC001070',
    //         'component_name' => 'Akomodasi PPIH Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001071',
    //         'component_name' => 'Akomodasi PPIH Non Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001072',
    //         'component_name' => 'Akomodasi PPIH Tenaga Musiman',
    //         ],
    //      [
    //          'component_code' => '2148QDC001073',
    //         'component_name' => 'Konsumsi PPIH Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001074',
    //         'component_name' => 'Konsumsi PPIH Non Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001075',
    //         'component_name' => 'Konsumsi PPIH Tenaga Musiman',
    //         ],
    //      [
    //          'component_code' => '2148QDC001076',
    //         'component_name' => 'Transportasi PPIH Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001077',
    //         'component_name' => 'Transportasi PPIH Non Kloter',
    //         ],
    //      [
    //          'component_code' => '2148QDC001078',
    //         'component_name' => 'Transportasi PPIH Tenaga Musiman',
    //         ],
    //      [
    //          'component_code' => '2148QDC001079',
    //         'component_name' => 'Evaluasi Teknis Petugas Panitia Penyelenggara Ibadah Haji Arab Saudi',
    //         ],
    //      [
    //          'component_code' => '2148QDC001080',
    //         'component_name' => 'Koordinasi Penyelenggaraan Ibadah Haji Luar Negeri',
    //         ],
    //      [
    //          'component_code' => '2148QDC002051',
    //         'component_name' => 'Bimbingan Jemaah Haji Reguler',
    //         ],
    //      [
    //          'component_code' => '2148QDC002052',
    //         'component_name' => 'Sertifikasi penyuluh dan pembimbing manasik haji',
    //         ],
    //      [
    //          'component_code' => '2148QDC002053',
    //         'component_name' => 'Pembinaan kelompok bimbingan',
    //         ],
    //      [
    //          'component_code' => '2149QMA001051',
    //         'component_name' => 'Pengelolaan Infrastruktur',
    //         ],
    //      [
    //          'component_code' => '2149QMA001052',
    //         'component_name' => 'Pengembangan Database Haji',
    //         ],
    //      [
    //          'component_code' => '2149QMA001053',
    //         'component_name' => 'Pengembangan Sistem Informasi Haji',
    //         ],
    //      [
    //          'component_code' => '2149UAH001051',
    //         'component_name' => 'Perencanaan Anggaran Operasional Haji',
    //         ],
    //      [
    //          'component_code' => '2149UAH001052',
    //         'component_name' => 'Pengelolaan Aset Haji',
    //         ],
    //      [
    //          'component_code' => '2149UAH001053',
    //         'component_name' => 'Monitoring dan Evaluasi Anggaran Operasional Haji',
    //         ],
    //      [
    //          'component_code' => '2149UAH001054',
    //         'component_name' => 'Pelaksanaan Anggaran dan Perbendaharaan Haji',
    //         ],
    //      [
    //          'component_code' => '2149UAH001056',
    //         'component_name' => 'Pelaporan Keuangan Operasional Haji',
    //         ],
    //      [
    //          'component_code' => '5310QDC001051',
    //         'component_name' => 'Seleksi Perusahaan Penyedia Akomodasi Jemaah Haji Indonesia di Arab Saudi',
    //         ],
    //      [
    //          'component_code' => '5310QDC001052',
    //         'component_name' => 'Seleksi Perusahaan Penyedia Konsumsi Jemaah Haji Indonesia di Arab Saudi',
    //         ],
    //      [
    //          'component_code' => '5310QDC001053',
    //         'component_name' => 'Seleksi Perusahaan Penyedia Transportasi Jemaah Haji Indonesia di Arab Saudi',
    //         ],
    //      [
    //          'component_code' => '2150EBA956051',
    //         'component_name' => 'Pengelolaan BMN dan Perlengkapan',
    //         ],
    //      [
    //          'component_code' => '2150EBA957051',
    //         'component_name' => 'Layanan Hukum dan Peraturan Perundang-Undangan',
    //         ],
    //      [
    //          'component_code' => '2150EBA957052',
    //         'component_name' => 'Penyelesaian Tindak Lanjut Hasil Temuan Pemeriksaan',
    //         ],
    //      [
    //          'component_code' => '2150EBA958051',
    //         'component_name' => 'Pameran/event penyelenggaraan haji/umrah',
    //         ],
    //      [
    //          'component_code' => '2150EBA958052',
    //         'component_name' => 'Pengelolaan Media Publikasi Informasi Haji dan Umrah',
    //         ],
    //      [
    //          'component_code' => '2150EBA958053',
    //         'component_name' => 'Penyebaran Informasi Haji dan Umrah',
    //         ],
    //      [
    //          'component_code' => '2150EBA959051',
    //         'component_name' => 'Pelayanan Protokoler',
    //         ],
    //      [
    //          'component_code' => '2150EBA960051',
    //         'component_name' => 'Pelayanan Organisasi, Tata Laksana, dan Reformasi Birokrasi',
    //         ],
    //      [
    //          'component_code' => '2150EBA962051',
    //         'component_name' => 'Rapat Kerja Nasional Penyelenggaraan Haji',
    //         ],
    //      [
    //          'component_code' => '2150EBA962052',
    //         'component_name' => 'Koordinasi penyelenggaraan ibadah haji',
    //         ],
    //      [
    //          'component_code' => '2150EBA962053',
    //         'component_name' => 'Pelayanan Umum dan Rumah Tangga',
    //         ],
    //      [
    //          'component_code' => '2150EBA962054',
    //         'component_name' => 'Pengelolaan Ketatausahaan',
    //         ],
    //      [
    //          'component_code' => '2150EBA962055',
    //         'component_name' => 'Layanan Dukungan Manajemen Eselon II',
    //         ],
    //      [
    //          'component_code' => '2150EBA994001',
    //         'component_name' => 'Gaji dan Tunjangan',
    //         ],
    //      [
    //          'component_code' => '2150EBA994002',
    //         'component_name' => 'Operasional dan Pemeliharaan Kantor',
    //         ],
    //      [
    //          'component_code' => '2150EBB951051',
    //         'component_name' => 'Pengadaan Perangkat Pengolah Data dan Komunikasi',
    //         ],
    //      [
    //          'component_code' => '2150EBB951052',
    //         'component_name' => 'Pengadaan Peralatan dan Fasilitas Perkantoran',
    //         ],
    //      [
    //          'component_code' => '2150EBB951053',
    //         'component_name' => 'Pengadaan Kendaraan Bermotor',
    //         ],
    //      [
    //          'component_code' => '2150EBB951054',
    //         'component_name' => 'Pembangunan/Renovasi gedung dan bangunan',
    //         ],
    //      [
    //          'component_code' => '2150EBC954051',
    //         'component_name' => 'Pengelolaan Kepegawaian',
    //         ],
    //      [
    //          'component_code' => '2150EBD952051',
    //         'component_name' => 'Penyusunan Perencanaan Program dan Anggaran',
    //         ],
    //      [
    //          'component_code' => '2150EBD952052',
    //         'component_name' => 'Pengelolaan Rencana Program dan Anggaran',
    //         ],
    //      [
    //          'component_code' => '2150EBD953051',
    //         'component_name' => 'Evaluasi dan Pelaporan Program',
    //         ],
    //      [
    //          'component_code' => '2150EBD955051',
    //         'component_name' => 'Pelaksananaan Anggaran dan Perbendaharaan',
    //         ],
    //      [
    //          'component_code' => '2150EBD955052',
    //         'component_name' => 'Verifikasi Anggaran dan Perbendaharaan',
    //         ],
    //      [
    //          'component_code' => '2150EBD955053',
    //         'component_name' => 'Layanan Administrasi PNBP',
    //         ],
    //      [
    //          'component_code' => '2150EBD955054',
    //         'component_name' => 'Pengelolaan PNBP',
    //         ],
    //      [
    //          'component_code' =>'2150EBD955055',
    //         'component_name' => 'Pengelolaan Laporan Keuangan',
    //     ]
    //     ];

    //     // Iterasi untuk membuat data 
    //     foreach ($componentsData as $cp) { 
    //         Component::create($cp);
    //      }

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
