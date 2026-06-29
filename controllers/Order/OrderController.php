<?php 

class OrderController{

  public function index(){

    $data= Order::all();


     return view("order", ["abc"=>  $data]);
  }



}




?>