<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\QueryException;
class ProductController extends Controller
{
    //
    
    public function create(Request $request){


       

       try{
        $product=Product::create($request->all());
        return response()->json([
            $product
        ]);
        }catch(Exception $e){
            return response()->json([
                'Message'=>'cant register user1'
                 ]);
        }catch(QueryException $e){

            return response()->json([
                'Message'=>'cant register user2'
                 ]);
        }

    }

    public function delete($id)
    {
      try{
        $product=Product::find($id);
        if($product)
        $isdel=$product->delete();
        else
        return ['Message'=>"Nothing to delete"];

        if($isdel){
            return response()->json($product);
        }else
        return ['Message'=>"Nothing to delete"];


      }catch(Exception $e){
         return ['Message'=>"Cant delete"];
      }
   }

   public function update($id,Request $request){
       //return $request->all();
       //return response()->json(['pp'=>$request->all()]);
    try{
        $product=Product::find($id);
        if($product){
        $product->order_number=$request->order_number;
        $product->order_ammt=$request->order_ammt;
        
        $product->save();
         return response()->json($product);
        }else{
          return ['Message'=>'Item not found'];
        }
     }catch(Exception $e)
     {
        return ['Message'=>'Cant Update'];
    
      }
      catch(QueryException $e){

        return response()->json(['Message'=>'Cant Update']);
       }
   
   
    }

    function getall(Request $request){
      try{ 
      $query=$request->all();
      if(isset($query['filter'])){
        $filter=json_decode($query['filter'],true);
      }
      if(isset($query['range'])){
        $range=json_decode($query['range'],true);
      }
      if(isset($query['sort'])){
        $sort=json_decode($query['sort'],true);
      }
      //print_r($filter);
       if(isset($filter) && count($range)==2 && count($sort)){
             if(isset($filter['q'])&& !empty($filter)){
                $products=Product::where('order_number','like','%'.$filter['q'].'%')->orderBy($sort[0],$sort[1])->offset($range[0])->limit($range[1]-1)->get();
                $total=Product::where('order_number','like','%'.$filter['q'].'%')->count();
              }
             else{
               $products=Product::offset($range[0])->orderBy($sort[0],$sort[1])->limit($range[1])->get();
               $total=Product::get()->count();
             }

           }else{
               $products=Product::offset($range[0])->limit($range[1])->get();
               $total=Product::get()->count();
           }



        if(!$products)
         return ['Message','Order not Found'];
        else{
         return response()->json($products)->withHeaders([
         'Access-Control-Expose-Headers'=> "X-Total-Count",
          'X-Total-Count'=>$total,
          //'Content-Range'=>'posts 0-5/319'
      ]);

        }
      }catch(Exception $e){
          ['Message','Order not Found','status'=>403];
        }

    }
    function getone($id){
        if(!$product=Product::find($id))
         return ['Message','Order not Found'];
         //response()->json(Product::all());
         else{
           return response()->json($product);
         }
         

         //$product=User::find(1);
         return response()->json($product);
    }



    
    
}
