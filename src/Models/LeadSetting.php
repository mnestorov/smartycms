<?php

namespace SmartyStudio\SmartyCms\Models;

use Illuminate\Database\Eloquent\Model;

class LeadSetting extends Model
{
	protected $fillable = [
		'mailer_name',
		'thank_you_subject',
		'thank_you_body',
	];
}
