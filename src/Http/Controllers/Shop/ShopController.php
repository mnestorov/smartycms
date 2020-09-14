<?php

namespace SmartyStudio\SmartyCms\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
	public function __construct()
	{
		if (config('smartycms.modules.shop') == false) {
			return redirect(config('smartycms.route_prefix'))->with('error', 'Shop module is disabled in config/smartycms.php')->send();
		}
	}

	/**
	 * Shop index page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		return view('admin::shop.index');
	}
}
