<?php
/**
 * Plugin Name: WP Simple Cookie Consent
 * Plugin URI: https://github.com/willcrobinson/wp-simple-cookie-consent
 * Description: A simple cookie consent plugin with customisable options
 * Version: 1.02
 * Author: Ombush Media Ltd
 * Author URI: https://ombush.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * DISCLAIMER:
 * This plugin is provided "as is" without any warranties, express or implied.
 * The user assumes all responsibility for its use. The authors and copyright
 * holders of this software shall not be liable for any damages or liability
 * whatsoever which may arise from the use, misuse, or inability to use this software.
 * This includes, but is not limited to, any general, special, incidental or
 * consequential damages, including damages for loss of data or profit, arising out
 * of the use or inability to use the software, even if the authors have been advised
 * of the possibility of such damages.
 *
 * The use of this plugin does not guarantee compliance with any laws or regulations,
 * including but not limited to the General Data Protection Regulation (GDPR).
 * Users are solely responsible for ensuring their own compliance with all applicable
 * laws and regulations.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Simple_Cookie_Consent {
    public function __construct() {
        $this->default_message = "{{SITE_NAME}} uses cookies to enhance your browsing experience. We use essential cookies for basic site functionality. We'd also like to use optional cookies for analytics and personalisation. You can accept all cookies or choose your preferences below. For more information, please see our Privacy Policy/Cookie Policy.";
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_head', array($this, 'display_cookie_banner'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        register_deactivation_hook(__FILE__, array($this, 'deactivation_hook'));
    }

    public function add_admin_menu() {
        add_options_page('Simple Cookie Consent', 'Cookie Consent', 'manage_options', 'simple-cookie-consent', array($this, 'admin_page'));
    }

    public function register_settings() {
        register_setting('simple_cookie_consent_settings', 'scc_html_code');
        register_setting('simple_cookie_consent_settings', 'scc_message');
        register_setting('simple_cookie_consent_settings', 'scc_background_color');
        register_setting('simple_cookie_consent_settings', 'scc_text_color');
        register_setting('simple_cookie_consent_settings', 'scc_button_color');
        register_setting('simple_cookie_consent_settings', 'scc_button_text_color');
        register_setting('simple_cookie_consent_settings', 'scc_link_color');
        register_setting('simple_cookie_consent_settings', 'scc_privacy_policy_url');
        register_setting('simple_cookie_consent_settings', 'scc_cookie_policy_url');
        register_setting('simple_cookie_consent_settings', 'scc_consent_period');
        register_setting('simple_cookie_consent_settings', 'scc_delete_on_deactivate');
    }

    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>Simple Cookie Consent Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('simple_cookie_consent_settings');
                do_settings_sections('simple_cookie_consent_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="scc_html_code">HTML Code</label></th>
                        <td><textarea name="scc_html_code" rows="5" cols="50"><?php echo esc_textarea(get_option('scc_html_code')); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_message">Consent Message</label></th>
                        <td>
                            <input type="text" name="scc_message" value="<?php echo esc_attr(get_option('scc_message', $this->default_message)); ?>" class="regular-text">
                            <p class="description">Use {{SITE_NAME}} as a placeholder for your site's name.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_background_color">Background Color</label></th>
                        <td><input type="color" name="scc_background_color" value="<?php echo esc_attr(get_option('scc_background_color', '#f1f1f1')); ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_text_color">Text Color</label></th>
                        <td><input type="color" name="scc_text_color" value="<?php echo esc_attr(get_option('scc_text_color', '#333333')); ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_button_color">Button Background Color</label></th>
                        <td><input type="color" name="scc_button_color" value="<?php echo esc_attr(get_option('scc_button_color', '#0073aa')); ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_button_text_color">Button Text Color</label></th>
                        <td><input type="color" name="scc_button_text_color" value="<?php echo esc_attr(get_option('scc_button_text_color', '#ffffff')); ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_link_color">Link Color</label></th>
                        <td><input type="color" name="scc_link_color" value="<?php echo esc_attr(get_option('scc_link_color', '#0000ff')); ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_privacy_policy_url">Privacy Policy URL</label></th>
                        <td><input type="url" name="scc_privacy_policy_url" value="<?php echo esc_url(get_option('scc_privacy_policy_url')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_cookie_policy_url">Cookie Policy URL</label></th>
                        <td><input type="url" name="scc_cookie_policy_url" value="<?php echo esc_url(get_option('scc_cookie_policy_url')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_consent_period">Consent Period (days)</label></th>
                        <td>
                            <input type="number" name="scc_consent_period" value="<?php echo esc_attr(get_option('scc_consent_period', 180)); ?>" min="1" max="365" class="small-text">
                            <p class="description">Number of days before asking for consent again. Default is 180 days (6 months).</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="scc_delete_on_deactivate">Delete settings on deactivation</label></th>
                        <td>
                            <input type="checkbox" name="scc_delete_on_deactivate" value="1" <?php checked(1, get_option('scc_delete_on_deactivate', 0)); ?>>
                            <p class="description">If checked, all plugin settings will be deleted when the plugin is deactivated.</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function display_cookie_banner() {
        if (!isset($_COOKIE['simple_cookie_consent'])) {
            $message = get_option('scc_message', $this->default_message);
            $message = str_replace('{{SITE_NAME}}', get_bloginfo('name'), $message);
    
            $privacy_policy_url = get_option('scc_privacy_policy_url');
            $cookie_policy_url = get_option('scc_cookie_policy_url');
            
            echo '<div id="simple-cookie-consent">';
            echo '<p>' . esc_html($message) . '</p>';

            if ($privacy_policy_url || $cookie_policy_url) {
                echo '<div class="policy-links">';
                if ($privacy_policy_url) {
                    echo '<a href="' . esc_url($privacy_policy_url) . '" target="_blank">Privacy Policy</a>';
                }
                if ($cookie_policy_url) {
                    echo '<a href="' . esc_url($cookie_policy_url) . '" target="_blank">Cookie Policy</a>';
                }
                echo '</div>';
            }
            
            
            echo '<div class="button-container">';
            echo '<button id="scc-accept">Accept</button>';
            echo '<button id="scc-decline">Decline</button>';
            echo '</div>';
            

            echo '</div>';
        } elseif ($_COOKIE['simple_cookie_consent'] === 'accept') {
            echo get_option('scc_html_code');
        }
    }

    public function enqueue_scripts() {
        wp_enqueue_style('simple-cookie-consent', plugin_dir_url(__FILE__) . 'css/simple-cookie-consent.css', array(), '1.4');
        wp_enqueue_script('simple-cookie-consent', plugin_dir_url(__FILE__) . 'js/simple-cookie-consent.js', array('jquery'), '1.4', true);
        
        $custom_css = $this->generate_custom_css();
        wp_add_inline_style('simple-cookie-consent', $custom_css);

        $consent_period = get_option('scc_consent_period', 180);
        wp_localize_script('simple-cookie-consent', 'sccData', array(
            'consentPeriod' => $consent_period
        ));
    }

    private function generate_custom_css() {
        $bg_color = get_option('scc_background_color', '#f1f1f1');
        $text_color = get_option('scc_text_color', '#333333');
        $button_color = get_option('scc_button_color', '#0073aa');
        $button_text_color = get_option('scc_button_text_color', '#ffffff');
        $link_color = get_option('scc_link_color', '#0000ff');

        $custom_css = "
            #simple-cookie-consent {
                background-color: {$bg_color};
                color: {$text_color};
            }
            #simple-cookie-consent button {
                background-color: {$button_color};
                color: {$button_text_color};
            }
            #simple-cookie-consent .policy-links a {
                color: {$link_color};
            }
        ";

        return $custom_css;
    }

    public function deactivation_hook() {
        if (get_option('scc_delete_on_deactivate', 0)) {
            $this->delete_all_settings();
        }
    }

    private function delete_all_settings() {
        delete_option('scc_html_code');
        delete_option('scc_message');
        delete_option('scc_background_color');
        delete_option('scc_text_color');
        delete_option('scc_button_color');
        delete_option('scc_button_text_color');
        delete_option('scc_link_color');
        delete_option('scc_privacy_policy_url');
        delete_option('scc_cookie_policy_url');
        delete_option('scc_consent_period');
        delete_option('scc_delete_on_deactivate');
    }
}

$simple_cookie_consent = new Simple_Cookie_Consent();
