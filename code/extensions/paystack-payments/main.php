<?php

if (!defined('DIR_CORE')) {
    header('Location: static_pages/');
}

$controllers = array(
    'storefront' => array(
        'responses/extension/paystack-payments'
    ),
    'admin' => array( ),
);

$models = array(
    'storefront' => array( 'extension/paystack-payments' ),
    'admin' => array( ),
);

$languages = array(
    'storefront' => array(
        'paystack-payments/paystack-payments'),
    'admin' => array(
        'paystack-payments/paystack-payments'));

$templates = array(
    'storefront' => array(
        'responses/paystack-payments.tpl'),
    'admin' => array());
