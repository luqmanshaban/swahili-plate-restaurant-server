<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function processTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price,
                    ]
                ]
            ]
        ]);

        // Extract relevant data from the PayPal response
        $orderId = $response['id'];
        $approveLink = '';

        foreach ($response['links'] as $link) {
            if ($link['rel'] === 'approve') {
                $approveLink = $link['href'];
                break;
            }
        }

        return response()->json([
            'message' => 'Transaction created successfully',
            'data' => [
                'order_id' => $orderId,
                'approve_link' => $approveLink,
            ],
            'response' => $response
        ]);
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        // You can extract more data from the capture response if needed
        $captureId = $response['id'];

        if($response['status'] && $response['status'] == 'COMPLETED') {
            return response()->json([
              'message' => 'Transaction completed successfully',
                'data' => [
                    'capture_id' => $captureId,
                ]
            ]);
        }else {
            return response()->json(['error' ]);
        }

    }

    
}
