@include('layout.header')
<div class="card">
  <div class="section">
  <div class="row">
    <div class="col-6">
        <form action="{{route('processPayment', [$product->name, $product->price])}}" method="POST"
            id="subscribe-form"> @csrf
            <div class="form-group">
                <div class="row">
                    <h4>Products Details</h4>
                <div class="col-12">
                        <div class="subscription-option">
                            <label for="plan-silver">
                                <span class="plan-price">Product Name : {{$product->name}}</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="subscription-option">
                            <label for="plan-silver">
                                <span class="plan-price">Description : {{$product->description}}</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="subscription-option">
                            <label for="plan-silver">
                                <span class="plan-price">Price : Rs. {{$product->price}}</span>
                            </label>
                        </div>
                    </div>

                </div>
                <hr>
            </div>

            <div class="form-group">
                <div class="row">
                    <h4>Card Details</h4>

                    <div class="col-12">
                        <div class="subscription-option">
                            <label for="plan-silver">
                            <span class="plan-price">Card Name:</span>
                        <input id="card-holder-name" type="text" value="{{$user->name}}" >
                            </label>
                        </div>
                    </div>

                        <div class="col-4"><span class="plan-price">Card Name:</span></div>

                        <div class="col-8">
                        <div class="subscription-option">

                            <div id="card-element" class="form-control"> </div>
                            <div id="card-errors" role="alert"></div>
                            </div>
                            </div>
            </div>
            <div class="stripe-errors"></div>
            @if (count($errors) > 0)<div class="alert alert-danger">
                @foreach($errors->all() as $error)
                {{ $error }}<br>
                @endforeach
            </div>
            @endif
            <div class="mt-4 form-group text-center"><button type="button" id="card-button"
                    data-secret="{{ $intent->client_secret }}"
                    class="btn btn-lg btn-success btn-block"> Pay</button>
            </div>
        </form>
    </div>
 </div>
</div>
</div>
@include('layout.footer')


<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        var card = elements.create('card', {
            hidePostalCode: true,
            style: style
        });
        card.mount('#card-element');
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        cardButton.addEventListener('click', async (e) => {
            cardButton.disabled = true;
            console.log("attempting");
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            });
            if (error) {
                cardButton.disabled = false;
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                paymentMethodHandler(setupIntent.payment_method);
            }
        });

        function paymentMethodHandler(payment_method) {
            var form = document.getElementById('subscribe-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', payment_method);
            form.appendChild(hiddenInput);
            form.submit();
        }
</script>
