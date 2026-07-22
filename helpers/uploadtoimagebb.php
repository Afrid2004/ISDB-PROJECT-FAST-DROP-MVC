<?php

function uploadToImageBB($tmpName)
{
  $apiKey = "cd908f57f43ca599d83bb8ee7ac71c82";
  $ch = curl_init();
  $image = base64_encode(file_get_contents($tmpName));
  curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.imgbb.com/1/upload?key=$apiKey",
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => [
      "image" => $image
    ]
  ]);
  $response = curl_exec($ch);
  if (curl_errno($ch)) {
    $error = curl_error($ch);
    curl_close($ch);
    return [
      "success" => false,
      "message" => $error
    ];
  }
  $result = json_decode($response, true);
  curl_close($ch);

  if (isset($result['success']) && $result['success'] == true && isset($result['data']['url'])) {
    return [
      "success" => true,
      "url" => $result['data']['url']
    ];
  }

  return [
    "success" => false,
    "message" => $result['error']['message'] ?? "Upload failed."
  ];
}
