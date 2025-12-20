<?php

namespace App\Services;

use App\Models\Order\Order;
use App\Models\Order\Payment;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Process a payment for an order
     */
    public function processPayment(string $paymentMethod, Order $order, array $paymentData = []): array
    {
        try {
            // Validate payment method - only accept valid enum from database
            $allowedMethods = ['cash_on_delivery', 'bank_transfer', 'credit_card'];
            if (!in_array($paymentMethod, $allowedMethods)) {
                throw new Exception('Invalid payment method: '.$paymentMethod);
            }

            switch ($paymentMethod) {
                case 'credit_card':
                    return $this->processCreditCard($order, $paymentData);
                case 'bank_transfer':
                    return $this->processBankTransfer($order, $paymentData);
                case 'cash_on_delivery':
                    return $this->processCashOnDelivery($order);
                default:
                    throw new Exception('Invalid payment method');
            }
        } catch (Exception $e) {
            Log::error('Payment processing error: '.$e->getMessage(), [
                'order_id' => $order->id,
                'payment_method' => $paymentMethod,
            ]);

            return [
                'success' => false,
                'message' => 'Lỗi xử lý thanh toán: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Process credit card payment
     */
    protected function processCreditCard(Order $order, array $paymentData): array
    {
        // In a real application, this would validate card details and call a payment gateway
        $transactionId = 'CC_'.uniqid().'_'.$order->id;

        try {
            // Validate payment data
            if (empty($paymentData['last_digits'] ?? null)) {
                throw new \Exception('Missing credit card information');
            }

            // Create payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'payment_method' => 'credit_card',
                'status' => 'completed',
                'transaction_id' => $transactionId,
                'payment_date' => now(),
            ]);

            // Update order status
            $order->update(['status' => 'pending']);
        } catch (\Exception $e) {
            Log::error('Credit card payment processing error: '.$e->getMessage(), [
                'order_id' => $order->id,
                'payment_data' => $paymentData,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }

        return [
            'success' => true,
            'message' => 'Thanh toán thẻ tín dụng thành công',
            'transaction_id' => $transactionId,
            'payment_id' => $payment->id,
        ];
    }

    /**
     * Process Bank Transfer payment
     */
    protected function processBankTransfer(Order $order, array $paymentData): array
    {
        // In a real application, this would validate bank transfer details
        $transactionId = 'BT_'.uniqid().'_'.$order->id;

        try {
            // Create payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'payment_method' => 'bank_transfer',
                'status' => 'pending',
                'transaction_id' => $transactionId,
            ]);

            // Update order status
            $order->update(['status' => 'pending']);
        } catch (\Exception $e) {
            Log::error('Bank transfer payment processing error: '.$e->getMessage(), [
                'order_id' => $order->id,
                'payment_data' => $paymentData,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }

        return [
            'success' => true,
            'message' => 'Đơn hàng đã được tạo. Vui lòng chuyển khoản theo thông tin đã cung cấp.',
            'transaction_id' => $transactionId,
            'payment_id' => $payment->id,
        ];
    }

    /**
     * Process Cash on Delivery payment
     */
    protected function processCashOnDelivery(Order $order): array
    {
        try {
            // Create payment record with pending status
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'payment_method' => 'cash_on_delivery',
                'status' => 'pending',
                'transaction_id' => 'COD_'.$order->id,
            ]);

            // Update order status
            $order->update(['status' => 'pending']);

        } catch (\Exception $e) {
            Log::error('Cash on Delivery payment processing error: '.$e->getMessage(), [
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }

        return [
            'success' => true,
            'message' => 'Đặt hàng thành công. Thanh toán khi nhận hàng.',
            'payment_id' => $payment->id,
            'transaction_id' => $payment->transaction_id,
        ];
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Payment $payment, string $status): bool
    {
        try {
            $validStatuses = ['pending', 'completed', 'failed'];

            if (! in_array($status, $validStatuses)) {
                throw new Exception('Invalid payment status');
            }

            $payment->status = $status;

            return $payment->save();
        } catch (Exception $e) {
            Log::error('Payment status update error: '.$e->getMessage(), [
                'payment_id' => $payment->id,
                'status' => $status,
            ]);

            return false;
        }
    }
}
