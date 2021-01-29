<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Flynsarmy\CsvSeeder\CsvSeeder;

class UserSeeder extends CsvSeeder
{

    public function __construct()
    {
        $this->filename = base_path().'/database/seeders/csvs/employees.csv';
        $this->connection = 'mysql';
        $this->table = 'users';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::disableQueryLog();
        parent::run();  
    }
}
