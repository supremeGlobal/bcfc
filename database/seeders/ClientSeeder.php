<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clients')->truncate();

		foreach (Client::$client as $item) {
			Client::create([
				'name' => $item['name'],
				// 'image' => $item['image'] ?? 'images/clients'
			]);
		}
    }
}
