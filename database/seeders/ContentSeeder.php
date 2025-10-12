<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContentSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$sqlPath = database_path('sql/contents.sql');

		if (File::exists($sqlPath)) {
			DB::unprepared(File::get($sqlPath));
			$this->command->info('Company info SQL imported successfully.');
		} else {
			$this->command->error('SQL file not found: ' . $sqlPath);
		}
	}
}
