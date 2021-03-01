<form method="post" action="<?php echo $form_callback; ?>" id="checkout_form" >
    <input type="hidden" name="amount" value="<?php echo $amount; ?>"/>
    <input type="hidden" name="currency" value="<?php echo $currency; ?>"/>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="hidden" name="txn_code" value="<?php echo $txn_code; ?>"/>
    <a id="<?php echo $back->name ?>" href="<?php echo $back->href; ?>" class="btn btn-default mr10" title="<?php echo $back->text ?>">
        <i class="fa fa-arrow-left"></i>
        <?php echo $back->text ?>
    </a>
    <script
      src="https://js.paystack.co/v1/inline.js"
      data-key="<?php echo $key; ?>"
      data-email="<?php echo $email; ?>"
      data-currency="<?php echo $currency; ?>"
      data-amount="<?php echo $amount*100; ?>"
      data-ref="<?php echo $txn_code; ?>">
    </script>

</form>
