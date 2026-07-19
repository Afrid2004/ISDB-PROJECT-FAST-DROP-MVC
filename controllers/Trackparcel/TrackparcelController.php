<?php

class TrackparcelController
{
  function index()
  {
    $tracking_id = strtoupper(trim($_GET['id'] ?? ''));
    $data = Parcel::trackParcel($tracking_id);
    view("", $data);
  }
}
