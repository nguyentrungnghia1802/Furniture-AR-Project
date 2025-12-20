<div 
    x-data="bankTransferPayment()" 
    x-show="isVisible" 
    class="payment-method-form" 
    id="bank-transfer-form">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold">{{ __('payment.bank_transfer') }}</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
            </svg>
        </div>

        <div class="bg-blue-50 rounded-md p-4 mb-4">
            <h4 class="font-semibold text-blue-900 mb-2">{{ __('payment.bank_account_info') }}</h4>
            <div class="text-sm text-blue-800 space-y-1">
                <p><strong>{{ __('payment.bank_name') }}:</strong> Luna Bank</p>
                <p><strong>{{ __('payment.account_number') }}:</strong> 1234567890</p>
                <p><strong>{{ __('payment.account_holder') }}:</strong> Luna Shop Ltd.</p>
                <p><strong>{{ __('payment.transfer_content') }}:</strong> {{ __('payment.order_number') }} #<span x-text="orderNumber"></span></p>
            </div>
        </div>

        <div class="text-sm text-gray-600 mb-4">
            <p>{{ __('payment.bank_transfer_instructions') }}</p>
        </div>
        
        <div class="mt-6">
            <button
                type="button"
                @click="processPayment"
                :disabled="isProcessing"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
            >
                <span x-show="isProcessing">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('payment.processing') }}
                </span>
                <span x-show="!isProcessing">
                    {{ __('payment.confirm_order') }}
                </span>
            </button>
        </div>
        
        <div class="mt-4 border-t pt-4">
            <p class="text-xs text-gray-500 text-center">
                {{ __('payment.bank_transfer_note') }}
            </p>
        </div>
    </div>
</div>

<script>
    function bankTransferPayment() {
        return {
            isVisible: false,
            isProcessing: false,
            orderNumber: Math.floor(Math.random() * 1000000),
            
            processPayment() {
                this.isProcessing = true;
                
                setTimeout(() => {
                    const paymentMethodInput = document.getElementById('payment_method_input');
                    paymentMethodInput.value = 'bank_transfer';
                    
                    document.getElementById('payment_data').value = JSON.stringify({
                        bank_transfer_order_ref: this.orderNumber
                    });
                    
                    document.getElementById('checkout-form').submit();
                }, 800);
            }
        };
    }
</script>
