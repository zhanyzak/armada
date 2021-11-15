<?php

namespace App\Http\Controllers\Seller;

use App\Models\Tarif;
use SimpleXMLElement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Paybox\Pay\Facade as Paybox;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PayController extends Controller
{
    public function payStore($tarif, $store)
    {
        $tarif = Tarif::findOrFail($tarif);
        $paybox = new Paybox();

        $paybox->merchant->id = 540634;
        $paybox->merchant->secretKey = 'XRDcqWXiIQY3YM4W';
        $paybox->order->id = rand(000000, 999999);
        $paybox->order->store_id = $store;
        $paybox->order->description = 'Оплата '.$tarif->title;
        $paybox->order->amount = $tarif->placement_price;
        $paybox->customer->user_phone = $this->getPhoneNumberAttribute(Auth::user()->phones[0] ?? '');
        $paybox->customer->salt = 'Оплата тарифа армады';
        $paybox->customer->userEmail =  Auth::user()->email ?? '';

        $paybox->config->successUrlMethod = 'GET';
        $paybox->config->resultUrl = env('APP_URL').'api/pay/result';
        $paybox->config->successUrl = env('APP_URL').'pay/success';

        if($paybox->init()) {
            file_put_contents('file.txt', $paybox );
            header('Location:' . $paybox->redirectUrl);
        }
    }

    protected function getPhoneNumberAttribute($phone)
    {
        $cleaned = preg_replace('/[^[:digit:]]/', '', $phone);
        preg_match('/(\d{1})(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
        return "7{$matches[2]}{$matches[3]}{$matches[4]}";
    }

    function makeFlatParamsArray($arrParams, $parent_name = '')
    {
        $arrFlatParams = [];
        $i = 0;
        foreach ($arrParams as $key => $val) {
            $i++;
            /**
             * Имя делаем вида tag001subtag001
             * Чтобы можно было потом нормально отсортировать и вложенные узлы не запутались при сортировке
             */
            $name = $parent_name . $key . sprintf('%03d', $i);
            if (is_array($val)) {
                $arrFlatParams = array_merge($arrFlatParams, makeFlatParamsArray($val, $name));
                continue;
            }
            $arrFlatParams += array($name => (string)$val);
        }

        return $arrFlatParams;
    }

    public function pay()
    {
        return view('sellers.pay');
    }
}
