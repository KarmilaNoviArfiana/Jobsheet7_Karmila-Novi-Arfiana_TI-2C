<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [   'mahasiswa_id' => 1,
                'matakuliah_id' => 1,
                'nilai' => 88
            ],
            [   'mahasiswa_id' => 1,
                'matakuliah_id' => 2,
                'nilai' => 87
            ],
            [   'mahasiswa_id' => 1,
                'matakuliah_id' => 3,
                'nilai' => 86
            ],
            [   'mahasiswa_id' => 1,
                'matakuliah_id' => 4,
                'nilai' => 90
            ],
            [   'mahasiswa_id' => 3,
                'matakuliah_id' => 1,
                'nilai' => 88
            ],
            [   'mahasiswa_id' => 3,
                'matakuliah_id' => 2,
                'nilai' => 93
            ],
            [   'mahasiswa_id' => 3,
                'matakuliah_id' => 3,
                'nilai' => 85
            ],
            [   'mahasiswa_id' => 3,
                'matakuliah_id' => 4,
                'nilai' => 80
            ],
        ];

        DB::table('mahasiswa_matakuliah')->insert($data);
    }
}