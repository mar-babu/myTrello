<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Workspace;

class WorkspaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('workspaces')->truncate();
        Schema::enableForeignKeyConstraints();

        $workspaces = [
            ['name' => 'Office', 'description' => 'Office purposes workspace'],
            ['name' => 'Personal', 'description' => 'Personal purposes workspace'],
            ['name' => 'Communication', 'description' => 'Communication purposes workspace'],
            ['name' => 'Travel', 'description' => 'Travel purposes workspace'],
            ['name' => 'Hobby', 'description' => 'Hobby purposes workspace'],
        ];

        collect($workspaces)->each(function($role){
            Workspace::create($role);
        });
    }
}
