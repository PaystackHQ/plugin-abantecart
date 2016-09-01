<?php

if (!defined('DIR_CORE')) {
    header('Location: static_pages/');
}

$controllers = array(
    'storefront' => array(
        'responses/extension/paystack'
    ),
    'admin' => array( ),
);

$models = array(
    'storefront' => array( 'extension/paystack' ),
    'admin' => array( ),
);

$languages = array(
    'storefront' => array(
        'paystack/paystack'),
    'admin' => array(
        'paystack/paystack'));

$templates = array(
    'storefront' => array(
        'responses/paystack.tpl'),
    'admin' => array());
