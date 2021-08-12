<?php

namespace App\Http\Controllers\Website;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\FeedbackContactUs;
use App\Events\ContactUsFeedback;
use App\Http\Controllers\Traits\GoogleCaptcha;

class ContactUsController extends WebsiteController
{
    use GoogleCaptcha;

    public function index()
    {
        return $this->view('contact');
    }

    public function feedback(Request $request)
    {
        $attributes = request()->validate(FeedbackContactUs::$rules);

        // validate google captcha
        $response = $this->validateCaptcha($request);
        if ($response->isSuccess()) {

            $row = FeedbackContactUs::create([
                'firstname'    => $attributes['firstname'],
                'lastname'     => $attributes['lastname'],
                'phone'        => $attributes['phone'],
                'email'        => $attributes['email'],
                'content'      => $attributes['content'],
                'client_ip'    => $request->getClientIp(),
                'client_agent' => $request->header('User-Agent'),
                'contactable_id'    => $attributes['contactable_id'],
                'contactable_type' => $attributes['contactable_type'],
                'contactable_type_name' => $attributes['contactable_type_name'],
                'contactable_name' => $attributes['contactable_name'],
            ]);

            event(new ContactUsFeedback($row));

            return json_response('Thank you for contacting us.');
        }

        return $this->captchaResponse($response);
    }
}
