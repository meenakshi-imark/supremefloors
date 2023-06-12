<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Mail;
use App\Mail\InvoiceReminder;


class InvoiceController extends Controller
{
	public function index(){
		$suppliers = DB::table('suppliers')->select('id','person_name')->orderBy('person_name','ASC')->get();
		$products = DB::table('products')->select('id','product_name','product_category')->orderBy('product_name','ASC')->get();
		return view('backend.sales-invoice',compact('suppliers','products'));
		
	}
	
	public function insert(Request $request){
		if(empty($request['supplierid'])){
			return redirect()->back()->with('error', 'Please enter a valid attention user.');
		}
		$product_id = implode(",",$request['product']);
		$quantity = implode(",",$request['quantity']);
		$unit = implode(",",$request['unit']);
		$unit_price = implode(",",$request['unitprice']);	
		$price = implode(",",$request['price']);	
		$services = implode(",",$request['services']);
		$serviceprice = implode(",",$request['serviceprice']);	
		$unnitprice = trim(str_replace("$","",$unit_price));
		$price1 = trim(str_replace("$","",$price));
		$invoice_id = rand(0, 999999);
		
		 $insert = DB::table("invoices")->
		 insert([
		 'invoice_id'			=>$request['invoiceid'],
		 'company'				=>$request['owner'],
		 'address'				=>$request['address'],
		 'attention_to'			=>$request['supplierid'],
		 'phone'				=>$request['phone'],
		 'email'				=>$request['email'],
		 'due_date'				=>$request['duedate'],
		 'installer'			=>$request['installer'],
		 'product_id'			=>$product_id,
		 'quantity'				=>$quantity,
		 'unit'					=>$unit,
		 'unit_price'			=>$unnitprice,
		 'amount'				=>$price1,
		 'services'				=>$services,
		 'serviceprice'			=>$serviceprice,
		 'site_address'			=>$request['site_address'],
		 'invoice'				=>$request['description'],
		 'gst'					=>$request['gst'],
		 'rebates'				=>$request['rebates'],
		 'subtotal'				=>trim(str_replace("$","",$request['subtotal'])),
		 'total'				=>trim(str_replace("$","",$request['totalamt'])),
		 'status'				=>'pending',
		 ]);

		 $find_inv_id = DB::getPdo()->lastInsertId();
		 

	 if($insert){
		$inv_decrptn = json_encode($request->description);
		$rep_subtotal = trim(str_replace("$","",$request->subtotal));
		$rep_total = trim(str_replace("$","",$request->totalamt));
		$subtotal = json_encode($rep_subtotal);
		$total = json_encode($rep_total);
		$gst = json_encode($request->gst);
		$invoice_no = json_encode($request->invoiceid);
		$due_date = json_encode($request->duedate);

		$prd_id = explode(',',$product_id);
		$product_no = [];
		foreach($prd_id as $prd){
			$p_table = DB::table('products')->where('id',$prd)->first();
			$product_no[] = $p_table->product_no;
		}
		$cnt_arr = count($product_no);

		$qty = explode(',',$quantity);
        $unit_price = explode(',',$unnitprice);
		$price = explode(',',$price1);

		$name = rand(999,11);
		$c_nm = json_encode($name);

		$user_id = $request->supplierid;
		$user = DB::table('users')->where('id',$user_id)->first();
		$contact_name = json_encode($user->name);

		$inv_lineitems = [];
		// for($i=0; $i<=$cnt_arr-1; $i++)
		// {
		// $inv_lineitems[] = '{
		// 	"ItemCode": '.$product_no[$i].',
		// 	"Description": '.$inv_decrptn.',
		// 	"Quantity": '.$qty[$i].',
		// 	"UnitAmount": '.$unit_price[$i].',
		// 	"TaxType": "OUTPUT",
		// 	"TaxAmount": "19.67",
		// 	"LineAmount": '.$price[$i].',
		// 	"AccountCode": "200",
		// 	"Tracking": [
		// 		{
		// 		"TrackingCategoryID": "e2f2f732-e92a-4f3a-9c4d-ee4da0182a13",
		// 		"Name": "Region",
		// 		"Option": "North"
		// 		}
		// 	]
		// 	}';
		// }

		for($i=0; $i<=$cnt_arr-1; $i++)
		{
		$inv_lineitems[] = [
			'ItemCode' => $product_no[$i],
			'Description' => $inv_decrptn,
			'Quantity' => $qty[$i],
			'UnitAmount' => $unit_price[$i],
			'TaxType' => 'OUTPUT',
			'TaxAmount' => '0',
			"LineAmount" => $price[$i],
			'AccountCode' => '3-3901',
			'Tracking' => [
                [
				'TrackingCategoryID' => 'e2f2f732-e92a-4f3a-9c4d-ee4da0182a13',
				'Name' => 'Region',
				'Option' => 'North'
				]
			]
		];
		}

		
		$line_items = json_encode($inv_lineitems,JSON_PRETTY_PRINT);

		$refresh_token = DB::table('xiro_token')->first();
		$client_id = $refresh_token->client_id;
		$client_secret = $refresh_token->secret_key;
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
		  $new_token = DB::table('xiro_token')->first();
		  
		  // create contact in xero

			$curl2 = curl_init();

			curl_setopt_array($curl2, array(
			CURLOPT_URL => 'https://api.xero.com/api.xro/2.0/Contacts',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
			"Contacts": [
				{
				"Name": '.$contact_name.'
				}
			]
			}
			',
			CURLOPT_HTTPHEADER => array(
				'xero-tenant-id:'.$new_token->tenant_id,
				'Authorization: Bearer '.$new_token->access_token.'',
				'Accept: application/json',
				'Content-Type: application/json',
				'Cookie: _abck=3895DFCC99B16A86767318BE44CCDE91~-1~YAAQlQVaaJP/vAmHAQAANAcfDgk1xQa5CNyAShqjx0yo/lhLN9t+M+Uc0ZamGf6688qdtPEuO6E4+SDOQzQPK2CfxBwZT1zENnR3FXXUK7/mufbLoiz+SjUkCDsj8/xWsqU8DqgEMLFR/hiPuIIEg35eMA+bWQBD2k56NVdP5LO6t5JN6MlndRxHCVdMAMxoeKPz6PZi6xnLPUb7r/j9pCldrabPGkn++YrhI/931NO6QcdbRwN4H92fofX0iLYdg1H1+ly2wDGx4HoioQolID3We1YXVzcOs7ntP8hgCit4w8lvYQvUoC4FBiB8b4D9I7pjTPWsuZjf5KAjdBOzTS/a19ByKaxU5eog1yeIWbuuUYDrIWksf6NYsqeHZ+4CAJ+bCKs=~-1~-1~-1; ak_bmsc=FB13E8E19B6ED9913C013891E0771068~000000000000000000000000000000~YAAQlQVaaJT/vAmHAQAANAcfDhM2LmWpK1cSYgK2CBrrAzc0XTaSqxiJoITJ0bglPJ3QNhxf5l0CoLlN1iz9G9MyRchJ9OuYr3+M1avUXvctal1dwkEWbGRkk46sacrHKWlLxzTE1snB7h6TKRfCr6pWPTCGV7+1EbMkSy0UzytyWU5AuFVJ5PI8ZkQtBG7zh8i5MT3IxRdiJQlY2bqVMuMRD+GsmAs7wrz7Wd6+pFya8putOdsXWrD0Jnc4+kXxR//KEI3/zx4i6Wk0bNI2ho4PUsW7RbOGhPeWfa/I9PUEQdW9i2ub0ssjqavqDVNNdugTtbt2rHbDYIYmvJMxnMNoJ/DFfEKHMoowAf0pDU5ickA8xqv5b89x; bm_sv=CC9871DC4393B991CB2B0E5CBCD43419~YAAQlQVaaPRUvQmHAQAA9uMjDhO3+7Vgl2aT31X/03/cBFdMfS8iBoDbiwIIEWdNciUKQhbPa69aW2T+4H7EQPHcsFII/70OEPy4U4SRD8YMDZ8VahlysR45pX/szxKSszT1c9Y3ICVPWydo8FGzYgsO28bQu/6abG5kP5C9XThmJFhzFhsrmMdg4t04PBCgk97FkOyUOu5TS4LnXwYBWEW9eKyE8fiXyxtfBpHwA0X9zeuzkx8d4iOi1itGJA==~1; bm_sz=FED4837CD033A02859502F8485B624C0~YAAQlQVaaJf/vAmHAQAANAcfDhN+/O7I+C0Fqb+ZYvd+1ElB2qlPG05KWn7yVFn1MGj5PCgtgmAEmQ/VE0XcmRcvKUOjI+HeywEfYrReTeby2cUr4jfM4afChM9r/vaLos4zmnvQkrBwkaH+cUhws1vidZWFh+Mco1bFqErLJBbzEruYYObex64xtzPbUTByLpg7gAMzfSG70g4cRwvLlUNrZlLJ/8rtp78XqckYRWZPs1rpc2lYQ+iAk4EilLNWfIqfuH8wWdFFOmQZV3V5jmWYe7CqQZ7QyQeozCVxJKQu~3621701~3687233'
			),
			));

			$response2 = curl_exec($curl2);

			curl_close($curl2);
			$json_vl = json_decode($response2, true);
			//  dd($json_vl['Contacts'][0]);

			$update_contactid = DB::table('users')->where('id',$user_id)->update(['contact_id'=>$json_vl['Contacts'][0]['ContactID']]);

		//   create invoice in xero
		  $usr_cntctid = DB::table('users')->where('id',$user_id)->first();
		  $cont_id = json_encode($usr_cntctid->contact_id);
		  $cont_name = json_encode($usr_cntctid->name);
		//   dd($usr_cntctid);
			$curl1 = curl_init();

			curl_setopt_array($curl1, array(
			CURLOPT_URL => 'https://api.xero.com/api.xro/2.0/Invoices',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
			"Invoices": [
				{
				"Type": "ACCREC",
				"Contact": {
					"ContactID": '.$cont_id.',
					"name": '.$cont_name.'
				},
				"DateString": "2009-09-08T00:00:00",
				"DueDateString": '.$due_date.',
				"ExpectedPaymentDate": "2009-10-20T00:00:00",
				"InvoiceNumber": '.$invoice_no.',
				"Reference": "Ref:Supreme",
				"BrandingThemeID": "",
				"Url": "http://www.accounting20.com",
				"CurrencyCode": "SGD",
				"Status": "SUBMITTED",
				"LineAmountTypes": "Inclusive",
				"SubTotal": "",
				"TotalTax": '.$gst.',
				"Total": '.$total.',
				"LineItems": '.$line_items.'
				}
			]
			}',
			CURLOPT_HTTPHEADER => array(
				'xero-tenant-id:'.$new_token->tenant_id,
				'Authorization: Bearer '.$new_token->access_token.'',
				'Accept: application/json',
				'Content-Type: application/json',
				
			),
			));

