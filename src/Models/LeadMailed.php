<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class LeadMailed extends Model
{
	protected $fillable = [
		'email',
		'subject',
		'body',
	];
}
