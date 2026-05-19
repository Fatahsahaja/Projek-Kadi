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
            ['nis' => '10001', 'nama' => 'Ahmad Fauzi',      'kelas' => 'X RPL 2',   'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '10002', 'nama' => 'Budi Santoso',     'kelas' => 'X RPL 3',   'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '10003', 'nama' => 'Citra Dewi',       'kelas' => 'X RPL 2',   'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '10004', 'nama' => 'Dian Pratama',     'kelas' => 'X RPL 1',   'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '10005', 'nama' => 'Eka Susanti',      'kelas' => 'X RPL 2',   'jurusan' => 'Rekayasa Perangkat Lunak'],

            // Kelas XI RPL
            ['nis' => '11001', 'nama' => 'Fatah Rizki Gunawan',    'kelas' => 'XI RPL 1',  'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '11002', 'nama' => 'Gilang Ramadhan',  'kelas' => 'XI RPL 3',  'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '11003', 'nama' => 'Hana Safitri',     'kelas' => 'XI RPL 1',  'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '11004', 'nama' => 'Irfan Hakim',      'kelas' => 'XI RPL 1',  'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '11005', 'nama' => 'Jihan Aulia',      'kelas' => 'XI RPL 2',  'jurusan' => 'Rekayasa Perangkat Lunak'],

            // Kelas XII RPL
            ['nis' => '12001', 'nama' => 'Kevin Pratama',    'kelas' => 'XII RPL 1', 'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '12002', 'nama' => 'Laila Nurhayati',  'kelas' => 'XII RPL 2', 'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '12003', 'nama' => 'Muhammad Rizki',   'kelas' => 'XII RPL 3', 'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '12004', 'nama' => 'Nadia Putri',      'kelas' => 'XII RPL 2', 'jurusan' => 'Rekayasa Perangkat Lunak'],
            ['nis' => '12005', 'nama' => 'Omar Abdillah',    'kelas' => 'XII RPL 1', 'jurusan' => 'Rekayasa Perangkat Lunak'],

            // Kelas X TKJ
            ['nis' => '10101', 'nama' => 'Putri Rahayu',     'kelas' => 'X TKJ 1',   'jurusan' => 'Teknik Komputer dan Jaringan'],
            ['nis' => '10102', 'nama' => 'Qori Ananda',      'kelas' => 'X TKJ 1',   'jurusan' => 'Teknik Komputer dan Jaringan'],
            ['nis' => '10103', 'nama' => 'Rafi Firmansyah',  'kelas' => 'X TKJ 2',   'jurusan' => 'Teknik Komputer dan Jaringan'],

            // Kelas XI Teknik Komputer dan Jaringan
            ['nis' => '11101', 'nama' => 'Sari Indah',       'kelas' => 'XI TKJ 1',  'jurusan' => 'Teknik Komputer dan Jaringan'],
            ['nis' => '11102', 'nama' => 'Taufik Hidayat',   'kelas' => 'XI TKJ 3',  'jurusan' => 'Teknik Komputer dan Jaringan'],
        ];

        foreach ($data as $item) {
            NisTemplate::create($item);
        }
    }
}
