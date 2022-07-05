<?php

/**
 * Plugin Name: OTS AAC
 * Description: Open Tibia Server Automatic Account Creator
 * Version:     1.0.0
 * Author:      Sorn
 * Text Domain: ots-aac
 */

if ( ! defined( 'ABSPATH' ) ) {
    // Exit if not loaded by WP core.
    exit;
}

if ( ! function_exists( 'oa_options_page' ) ) {
    add_action( 'admin_menu', 'oa_options_page' );

    function oa_options_page() {
        add_options_page(
            'OTS AAC',
            'OTS AAC',
            'manage_options',
            'oa-options',
            'oa_options_html'
        );
    }

    function oa_options_html() {
        ?>
        <h1>OTS AAC</h1>
        <form method="POST" action="options.php">
            <?php
            settings_fields( 'oa-options' );
            do_settings_sections( 'oa-options' );
            submit_button( 'Save' );
            ?>
        </form>
        <?php
    }
}

if ( ! function_exists( 'oa_settings_init' ) ) {
    add_action( 'admin_init', 'oa_settings_init' );

    function oa_settings_init() {
        add_option(
            'oa_server_config_path',
            '/home/otsaac/tfs/config.lua'
        );

        register_setting(
            'oa-options',
            'oa_server_config_path',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        add_settings_section(
            'oa_settings_config',
            'Configuration',
            'oa_settings_config_html',
            'oa-options'
        );

        add_settings_field(
            'oa_settings_server_config_path',
            'Path to server config',
            'oa_settings_server_config_path_html',
            'oa-options',
            'oa_settings_config'
        );
    }

    function oa_settings_config_html() {
        echo 'Link to your Open Tibia Server';
    }

    function oa_settings_server_config_path_html() {
        $option = get_option( 'oa_server_config_path' );
        ?>
        <input
            type="text"
            name="oa_server_config_path"
            value="<?php echo isset( $option ) ? esc_attr( $option ) : ''; ?>"
            placeholder="/your/server/config.lua">
        <?php
    }
}
