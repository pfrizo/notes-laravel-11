<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notes')->insert([
            [
                'user_id' => 1,
                'title' => 'Note 1',
                'text' => "Note 1's text",
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 1,
                'title' => 'Note 2',
                'text' => "Note 2's text",
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2,
                'title' => 'Note 3',
                'text' => "Note 3's text",
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
