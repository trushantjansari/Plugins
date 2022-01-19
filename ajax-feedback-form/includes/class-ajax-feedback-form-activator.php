<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 */
class Ajax_Feedback_Form_Activator {

    public function activate() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback';
        //$my_products_db_version = '1.0.0';
        $charset_collate = $wpdb->get_charset_collate();
     

        if ( $wpdb->get_var("SHOW TABLES WHERE '{$table_name}'") != $table_name ) {

            $sql = "CREATE TABLE $table_name (
                    ID mediumint(9) NOT NULL AUTO_INCREMENT,
                    `user_id` int(9) NOT NULL,
                    `first_name` text NOT NULL,
                    `last_name` text NOT NULL,
                    `email` text NOT NULL,
                    `subject` text NOT NULL,
                    `message` varchar(255) NOT NULL,
                    `date` datetime NOT NULL,
                    PRIMARY KEY  (ID)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            add_option('ajff_db_version', '1.0.0');
        }
      

    }
    public function jal_install() {
        global $jal_db_version;
        $jal_db_version = '1.0';
        global $wpdb;
        global $jal_db_version;
    
        $table_name = $wpdb->prefix . 'aaliveshoutbox';
        
        $charset_collate = $wpdb->get_charset_collate();
        if ( $wpdb->get_var("SHOW TABLES WHERE '{$table_name}'") != $table_name ) {
            $table_name = $wpdb->prefix . 'aaliveshoutbox222';
        }else{
            $table_name = $wpdb->prefix . 'aaliveshoutbox333';
        }

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name tinytext NOT NULL,
            text text NOT NULL,
            url varchar(55) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
    
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    
        add_option( 'jal_db_version', $jal_db_version );
    }


}
