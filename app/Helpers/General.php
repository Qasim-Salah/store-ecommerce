<?php

define('PAGINATION_COUNT', 10);
function getFolder()
{
    return app()->getLocale() === 'ar' ? 'css-rtl' : 'css';
}

function getLang()
{
    return app()->getLocale() === 'ar' ? 'اللغة العربية' : 'اللغة الانكليزية';
}


function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    return $filename;
}
