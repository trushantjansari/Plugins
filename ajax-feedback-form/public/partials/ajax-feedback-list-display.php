<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 */
?> 

 <div id="feedback-form-container">         
      
      <!-- Start Content Section -->
      <div id="ajffcontent">
          <div class="row">
          
              <h2 class="big-title"><?php echo esc_html($sett_val['list_title'] ?: "Feedback List"); ?></h2>   
              
            <?php
                      
            if ( is_user_logged_in() ) {
                $cur_user = wp_get_current_user();
                $fname = $cur_user->user_firstname ?: "";
                $lname = $cur_user->user_lastname ?: "";
                $email = $cur_user->user_email ?: "";
            }else{
                $fname = $lname = $email = "";
            } ?>
           
          
          </div>
      </div>
      <!-- End Content Section  -->
      <?php
      if(current_user_can('administrator')) {

        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback';


        $customPagHTML     = "";
        $query             = "SELECT * FROM $table_name";
        $total_query       = "SELECT COUNT(1) FROM (${query}) AS combined_table";
        $total             = $wpdb->get_var( $total_query );
        $items_per_page    = $sett_val['list_perpage'] ?: 5;
        $page              = isset( $_GET['ajffpage'] ) ? abs( (int) $_GET['ajffpage'] ) : 1;
        $offset            = ( $page * $items_per_page ) - $items_per_page;
        $result            = $wpdb->get_results( $query . " ORDER BY date DESC LIMIT ${offset}, ${items_per_page}", ARRAY_A );
        $totalPage         = ceil($total / $items_per_page);
    ?>
    
    <table id="feedback_list">
        <tr>
            <td>ID</td>
            <td width="20%">First name</td>
            <td width="20%">Last name</td>
            <td width="20%">E-Mail</td>
            <td width="20%">Subject</td>
        </tr>    
    <?php

      foreach($result as $row)
      {
        $data .= '<tr onclick="show_hide_row("hidden_row1");">';
            $data .= '<td>'.$row["ID"].'</td>';
            $data .= '<td>'.$row["first_name"].'</td>';
            $data .= '<td>'.$row["last_name"].'</td>';
            $data .= '<td>'.$row["email"].'</td>';
            $data .= '<td>'.$row["subject"].'</td>';
            $data .= '</tr>';
            $data .= '<tr id="hidden_row1" class="hidden_row" style="display:none;">';
            $data .= '<td>Feedback: </td>';
            $data .= '<td colspan=2>'.$row["message"].'</td>';
            $data .= '<td>Date: </td>';
            $data .= '<td>'.$row["date"].'</td>';
        $data .= '</tr>';
        ?>
        <tr onclick="show_hide_row('hidden_row<?php echo $row['ID']; ?>');">
            <td><?php echo $row["ID"]; ?></td>
            <td><?php echo $row["first_name"]; ?></td>
            <td><?php echo $row["last_name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["subject"]; ?></td>
        </tr>
        <tr id="hidden_row<?php echo $row['ID']; ?>" class="hidden_row" style="display:none;">
            
            <td colspan="5" style="text-align:left;">
                <strong>Feedback: </strong><?php echo $row["message"]; ?><br>
                <strong>Date: </strong><?php echo $row["date"]; ?>
            </td>
        </tr>
       <?php     
      
      }
      ?>
        </table>
        <script type="text/javascript">
            function show_hide_row(row)
            {
                jQuery("#"+row).toggle();
            }
        </script>
    </div>
    <?php if($totalPage > 1){
            $customPagHTML     =  '<div><span>Page '.$page.' of '.$totalPage.'</span><span style="float:right;">'.paginate_links( array(
            'base' => add_query_arg( 'ajffpage', '%#%' ),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => $totalPage,
            'current' => $page
            )).'</span></div>';
            }   

            echo $customPagHTML;
    }else{
        echo "<h3>You are not authorized to view content of this page</h3>";
    }