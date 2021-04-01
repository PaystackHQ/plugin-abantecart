<?php

if ( !defined ( 'DIR_CORE' )) {
    header ( 'Location: static_pages/' );
}

class ControllerResponsesExtensionPaystackPayments extends AController{

    public $data = array();
    public function generate_code($length = 4){
      $characters = 'RS01234ABCD6789KTUVWLMNOPQEFGHIJ5XYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
    public function main(){

        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['button_back'] = $this->language->get('button_back');

        if ($this->config->get('paystack_sandbox') == 'test') {
            $this->data['key'] = $this->config->get('paystack_tpk');
        }
        else {
            $this->data['key'] = $this->config->get('paystack_lpk');
        }

        if($this->config->get('embed_mode')) {
            $this->data['target_parent'] = 'target="_parent"';
        }

        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $this->data['amount'] = $this->currency->format($order_info['total'], $order_info['currency'], $order_info['value'], FALSE);
        $this->data['country'] = $order_info['shipping_iso_code_2'];
        $this->data['currency'] = $order_info['currency'];
        $this->data['phone'] = $order_info['telephone'];
        $this->data['email'] = $order_info['email'];
        $this->data['city'] = $order_info['shipping_city'];
        $this->data['postal_code'] = $order_info['shipping_postcode'];
        $this->data['address'] = $order_info['shipping_address_1'];
        $this->data['form_callback'] = $this->html->getSecureURL('extension/paystack_payments/callback');

        $this->load->library('encryption');
        $encryption = new AEncryption($this->config->get('encryption_key'));
        $this->data['id'] = $encryption->encrypt($this->session->data['order_id']);
        $this->data['txn_code'] = $this->generate_code().$this->session->data['order_id'].$this->generate_code();

        if ($this->request->get['rt'] != 'checkout/guest_step_3') {
            $this->data['back'] = $this->html->getSecureURL('checkout/payment');
        } else {
            $this->data['back'] = $this->html->getSecureURL('checkout/guest_step_2');
        }

        $back = $this->request->get[ 'rt' ] != 'checkout/guest_step_3'
            ? $this->html->getSecureURL('checkout/payment')
            : $this->html->getSecureURL('checkout/guest_step_2');

        $this->data[ 'back' ] = HtmlElementFactory::create(array( 'type' => 'button',
            'name' => 'back',
            'text' => $this->language->get('button_back'),
            'style' => 'button',
            'href' => $back ));

        $this->data[ 'button_confirm' ] = HtmlElementFactory::create(
            array( 'type' => 'submit',
                'name' => $this->language->get('button_confirm'),
                'style' => 'button',
            ));

        $this->view->batchAssign( $this->data );
        $this->processTemplate('responses/paystack_payments.tpl');
    }

    function callback(){

        include_once 'verify.php';

        if ($this->request->is_GET()) {
            $this->redirect($this->html->getURL('index/home'));
        }

        $this->load->library('encryption');
        $encryption = new AEncryption($this->config->get('encryption_key'));

        if (isset($this->request->post['id'])) {
            $order_id = $encryption->decrypt($this->request->post['id']);
        } else {
            $order_id = 0;
        }

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);

        if(!$order_info){
            error_log('asd',0);
            return null;
        }
        if ($this->config->get('paystack_sandbox') == 'test') {
            $prk =  $this->config->get('paystack_tsk');
        }
        else {
            $prk =  $this->config->get('paystack_lsk');
        }

        $verification = verify_txn($this->request->post['txn_code'],$prk);
        if (($verification->status===false) || (!property_exists($verification, 'data')) || ($verification->data->status !== 'success')) {
            $this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'),'Processing Payment');

            $msg = new AMessage();
            $msg->saveError('Paystack','Error verifying the payment of the order '.$order_id);
        }else{
          $this->model_checkout_order->confirm($order_id, $this->config->get('paystack_order_status_id'),'Payment was successful, Transaction ID : '.$this->request->post['txn_code']);

        }

        $this->redirect($this->html->getURL('checkout/success'));

    }

}
