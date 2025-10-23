<?php

use App\Models\Sensor;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $sensors = [
        'ph' => [
            'rentangNilai' => '0 - 14',
            'keterangan' => 'pH adalah singkatan dari "Potensi Hidrogen." Ini adalah ukuran yang digunakan untuk menggambarkan sejauh mana suatu larutan bersifat asam atau bersifat basa (alkali). Pengukuran pH mengukur konsentrasi ion hidrogen (H+) dalam suatu larutan. Nilai pH berkisar dari 0 hingga 14, dengan nilai tertentu mengindikasikan tingkat keasaman atau kebasaan.'
        ],
        'cod' => [
            'rentangNilai' => '0 - 300 mg/L',
            'keterangan' => 'COD (Chemical Oxygen Demand) adalah parameter yang mengukur kuantitas senyawa kimia dan organik dalam suatu larutan yang dapat mengoksidasi oksigen. Nilai COD yang tinggi menunjukkan tingkat pencemaran air yang tinggi karena adanya senyawa yang dapat mengurangi kadar oksigen di dalam air, berpotensi merusak ekosistem air.'
        ],
        'nitrat' => [
            'rentangNilai' => '0 - 50 mg/L',
            'keterangan' => 'Nitrat adalah garam atau senyawa kimia yang terbentuk dari unsur nitrogen (N) dan oksigen (O). Senyawa nitrat yang paling umum adalah ion nitrat (NO3-), yang terdiri dari satu atom nitrogen dan tiga atom oksigen. Ion nitrat adalah bentuk teroksidasi nitrogen yang penting dalam kimia dan biologi. itrat dalam kualitas air adalah parameter penting yang sering diukur dan dimonitor dalam pengawasan kualitas air. Kandungan nitrat dalam air dapat memiliki implikasi signifikan terhadap kesehatan manusia, ekologi perairan, dan pengelolaan sumber daya alam.'
        ],
        'tss' => [
            'rentangNilai' => '0 - 50 mg/L',
            'keterangan' => 'Total Suspended Solids (TSS) adalah parameter yang mengukur total jumlah padatan atau partikel padat yang terlarut dalam air. TSS mencakup partikel-partikel seperti lumpur, debu, kotoran, dan bahan organik yang mengambang di dalam air. Kadar TSS yang tinggi dalam air dapat mengindikasikan tingkat pencemaran dan dapat memengaruhi kualitas air serta keberlanjutan lingkungan perairan.'
        ],
        'debit_air' => [
            'rentangNilai' => 'm3/s',
            'keterangan' => 'Debit air mengacu pada jumlah air yang mengalir melalui suatu saluran atau sistem pada suatu waktu tertentu. Ini adalah ukuran kuantitas air yang dilewati atau digunakan dalam jaringan perpipaan, sungai, saluran irigasi, atau instalasi lainnya. Debit air diukur dalam berbagai satuan, seperti liter per detik (L/s), meter kubik per detik (m³/s), atau galon per menit (GPM), tergantung pada negara dan sistem pengukuran yang digunakan. Debit air penting untuk pemantauan dan manajemen sumber daya air, seperti pasokan air minum, irigasi pertanian, dan perencanaan ekosistem sungai.'
        ],
        'dissolver_oxygen' => [
            'rentangNilai' => '5 - 8 mg/L',
            'keterangan' => 'Dissolved Oxygen (DO), atau oksigen terlarut dalam air, adalah parameter penting dalam ilmu lingkungan dan pengelolaan air. DO merujuk pada jumlah oksigen yang larut dalam air, yang sangat penting untuk kelangsungan hidup organisme akuatik, seperti ikan, mikroorganisme, dan makhluk air lainnya.'
        ],
        'turbidity' => [
            'rentangNilai' => '0- 40 NTU',
            'keterangan' => 'Turbidity adalah ukuran sejauh mana partikel-partikel padat tersuspensi dalam air mengaburkan atau mengurangi transparansi air. Pengukuran turbiditas sering digunakan untuk mengukur kualitas air. Turbiditas biasanya diukur dalam unit NTU (Nephelometric Turbidity Units).'
        ],
        'salinity' => [
            'rentangNilai' => '0- 10 PSU',
            'keterangan' => 'Salinity mengacu pada konsentrasi garam atau garam terlarut dalam air. Ini dapat diukur dalam berbagai satuan, termasuk PSU (Practical Salinity Units) atau ppt (parts per thousand).'
        ],
        'tds' => [
            'rentangNilai' => '0 - 50 ppm',
            'keterangan' => 'Total Dissolved Solids (TDS) mengacu pada jumlah total zat terlarut yang ada dalam air. Ini termasuk mineral, garam, logam, dan senyawa kimia lainnya. TDS diukur dalam satuan ppm (parts per million) atau mg/L (miligram per liter).'
        ],
        'orp' => [
            'rentangNilai' => '-1000 - 1000 mV',
            'keterangan' => 'Oxygen Reduction Potential (ORP) mengukur tingkat potensial oksidasi atau reduksi dalam air. Ini sering digunakan sebagai indikator kualitas air dan kontrol proses dalam aplikasi pengolahan air.'
        ],
        'temperature_air' => [
            'rentangNilai' => '10 - 35°C',
            'keterangan' => 'Temperature Air adalah suhu air yang dapat mempengaruhi kelangsungan hidup organisme akuatik dan memengaruhi sifat fisik air, seperti tingkat oksigen terlarut.'
        ],
        'water_level_cm' => [
            'rentangNilai' => '0- 100 CM',
            'keterangan' => 'Water Level (Tinggi Air) mengacu pada tinggi atau kedalaman permukaan air. Ini bisa diukur dalam berbagai unit, termasuk sentimeter (cm) dan persentase (persen), tergantung pada konteks pengukuran. Misalnya, "Water Level cm" mengukur kedalaman air dalam sentimeter, sementara "Water Level Persen" mungkin mengacu pada tingkat isi (kapasitas) suatu waduk atau tangki air.'
        ],
        'water_level_persen' => [
            'rentangNilai' => '0 - 100 %',
            'keterangan' => 'Water Level (Tinggi Air) mengacu pada tinggi atau kedalaman permukaan air. Ini bisa diukur dalam berbagai unit, termasuk sentimeter (cm) dan persentase (persen), tergantung pada konteks pengukuran. Misalnya, "Water Level cm" mengukur kedalaman air dalam sentimeter, sementara "Water Level Persen" mungkin mengacu pada tingkat isi (kapasitas) suatu waduk atau tangki air.'
        ],
        'status_pompa' => [
            'rentangNilai' => '',
            'keterangan' => 'Status pompa merujuk pada keadaan atau kondisi dari sebuah sistem pompa, apakah sedang dalam keadaan aktif (hidup) atau tidak aktif (mati). '
        ],
    ];

    foreach ($sensors as $sensorName => $sensorInfo) {
        $existingSensor = Sensor::where('namaSensor', $sensorName)->first();

        if (!$existingSensor) {
            Sensor::create([
                'namaSensor' => $sensorName,
                'rentangNilai' => $sensorInfo['rentangNilai'],
                'keterangan' => $sensorInfo['keterangan'],
            ]);
        }
    }

}
}
