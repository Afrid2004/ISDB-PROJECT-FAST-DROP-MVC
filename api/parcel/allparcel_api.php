<?php

class ParcelApi
{
  function index()
  {
    $message = "Pay function";
    echo json_encode(['message' => $message]);
  }

  function pay()
  {
    $messages = "Pay function 2";
    echo json_encode(['message' => $messages]);
  }
}