			$response1 = curl_exec($curl1);
			curl_close($curl1);
			$invoice_vl = json_decode($response1, true);
			// echo'<pre>';print_r($invoice_vl);echo'</pre>';exit();
			$update_invoiceid = DB::table('invoices')->where('id',$find_inv_id)->update(['xero_invoice_id'=>$invoice_vl['Invoices'][0]['InvoiceID']]);

		\LogActivity::addToLog('Create new invoice.');
		return redirect('/all-invoice')->with('success', 'Invoice created successfully.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
	public function show(Request $request){
		if($request->input('search')){
		$search = $request->input('search');
		$invoices = DB::table("invoices")->where('invoice_id', 'LIKE',"%{$search}%")->orderBy('id','DESC')->paginate(10);
		}
		else{
		$invoices = DB::table('invoices')->orderBy('id','DESC')->paginate(10);
		}
		return view('backend.all-invoice',compact('invoices'));
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("invoices")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one record.'); 
		}
	}
	
	public function status_change($id , $approval){
		  $getpo  = DB::table('invoices')->where('id',$id)->first();
		  $update = DB::table("invoices")->where('id',$id)->update(['status'=>$approval,'completed_at'=>date('Y-m-d')]);
		  $users = DB::table('users')->select('email')->where('id',$getpo->attention_to)->first();
		  \LogActivity::addToLog('Update invoice status.');
		  Mail::to($users->email)->send(new InvoiceReminder($approval));

    // generate token

		$refresh_token = DB::table('xiro_token')->first();
		$client_id = $refresh_token->client_id;
		$client_secret = $refresh_token->secret_key;
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
		  $new_token = DB::table('xiro_token')->first();

	//   update status of invoice in xero

		$inv_id = $getpo->invoice_id;
		$encode_inv_id = json_encode($inv_id);

			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.xero.com/api.xro/2.0/Invoices/'.$encode_inv_id.'',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
				"InvoiceNumber": '.$encode_inv_id.',
				"Status": "AUTHORISED",
				"SentToContact": "true"
			}
			
