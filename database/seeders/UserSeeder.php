<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use App\Models\Jabatan;
use App\Models\Jenis;
use App\Models\Korlap;
use App\Models\Organisasi;
use App\Models\Region;
use App\Models\SubRegion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $jeniss = [
            [
                'name' => 'peserta',
            ],
            [
                'name' => 'korlap',
            ],
            [
                'name' => 'panitia',
            ],
            [
                'name' => 'satgas',
            ],
        ];
        Jenis::insert($jeniss);

        $jabatans =
            [
                [
                    'nama_jabatan' => 'ketua'
                ],
                [
                    'nama_jabatan' => 'waka'
                ]
            ];
        Jabatan::insert($jabatans);



        $region = [
            [
                'no' => '0001',
                'name_region' => 'Banyumas',
            ],
            [
                'no' => '0002',
                'name_region' => 'Tasikmalaya',
            ]
        ];

        Region::insert($region);

        $subregion = [
            [
                'no' => '0001',
                'name_sub_region' => 'Ngapak',
                'region_id' => Region::where('name_region', 'Banyumas')->first()->value('id')
            ],
            [
                'no' => '0002',
                'name_sub_region' => 'Ngidul',
                'region_id' => Region::where('name_region', 'Tasikmalaya')->first()->value('id')
            ]
        ];

        SubRegion::insert($subregion);

        $organisasis = [
            [
                'no' => '0001',
                'sub_region_id' => SubRegion::where('name_sub_region', 'Ngapak')->first()->value('id'),
                'nama_organisasi' => 'JJKP',
                'alamat_organisasi' => 'JL.Merdeka'
            ],
            [
                'no' => '0002',
                'sub_region_id' => SubRegion::where('name_sub_region', 'Ngidul')->first()->value('id'),
                'nama_organisasi' => 'BPPK',
                'alamat_organisasi' => 'JL.Sudirman'
            ]
        ];
        Organisasi::insert($organisasis);



        $users = [
            [
                'nik' => '01.01.01.001',
                'nik' => '2200996643',
                'jk' => 'Laki-Laki',
                'username' => 'admin',
                'name' => 'Rizki',
                'phone' => '08951111112',
                'jabatan_id' => Jabatan::where('nama_jabatan', 'ketua')->first()->value('id'),
                'jenis_id' => Jenis::where('name', 'peserta')->first()->value('id'),
                'organisasi_id' => Organisasi::where('nama_organisasi', 'BPPK')->first()->value('id'),
                'email' => 'ki@admin.com',
                'address' => 'JL.Jagad',
                'password' => bcrypt('123123123'),
            ],
            [
                'nik' => '01.01.01.002',
                'nik' => '2200996655443',
                'jk' => 'Perempuan',
                'username' => 'spv',
                'name' => 'Santuy',
                'phone' => '08951111113',
                'jabatan_id' => Jabatan::where('nama_jabatan', 'waka')->first()->value('id'),
                'jenis_id' => Jenis::where('name', 'peserta')->first()->value('id'),
                'organisasi_id' => Organisasi::where('nama_organisasi', 'JJKP')->first()->value('id'),
                'email' => 'admin@mas.com',
                'address' => 'JL.Gando',
                'password' => bcrypt('123123123'),
            ]
        ];
        User::insert($users);
    }
}
