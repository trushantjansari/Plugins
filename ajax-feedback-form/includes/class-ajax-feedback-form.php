<?php
/**
 * The file that defines the core plugin class
 *
 */

class Ajax_Feedback_Form{
    /**
    * The loader that's responsible for maintaining and registering all hooks that power the plugin.
    */
    protected $loader;

    /**
     * The current version of the plugin.
     */
    protected $ajax_feedback_form;

    /**
     * The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     */
    public function __construct() {
        if ( defined( 'AJAX_FEEDBACK_FORM_VERSION' ) ) {
            $this->version = AJAX_FEEDBACK_FORM_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->ajax_feedback_form = 'ajax-feedback-form';

        $this->load_dependencies();
        //$this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }
    /**
     *  Include the following files that make up the plugin:
	 *
	 * - Ajax_Feedback_Form_Loader. Orchestrates the hooks of the plugin.
	 * - Ajax_Feedback_Form_i18n. Defines internationalization functionality.
	 * - Ajax_Feedback_Form_Admin. Defines all hooks for the admin area.
	 * - Ajax_Feedback_Form_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
    */
    private function load_dependencies() {
        //** The class responsible for defining all actions that occur in the admin area. **/         
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ajax-feedback-form-loader.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ajax-feedback-form-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ajax-feedback-form-admin-settings.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ajax-feedback-form-admin-option.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ajax-feedback-form-admin-data.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ajax-feedback-form-public.php';
        

        $this->loader = new Ajax_Feedback_Form_Loader();

    }
    public function get_ajax_feedback_form() {
        return $this->ajax_feedback_form;
    }

    public function get_version() {
		return $this->version;
	}
    /**
     * 
     * Register all of the hooks related to the admin area functionality of the plugin.
     * 
     */
    private function define_admin_hooks() {
        $plugin_admin_options = new Ajax_Feedback_Form_Admin_Options( $this->get_ajax_feedback_form(), $this->get_version() );
    
        $this->loader->add_action('admin_init', $plugin_admin_options, 'settings_init');
        $this->loader->add_action('admin_menu', $plugin_admin_options, 'admin_menu');
        $this->loader->add_action('admin_menu', $plugin_admin_options, 'load_user_list_table_screen_options');
       
        // $plugin_admin = new Ajax_Feedback_Form_Admin( $this->get_ajax_feedback_form(), $this->get_version() );
        // $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        
    }
    /**
	 *
     *  Register all of the hooks related to the public-facing functionality of the plugin.
	 *
	 */
	private function define_public_hooks() {

		$plugin_public = new Ajax_Feedback_Form_Public( $this->get_ajax_feedback_form(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_nopriv_ajff_sentemail', $plugin_public, 'ajff_sentemail' );
		$this->loader->add_action( 'wp_ajax_ajff_sentemail', $plugin_public, 'ajff_sentemail' ); 
		add_shortcode('ajax_feedback_form', array($plugin_public, 'ajax_feedback_form_frontend' )); 
        add_shortcode('ajax_feedback_list', array($plugin_public, 'ajax_feedback_list_frontend' ));

	}

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run() {
        $this->loader->run();

    }

}
?>