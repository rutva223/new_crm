 
 <?php
     $profile = \App\Models\Utility::get_file('uploads/avatar/');
     $attachment = \App\Models\Utility::get_file('uploads/attachment/');
     // $profile=asset(Storage::url('uploads/avatar'));
     $logo = Utility::GetLogo();    

 ?>
 <?php $__env->startPush('script-page'); ?>
     <script src="https://js.stripe.com/v3/"></script>
     <script src="https://js.paystack.co/v1/inline.js"></script>
     <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
     <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

     <script type="text/javascript">
         <?php if(\Auth::user()->type != 'company'): ?>
             <?php if(
                 $invoice->getDue() > 0 &&
                     !empty($company_payment_setting) &&
                     $company_payment_setting['is_stripe_enabled'] == 'on' &&
                     !empty($company_payment_setting['stripe_key']) &&
                     !empty($company_payment_setting['stripe_secret'])): ?>

                 var stripe = Stripe('<?php echo e($company_payment_setting['stripe_key']); ?>');
                 var elements = stripe.elements();

                 // Custom styling can be passed to options when creating an Element.
                 var style = {
                     base: {
                         // Add your base input styles here. For example:
                         fontSize: '14px',
                         color: '#32325d',
                     },
                 };

                 // Create an instance of the card Element.
                 var card = elements.create('card', {
                     style: style
                 });

                 // Add an instance of the card Element into the `card-element` <div>.
                 card.mount('#card-element');

                 // Create a token or display an error when the form is submitted.
                 var form = document.getElementById('payment-form');
                 form.addEventListener('submit', function(event) {
                     event.preventDefault();

                     stripe.createToken(card).then(function(result) {
                         if (result.error) {
                             $("#card-errors").html(result.error.message);
                             toastrs('Error', result.error.message, 'error');
                         } else {
                             // Send the token to your server.
                             stripeTokenHandler(result.token);
                         }
                     });
                 });

                 function stripeTokenHandler(token) {
                     // Insert the token ID into the form so it gets submitted to the server
                     var form = document.getElementById('payment-form');
                     var hiddenInput = document.createElement('input');
                     hiddenInput.setAttribute('type', 'hidden');
                     hiddenInput.setAttribute('name', 'stripeToken');
                     hiddenInput.setAttribute('value', token.id);
                     form.appendChild(hiddenInput);

                     // Submit the form
                     form.submit();
                 }
             <?php endif; ?>
         <?php endif; ?>
     </script>


     <script>
         $('.cp_link').on('click', function() {
             var value = $(this).attr('data-link');
             var $temp = $("<input>");
             $("body").append($temp);
             $temp.val(value).select();
             document.execCommand("copy");
             $temp.remove();
             toastrs('Success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')
         });
         $(document).on("click", ".status_change", function() {
             var invoice_id = $(this).attr('data-invoice');
             var status = $(this).attr('data-id');
             $.ajax({
                 url: '<?php echo e(route('invoice.status.change')); ?>',
                 type: 'GET',
                 data: {
                     invoice_id: invoice_id,
                     status: status,
                     "_token": $('meta[name="csrf-token"]').attr('content')
                 },
                 success: function(data) {
                     location.reload();
                 }
             });
         });

         $(document).on('change', 'select[name=item]', function() {
             var item_id = $(this).val();
             $.ajax({
                 url: '<?php echo e(route('invoice.items')); ?>',
                 type: 'GET',
                 headers: {
                     'X-CSRF-TOKEN': jQuery('#token').val()
                 },
                 data: {
                     'item_id': item_id,
                 },
                 cache: false,
                 success: function(data) {
                     var invoiceItems = JSON.parse(data);

                     $('.price').val(invoiceItems.sale_price);
                     $('.quantity').val(invoiceItems.quantity);
                     $('.discount').val(0);

                     var taxes = '';
                     var tax = [];
                     if (invoiceItems.taxes != '') {
                         for (var i = 0; i < invoiceItems.taxes.length; i++) {
                             taxes += '<span class=" mr-1 mt-1">' + invoiceItems
                                 .taxes[i].name + ' ' + '(' + invoiceItems.taxes[i].rate + '%)' +
                                 '</span><br>';
                         }
                     } else {
                         taxes = '-';
                     }


                     $('.taxId').val(invoiceItems.tax);
                     $('.tax').html(taxes);


                 }
             });
         });

         $(document).on('click', '.type', function() {
             var obj = $(this).val();

             if (obj == 'milestone') {
                 $('.milestoneTask').removeClass('d-none');
                 $('.milestoneTask').addClass('d-block');
                 $('.title').removeClass('d-block');
                 $('.title').addClass('d-none');

             } else {
                 $('.title').removeClass('d-none');
                 $('.title').addClass('d-block');
                 $('.milestoneTask').removeClass('d-block');
                 $('.milestoneTask').addClass('d-none');
             }
         });

         <?php if(isset($company_payment_setting['paystack_public_key'])): ?>
             $(document).on("click", "#pay_with_paystack", function() {
                 $('#paystack-payment-form').ajaxForm(function(res) {
                     var amount = res.total_price;
                     if (res.flag == 1) {
                         var paystack_callback = "<?php echo e(url('/invoice/paystack')); ?>";

                         var handler = PaystackPop.setup({
                             key: '<?php echo e(isset($company_payment_setting['paystack_public_key']) ? $company_payment_setting['paystack_public_key'] : ''); ?>',
                             email: res.email,
                             amount: res.total_price * 100,
                             currency: res.currency,
                             ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                                 1
                             ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                             metadata: {
                                 custom_fields: [{
                                     display_name: "Email",
                                     variable_name: "email",
                                     value: res.email,
                                 }]
                             },

                             callback: function(response) {

                                 window.location.href = paystack_callback + '/' + response
                                     .reference + '/' + '<?php echo e(encrypt($invoice->id)); ?>' +
                                     '?amount=' + amount;
                             },
                             onClose: function() {
                                 alert('window closed');
                             }
                         });
                         handler.openIframe();
                     } else if (res.flag == 2) {
                         toastrs('Error', res.msg, 'msg');
                     } else {
                         toastrs('Error', res.message, 'msg');
                     }

                 }).submit();
             });
         <?php endif; ?>

         <?php if(isset($company_payment_setting['flutterwave_public_key'])): ?>
             //    Flaterwave Payment
             $(document).on("click", "#pay_with_flaterwave", function() {
                 $('#flaterwave-payment-form').ajaxForm(function(res) {

                     if (res.flag == 1) {
                         var amount = res.total_price;
                         var API_publicKey =
                             '<?php echo e(isset($company_payment_setting['flutterwave_public_key']) ? $company_payment_setting['flutterwave_public_key'] : ''); ?>';
                         var nowTim = "<?php echo e(date('d-m-Y-h-i-a')); ?>";
                         // var flutter_callback = "<?php echo e(url('/invoice/flaterwave')); ?>";
                         var x = getpaidSetup({
                             PBFPubKey: API_publicKey,
                             customer_email: '<?php echo e(Auth::user()->email); ?>',
                             amount: res.total_price,
                             currency: '<?php echo e(Utility::getValByName('site_currency')); ?>',
                             txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) +
                                 'fluttpay_online-' + '<?php echo e(date('Y-m-d')); ?>' + '?amount=' + amount,
                             meta: [{
                                 metaname: "payment_id",
                                 metavalue: "id"
                             }],
                             onclose: function() {},
                             callback: function(response) {
                                 var txref = response.tx.txRef;
                                 if (
                                     response.tx.chargeResponseCode == "00" ||
                                     response.tx.chargeResponseCode == "0"
                                 ) {
                                     window.location.href = '<?php echo e(url('invoice/flaterwave')); ?>' +
                                         '/' +
                                         '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>' +
                                         '/' + txref;
                                     // window.location.href = flutter_callback + '/' + txref + '/' + '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>';
                                 } else {
                                     // redirect to a failure page.
                                 }
                                 x
                                     .close(); // use this to close the modal immediately after payment.
                             }
                         });
                     } else if (res.flag == 2) {
                         toastrs('Error', res.msg, 'msg');
                     } else {
                         toastrs('Error', data.message, 'msg');
                     }

                 }).submit();
             });
         <?php endif; ?>

         <?php if(isset($company_payment_setting['razorpay_public_key'])): ?>
             // Razorpay Payment
             $(document).on("click", "#pay_with_razorpay", function() {
                 $('#razorpay-payment-form').ajaxForm(function(res) {
                     if (res.flag == 1) {
                         var amount = res.total_price;
                         var razorPay_callback = '<?php echo e(url('/invoice/razorpay')); ?>';
                         var totalAmount = res.total_price * 100;
                         var coupon_id = res.coupon;
                         var options = {
                             "key": "<?php echo e(isset($company_payment_setting['razorpay_public_key']) ? $company_payment_setting['razorpay_public_key'] : ''); ?>", // your Razorpay Key Id
                             "amount": totalAmount,
                             "name": 'Plan',
                             "currency": '<?php echo e(Utility::getValByName('site_currency')); ?>',
                             "description": "",
                             "handler": function(response) {
                                 window.location.href = razorPay_callback + '/' + response
                                     .razorpay_payment_id + '/' +
                                     '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>' +
                                     '?amount=' + amount;
                             },
                             "theme": {
                                 "color": "#528FF0"
                             }
                         };
                         var rzp1 = new Razorpay(options);
                         rzp1.open();
                     } else if (res.flag == 2) {
                         toastrs('Error', res.msg, 'msg');
                     } else {
                         toastrs('Error', data.message, 'msg');
                     }

                 }).submit();
             });
         <?php endif; ?>
     </script>
     <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"
         integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
         integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
     </script>
 <?php $__env->stopPush(); ?>
 <?php $__env->startSection('page-title'); ?>
     <?php echo e(__('Invoice Detail')); ?>

 <?php $__env->stopSection(); ?>
 <?php $__env->startSection('title'); ?>
     <div class="d-inline-block">
         <h5 class="h4 d-inline-block font-weight-400 mb-0 ">
             <?php echo e(\Auth::user()->invoicenumberFormat($invoice->invoice_id) . ' ' . __('Details')); ?></h5>
     </div>
 <?php $__env->stopSection(); ?>
 <?php $__env->startSection('breadcrumb'); ?>
     <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
     <li class="breadcrumb-item"><a href="<?php echo e(route('invoice.index')); ?>"><?php echo e(__('Invoice')); ?></a></li>
     <li class="breadcrumb-item active" aria-current="page"><?php echo e(\Auth::user()->invoicenumberFormat($invoice->invoice_id)); ?>

     </li>
 <?php $__env->stopSection(); ?>
 <?php $__env->startSection('action-btn'); ?>
     <a href="#" data-size="lg" data-url="<?php echo e(route('creditNote.create')); ?>" data-bs-toggle="modal"
         data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Create Payment')); ?>"
         class="btn btn-sm btn-primary btn-icon m-1">
         <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-title="<?php echo e(__('Add Credit Note')); ?>"><i
                 class="ti ti-plus"></i></span>
         <span class="btn-inner--text"><?php echo e(__('Add Credit Note')); ?></span>
     </a>

     <a href="#" class="btn btn-sm btn-primary btn-icon m-1 cp_link"
         data-link="<?php echo e(route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id))); ?>"
         data-toggle="tooltip" data-original-title="<?php echo e(__('Click to copy invoice link')); ?>">
         <span class="btn-inner--icon"><i class="ti ti-copy"data-bs-toggle="tooltip"
                 data-bs-original-title="<?php echo e(__('Copy')); ?>"></i></span>
         <span class="btn-inner--text"><?php echo e(__('Copy')); ?></span>

     </a>
     <?php if(\Auth::user()->type == 'company'): ?>
         <a href="#" data-size="lg" data-url="<?php echo e(route('invoice.create.item', $invoice->id)); ?>"
             data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Add Item')); ?>"
             class="btn btn-sm btn-primary btn-icon m-1">
             <span class="btn-inner--icon"><i class="ti ti-plus"></i></span>
             <span class="btn-inner--text"><?php echo e(__('Add Item')); ?></span>
         </a>


         <?php if($invoice->status != 0 && $invoice->status != 5): ?>
             <a href="<?php echo e(route('invoice.send', $invoice->id)); ?>" class="btn btn-sm btn-primary btn-icon m-1">
                 <span class="btn-inner--icon"><i class="ti ti-send"></i></span>
                 <span class="btn-inner--text"><?php echo e(__('Resend')); ?></span>
             </a>
         <?php else: ?>
             <?php if(!empty($invoice->items)): ?>
                 <a href="<?php echo e(route('invoice.send', $invoice->id)); ?>" class="btn btn-sm btn-primary btn-icon m-1">
                     <span class="btn-inner--icon"><i class="ti ti-send"></i></span>
                     <span class="btn-inner--text"><?php echo e(__('Send')); ?></span>
                 </a>
             <?php endif; ?>
         <?php endif; ?>
         <a href="#" data-size="lg" data-url="<?php echo e(route('invoice.create.receipt', $invoice->id)); ?>"
             data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo e(__('Add Receipt')); ?>"
             class="btn btn-sm btn-primary btn-icon m-1">
             <span class="btn-inner--icon"><i class="ti ti-plus"></i></span>
             <span class="btn-inner--text"><?php echo e(__('Add Receipt')); ?></span>
         </a>

         <a href="<?php echo e(route('invoice.send', $invoice->id)); ?>" class="btn btn-sm btn-primary btn-icon m-1 ">
             <span class="btn-inner--icon"><i class="ti ti-report-money"></i></span>
             <span class="btn-inner--text"><?php echo e(__('Payment Reminder')); ?></span>
         </a>
     <?php endif; ?>

     <a href="<?php echo e(route('invoice.pdf', \Crypt::encrypt($invoice->id))); ?>" target="_blank"
         class="btn btn-sm btn-primary btn-icon m-1">
         <span class="btn-inner--icon"><i class="ti ti-printer"></i></span>
         <span class="btn-inner--text"><?php echo e(__('Print')); ?></span>
     </a>

     <?php if(\Auth::user()->type == 'client'): ?>
         <?php if(
             $invoice->getDue() > 0 &&
                 !empty($company_payment_setting) &&
                 ($company_payment_setting['is_stripe_enabled'] == 'on' ||
                     $company_payment_setting['is_paypal_enabled'] == 'on' ||
                     $company_payment_setting['is_paystack_enabled'] == 'on' ||
                     $company_payment_setting['is_flutterwave_enabled'] == 'on' ||
                     $company_payment_setting['is_razorpay_enabled'] == 'on' ||
                     $company_payment_setting['is_mercado_enabled'] == 'on' ||
                     $company_payment_setting['is_paytm_enabled'] == 'on' ||
                     $company_payment_setting['is_mollie_enabled'] == 'on' ||
                     $company_payment_setting['is_paypal_enabled'] == 'on' ||
                     $company_payment_setting['is_skrill_enabled'] == 'on' ||
                     $company_payment_setting['is_coingate_enabled'] == 'on' ||
                     $company_payment_setting['is_paymentwall_enabled'] == 'on' ||
                     $company_payment_setting['is_toyyibpay_enabled'] == 'on' ||
                     $company_payment_setting['is_payfast_enabled'] == 'on' ||
                     $company_payment_setting['is_iyzipay_enabled'] == 'on' ||
                     $company_payment_setting['is_sspay_enabled'] == 'on' ||
                     $company_payment_setting['is_paytab_enabled'] == 'on' ||
                     $company_payment_setting['is_benefit_enabled'] == 'on' ||
                     $company_payment_setting['is_cashfree_enabled'] == 'on' ||
                     $company_payment_setting['is_aamarpay_enabled'] == 'on' ||
                     $company_payment_setting['is_paytr_enabled'] == 'on'
                    )): ?>
             <a href="#" data-bs-toggle="modal" data-bs-target="#paymentModal"
                 class="btn btn-sm btn-primary btn-icon m-1" type="button">
                 <i class="fas fa-coins mr-1"></i> <?php echo e(__('Pay Now')); ?>

             </a>
         <?php endif; ?>
     <?php endif; ?>
 <?php $__env->stopSection(); ?>

 <?php $__env->startSection('filter'); ?>
 <?php $__env->stopSection(); ?>
 <?php $__env->startSection('content'); ?>
     <div class="row">
         <!-- [ Invoice ] start -->
         <div class="container">
             <div class="card" id="printTable">
                 <div class="card-header">
                     <h4><?php echo e(__('Invoice')); ?></h4>
                 </div>
                 <div class="card-body">
                     <div class="row ">
                         <div class="col-md-8 invoice-contact">
                             <div class="invoice-box row">
                                 <div class="col-sm-12">
                                     <table class="table mt-0 table-responsive invoice-table table-borderless">
                                         <tbody>
                                             <tr>
                                                 <td><a href="<?php echo e(route('invoice.index')); ?>"><img class="img-fluid mb-3"
                                                             src="<?php echo e(\App\Models\Utility::get_file('uploads/logo/' . $logo).'?timestamp='.time()); ?>"
                                                             alt="Dashboard-kit Logo"></a>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td><?php echo e($settings['company_name']); ?>

                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>
                                                     <?php echo e($settings['company_address']); ?> <br>
                                                     <?php echo e($settings['company_city']); ?><br>
                                                     <?php echo e($settings['company_state']); ?>

                                                     <?php echo e($settings['company_zipcode']); ?> <br>
                                                     <?php echo e($settings['company_country']); ?>

                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td><?php echo e($settings['company_telephone']); ?>

                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="float-end">
                                 <?php echo DNS2D::getBarcodeHTML(
                                     route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id)),
                                     'QRCODE',
                                     2,
                                     2,
                                 ); ?>

                             </div>
                         </div>
                     </div>

                     <div class="row invoive-info d-print-inline-flex">
                         <?php if(!empty($invoice->clientDetail)): ?>
                             <div class="col-sm-4 invoice-client-info">
                                 <h6><?php echo e(__('Invoice To :')); ?></h6>
                                 <h6 class="m-0">
                                     <?php echo e(!empty($invoice->clientDetail->company_name) ? $invoice->clientDetail->company_name : ''); ?>

                                 </h6>

                                 <p class="m-0 m-t-10">
                                     <?php echo e(!empty($invoice->clientDetail->address_1) ? $invoice->clientDetail->address_1 : ''); ?>

                                     <br><?php echo e(!empty($invoice->clientDetail->city) ? $invoice->clientDetail->city : ''); ?>

                                     <br> <?php echo e(!empty($invoice->clientDetail->state) ? $invoice->clientDetail->state : ''); ?>

                                     
                                     <?php echo e(!empty($invoice->clientDetail->zip_code) ? $invoice->clientDetail->zip_code : ''); ?></span>
                                     
                                     <br>
                                     <?php echo e(!empty($invoice->clientDetail->country) ? $invoice->clientDetail->country : ''); ?>

                                 </p><br>
                                 <p class="m-0">
                                     <?php echo e(!empty($invoice->clientDetail->mobile) ? $invoice->clientDetail->mobile : ''); ?></p>
                             </div>
                         <?php endif; ?>
                         <div class="col-sm-4">
                             <h6 class="m-b-20"><?php echo e(__('Order Details :')); ?></h6>
                             <table class="table table-responsive mt-0 invoice-table invoice-order table-borderless">
                                 <tbody>
                                     <tr>
                                         <th><?php echo e(__('Issue Date :')); ?></th>
                                         <td><?php echo e(\Auth::user()->dateFormat($invoice->issue_date)); ?></td>
                                     </tr>
                                     <tr>
                                         <th><?php echo e(__('Expiry Date : ')); ?></th>
                                         <td><?php echo e(\Auth::user()->dateFormat($invoice->due_date)); ?></td>
                                     </tr>
                                     <tr>
                                         <th><?php echo e(__('Status : ')); ?></th>
                                         <td>
                                             <?php if($invoice->status == 0): ?>
                                                 <span
                                                     class="badge rounded bg-primary"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                             <?php elseif($invoice->status == 1): ?>
                                                 <span
                                                     class="badge rounded bg-info"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                             <?php elseif($invoice->status == 2): ?>
                                                 <span
                                                     class="badge rounded bg-secondary"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                             <?php elseif($invoice->status == 3): ?>
                                                 <span
                                                     class="badge rounded bg-danger"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                             <?php elseif($invoice->status == 4): ?>
                                                 <span
                                                     class="badge rounded bg-warning"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                             <?php elseif($invoice->status == 5): ?>
                                                 <span
                                                     class="badge rounded bg-success"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                             <?php endif; ?>
                                         </td>
                                     </tr>
                                     
                                 </tbody>
                             </table>
                         </div>
                         <div class="col-sm-4">
                             <h6 class="m-b-20"><?php echo e(__('Invoice No.')); ?></h6>
                             <h6 class="text-uppercase text-primary">
                                 <?php echo e(\Auth::user()->invoicenumberFormat($invoice->invoice_id)); ?>

                             </h6>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-12">
                             <div class="table-responsive mb-4">
                                 <table class="table invoice-detail-table">
                                     <thead>
                                         <tr class="thead-default">
                                             <th><?php echo e(__('Item')); ?></th>
                                             <th><?php echo e(__('Quantity')); ?></th>
                                             <th><?php echo e(__('Rate')); ?></th>
                                             <th><?php echo e(__('Tax')); ?></th>
                                             <th><?php echo e(__('Discount')); ?></th>
                                             <th><?php echo e(__('Price')); ?></th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                             $totalQuantity = 0;
                                             $totalRate = 0;
                                             $totalAmount = 0;
                                             $totalTaxPrice = 0;
                                             $totalDiscount = 0;
                                             $taxesData = [];
                                         ?>
                                         <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <tr>
                                                 <td>
                                                     <h6><?php echo e(!empty($item->item) ? $item->item : 'No Item'); ?></h6>
                                                     <p><?php echo e($item->description); ?></p>
                                                 </td>
                                                 <td><?php echo e($item->quantity); ?></td>
                                                 <td><?php echo e(\Auth::user()->priceFormat($item->price)); ?></td>
                                                 <td>
                                                     <?php if(!empty($item->tax)): ?>
                                                         <?php $__currentLoopData = $item->itemTax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <a href="#!"
                                                                 class="d-block text-sm text-muted"><?php echo e($tax['name'] . ' (' . $tax['rate'] . '%)'); ?>

                                                                 &nbsp;&nbsp;<?php echo e(($tax['price'])); ?></a>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                     <?php else: ?>
                                                         -
                                                     <?php endif; ?>
                                                 </td>
                                                 <td><?php echo e(\Auth::user()->priceFormat($item->discount)); ?></td>
                                                 <td><?php echo e(\Auth::user()->priceFormat($item->price * $item->quantity)); ?></td>
                                                 <?php
                                                     $totalQuantity += $item->quantity;
                                                     $totalRate += $item->price;
                                                     $totalDiscount += $item->discount;
                                                     $totalAmount += $item->price * $item->quantity;
                                                 ?>
                                             </tr>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-12">
                             <div class="invoice-total">
                                 <table class="table invoice-table ">
                                    <?php
                                        $invoiceTotalPrice = $invoice->getTotal();
                                        $invoiceCreditNote = $invoice->creditNotes->sum('amount');
                                        $invoiceGetDue = $invoice->getDue();
                                    ?>
                                     <tbody>
                                         <tr>
                                             <th><?php echo e(__('Sub Total :')); ?></th>
                                             <td><?php echo e(\Auth::user()->priceFormat($invoice->getSubTotal())); ?></td>
                                         </tr>
                                         <tr>
                                             <th><?php echo e(__('Discount :')); ?></th>
                                             <td><?php echo e(\Auth::user()->priceFormat($invoice->getTotalDiscount())); ?></td>
                                         </tr>
                                         <?php if(!empty($invoice->taxesData)): ?>
                                             <?php $__currentLoopData = $invoice->taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <tr>

                                                     <th><?php echo e($taxName); ?></th>
                                                     <td><?php echo e(\Auth::user()->priceFormat($taxPrice)); ?></td>
                                                 </tr>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                         <?php endif; ?>

                                         <tr>
                                             <th><?php echo e(__('Total :')); ?></th>
                                             <td><?php echo e(\Auth::user()->priceFormat($invoiceTotalPrice)); ?></td>
                                         </tr>
                                         <tr>
                                             <th><?php echo e(__('Credit Note :')); ?></th>
                                             <td><?php echo e(\Auth::user()->priceFormat($invoiceCreditNote)); ?></td>
                                         </tr>
                                         <tr>
                                             <th><?php echo e(__('Paid :')); ?></th>
                                             <td><?php echo e(\Auth::user()->priceFormat($invoiceTotalPrice - $invoiceGetDue - $invoiceCreditNote)); ?>

                                             </td>
                                         </tr>
                                         <tr>
                                             <th><?php echo e(__('Due :')); ?></th>
                                             <td><?php echo e(\Auth::user()->priceFormat($invoiceGetDue)); ?></td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- [ Invoice ] end -->

     
     <div class="row">
         <div class="col-sm-12">
             <div class="card table-responsive mb-4">
                 <div class="card-header">
                     <h5><?php echo e(__('Receipt Summary')); ?></h5>
                     <?php if($user_storage >= $plan_storage): ?>
                         <span
                             class="text-danger"><small><?php echo e(__('Your plan storage limit is over , so you can not see customer uploaded payment receipt.')); ?></small></span>
                     <?php endif; ?>
                 </div>
                 <table class="card-body table invoice-detail-table">
                     <thead>
                         <tr class="thead-default">
                             <th><?php echo e(__('Transaction ID')); ?></th>
                             <th><?php echo e(__('Payment Date')); ?></th>
                             <th><?php echo e(__('Payment Method')); ?></th>
                             <th><?php echo e(__('Payment Type')); ?></th>
                             <th><?php echo e(__('Note')); ?></th>
                             <th><?php echo e(__('Amount')); ?></th>
                             <?php if(\Auth::user()->type == 'company'): ?>
                                 <th> <?php echo e(__('Action')); ?></th>
                             <?php endif; ?>
                         </tr>
                     </thead>
                     <tbody>
                         
                         <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <tr>
                                 <td><?php echo e($payment->transaction); ?> </td>
                                 <td><?php echo e(\Auth::user()->dateFormat($payment->date)); ?> </td>
                                 <td><?php echo e(!empty($payment->payments) ? $payment->payments->name : ''); ?> </td>
                                 <td><?php echo e($payment->payment_type); ?> </td>
                                 <td><?php echo e($payment->notes); ?> </td>
                                 <td> <?php echo e(\Auth::user()->priceFormat($payment->amount)); ?></td>
                                 <td>
                                     <?php if($user_storage >= $plan_storage): ?>
                                     <?php else: ?>
                                         <?php if(!empty($payment->receipt)): ?>
                                             <?php
                                                 $x = pathinfo($payment->receipt, PATHINFO_FILENAME);
                                                 $extension = pathinfo($payment->receipt, PATHINFO_EXTENSION);
                                                 $result = str_replace(['#', "'", ';'], '', $payment->receipt);
                                                 // dd($result);
                                             ?>
                                             <a href="<?php echo e(route('invoice.receipt', [$x, "$extension"])); ?>"
                                                 data-toggle="tooltip"
                                                 class="btn btn-sm btn-primary btn-icon rounded-pill">
                                                 <i class="ti ti-download"></i>
                                             </a>
                                             <a href="<?php echo e($attachment . $x . '.' . $extension); ?>" target="_blank"
                                                 data-toggle="tooltip"
                                                 class="btn btn-sm btn-secondary btn-icon rounded-pill">
                                                 <i class="ti ti-crosshair" data-bs-toggle="tooltip"
                                                     data-bs-original-title="<?php echo e(__('Preview')); ?>"></i>
                                             </a>
                                         <?php else: ?>
                                         <?php endif; ?>
                                     <?php endif; ?>
                                     <?php if(\Auth::user()->type == 'company'): ?>
                                         <div class="action-btn bg-danger ms-2">
                                             <?php echo Form::open(['method' => 'DELETE', 'route' => ['invoice.payment.delete', $invoice->id, $payment->id]]); ?>

                                             <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                 <i class="ti ti-trash text-white"></i>
                                             </a>
                                             <?php echo Form::close(); ?>

                                         </div>
                                     <?php endif; ?>


                                 </td>

                             </tr>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         <?php $__currentLoopData = $banktransfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank_payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             
                             <tr>
                                 <td><?php echo e($bank_payment->order_id); ?> </td>
                                 <td><?php echo e(\Auth::user()->dateFormat($bank_payment->date)); ?> </td>
                                 <td><?php echo e('-'); ?> </td>
                                 <td> <?php echo e(__('Bank Transfer')); ?> </td>
                                 <td>
                                     <?php echo e(\Auth::user()->invoicenumberFormat($invoice->invoice_id)); ?>

                                 </td>
                                 <td><?php echo e(\Auth::user()->priceFormat($bank_payment->amount)); ?> </td>
                                 <td>
                                     <?php if($bank_payment->status == 'Pending' && \Auth::user()->type == 'company'): ?>
                                         <div class="action-btn bg-warning ms-2">
                                             <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                 data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                 data-url="<?php echo e(route('banktransfer.show', $bank_payment->id)); ?>"
                                                 data-bs-whatever="<?php echo e(__('Invoice Bank Transfer')); ?>"> <span
                                                     class="text-white">
                                                     <i class="ti ti-caret-right" data-bs-toggle="tooltip"
                                                         data-bs-original-title="<?php echo e(__('Invoice Bank Transfer')); ?>"></i></span></a>
                                         </div>
                                     <?php endif; ?>
                                     <?php if((\Auth::user()->type == 'company' && $bank_payment->status == 'Pending') || $bank_payment->status == 'Reject'): ?>
                                         <div class="action-btn bg-danger ms-2">
                                             <?php echo Form::open([
                                                 'method' => 'DELETE',
                                                 'route' => ['invoice.bankpayment.delete', $invoice->id, $bank_payment->id],
                                             ]); ?>

                                             <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                 <i class="ti ti-trash text-white"></i>
                                             </a>
                                             <?php echo Form::close(); ?>

                                         </div>
                                     <?php elseif(\Auth::user()->type == 'company'): ?>
                                         <div class="action-btn bg-danger ms-2">
                                             <?php echo Form::open(['method' => 'DELETE', 'route' => ['invoice.payment.delete', $invoice->id, $payment->id]]); ?>

                                             <a href="#!" class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                 <i class="ti ti-trash text-white"></i>
                                             </a>
                                             <?php echo Form::close(); ?>

                                         </div>
                                     <?php endif; ?>
                                 </td>
                             </tr>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
     
     <div class="row">
         <div class="col-sm-12">
             <div class="card table-responsive mb-4">
                 <div class="card-header">
                     <h5><?php echo e(__('Credit Note Summary')); ?></h5>
                     <div class="card-body table-responsive">
                         <table class="table" id="">
                             <thead>
                                 <tr>
                                     <th scope="col"><?php echo e(__('Invoice')); ?></th>
                                     <?php if(\Auth::user()->type != 'client'): ?>
                                         <th scope="col"><?php echo e(__('Client')); ?></th>
                                     <?php endif; ?>
                                     <th scope="col"><?php echo e(__('Date')); ?></th>
                                     <th scope="col"><?php echo e(__('Amount')); ?></th>
                                     <th scope="col"><?php echo e(__('Description')); ?></th>
                                     <?php if(\Auth::user()->type == 'company'): ?>
                                         <th scope="col" class="text-right"><?php echo e(__('Action')); ?></th>
                                     <?php endif; ?>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <?php if(!empty($invoice->creditNote)): ?>
                                         <?php $__currentLoopData = $invoice->creditNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $creditNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <tr>
                                                 <td>
                                                     <div class="media-body">
                                                         <a href="<?php echo e(route('invoice.show', \Crypt::encrypt($invoice->id))); ?>"
                                                             class="btn btn-outline-primary">
                                                             <?php echo e(AUth::user()->invoiceNumberFormat($invoice->invoice_id)); ?></a>
                                                     </div>
                                                 </td>
                                                 <?php if(\Auth::user()->type != 'client'): ?>
                                                     <td><?php echo e(!empty($invoice->clients) ? $invoice->clients->name : ''); ?>

                                                     </td>
                                                 <?php endif; ?>
                                                 <td><?php echo e(Auth::user()->dateFormat($creditNote->date)); ?></td>
                                                 <td><?php echo e(Auth::user()->priceFormat($creditNote->amount)); ?></td>
                                                 <td><?php echo e($creditNote->description); ?></td>
                                                 <td class="table-actions text-right">
                                                     <?php if(\Auth::user()->type == 'company'): ?>
                                                         <div class="action-btn bg-info ms-2">
                                                             <a href="#" data-size="lg"
                                                                 data-url="<?php echo e(route('creditNote.edit', $creditNote->id)); ?>"
                                                                 data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                 data-bs-whatever="<?php echo e(__('Edit Credit Note')); ?>"
                                                                 class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                                 <i class="ti ti-edit text-white" data-bs-toggle="tooltip"
                                                                     data-bs-original-title="<?php echo e(__('Edit')); ?>"></i>
                                                             </a>
                                                         </div>
                                                         <div class="action-btn bg-danger ms-2">
                                                             <?php echo Form::open(['method' => 'DELETE', 'route' => ['creditNote.destroy', $creditNote->id]]); ?>

                                                             <a href="#!"
                                                                 class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                                 <i class="ti ti-trash text-white"
                                                                     data-bs-toggle="tooltip"
                                                                     data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                                             </a>
                                                             <?php echo Form::close(); ?>

                                                         </div>
                                                     <?php endif; ?>
                                                 </td>
                                             </tr>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     <?php endif; ?>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!--Payment Modal-->
     <?php if(\Auth::user()->type == 'client'): ?>
         <?php if($invoice->getDue() > 0): ?>
             <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog"
                 aria-labelledby="paymentModalLabel" aria-hidden="true">
                 <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title" id="paymentModalLabel"><?php echo e(__('Add Payment')); ?></h5>
                             <button type="button" class="btn-close" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                         </div>

                         <div class="modal-body">
                             <?php if(
                                 !empty($company_payment_setting) &&
                                     ($company_payment_setting['is_stripe_enabled'] == 'on' ||
                                         $company_payment_setting['is_paypal_enabled'] == 'on' ||
                                         $company_payment_setting['is_paystack_enabled'] == 'on' ||
                                         $company_payment_setting['is_flutterwave_enabled'] == 'on' ||
                                         $company_payment_setting['is_razorpay_enabled'] == 'on' ||
                                         $company_payment_setting['is_mercado_enabled'] == 'on' ||
                                         $company_payment_setting['is_paytm_enabled'] == 'on' ||
                                         $company_payment_setting['is_mollie_enabled'] == 'on' ||
                                         $company_payment_setting['is_paypal_enabled'] == 'on' ||
                                         $company_payment_setting['is_skrill_enabled'] == 'on' ||
                                         $company_payment_setting['is_coingate_enabled'] == 'on' ||
                                         $company_payment_setting['is_paymentwall_enabled'] == 'on' ||
                                         $company_payment_setting['is_toyyibpay_enabled'] == 'on' ||
                                         $company_payment_setting['is_payfast_enabled'] == 'on' ||
                                         $company_payment_setting['is_iyzipay_enabled'] == 'on' ||
                                         $company_payment_setting['is_sspay_enabled'] == 'on' ||
                                         $company_payment_setting['is_paytab_enabled'] == 'on' ||
                                         $company_payment_setting['is_benefit_enabled'] == 'on' ||
                                         $company_payment_setting['is_cashfree_enabled'] == 'on' ||
                                         $company_payment_setting['is_aamarpay_enabled'] == 'on' ||
                                         $company_payment_setting['is_paytr_enabled'] == 'on'
                                         )): ?>
                                 <ul class="nav nav-pills  mb-3" role="tablist">
                                     <?php if(isset($company_payment_setting['is_bank_transfer_enabled']) &&
                                             $company_payment_setting['is_bank_transfer_enabled'] == 'on'): ?>
                                         <?php if(isset($company_payment_setting['bank_details']) && !empty($company_payment_setting['bank_details'])): ?>
                                             <li class="nav-item mb-2">
                                                 <a href="#banktransfer-payment"
                                                     class="btn btn-outline-primary btn-sm active"
                                                     aria-controls="banktransfer" data-bs-toggle="tab" role="tab"
                                                     aria-selected="false">
                                                     <?php echo e(__('BankTransfer')); ?>

                                                 </a>
                                             </li>&nbsp;
                                         <?php endif; ?>
                                     <?php endif; ?>
                                     <?php if(
                                         $company_payment_setting['is_stripe_enabled'] == 'on' &&
                                             !empty($company_payment_setting['stripe_key']) &&
                                             !empty($company_payment_setting['stripe_secret'])): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm" data-bs-toggle="tab"
                                                 href="#stripe-payment" role="tab" aria-controls="stripe"
                                                 aria-selected="true"><?php echo e(__('Stripe')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(
                                         $company_payment_setting['is_paypal_enabled'] == 'on' &&
                                             !empty($company_payment_setting['paypal_client_id']) &&
                                             !empty($company_payment_setting['paypal_secret_key'])): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#paypal-payment" role="tab" aria-controls="paypal"
                                                 aria-selected="false"><?php echo e(__('Paypal')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(
                                         $company_payment_setting['is_paystack_enabled'] == 'on' &&
                                             !empty($company_payment_setting['paystack_public_key']) &&
                                             !empty($company_payment_setting['paystack_secret_key'])): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#paystack-payment" role="tab" aria-controls="paystack"
                                                 aria-selected="false"><?php echo e(__('Paystack')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_flutterwave_enabled']) &&
                                             $company_payment_setting['is_flutterwave_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#flutterwave-payment" role="tab" aria-controls="flutterwave"
                                                 aria-selected="false"><?php echo e(__('Flutterwave')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_razorpay_enabled']) && $company_payment_setting['is_razorpay_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#razorpay-payment" role="tab" aria-controls="razorpay"
                                                 aria-selected="false"><?php echo e(__('Razorpay')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_mercado_enabled']) && $company_payment_setting['is_mercado_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#mercado-payment" role="tab" aria-controls="mercado"
                                                 aria-selected="false"><?php echo e(__('Mercado')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_paytm_enabled']) && $company_payment_setting['is_paytm_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#paytm-payment" role="tab" aria-controls="paytm"
                                                 aria-selected="false"><?php echo e(__('Paytm')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_mollie_enabled']) && $company_payment_setting['is_mollie_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#mollie-payment" role="tab" aria-controls="mollie"
                                                 aria-selected="false"><?php echo e(__('Mollie')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_skrill_enabled']) && $company_payment_setting['is_skrill_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#skrill-payment" role="tab" aria-controls="skrill"
                                                 aria-selected="false"><?php echo e(__('Skrill')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_coingate_enabled']) && $company_payment_setting['is_coingate_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#coingate-payment" role="tab" aria-controls="coingate"
                                                 aria-selected="false"><?php echo e(__('Coingate')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_paymentwall_enabled']) &&
                                             $company_payment_setting['is_paymentwall_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#paymentwall-payment" role="tab" aria-controls="paymentwall"
                                                 aria-selected="false"><?php echo e(__('PaymentWall')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_toyyibpay_enabled']) && $company_payment_setting['is_toyyibpay_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#toyyibpay-payment" role="tab" aria-controls="toyyibpay"
                                                 aria-selected="false"><?php echo e(__('Toyyibpay')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_payfast_enabled']) && $company_payment_setting['is_payfast_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#payfast-payment" role="tab" aria-controls="payfast"
                                                 aria-selected="false"><?php echo e(__('payfast')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_iyzipay_enabled']) && $company_payment_setting['is_iyzipay_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#iyzipay-payment" role="tab" aria-controls="iyzipay"
                                                 aria-selected="false"><?php echo e(__('Iyzipay')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_sspay_enabled']) && $company_payment_setting['is_sspay_enabled'] == 'on'): ?>
                                         <li class="nav-item mb-2">
                                             <a class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                                                 href="#sspay-payment" role="tab" aria-controls="sspay"
                                                 aria-selected="false"><?php echo e(__('Sspay')); ?></a>
                                         </li>&nbsp;
                                     <?php endif; ?>

                                     <?php if(isset($company_payment_setting['is_paytab_enabled']) && $company_payment_setting['is_paytab_enabled'] == 'on'): ?>
                                        <li class="nav-item mb-2">
                                            <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#paytab-payment" role="tab" aria-controls="paytab" type="button"
                                            aria-selected="false"><?php echo e(__('PayTab')); ?></button>
                                        </li>&nbsp;
                                    <?php endif; ?>

                                    <?php if(isset($company_payment_setting['is_benefit_enabled']) && $company_payment_setting['is_benefit_enabled'] == 'on'): ?>
                                        <li class="nav-item mb-2">
                                            <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#benefit-payment" role="tab" aria-controls="benefit" type="button"
                                                aria-selected="false"><?php echo e(__('Benefit')); ?></button>
                                        </li>&nbsp;
                                    <?php endif; ?>

                                    <?php if(isset($company_payment_setting['is_cashfree_enabled']) && $company_payment_setting['is_cashfree_enabled'] == 'on'): ?>
                                            <li class="nav-item mb-2">
                                                <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#cashfree-payment" role="tab" aria-controls="benefit" type="button"
                                                    aria-selected="false"><?php echo e(__('Cashfree')); ?></button>
                                            </li>&nbsp;
                                    <?php endif; ?>

                                    <?php if(isset($company_payment_setting['is_aamarpay_enabled']) && $company_payment_setting['is_aamarpay_enabled'] == 'on'): ?>
                                            <li class="nav-item mb-2">
                                                <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#aamarpay-payment" role="tab" aria-controls="benefit" type="button"
                                                    aria-selected="false"><?php echo e(__('Aamarpay')); ?></button>
                                            </li>&nbsp;
                                    <?php endif; ?>

                                    <?php if(isset($company_payment_setting['is_paytr_enabled']) && $company_payment_setting['is_paytr_enabled'] == 'on'): ?>
                                        <li class="nav-item mb-2">
                                            <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#paytr-payment" role="tab" aria-controls="benefit" type="button"
                                                aria-selected="false"><?php echo e(__('PayTr')); ?></button>
                                        </li>&nbsp;
                                    <?php endif; ?>

                                    <?php if(isset($company_payment_setting['is_yookassa_enabled'])  && $company_payment_setting['is_yookassa_enabled'] == 'on'): ?>
                                        <?php if(isset($company_payment_setting['is_yookassa_enabled']) && !empty($company_payment_setting['is_yookassa_enabled']) &&
                                        (isset($company_payment_setting['yookassa_shop_id']) && !empty($company_payment_setting['yookassa_shop_id'])) &&
                                        (isset($company_payment_setting['yookassa_secret_key']) && !empty($company_payment_setting['yookassa_secret_key']))): ?>
                                            <li class="nav-item mb-2">
                                                <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#yookassa-payment" role="tab" aria-controls="benefit" type="button"
                                                    aria-selected="false"><?php echo e(__('Yookassa')); ?></button>
                                            </li>&nbsp;
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(isset($company_payment_setting['is_midtrans_enabled']) && $company_payment_setting['is_midtrans_enabled'] == 'on'): ?>
                                        <?php if(isset($company_payment_setting['is_midtrans_enabled']) &&
                                                !empty($company_payment_setting['is_midtrans_enabled']) &&
                                                (isset($company_payment_setting['midtrans_secret']) && !empty($company_payment_setting['midtrans_secret']))): ?>
                                            <li class="nav-item mb-2">
                                                <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#midtrans-payment" role="tab" aria-controls="benefit" type="button"
                                                    aria-selected="false"><?php echo e(__('Midtrans')); ?></button>
                                            </li>&nbsp;
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(isset($company_payment_setting['is_xendit_enabled']) && $company_payment_setting['is_xendit_enabled'] == 'on'): ?>
                                        <?php if(isset($company_payment_setting['is_xendit_enabled']) &&
                                                !empty($company_payment_setting['is_xendit_enabled']) &&
                                                (isset($company_payment_setting['xendit_api_key']) && !empty($company_payment_setting['xendit_api_key'])) &&
                                                (isset($company_payment_setting['xendit_token']) && !empty($company_payment_setting['xendit_token']))): ?>
                                            <li class="nav-item mb-2">
                                                <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#xendit-payment" role="tab" aria-controls="benefit" type="button"
                                                    aria-selected="false"><?php echo e(__('Xendit')); ?></button>
                                            </li>&nbsp;
                                        <?php endif; ?>
                                    <?php endif; ?>

                                 </ul>
                             <?php endif; ?>
                             <div class="tab-content">
                                 <?php if(isset($company_payment_setting['is_bank_transfer_enabled']) && $company_payment_setting['is_bank_transfer_enabled'] == 'on'): ?>
                                     <?php if(isset($company_payment_setting['bank_details']) && !empty($company_payment_setting['bank_details'])): ?>
                                         <div class="tab-pane fade active show" id="banktransfer-payment" role="tabpanel"
                                             aria-labelledby="banktransfer-payment-tab">
                                             <div class="card-body">
                                                 <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                                     id="payment-form"
                                                     action="<?php echo e(route('invoice.pay.with.banktransfer')); ?>"
                                                     enctype="multipart/form-data">
                                                     <?php echo csrf_field(); ?>
                                                     <div class="row">
                                                         <div class="form-group col-md-12">
                                                             <div class="row">
                                                                 <div class="col-md-6">
                                                                     <?php echo isset($company_payment_setting['bank_details']) ? $company_payment_setting['bank_details'] : ''; ?>

                                                                 </div>
                                                                 <div class="col-md-6">
                                                                     <label for="payment_receipt"
                                                                         class="form-label"><?php echo e(__('Payment Receipt :')); ?></label>
                                                                     <input type="file" name="payment_receipt"
                                                                         class="form-control">
                                                                 </div>
                                                                 <?php $__errorArgs = ['payment_receipt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                     <span class="invalid-payment_receipt text-danger text-xs"
                                                                         role="alert"><?php echo e($messages); ?></span>
                                                                 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                             </div><br>

                                                             <label for="amount"
                                                                 class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                                             <span>
                                                                 <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?></span>
                                                             <div class="form-icon-addon">
                                                                 <!-- <span> <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?></span> -->
                                                                 <input class="form-control" required="required"
                                                                     min="0" name="amount" type="number"
                                                                     value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                                     step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                                     id="amount">
                                                                 <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                                     name="invoice_id">
                                                             </div>
                                                             <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <span class="invalid-amount text-danger text-xs"
                                                                     role="alert"><?php echo e($message); ?></span>
                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </div>

                                                         <div class="col-12 form-group mt-3 text-right">
                                                             <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                                 class="btn btn-sm btn-primary rounded-pill">
                                                         </div>
                                                     </div>
                                                 </form>
                                             </div>
                                         </div>
                                     <?php endif; ?>
                                 <?php endif; ?>

                                 <?php if(
                                     !empty($company_payment_setting) &&
                                         ($company_payment_setting['is_stripe_enabled'] == 'on' &&
                                             !empty($company_payment_setting['stripe_key']) &&
                                             !empty($company_payment_setting['stripe_secret']))): ?>
                                     <div class="tab-pane fade " id="stripe-payment" role="tabpanel"
                                         aria-labelledby="stripe-payment">
                                         <form method="post"
                                             action="<?php echo e(route('client.invoice.payment', $invoice->id)); ?>"
                                             class="require-validation" id="payment-form">
                                             <?php echo csrf_field(); ?>
                                             <div class="row">
                                                 <div class="col-sm-8">
                                                     <div class="custom-radio">
                                                         <label
                                                             class="font-16 font-weight-bold"><?php echo e(__('Credit / Debit Card')); ?></label>
                                                     </div>
                                                     <p class="mb-0 pt-1 text-sm">
                                                         <?php echo e(__('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.')); ?>

                                                     </p>
                                                 </div>

                                             </div>
                                             <div class="row">
                                                 <div class="col-md-12">
                                                     <div class="form-group">
                                                         <label for="card-name-on"><?php echo e(__('Name on card')); ?></label>
                                                         <input type="text" name="name" id="card-name-on"
                                                             class="form-control required"
                                                             placeholder="<?php echo e(\Auth::user()->name); ?>">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-12">
                                                     <div id="card-element">

                                                     </div>
                                                     <div id="card-errors" role="alert"></div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="form-group col-md-12">
                                                     <br>
                                                     <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                     <div class="input-group">
                                                         <span class="input-group-prepend"><span
                                                                 class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                         <input class="form-control" required="required" min="0"
                                                             name="amount" type="number"
                                                             value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                             step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                             id="amount">
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-12">
                                                     <div class="error" style="display: none;">
                                                         <div class='alert-danger alert'>
                                                             <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <button class="btn btn-sm btn-primary rounded-pill"
                                                     type="submit"><?php echo e(__('Make Payment')); ?></button>
                                             </div>
                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(
                                     !empty($company_payment_setting) &&
                                         ($company_payment_setting['is_paypal_enabled'] == 'on' &&
                                             !empty($company_payment_setting['paypal_client_id']) &&
                                             !empty($company_payment_setting['paypal_secret_key']))): ?>
                                     <div class="tab-pane fade " id="paypal-payment" role="tabpanel"
                                         aria-labelledby="paypal-payment">
                                         <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                             id="payment-form"
                                             action="<?php echo e(route('client.pay.with.paypal', $invoice->id)); ?>">
                                             <?php echo csrf_field(); ?>
                                             <div class="row">
                                                 <div class="form-group col-md-12">
                                                     <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                     <div class="input-group">
                                                         <span class="input-group-prepend"><span
                                                                 class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                         <input class="form-control" required="required" min="0"
                                                             name="amount" type="number"
                                                             value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                             step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                             id="amount">
                                                         <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                             <span class="invalid-amount" role="alert">
                                                                 <strong><?php echo e($message); ?></strong>
                                                             </span>
                                                         <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <button class="btn btn-sm btn-primary rounded-pill" name="submit"
                                                     type="submit"><?php echo e(__('Make Payment')); ?></button>
                                             </div>
                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(
                                     !empty($company_payment_setting) &&
                                         ($company_payment_setting['is_paystack_enabled'] == 'on' &&
                                             !empty($company_payment_setting['paystack_public_key']) &&
                                             !empty($company_payment_setting['paystack_secret_key']))): ?>
                                     <div class="tab-pane fade " id="paystack-payment" role="tabpanel"
                                         aria-labelledby="paypal-payment">
                                         <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                             id="paystack-payment-form"
                                             action="<?php echo e(route('invoice.pay.with.paystack')); ?>">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input class="btn btn-sm btn-primary rounded-pill" id="pay_with_paystack"
                                                     type="button" value="<?php echo e(__('Make Payment')); ?>">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(
                                     !empty($company_payment_setting) &&
                                         $company_payment_setting['is_flutterwave_enabled'] == 'on' &&
                                         !empty($company_payment_setting['flutterwave_public_key']) &&
                                         !empty($company_payment_setting['flutterwave_secret_key'])): ?>
                                     <div class="tab-pane fade " id="flutterwave-payment" role="tabpanel"
                                         aria-labelledby="paypal-payment">

                                         <form role="form" action="<?php echo e(route('invoice.pay.with.flaterwave')); ?>"
                                             method="post" class="require-validation" id="flaterwave-payment-form">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input class="btn btn-sm btn-primary rounded-pill"
                                                     id="pay_with_flaterwave" type="button"
                                                     value="<?php echo e(__('Make Payment')); ?>">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(isset($company_payment_setting['is_razorpay_enabled']) && $company_payment_setting['is_razorpay_enabled'] == 'on'): ?>
                                     <div class="tab-pane fade " id="razorpay-payment" role="tabpanel"
                                         aria-labelledby="paypal-payment">
                                         <form role="form" action="<?php echo e(route('invoice.pay.with.razorpay')); ?>"
                                             method="post" class="require-validation" id="razorpay-payment-form">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input class="btn btn-sm btn-primary rounded-pill" id="pay_with_razorpay"
                                                     type="button" value="<?php echo e(__('Make Payment')); ?>">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(isset($company_payment_setting['is_mercado_enabled']) && $company_payment_setting['is_mercado_enabled'] == 'on'): ?>
                                     <div class="tab-pane fade " id="mercado-payment" role="tabpanel"
                                         aria-labelledby="mercado-payment">
                                         <form role="form" action="<?php echo e(route('invoice.pay.with.mercado')); ?>"
                                             method="post" class="require-validation" id="mercado-payment-form">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input type="submit" id="pay_with_mercado"
                                                     value="<?php echo e(__('Make Payment')); ?>"
                                                     class="btn btn-sm btn-primary rounded-pill">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(isset($company_payment_setting['is_paytm_enabled']) && $company_payment_setting['is_paytm_enabled'] == 'on'): ?>
                                     <div class="tab-pane fade" id="paytm-payment" role="tabpanel"
                                         aria-labelledby="paytm-payment">
                                         <form role="form" action="<?php echo e(route('invoice.pay.with.paytm')); ?>"
                                             method="post" class="require-validation" id="paytm-payment-form">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="col-md-12">
                                                 <div class="form-group">
                                                     <label for="flaterwave_coupon"
                                                         class=" text-dark"><?php echo e(__('Mobile Number')); ?></label>
                                                     <input type="text" id="mobile" name="mobile"
                                                         class="form-control mobile" data-from="mobile"
                                                         placeholder="<?php echo e(__('Enter Mobile Number')); ?>" required>
                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input type="submit" id="pay_with_paytm"
                                                     value="<?php echo e(__('Make Payment')); ?>"
                                                     class="btn btn-sm btn-primary rounded-pill">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(isset($company_payment_setting['is_mollie_enabled']) && $company_payment_setting['is_mollie_enabled'] == 'on'): ?>
                                     <div class="tab-pane fade " id="mollie-payment" role="tabpanel"
                                         aria-labelledby="mollie-payment">
                                         <form role="form" action="<?php echo e(route('invoice.pay.with.mollie')); ?>"
                                             method="post" class="require-validation" id="mollie-payment-form">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input type="submit" id="pay_with_mollie"
                                                     value="<?php echo e(__('Make Payment')); ?>"
                                                     class="btn btn-sm btn-primary rounded-pill">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(isset($company_payment_setting['is_skrill_enabled']) && $company_payment_setting['is_skrill_enabled'] == 'on'): ?>
                                     <div class="tab-pane fade " id="skrill-payment" role="tabpanel"
                                         aria-labelledby="skrill-payment">
                                         <form role="form" action="<?php echo e(route('invoice.pay.with.skrill')); ?>"
                                             method="post" class="require-validation" id="skrill-payment-form">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <?php
                                                 $skrill_data = [
                                                     'transaction_id' => md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id'),
                                                     'user_id' => 'user_id',
                                                     'amount' => 'amount',
                                                     'currency' => 'currency',
                                                 ];
                                                 session()->put('skrill_data', $skrill_data);

                                             ?>
                                             <div class="form-group mt-3">
                                                 <input type="submit" id="pay_with_skrill"
                                                     value="<?php echo e(__('Make Payment')); ?>"
                                                     class="btn btn-sm btn-primary rounded-pill">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(isset($company_payment_setting['is_coingate_enabled']) && $company_payment_setting['is_coingate_enabled'] == 'on'): ?>
                                     <div class="tab-pane fade " id="coingate-payment" role="tabpanel"
                                         aria-labelledby="coingate-payment">
                                         <form role="form" action="<?php echo e(route('invoice.pay.with.coingate')); ?>"
                                             method="post" class="require-validation" id="coingate-payment-form">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input type="submit" id="pay_with_coingate"
                                                     value="<?php echo e(__('Make Payment')); ?>"
                                                     class="btn btn-sm btn-primary rounded-pill">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(
                                     !empty($company_payment_setting) &&
                                         ($company_payment_setting['is_paymentwall_enabled'] == 'on' &&
                                             !empty($company_payment_setting['paymentwall_public_key']) &&
                                             !empty($company_payment_setting['paymentwall_private_key']))): ?>
                                     <div class="tab-pane fade " id="paymentwall-payment" role="tabpanel"
                                         aria-labelledby="paymentwall-payment">
                                         <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                             id="paymentwall-payment-form"
                                             action="<?php echo e(route('invoice.paymentwallpayment')); ?>">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input class="btn btn-sm btn-primary rounded-pill"
                                                     id="pay_with_paymentwall" type="submit"
                                                     value="<?php echo e(__('Make Payment')); ?>">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 <?php if(
                                     !empty($company_payment_setting) &&
                                         ($company_payment_setting['is_toyyibpay_enabled'] == 'on' &&
                                             !empty($company_payment_setting['toyyibpay_secret_key']) &&
                                             !empty($company_payment_setting['category_code']))): ?>
                                     <div class="tab-pane fade " id="toyyibpay-payment" role="tabpanel"
                                         aria-labelledby="toyyibpay-payment">
                                         <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                             id="toyyibpay-payment-form"
                                             action="<?php echo e(route('invoice.toyyibpaypayment')); ?>">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="invoice_id"
                                                 value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                             <div class="form-group col-md-12">
                                                 <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                 <div class="input-group">
                                                     <span class="input-group-prepend"><span
                                                             class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                     <input class="form-control" required="required" min="0"
                                                         name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                         min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                         id="amount">

                                                 </div>
                                             </div>
                                             <div class="form-group mt-3">
                                                 <input class="btn btn-sm btn-primary rounded-pill"
                                                     id="pay_with_toyyibpay" type="submit"
                                                     value="<?php echo e(__('Make Payment')); ?>">
                                             </div>

                                         </form>
                                     </div>
                                 <?php endif; ?>

                                 
                                 <?php if(isset($company_payment_setting['is_payfast_enabled']) && $company_payment_setting['is_payfast_enabled'] == 'on'): ?>
                                     <?php if(isset($company_payment_setting['payfast_merchant_id']) &&
                                             !empty($company_payment_setting['payfast_merchant_id']) &&
                                             (isset($company_payment_setting['payfast_merchant_key']) &&
                                                 !empty($company_payment_setting['payfast_merchant_key']))): ?>
                                         <div class="tab-pane fade" id="payfast-payment" role="tabpanel"
                                             aria-labelledby="payfast-payment-tab">
                                             <?php
                                                 $pfHost = $company_payment_setting['payfast_mode'] == 'sandbox' ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
                                             ?>
                                             <form action=<?php echo e('https://' . $pfHost . '/eng/process'); ?> method="post"
                                                 class="require-validation" id="payfast-form">
                                                 
                                                 <?php echo csrf_field(); ?>
                                                 <div class="row">
                                                     <div class="form-group col-md-12">
                                                         <label for="amount"
                                                             class="col-form-lable"><?php echo e(__('Amount')); ?></label>
                                                         <div class="input-group col-md-12">
                                                            <span class="input-group-prepend"><span
                                                                class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                             <input type="number" class="form-control input_payfast"
                                                                 required min="0" name="amount"
                                                                 value="<?php echo e($invoice->getDue()); ?>" step="0.01"
                                                                 max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                                             <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                                 name="invoice_id" id="invoice_id">
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div id="get-payfast-inputs"></div>
                                                 <div class="col-12 form-group mt-3 text-right">
                                                     <input type="submit" class="btn btn-sm btn-primary rounded-pill"
                                                         id="pay_with_payfast" value="<?php echo e(__('Make Payment')); ?>">
                                                 </div>
                                             </form>
                                         </div>
                                     <?php endif; ?>
                                 <?php endif; ?>

                                 
                                 <?php if(isset($company_payment_setting['is_iyzipay_enabled']) && $company_payment_setting['is_iyzipay_enabled'] == 'on'): ?>
                                    <?php if(isset($company_payment_setting['iyzipay_public_key']) &&
                                    !empty($company_payment_setting['iyzipay_public_key']) &&
                                    (isset($company_payment_setting['iyzipay_secret_key']) && !empty($company_payment_setting['iyzipay_secret_key']))): ?>
                                    <div class="tab-pane fade" id="iyzipay-payment" role="tabpanel"
                                    aria-labelledby="iyzipay-payment-tab">
                                    <div class="card-body">
                                        
                                            <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                                id="payment-form"
                                                action="<?php echo e(route('client.pay.with.iyzipay', $invoice->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount"
                                                            class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                                        
                                                        <div class="input-group col-md-12">
                                                            <span class="input-group-prepend"><span
                                                                class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                                step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                                id="amount">
                                                        </div>
                                                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-amount text-danger text-xs"
                                                                role="alert"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="col-12 form-group mt-3 text-right">
                                                        <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                            class="btn btn-sm btn-primary rounded-pill">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                 <?php endif; ?>

                                 <?php if(
                                    !empty($company_payment_setting) &&
                                        ($company_payment_setting['is_sspay_enabled'] == 'on' &&
                                            !empty($company_payment_setting['sspay_secret_key']) &&
                                            !empty($company_payment_setting['sspay_category_code']))): ?>
                                    <div class="tab-pane fade " id="sspay-payment" role="tabpanel"
                                        aria-labelledby="sspay-payment">
                                        <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                            id="sspay-payment-form"
                                            action="<?php echo e(route('invoice.sspaypayment')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="invoice_id"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                                            <div class="form-group col-md-12">
                                                <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-prepend"><span
                                                            class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                                    <input class="form-control" required="required" min="0"
                                                        name="amount" type="number" value="<?php echo e($invoice->getDue()); ?>"
                                                        min="0" step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                        id="amount">

                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <input class="btn btn-sm btn-primary rounded-pill"
                                                    id="pay_with_sspay" type="submit"
                                                    value="<?php echo e(__('Make Payment')); ?>">
                                            </div>

                                        </form>
                                    </div>
                                 <?php endif; ?>

                                 <?php if(isset($company_payment_setting['is_paytab_enabled']) && $company_payment_setting['is_paytab_enabled'] == 'on'): ?>
                                <?php if(isset($company_payment_setting['paytab_profile_id']) &&
                                        !empty($company_payment_setting['paytab_profile_id']) &&
                                        (isset($company_payment_setting['paytab_server_key']) && !empty($company_payment_setting['paytab_server_key'])) &&
                                        (isset($company_payment_setting['paytab_region']) && !empty($company_payment_setting['paytab_region']))): ?>
                                    <div class="tab-pane fade" id="paytab-payment" role="tabpanel" aria-labelledby="paytab-payment">

                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('pay.with.paytab', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                         
                            

                            <?php if(isset($company_payment_setting['is_benefit_enabled']) && $company_payment_setting['is_benefit_enabled'] == 'on'): ?>
                                <?php if(isset($company_payment_setting['benefit_api_key']) &&
                                        !empty($company_payment_setting['benefit_api_key']) &&
                                        (isset($company_payment_setting['benefit_secret_key']) && !empty($company_payment_setting['benefit_secret_key']))): ?>
                                    <div class="tab-pane fade" id="benefit-payment" role="tabpanel"
                                        aria-labelledby="benefit-payment">

                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('pay.with.benefit', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                        
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(isset($company_payment_setting['is_cashfree_enabled']) && $company_payment_setting['is_cashfree_enabled'] == 'on'): ?>
                                <?php if(isset($company_payment_setting['cashfree_api_key']) &&
                                        !empty($company_payment_setting['cashfree_api_key']) &&
                                        (isset($company_payment_setting['cashfree_secret_key']) && !empty($company_payment_setting['cashfree_secret_key']))): ?>
                                    <div class="tab-pane fade" id="cashfree-payment" role="tabpanel"
                                        aria-labelledby="cashfree-payment">

                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('pay.with.cashfree', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(isset($company_payment_setting['is_aamarpay_enabled']) && $company_payment_setting['is_aamarpay_enabled'] == 'on'): ?>
                                <?php if(isset($company_payment_setting['aamarpay_store_id']) &&
                                        !empty($company_payment_setting['aamarpay_store_id']) &&
                                        (isset($company_payment_setting['aamarpay_signature_key']) && !empty($company_payment_setting['aamarpay_signature_key'])) &&
                                        (isset($company_payment_setting['aamarpay_description']) && !empty($company_payment_setting['aamarpay_description']))): ?>
                                    <div class="tab-pane fade" id="aamarpay-payment" role="tabpanel"
                                        aria-labelledby="aamarpay-payment">

                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('pay.with.aamarpay', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(isset($company_payment_setting['is_paytr_enabled']) && $company_payment_setting['is_paytr_enabled'] == 'on'): ?>
                                <?php if(isset($company_payment_setting['paytr_merchant_id']) &&
                                !empty($company_payment_setting['paytr_merchant_id']) &&
                                (isset($company_payment_setting['paytr_merchant_key']) && !empty($company_payment_setting['paytr_merchant_key'])) &&
                                (isset($company_payment_setting['paytr_merchant_salt']) && !empty($company_payment_setting['paytr_merchant_salt']))): ?>
                                    <div class="tab-pane fade" id="paytr-payment" role="tabpanel"
                                        aria-labelledby="paytr-payment">

                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('pay.with.paytr', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(isset($company_payment_setting['is_yookassa_enabled']) && $company_payment_setting['is_yookassa_enabled'] == 'on'): ?>
                                <?php if(isset($company_payment_setting['is_yookassa_enabled']) && !empty($company_payment_setting['is_yookassa_enabled']) &&
                                (isset($company_payment_setting['yookassa_shop_id']) && !empty($company_payment_setting['yookassa_shop_id'])) &&
                                (isset($company_payment_setting['yookassa_secret_key']) && !empty($company_payment_setting['yookassa_secret_key']))): ?>
                                    <div class="tab-pane fade" id="yookassa-payment" role="tabpanel"
                                        aria-labelledby="yookassa-payment">

                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('invoice.with.yookassa', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(isset($company_payment_setting['is_midtrans_enabled']) && $company_payment_setting['is_midtrans_enabled'] == 'on'): ?>
                                <?php if(isset($company_payment_setting['is_midtrans_enabled']) &&
                                !empty($company_payment_setting['is_midtrans_enabled']) &&
                                (isset($company_payment_setting['midtrans_secret']) && !empty($company_payment_setting['midtrans_secret']))): ?>
                                    <div class="tab-pane fade" id="midtrans-payment" role="tabpanel"
                                        aria-labelledby="midtrans-payment">
                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('invoice.with.midtrans', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(isset($company_payment_setting['is_xendit_enabled']) && $company_payment_setting['is_xendit_enabled'] == 'on'): ?>
                                <?php if(isset($company_payment_setting['is_xendit_enabled']) &&
                                !empty($company_payment_setting['is_xendit_enabled']) &&
                                (isset($company_payment_setting['xendit_api_key']) && !empty($company_payment_setting['xendit_api_key'])) &&
                                (isset($company_payment_setting['xendit_token']) && !empty($company_payment_setting['xendit_token']))): ?>
                                    <div class="tab-pane fade" id="xendit-payment" role="tabpanel"
                                        aria-labelledby="xendit-payment">
                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('invoice.with.xendit', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($company_payment_setting['currency_symbol']) ? $company_payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            </div>
                         </div>
                     </div>
                 </div>
             </div> 
         <?php endif; ?>
     <?php endif; ?>

 <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/invoice/view.blade.php ENDPATH**/ ?>