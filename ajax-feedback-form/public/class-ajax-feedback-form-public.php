<?php

class Ajax_Feedback_Form_Public {

    /**
     * The ID of this plugin.
     */
    private $ajax_feedback_form;

    /**
     * The version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct( $ajax_feedback_form, $version ) {

        $this->ajax_feedback_form = $ajax_feedback_form;
        $this->version = $version;

        $this->settings_api = new Ajax_Feedback_Form_Settings_API($this->ajax_feedback_form, $this->version); 

    }
    /**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'ajff-bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'ajff-animate', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' ); 
		wp_enqueue_style( 'ajff-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *

	 */
	public function enqueue_scripts() {
 
		wp_enqueue_script( 'ajff-form-validator', plugin_dir_url( __FILE__ ) . 'js/form-validator.min.js', array('jquery'), $this->version, true );
		wp_enqueue_script( 'ajff-feedback-form', plugin_dir_url( __FILE__ ) . 'js/feedback-form-script.js', array('ajff-form-validator'), $this->version, true );
		wp_enqueue_script( 'ajff-main', plugin_dir_url( __FILE__ ) . 'js/main.js', array('ajff-feedback-form'), $this->version, true );
		// Localize the script with new data
		wp_localize_script( 'ajff-feedback-form', 'ajff', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

    // Feedback form
	function ajff_sentemail() {
		$errorMSG = "";
		// FIRST NAME
		if (empty($_POST["fname"])) {
		    $errorMSG = "First Name is required ";
		} else {
		    $name = $_POST["fname"];
            $data['fname'] = $_POST["fname"];
		}
		
        // LAST NAME
		if (empty($_POST["lname"])) {
		    $errorMSG = "Last Name is required ";
		} else {
		    $lname = $_POST["lname"];
            $data['lname'] = $_POST["lname"];
		}        

		// EMAIL
		if (empty($_POST["email"])) {
		    $errorMSG .= "Email is required ";
		} else {
		    $email = $_POST["email"];
            $data['email'] = $_POST["email"];
		}

		// MSG SUBJECT
		if (empty($_POST["msg_subject"])) {
		    $errorMSG .= "Subject is required ";
		} else {
		    $msg_subject = $_POST["msg_subject"];
            $data['subject'] = $_POST["msg_subject"];
		}

		// MESSAGE
		if (empty($_POST["message"])) {
		    $errorMSG .= "Message is required ";
		} else {
		    $message = $_POST["message"];
            $data['message'] = $_POST["message"];
		}

		$sett_val = $this->settings_value();

		$EmailTo = ($sett_val['mail_to']) ? $sett_val['mail_to'] : get_option( 'admin_email' );
		$Subject = ($sett_val['mail_sub']) ? $sett_val['mail_sub'] : 'New Feedback Received';

		// prepare email body text
		$Body = "";
		$Body .= "First Name: ";
		$Body .= $data['fname'];
        $Body .= "\n";
        $Body .= "Last Name: ";
		$Body .= $lname;
		$Body .= "\n";
		$Body .= "Email: ";
		$Body .= $email;
		$Body .= "\n";
		$Body .= "Subject: ";
		$Body .= $msg_subject;
		$Body .= "\n";
		$Body .= "Message: ";
		$Body .= $message;
		$Body .= "\n";
        
       
        if($errorMSG == ""){
            $inserted = $this->ajff_insert_data($data);

            if($inserted){
                // send email
                $success = wp_mail($EmailTo, $Subject, $Body, "From:".$email);
                
                if ($success){
                    // echo "Working";
                    $results = "success";
                }else{
                    $results = "Something went wrong with mail :(";
                }
            }else{
                $results = "Something went wrong with insert:(";
            }
        }else{
            $results = $errorMSG;
        }

		die($results);
		
        // return $results;
	}
    
    /**
	 * Frontend Form Shortcode
	 *
	 */
	public function ajax_feedback_form_frontend($atts,$content = null) {
		$sett_val = $this->settings_value();
		$atts = shortcode_atts(array(
		    'style' =>'one',  
		), $atts); 
		ob_start(); 

		include('partials/ajax-feedback-form-public-display.php');
		?> 
		<?php 
		return ob_get_clean();
	}

	/**
	 * Frontend List Shortcode
	 *
	 */
	public function ajax_feedback_list_frontend($atts,$content = null) {
		$sett_val = $this->settings_value();
		$atts = shortcode_atts(array(
		    'style' =>'one',  
		), $atts); 
		ob_start(); 
		
		include('partials/ajax-feedback-list-display.php');
	
		return ob_get_clean();
	}

    /**
	 * Settings value
	 *
	 */
    public function settings_value(){  
		
		$form_title = $this->settings_api->get_option('t1_form_title','ajff_style_one',''); 		
		$from_bgc = $this->settings_api->get_option('t1_from_bgc','ajff_style_one',''); 
		$from_bdrc = $this->settings_api->get_option('t1_from_bdrc','ajff_style_one',''); 
		$list_title = $this->settings_api->get_option('t1_list_title','ajff_style_one',''); 
		$list_perpage = $this->settings_api->get_option('t1_list_perpage','ajff_style_one',''); 
		
		

		$mail_sub = $this->settings_api->get_option('t2_mail_sub','ajff_style_two',''); 
		$mail_to = $this->settings_api->get_option('t2_mail_to','ajff_style_two',''); 

		
		$val =  array(
			'form_title'=>$form_title,
			'from_bgc'	=>$from_bgc,
			'from_bdrc'	=>$from_bdrc,
			'list_title'=>$list_title,
			'list_perpage'=> $list_perpage,
			'mail_sub'	=>$mail_sub,
			'mail_to'	=>$mail_to
		); 
		return $val;
    } 

    public function ajff_insert_data($data) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'feedback';
        
        $wpdb->insert( 
            $table_name, 
            array( 
                'first_name' => $data['fname'], 
                'last_name' => $data['lname'], 
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'date' => current_time( 'mysql' )
            ) 
        );

        return true;
    }
}