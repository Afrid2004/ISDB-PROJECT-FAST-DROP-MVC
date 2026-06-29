<?php 

class Warehouses{
    
  public $id;
  public $name;
  public $city;
  public $contact;


  public function __construct()
  {  
  }

  public function set($id, $name, $city,$contact)
  {
     $this->id= $id;
     $this->name= $name;
     $this->city= $city;
     $this->contact= $contact;
  }

  public function save(){
      global $db;
      $stmt= $db->query("insert into core_warehouses(name, city,contact)
       values('$this->name', '$this->city', '$this->contact');
      ");
      return $db->insert_id;
  }

    public function update(){
      global $db;
      $stmt= $db->query("update core_warehouses name='$this->name', city='$this->city',contact='$this->contact' where id=$this->id;
      ");
      return  $stmt;
  }

   public static function all(){
      global $db;
      $stmt= $db->query("select * from core_warehouses");
      return  array_map(fn($d)=>(object) $d, $stmt->fetch_all(MYSQLI_ASSOC));
  }
   public static  function find($id){
      global $db;
      $stmt= $db->query("select * from core_warehouses where id= $id");
      return $db->insert_id;
  }
   public static  function delete($id){
      global $db;
      $stmt= $db->query("delete from core_warehouses where id= $id");
      return $db->insert_id;
  }


}









?>