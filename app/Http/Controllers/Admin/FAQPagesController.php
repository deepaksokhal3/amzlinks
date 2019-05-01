<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FAQPagesRequest;
use App\Models\FaqCatagory;
use App\Models\FaqPages;

class FAQPagesController extends Controller {
	//

	const active = 'create';
	const title = 'FAQ Pages';
	const item = 5;
	/**
	 * Show the application index.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$title = (object) array(
			'active' => self::active,
			'title' => self::title,
		);
		$faqCatagories = FaqCatagory::all();
		foreach ($faqCatagories as $faqCatagory) {
			$catagories[$faqCatagory->id] = $faqCatagory->name;
		}

		$pages = FaqPages::with('getCatagories')->paginate(self::item);
		return view('backend.faq.pages.index', compact('title', 'pages', 'catagories'));
	}

	/**
	 * Show the form for creating a new user.
	 * @param App\Models\FaqPages $pages
	 * @return \Illuminate\Http\Response
	 */
	public function edit(FaqPages $page) {
		$title = (object) array(
			'active' => 'edit',
			'title' => self::title,
		);
		$faqCatagories = FaqCatagory::all();
		foreach ($faqCatagories as $faqCatagory) {
			$catagories[$faqCatagory->id] = $faqCatagory->name;
		}
		$pages = FaqPages::with('getCatagories')->paginate(self::item);
		return view('backend.faq.pages.index', compact('title', 'catagories', 'page', 'pages'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param FAQPagesRequest $request
	 * @return void
	 */
	public function store(FAQPagesRequest $request) {
		try {
			FaqPages::create($request->all());
			$request->session()->flash('success', "FAQ page created successfully!");
			return redirect()->route('page.index');
		} catch (Exception $e) {
			$request->session()->flash('error', $e->getMessage());
			return redirect()->route('page.index');
		}

	}

	/**
	 * Store a newly created resource in storage.
	 * @param App\Models\FaqPages $page
	 * @param FAQPagesRequest $request
	 * @return void
	 */
	public function update(FAQPagesRequest $request, FaqPages $page) {
		try {
			$page->title = $request->title;
			$page->cat_id = $request->cat_id;
			$page->description = $request->description;
			$page->save();
			$request->session()->flash('success', "FAQ page update successfully!");
			return redirect()->route('page.index');
		} catch (Exception $e) {
			$request->session()->flash('error', $e->getMessage());
			return redirect()->route('page.index');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param FAQPagesRequest $request
	 * @param App\Models\FaqPages $page
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy(FAQPagesRequest $request, FaqPages $page) {
		$request->session()->flash('success', "FAQ page deleted!");
		$page->delete();
		return redirect()->route('page.index');
	}
}
