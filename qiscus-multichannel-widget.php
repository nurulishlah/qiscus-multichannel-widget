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

if (!defined('QISCUS_MULTICHANNEL_URL'))
    define('QISCUS_MULTICHANNEL_URL', plugin_dir_url(__FILE__));
if (!defined('QISCUS_MULTICHANNEL_PATH'))
    define('QISCUS_MULTICHANNEL_PATH', plugin_dir_path(__FILE__));

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
        add_action('admin_menu', array($this, 'addAdminMenu'));
        add_action('wp_ajax_store_admin_data', array($this, 'storeAdminData'));
        add_action('admin_enqueue_scripts', array($this, 'addAdminScripts'));
    }

    public function addAdminMenu()
    {
        add_menu_page(
            __('Qiscus Multichannel', 'qmultichannel'),
            __('Qiscus Multichannel', 'qmultichannel'),
            'manage_options',
            'qmultichannel',
            array($this, 'adminLayout'),
            ''
        );
    }

    public function adminLayout()
    {
        $data = $this->getData();
        $app_id = $data['app_id'];
        ?>

        <div class="wrap">
            <h1><?php _e('Qiscus Multichannel Widget Settings', 'qmultichannel'); ?></h1>
            <p>
                <?php _e('Please provide your Qiscus Multichannel App ID. You can get your App ID from <a href="https://qismo.qiscus.com/settings#information">App Information page</a>',
                    'qmultichannel'); ?>
            </p>
            <hr>
            <form id="qmultichannel-admin-form">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <label><?php _e('App ID', 'qmultichannel') ?></label>
                        </th>
                        <td>
                            <input type="text" name="qmultichannel_app_id"
                                   id="qmultichannel_app_id"
                                   class="regular-text"
                                   target="_blank"
                                   placeholder="Put your app id here ..."
                                   value="<?php
                                   echo (isset($data['app_id'])) ? $data['app_id'] : '';
                                   ?>"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input type="submit"
                           name="submit"
                           id="qmultichannel-admin-save" class="button button-primary"
                           value="<?php _e( 'Save Changes', 'qmultichannel' ); ?>">
                </p>
            </form>
        </div>

        <?php
    }

    private $option_name = 'qmultichannel_data';

    /**
     * Returns the saved options data as an array
     *
     * @return array
     */
    private function getData()
    {
        return get_option($this->option_name, array());
    }

    /**
     * The security nonce
     *
     * @var string
     */
    private $_nonce = 'qmultichannel_admin';

    /**
     * Qiscus Multichannel saving process
     */
    public function addAdminScripts()
    {

        wp_enqueue_script('qmultichannel-admin', QISCUS_MULTICHANNEL_URL, 'assets/js/admin.js', array(), 1.0);

        $admin_options = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            '_nonce'   => wp_create_nonce($this->_nonce),
        );

        wp_localize_script('qmultichannel-admin', 'qmultichannel_exchanger', $admin_options);
    }

    public function storeAdminData()
    {
        if (wp_verify_nonce($_POST['security'], $this->_nonce) === false)
            die('Invalid Request!');

        $data = $this->getData();

        foreach ($_POST as $field=>$value) {
            if (substr($field, 0, 13) !== "qmultichannel_" || empty($value))
                continue;

            $field = substr($field, 13);

            $data[$field] = esc_attr__($value);
        }

        update_option($this->option_name);

        echo __('App ID Saved!', 'qmultichannel');
        die();

    }
}

/*
 * Start the plugin
 */
new QiscusMultichannel();