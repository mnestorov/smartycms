<?php

namespace SmartyStudio\SmartyCms\Tests\Unit;

use SmartyStudio\SmartyCms\Tests\SmartyCmsTestCase;

class ConsoleTest extends SmartyCmsTestCase
{
	public function tearDown() : void
	{
		parent::tearDown();
	}

	public function testInstall()
	{
		$this->assertTrue(0 < $this->artisan('smartycms:install', [
            'prefix'    => 'admin',
            'admin'     => 'admin',
            'email'     => 'admin@example.com',
            'password'  => '123'
        ]));
	}
}
