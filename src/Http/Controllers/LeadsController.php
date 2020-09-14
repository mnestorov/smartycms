<?php

namespace SmartyStudio\SmartyCms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SmartyStudio\SmartyCms\Models\Lead;
use SmartyStudio\SmartyCms\Models\LeadMailed;
use SmartyStudio\SmartyCms\Models\LeadSetting;

class LeadsController extends Controller
{
	public function __construct()
	{
		if (config('smartycms.modules.leads') == false) {
			return redirect(config('smartycms.route_prefix'))->with('error', 'Leads module is disabled in config/smartycms.php')->send();
		}
	}

	/**
	 * Pages controller index page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$leads = Lead::paginate(15);

		return view('admin::leads.index', compact('leads'));
	}

	public function getEdit($lead_id)
	{
		$lead = Lead::find($lead_id);
		$data = json_decode($lead->data);

		return view('admin::leads.edit', compact('lead', 'data'));
	}

	public function getDelete(Request $request, $lead_id)
	{
		$lead = Lead::find($lead_id)->delete();

		return redirect($request->segment(1) . '/leads');
	}

	public function getSettings()
	{
		$setting = LeadSetting::first();

		return view('admin::leads.settings', compact('setting'));
	}

	public function postSettings(Request $request)
	{
		$data = [
			'mailer_name'       => !empty($request->mailer_name) ? $request->mailer_name : null,
			'thank_you_subject' => !empty($request->thank_you_subject) ? $request->thank_you_subject : null,
			'thank_you_body'    => !empty($request->thank_you_body) ? $request->thank_you_body : null,
		];

		$setting = LeadSetting::first();

		!empty($setting->id) ? $setting->update($data) : LeadSetting::create($data);

		return back();
	}

	public function getEmail()
	{
		$leads = Lead::get();

		return view('admin::leads.email', compact('leads'));
	}

	public function postEmail(Request $request)
	{
		if (!is_array($request->receivers)) {
			return back()->withInput()->with(['error' => 'Please select receivers']);
		} else {
			if (empty($request->subject) || empty($request->body)) {
				return back()->withInput()->with(['error' => 'Please fill all message data']);
			}

			$this->emailLeeds($request);

			return back()->with(['success' => 'Mailing done']);
		}
	}

	public function getEditEmail($email_id)
	{
		$mail = LeadMailed::find($email_id);

		return view('admin::leads.edit_mail', compact('mail'));
	}

	/**
	 * Email leads.
	 */
	private function emailLeeds($request)
	{
		$url = explode('.', $request->root());
		$url_count = count($url) - 1;

		foreach ($request->receivers as $receiver) {
			Mail::send('admin::mail.leads', ['body' => $request->body], function ($m) use ($receiver, $url, $url_count, $request) {
				$m->from('noreply@' . $url[$url_count - 1] . '.' . $url[$url_count], $url[$url_count - 1] . '.' . $url[$url_count]);

				$m->to($receiver, $receiver)->subject($request->subject);
			});

			LeadMailed::create([
				'email'   => $receiver,
				'subject' => $request->subject,
				'body'    => $request->body,
			]);
		}

		return true;
	}
}
