<?php

namespace Database\Factories;

use App\Models\RegencyCity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegencyCity>
 */
class RegencyCityFactory extends Factory
{
    protected $model = RegencyCity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
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
        $id = 1;
        $result = [];
        
        for ($i = 0; $i < count($data); $i++) {
            $result[] = [
                'id' => $id++,
                 'name'[$i],
            ];
        }
        
        return $result;
        }
    }
