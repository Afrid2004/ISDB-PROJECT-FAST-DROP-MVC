<?php

function avatar($name, $photo = null)
{
  if (!empty($photo)) {
    return "<img  loading='lazy' src='$photo' class='w-full h-full object-cover'>";
  }

  $nameArray = explode(" ", trim($name));

  $text = strtoupper($nameArray[0][0]);

  if (isset($nameArray[1])) {
    $text .= strtoupper($nameArray[1][0]);
  }

  return "
    <div class='w-full h-full flex items-center justify-center bg-white text-secondary font-semibold'>
        $text
    </div>";
}
