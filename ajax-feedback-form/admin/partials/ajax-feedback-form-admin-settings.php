<?php

/**
 * Provide a admin area view for the plugin
 *
 */
  
 ?>

<div class="wrap"> 
    <h2><?php esc_html_e('Ajax Feedback Form Settings', 'ajax-feedback-form'); ?></h2>
    <div id="poststuff"> 
        <div id="post-body" class="metabox-holder">  
        	<div id="post-body-content"> 
	            <div class="inside">
	                <?php $this->settings_api->show_navigation();?>
	                <?php $this->settings_api->show_forms();?> 
	            </div>   
	        </div>  
        </div>    
    </div>   
</div>  