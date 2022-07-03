<?php

namespace Armincms\MDarman\Http\Controllers;

use Armincms\MDarman\Http\Requests\SubscribeRequest;
use Armincms\Coursera\Nova\Course;
use Armincms\Orderable\Nova\Billing;
use Armincms\Orderable\Nova\Order;
use Zareismail\Gutenberg\Gutenberg;

class SubscribeController extends Controller
{
    public function __invoke(SubscribeRequest $request)
    {
        $order = Order::newModel();
        $course = Course::newModel()->findOrFail($request->route('course'));
        $attributes = [
            "name" => $course->name,
            "resource" => Course::class,
            "callback_url" => route('mdarman.subscribed', $course),
        ];

        $order->forceFill($attributes)->asOnHold();

        $order->addItem($course, [
            'course' => $request->route('course'),
            'user' => $request->user()->getKey(),
            'imei' => $request->get('imei'),
        ]);

        $fragment = Gutenberg::cachedFragments()->find(Billing::billingPage());

        return [
            'redirect' => $fragment->getUrl($order->getUri()),
            'trackingCode' => $order->trackingCode(),
        ];
    }

    public function subscribed(SubscribeRequest $request)
    {
        return response(
            '<a href="'
            .config('mdarman.callbackUrl')
            . '">برای بازگشت به برنامه کلیک نمایید.</a>'
        );
    }
}
