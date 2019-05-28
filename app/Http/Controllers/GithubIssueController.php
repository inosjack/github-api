<?php

namespace App\Http\Controllers;

use App\Rules\Gitrepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GithubIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllIssue(Request $request)
    {
        //
        $validatedData = $request->validate([
            'url' =>  ['required', 'string', new Gitrepo],
        ]);

        $explodeUrl = explode('/',$validatedData['url']);

        $owner_name = $explodeUrl[count($explodeUrl) -2];

        $repos = explode('.',$explodeUrl[count($explodeUrl) -1]);

        $repo_name = $repos[0];

        $nub_of_open_in_last_24h = 0;
        $nub_of_open_in_last_24h_lt_7d = 0;
//        - Number of open issues that were opened more than 7 days ago
        $nub_of_open_more_thn_7d = 0;
        $total_open_issue = 0;
        $link = 'rel="next"';
        $page =0;
        while (strpos($link, 'rel="next"') !== false) {
            $page++;
            $fetch_data_from_github = self::fetchIssuesFromGithub($owner_name,$repo_name,$page);
            if (isset($fetch_data_from_github['status']) and $fetch_data_from_github['status'] === 'fail') {
                return response()->json(
                    ['view' => view('openissuetable',$fetch_data_from_github)->render()]
                );
            }
            $link = $fetch_data_from_github['links'][0];
            $total_open_issue = $fetch_data_from_github['total_open_issue'];
            $nub_of_open_in_last_24h += $fetch_data_from_github["nub_of_open_in_last_24h"];
            $nub_of_open_in_last_24h_lt_7d += $fetch_data_from_github["nub_of_open_in_last_24h_lt_7d"];
            $nub_of_open_more_thn_7d = $total_open_issue - ($nub_of_open_in_last_24h + $nub_of_open_in_last_24h_lt_7d);
        }


        $data['status'] = 'success';
        $data['nub_of_open_in_last_24h'] = $nub_of_open_in_last_24h;
        $data['nub_of_open_in_last_24h_lt_7d'] = $nub_of_open_in_last_24h_lt_7d;
        $data['nub_of_open_more_thn_7d'] = $nub_of_open_more_thn_7d;
        $data['total_open_issue'] = $total_open_issue;

        return response()->json(
            [
                'view' => view('openissuetable',$data)->render(),
                'status' => 'success'
            ]
        );


    }


    public static function fetchIssuesFromGithub($owner_name,$repo_name,$page=1,$per_page=100) {
        $url = "https://api.github.com/search/issues?q=repo:{$owner_name}/{$repo_name}+type:issue+state:open&page={$page}&per_page={$per_page}";

        $client = new \GuzzleHttp\Client();
        try {
            $request = $client->get($url)
                ->withHeader( "Accept","application/vnd.github.symmetra-preview+json")
                ->withHeader( "User-Agent", "GITHUB-LARAVEL-API");
            $response = $request->getBody()->getContents();
        }
        catch (\Exception $exception) {
            return [
                'status' => 'fail',
                'httpCode' => $exception->getCode(),
                'error' => "Something went wrong! Try after sometime."
            ];
        }
        $response_array = json_decode($response);
        $items = $response_array->items;
        $http_code = $request->getStatusCode();
        $headers = $request->getHeaders();

        if ($http_code != 200) {
            return [
                'httpCode' => $http_code,
                'error' => "Something went wrong"
            ];
        }

        $collection= collect($items);

        //    - Number of open issues that were opened in the last 24 hours
        $nub_of_open_in_last_24h = $collection->filter(function ($item, $key) {
            return Carbon::now()->diffInHours(Carbon::parse($item->created_at)) <= 24;
        })->count();
        //  - Number of open issues that were opened more than 24 hours ago but less than 7 days ago
        $nub_of_open_in_last_24h_lt_7d = $collection->filter(function ($item, $key) {
            return Carbon::now()->diffInHours(Carbon::parse($item->created_at)) >= 24 and Carbon::now()->diffInDays(Carbon::parse($item->created_at)) <= 7;
        })->count();

        return [
            'nub_of_open_in_last_24h' => $nub_of_open_in_last_24h,
            'nub_of_open_in_last_24h_lt_7d' => $nub_of_open_in_last_24h_lt_7d,
            'total_open_issue' => $response_array->total_count,
            'links' => $headers['Link']
        ];
    }
}
