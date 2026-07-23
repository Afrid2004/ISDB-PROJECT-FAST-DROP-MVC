<?php

class CustomerApi
{
    public function index()
    {
        $data = Customer::all();

        if (!empty($data)) {
            echo json_encode(
                [
                    "success" => true,
                    "data"    => $data
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Data not found!"
                ]
            );
        }
    }

    public function create()
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mobile = trim($_POST['mobile'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $photo = trim($_POST['photo'] ?? '');
        $customer = new Customer();
        $customer->set($name, $email, $mobile, $address, $photo);
        $success = $customer->save();
        if ($success) {
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Created successfully!"
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Creation failed!"
                ]
            );
        }
    }

    public function update()
    {
        $id = intval($_POST['id']);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mobile = trim($_POST['mobile'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $photo = trim($_POST['photo'] ?? '');
        $customer = new Customer();
        $customer->set($name, $email, $mobile, $address, $photo);
        $success = $customer->update($id);
        if ($success) {
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Updated successfully!"
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Update failed!"
                ]
            );
        }
    }

    public function delete()
    {
        $id = intval($_POST['id']);
        $customer = new Customer();
        $success = $customer->delete($id);
        if ($success) {
            echo json_encode(
                [
                    "success" => true,
                    "message" => "Deleted successfully!"
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Deletion failed!"
                ]
            );
        }
    }

    public function find()
    {
        $id = intval($_POST['id']);
        $data = Customer::find($id);
        if ($data) {
            echo json_encode(
                [
                    "success" => true,
                    "data"    => $data
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Data not found"
                ]
            );
        }
    }
}
