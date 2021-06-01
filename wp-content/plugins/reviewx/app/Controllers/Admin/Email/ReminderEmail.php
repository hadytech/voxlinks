<?php

namespace ReviewX\Controllers\Admin\Email;

use DateTime;
use DateTimeZone;
use ReviewX\Extended\WPCore\WordpressListTable;

class ReminderEmail extends WordpressListTable
{
    public static $SEARCH_COLUMN = 'search_id';
    const tableName = "reviewx_reminder_email";

    public static $REMINDER_STATUS = [
        'scheduled', 'delivered', 'failed', 'cancelled'
    ];

    private static $DEFAULT_REMINDER_STATUS = 'all';

    /**
     * Set email log
     *
     * @param [type] $orderId
     * @param [type] $customerEmail
     * @param [type] $products
     * @param [type] $processedEmail
     * @param [type] $scheduledAt
     * @param [type] $status
     * @param integer $totalDelivery
     * @param integer $isSubscribe
     */
    public function setEmailLog($orderId, $customerEmail, $products, $processedEmail, $scheduledAt, $status, $totalDelivery = 1, $isSubscribe = 1)
    {
        $order = wc_get_order($orderId);
        $orderStatus = wc_get_order_status_name( $order->get_status() );
        $orderDate = $order->get_date_created();
        $maxDelivery = get_option('_rx_option_how_many_email', 5);


        return wpFluent()->table(self::tableName)->insert([
            'order_id' => $orderId,
            'customer_email' => $customerEmail,
            'order_items' => count($products),
            'order_status' => $orderStatus,
            'order_date' => $orderDate,
            'max_delivery' => $maxDelivery,
            'total_delivery' => $totalDelivery,
            'scheduled_at' => $scheduledAt,
            'status' => $status,
            'processed_email' => $processedEmail,
            'is_subscribe' => $isSubscribe,
        ]);
    }

    /**
     * Get Email log
     *
     * @param [type] $orderId
     * @return mixed|null
     */
    public function getEmailLog($orderId)
    {
        $log = \wpFluent()->table(self::tableName)->find($orderId, 'order_id');
        
        if (! empty($log) ) {
            return $log;
        }

        return null;
    }

    /**
     * Check email is processable or not
     *
     * @param [type] $reminderEmail
     * @return boolean
     */
    public function isProcessAble($reminderEmail)
    {
        $processable = true;

        if (\ReviewX_Helper::is_pro()) {
            if (! ($reminderEmail->is_subscribe)) {
                $processable &= false;
            }

            if ($reminderEmail->max_delivery <= $reminderEmail->total_delivery) {
                $processable &= false;
            }
        }

        return $processable;
    }

    /**
     * Update email log
     *
     * @param [type] $logId
     * @param [type] $data
     * @return void
     */
    public function updateLog($logId, $data) 
    {
        wpFluent()->table(self::tableName)->where('id', $logId)
                  ->update($data);
    }

    /**
     * Get Columns
     *
     * @return array
     */
    public function get_columns()
    {
        $columns = array(
            'cb'                => '<input type="checkbox" />',
            'order_id'        => __('Order ID', 'reviewx'),
            'customer_email'    => __('Customer Email', 'reviewx'),
            'order_status' => __('Order Status', 'reviewx'),
            'max_delivery' => __('Max Delivery', 'reviewx'),
            'total_delivery' => __('Total Delivery', 'reviewx'),
            'status' => __('Status', 'reviewx'),
            'is_subscribe' => __('Is Subscribe', 'reviewx'),
            'scheduled_at' => __('Email Scheduled At', 'reviewx'),
            'action' => __('Action', 'reviewx'),
        );

        return $columns;
    }

    /**
     * Get Bulk Actions
     * @return array
     */
    public function get_bulk_actions()
    {
        $actions = array();

        $actions['send_now'] = __( 'Send Now', 'reviewx' );
        if (array_key_exists('reminder_status', $_GET)) {
            $reminderStatus = sanitize_text_field($_GET['reminder_status']);
            if ($reminderStatus == 'scheduled') {
                $actions['cancelled'] = __( 'Cancelled', 'reviewx' );
            }
        }

        return $actions;

    }

