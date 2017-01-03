<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class SearchController extends Controller
{

	public function search($term){

		$data['title'] = 'Search: ' . htmlspecialchars($term);

		$data['results'] = \App\Filing::search_by_name($term);

		return view('search-results', $data);

	}

}
