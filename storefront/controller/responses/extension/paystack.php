<?php

if ( !defined ( 'DIR_CORE' )) {
    header ( 'Location: static_pages/' );
}

class ControllerResponsesExtensionPaystack extends AController{

    public $data = array();
    // public function generate_new_code($length = 4){
    //   $characters = 'RS01234ABCD6789KTUVWLMNOPQEFGHIJ5XYZ';
    //   $charactersLength = Tools::strlen($characters);
    //   $randomString = '';
    //   for ($i = 0; $i < $length; $i++) {
    //       $randomString .= $characters[rand(0, $charactersLength - 1)];
    //   }
    //   return $randomString;
    // }
    public function main(){

        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['button_back'] = $this->language->get('button_back');

        if ($this->config->get('paystack_sandbox') == 'test') {
            $this->data['key'] = $this->config->get('paystack_putk');
        }
        else {
            $this->data['key'] = $this->config->get('paystack_pulk');
        }

        if($this->config->get('embed_mode')) {
            $this->data['target_parent'] = 'target="_parent"';
        }

        $this->data['image'] = $this->config->get('paystack_customimg');
        $this->data['customdesc'] = $this->config->get('paystack_customdesc');

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
        $this->data['form_callback'] = $this->html->getSecureURL('extension/paystack/callback');

        $this->load->library('encryption');
        $encryption = new AEncryption($this->config->get('encryption_key'));
        $this->data['id'] = $encryption->encrypt($this->session->data['order_id']);
        // $this->data['txn_code'] = $encryption->encrypt($this->session->data['order_id']);

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
        $this->processTemplate('responses/paystack.tpl');
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

        $prk = $this->config->get('paystack_sandbox') ? $this->config->get('paystack_prtk') : $this->config->get('paystack_prlk');

        // $verified_transaction = verify_transaction($this->request->post['token'], $this->request->post['amount'], $this->request->post['currency'], $prk);

        $verified_transaction = verify_txn($this->request->post['id'],$prk);
        if (($verification->status===false) || (!property_exists($verification, 'data')) || ($verification->data->status !== 'success')) {
            $this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'),'Processing Payment');

            $msg = new AMessage();
            $msg->saveError('Paystack Payment','Error verifying the payment of the order '.$order_id.' ! Check transaction API result : '.json_encode($verified_transaction['response']));
        }else{
          $this->model_checkout_order->confirm($order_id, $this->config->get('paystack_order_status_id'),'The Order was payed with success, transaction id : '.$verified_transaction['response']['id']);

        }

        $this->redirect($this->html->getURL('checkout/success'));

    }

}
