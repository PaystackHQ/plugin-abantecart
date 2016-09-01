<script src="https://checkout.simplepay.ng/simplepay.js"></script>
<script>

    function processPaymentSimplePay(token) {

        var form = $('#checkout_form');
        form.append(
            $('<input />', { name: 'token', type: 'hidden', value: token })
        );
        form.submit();

    }

    var handler = SimplePay.configure({
        token: processPaymentSimplePay,
        key: '<?php echo $key; ?>',
        image: '<?php echo $image; ?>'
    });

    var desc = '<?php echo $customdesc;?>' == '' ? 'Payment of the Order ' : '<?php echo $customdesc;?>'

    function openCheckout(){ // add the event to your "pay" button
        handler.open(SimplePay.CHECKOUT, {
            email: '<?php echo $email; ?>', // optional: user's email
            phone: '<?php echo $phone; ?>', // optional: user's phone number
            description: desc, // a description of your choosing
            address: '<?php echo $address; ?>', // user's address
            postal_code: '<?php echo $postal_code; ?>', // user's postal code
            city: '<?php echo $city; ?>', // user's city
            country: '<?php echo $country; ?>', // user's country
            amount: SimplePay.amountToLower('<?php echo $amount; ?>'), // value of the purchase, ₦ 1100
            currency: '<?php echo $currency; ?>' // currency of the transaction
        });
    }

</script>

<form method="post" action="<?php echo $form_callback; ?>" id="checkout_form" >
    <input type="hidden" name="amount" value="<?php echo $amount; ?>"/>
    <input type="hidden" name="currency" value="<?php echo $currency; ?>"/>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
</form>

<div class="form-group action-buttons text-center">
    <a id="<?php echo $back->name ?>" href="<?php echo $back->href; ?>" class="btn btn-default mr10" title="<?php echo $back->text ?>">
        <i class="fa fa-arrow-left"></i>
        <?php echo $back->text ?>
    </a>
    <a href="javascript:openCheckout()">
        <button id="btn-checkout" class="btn btn-orange lock-on-click" title="<?php echo $button_confirm->name ?>" type="submit">
            <i class="fa fa-check"></i>
            <?php echo $button_confirm->name; ?>
        </button>
    </a>
</div>
