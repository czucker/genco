<?php

include_once('class.emember.list_table.php');

class WP_eMember_List_Protected_Media extends WP_eMember_List_Table {

    function __construct() {
        global $status, $page;

        //Set parent defaults
        parent::__construct(array(
            'singular' => 'media file', //singular name of the listed records
            'plural' => 'media files', //plural name of the listed records
            'ajax' => false //does this table support ajax?
        ));
    }

    function column_default($item, $column_name) {
        //Just print the data for that column
        return $item[$column_name];
    }

    /* TODO - colum_XX replace XX with your table's key/id column field value. The actions (edit, delete etc.) will be added to this column in the list */

    function column_id($item) {

        //Build row actions (we are only alowing "Delete" option for this list)
        $actions = array(
            'delete' => sprintf('<a href="?page=eMember_admin_functions_menu&tab=2&delete_record=1&record_id=%s" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>', $item['id']),
        );

//Use the folloiwng instead of the above if you want to add both edit and delete options for each row of the list
//        $actions = array(
//            'edit'      => sprintf('<a href="admin.php?page=edit_record&edit=%s">Edit</a>',$item['id']),
//            'delete'    => sprintf('<a href="?page=%s&Delete=%s&delete_file_id=%s" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>',$_REQUEST['page'],'1',$item['id']),
//        );
        //Return the refid column contents
        return $item['id'] . $this->row_actions($actions);
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                /* $1%s */ $this->_args['singular'], //Let's reuse singular label (media file)
                /* $2%s */ $item['id'] //The value of the checkbox should be the record's key/id
        );
    }

    function get_columns() {//Columns to display in the list
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox next to each item (used for bulk operation selection)
            'id' => 'File ID',
            'filename' => 'File Name',
            'guid' => 'File URL',
            'upload_date' => 'Upload Date'
        );
        return $columns;
    }

    function get_sortable_columns() {//Specify which columns will be sortable in the list
        $sortable_columns = array(
            'id' => array('id', true), //true means it will be display sorted on this column when it first renders the page
            'filename' => array('filename', false),
            'guid' => array('guid', false),
            'upload_date' => array('upload_date', false)
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {
            $records_to_delete = $_POST['mediafile']; //value of $this->_args['singular'] is the "key"
            if (empty($records_to_delete)) {
                echo '<div id="message" class="updated fade"><p>Error! You need to select multiple records to perform a bulk action!</p></div>';
                return;
            }
            foreach ($records_to_delete as $id) {
                global $wpdb;
                $media_db_table_name = $wpdb->prefix . "emember_uploads";
                $updatedb = "DELETE FROM $media_db_table_name WHERE id='$id'";
                $results = $wpdb->query($updatedb);
            }
            echo '<div id="message" class="updated fade"><p>Selected records deleted successfully!</p></div>';
        }
    }

    function prepare_items() {

        // Lets decide how many records per page to show
        $per_page = 30;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        // This checks for sorting input and sets the sort order parameters accordingly.
        $orderby_column = isset($_GET['orderby']) ? $_GET['orderby'] : '';
        $sort_order = isset($_GET['order']) ? $_GET['order'] : '';
        if (empty($orderby_column)) {//set the default orderby column if it is empty
            $orderby_column = "id";
            $sort_order = "DESC";
        }

        //Query the database table and prepare our data that will be used to list the items
        global $wpdb;
        $media_db_table_name = $wpdb->prefix . "emember_uploads";
        $media_files = $wpdb->get_results("SELECT * FROM $media_db_table_name ORDER BY $orderby_column $sort_order", OBJECT);

        $data = array();
        $data = json_decode(json_encode($media_files), true);

        //pagination requirement
        $current_page = $this->get_pagenum();

        //pagination requirement
        $total_items = count($data);

        //pagination requirement
        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);

        // Now we add our *sorted* data to the items property, where it can be used by the rest of the class.
        $this->items = $data;

        //pagination requirement
        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
        ));
    }

}

?>