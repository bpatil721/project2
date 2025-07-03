<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\View;

class SiteController extends Controller
{
    public function  getLogin() {
        if(Auth::guard('user')->check()){
            return view('dashboard');
        }
        return view('login');
    }
    public function postLogin(Request $request ){
        $email = $request['email'];
        $password = $request['password'];
        if(Auth::guard('user')->attempt(['email'=>$email,'password'=>$password])){
            $user = Auth::guard('user')->user();
            $res['status'] = 1;
            $res['msg'] = 'Login successfully';
            return response()->json($res);
        }else{
            return response()->json(['status' =>false,'msg'=>'Invalid creaditon']);
        }
    }
    
    public function  getRegister() {
        return view('register');
    }
    public function postRegisgter(Request $request){
        $valid = \Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($valid->fails()){
            return response()->json(['status'=>false,'msg'=>$valid->messages()->first()]);
        }
        User::create($request->all());
        return response()->json(['status'=>true,'msg'=>"Register successfully"]);   
    }
    public function  getDashboard() {
        return view('dashboard');
    }
    
    public function  getProduct() {
        $categories = Category::get();
        return view('product',compact('categories'));
    }
    public function postLogout(Request $request){
        if(Auth::guard('user')->user()){
            Auth::guard('user')->logout();
            return response()->json(['status'=>true,'msg'=>'Logout Successfully']);
        }else{
            return response()->json(['status'=>false,'msg'=>'Something went to wrong']);
        }
    }
    public function postAddProduct(Request $request){
        $data = $request->all();
        $valid = \Validator::make($data,[
            'title' => 'required',
            'qty' => 'required',
            'sku' => 'required',
        ]);
        if($valid->fails()){
            return response()->json(['status'=>false, 'msg' => $valid->messages()->first()]);
        }
       $res =  Product::create($data);
       if($res){
           return response()->json(['status'=>true,'msg' => 'Product added']);
        }else{
         return response()->json(['status'=>false,'msg' => 'Product not added']);
       }
    }

    public function getProductData(Request $request){
        $data = Product::with('category')->get()->toArray(); 
        $html = view::make('product-list',compact('data'))->render();
        return response()->json(['status'=>true,'html'=>$html]);
    }
    public function ProductUpdate(Request $request){
        $data = $request->all();
        $id = $data['product_id'];
        $valid = \Validator::make($data,[
            'title'=>'required',
            'category'=>'required',
            'sku' =>'required'
        ]);
        if($valid->fails()){
            return response()->json(['status'=>false,'msg'=>$valid->messages()->first()]);
        }
        $product = Product::findOrFail($id);
        $res = $product->update($data);
        if($res){
            return response()->json(['status'=>true,'msg' => 'Product update']);
         }else{
          return response()->json(['status'=>false,'msg' => 'Product not update']);
        }
    }
    public function getProfile(){
        return view('profile');
    }
}
