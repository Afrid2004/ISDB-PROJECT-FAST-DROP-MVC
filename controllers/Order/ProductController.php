<?php


class ProductController
{


    function index() {

       $data= Product::all();

       view("order" , ["data"=>  $data]);
    }


    function find($id) {

       $data= Product::find($id);

       view("order" , ["data"=>  $data]);
    }
}
