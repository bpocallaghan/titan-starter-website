<?php

if (!function_exists('upload_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string $path
     * @return string
     */
    function upload_path($path = '')
    {
        // path
        $path = env('PUBLIC_FOLDER', 'public') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $path;
        // remove trailing seperators (incase more than 1)
        // add 1 trailing seperator (to add file in directory)
        return rtrim(base_path($path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }
}

if (!function_exists('upload_path_images')) {
    /**
     * Get the path to the public images folder.
     *
     * @param  string $path
     * @return string
     */
    function upload_path_images($path = '')
    {
        return upload_path('images' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR);
    }
}

if (!function_exists('upload_path_videos')) {
    /**
     * Get the path to the public videos folder.
     *
     * @param  string $path
     * @return string
     */
    function upload_path_videos($path = '')
    {
        return upload_path('videos' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR);
    }
}

function get_file_extensions($type = 'image')
{
    switch ($type) {
        case 'image':
            return 'image/x-png, image/jpeg, image/jpg, image/png';
    }

    return '';
}

function form_file_type($type)
{
    switch ($type) {
        case 'image':
            return 'image/*';
            break;
        case 'pdf':
            return 'application/pdf';
            break;
    }
}

function get_min_width_height($width, $height, $minWidth = 100, $minHeight = 100)
{
    if ($width > $height) {
        $ratio = $width / $height;
        $height = $minHeight;
        $width = round($height * $ratio);
    }
    else {
        $ratio = $height / $width;
        $width = $minWidth;
        $height = round($width * $ratio);
    }

    return ['w' => $width, 'h' => $height];
}

function uploaded_images_url($name)
{
    return '/uploads/images/' . $name;
}

/**
 * Convert a csv to an array
 *
 * @param string $filename
 * @param string $delimiter
 * @return array|bool
 */
function csv_to_array($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename)) {
        return false;
    }

    $header = null;
    $data = [];
    if (($handle = fopen($filename, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (!$header) {
                $header = $row;
            }
            else {
                if (count($header) == count($row)) {
                    $data[] = array_combine($header, $row);
                }
            }
        }
        fclose($handle);
    }

    return $data;
}

/**
 * Search for a given value in $haystack
 * Can overide the default key to search on
 *
 * @param        $value
 * @param        $haystack
 * @param string $k
 * @return bool
 */
function array_search_value($value, $haystack, $k = 'id')
{
    foreach ($haystack as $key => $item) {
        if ($value == $item[$k]) {
            return true;
        }
    }

    return false;
}
