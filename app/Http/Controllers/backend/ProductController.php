<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    
    public function product_form()
    {
        $product_category = Product_category::all();
        $suppliers = Supplier::all();
        return view('backend.product-create-product',compact('product_category','suppliers'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_product(Request $request)
    {


	// echo"<pre>";print_r($request->all());echo"</pre>";exit();
        // echo "<pre>";
        // print_r($_POST);
        // exit;
		 /* $validations = $request->validate([
                
                'product_no' => 'required|unique:products',
                'product_name' => 'required',
                'product_category' => 'required',
                'min_cost' => 'required',
                'units_per_packet' => 'required',
                'descriptions' => 'required',
                'reorder_qty' => 'required',
                'product_code' => 'required',
                'sizeperunit' => 'required',
                'area' => 'required',
                'p_image'        => 'image|max:500|mimes:png,jpeg',
            ]); */

         if(count($request->product_code)>0){ 
            $count = count($request->product_code)-1;
            for($i=0;$i<$count;$i++){
                
                $new = $request->product_code[$i] .",". $request->pcode[$i] .",". $request->pname[$i] .",". $request->remarks[$i];
                $explode[] = explode(",",$new);
                }
            for($i=0;$i<count($explode);$i++){  
                if(!empty($explode[$i][0])){
                    
                $newval[]= $explode[$i];
                }
                else{
                    $newval[]="";
                }
                    
                }
                
                $data = array_column($newval,0);
                $data2 = array_column($newval,1);
                $data3 = array_column($newval,2);
                $data4 = array_column($newval,3);
    
    
                $productcodess = implode(',',$data);
                $supplieridsss = implode(',',$data2);
                $suppliernamesss = implode(',',$data3);
                $remarkssss = implode(',',$data4);
                // dd($data);
                // echo"<pre>";print_r($data2);echo"</pre>";   
             }
           
            
            
            $product = new Supplier;
            if($request->supplier_name && $request->supplier_email){
            $product->person_name = $request->suppliername;
            $product->email = $request->supplier_email;
            // $product->company_name = null;
            $product->save();
            }
    
            
            
            $products = new Product;
            if($request->file('p_image')){
                $file= $request->file('p_image');
                $filename= $file->getClientOriginalName();
                $file-> move(public_path('admin/productimage'), $filename);
                $products['p_image']= $filename;
            }
            // $product_no = rand(0, 999999);
			
            $products->product_no = $request->product_no;
            $products->product_name = $request->product_name;
            $products->product_category = $request->product_category;
            $products->min_cost = $request->min_cost;
            $products->skirting_type = implode(',', $request->dropdown_group);
            $products->units_per_packet = $request->units_per_packet;
            $products->descriptions = $request->descriptions;
            $products->reorder_qty = $request->reorder_qty;
            $products->sizeperunit = $request->sizeperunit;
            $products->area = $request->area;
            
            
        
            if($product->id && !empty($supplieridsss)){
                $supplierid = $supplieridsss.','.$product->id;
                // echo "<pre>";
                // print_r($supplierid);
                // exit;
                $products->supplier_id = $supplierid;
                
            }
            elseif($product->id ){
                $products->supplier_id = $product->id;
               
            }
            else{
            
            $products->supplier_id = $supplieridsss;
            // dd($products);
            }
    
    
        
        
            if($request->suppliername && !empty($suppliernamesss)){
                $suppliersall = $suppliernamesss.','.$request->suppliername;
                // echo "<pre>";
                // print_r($supplierid);
                // exit;
                $products->supplier_name = $suppliersall;
                
            }
            elseif($request->suppliername){
                $products->supplier_name = $request->suppliername;
            }
            else{
            
            $products->supplier_name = $suppliernamesss;
            }
    // product_code:-
    
    if($request->product_code1 && !empty($productcodess)){
        $productsall = $productcodess.','.$request->product_code1;
        // echo "<pre>";
        // print_r($supplierid);
        // exit;
        $products->product_code = $productsall;
        
    }
    elseif($request->product_code1){
        $products->product_code = $request->product_code1;
    }
    else{
    
    $products->product_code = $productcodess;
    }
    
    // remarks:-
    
    if($request->remarks1 && !empty($remarkssss)){
        $remarksall = $remarkssss.','.$request->remarks1;
        // echo "<pre>";
        // print_r($supplierid);
        // exit;
        $products->remarks = $remarksall;
        
    }
    elseif($request->remarks1){
        $products->remarks = $request->remarks1;
    }
    else{
    
    $products->remarks = $remarkssss;
    }
            
            $products->total_inventry = $request->total_inventry;
            // $products->p_image = $request->p_image;
            // dd($products);
            
        $products->save();
        $id = $product->id;
        /* Get xiro token*/ 
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

          /* Create New Item*/
          $new_token = DB::table('xiro_token')->first();
        //   echo'<pre>';print_r($request['product_name']);echo'</pre>';exit();
             $curl1 = curl_init();

            curl_setopt_array($curl1, array(
            CURLOPT_URL => 'https://api.xero.com/api.xro/2.0/Items',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "Code": '.$request['product_no'].',
            "Name": "'.$request['product_name'].'",
            "Description": "'.$request['descriptions'].'",
            "PurchaseDescription": "'.$request['descriptions'].'",
            "PurchaseDetails": {
                "UnitPrice": '.$request['min_cost'].',
                "AccountCode": "3-3901"
            },
            "SalesDetails": {
                "UnitPrice": '.$request['min_cost'].',
                "AccountCode": "3-3901"
            }
            }',
            CURLOPT_HTTPHEADER => array(
                'xero-tenant-id:'.$new_token->tenant_id,
                'Content-Type: application/json',
                'Authorization: Bearer '.$new_token->access_token.''
            ),
            ));

            $result_item = curl_exec($curl1);

            curl_close($curl1);
            $itemid = strtok($result_item, " ");
            $xml = simplexml_load_string($result_item);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            // $array = explode(' ', $result_item);

            $update = DB::table('products')->where('id',$products->id)->update(['itemid'=>$array['Items']['Item']['ItemID']]);
            

        if($id){
        return redirect()->route('edit_supplier', ['id' => $id])->with('success','Product added successfully! Please fill suppliers fields.');
        }else{
        return redirect()->route('all_products')->with('success','Product added successfully.');
        } 
    }

    
    public function edit_product($id)
    {
        $products = Product::find($id);
        $product_category = Product_category::all();
        $suppliers = Supplier::all();
        return view('backend.product-edit-product',compact('product_category','suppliers','products'));
    }

    
    public function update_product(Request $request,$id)
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        if(count($request->product_code)>0){
            $count = count($request->product_code);
            for($i=0;$i<$count;$i++){
                
                $new = $request->product_code[$i] .",". $request->pcode[$i] .",". $request->pname[$i] .",". $request->remarks[$i];
                $explode[] = explode(",",$new);
                }
            for($i=0;$i<count($explode);$i++){  
                if(!empty($explode[$i][0])){
                    
                $newval[]= $explode[$i];
                }
                else{
                    $newval[]="";
                }
                    
                }
                
                $data = array_column($newval,0);
                $data2 = array_column($newval,1);
                $data3 = array_column($newval,2);
                $data4 = array_column($newval,3);
    
    
                $productcodess = implode(',',$data);
                $supplieridsss = implode(',',$data2);
                $suppliernamesss = implode(',',$data3);
                $remarkssss = implode(',',$data4);
                // dd($data);
                // echo"<pre>";print_r($data2);echo"</pre>";   
             }
            // $validations = $request->validate([
                
            //     'product_no' => 'required|unique:products',
            //     'product_name' => 'required',
            //     'product_category' => 'required',
            //     'min_cost' => 'required',
            //     'units_per_packet' => 'required',
            //     'descriptions' => 'required',
            //     'reorder_qty' => 'required',
            //     'product_code' => 'required',
            //     'p_image'        => 'image|max:500|mimes:png,jpeg',
            // ]);
            
            
            $product = new Supplier;
            if($request->suppliername && $request->supplier_email){
            $product->person_name = $request->suppliername;
            $product->email = $request->supplier_email;
            // $product->company_name = null;
            $product->save();
            }
    
            
            
            $products = Product::find($id);
            if($request->file('p_image')){
                $file= $request->file('p_image');
                $filename= $file->getClientOriginalName();
                $file-> move(public_path('admin/productimage'), $filename);
                $products['p_image']= $filename;
            }
            // $product_no = rand(0, 999999);
            $products->product_no = $request->product_no;
            $products->product_name = $request->product_name;
            $products->product_category = $request->product_category;
            $products->min_cost = $request->min_cost;
            $products->skirting_type = implode(',', $request->dropdown_group);
            $products->units_per_packet = $request->units_per_packet;
            $products->descriptions = $request->descriptions;
            $products->reorder_qty = $request->reorder_qty;
            $products->sizeperunit = $request->sizeperunit;
            $products->area = $request->area;
            
           
        
            if($product->id && !empty($supplieridsss)){
                $supplierid = $supplieridsss.','.$product->id;
                // echo "<pre>";
                // print_r($supplierid);
                // exit;
                $products->supplier_id = $supplierid;
                
            }
            elseif($product->id ){
                $products->supplier_id = $product->id;
               
            }
            else{
            
            $products->supplier_id = $supplieridsss;
            // dd($products);
            }
    
    
        
        
            if($request->suppliername && !empty($suppliernamesss)){
                $suppliersall = $suppliernamesss.','.$request->suppliername;
                // echo "<pre>";
                // print_r($supplierid);
                // exit;
                $products->supplier_name = $suppliersall;
                
            }
            elseif($request->suppliername){
                $products->supplier_name = $request->suppliername;
            }
            else{
            
            $products->supplier_name = $suppliernamesss;
            }
    // product_code:-
    
    if($request->product_code1 && !empty($productcodess)){
        $productsall = $productcodess.','.$request->product_code1;
        // echo "<pre>";
        // print_r($supplierid);
        // exit;
        $products->product_code = $productsall;
        
    }
    elseif($request->product_code1){
        $products->product_code = $request->product_code1;
    }
    else{
    
    $products->product_code = $productcodess;
    }
    
    // remarks:-
    
    if($request->remarks1 && !empty($remarkssss)){
        $remarksall = $remarkssss.','.$request->remarks1;
        // echo "<pre>";
        // print_r($supplierid);
        // exit;
        $products->remarks = $remarksall;
        
    }
    elseif($request->remarks1){
        $products->remarks = $request->remarks1;
    }
    else{
    
    $products->remarks = $remarkssss;
    }
            
            $products->total_inventry = $request->total_inventry;
            // $products->p_image = $request->p_image;
            // dd($products);
            $products->save();
        $id = $product->id;
        
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

          /* Create New Item*/
          $new_token = DB::table('xiro_token')->first();
          $curl1 = curl_init();

          curl_setopt_array($curl1, array(
          CURLOPT_URL => 'https://api.xero.com/api.xro/2.0/Items/'.$products->itemid.'',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "Code": '.$request['product_no'].',
          "Name": "'.$request['product_name'].'",
          "Description": "'.$request['descriptions'].'",
          "PurchaseDescription": "'.$request['descriptions'].'",
          "PurchaseDetails": {
              "UnitPrice": '.$request['min_cost'].',
              "AccountCode": "200"
          },
          "SalesDetails": {
              "UnitPrice": '.$request['min_cost'].',
              "AccountCode": "200"
          }
          }',
          CURLOPT_HTTPHEADER => array(
              'xero-tenant-id:'.$new_token->tenant_id,
              'Content-Type: application/json',
              'Authorization: Bearer '.$new_token->access_token.''
          ),
          ));

          $result_item = curl_exec($curl1);

          curl_close($curl1);

        if($id){
        return redirect()->route('edit_supplier', ['id' => $id])->with('success','Product updated successfully! Please fill suppliers fields.');
        }else{
        return redirect()->route('all_products')->with('success','Product updated successfully.');
        }
    }

    public function delete_img(Request $request){
        $image = Product::where('id', $request->id)
        ->update([
           'p_image' => null
        ]);
         return Response()->json(array('msg' => 'Image deleted successfully.', 'status' => true));
    }
    
    public function show(Request $request)
    {  
        $categories = Product_category::all();
        if($request->input('category')){
        $category = $request->input('category');
        $products = Product::where('product_category',$request->input('category'))->orderBy('id','DESC')->paginate(10);
        $products->appends(['category' => $category]);
        }else{
        $products = Product::orderBy('id','DESC')->paginate(10);
        }
        return view("backend.product-all-products",compact('categories','products'));
    }

    public function destroy(Product $product, $id)
    {
    $product = Product::where('id',$id)->first();
    $product->delete();
    return redirect()->back()->with('success', 'Product deleted successfully.');
    }
    
    public function update_status($id){
        $chkstatus = Product::find($id);
        if($chkstatus->status=="1"){
            $update = Product::find($id);
            $update->status = '2';
            $update->save();
        }
        else{
         $update = Product::find($id);
         $update->status = '1';
         $update->save();
        }
        return redirect()->back()->with('success', 'Status updated successfully.');  
    }
	
	public function deleteallproducts(Request $request){
	 if($request->id){
     DB::table("products")->whereIn('id',$request->id)->delete();
     return redirect()->back()->with('success', 'Records are deleted successfully.'); 
	}
	else{
		return redirect()->back()->with('error', 'Please select atleast one product.'); 
		}
	
	}
    
}
