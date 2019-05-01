<?php

namespace App\Http\Controllers;
use App\Models\FaqCatagory;
use App\Models\FaqPages;

class FAQController extends Controller {

	/**
	 * Show the application FAQ page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$catagories = FaqCatagory::all();
		return view('front.faq.index', compact('catagories'));
	}

	/**
	 * Show the application FAQ.
	 *
	 * @param Illuminate\Http\Request; $catId
	 * @return \Illuminate\Http\Response
	 */
	public function view($tab) {
		$catagories = FaqCatagory::all();
		$title = FaqCatagory::find($tab)->name;
		$pages = FaqPages::whereCatId($tab)->get(['id', 'title']);
		$view = (count($pages) > 0) ? 'index' : 'comingsoon';
		return view('front.faq.catagory.' . $view, compact('tab', 'catagories', 'pages', 'title'));
	}

	/**
	 * Show the application FAQ inner pages.
	 *
	 * @param Illuminate\Http\Request; $tab,$pageId
	 * @return \Illuminate\Http\Response
	 */
	public function viewInner($tab, $pageId) {
		$page = FaqPages::with('getCatagories')->find($pageId);
		return view('front.faq.catagory.inner-page', compact('catagories', 'page'));
	}
}
