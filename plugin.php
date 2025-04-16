<?php
/**
 * Plugin Name: Gravity Forms Prevent Database Storing
 * Plugin URI:  https://github.com/devgeniem/wp-gravityforms-db-prevent
 * Description: A Gravity Forms plugin to let the form creator decide if the values should be saved to database or not.
 * Version:     0.0.2
 * Author:      Geniem
 * Author URI:  http://www.geniem.fi/
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: geniem-db-prevent
 * Domain Path: /languages
 */

namespace Geniem;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Plugin class
 */
class GF_DB_Prevent {

    /**
     * Plugin text domain
     */
    const TEXTDOMAIN = 'geniem-db-prevent';

    /**
     * Constructor to initialize things
     */
    public function __construct() {
        add_filter( 'gform_form_settings',          [ $this, 'form_setting' ],    10, 2 );
        add_filter( 'gform_tooltips',               [ $this, 'add_tooltip' ],     10, 1 );
        add_filter( 'gform_pre_form_settings_save', [ $this, 'save_setting' ],    10, 1 );
        add_filter( 'gform_after_submission',       [ $this, 'delete_entry' ],    10, 2 );
        add_action( 'plugins_loaded',               [ $this, 'load_textdomain' ], 10 );
    }

    /**
     * Add the custom form setting
     *
     * @param array $settings Form settings.
     * @param array $form     The form.
     * @return array
     */
    public function form_setting( array $settings, array $form ) : array {
        $settings[ __( 'Restrictions', 'gravityforms' ) ]['geniem_db_prevent'] = sprintf(
            '<tr>
                <th>%1$s %2$s</th>
                <td>
                    <input type="checkbox" value="1" name="geniem_db_prevent" id="geniem_db_prevent"%3$s>
                    <label for="geniem_db_prevent">%1$s</label>
                </td>
            </tr>',
            __( 'Prevent database storing', self::TEXTDOMAIN ),
            gform_tooltip( 'geniem_db_prevent', '', true ),
            rgar( $form, 'geniem_db_prevent' ) ? ' checked="checked"' : ''
        );

        return $settings;
    }

    /**
     * Save the custom form setting
     *
     * @param array $form Form settings.
     * @return array
     */
    public function save_setting( array $form ) : array {
        $form['geniem_db_prevent'] = rgpost( 'geniem_db_prevent' );

        return $form;
    }

    /**
     * Delete the entry in submission
     *
     * @param array $entry The form entry.
     * @param array $form  Form settings.
     * @return void
     */
    public function delete_entry( array $entry, array $form ) {
        // Only delete if the setting is set
        if ( ! empty( $form['geniem_db_prevent'] ) && $form['geniem_db_prevent'] ) {
            \GFAPI::delete_entry( $entry['id'] );
        }
    }

    /**
     * Add a tooltip for the setting
     *
     * @param array $tooltips Tooltips.
     * @return array
     */
    public function add_tooltip( array $tooltips ) : array {
        $tooltips['geniem_db_prevent'] = sprintf(
            '<h6>%s</h6> %s',
            __( 'Prevent database storing', self::TEXTDOMAIN ),
            __( 'When enabled, the form entry will be deleted from the database as soon as the emails are sent.', self::TEXTDOMAIN )
        );

        return $tooltips;
    }

    /**
     * Load plugin textdomain
     *
     * @return void
     */
    public function load_textdomain() {
        $data = get_plugin_data( __FILE__, false, true );

        load_plugin_textdomain( $data['TextDomain'], false, $data['DomainPath'] );
    }
}

// Initiate the plugin
new GF_DB_Prevent();
