
# Paystack Abantecart Plugin

Welcome to the Paystack Abantecart plugin repository on GitHub. 

Here you can browse the source code, look at open issues and keep track of development.

## Installation 

### Minimum Requirements

* Confirm that your server can conclude a TLSv1.2 connection to Paystack's servers. More information about this requirement can be gleaned here: [TLS v1.2 requirement](https://developers.paystack.co/blog/tls-v12-requirement).
* PHP with the 21 Oct 2026 security fixes for critical remote code execution flaws (GHSA-w8hw-w9fx-j79w, GHSA-6wmf-4rv5-p3rp; [php.net advisory](https://www.php.net/releases/8_2_35.php)): **8.2.35, 8.3.36, 8.4.27, 8.5.12 or later**. PHP 8.1 and older no longer receive security fixes.
* AbanteCart 1.4.x or later is recommended for PHP 8.2+. AbanteCart [1.3.4](https://www.abantecart.com/shopping-cart-news/abantecart-134-release) only set PHP 8.0 as its minimum, [1.4.0](https://www.abantecart.com/shopping-cart-news/abantecart-140-released) added PHP 8.3 support and [1.4.2](https://www.abantecart.com/shopping-cart-news/abantecart-142-release) added PHP 8.4 support; AbanteCart does not document PHP 8.5 support. The extension manifest (`config.xml`, `package.xml`) currently declares compatibility with AbanteCart 1.3 only, and this plugin has not been tested inside a real AbanteCart 1.3 or 1.4 install, so if you are on 1.3.x and cannot run a patched PHP 8.2+, upgrade AbanteCart first.
* At least version 4.0.0 of the WPJobster theme

### Automatic installation

Automatic installation is the easiest option as Abantecart handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of Abantecart Paystack Gateway, log in to your Abantecart dashboard, navigate to the Integrations menu and click "Payments".

In the search field type “Paystack” and click Search Plugins. Once you’ve found our payment plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Add to cart”, then complete the checkout process.


## Documentation

* [Paystack Documentation](https://paystack.com/docs/)
* [Paystack Helpdesk](https://paystack.com/help)

## Support

For bug reports and feature requests directly related to this plugin, please use the [issue tracker](https://github.com/PaystackHQ/plugin-abantecart/issues). 

For general support or questions about your Paystack account, you can reach out by sending a message from [our website](https://paystack.com/contact).

## Community

If you are a developer, please join our Developer Community on [Slack](https://slack.payslack.com).

## Contributing to the Abantecart plugin

If you have a patch or have stumbled upon an issue with the Abantecart plugin, you can contribute this back to the code. Please read our [contributor guidelines](https://github.com/PaystackHQ/plugin-abantecart/blob/master/CONTRIBUTING.md) for more information how you can do this.
