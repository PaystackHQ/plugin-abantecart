<?php

if (!defined('DIR_CORE')) {
    header('Location: static_pages/');
}

$controllers = array(
    'storefront' => array(
        'responses/extension/paystack_payments'
    ),
    'admin' => array( ),
);

$models = array(
    'storefront' => array( 'extension/paystack_payments' ),
    'admin' => array( ),
);

$languages = array(
    'storefront' => array(
        'paystack_payments/paystack_payments'),
    'admin' => array(
        'paystack_payments/paystack_payments'));

$templates = array(
    'storefront' => array(
        'responses/paystack_payments.tpl'),
    'admin' => array());
