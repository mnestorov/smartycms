<?php

namespace SmartyStudio\SmartyCms\Http\Controllers\Places;

use App\Http\Controllers\Controller;

class PlacesController extends Controller
{
	public function __construct()
	{
		if (config('smartycms.modules.places') == false) {
			return redirect(config('smartycms.route_prefix'))->with('error', 'Places module is disabled in config/smartycms.php')->send();
		}
	}

	/**
	 * Show all locations.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		return view('admin::places.index');
	}
}
