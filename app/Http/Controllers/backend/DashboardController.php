<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_category;
use DB;
use DateTime;
use App\Models\User;

class DashboardController extends Controller
{
	public function sales_dashboard(){
	 $quotation = DB::table('quotations')->select('total')->sum('total');
	 $invoices = DB::table('invoices')->select('total')->sum('total');
	 $payment = DB::table('invoices')->select('total')->where('status','completed')->sum('total');
	 $installation = DB::table('jobsheets')->where('installation_status','1')->orderBy('id','DESC')->take(5)->get();
	 $invoice = DB::table('invoices')->where('status','pending')->orderBy('id','DESC')->get();
	 $pieChart = DB::table('quotations')->select(\DB::raw("COUNT(*) as count"), \DB::raw("status as month_name"))
        ->groupBy('month_name')
        ->orderBy('count')
        ->get();
	 $inpieChart = DB::table('invoices')->select(\DB::raw("COUNT(*) as count"), \DB::raw("status as month_name"))
        ->groupBy('month_name')
        ->orderBy('count')
        ->get();
		
		$week_start = date( 'Y-m-d', strtotime( 'monday this week' ) );
		$week_end = date( 'Y-m-d', strtotime( 'sunday this week' ) );
	 $invoice_conversion = DB::table('invoices')->where('status','completed')->whereBetween('completed_at',[$week_start, $week_end])->sum('total');
	 $commission = DB::table('invoices')->where('status','completed')->get();
	 return view('backend.sales-dashboard',compact('quotation','invoices','payment','installation','invoice','pieChart','inpieChart','invoice_conversion','commission'));
	}
	
	public function googlePieChart()
    {
       // $fruit = User::where('id','1')->get();
    	// $veg = User::where('id','30')->get();
    	// $grains = User::where('id','41')->get();
    	// $fruit_count = count($fruit);    	
    	// $veg_count = count($veg);
    	// $grains_count = count($grains);
    	
		$data['lineChart'] = DB::table('quotations')->select(\DB::raw("COUNT(*) as count"), \DB::raw("status as month_name"))
        ->groupBy('month_name')
        ->orderBy('count')
        ->get();
 
        return view('backend.googlePieChart', $data);
		
		
		 // $pieChart = DB::table('quotations')->select(\DB::raw("COUNT(*) as count"), \DB::raw("status as month_name"))
        // ->groupBy('month_name')
        // ->orderBy('count')
        // ->get();
		// return view('backend.googlePieChart',compact('pieChart'));
    }
    
    public function commission(Request $request){
        if($request->input('search')){
           $search =$request->input('search');
           $commission = DB::table('invoices')->where('status','completed')->where('invoice_id', 'LIKE',"%{$search}%")->paginate(10);  
        }
        else{
           $commission = DB::table('invoices')->where('status','completed')->paginate(10);
        }
         return view('backend.commission',compact('commission'));
    }
	
	public function deleteall(Request $request){
	    if($request->id){
	     $update = DB::table("invoices")->whereIn('id',$request['id'])->update([
		 'status'			=>'pending',
		 'completed_at'		=>NULL,
		]);   
		return redirect()->back()->with('success', 'Record removed from commission.'); 
	    }
	    return redirect()->back()->with('error', 'Please select atleast one record.'); 
	   
	}
	
	public function delete($id){
	   $orders = DB::table('invoices')->where('id',$id)->update([
		 'status'			=>'pending',
		 'completed_at'		=>NULL,
		]); 
	   return redirect()->back()->with('success', 'Record removed from commission.');	
	   
	}
	
	public function details(Request $request){
	    $commission = DB::table('invoices')->where('id',$request['id'])->first();
	    $date1 = new DateTime($commission->created_at);
		$date2 = new DateTime($commission->completed_at);
		$interval = $date1->diff($date2);
		if($interval->days<7){
		$percentage ="4";	
		}
		elseif($interval->days>=8 && $interval->days<=14){
		$percentage ="3.5";	
		}
		elseif($interval->days>=15 && $interval->days<=40){
		$percentage ="3";	
		}
		elseif($interval->days>=41 && $interval->days<=75){
		$percentage ="2";	
		}
		else{
		$percentage ="1";		
		}
		$earning = $commission->total*$percentage/100;
		$result="";
		$result.='<div class="row row-cols-3 mb-3">
                            <div class="col">
                                <p><b>Earning:</b></p>
                            </div>
                            <div class="col">
                                <p>'.$earning.'</p>
                            </div>
                        </div>
                        <div class="row row-cols-3 mb-3">
                            <div class="col">
                                <p><b>Percentage:</b></p>
                            </div>
                            <div class="col">
                                <p>'.$percentage.'</p>
                            </div>
                        </div>
                        
                        <div class="row row-cols-3  mb-3">
                            <div class="col">
                                <p><b>Date of Payment:</b></p>
                            </div>
                            <div class="col">
                                <p>'.$commission->completed_at.'</p>
                            </div>
                        </div>
                        <div class="row row-cols-3 mb-5">
                            <div class="col">
                                <p><b>Sale Amount:</b></p>
                            </div>
                            <div class="col">
                                <p>'.number_format($commission->total).'</p>
                            </div>
                        </div>
                        
                        <div class="row row-cols-3 mb-3">
                            <div class="col">
                                <p><b>Invoice Number:</b></p>
                            </div>
                            <div class="col">
                                <p>'.$commission->invoice_id.'</p>
                            </div>
                        </div>';
		return Response($result);
	}
	
}