    /**
     * @return string|false
     */
    public function current_action()
    {
        return parent::current_action();
    }

    /**
     * @param object $item
     */
    public function column_cb($item)
    {
        $id = $item['order_id'];
        $name = "LOG_ORDER_IDS[]";
        echo \view('partials.utilities.input_field', compact('id', 'name'));
    }

    /**
     * Get table data
     *
     * @return void
     */
    public function table_data()
    {
        global $reminder_status; 
        $reminder_status = request_filled('reminder_status');
        if( ! in_array($reminder_status,self::$REMINDER_STATUS)) {
            $reminder_status = self::$DEFAULT_REMINDER_STATUS;
        }        

        if( $reminder_status == 'all' ){
            $logs       = wpFluent()->table(self::tableName)->get();
        } else {
            $logs       = wpFluent()->table(self::tableName)->where('status', '=', $reminder_status)->get();
        }

        $user_search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
        if( $user_search_key ) {
			$logs = $this->filter_table_data( $logs, $user_search_key );
		}
        
        $data       = [];
        
        foreach($logs as $log) {
            $data[] = (array) $log;
        }

        return $data;
    }

    /**
     * Filter table data
     *
     * @param [type] $table_data
     * @param [type] $search_key
     * @return void
     */
    public function filter_table_data( $table_data, $search_key ) {
		$filtered_table_data = array_values( array_filter( $table_data, function( $row ) use( $search_key ) {
			foreach( $row as $row_val ) {
				if( stripos( $row_val, $search_key ) !== false ) {
					return true;
				}				
			}			
		} ) );
		
		return $filtered_table_data;
		
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
            case 'order_id':
                return $item['order_id'];
            case 'customer_email':
                return $item['customer_email'];
            case 'order_status':
                return $item['order_status'];
            case 'max_delivery':
                return $item['max_delivery'];
            case 'total_delivery':
                return $item['total_delivery'];
            case 'status':
                return $item['status'];
            case 'is_subscribe':
                return $item['is_subscribe'] ? 'Subscribed' : 'Unsubscribed';
            case 'scheduled_at':
                $dt = new DateTime($item['scheduled_at']);
                return $dt->format('d-M-Y h:iA');
             case 'action':
                 return \view('partials.utilities.schedule_button', compact('item'));
            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Prepare items
     *
     * @return void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        //usort( $data, array( &$this, 'sort_data' ) );

        $perPage = $this->get_per_page();
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
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array();
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'title';
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

    /**
     * @global int $post_id
     * @global string $comment_status
     * @global string $comment_type
     */
    protected function get_views()
    {
        global $post_id, $reminder_status;

        $status_links = array();
        $num_comments = $this->get_reminder_count();
        $stati = array(
            /* translators: %s: Number of comments. */
            'all'       => _nx_noop(
                'All <span class="count">(%s)</span>',
                'All <span class="count">(%s)</span>',
                'comments',
                'reviewx'
            ), // Singular not used.

            /* translators: %s: Number of comments. */
            'scheduled' => _nx_noop(
                'Scheduled <span class="count">(%s)</span>',
                'Scheduled <span class="count">(%s)</span>',
                'comments',
                'reviewx'
            ),

            /* translators: %s: Number of comments. */
            // 'sent'  => _nx_noop(
            //     'Sent <span class="count">(%s)</span>',
            //     'Sent <span class="count">(%s)</span>',
            //     'comments',
            //     'reviewx'
            // ),

            /* translators: %s: Number of comments. */
            'failed'  => _nx_noop(
                'Failed <span class="count">(%s)</span>',
                'Failed <span class="count">(%s)</span>',
                'comments',
                'reviewx'
            ),            

            /* translators: %s: Number of comments. */
            'cancelled'      => _nx_noop(
                'Cancelled <span class="count">(%s)</span>',
                'Cancelled <span class="count">(%s)</span>',
                'comments',
                'reviewx'
            ),
        );

        $link = admin_url('admin.php?page=reviewx-review-email');

        if ( ! empty( $reminder_status ) && 'all' != $reminder_status ) {
            $link = add_query_arg( 'reminder_status', $reminder_status, $link );
        }

        foreach ( $stati as $status => $label ) {
            $current_link_attributes = '';

            if ( $status === $reminder_status ) {
                $current_link_attributes = ' class="current" aria-current="page"';
            }

            // if ( 'mine' === $status ) {
            //     $current_user_id    = get_current_user_id();
            //     $num_comments->mine = get_comments(
            //         array(
            //             'post_id' 		=> $post_id ? $post_id : 0,
            //             'user_id' 		=> $current_user_id,
            //             'count'   		=> true,
            //         )
            //     );
            //     $link               = add_query_arg( 'user_id', $current_user_id, $link );
            // } else {
            //     $link = remove_query_arg( 'user_id', $link );
            // }

            // if ( ! isset( $num_comments->$status ) ) {
            //     $num_comments->$status = 10;
            // }
            $link = add_query_arg( 'reminder_status', $status, $link );
            if ( $post_id ) {
                $link = add_query_arg( 'p', absint( $post_id ), $link );
            }

            /*
            // I toyed with this, but decided against it. Leaving it in here in case anyone thinks it is a good idea. ~ Mark
            if ( !empty( $_REQUEST['s'] ) )
                $link = add_query_arg( 's', esc_attr( wp_unslash( $_REQUEST['s'] ) ), $link );
            */
            $status_links[ $status ] = "<a href='$link'$current_link_attributes>" . sprintf(
                    translate_nooped_plural( $label, $num_comments->$status ),
                    sprintf(
                        '<span class="%s-count">%s</span>',
                        ( 'moderated' === $status ) ? 'pending' : $status,
                        number_format_i18n( $num_comments->$status )
                    )
                ) . '</a>';
        }

        /**
         * Filters the comment status links.
         *
         * @since 2.5.0
         * @since 5.1.0 The 'Mine' link was added.
         *
         * @param string[] $status_links An associative array of fully-formed comment status links. Includes 'All', 'Mine',
         *                              'Pending', 'Approved', 'Spam', and 'Trash'.
         */
        return apply_filters( 'comment_status_links', $status_links );
    }
    
    /**
     * @return object
     */
    public function get_reminder_count()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'reviewx_reminder_email';
        $totals = (array) $wpdb->get_results("SELECT status, COUNT( * ) AS total FROM {$table} GROUP BY status", ARRAY_A );

        $reminder_count = array(
            'all'               => 0,
            'scheduled'           => 0,
            'delivered'           => 0,
            'failed'              => 0,
            'cancelled'           => 0,
        );

        foreach ( $totals as $row ) {
            switch ( $row['status'] ) {
                case 'all':
                    $reminder_count['all']        = $row['total'];
                    $reminder_count['all']         += $row['total'];
                    break;                  
                case 'scheduled':
                    $reminder_count['scheduled']        = $row['total'];
                    $reminder_count['all']              += $row['total'];
                    break;
                 case 'delivered':
                     $reminder_count['delivered']        = $row['total'];
                     $reminder_count['all']              += $row['total'];
                     break;
                case 'failed':
                    $reminder_count['failed']           = $row['total'];
                    $reminder_count['all']              += $row['total'];
                    break;
                case 'cancelled':
                    $reminder_count['cancelled']        = $row['total'];
                    $reminder_count['all']              += $row['total'];
                    break;
                default:
                    break;
            }
        }

        return (object) $reminder_count;
    } 
    
    /**
     * Get per page
     */
    public function get_per_page( )
    {
        return $this->get_items_per_page( 'edit_review_email_per_page', 20 );
        
    }    
}