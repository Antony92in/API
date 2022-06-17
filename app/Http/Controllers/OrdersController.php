<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class OrdersController
 * @package App\Http\Controllers
 */
class OrdersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $order = new Order();
            $order->full_name = $request->full_name;
            $order->address = $request->address;
            $order->amount = $request->amount;
            $order->created_at = $this->getCurrentTime();

            if (!$order->save()) {
                return response()->json([
                    'status' => 'error'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * @param int $orderId
     * @return JsonResponse
     */
    public function show(int $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Can not find order ' . $orderId
            ]);
        }

        return response()->json([
            'status' => 'success',
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * @return string
     */
    private function getCurrentTime(): string
    {
        return date('Y-m-d H:i:s');
    }

}
