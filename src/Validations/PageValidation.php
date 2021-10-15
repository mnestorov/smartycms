<?php

namespace SmartyStudio\SmartyCms\Validations;

class PageValidation
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public static function rules($page_id = '')
	{
		return [
			'title'           => 'required',
			'elements_prefix' => 'required|unique:pages,elements_prefix,' . $page_id,
			'slug'            => 'required|unique:pages,slug,' . $page_id,
			'description'     => 'required',
		];
	}

	/**
	 * Get the specific message for rules that apply to the request.
	 *
	 * @return array of message
	 */
	public static function messages()
	{
		return [
			//
		];
	}
}
