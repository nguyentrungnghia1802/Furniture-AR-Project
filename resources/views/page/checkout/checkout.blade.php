@php
    $total = 0;
    $originalTotal = 0;
    $totalSavings = 0;
    
    if (isset($selectedItems) && is_array($selectedItems)) {
        foreach ($selectedItems as $item) {
            $discountedSubtotal = ($item['discounted_price'] ?? $item['price']) * ($item['quantity'] ?? 0);
            $originalSubtotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
            
            $total += $discountedSubtotal;
            $originalTotal += $originalSubtotal;
        }
        $totalSavings = $originalTotal - $total;
    }
    
    $defaultMethod =
        isset($paymentMethods) && count($paymentMethods) > 0
            ? ucfirst(str_replace('_', ' ', $paymentMethods[0]))
            : __('checkout.no_method');

@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('checkout.title') }}
        </h2>
    </x-slot>
    <x-alert />

    <div class="max-w-4xl mx-auto py-12 px-2 sm:px-4 space-y-8 sm:space-y-10">

        {{-- Address Information --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ __('checkout.address_information') }}</h3>
            <h4 class="text-gray-700 leading-relaxed mb-4">
                <span class="block font-medium">{{ $userName }}</span>

                @if ($firstAddress)
                    <span id="selected-phone" class="block text-sm text-gray-600">{{ $firstAddress->phone ?? 'N/A' }}</span>
                    <span id="selected-address" class="block text-sm text-gray-600">
                        {{ $firstAddress->address ?? 'N/A' }}
                    </span>
                @else
                    <span id="selected-phone" class="block text-sm text-gray-600">N/A</span>
                    <span id="selected-address" class="block text-sm text-gray-600">
                        N/A
                    </span>
                @endif
            </h4>

            <button id="toggle-address-list"
                class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                {{ __('checkout.change_address') }}
            </button>

            <button id="open-address-form"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                {{ __('checkout.add_address') }}
            </button>
        </div>

        {{-- Product List --}}
        <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 overflow-x-auto">
            @if (count($selectedItems) > 0)
                <table class="min-w-full text-xs sm:text-sm">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">{{ __('checkout.images') }}</th>
                            <th class="py-2 px-4 border-b">{{ __('checkout.product_name') }}</th>
                            <th class="py-2 px-4 border-b">{{ __('checkout.price') }}</th>
                            <th class="py-2 px-4 border-b">{{ __('checkout.quantity') }}</th>
                            <th class="py-2 px-4 border-b">{{ __('checkout.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($selectedItems as $item)
                            @php 
                                $total += ($item['discounted_price'] ?? $item['price']) * $item['quantity']; 
                                $hasDiscount = ($item['discount_percent'] ?? 0) > 0;
                            @endphp
                            <tr>
                                <td class="py-2 px-4 border-b">
                                    <img src="{{ $item['image'] }}"
                                        class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded">
                                </td>
                                <td class="py-2 px-4 border-b">{{ $item['name'] }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if ($hasDiscount)
                                        <div class="space-y-1">
                                            <div class="text-gray-600 font-bold">
                                                ${{ number_format($item['discounted_price'] ?? $item['price'], 2, '.', ',') }}
                                            </div>
                                            <div class="text-xs text-gray-500 line-through">
                                                ${{ number_format($item['price'], 2, '.', ',') }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-gray-600 font-bold">
                                            ${{ number_format($item['price'], 2, '.', ',') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b">{{ $item['quantity'] }}</td>
                                <td class="py-2 px-4 border-b">${{ number_format(($item['discounted_price'] ?? $item['price']) * $item['quantity'], 2, '.', ',') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right font-bold py-2 px-4">{{ __('checkout.total') }}</td>
                            <td class="font-bold py-2 px-4">${{ number_format($total, 2, '.', ',') }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p>{{ __('checkout.no_products') }}</p>
            @endif
        </div>

        {{-- Payment --}}
        <div class="bg-white rounded-xl shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('checkout.payment_method') }}</h3>
                    <h4 class="text-gray-700" id="current-method">{{ $defaultMethod }}</h4>
                </div>
                <button id="change-method-btn" type="button"
                    class="bg-gray-600 text-white px-3 sm:px-4 py-2 rounded hover:bg-gray-700 transition whitespace-nowrap w-full sm:w-auto">
                    {{ __('checkout.change_method') }}
                </button>
            </div>

            <div>
                <!-- Subtotal before discount -->
                @if ($totalSavings > 0)
                    <div class="flex items-center justify-between flex-wrap gap-2 mb-2 text-xs sm:text-base">
                        <h3 class="text-lg font-medium text-gray-600">{{ __('checkout.original_subtotal') }}</h3>
                        <p class="text-lg text-gray-500 line-through">${{ number_format($originalTotal, 2, '.', ',') }}</p>
                    </div>
                @endif
                
                <!-- Subtotal after discount -->
                <div class="flex items-center justify-between flex-wrap gap-2 mb-4 text-xs sm:text-base">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('checkout.subtotal') }}</h3>
                    <p class="text-xl font-bold text-gray-600">${{ number_format($total, 2, '.', ',') }}</p>
                </div>
                
                <!-- Savings -->
                @if ($totalSavings > 0)
                    <div class="flex items-center justify-between flex-wrap gap-2 mb-4 text-xs sm:text-base">
                        <h3 class="text-lg font-medium text-green-600">{{ __('checkout.you_save') }}</h3>
                        <p class="text-lg font-bold text-green-600">-${{ number_format($totalSavings, 2, '.', ',') }}</p>
                    </div>
                @endif
                
                <div class="flex items-center justify-between flex-wrap gap-2 mb-4 text-xs sm:text-base">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('checkout.shipping_fee') }}</h3>
                    <p class="text-xl font-bold text-gray-600">$8.00</p>
                </div>
                <div class="flex items-center justify-between flex-wrap gap-2 mb-4 text-xs sm:text-base border-t pt-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('checkout.total_payment') }}</h3>
                    <p class="text-xl font-bold text-gray-800">${{ number_format($total + 8, 2, '.', ',') }}</p>
                </div>
            </div>

            <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <input type="hidden" name="payment_method" id="payment_method_input"
                    value="{{ $paymentMethods[0] ?? 'cash_on_delivery' }}">
                <input type="hidden" name="payment_data" id="payment_data" value="{}">>

                <input type="hidden" name="selected_items_json" value='@json($selectedItems)'>

                <input type="hidden" name="address_id" id="selected_address_id" value="{{ $firstAddress->id ?? '' }}">

                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ __('checkout.note') }}</h3>
                <textarea name="note" class="w-full p-2 border rounded text-xs sm:text-sm mb-4" rows="4"
                    placeholder="{{ __('checkout.enter_your_note') }}">{{ old('note') }}</textarea>

                <div class="mt-6">
                    <div id="payment-methods-container" class="space-y-4">
                        <x-payment.credit-card />
                        <x-payment.bank-transfer />
                        <x-payment.cash-on-delivery />
                    </div>
                </div>

                <div class="mt-6">
                    <button id="direct-submit-btn" type="submit"
                        class="bg-orange-600 text-white px-3 sm:px-4 py-2 rounded w-full sm:w-auto">
                        {{ __('checkout.place_order') }}
                    </button>
                    <p class="text-xs text-gray-500 mt-2">{{ __('checkout.or_select_payment_method') }}</p>
                </div>
            </form>




        </div>
    </div>

    <!-- Payment method selection modal -->
    <div id="method-selection" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('checkout.select_payment_method') }}</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach ($paymentMethods as $method)
                        <button type="button"
                            class="method-option px-4 py-2 border rounded-lg hover:bg-gray-50 transition text-sm sm:text-base flex items-center"
                            data-method="{{ $method }}">
                            @if ($method === 'credit_card')
                                <span class="mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </span>
                            @elseif($method === 'bank_transfer')
                                <span class="mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                    </svg>
                                </span>
                            @elseif($method === 'cash_on_delivery')
                                <span class="mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </span>
                            @endif
                            {{ ucfirst(str_replace('_', ' ', $method)) }}
                        </button>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <button id="close-method-selection"
                        class="mt-4 text-sm text-gray-500 hover:underline hover:text-gray-700">{{ __('checkout.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form -->
    <div id="address-form-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('checkout.add_shipping_address') }}</h3>

                <div class="mb-4">
                    <label class="block mb-1 text-gray-700">{{ __('checkout.phone_number') }}</label>
                    <input id="phone_number" type="text" class="w-full border rounded px-3 py-2"
                        placeholder="{{ __('checkout.enter_phone_number') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-gray-700">City / Province</label>
                    <select id="province" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Select Province --</option>
                        <option value="An Giang">An Giang</option>
                        <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
                        <option value="Bắc Giang">Bắc Giang</option>
                        <option value="Bắc Kạn">Bắc Kạn</option>
                        <option value="Bạc Liêu">Bạc Liêu</option>
                        <option value="Bắc Ninh">Bắc Ninh</option>
                        <option value="Bến Tre">Bến Tre</option>
                        <option value="Bình Định">Bình Định</option>
                        <option value="Bình Dương">Bình Dương</option>
                        <option value="Bình Phước">Bình Phước</option>
                        <option value="Bình Thuận">Bình Thuận</option>
                        <option value="Cà Mau">Cà Mau</option>
                        <option value="Cao Bằng">Cao Bằng</option>
                        <option value="Đắk Lắk">Đắk Lắk</option>
                        <option value="Đắk Nông">Đắk Nông</option>
                        <option value="Điện Biên">Điện Biên</option>
                        <option value="Đồng Nai">Đồng Nai</option>
                        <option value="Đồng Tháp">Đồng Tháp</option>
                        <option value="Gia Lai">Gia Lai</option>
                        <option value="Hà Giang">Hà Giang</option>
                        <option value="Hà Nam">Hà Nam</option>
                        <option value="Hà Nội">Hà Nội</option>
                        <option value="Hà Tĩnh">Hà Tĩnh</option>
                        <option value="Hải Dương">Hải Dương</option>
                        <option value="Hải Phòng">Hải Phòng</option>
                        <option value="Hậu Giang">Hậu Giang</option>
                        <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                        <option value="Hòa Bình">Hòa Bình</option>
                        <option value="Hưng Yên">Hưng Yên</option>
                        <option value="Khánh Hòa">Khánh Hòa</option>
                        <option value="Kiên Giang">Kiên Giang</option>
                        <option value="Kon Tum">Kon Tum</option>
                        <option value="Lai Châu">Lai Châu</option>
                        <option value="Lâm Đồng">Lâm Đồng</option>
                        <option value="Lạng Sơn">Lạng Sơn</option>
                        <option value="Lào Cai">Lào Cai</option>
                        <option value="Long An">Long An</option>
                        <option value="Nam Định">Nam Định</option>
                        <option value="Nghệ An">Nghệ An</option>
                        <option value="Ninh Bình">Ninh Bình</option>
                        <option value="Ninh Thuận">Ninh Thuận</option>
                        <option value="Phú Thọ">Phú Thọ</option>
                        <option value="Phú Yên">Phú Yên</option>
                        <option value="Quảng Bình">Quảng Bình</option>
                        <option value="Quảng Nam">Quảng Nam</option>
                        <option value="Quảng Ngãi">Quảng Ngãi</option>
                        <option value="Quảng Ninh">Quảng Ninh</option>
                        <option value="Quảng Trị">Quảng Trị</option>
                        <option value="Sóc Trăng">Sóc Trăng</option>
                        <option value="Sơn La">Sơn La</option>
                        <option value="Tây Ninh">Tây Ninh</option>
                        <option value="Thái Bình">Thái Bình</option>
                        <option value="Thái Nguyên">Thái Nguyên</option>
                        <option value="Thanh Hóa">Thanh Hóa</option>
                        <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
                        <option value="Tiền Giang">Tiền Giang</option>
                        <option value="Trà Vinh">Trà Vinh</option>
                        <option value="Tuyên Quang">Tuyên Quang</option>
                        <option value="Vĩnh Long">Vĩnh Long</option>
                        <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                        <option value="Yên Bái">Yên Bái</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-gray-700">Commune / Ward</label>
                    <input id="ward" type="text" class="w-full border rounded px-3 py-2"
                        placeholder="Enter commune or ward name" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-gray-700">Detailed Address</label>
                    <input id="address_detail" type="text" class="w-full border rounded px-3 py-2"
                        placeholder="House number, street name ..." required>
                </div>

                <div class="flex justify-between items-center">
                    <button id="save-address" type="button"
                        class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                        {{ __('checkout.save_address') }}
                    </button>
                    <button id="close-address-form" class="text-gray-600 hover:underline">
                        {{ __('checkout.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Address List -->
    <div id="address-list-container" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md max-h-[90vh] overflow-hidden relative">
                <h3 class="text-xl font-semibold text-center mb-4 pt-6">{{ __('checkout.address_list') }}</h3>

                <!-- Scrollable area for the address list -->
                <div id="address-list" class="space-y-4 px-6 overflow-y-auto max-h-[60vh]">
                    @if($addresses && count($addresses) > 0)
                        @foreach ($addresses as $address)
                            <a href="#" class="address-item" data-id="{{ $address->id }}"
                                data-phone="{{ $address->phone ?? 'N/A' }}" data-address="{{ $address->address ?? 'N/A' }}">
                                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 shadow-sm hover:bg-gray-100 transition">
                                    <p class="text-gray-800"><strong>{{ __('checkout.phone') }}:</strong> {{ $address->phone ?? 'N/A' }}</p>
                                    <p class="text-gray-800"><strong>{{ __('checkout.address') }}:</strong> {{ $address->address ?? 'N/A' }}</p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <p>{{ __('checkout.no_addresses') }}</p>
                            <p class="text-sm mt-2">{{ __('checkout.please_add_address') }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-center px-6 pb-6">
                    <button
                        class="close-address-list px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded">
                        {{ __('checkout.close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============= PAYMENT METHOD LOGIC =============
            const btnChangeMethod = document.getElementById('change-method-btn');
            const methodBox = document.getElementById('method-selection');
            const currentMethod = document.getElementById('current-method');
            const closeMethodBtn = document.getElementById('close-method-selection');
            const paymentForms = document.querySelectorAll('.payment-method-form');
            const defaultMethod = '{{ $paymentMethods[0] ?? 'cash_on_delivery' }}';

            // Function to show the appropriate payment form
            function showPaymentForm(method) {
                // Hide all payment forms
                paymentForms.forEach(form => {
                    if (window.Alpine) {
                        const alpineData = window.Alpine.$data(form);
                        if (alpineData && typeof alpineData.isVisible !== 'undefined') {
                            alpineData.isVisible = false;
                        }
                    }
                });

                // Show the selected payment form
                const formId = `${method.replace(/_/g, '-')}-form`;
                const selectedForm = document.getElementById(formId);
                if (selectedForm && window.Alpine) {
                    const alpineData = window.Alpine.$data(selectedForm);
                    if (alpineData && typeof alpineData.isVisible !== 'undefined') {
                        alpineData.isVisible = true;
                    }
                }
            }

            // Show the initial payment form based on the default method
            showPaymentForm(defaultMethod);

            // Handle direct submit button
            document.getElementById('direct-submit-btn').addEventListener('click', function(e) {
                e.preventDefault();
                
                // Validate address is selected
                const addressId = document.getElementById('selected_address_id').value;
                if (!addressId || addressId === '') {
                    alert('Please select a delivery address before placing your order.');
                    return;
                }
                
                const selectedMethod = document.getElementById('payment_method_input').value;

                // Check if payment is required and not completed for certain methods
                if (selectedMethod === 'credit_card' || selectedMethod === 'bank_transfer') {
                    // Check if payment has been completed (you can add specific checks here)
                    const paymentCompleted = checkPaymentStatus(selectedMethod);
                    
                    if (!paymentCompleted) {
                        alert('Please complete your payment before placing the order.');
                        showPaymentForm(selectedMethod);
                        document.querySelector(`#${selectedMethod.replace(/_/g, '-')}-form`).scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        return;
                    }
                }

                // If cash_on_delivery or payment completed, submit the form
                if (selectedMethod === 'cash_on_delivery') {
                    document.getElementById('payment_data').value = JSON.stringify({
                        terms_accepted: true
                    });
                }
                
                document.getElementById('checkout-form').submit();
            });
            
            // Function to check payment status
            function checkPaymentStatus(method) {
                // For credit card, check if card details are filled and validated
                if (method === 'credit_card') {
                    const form = document.getElementById('credit-card-form');
                    if (form) {
                        const cardNumber = form.querySelector('input[name="card_number"]');
                        const expiryDate = form.querySelector('input[name="expiry_date"]');
                        const cvv = form.querySelector('input[name="cvv"]');
                        
                        return cardNumber && cardNumber.value && 
                               expiryDate && expiryDate.value && 
                               cvv && cvv.value;
                    }
                    return false;
                }
                
                // For Bank Transfer, always return true as user will transfer later
                if (method === 'bank_transfer') {
                    return true;
                }
                
                return true; // For other methods like COD
            }

            // Show payment method selection modal
            btnChangeMethod.addEventListener('click', function() {
                methodBox.classList.remove('hidden');
            });

            // Close modal when a payment method is selected
            document.querySelectorAll('.method-option').forEach(button => {
                button.addEventListener('click', function() {
                    const selected = this.dataset.method;
                    document.getElementById('payment_method_input').value = selected;
                    currentMethod.textContent = selected.charAt(0).toUpperCase() + selected.slice(1)
                        .replaceAll('_', ' ');
                    methodBox.classList.add('hidden');

                    // Show the selected payment form
                    showPaymentForm(selected);
                });
            });

            // Close modal when cancel button is pressed
            closeMethodBtn.addEventListener('click', function() {
                methodBox.classList.add('hidden');
            });
        });

        // ============= ADDRESS LOGIC - SEPARATE LISTENER =============
        // Tách thành listener riêng để tránh xung đột với các listener khác
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Address logic loaded");
            
            // Các phần tử DOM address
            const openAddressFormBtn = document.getElementById('open-address-form');
            const toggleAddressListBtn = document.getElementById('toggle-address-list');
            const addressFormModal = document.getElementById('address-form-modal');
            const addressListContainer = document.getElementById('address-list-container');
            const closeAddressFormBtn = document.getElementById('close-address-form');
            
            // Debug - kiểm tra các phần tử có tồn tại không
            console.log("openAddressFormBtn:", openAddressFormBtn);
            console.log("toggleAddressListBtn:", toggleAddressListBtn);
            console.log("addressListContainer:", addressListContainer);
            
            // Mở form thêm địa chỉ mới
            if (openAddressFormBtn) {
                openAddressFormBtn.addEventListener('click', function(e) {
                    console.log("Open address form clicked");
                    e.preventDefault();
                    addressFormModal.classList.remove('hidden');
                });
            }

            // Mở danh sách địa chỉ
            if (toggleAddressListBtn) {
                toggleAddressListBtn.addEventListener('click', function(e) {
                    console.log("Toggle address list clicked");
                    e.preventDefault();
                    addressListContainer.classList.toggle('hidden');
                });
            }
            
            // Đóng form thêm địa chỉ
            if (closeAddressFormBtn) {
                closeAddressFormBtn.addEventListener('click', function() {
                    addressFormModal.classList.add('hidden');
                });
            }
            
            // Đóng danh sách địa chỉ
            document.querySelectorAll('.close-address-list').forEach(button => {
                button.addEventListener('click', function() {
                    addressListContainer.classList.add('hidden');
                });
            });
            
            // Chọn địa chỉ từ danh sách
            document.querySelectorAll('.address-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const phone = this.dataset.phone || 'N/A';
                    const address = this.dataset.address || 'N/A';
                    
                    console.log("Selected address:", id, phone, address);
                    
                    // Cập nhật thông tin hiển thị
                    document.getElementById('selected_address_id').value = id;
                    document.getElementById('selected-phone').textContent = phone;
                    document.getElementById('selected-address').textContent = address;
                    
                    // Ẩn danh sách địa chỉ
                    addressListContainer.classList.add('hidden');
                });
            });
            
            
            // Lưu địa chỉ mới
            const saveAddressBtn = document.getElementById('save-address');
            if (saveAddressBtn) {
                saveAddressBtn.addEventListener('click', function() {
                    const phone = document.getElementById('phone_number').value;
                    const province = document.getElementById('province').value;
                    const ward = document.getElementById('ward').value;
                    const detail = document.getElementById('address_detail').value;
                    
                    // Tạo địa chỉ đầy đủ
                    let fullAddress = detail;
                    if (ward) fullAddress += ', ' + ward;
                    if (province) fullAddress += ', ' + province;
                    
                    if (!phone || !province || !ward || !detail) {
                        alert("Please fill in all required information.");
                        return;
                    }
                    
                    fetch('{{ route('addresses.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            phone: phone,
                            address: fullAddress,
                            city: province,
                            ward: ward
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const id = data.address?.id || '';
                            const phone = data.address?.phone || 'N/A';
                            const addressText = data.address?.address || 'N/A';
                            
                            // Cập nhật địa chỉ được chọn ngay lập tức
                            document.getElementById('selected_address_id').value = id;
                            document.getElementById('selected-phone').textContent = phone;
                            document.getElementById('selected-address').textContent = addressText;
                            
                            // Thêm vào danh sách địa chỉ
                            const a = document.createElement('a');
                            a.href = '#';
                            a.className = 'address-item';
                            a.dataset.id = id;
                            a.dataset.phone = phone;
                            a.dataset.address = addressText;
                            
                            a.innerHTML = `
                                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 shadow-sm hover:bg-gray-100 transition">
                                    <p class="text-gray-800"><strong>Phone:</strong> ${phone}</p>
                                    <p class="text-gray-800"><strong>Address:</strong> ${addressText}</p>
                                </div>
                            `;
                            
                            const addressList = document.getElementById('address-list');
                            // Xóa message "no addresses" nếu có
                            const noAddressMsg = addressList.querySelector('.text-center');
                            if (noAddressMsg) {
                                noAddressMsg.remove();
                            }
                            addressList.appendChild(a);
                            
                            // Thêm event listener cho địa chỉ mới
                            a.addEventListener('click', function(e) {
                                e.preventDefault();
                                document.getElementById('selected_address_id').value = id;
                                document.getElementById('selected-phone').textContent = phone;
                                document.getElementById('selected-address').textContent = addressText;
                                addressListContainer.classList.add('hidden');
                            });
                            
                            // Ẩn modal và reset form
                            addressFormModal.classList.add('hidden');
                            document.getElementById('phone_number').value = '';
                            document.getElementById('province').value = '';
                            document.getElementById('ward').value = '';
                            document.getElementById('address_detail').value = '';
                            
                            alert("Address saved successfully!");
                        } else {
                            alert("Error: " + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(err => {
                        console.error("Error saving address:", err);
                        alert("Error saving address. Please try again.");
                    });
                });
            }
        });
    </script>


</x-app-layout>