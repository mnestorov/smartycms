<?php

namespace SmartyStudio\SmartyCms\Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Cms;
use SmartyStudio\SmartyCms\Blog;
use SmartyStudio\SmartyCms\Models\BlogCategory;
use SmartyStudio\SmartyCms\Models\BlogPost;
use SmartyStudio\SmartyCms\Models\BlogPostComment;
use SmartyStudio\SmartyCms\Models\Gallery;
use SmartyStudio\SmartyCms\Models\Order;
use SmartyStudio\SmartyCms\Models\Page;
use SmartyStudio\SmartyCms\Models\Product;
use SmartyStudio\SmartyCms\Models\ProductCategory;
use SmartyStudio\SmartyCms\Models\ProductComment;
use SmartyStudio\SmartyCms\Tests\SmartyCmsTestCase;

class PackageTest extends SmartyCmsTestCase
{
	public function tearDown()
	{
		parent::tearDown();
	}

	public function testDefaultConfig()
	{
		$this->assertArraySubset(['route_prefix' => 'administration', 'google_map_api' => ''], require __DIR__ . '/../../src/config/smartycms.php');
	}

	public function testFacade()
	{
		$this->assertEquals(CMS_test::getFacadeName(), 'sla');
	}

	public function testCMSFacadeHaveBlogModel()
	{
		$this->assertInstanceOf(Blog::class, Cms::Blog());
	}

	public function testCMSFacadeHaveBlogPostModel()
	{
		$this->assertInstanceOf(BlogPost::class, Cms::Blog()->posts());
	}

	public function testCMSFacadeHaveBlogCategoriesModel()
	{
		$this->assertInstanceOf(BlogCategory::class, Cms::Blog()->categories());
	}

	public function testCMSFacadeHaveBlogPostCommentModel()
	{
		$this->assertInstanceOf(BlogPostComment::class, Cms::Blog()->comments());
	}

	public function testCMSFacadeHaveGalleryModel()
	{
		$this->assertInstanceOf(Gallery::class, Cms::gallery());
	}

	public function testCMSFacadeHaveLocationsCollection()
	{
		$this->assertInstanceOf(Collection::class, Cms::locations());
	}

	public function testCMSFacadeHaveMapsCollection()
	{
		$this->assertInstanceOf(Collection::class, Cms::maps());
	}

	public function testCMSFacadeHavePageModel()
	{
		$this->assertInstanceOf(Page::class, Cms::page());
	}

	public function testCMSFacadeHaveShopOrderModel()
	{
		$this->assertInstanceOf(Order::class, Cms::shop()->orders());
	}

	public function testCMSFacadeHaveShopProductModel()
	{
		$this->assertInstanceOf(Product::class, Cms::shop()->products());
	}

	public function testCMSFacadeHaveShopProductCommentModel()
	{
		$this->assertInstanceOf(ProductComment::class, Cms::shop()->comments());
	}

	public function testCMSFacadeHaveShopProductCategoryModel()
	{
		$this->assertInstanceOf(ProductCategory::class, Cms::shop()->categories());
	}

	public function testServiceProvider()
	{
		$this->assertTrue($this->app->bound('sla'));
		$this->assertTrue($this->app->bound('command.smartycms.install'));
		$this->assertTrue($this->app->bound('command.smartycms.update'));
	}

	public function testServiceProviderExtendGuard()
	{
		$this->assertArraySubset(['provider' => 'system-admins'], $this->app->config['auth']['guards']['system-admin']);
		$this->assertArraySubset(['model' => 'SmartyStudio\SmartyCms\Admin'], $this->app->config['auth']['providers']['system-admins']);
	}
}

class CMS_test extends \SmartyStudio\SmartyCms\Facades\Cms
{
	public static function getFacadeName()
	{
		return parent::getFacadeAccessor();
	}
}
