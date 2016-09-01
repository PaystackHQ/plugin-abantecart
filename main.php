<?php

if (!defined('DIR_CORE')) {
    header('Location: static_pages/');
}

$controllers = array(
    'storefront' => array(
        'responses/extension/simplepay_payments'
    ),
    'admin' => array( ),
);

$models = array(
    'storefront' => array( 'extension/simplepay_payments' ),
    'admin' => array( ),
);

$languages = array(
    'storefront' => array(
        'simplepay_payments/simplepay_payments'),
    'admin' => array(
        'simplepay_payments/simplepay_payments'));

$templates = array(
    'storefront' => array(
        'responses/simplepay_payments.tpl'),
    'admin' => array());