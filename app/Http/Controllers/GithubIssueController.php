<?php

namespace App\Http\Controllers;

use App\Rules\Gitrepo;
use Illuminate\Http\Request;

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
//        return $validatedData;
    }
}
