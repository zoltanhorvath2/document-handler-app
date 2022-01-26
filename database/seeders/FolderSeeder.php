<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $counter = 10;

        for($i = 1; $i <= $counter; $i++){
            DB::table('folders')->insert([
                'parent_id' => 0,
                'folder_name' => 'Category ' . $i,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for($i = 1; $i <= $counter; $i++){
            DB::table('folders')->insert([
                'parent_id' => $i,
                'folder_name' => 'Subfolder1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
