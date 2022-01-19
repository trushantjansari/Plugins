<?php
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 */
class Ajax_Feedback_Form_Uninstaller {

    public static function uninstall() {
        $db_option =  get_option('ajff_style_three');
        if($db_option['t1_form_db'] == 'on' && $db_option['t1_form_db'] != ''){
            global $wpdb;
            $table_name = $wpdb->prefix . 'feedback';
            $sql = "DROP TABLE IF EXISTS $table_name";
            $wpdb->query($sql);
        }

    }

}
