<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;


class SearchController extends Controller
{

	public function search(Request $request){

		$data['search_term'] = $request->get('term');

		if (empty($data['search_term'])){

			$data['title'] = 'No results found';

			return view('search-results', $data);

		}

		$data['title'] = 'Search: ' . htmlspecialchars($request->get('term'));

		$data['results'] = \App\Filing::search_by_name($request->get('term'));

		return view('search-results', $data);

	}

}
