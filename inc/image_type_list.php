<?php
$image_type = [
    'image/gif' => false,
    'image/jpeg' => true,
    'image/png' => true,
    'application/x-shockwave-flash' => false,
    'image/psd' => false,
    'image/bmp' => true,
    'image/tiff' => false,
    'application/octet-stream' => false,
    'image/jp2' => false,
    'image/iff' => false,
    'image/vnd.wap.wbmp' => false,
    'image/xbm' => false,
    'image/vnd.microsoft.icon' => false,
    'image/webp' => true,
];

foreach ($image_type as $k => $v) {
    if ($image_type[$k] == true) {
        $image_type_list_on[$k] = $v;
    }
}
