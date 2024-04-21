
<?php $stripe_session = Session::get('stripe_session'); ?>
<?php $Settings = App\Models\Setting::pluck('value', 'name'); ?>
<?php if(isset($stripe_session) && $stripe_session && isset($stripe_session->id)): ?>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe("{{ $Settings['stripe_key'] }}");
    console.log(stripe);
    stripe.redirectToCheckout({
        sessionId: '{{ $stripe_session->id }}',
    }).then((result) => {});
</script>
<?php endif ?>
<?php Session::put('stripe_session', $stripe_session); ?>
