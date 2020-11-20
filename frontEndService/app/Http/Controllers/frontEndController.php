<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;



class frontEndController extends Controller{

	///// 3 methods 

	public function __construct(){}

	/////////1-lookup
	public function getBook($id){
		$url = '';
		$startQuery1 = microtime(true);
		if (Cache::has($id)){	
			$bookValue = Cache::get($id);	
			$endcache1 = microtime(true); 
			echo "cache:" . ($endcache1 - $startQuery1);
			return response()->json(json_decode($bookValue));
		}
		
		$num = rand(1,4);
		if ($num < 3)
		{
		    $url = 'http://192.168.12.141:8000/query/bookid/' . $id;
		}
		else 
		{
			$url = 'http://192.168.12.141:8001/query/bookid/' . $id;
		}
	   
		// get book from catalogue

		$page = file_get_contents($url); 
		Cache::put($id , $page ,300);	
		$end = microtime(true); 
		echo "done put the book in the cache:" . ($end - $startQuery1);
		return response()->json(json_decode($page));
	}



	//2- search
	public function getAllBooks($item){

		// make a query
		$startQuery2 = microtime(true);	
		if (Cache::has($item))
		{	
			$valueBook = Cache::get($item);	
			$endcache2 = microtime(true); 
			echo " time of cache:" . ($endcache2 - $startQuery2);
			return response()->json(json_decode($valueBook));
		}

		$url = '';
		$randomNum = rand(1,4); 
		if ($randomNum < 3){
			$url = 'http://192.168.12.141:8000/query/booktopic/' . $item;
		}
		else {
			$url = 'http://192.168.12.141:8001/query/booktopic/' . $item;		
		}

/////////////////////////////////////
// get the topics from catalogue
		$page = file_get_contents($url); 
		Cache::put($topic , $page ,300);	
		$end = microtime(true); 
		echo "ooget from cache:" . ($end - $startQuery2);
		return response()->json(json_decode($page));
	}
	
	//
	


////3-buy
	
public function buyBook($id){
	$startQuery3 = microtime(true);	
	if (Cache::has('Buy' . $id))
	{	// check if the item in cache
		$bookidvalue = Cache::get('Buy' . $id);	
		$val = json_decode($bookidvalue)->Message;
		if ($val != 'Your Buy operation done successfuly.')
		{
			$endcache3 = microtime(true); 
			echo "cache:" . ($endcache2 - $startQuery3);
			return response()->json(json_decode($bookidvalue));
		}
		Cache::forget('Buy' . $id);
	}

	$url = '';
	$num = rand(1,4);
	if ($num < 3)
	{
		$url = 'http://192.168.12.142:8000/buy/' . $id;
	}
	else
	 {
		  $url = 'http://192.168.12.142:8001/buy/' . $id;
		}

	$page = file_get_contents($url);
	Cache::put('Buy'.$id , $page ,60);	//// put it in cache
	$end = microtime(true); // end time of query without cache
	echo "put the book in the cache :" . ($end - $startQuery3);
	return response()->json(json_decode($page));
}	
//








}
