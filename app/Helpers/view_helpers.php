<?php

if (!function_exists('format_date')) {
    /**
     * Format Date
     *
     * @param        $date
     * @param string $format
     * @return bool|string
     */
    function format_date($date, $format = "d F Y")
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('activity_after')) {
    /**
     * Get the After Title of model
     * @param $activity
     * @return string
     */
    function activity_after($activity)
    {
        if (strlen($activity->after) > 3) {
            $after = json_decode($activity->after);
            $after_txt = '';

            foreach($after as $k => $v){
                $after_txt .= ucfirst($k).': '.$v.'<br>';
            }
            return $after_txt;
        }

        return $activity->subject->title ?? '';
    }
}

if (!function_exists('activity_before')) {
    /**
     * Get the After Title of model
     * @param $activity
     * @return string
     */
    function activity_before($activity)
    {
        $before_txt = '';
        if (strlen($activity->before) > 3) {
            $before = json_decode($activity->before);


            foreach($before as $k => $v){
                $before_txt .= ucfirst($k).': '.$v.'<br>';
            }
        }
        return $before_txt;

    }
}

function image_row_link($name, $thumb, $image = null)
{
    return "<a data-lightbox='".$name."' title='".$name."' href='" . uploaded_images_url(($image ? $image : $thumb)) . "'><img src='" . uploaded_images_url($thumb) . "' class='img-fluid' alt='".$name."' style='height: 50px'/></a>";
}

if (!function_exists('photo_url')) {
    function photo_url($name)
    {
        return config('app.url') . '/uploads/photos/' . $name;
    }
}

/**
 * Fetch the website settings from session or database
 */
if (!function_exists('settings')) {

    /**
     * @param bool $forceNew
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    function settings($forceNew = false)
    {
        if (!$forceNew) {
            // fetch settings from session
            if (session()->has("titan.settings")) {
                return session("titan.settings");
            }
        }

        // fetch settings or create if not exist
        $settings = \App\Models\Settings::find(1);
        if (is_null($settings)) {
            $settings = \App\Models\Settings::create([
                'name'        => config('app.name'),
                'description' => config('app.description'),
                'author'      => config('app.author'),
                'keywords'    => config('app.keywords'),
            ]);
        }

        session()->put("titan.settings", $settings);

        return $settings;
    }
}


if (!function_exists('number_format_decimal')) {
    function number_format_decimal($value, $decimals = 2)
    {
        return str_replace(".00", "", (string) number_format($value, $decimals));
    }
}

if (!function_exists('add_product_to_mail')) {
    function add_product_to_mail($mail, $product)
    {
        return $mail->line("Product: {$product->name}")
            ->line("Category: " . $product->category->name . ($product->category->parent ? " ({$product->category->parent->name})" : ''))
            ->line("Reference: {$product->reference}")
            ->line("Amount: {$product->amount} (per item)")
            ->line("<strong>Quantity: {$product->pivot->quantity}</strong>");
    }
}
