<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 */
  
 ?>

<div class="wrap"> 
    <h2><?php esc_html_e('Ajax Feedback Form Info:', 'ajax-feedback-form'); ?></h2>
    <div id="poststuff"> 
        <div id="post-body" class="metabox-holder  columns-2"> 
             
        	<div id="post-body-content">  
                <div class="inside"> 
                    <h3>Feedback From shortcode: </h3> 
                    <p>There are two ways to use form <b><i>shortcode</i></b> to display at the frontend.</p>
                    <p>In posts or pages editor:</p>
                    <code> [ajax_feedback_form]</code> 
                    <p>In php file:</p>
                    <code> &lt;?php echo do_shortcode('[ajax_feedback_form]') ?&gt;
                    </code> 
                </div>  
                <hr>
                <div class="inside"> 
                    <h3>Feedback List shortcode: </h3> 
                    <p>There are two ways to use feedback list <b><i>shortcode</i></b> to display at the frontend.</p>
                    <p>In posts or pages editor:</p>
                    <code> [ajax_feedback_list]</code> 
                    <p>In php file:</p>
                    <code> &lt;?php echo do_shortcode('[ajax_feedback_list]') ?&gt;
                    </code> 
                </div>  
	        </div>  

            <div id="postbox-container-1" class="postbox-container">
                <div class="meta-box-sortables">
                    <div class="postbox">
                        <h3>Info: </h3> 
                        <hr>
                        <div class="inside">
                            <p>Plugin : <b>Ajax Feedback Form</b> - v<?php echo $this->version; ?> </p>
                            <p>Author : Trushant</p>
                            <p>Email : <a href="mailto:jtrushant1991@gmail.com" target="_blank">jtrushant1991@gmail.com</a></p> 
                            
                        </div>
                    </div> 
                </div> 
            </div> 
        </div>    
    </div>  
</div>  