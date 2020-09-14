<?php

namespace SmartyStudio\SmartyCms\Tests\Unit;

use SmartyStudio\SmartyCms\Models\Page;
use SmartyStudio\SmartyCms\Tests\SmartyCmsTestCase;
use SmartyStudio\SmartyCms\Traits\HelpersTrait;

class TraitTest extends SmartyCmsTestCase
{
	use HelpersTrait;

	public function testSanitizeElement()
	{
		$this->assertEquals($this->sanitizeElements('Aa123--1aax\#!adAafaS/ccaa-'), 'aa1231aaxadaafasccaa');
	}

	public function testGenerateNestedPageList()
	{
		$page = factory(Page::class)->create();

		$this->assertEquals($this->generateNestedPageList($page->get()), '<ul class="border"><li><a href="pages/edit/' . $page->id . '">' . $page->title . '</a></li></ul>');
	}
}
