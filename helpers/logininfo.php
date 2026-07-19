<?php


function getDeviceName($ua)
{
  // Mobile
  if (preg_match('/iPhone/i', $ua)) {
    return "Apple iPhone";
  }
  if (preg_match('/iPad/i', $ua)) {
    return "Apple iPad";
  }
  if (preg_match('/Android/i', $ua)) {
    return "Android Device";
  }
  if (preg_match('/Windows NT/i', $ua)) {
    return "Windows PC";
  }
  if (preg_match('/Macintosh|Mac OS X/i', $ua)) {
    return "Mac";
  }
  if (preg_match('/Linux/i', $ua)) {
    return "Linux PC";
  }
  return "Unknown Device";
}

function getBrowser($ua)
{
  if (preg_match('/Edg/i', $ua)) {
    return "Microsoft Edge";
  }

  if (preg_match('/OPR/i', $ua)) {
    return "Opera";
  }

  if (preg_match('/Chrome/i', $ua)) {
    return "Google Chrome";
  }

  if (preg_match('/Firefox/i', $ua)) {
    return "Mozilla Firefox";
  }

  if (preg_match('/Safari/i', $ua)) {
    return "Safari";
  }

  return "Unknown";
}

function getLocation($ip)
{
  if ($ip == "::1" || $ip == "127.0.0.1") {
    return "Localhost";
  }
  $url = "http://ip-api.com/json/{$ip}?fields=status,country,regionName,city";
  $response = @file_get_contents($url);
  if (!$response) {
    return "Unknown";
  }
  $data = json_decode($response, true);
  if ($data['status'] == 'success') {
    return "{$data['city']}, {$data['regionName']}, {$data['country']}";
  }
  return "Unknown";
}
