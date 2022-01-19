<?php

/**
 * The admin-specific functionality of the plugin.
 *
 */
class Ajax_Feedback_Form_Admin {

    /**
     * The ID of this plugin.
     *
     */
    private $ajax_feedback_form;

    /**
     * The version of this plugin.
     *
     */
    private $version;


    /**
     * The settings api of this plugin.
     */
    private $settings_api;

    /**
     * The plugin plugin_base_file of the plugin.
     */
    protected $plugin_base_file;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct( $ajax_feedback_form, $version ) {

        $this->ajax_feedback_form = $ajax_feedback_form;
        $this->version = $version;

        $this->settings_api = new Ajax_Feedback_Form_Settings_API($this->ajax_feedback_form, $this->version);

    }

    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles() {

        wp_enqueue_style( $this->ajax_feedback_form, plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->ajax_feedback_form, plugin_dir_url( __FILE__ ) . 'js/main.js', array( 'jquery' ), $this->version, false );

    }



}
