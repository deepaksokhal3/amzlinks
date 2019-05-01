<?php

namespace App\Http\Controllers;
use App\Http\Requests\TrackingCodeRequest;
use App\Models\TrackingType;
use App\Models\Tracks;
use Auth;
use Illuminate\Http\Request;

class TrackingController extends Controller {

	function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application created tracking links
	 *
	 * @param Illuminate\Http\Request;by auth user
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data['trackingCodes'] = Tracks::whereUserId(Auth::user()->id)->with('trackingType')->get();
		return view('front.tracking.index')->with($data);

	}

	/**
	 * Show the application create tracking link form
	 *
	 * @param Illuminate\Http\Request; by auth user
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$typeOfCodes = [];
		foreach (TrackingType::all() as $typeOfCode):
			$typeOfCodes[$typeOfCode->id] = $typeOfCode->name;
			$icons[$typeOfCode->id] = ['data-content' => "<i class='" . trim($typeOfCode->icon) . "'></i>" . $typeOfCode->name];
		endforeach;
		return view('front.tracking.add', compact('typeOfCodes', 'icons'));
	}

	/**
	 * Get the application created tracking code
	 *
	 * @param Illuminate\Http\Request; $request by id and auth user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request) {
		if (!$request->input('id')) {
			return redirect('trackings');
		}
		$typeOfCodes = [];
		$track = Tracks::find($request->input('id')); // get traking data by id
		foreach (TrackingType::all() as $typeOfCode):
			$typeOfCodes[$typeOfCode->id] = $typeOfCode->name;
			$icons[$typeOfCode->id] = ['data-content' => "<i class='" . trim($typeOfCode->icon) . "'></i>" . $typeOfCode->name];
		endforeach;
		return view('front.tracking.edit', compact('typeOfCodes', 'icons', 'track'));
	}

	/**
	 * Update the application tracking data by spacific
	 *
	 * @param Tracks $track
	 * @param Illuminate\Http\Request; $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(TrackingCodeRequest $request, Tracks $track) {
		try {
			$track->trackTitle = $request->trackTitle;
			$track->type = $request->type;
			$track->trackCode = $request->trackCode;
			$track->save();
		} catch (Exception $e) {

		}
		return redirect('trackings');

	}

	/**
	 * Submit the application Tracking codein databae
	 *
	 * @param Illuminate\Http\Request; $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(TrackingCodeRequest $request) {
		$request['user_id'] = Auth::user()->id;
		Tracks::create($request->all());
		return redirect('trackings');

	}

	/**
	 * DELETE the application strored Tracking code
	 *
	 * @param Illuminate\Http\Request; $request
	 * @return \Illuminate\Http\Response
	 */
	public function drop(Request $request) {
		if ($request->ajax() && $request->input('id')):
			try {
				Tracks::destroy($request->input('id'));
				echo json_encode(array('sucsess' => 'Tracking Code delete successfully.'));
			} catch (Exception $e) {
				echo json_encode(array('error' => $e->getMessage()));
			}
		endif;
	}
}
