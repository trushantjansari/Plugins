<?php

/**
 * The admin-specific functionality of the plugin.
 *
 */

class Ajax_Feedback_Form_Admin_Options {

    /**
     * The ID of this plugin.
     */
    private $ajax_feedback_form;

    /**
     * The version of this plugin.
     */
    private $version;


    /**
     * The settings api of this plugin.
     *
     */
    private $settings_api;

    /**
     * The settings api of this plugin.
     *
     */
    private $feedback_data;

    /**
     * Initialize the class and set its properties.
     **/
    public function __construct( $ajax_feedback_form, $version ) {

        $this->ajax_feedback_form = $ajax_feedback_form;
        $this->version = $version;

        $this->settings_api = new Ajax_Feedback_Form_Settings_API($this->ajax_feedback_form, $this->version);
       
    }


    public function admin_menu() {
        add_menu_page(
            __('Ajax Feedback Form', 'ajax-feedback-form'),  // page title
            __('Ajax Feedback Form', 'ajax-feedback-form' ),  // menu title
            'manage_options',
            'wp_aff',
            array($this, 'admin_about'),
            'dashicons-email', // icon
            75 // priority
        );

        add_submenu_page(
            'wp_aff',
            __('Feedback List', 'ajax-feedback-form'),  // page title
            __('Feedback Data', 'ajax-feedback-form' ),  // menu title
            'manage_options',  // page permission
            'wp_affd',  // page slug
            array($this, 'admin_feedback_data')
        );

        add_submenu_page(
            'wp_aff',
            __('Settings', 'ajax-feedback-form'),  // page title
            __('Settings', 'ajax-feedback-form' ),  // menu title
            'manage_options',  // page permission
            'wp_affs',  // page slug
            array($this, 'admin_settings')
        );

    }

    public function load_user_list_table_screen_options(){
        $arguments = array(
            'label'		=>	__( 'Users Per Page', 'ajax-feedback-form' ),
            'default'	=>	5,
            'option'	=>	'users_per_page'
        );
        add_screen_option( 'per_page', $arguments );
    
    }   

    public function admin_settings() {

        include('ajax-feedback-form-admin-settings.php');
    }

    public function admin_feedback_data(){
        $this->feedback_data = new Ajax_Feedback_Form_List();
        $this->feedback_data->prepare_items();
        //$this->feedback_data->ajax_response();
         include('ajax-feedback-form-admin-table.php');
    }

    public function admin_about() {

        include('ajax-feedback-form-admin-about.php');
    }
   
    public function settings_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'ajff_style_one',
                'title' => __( 'General', 'ajax-feedback-form' ),
            ),
            array(
                'id'    => 'ajff_style_two',
                'title' => __( 'Form (Mail)', 'ajax-feedback-form' )
            ),
            array(
                'id'    => 'ajff_style_three',
                'title' => __( 'Database', 'ajax-feedback-form' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public function get_settings_fields() {
        $settings_fields = array(
            'ajff_style_one' => array(
                
                array(
                    'name'              => 't1_form_title',
                    'label'             => __( 'Form Title', 'ajax-feedback-form' ),
                    'desc'              => __( 'Write form title here.', 'ajax-feedback-form' ),
                    'placeholder'       => __( 'Feedback Form', 'ajax-feedback-form' ),
                    'type'              => 'text',
                    'default'           => 'Submit your feedback',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                
                array(
                    'name'    => 't1_from_bgc',
                    'label'   => __( 'Form  Button BG Color', 'ajax-feedback-form' ),
                    'desc'    => __( 'Pick a color for button background.', 'ajax-feedback-form' ),
                    'type'    => 'color',
                    'default' => '#5cb85c'
                ),
                array(
                    'name'    => 't1_from_bdrc',
                    'label'   => __( 'Form  Button Border Color', 'ajax-feedback-form' ),
                    'desc'    => __( 'Pick a color for button border.', 'ajax-feedback-form' ),
                    'type'    => 'color',
                    'default' => '#4cae4c'
                ),

                array(
                    'name'              => 't1_list_title',
                    'label'             => __( 'List Title', 'ajax-feedback-form' ),
                    'desc'              => __( 'Write List title here.', 'ajax-feedback-form' ),
                    'placeholder'       => __( 'Feedback List', 'ajax-feedback-form' ),
                    'type'              => 'text',
                    'default'           => 'Feebback List',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'              => 't1_list_perpage',
                    'label'             => __( 'List Per Page', 'ajax-feedback-form' ),
                    'desc'              => __( 'List Per Page here.', 'ajax-feedback-form' ),
                    'placeholder'       => __( 'Feedback List Per Page', 'ajax-feedback-form' ),
                    'type'              => 'text',
                    'default'           => '5',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
               
            ),
            'ajff_style_two' => array(
                array(
                    'name'              => 't2_mail_sub',
                    'label'             => __( 'Mail Subject', 'ajax-feedback-form' ),
                    'desc'              => __( 'Write mail subject here.', 'ajax-feedback-form' ),
                    'placeholder'       => __( 'Email Subject Title.', 'ajax-feedback-form' ),
                    'type'              => 'text',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'              => 't2_mail_to',
                    'label'             => __( 'Mail To', 'ajax-feedback-form' ),
                    'desc'              => __( 'Write recieved mail here.', 'ajax-feedback-form' ),
                    'placeholder'       => __( '', 'ajax-feedback-form' ),
                    'type'              => 'text',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
            ),
            'ajff_style_three' => array(
                
                array(
                    'name'              => 't1_form_db',
                    'label'             => __( 'Table Option', 'ajax-feedback-form' ),
                    'desc'              => __( 'Delete Feedback data and table from database while uninstall plugin', 'ajax-feedback-form' ),
                    'type'              => 'checkbox',
                    'default'           => false,
                    'sanitize_callback' => 'sanitize_text_field'
                )   
            ),
        );

        return $settings_fields;
    }

    

}
