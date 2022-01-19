<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 */
?> 
<?php //echo $atts['style']; ?>

 <div id="feedback-form-container">         
      
      <!-- Start Content Section -->
      <div id="ajffcontent">
          <div class="row">
          
              <h2 class="big-title"><?php echo esc_html($sett_val['form_title'] ?: "Submit your feedback"); ?></h2>   
            <?php if ( is_user_logged_in() ) {
                $cur_user = wp_get_current_user();
                $fname = $cur_user->user_firstname ?: "";
                $lname = $cur_user->user_lastname ?: "";
                $email = $cur_user->user_email ?: "";
            }else{
                $fname = $lname = $email = "";
            } ?>
            <!-- Start Feedback Form -->
            <form role="form" id="feedbackForm" class="contact-form" data-toggle="validator" class="shake">
              <div class="form-group">
                <div class="controls">
                  <input type="text" value="<?php echo $fname; ?>" id="fname" class="form-control" placeholder="First Name" required data-error="Please enter your first name">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="form-group">
                <div class="controls">
                  <input type="text" value="<?php echo $lname; ?>" id="lname" class="form-control" placeholder="Last Name" required data-error="Please enter your last name">
                  <div class="help-block with-errors"></div>
                </div>
              </div>              
              <div class="form-group">
                <div class="controls">
                  <input type="email" value="<?php echo $email; ?>" class="email form-control" id="email" placeholder="Email" required data-error="Please enter your email">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="form-group">
                <div class="controls">
                  <input type="text" id="msg_subject" class="form-control" placeholder="Subject" required data-error="Please enter your message subject">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="form-group">
                <div class="controls">
                  <textarea id="message" rows="7" placeholder="Message" class="form-control" required data-error="Write your message"></textarea>
                  <div class="help-block with-errors"></div>
                </div>  
              </div>

              <button style="background-color:<?php  echo esc_html($sett_val['from_bgc']); ?>;" type="submit" id="submit" class="btn btn-success"></i> Send Feedback</button>
              
              <div class="clearfix"></div>   

            </form>     
            <div id="msgSubmit" class="h3 text-center hidden"></div> 
            <!-- End Feedback Form -->

          
          </div>
      </div>
      <!-- End Content Section  -->
      
    </div>