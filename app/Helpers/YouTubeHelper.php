<?php

namespace App\Helpers;

class YouTubeHelper
{
    public static function getYouTubeVideoId($url)
    {
        $regExp = '/^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|watch\?.+&v=)([^#&?]*).*/';
        if (preg_match($regExp, $url, $matches)) {
            return (isset($matches[2]) && strlen($matches[2]) === 11) ? $matches[2] : null;
        }
        return null;
    }
}
