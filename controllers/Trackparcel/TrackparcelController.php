<?php

class TrackparcelController
{
  function index()
  {
    $tracking_id = trim($_GET['id'] ?? '');
    $data = Parcel::trackParcel($tracking_id);
    view("", $data);
  }
}