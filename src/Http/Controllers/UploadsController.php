<?php

namespace SmartyStudio\SmartyCms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller
{
	/**
	 * Get uploaded file from default storage.
	 *
	 * @param file $filename
	 *
	 * @return response
	 */
	public function Index($filename)
	{
		if (Storage::exists($filename)) {
			$file = Storage::url($filename);

			$imginfo = getimagesize($file);
			header("Content-type: {$imginfo['mime']}");
			readfile($file);

			return readfile($file);
		} else {
			abort(404);
		}
	}
}
