<?php

namespace Database\Seeders;

use App\Models\NisTemplate;
use Illuminate\Database\Seeder;

class NisTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Kelas X RPL
            ['nis' => '10001', 'nama' => 'Ahmad Fauzi',      'kelas' => 'X',   'jurusan' => 'RPL'],
            ['nis' => '10002', 'nama' => 'Budi Santoso',     'kelas' => 'X',   'jurusan' => 'RPL'],
            ['nis' => '10003', 'nama' => 'Citra Dewi',       'kelas' => 'X',   'jurusan' => 'RPL'],
            ['nis' => '10004', 'nama' => 'Dian Pratama',     'kelas' => 'X',   'jurusan' => 'RPL'],
            ['nis' => '10005', 'nama' => 'Eka Susanti',      'kelas' => 'X',   'jurusan' => 'RPL'],

            // Kelas XI RPL
            ['nis' => '11001', 'nama' => 'Fatah Rizki Gunawan',    'kelas' => 'XI',  'jurusan' => 'RPL'],
            ['nis' => '11002', 'nama' => 'Gilang Ramadhan',  'kelas' => 'XI',  'jurusan' => 'RPL'],
            ['nis' => '11003', 'nama' => 'Hana Safitri',     'kelas' => 'XI',  'jurusan' => 'RPL'],
            ['nis' => '11004', 'nama' => 'Irfan Hakim',      'kelas' => 'XI',  'jurusan' => 'RPL'],
            ['nis' => '11005', 'nama' => 'Jihan Aulia',      'kelas' => 'XI',  'jurusan' => 'RPL'],

            // Kelas XII RPL
            ['nis' => '12001', 'nama' => 'Kevin Pratama',    'kelas' => 'XII', 'jurusan' => 'RPL'],
            ['nis' => '12002', 'nama' => 'Laila Nurhayati',  'kelas' => 'XII', 'jurusan' => 'RPL'],
            ['nis' => '12003', 'nama' => 'Muhammad Rizki',   'kelas' => 'XII', 'jurusan' => 'RPL'],
            ['nis' => '12004', 'nama' => 'Nadia Putri',      'kelas' => 'XII', 'jurusan' => 'RPL'],
            ['nis' => '12005', 'nama' => 'Omar Abdillah',    'kelas' => 'XII', 'jurusan' => 'RPL'],

            // Kelas X TKJ
            ['nis' => '10101', 'nama' => 'Putri Rahayu',     'kelas' => 'X',   'jurusan' => 'TKJ'],
            ['nis' => '10102', 'nama' => 'Qori Ananda',      'kelas' => 'X',   'jurusan' => 'TKJ'],
            ['nis' => '10103', 'nama' => 'Rafi Firmansyah',  'kelas' => 'X',   'jurusan' => 'TKJ'],

            // Kelas XI TKJ
            ['nis' => '11101', 'nama' => 'Sari Indah',       'kelas' => 'XI',  'jurusan' => 'TKJ'],
            ['nis' => '11102', 'nama' => 'Taufik Hidayat',   'kelas' => 'XI',  'jurusan' => 'TKJ'],
        ];

        foreach ($data as $item) {
            NisTemplate::create($item);
        }
    }
}
