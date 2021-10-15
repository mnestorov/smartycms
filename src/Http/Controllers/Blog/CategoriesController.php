<?php

namespace SmartyStudio\SmartyCms\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SmartyStudio\SmartyCms\Models\BlogCategory;
use SmartyStudio\SmartyCms\Traits\HelpersTrait;
use SmartyStudio\SmartyCms\Validations\BlogCategoryValidation;

class CategoriesController extends Controller
{
	use HelpersTrait;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$blogs = BlogCategory::orderBy('title')->get();

		return view('admin::blog_categories.index', compact('blogs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getNew()
	{
		$category = new BlogCategory();

		$blogs = BlogCategory::all();

		return view('admin::blog_categories.category', compact('category', 'blogs'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $category_id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getEdit($category_id)
	{
		$category = BlogCategory::find($category_id);

		$blogs = BlogCategory::all();

		return view('admin::blog_categories.category', compact('category', 'blogs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postSave(Request $request, $category_id)
	{
		// validation
		$validation = Validator::make($request->all(), BlogCategoryValidation::rules(), BlogCategoryValidation::messages());

		if ($validation->fails()) {
			return back()->withInput()->withErrors($validation);
		}

		if ($category_id == 'new') {
			$category = new BlogCategory();
		} else {
			$category = BlogCategory::find($category_id);
		}

		$category->fill($request->all());

		if ($request->has('thumb')) {
			$category->thumb = $this->saveImageWithRandomName($request->file('thumb'), 'blog');
		}

		if ($request->input('delete_thumb')) {
			if (Storage::exists($category->thumb)) {
				Storage::delete($category->thumb);
			}

			$category->thumb = null;
		}

		//REPLACE slug
		$category->slug = str_slug($request->title);

		$category->save();

		return redirect($request->segment(1) . '/blog/categories/edit/' . $category->id)->with('success', 'Saved successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $category_id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDelete(Request $request, $category_id)
	{
		$category = BlogCategory::find($category_id)->delete();

		return redirect($request->segment(1) . '/blog/categories/')->with('success', 'Item deleted');
	}
}
