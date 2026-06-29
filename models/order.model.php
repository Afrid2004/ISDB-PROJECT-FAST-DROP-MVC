<?php 

class Order{
 public $id;
 public $customer_id;
 public $status;
 public $grand_total;
 public $discount;
 public $vat;
 public $order_date;

 public function __construct()
 {
 }

 public function set($id,$customer_id,$status,$grand_total,$discount, $vat, $order_date)
 { 
    $this->id=$id;
    $this->customer_id=$customer_id;
    $this->status=$status;
    $this->grand_total=$grand_total;
    $this->discount=$discount;
    $this->vat=$vat;
    $this->order_date=$order_date;
 }


 public function save(){
   global $db;
   $stmt= $db->query("insert into products(customer_id, status,grand_total, discount)
   values ('$this->customer_id','$this->status', '$this->grand_total', '$this->discount') ");
   return $db->insert_id;
 }
 public function update(){
   global $db;
   $stmt= $db->query("update products  set customer_id= '$this->customer_id', status= '$this->status',
   grand_total= '$this->grand_total' , discount='$this->discount' where id= $this->id");
   return $db->insert_id;
 }
 public static function all(){
   global $db;
   $stmt= $db->query("select * from orders");
   return  array_map(fn($d)=> (object) $d,$stmt->fetch_all(MYSQLI_ASSOC));
 }
 public static function find($id){
    global $db;
   $stmt= $db->query("select * from products where id= $id");
   return  $stmt->fetch_object();
 }
 public static function delete($id){
     global $db;
     $stmt= $db->query("delete from products where id= $id");
   return  $stmt;
 }

}
?>