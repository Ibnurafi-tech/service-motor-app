<?php

namespace Database\Seeders;

use App\Models\DaftarService;
use App\Models\DataService;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\PembayaranService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Data Dummy Pelanggan
        $pelanggans = [
            [
                'id_pelanggan' => 'PLG-001',
                'nama_lengkap' => 'Muhammad Ibnu Rafi',
                'no_hp'        => '081264551101',
                'alamat'       => 'Jl. Merdeka No. 12, Banda Sakti, Lhokseumawe',
                'pekerjaan'    => 'Mahasiswa',
            ],
            [
                'id_pelanggan' => 'PLG-002',
                'nama_lengkap' => 'Teuku Rizky Pratama',
                'no_hp'        => '085277889902',
                'alamat'       => 'Jl. Samudera Baru No. 45, Lhokseumawe',
                'pekerjaan'    => 'Karyawan Swasta',
            ],
            [
                'id_pelanggan' => 'PLG-003',
                'nama_lengkap' => 'Cut Putri Nabila',
                'no_hp'        => '082233445503',
                'alamat'       => 'Jl. Darussalam No. 8, Muara Dua, Lhokseumawe',
                'pekerjaan'    => 'Wiraswasta',
            ],
        ];

        foreach ($pelanggans as $pelanggan) {
            Pelanggan::updateOrCreate(
                ['id_pelanggan' => $pelanggan['id_pelanggan']],
                $pelanggan
            );
        }

        // 2. Data Dummy Kendaraan
        $kendaraans = [
            [
                'no_plat'         => 'BL 4521 KQ',
                'jenis_kendaraan' => 'Matic',
                'no_stnk'         => 'STNK-20230011',
                'tahun_pembuatan' => 2023,
                'nama_pemilik'    => 'Muhammad Ibnu Rafi',
                'warna_kendaraan' => 'Hitam Matte',
            ],
            [
                'no_plat'         => 'BL 2190 KR',
                'jenis_kendaraan' => 'Manual Transmisi',
                'no_stnk'         => 'STNK-20210045',
                'tahun_pembuatan' => 2021,
                'nama_pemilik'    => 'Teuku Rizky Pratama',
                'warna_kendaraan' => 'Merah Putih',
            ],
            [
                'no_plat'         => 'BL 6789 KS',
                'jenis_kendaraan' => 'Matic',
                'no_stnk'         => 'STNK-20240089',
                'tahun_pembuatan' => 2024,
                'nama_pemilik'    => 'Cut Putri Nabila',
                'warna_kendaraan' => 'Putih Mutiara',
            ],
        ];

        foreach ($kendaraans as $kendaraan) {
            Kendaraan::updateOrCreate(
                ['no_plat' => $kendaraan['no_plat']],
                $kendaraan
            );
        }

        // 3. Data Dummy Daftar Service
        $daftarServices = [
            [
                'id_servis'         => 'SRV-001',
                'no_plat'           => 'BL 4521 KQ',
                'id_pelanggan'      => 'PLG-001',
                'keluhan_kendaraan' => 'Tarikan awal bergetar (gredek) dan ganti oli mesin rutin',
                'tanggal_servis'    => '2026-11-15',
            ],
            [
                'id_servis'         => 'SRV-002',
                'no_plat'           => 'BL 2190 KR',
                'id_pelanggan'      => 'PLG-002',
                'keluhan_kendaraan' => 'Rantai kendor, rem depan kurang pakem, dan tune up',
                'tanggal_servis'    => '2026-11-16',
            ],
            [
                'id_servis'         => 'SRV-003',
                'no_plat'           => 'BL 6789 KS',
                'id_pelanggan'      => 'PLG-003',
                'keluhan_kendaraan' => 'Servis berkala 5.000 km dan cek tekanan ban',
                'tanggal_servis'    => '2026-11-17',
            ],
        ];

        foreach ($daftarServices as $service) {
            DaftarService::updateOrCreate(
                ['id_servis' => $service['id_servis']],
                $service
            );
        }

        // 4. Data Dummy Pengerjaan / Data Service
        $dataServices = [
            [
                'id_servis'           => 'SRV-001',
                'estimasi_service'    => '45 Menit',
                'nama_mekanik'        => 'Bang Hendra',
                'sparepart_pengganti' => 'Oli MPX2 0.8L, Roller Set KVB, Grease CVT',
            ],
            [
                'id_servis'           => 'SRV-002',
                'estimasi_service'    => '1 Jam',
                'nama_mekanik'        => 'Bang Fajar',
                'sparepart_pengganti' => 'Kampas Rem Depan Ori, Oli SPX1 1.0L',
            ],
            [
                'id_servis'           => 'SRV-003',
                'estimasi_service'    => '30 Menit',
                'nama_mekanik'        => 'Bang Hendra',
                'sparepart_pengganti' => 'Oli Gardan, Filter Udara',
            ],
        ];

        foreach ($dataServices as $data) {
            DataService::updateOrCreate(
                ['id_servis' => $data['id_servis']],
                $data
            );
        }

        // 5. Data Dummy Pembayaran Service
        $pembayarans = [
            [
                'id_servis'        => 'SRV-001',
                'jumlah_biaya'     => 165000,
                'jenis_pembayaran' => 'Cash / Tunai',
                'keterangan'       => 'Lunas - Servis CVT & Ganti Oli',
            ],
            [
                'id_servis'        => 'SRV-002',
                'jumlah_biaya'     => 140000,
                'jenis_pembayaran' => 'Non Tunai',
                'keterangan'       => 'Lunas via QRIS BSI',
            ],
            [
                'id_servis'        => 'SRV-003',
                'jumlah_biaya'     => 95000,
                'jenis_pembayaran' => 'Cash / Tunai',
                'keterangan'       => 'Lunas - Servis Berkala',
            ],
        ];

        foreach ($pembayarans as $pembayaran) {
            PembayaranService::updateOrCreate(
                ['id_servis' => $pembayaran['id_servis']],
                $pembayaran
            );
        }
    }
}
