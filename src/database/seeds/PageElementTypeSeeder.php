<?php

namespace SmartyStudio\SmartyCms\Database\Seeds;

use Illuminate\Database\Seeder;
use SmartyStudio\SmartyCms\Models\PageElementType;

class PageElementTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		PageElementType::create(['title' => 'Text']);
		PageElementType::create(['title' => 'HTML']);
		PageElementType::create(['title' => 'File']);
	}
}