			',
			CURLOPT_HTTPHEADER => array(
				'xero-tenant-id:'.$new_token->tenant_id,
				'Authorization: Bearer '.$new_token->access_token.'',
				'Accept: application/json',
				'Content-Type: application/json',
				'Cookie: _abck=3895DFCC99B16A86767318BE44CCDE91~-1~YAAQn2PUF44p0QeHAQAA4c8IEwlp/kP9x5xpaNEW1l4pxumHtWfNwyhRVZdjqRx8ODDPwFHWiO6/bRZSCQL6JSuZjL1QEAMSHvecjGuQNWZwVBUmx6eR3MC318vROsAMf1f6RY0Xm+QlWpm7mqYUrNpFXNUqAtL89WxRO436R3wf7+XqwBduAnjPcbIi4baXhpuW62GMqSWVDXI1mxVhyaZfzackGnZLX4UOaHamMwm+Q0nL41p4dlqRhNVOkUcaOXoZGMTENfDaQ0DTU6IEvuZrRy5YnBUI+eMWA0oJb47QbwNJWRHTj4pqihF9QlKECyVkKF8ezKPRlzkQO7mPkviZNIIKO9XKyfz799z3tNLRr1X08FAD2aFDrj0LTdQe1T8pkYE=~-1~-1~-1; ak_bmsc=F17F9862EFDE3B98675989F7FE9D5CC3~000000000000000000000000000000~YAAQn2PUF48p0QeHAQAA4c8IExMLpTLIz8Jx9pVdg94LOVhSUZWrOtmd4k+B2TRwdH6IDSw5xudoKRxaCYt77g0Tt/tvLrX78fnvuKtOrCMPXNN0YaWYwhrN19NMHH20eGOmNHBb1zCyR6N+pCqqUNqCu3UvHspqjQbkN8BtLqTWpnDRcvVLdQ36w4BLgVngrRFGR4WSJ4XfFNgZM9ZTufCebP2P3BMEz9GuLAHKxWo3rzpxp51elxFydx5fQkp0O9bXAxS/H+woqZojcYN45PpMBa/W2wVZElxbmtaklV9Eboldbgp+zuLnYW2MwUaPIjHv7jOpCPHyiz+9m7ULvsJSCOAKRwwo3Jgzuv1TocesicxBVYp4vFE=; bm_sv=718D205551AAF12AB6B75E7461E034B6~YAAQfF06Fxr/pQqHAQAAyXYPExOWetR2vp2aGRfn7wOT7AfE1rmswVyaB8fWrk90Jd1UOuGU+WODKh3Pf9HMyQqiiAt5OKNHmZ8pal5ClXBT7Csadnx0N3u9dh5/EhXU4HnQygGVPBBL9qXEZxjYo75Uk0CcO+rx4cxpmaXDVeNdGRDoaEaFDGw02M4MhH9yHCtzwhe4+Rb/iV0VeWl0jJfrahF4SJFCGO+sFu830KpKkTIA7x7DTCcP+NLVSA==~1; bm_sz=3BA892B7AE7AC0A1F433A20F7B5B4826~YAAQn2PUF5Ap0QeHAQAA4c8IExN7Yql5ofUqdOJbtJF54ZK27NliwuFh8H5+84ga+MeJUdW9upcb/uIWtDY3nPgEr+amOeU2KB2SBPLKn3iWo31nizQqLUt9+zyBbkwbTpMi9yBAMvn5kd6YsV+RvG7Rm3ies/evnx4uu3mljt07mdIP4f4q3R9kHSnc9YPsEZFrt7kz0MUKZdKQamdU1op3f9eQA1BM+Qn44ADQTFhaxist16I2/PYZx4rW1EVVCMKWzdgO7wT34n6FmdvPUtxSN9IDiC80Y5m1vRlGOkx7~3556407~3158084'
			),
			));
			
			$response = curl_exec($curl);
			
			curl_close($curl);
			// dd($response);
	


		  return redirect()->back()->with('success', 'Status updated successfully.'); 
	}
	
	public function delete($id){
	   $orders = DB::table('invoices')->where('id',$id)->delete();
	   return redirect()->back()->with('success', 'Invoice deleted successfully.');	
	}
	
		
	public function pdf($id, Request $request){
		if($request->has('download')){  
		 $invoice = DB::table('invoices')->where('id',$id)->first();
		 $getproducts['products'] = explode(",",$invoice->product_id);
		 $getquantity['quantity'] = explode(",",$invoice->quantity);
		 $getunit['unit'] = explode(",",$invoice->unit);
		 $getunit_price['price'] = explode(",",$invoice->unit_price);
		 $getprice['amount'] = explode(",",$invoice->amount);
		 $arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice);
         $pdf = PDF::loadView('backend.invoice-pdf',compact('invoice','arr'));  
         return $pdf->download('invoice.pdf');  
        } 	
	}
	
	public function edit($id){
		$products = DB::table('products')->select('id','product_name','product_category')->orderBy('product_name','ASC')->get();
		$invoice = DB::table('invoices')->where('id',$id)->first();
		$suppliers = DB::table('users')->select('id','name')->where('id',$invoice->attention_to)->get();
		$getproducts['products'] = explode(",",$invoice->product_id);
		$getquantity['quantity'] = explode(",",$invoice->quantity);
		$getunit['unit'] = explode(",",$invoice->unit);
		$getunit_price['price'] = explode(",",$invoice->unit_price);
		$getprice['amount'] = explode(",",$invoice->amount);
		$sevices['sevices'] = explode(",",$invoice->services);
		$serviceprice['serviceprice'] = explode(",",$invoice->serviceprice);
		$arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice,$sevices,$serviceprice);
		return view('backend.invoice-edit-invoice',compact('suppliers','products','invoice','arr'));
	}
	
	public function update(Request $request){
		$find_up_id = DB::table("invoices")->where('id',$request['id'])->first();
		$xero_inv_id = $find_up_id->xero_invoice_id;
		$encode_xero_inv_id = json_encode($xero_inv_id);

		$product_id = implode(",",$request['product']);
		$quantity = implode(",",$request['quantity']);
		$unit = implode(",",$request['unit']);
		$unit_price = implode(",",$request['unitprice']);	
		$price = implode(",",$request['price']);	
		$services = implode(",",$request['services']);	
		$serviceprice = implode(",",$request['serviceprice']);	
		$unnitprice = trim(str_replace("$","",$unit_price));
		$price1 = trim(str_replace("$","",$price));
		$update = DB::table("invoices")->where('id',$request['id'])->update([
		 'invoice_id'			=>$request['invoiceid'],
		 'company'				=>$request['owner'],
		 'address'				=>$request['address'],
		 'attention_to'			=>$request['supplierid'],
		 'phone'				=>$request['phone'],
		 'email'				=>$request['email'],
		 'due_date'				=>$request['duedate'],
		 'installer'			=>$request['installer'],
		 'product_id'			=>$product_id,
		 'quantity'				=>$quantity,
		 'unit'					=>$unit,
		 'unit_price'			=>$unnitprice,
		 'amount'				=>$price1,
		 'services'				=>$services,
		 'serviceprice'			=>$serviceprice,
		 'site_address'			=>$request['site_address'],
		 'invoice'				=>$request['description'],
		 'gst'					=>$request['gst'],
		 'rebates'				=>$request['rebates'],
		 'subtotal'				=>trim(str_replace("$","",$request['subtotal'])),
		 'total'				=>trim(str_replace("$","",$request['totalamt'])),
		]);

	// generate token

			$refresh_token = DB::table('xiro_token')->first();
			$client_id = $refresh_token->client_id;
			$client_secret = $refresh_token->secret_key;
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
			  $new_token = DB::table('xiro_token')->first();

	//   update contact in xero
	      $user_id = $request->supplierid;
		  $usr_cntctid = DB::table('users')->where('id',$user_id)->first();
		  $cont_id = json_encode($usr_cntctid->contact_id);


			$curl_c_up = curl_init();

			curl_setopt_array($curl_c_up, array(
			CURLOPT_URL => 'https://api.xero.com/api.xro/2.0/Contacts',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
			"ContactID": '.$cont_id.',
			"ContactStatus": "ARCHIVED"
			}

			',
			CURLOPT_HTTPHEADER => array(
				'xero-tenant-id:'.$new_token->tenant_id,
				'Authorization: Bearer '.$new_token->access_token.'',
				'Accept: application/json',
				'Content-Type: application/json',
				'Cookie: _abck=3895DFCC99B16A86767318BE44CCDE91~-1~YAAQtG0/F9MlwQyHAQAALFsAEgnlnan3d55Gd1ODTAbciTUfFlLnnLYsV70hUN3UvqP0k4kNihm3siOOy1TKGFb/kyTuHk/Pg5/t+ZddF90j2DAmHPC3sohCqwG7idG3MxHPXQWZRChCh06ZTuduuRIsq7NpI+5WXvvnoUT3PJyWwpfcU9qebBURnNKryP+FVWtI4dg2zCECsqyMjyRzxhIS5CR3h897oqf8y5qCmghlc4u0ds/+okdjjt3s6IGxL8g5unSkXzUK+V117Wtg67xzF5oiqb1d41ONvPhST7zNGSQmz1SPuODXZRqAtzX+gC+Lhg9S4zketV2OBnlTWVhaegOt2TWofjMyHPkI8nyvaT3NZFq3YHvw5WB/MxFXjrDKBjM=~-1~-1~-1; ak_bmsc=749B387F45D25E93C4DEC7AA8168F86A~000000000000000000000000000000~YAAQtG0/F9QlwQyHAQAALFsAEhOZzEDAvbV9qINaLB4WEOExWBi0Ef4mscmewfgs426OBVAlvqYBwd8wKgbnnaLRwpBpbPFf2pnzpi/WiNrbDTYm3x1Jtq5MEDLGRfgYDDZdP3pl/PGtIkvLuQ+rJtIb07GlgCkU9mVnS+YDVAvz97PMDsUnu7QB5d5Wb+QK4EyKuhUntpA4ScuxXBS58EZxSIkQIAnT4TjEpQWBqXu6xTm6v2Pl/u6zS8AmkNXU8k+NeLjY277kr6pqjS9IAnxzyOrGOr4NqzEXNIZ3n4281DNm02QzaSXNgmgGuzvjGEpc1RdlrBJBCV2To1nE5bmwwOKa/+pLnLQHNLJt81jY9n2g3ktIteU=; bm_sv=B4A34A11BA2DAC0F5CD3C750DF761411~YAAQfF06Fw3BlQqHAQAAEqprEhNlJSWOk+IIF0LATUpkbuI4pl4TnhHu6kcUncwB0v2C10VLZ3dRKVzZZt3AUW/HDwkJxSp81NM+lA+P9FVygJA16alMvzcA+TItgQFn9cBINdESMGe/X5YVqOkDvQpQ3N4qlJjfquhjsQIHv4lztP5imiXMKwLDFSuQP2YuaG5D/bfm7qL5AOSYOlA3t6BI6owiYWLrEGMAPlDDxrG+vuEfEGu9gsc80DZQHX0=~1; bm_sz=75EA25FBC173488AF26D787D788CA95B~YAAQtG0/F9UlwQyHAQAALFsAEhM7J1uH9Gsnmo4lWUp9H5PHx9zumCZOFO0xotogT6roWEd1uXeezgi0ubEDFIXEO/FihTzbovzsDqQ/DuOrScHjjwB/UCsSZ3rH4oeOHwDferHOAp2mmyCu9HQ4114/AcGI0HVcR4qc8rv2MA4KcGoWKPoKPSmlTcG6bIi1MCZ9duGpSzUV0oynUUlSTY9Dlsyk0Q1Q6ZQaNATU9mOhgXVdU06CjfnxWv9XA8qjcRir+Gf71u1dduFfezDUcCTuSngeOgt3q4pUkLhvH3HS~3160390~4469049'
			),
			));

			$response_c_up = curl_exec($curl_c_up);

			curl_close($curl_c_up);
			// dd($response_c_up);

	//   update invoice in xero

			$curl_up = curl_init();

			curl_setopt_array($curl_up, array(
			CURLOPT_URL => 'https://api.xero.com/api.xro/2.0/Invoices',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
				"InvoiceID": '.$encode_xero_inv_id.',
				// "SentToContact": "true"
			}
			',
			CURLOPT_HTTPHEADER => array(
				'xero-tenant-id:'.$new_token->tenant_id,
				'Authorization: Bearer '.$new_token->access_token.'',
				'Accept: application/json',
				'Content-Type: application/json',
			),
			));

			$response_up = curl_exec($curl_up);

			curl_close($curl_up);
			// dd($response_up);

			return redirect()->back()->with('success', 'Invoice updated successfully.');
		
	}
	
	public function getdetails(Request $request){
		$data = DB::table('users')->select("email", "phone")->where('id',$request['supid'])->get();
		return response()->json(['results' => $data]);
	}

	public function searchcustomer(Request $request){
		 $data = DB::table('users')->select("name as value", "id")->where('name', 'LIKE', '%'. $request->get('search'). '%')->where('customer_type','!=','NULL')
                    ->get();
    
        return response()->json($data);
	}
	
	public function print_invoice($id){
		$invoice = DB::table('invoices')->where('id',$id)->first();
		$getproducts['products'] = explode(",",$invoice->product_id);
		$getquantity['quantity'] = explode(",",$invoice->quantity);
		$getunit['unit'] = explode(",",$invoice->unit);
		$getunit_price['price'] = explode(",",$invoice->unit_price);
		$getprice['amount'] = explode(",",$invoice->amount);
		$arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice);
		return view('backend.invoice-pdf',compact('invoice','arr'));
		
	}

}
