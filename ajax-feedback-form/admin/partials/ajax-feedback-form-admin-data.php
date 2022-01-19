<?php
// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Ajax_Feedback_Form_List extends WP_List_Table
{
    function __construct() {

		parent::__construct(
			array(
				'singular'  => 'Feedback',
				'plural'    => 'Feedbacks',
				'ajax'      => false
			)
		);

	}
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'cb'		=> '<input type="checkbox" />', // to display the checkbox.	
            'ID'         => 'ID',
            'first_name' => 'First Name',
            'last_name'  => 'Last Name',
            'email'      => 'E-Mail',
            'subject'    => 'Subject',
            'message'    => 'Message',
            'date'       => 'Date',
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array('id');
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array(
            'first_name' => array('first_name', false),
            'date' => array('date', false)
        );
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback';

        $sql = "SELECT * FROM $table_name";
        
        $result = $wpdb->get_results( $sql, ARRAY_A);

        return $result;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'ID':
            case 'first_name':
            case 'last_name':
            case 'email':
            case 'subject':
            case 'message':
            case 'date':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
        }

    /**
     * Get value for checkbox column.
     *
     * @param object $item  A row's data.
     * @return string Text to be placed inside the column <td>.
     */
    protected function column_cb( $item ) {
        return sprintf(		
        '<label class="screen-reader-text" for="user_' . $item['ID'] . '">' . sprintf( __( 'Select %s' ), $item['user_login'] ) . '</label>'
        . "<input type='checkbox' name='users[]' id='user_{$item['ID']}' value='{$item['ID']}' />"					
        );
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'first_name';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
    }

}
?>