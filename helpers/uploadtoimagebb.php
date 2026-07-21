<?php

function uploadToImageBB($tmpName)
{
  $apiKey = "YOUR_IMGBB_API_KEY";
  $ch = curl_init();
  curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.imgbb.com/1/upload?key=$apiKey",
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => [
      "image" => new CURLFile($tmpName)
    ]
  ]);
  $response = curl_exec($ch);
  if (curl_errno($ch)) {
    return false;
  }
  $result = json_decode($response, true);
  return $result['data']['url'] ?? false;
}