<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('check/url', 'GithubIssueController@getAllIssue')->name('get.all.issue');

//<?php
//
//$curl = curl_init();
//
//curl_setopt_array($curl, array(
//    CURLOPT_URL => "https://api.github.com/search/issues?q=repo:freecodecamp/freecodecamp+type:issue+state:open",
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_ENCODING => "",
//    CURLOPT_MAXREDIRS => 10,
//    CURLOPT_TIMEOUT => 30,
//    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//    CURLOPT_CUSTOMREQUEST => "GET",
//    CURLOPT_POSTFIELDS => "{\n  \"sender_phone\": \"\",\n  \"sender_email\": \"xyz@xyz.com\",\n  \"msg_list\": [\n    {\n      \"id\": 1,\n      \"phone\": \"918955705107\",\n      \"msg\": \"‌​​​‌​​‌‍‌​​​​‌‌​‍‌​​‌‌‌‌​‍‌​​​‌‌‌‌‍‌​​‌‌‌‌​‍‌​​​‌‌​‌hello jayant\"\n    },\n    {\n      \"id\": 7,\n      \"phone\": \"12016141197\",\n      \"msg\": \"‌​​​‌​​‌‍‌​​​​‌‌​‍‌​​‌‌‌‌​‍‌​​​‌‌‌‌‍‌​​‌‌‌‌​‍‌​​​‌‌​‌hello jayant\"\n    }\n  ]\n}",
//    CURLOPT_HTTPHEADER => array(
//        "Accept: application/vnd.github.symmetra-preview+json",
//        "Authorization: Token ecdef6fec7348b042509d146037fa5d6756149ee",
//        "Postman-Token: ae4a7655-8248-4479-8480-d193f0ac9147",
//        "cache-control: no-cache"
//    ),
//));
//
//$response = curl_exec($curl);
//$err = curl_error($curl);
//
//curl_close($curl);
//
//if ($err) {
//    echo "cURL Error #:" . $err;
//} else {
//    echo $response;
//}

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
