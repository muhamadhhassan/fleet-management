<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

trait TruncateTable
{
    public function truncate($table)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}