<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqCatagoryRequest;
use App\Models\FaqCatagory;

class ManageFaqController extends Controller {
	//

	const active = 'create';
	const title = 'FAQ Catagory';

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
		return view('backend.faq.index', compact('title', 'faqCatagories'));
	}

	/**
	 * Show the form for creating a new user.
	 * @param App\Models\FaqCatagory $faqCatagory
	 * @return \Illuminate\Http\Response
	 */
	public function edit(FaqCatagory $faqCatagory) {
		$title = (object) array(
			'active' => 'edit',
			'title' => self::title,
		);
		$faqCatagories = FaqCatagory::all();
		return view('backend.faq.index', compact('title', 'faqCatagory', 'faqCatagories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param FaqCatagoryRequest $request
	 * @return void
	 */
	public function store(FaqCatagoryRequest $request) {
		try {
			FaqCatagory::create($request->all());
			$request->session()->flash('success', "FAQ catagory created successfully!");
			return redirect()->route('faq.index');
		} catch (Exception $e) {
			$request->session()->flash('error', $e->getMessage());
			return redirect()->route('faq.index');
		}

	}

	/**
	 * Store a newly created resource in storage.
	 * @param App\Models\FaqCatagory $faqCatagory
	 * @param FaqCatagoryRequest $request
	 * @return void
	 */
	public function update(FaqCatagoryRequest $request, FaqCatagory $faqCatagory) {
		try {
			$faqCatagory->name = $request->name;
			$faqCatagory->save();
			$request->session()->flash('success', "FAQ catagory update successfully!");
			return redirect()->route('faq.index');
		} catch (Exception $e) {
			$request->session()->flash('error', $e->getMessage());
			return redirect()->route('faq.index');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param FaqCatagoryRequest $request
	 * @param  \App\Models\FaqCatagory $faqCatagory
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy(FaqCatagoryRequest $request, FaqCatagory $faqCatagory) {
		$request->session()->flash('success', "FAQ catagory deleted!");
		$faqCatagory->delete();
		return redirect()->route('faq.index');
	}
}
