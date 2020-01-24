<?php

if (!function_exists('url_admin')) {
    /**
     * Generate a url for the application.
     *
     * @param  string $path
     * @param  mixed  $parameters
     * @param  bool   $secure
     * @return string
     */
    function url_admin($path = null, $parameters = [], $secure = null)
    {
        return app('url')->to('admin/' . $path, $parameters, $secure);
    }
}

if (!function_exists('route_admin')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string                    $name
     * @param  array                     $parameters
     * @param  bool                      $absolute
     * @param  \Illuminate\Routing\Route $route
     * @return string
     */
    function route_admin($name, $parameters = [], $absolute = true, $route = null)
    {
        return Redirect::to(app('url')->route('admin.' . $name, $parameters, $absolute, $route));
    }
}

if (!function_exists('save_resource_url')) {
    /**
     * Save the resource home url (to easily redirect back on store / update / delete)
     * @param null $url
     */
    function save_resource_url($url = null)
    {
        $url = $url ?: request()->url();

        session()->put('url.resource.home', $url);
    }
}

if (!function_exists('redirect_to_resource')) {

    /**
     * Generate a URL to a named route.
     *
     * @param boolean $to
     * @param int     $status
     * @param array   $headers
     * @param null    $secure
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirect_to_resource($to = null, $status = 302, $headers = [], $secure = null)
    {
        $to = $to ?: session('url.resource.home', '/');

        return redirect($to, $status, $headers, $secure);
    }
}

/**
 * A Success json response
 * @param $response
 * @return \Illuminate\Http\JsonResponse
 */
function json_response($response = 'success')
{
    $data = [
        'success' => 1,
        'error'   => null,
        'data'    => $response,
    ];

    return response()->json($data);
}

/**
 * An Error json response
 * @param        $title
 * @param string $content
 * @param string $type
 * @return \Illuminate\Http\JsonResponse
 */
function json_response_error($title, $content = '', $type = 'popup')
{
    return response()->json([
        'success' => 0,
        'type'    => $type,
        'error'   => ['title' => $title, 'content' => $content]
    ]);
}

/**
 * An Error json response
 * @param $title
 * @param $content
 * @return \Illuminate\Http\JsonResponse
 */
function json_response_error_alert($title, $content = '')
{
    return json_response($title, $content, 'alert');
}

/**
 * Check if the slug is actually a valid url
 *
 * @param $slug
 * @return bool
 */
function is_slug_url($slug)
{
    if (strpos($slug, 'http://') === 0) {
        return true;
    }

    if (strpos($slug, 'https://') === 0) {
        return true;
    }

    if (strpos($slug, 'www.') === 0) {
        return true;
    }

    return false;
}