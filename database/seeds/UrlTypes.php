<?php

use Illuminate\Database\Seeder;

class UrlTypes extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$data = [
			[
				'name' => 'URL Rotator',
				'code' => 'rotator',
				'icon' => 'rotator.png',
				'description' => 'Rotate as many URLs as you’d like. This can be used to rank on Amazon for as many long-tail keywords as you desire.',
			],
			[
				'name' => 'Seeker (SFB) URL',
				'code' => 'seeker',
				'icon' => 'seeker.png',
				'description' => 'Amazon rewards natural searches that convert into sales. We make it easier for customers to naturally find your product on Amazon, and allow you easily rotate keywords as well. This can help give you some rank juice when the sale occurs.',
			],
			[
				'name' => '2-STEP VIA FIELD-ASIN',
				'code' => '2-step-field-asin',
				'icon' => 'step-field.png',
				'description' => 'A link that searches products with a field ASIN filter. This is used for ranking on Amazon for keywords.',
			],
			[
				'name' => '2-STEP VIA HIDDEN KEYWORD',
				'code' => '2-step-hidden-keyword',
				'icon' => 'keyword.png',
				'description' => 'A link that searches products with a keyword filter. This is used for ranking on Amazon for keywords.',
			],
			[
				'name' => '2-STEP VIA BRAND',
				'code' => '2-step-brand',
				'icon' => 'step-brand.png',
				'description' => 'A link that searches products with a brand filter. This is used for ranking on Amazon for keywords.',
			],
			[
				'name' => '2-STEP VIA STOREFRONT',
				'code' => '2-step-storefront',
				'icon' => 'storefront.png',
				'description' => 'A link that search products with a store filter. This is used for ranking on Amazon for keywords.',
			],
			[
				'name' => 'BUY TOGETHER',
				'code' => 'buy-together',
				'icon' => 'buy-together.png',
				'description' => 'coming soon',
			],
			[
				'name' => 'ADD TO CART',
				'code' => 'add-to-cart',
				'icon' => 'add-cart.png',
				'description' => 'coming soon',
			],
			[
				'name' => 'CANONICAL URL',
				'code' => 'canonical-url',
				'icon' => 'canonical-url.png',
				'description' => 'coming soon',
			],
		];
		DB::table('url_types')->insert($data);
	}
}
