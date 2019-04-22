<?php
/**
 * Plugin Name: Qiscus Multichannel CS Widget
 * Description: Simple plugin to integrate Qiscus Multichannel CS Widget
 * Version:     0.0.1
 * Author:      Muhamad Saad Nurul Ishlah
 * Author URI:  https://ishlah.github.io/
 * Plugin URI:  https://github.com/nurulishlah/qiscus-multichannel-widget
*/

/**
 * Plugin constants
*/

if (!defined('QMCW_URL'))
    define('QMCW_URL', plugin_dir_url(__FILE__));
if (!defined('QMCW_PATH'))
    define('QMCW_PATH', plugin_dir_path(__FILE__));

/**
 * Class QiscusMultichannel
 */
class QiscusMultichannel
{

    /**
     * QiscusMultichannel constructor.
     */
    public function __construct()
    {

    }
}

/*
 * Start the plugin
 */
new QiscusMultichannel();