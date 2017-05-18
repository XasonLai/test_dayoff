<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use phpQuery; 
use App\Map;

class TestController extends Controller
{

    public function getYou(Request $request){
    	
        $data['str'] = null;

        $data['map'] = Map::all();
        
        return view('test' , $data);
    }

    // public function postYou(Request $request){
    	
    // 	// $html = $request->input('article_title');
    //  //    phpQuery::newDocumentFileHTML($html);
    //  //    $titleElement = pq('div.trans');
    //  //    $str = trim($titleElement->html());
    //  //    $text = strip_tags($str);

    //     // $data['str'] = $str;
    //     // $data['text'] = $text;

    //     return view('test' , $data);
    // }

    public function fix(Request $request){
    	
    	$url = $request->input('url');
    	phpQuery::newDocumentFileHTML($url);
        $titleElement = pq('div.trans');
        $str = trim($titleElement->html());

        return $str;
    }

    public function map(Request $request){
    	$data = $request->input('place');
    	foreach ($data as $key => $value) {
    		$map = new Map;
    		$place_id = $map->where('place_id' , $value['place_id'])->first();
    		if(!isset($place_id)){
    			\DB::table('maps')->insert($value);
    		}
    	}

    	var_dump('don....');
    }
}
