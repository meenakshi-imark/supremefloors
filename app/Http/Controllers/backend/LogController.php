<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class LogController extends Controller
{
	
	public function addtolog()
    {
        \LogActivity::addToLog('My Testing Add To Log.');
        dd('log insert successfully.');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('backend.activity-log',compact('logs'));
    }

    public function delete($id){
       $delete = DB::table('log_activities')->where('id',$id)->delete();
	   return redirect()->back()->with('success', 'Log deleted successfully.');	
    }

    public function deleteall(Request $request){
		if($request->id){
		DB::table("log_activities")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Logs are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one record.'); 
		}
	}

    public function cronjob(){
       
        $client_id = "7F63B5D412D842FE9B6BA4589087E0C6";
        $client_secret = "CsDf1zsr3gZ08CyBh8b-74GHxr5MI0qtndGWqM0RSKy-Dasi";
        $refresh_token = DB::table('xiro_token')->first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://identity.xero.com/connect/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('grant_type' => 'refresh_token','refresh_token' => ''.$refresh_token->refresh_token.'','client_id' => ''.$client_id.'','client_secret' => ''.$client_secret.''),
          CURLOPT_HTTPHEADER => array(
            'grant_type: refresh_token'           
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $json = json_decode($response, true);
       
        $update = DB::table('xiro_token')->where('id',$refresh_token->id)->update(['refresh_token'=>$json['refresh_token'],'access_token'=>$json['access_token']]);
        




         }
}
