<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;

class ContactController extends Controller {

	/**
	 * Show the application Contact page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('front.contact.index');
	}

	/**
	 * Show the application Contact page.
	 * @param Illuminate\Http\Request; $request
	 * @return \Illuminate\Http\Response
	 */
	public function sendContactUsMail(Request $request) {
		try {
			$validator = Validator::make($request->all(), [
				'name' => 'required',
				'email' => 'required|email',
				'message' => 'required',
			]);
			if ($validator->fails()) {
				return redirect('contact-us')
					->withErrors($validator)
					->withInput();
			}
			$user = (object) $request->all();
			try {
				Mail::send('emails.contact', ['user' => $user], function ($m) use ($user) {
					$m->from('admin@amzlinks.com', "AMZLinks Notifications");
					$m->replyTo($user->email, $user->name);
					$m->to('admin@amzlinks.com', 'Amzlinks')->subject('Contact us');
				});
			} catch (\Exception $e) {
				echo $e->getMessage();die;
				return redirect()->back()->withErrors(['validMai' => $e->getMessage()]);
			}

			return redirect()->back()->withSuccess('Email successfully sent. We will revert back soon.');
		} catch (Exception $e) {
			return redirect('contact-us');
		}
	}
}
