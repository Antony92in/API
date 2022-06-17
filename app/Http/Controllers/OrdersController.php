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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string','max:200'],
            'amount' => ['required','numeric']
        ]);

        try {

            if (!Order::create($data)) {
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

        $data = $request->validate([
            'full_name' => ['max:100', 'string'],
            'address' => ['max:200', 'string'],
            'amount' => ['numeric']
        ]);

        if (!$order->update($data)) {
            return response()->json([
                'status' => 'error'
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

}
