<?php

class Customer
{
    public $id;
    public $name;
    public $email;
    public $mobile;
    public $address;
    public $photo;

    public  function __construct() {}

    public function set($name, $email, $mobile, $address, $photo = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->address = $address;
        $this->photo = $photo;
    }

    // insert 
    public function save()
    {
        global $db;
        $stmt = $db->prepare("INSERT INTO customers(name,email,mobile,address,photo) VALUES(?,?,?,?,?)");
        $stmt->bind_param("sssss", $this->name, $this->email, $this->mobile, $this->address, $this->photo);
        if ($stmt->execute()) {
            $this->id = $db->insert_id;
            return true;
        }
        return false;
    }

    // read data 
    public static function all()
    {
        global $db;
        $result = $db->query("SELECT * FROM customers ORDER BY id DESC");
        if ($result && $result->num_rows > 0) {
            return array_map(
                fn($item) => (object)$item,
                $result->fetch_all(MYSQLI_ASSOC)
            );
        }
        return [];
    }

    // update data 
    public function update($id)
    {
        global $db;

        $stmt = $db->prepare("UPDATE customers SET name=?, email=?, mobile=?, address=?, photo=? WHERE id=?");

        $stmt->bind_param(
            "sssssi",
            $this->name,
            $this->email,
            $this->mobile,
            $this->address,
            $this->photo,
            $id
        );

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete data 
    public function delete($id)
    {
        global $db;

        $stmt = $db->prepare("DELETE FROM customers WHERE id=?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // find data 
    public static function find($id)
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM customers WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        }
        return null;
    }
}
