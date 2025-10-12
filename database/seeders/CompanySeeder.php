<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
	public function run(): void
	{
		DB::table('companies')->truncate();

		foreach (User::$company as $company) {
			Company::create([
				'name' => $company['name'],
				'url' => $company['url'],
				'image' => 'images/logo/' .$company['image'],
				'status' => 'active',
				'sort_order' => false
			]);
		}
	}
}
