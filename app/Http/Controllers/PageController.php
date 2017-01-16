<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Curl\Curl;

class PageController extends BaseController
{

	public function home(){

		$data['title'] = 'Explore IRS 990 Filings on AWS';

		// Get/set CSV links from cache (too slow to hit AWS server each time)
		$data['valid_csv_links'] = Cache::get('csv_links', function(){

			$links = $this->get_csv_links();

			Cache::put('csv_links', $links, 604800); // cache for 1 week

			return $links;

		});

		// Get/set JSON links from cache (too slow to hit AWS server each time)
		$data['valid_json_links'] = Cache::get('json_links', function(){

			$links = $this->get_json_links();

			Cache::put('json_links', $links, 604800); // cache for 1 week

			return $links;

		});

		return view('page/home', $data);

	}

	///////////////
	// Protected //
	///////////////

	protected function get_csv_links(){

		// Get year range - current year and back to 2011, when the files start
		$years = range(2011, date('Y'));

		// CSV Links
		$valid_csv_links = array();

		foreach ($years as $year){

			$csv_url = "https://s3.amazonaws.com/irs-form-990/index_$year.csv";

			$curl = new Curl;
			$curl->head($csv_url);

			if (!$curl->error){
				$valid_csv_links[$year] = $csv_url;
			}

		}

		return $valid_csv_links;

	}

	protected function get_json_links(){

		// Get year range - current year and back to 2011, when the files start
		$years = range(2011, date('Y'));

		// JSON Links
		$valid_json_links = array();

		foreach ($years as $year){

			$json_url = "https://s3.amazonaws.com/irs-form-990/index_$year.json";

			$curl = new Curl;
			$curl->head($json_url);

			if (!$curl->error){
				$valid_json_links[$year] = $json_url;
			}

		}

		return $valid_json_links;

	}

}
