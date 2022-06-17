<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    public function store(Request $request): JsonResponse
    {
        try {
            $order = new Order();
            $order->full_name = $request->full_name;
            $order->address = $request->address;
            $order->amount = $request->amount;

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
    public function show(int $orderId): JsonResponse
    {
        $order = Order::find($orderId);

        if (!$order) {
            throw new NotFoundHttpException('Can not find order ' . $orderId);
        }

        return response()->json([
            'status' => 'success',
            'order' => $order
        ]);
    }

    /**
     * @param Request $request
     * @param int $orderId
     * @return JsonResponse
     */
    public function update(Request $request, int $orderId): JsonResponse
    {
        $order = Order::find($orderId);

        if (!$order) {
            throw new NotFoundHttpException('Can not find order ' . $orderId);
        }

        if (!$order->update($request->all())) {
            return response()->json([
               'status' => 'error'
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

}
