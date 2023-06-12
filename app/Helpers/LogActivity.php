<?php


namespace App\Helpers;
use Request;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{


    public static function addToLog($subject)
    {   
    	$log = [];
    	$log['userid'] = auth()->user()->id;
    	$log['activity'] = $subject;
    	$log['timestamp'] = date("Y-m-d");
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
        if(count($_GET)>0){
        $search = $_GET['search'];
        return LogActivityModel::where('activity','LIKE',"%{$search}%")->latest()->paginate(10);
        }
        else{
    	return LogActivityModel::latest()->paginate(10);
        }
    }


}