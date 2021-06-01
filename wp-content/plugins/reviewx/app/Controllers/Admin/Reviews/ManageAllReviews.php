<?php

namespace ReviewX\Controllers\Admin\Reviews;

use ReviewX\Constants\Reviewx;
use ReviewX\Controllers\Admin\Criteria\CriteriaController;
use ReviewX\Extended\WPCore\WordpressListTable;
use ReviewX\Models\Review;
use ReviewX\Modules\Gatekeeper;
use ReviewX\Controllers\Admin\Core\ReviewxMetaBox;

/**
 * Class ManageAllReviews
 * @package ReviewX\Controllers\Admin\Reviews
 */
class ManageAllReviews extends WordpressListTable
{
    public static $SEARCH_COLUMN = 'search_id';
    public static $REVIEWS_PER_PAGE = 10;

    public static $COMMENT_STATUS = [
        'all', 'mine', 'moderated', 'approved', 'spam', 'trash'
    ];

    private static $DEFAULT_COMMENT_STATUS = 'all';

    private $user_can;

    /**
     * @return int
     * @throws \WpFluent\Exception
     */
    private function getAllReviews()
    {

        return wpFluent()->table('comments')
            ->where('comment_type', 'review')
            ->where(function ($query) {
                $query->whereNotIn('comment_approved', ['trash', 'spam']);
            })
            ->join('posts', function ($table) {
                
                $post_types     = [];
                $post_types     = \ReviewX_Helper::get_enabled_types(); 
                array_push($post_types, 'product' );

                $table->on('posts.ID', '=', 'comments.comment_post_ID');
                // $table->where('posts.post_type', '=', 'product');
                $table->whereIn('posts.post_type', $post_types);
            })->count();
    }

    /**
     * @return array|object|null
     * @throws \WpFluent\Exception
     */
    private function getAllProducts()
    {
        return wpFluent()->table('comments')
            ->where('comment_type', 'review')
            ->where(function ($query) {
                $query->whereNotIn('comment_approved', ['trash', 'spam']);
            })
            ->join('posts', function ($table) {
                
                $post_types     = [];
                $post_types     = \ReviewX_Helper::get_enabled_types(); 
                array_push($post_types, 'product' );
                
                $table->on('posts.ID', '=', 'comments.comment_post_ID');
                // $table->where('posts.post_type', '=', 'product');
                $table->whereIn('posts.post_type', $post_types);
            })->groupBy('comment_post_ID')->get();
    }

    /**
     * @return array|object|null
     * @throws \WpFluent\Exception
     */
    private function getAllReviewers()
    {
        return wpFluent()->table('comments')
            ->where('comment_type', 'review')
            ->where(function ($query) {
                $query->whereNotIn('comment_approved', ['trash', 'spam']);
            })
            ->join('posts', function ($table) {
                
                $post_types     = [];
                $post_types     = \ReviewX_Helper::get_enabled_types(); 
                array_push($post_types, 'product' );

                $table->on('posts.ID', '=', 'comments.comment_post_ID');
                // $table->where('posts.post_type', '=', 'product');
                $table->whereIn('posts.post_type', $post_types);
            })->groupBy('user_id')->get();
    }

    /**
     * @throws \WpFluent\Exception
     */
    public function call_analytics_header()
    {
        $totalReviews = $this->getAllReviews();
        $totalProducts = count($this->getAllProducts());
        $totalReviewers = count($this->getAllReviewers());

        echo \view('admin.components.manage-all-reviews.stats', compact('totalReviews', 'totalProducts', 'totalReviewers'));
    }

    /**
     * @return array
     */
    public function wp_list_table_data()
    {
        global $comment_status, $search;

        $comment_status = request_filled('comment_status');

        if( ! in_array($comment_status,self::$COMMENT_STATUS)) {
            $comment_status = self::$DEFAULT_COMMENT_STATUS;
        }

        $search     = request_filled('s');
        $orderby    = request_filled('orderby');
        $order      = request_filled('order');

        $comments_per_page = $this->get_per_page( $comment_status );

        $number = request_filled('number');

        if ( isset( $number ) && is_numeric($number) ) {
            $number = (int) $number;
        } else {
            $number = $comments_per_page + min( 8, $comments_per_page ); // Grab a few extra.
        }

        $page = $this->get_pagenum();

        $start = request_filled('start');

        if (! $start ) {
            $start = ( $page - 1 ) * $comments_per_page;
        }

        $offset = request_filled('offset');

        if ( wp_doing_ajax() && isset( $offset ) ) {
            $start += $offset;
        }

        $status_map = [
            'mine'      => '',
            'moderated' => 'hold',
            'approved'  => 'approve',
            'all'       => '',
        ];

        $post_types     = [];
        $post_types     = \ReviewX_Helper::get_enabled_types(); 
        array_push($post_types, 'product' );
        $type           = array( 'comment', 'review' );

        $args = [
            'status'    => _get($status_map[ $comment_status ],$comment_status),
            'search'    => $search,
            'offset'    => $start,
            'post_type' => $post_types,
            'type'  	=> $type,
            'number'    => $number,
            'orderby'   => $orderby,
            'order'     => $order,
        ];

        $get_review_info = $all_comments = [];

        $comments = get_comments($args);

        $wpOptions = get_option('_rx_option_review_criteria');

        $wpOptions = _get($wpOptions,[]);

        foreach ($comments as $comment) {

            $reviewx_id = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type( $comment->comment_post_ID ) );
            if( $reviewx_id ){
                $settings   = ReviewxMetaBox::get_metabox_settings( $reviewx_id );
                $wpOptions  = $settings->review_criteria;
                $wpOptions = _get($wpOptions,[]);
            }

            $product = get_post($comment->comment_post_ID) ? : null;
            $meta    = get_comment_meta($comment->comment_ID) ? : [];

            if( array_key_exists('reviewx_rating', $meta) ){
                $metaReview = _get($meta['reviewx_rating']);
            } else {
                $metaReview = null;
            }

            $ratings = [];

            if($metaReview !== null) {

                $ratingsOnCriteria = unserialize($metaReview[0]);

                foreach($ratingsOnCriteria as $key =>  $criterion) {
                    if( array_key_exists($key,$wpOptions) && _get($wpOptions[$key]) !== null) {
                        $ratings[ $wpOptions[$key] ] = $criterion;
                    }
                }
            }

            $post_id = $comment->comment_post_ID;
            if ( current_user_can( 'edit_post', $post_id ) ) {
                $post_link  = "<a href='" . esc_url( get_edit_post_link( $post_id ) ) . "'>";
                $post_link .= esc_html( get_the_title( $post_id ) ) . '</a>';
            } else {
                $post_link = esc_html( get_the_title( $post_id ) );
            }

            $submitted = sprintf(
                __( '%1$s at %2$s', 'reviewx' ),
                get_comment_date( 'j M Y', $comment ),
                get_comment_date( 'g:i a', $comment )
            );
            if ( 'approved' === wp_get_comment_status( $comment ) && ! empty( $comment->comment_post_ID ) ) {
                $submitted = '<a href="' . esc_url( get_comment_link( $comment ) ) . '">' . $submitted . '</a>';
            }

            $data = [
                'id'               => $comment->comment_ID,
                'post_id'		   => $comment->comment_post_ID,
                'parent_id'		   => $comment->comment_parent,
                'reviewer'         => $comment->comment_author,
                'status'           => $comment->comment_approved,
                'reviewed_product' => !empty($product) ? $post_link : '',
                'review_comments'  => $comment->comment_content,
                'update_at'        => $submitted,
                'ratings'          => $ratings,
            ];

            if (array_key_exists('reviewx_title', $meta)) {
                $data['review_title'] = _get($meta['reviewx_title'][0]);
            }

            if (array_key_exists('rating', $meta)) {
                $data['avg_rating'] = _get($meta['rating'][0],0);
            }

            $all_comments[] = $data;
        }

        $total_comments_count = get_comments(
            array_merge($args, ['count'  => true,'offset' => 0,'number' => 0]
            )
        );

        $get_review_info['all_reviews']         = $all_comments;
        $get_review_info['reviews_per_page']    = $comments_per_page;
        $get_review_info['total_reviews_count'] = $total_comments_count;

        return $get_review_info;
    }

    /**
     * @param object $item
     * @param string $column_name
     * @return mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
                return $item['id'];

            case 'review_title':
                $domain = 'reviewx';
                $title = isset($item['review_title']) ? $item['review_title'] : '';
                if( $item['parent_id'] != 0 ){
                    $item_info =  $this->get_review_info( $item['id'] );
                    $parent_id = 0;
                    if( is_array($item_info) ) {
                        $parent_id = $item_info[0]->comment_parent;
                    }
                    return \view('partials.utilities.store-owner-title',compact('title', 'parent_id', 'domain'));
                } else {
                    return \view('partials.utilities.title',compact('title', 'domain'));
                }

            case 'review_comments':
                return $item['review_comments'];

            case 'reviewer':
                $domain = 'reviewx';
                $author = $item['reviewer'];
                if( $item['parent_id'] != 0 ){
                    return \view('partials.utilities.store-owner',compact('author', 'domain'));
                } else {
                    return \view('partials.utilities.reviewer',compact('author', 'domain'));
                }

            case 'reviewed_product':
                return $item['reviewed_product'];

            case 'avg_rating':
                $domain = 'reviewx';
                $avg = isset($item['avg_rating']) ? $item['avg_rating'] : '';
                $post_id = $item['post_id'];
                $ratings = $item['ratings'];
                if( $item['parent_id'] != 0 ){
                    return \view('partials.utilities.store-owner-rating',compact('owner-rating', 'domain'));
                } else {
                    return \view('partials.utilities.ratings-span',compact('avg','ratings', 'post_id', 'domain'));
                }                
            case 'status':
                return $item[$column_name] == 1 ? \view('partials.utilities.approved') : \view('partials.utilities.unapproved');

            case 'update_at':
                //So I added this line to display comment
                return $item[$column_name];

            case 'actions':
                $id = $item['id'];
                $domain = 'reviewx';
                $edit = \view('partials.utilities.edit', compact('id', 'domain'));
                $view = \view('partials.utilities.view', compact('id', 'domain'));
                return $edit;
            default:
                return;

        }
    }

    /**
     * Get Columns
     *
     * @return array
     */
    public function get_columns()
    {
        $inputField = \view('partials.utilities.input_field');
        return [
            'cb'                => '<input type="checkbox" />',
            'id'                => __( 'Review ID', 'reviewx' ),
            'review_title'      => __( 'Review Title', 'reviewx' ),
            'review_comments'   => __( 'Review Comments', 'reviewx' ),
            'reviewer'          => __( 'Reviewer', 'reviewx' ),
            'reviewed_product'  => __( 'Product/Post', 'reviewx' ),
            'avg_rating'        => __( 'Rating', 'reviewx' ),
            'status'            => __( 'Status', 'reviewx' ),
            'update_at'         => __( 'Submitted At', 'reviewx' ),
            'actions'           => __( 'Actions', 'reviewx' ),
        ];
    }

    /**
     * Get Sortable Columns
     *
     * @return array|array[]
     */
    public function get_sortable_columns()
    {
        return [
            'id' => [ 'id', false ],
            'update_at' => [ 'update_at', false ],
            'reviewer' => ['reviewer',false],
            'reviewed_product' => ['reviewed_product', false],
            'status' => ['status', false],
        ];
    }

    /**
     * @param object $item
     */
    public function column_cb($item)
    {
        $id = $item['id'];
        echo \view('partials.utilities.input_field', compact('id'));
    }

    /**
     * Get Bulk Actions
     * @return array
     */
    public function get_bulk_actions()
    {
        global $comment_status;

        $actions = array();
        if ( in_array( $comment_status, array( 'all', 'approved' ) ) ) {
            $actions['unapprove'] = __( 'Unapprove', 'reviewx' );
        }
        if ( in_array( $comment_status, array( 'all', 'moderated' ) ) ) {
            $actions['approve'] = __( 'Approve', 'reviewx' );
        }
        if ( in_array( $comment_status, array( 'all', 'moderated', 'approved', 'trash' ) ) ) {
            $actions['spam'] = _x( 'Mark as Spam', 'comment', 'reviewx' );
        }

        if ( 'trash' === $comment_status ) {
            $actions['untrash'] = __( 'Restore', 'reviewx');
        } elseif ( 'spam' === $comment_status ) {
            $actions['unspam'] = _x( 'Not Spam', 'comment', 'reviewx' );
        }

        if ( in_array( $comment_status, array( 'trash', 'spam' ) ) || ! EMPTY_TRASH_DAYS ) {
            $actions['delete'] = __( 'Delete Permanently', 'reviewx' );
        } else {
            $actions['trash'] = __( 'Move to Trash', 'reviewx' );
        }

        return $actions;

    }

    /**
     * Prepare Items
     * @return void
     */
    public function prepare_items()
    {
        $get_review_info   = $this->wp_list_table_data();
        $this->items       = array_slice( $get_review_info['all_reviews'], 0, $get_review_info['reviews_per_page'] );
        $this->extra_items = array_slice( $get_review_info['all_reviews'], $get_review_info['reviews_per_page'] );

        $this->set_pagination_args( array(
            'total_items' => _get($get_review_info['total_reviews_count'], 0),
            'per_page' => _get($get_review_info['reviews_per_page'],self::$REVIEWS_PER_PAGE)
        ) );

        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, [], $sortable);
    }

    /**
     * @param string $comment_status
     * @return int
     */
    public function get_per_page( $comment_status = 'all' )
    {
        $comments_per_page = $this->get_items_per_page( 'edit_review_per_page', 20 );
        /**
         * Filters the number of comments listed per page in the comments list table.
         *
         * @since 2.6.0
         *
         * @param int    $comments_per_page The number of comments to list per page.
         * @param string $comment_status    The comment status name. Default 'All'.
         */
        return apply_filters( 'comments_per_page', $comments_per_page, $comment_status );

    }

    /**
     * Process Bulk Action
     *
     * @return void
     */
    public function process_bulk_action()
    {
        $doaction = $this->current_action();
        if ( $doaction ) {
            $comment_ids = $_REQUEST['delete_comments'];

            $approved   = 0;
            $unapproved = 0;
            $spammed    = 0;
            $unspammed  = 0;
            $trashed    = 0;
            $untrashed  = 0;
            $deleted    = 0;
            $redirect_to = remove_query_arg( array( 'trashed', 'untrashed', 'deleted', 'spammed', 'unspammed', 'approved', 'unapproved', 'ids' ), wp_get_referer() );

            wp_defer_comment_counting( true );

            foreach ( $comment_ids as $comment_id ) { // Check the permissions on each.
                if ( ! current_user_can( 'edit_comment', $comment_id ) ) {
                    continue;
                }

                switch ( $doaction ) {
                    case 'approve':
                        wp_set_comment_status( $comment_id, 'approve' );
                        $this->add_rating_into_total_rating_data($comment_id);
                        $approved++;
                        break;
                    case 'unapprove':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_set_comment_status( $comment_id, 'hold' );
                        $unapproved++;
                        break;
                    case 'spam':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_spam_comment( $comment_id );
                        $spammed++;
                        break;
                    case 'unspam':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_unspam_comment( $comment_id );
                        $unspammed++;
                        break;
                    case 'trash':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_trash_comment( $comment_id );
                        $trashed++;
                        break;
                    case 'untrash':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_untrash_comment( $comment_id );
                        $untrashed++;
                        break;
                    case 'delete':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        CriteriaController::removeCriteria($comment_id);
                        Gatekeeper::removeLog($comment_id);
                        wp_delete_comment( $comment_id );
                        $deleted++;
                        break;
                }
            }

            if ( ! in_array( $doaction, array( 'approve', 'unapprove', 'spam', 'unspam', 'trash', 'delete' ), true ) ) {
                $screen = get_current_screen()->id;

                /** This action is documented in wp-admin/edit.php */
                $redirect_to = apply_filters( "handle_bulk_actions-{$screen}", $redirect_to, $doaction, $comment_ids ); // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
            }

            wp_defer_comment_counting( false );

            if ( $approved ) {
                $redirect_to = add_query_arg( 'approved', $approved, $redirect_to );
            }
            if ( $unapproved ) {
                $redirect_to = add_query_arg( 'unapproved', $unapproved, $redirect_to );
            }
            if ( $spammed ) {
                $redirect_to = add_query_arg( 'spammed', $spammed, $redirect_to );
            }
            if ( $unspammed ) {
                $redirect_to = add_query_arg( 'unspammed', $unspammed, $redirect_to );
            }
            if ( $trashed ) {
                $redirect_to = add_query_arg( 'trashed', $trashed, $redirect_to );
            }
            if ( $untrashed ) {
                $redirect_to = add_query_arg( 'untrashed', $untrashed, $redirect_to );
            }
            if ( $deleted ) {
                $redirect_to = add_query_arg( 'deleted', $deleted, $redirect_to );
            }
            if ( $trashed || $spammed ) {
                $redirect_to = add_query_arg( 'ids', join( ',', $comment_ids ), $redirect_to );
            }

            wp_safe_redirect( $redirect_to );
            exit;
        }

    }

    /**
     * @param $comment_id
     * @param $action
     */
    public function deduct_rating_by_previous_comment_status($comment_id, $action)
    {
        $mapStatusPrevent = [
            0 => [
                'spam',
                'trash',
                'delete',
            ],
            1 => [],
            'spam' => [
                'unspam',
                'trash',
                'delete',
            ],
            'trash' => [
                'untrash',
                'spam',
                'delete'
            ],
        ];

        $comment_status = wp_get_comment_status($comment_id);
        if (! in_array($action, $mapStatusPrevent[$comment_status])) {
            $this->deduct_rating_from_total_rating_data($comment_id);
        }
    }

    /**
     * @param $comment_id
     */
    public function deduct_rating_from_total_rating_data( $comment_id )
    {

        $prod_id = $this->get_review_product_id( $comment_id );
        $ratingOption = get_option('_rx_product_' . $prod_id . '_rating') ? : [];

        //check old review data
        if( count($ratingOption) ) {

            $rating = get_comment_meta( $comment_id, 'rating', true );
            $criteria = get_comment_meta( $comment_id, 'reviewx_rating', true );

            $criData = [];
            foreach ($criteria as $key => $value) {
                $criData[$key] = _get($ratingOption[$key], 0) - $value;
            }
            update_option('_rx_product_' . $prod_id . '_rating', array_merge([
                'total_review' =>  _get($ratingOption['total_review'], 0),
                'total_rating' =>  _get($ratingOption['total_rating'], 0) - $rating
            ], $criData));
        }

    }

    /**
     * @param $comment_id
     */
    public function add_rating_into_total_rating_data( $comment_id )
    {
        $prod_id = $this->get_review_product_id( $comment_id );
        $ratingOption = get_option('_rx_product_' . $prod_id . '_rating') ? : [];

        //check old review data
        if( count($ratingOption) ) {

            $rating = get_comment_meta( $comment_id, 'rating', true );
            $criteria = get_comment_meta( $comment_id, 'reviewx_rating', true );

            $criData = [];
            foreach ($criteria as $key => $value) {
                $criData[$key] = _get($ratingOption[$key], 0) + $value;
            }
            update_option('_rx_product_' . $prod_id . '_rating', array_merge([
                'total_review' =>  _get($ratingOption['total_review'], 0),
                'total_rating' =>  _get($ratingOption['total_rating'], 0) + $rating
            ], $criData));
        }

    }

    /**
     * @param $comment_id
     * @return int
     */
    public function get_review_product_id( $comment_id )
    {
        global $wpdb;
        $rx_comment_table = $wpdb->prefix . 'comments';
        $data             = $wpdb->get_results( $wpdb->prepare( "SELECT comment_post_ID FROM $rx_comment_table WHERE comment_id = %d", $comment_id ) );
        if( $data && !empty($data[0]->comment_post_ID) ) {
            return $data[0]->comment_post_ID;
        }
        return 0;
    }

    /**
     * @return string|false
     */
    public function current_action()
    {
        return parent::current_action();
    }

    /**
     * Review Action Status
     * @return void
     */
    public function review_action_status()
    {
        if ( isset( $_REQUEST['error'] ) ) {
            $error     = (int) $_REQUEST['error'];
            $error_msg = '';
            switch ( $error ) {
                case 1:
                    $error_msg = __( 'Invalid comment ID.' , 'reviewx');
                    break;
                case 2:
                    $error_msg = __( 'Sorry, you are not allowed to edit comments on this post.', 'reviewx' );
                    break;
            }
            if ( $error_msg ) {
                echo '<div id="moderated" class="error"><p>' . $error_msg . '</p></div>';
            }
        }

        if ( isset( $_REQUEST['approved'] ) || isset( $_REQUEST['deleted'] ) || isset( $_REQUEST['trashed'] ) || isset( $_REQUEST['untrashed'] ) || isset( $_REQUEST['spammed'] ) || isset( $_REQUEST['unspammed'] ) || isset( $_REQUEST['same'] ) ) {
            $approved  = isset( $_REQUEST['approved'] ) ? (int) $_REQUEST['approved'] : 0;
            $deleted   = isset( $_REQUEST['deleted'] ) ? (int) $_REQUEST['deleted'] : 0;
            $trashed   = isset( $_REQUEST['trashed'] ) ? (int) $_REQUEST['trashed'] : 0;
            $untrashed = isset( $_REQUEST['untrashed'] ) ? (int) $_REQUEST['untrashed'] : 0;
            $spammed   = isset( $_REQUEST['spammed'] ) ? (int) $_REQUEST['spammed'] : 0;
            $unspammed = isset( $_REQUEST['unspammed'] ) ? (int) $_REQUEST['unspammed'] : 0;
            $same      = isset( $_REQUEST['same'] ) ? (int) $_REQUEST['same'] : 0;

            if ( $approved > 0 || $deleted > 0 || $trashed > 0 || $untrashed > 0 || $spammed > 0 || $unspammed > 0 || $same > 0 ) {
                if ( $approved > 0 ) {
                    /* translators: %s: Number of comments. */
                    $messages[] = sprintf( _n( '%s comment approved.', '%s comments approved.', $approved , 'reviewx'), $approved );
                }

                if ( $spammed > 0 ) {
                    $ids = isset( $_REQUEST['ids'] ) ? $_REQUEST['ids'] : 0;
                    /* translators: %s: Number of comments. */
                    $messages[] = sprintf( _n( '%s comment marked as spam.', '%s comments marked as spam.', $spammed, 'reviewx' ), $spammed ) . ' <a href="' . esc_url( wp_nonce_url( "edit-comments.php?doaction=undo&action=unspam&ids=$ids", 'bulk-comments' ) ) . '">' . __( 'Undo', 'reviewx' ) . '</a><br />';
                }

                if ( $unspammed > 0 ) {
                    /* translators: %s: Number of comments. */
                    $messages[] = sprintf( _n( '%s comment restored from the spam.', '%s comments restored from the spam.', $unspammed, 'reviewx' ), $unspammed );
                }

                if ( $trashed > 0 ) {
                    $ids = isset( $_REQUEST['ids'] ) ? $_REQUEST['ids'] : 0;
                    /* translators: %s: Number of comments. */
                    $messages[] = sprintf( _n( '%s comment moved to the Trash.', '%s comments moved to the Trash.', $trashed, 'reviewx' ), $trashed ) . ' <a href="' . esc_url( wp_nonce_url( "edit-comments.php?doaction=undo&action=untrash&ids=$ids", 'bulk-comments' ) ) . '">' . __( 'Undo', 'reviewx' ) . '</a><br />';
                }

                if ( $untrashed > 0 ) {
                    /* translators: %s: Number of comments. */
                    $messages[] = sprintf( _n( '%s comment restored from the Trash.', '%s comments restored from the Trash.', $untrashed, 'reviewx' ), $untrashed );
                }

                if ( $deleted > 0 ) {
                    /* translators: %s: Number of comments. */
                    $messages[] = sprintf( _n( '%s comment permanently deleted.', '%s comments permanently deleted.', $deleted , 'reviewx'), $deleted );
                }

                if ( $same > 0 ) {
                    $comment = get_comment( $same );
                    if ( $comment ) {
                        switch ( $comment->comment_approved ) {
                            case '1':
                                $messages[] = __( 'This comment is already approved.', 'reviewx' ) . ' <a href="' . esc_url( admin_url( "comment.php?action=editcomment&c=$same" ) ) . '">' . __( 'Edit comment', 'reviewx' ) . '</a>';
                                break;
                            case 'trash':
                                $messages[] = __( 'This comment is already in the Trash.', 'reviewx' ) . ' <a href="' . esc_url( admin_url( 'edit-comments.php?comment_status=trash' ) ) . '"> ' . __( 'View Trash', 'reviewx' ) . '</a>';
                                break;
                            case 'spam':
                                $messages[] = __( 'This comment is already marked as spam.', 'reviewx' ) . ' <a href="' . esc_url( admin_url( "comment.php?action=editcomment&c=$same" ) ) . '">' . __( 'Edit comment', 'reviewx' ) . '</a>';
                                break;
                        }
                    }
                }

                echo '<div id="moderated" class="updated notice is-dismissible"><p>' . implode( "<br/>\n", $messages ) . '</p></div>';
            }
        }

    }

    /**
     * @return object
     */
    public function get_comment_count( )
    {
        global $wpdb;

        $where = $wpdb->prepare( 'WHERE comment_type = %s', 'review' );

        $totals = (array) $wpdb->get_results(
            "
			SELECT comment_approved, COUNT( * ) AS total
			FROM {$wpdb->comments}
			{$where}
			GROUP BY comment_approved
		",
            ARRAY_A
        );

        $comment_count = array(
            'approved'            => 0,
            'moderated'           => 0,
            'spam'                => 0,
            'trash'               => 0,
            'post-trashed'        => 0,
            'total_comments'      => 0,
            'all'                 => 0,
        );

        foreach ( $totals as $row ) {
            switch ( $row['comment_approved'] ) {
                case 'trash':
                    $comment_count['trash'] = $row['total'];
                    break;
                case 'post-trashed':
                    $comment_count['post-trashed'] = $row['total'];
                    break;
                case 'spam':
                    $comment_count['spam']            = $row['total'];
                    $comment_count['total_comments'] += $row['total'];
                    break;
                case '1':
                    $comment_count['approved']        = $row['total'];
                    $comment_count['total_comments'] += $row['total'];
                    $comment_count['all']            += $row['total'];
                    break;
                case '0':
                    $comment_count['moderated'] = $row['total'];
                    $comment_count['total_comments']     += $row['total'];
                    $comment_count['all']                += $row['total'];
                    break;
                default:
                    break;
            }
        }

        return (object) $comment_count;
    }

    /**
     * @global int $post_id
     * @global string $comment_status
     * @global string $comment_type
     */
    protected function get_views()
    {
        global $post_id, $comment_status, $comment_type;

        $status_links = array();
        $num_comments = $this->get_comment_count();

        $stati = array(
            /* translators: %s: Number of comments. */
            'all'       => _nx_noop(
                'All <span class="count">(%s)</span>',
                'All <span class="count">(%s)</span>',
                'comments'
            ), // Singular not used.

            /* translators: %s: Number of comments. */
            // 'mine'      => _nx_noop(
            //     'Mine <span class="count">(%s)</span>',
            //     'Mine <span class="count">(%s)</span>',
            //     'comments',
            //     'reviewx'
            // ),

            /* translators: %s: Number of comments. */
            'moderated' => _nx_noop(
                'Pending <span class="count">(%s)</span>',
                'Pending <span class="count">(%s)</span>',
                'comments'
            ),

            /* translators: %s: Number of comments. */
            'approved'  => _nx_noop(
                'Approved <span class="count">(%s)</span>',
                'Approved <span class="count">(%s)</span>',
                'comments'
            ),

            /* translators: %s: Number of comments. */
            'spam'      => _nx_noop(
                'Spam <span class="count">(%s)</span>',
                'Spam <span class="count">(%s)</span>',
                'comments'
            ),

            /* translators: %s: Number of comments. */
            'trash'     => _nx_noop(
                'Trash <span class="count">(%s)</span>',
                'Trash <span class="count">(%s)</span>',
                'comments'
            ),
        );

        if ( ! EMPTY_TRASH_DAYS ) {
            unset( $stati['trash'] );
        }

        $link = admin_url('admin.php?page=reviewx-all');

        if ( ! empty( $comment_type ) && 'all' != $comment_type ) {
            $link = add_query_arg( 'comment_type', $comment_type, $link );
        }

        foreach ( $stati as $status => $label ) {
            $current_link_attributes = '';

            if ( $status === $comment_status ) {
                $current_link_attributes = ' class="current" aria-current="page"';
            }

            if ( 'mine' === $status ) {
                $current_user_id    = get_current_user_id();
                $num_comments->mine = get_comments(
                    array(
                        'post_id' 		=> $post_id ? $post_id : 0,
                        'user_id' 		=> $current_user_id,
                        'count'   		=> true,
                    )
                );
                $link               = add_query_arg( 'user_id', $current_user_id, $link );
            } else {
                $link = remove_query_arg( 'user_id', $link );
            }

            if ( ! isset( $num_comments->$status ) ) {
                $num_comments->$status = 10;
            }
            $link = add_query_arg( 'comment_status', $status, $link );
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
        
        return $status_links;
    }

    /**
     * No Items
     */
    public function no_items()
    {
        global $comment_status;

        if ( 'moderated' === $comment_status ) {
            _e( 'No reviews awaiting moderation.', 'reviewx' );
        } elseif ( 'trash' === $comment_status ) {
            _e( 'No reviews found in Trash.', 'reviewx' );
        } else {
            _e( 'No reviews found.', 'reviewx' );
        }
    }

    /**
     * Displays the comments table.
     *
     * Overrides the parent display() method to render extra comments.
     *
     * @since 3.1.0
     */
    public function display()
    {
        wp_nonce_field( 'fetch-list-' . get_class( $this ), '_ajax_fetch_list_nonce' );

        $this->display_tablenav( 'top' );

        $this->screen->render_screen_reader_content( 'heading_list' );

        ?>
        <table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
            <thead>
            <tr>
                <?php $this->print_column_headers(); ?>
            </tr>
            </thead>

            <tbody id="the-comment-list" data-wp-lists="list:comment">
            <?php $this->display_rows_or_placeholder(); ?>
            </tbody>

            <tbody id="the-extra-comment-list" data-wp-lists="list:comment" style="display: none;">
            <?php
            /*
            * Back up the items to restore after printing the extra items markup.
            * The extra items may be empty, which will prevent the table nav from displaying later.
            */
            $items       = $this->items;
            $this->items = $this->extra_items;
            $this->display_rows_or_placeholder();
            $this->items = $items;
            ?>
            </tbody>

            <tfoot>
            <tr>
                <?php $this->print_column_headers( false ); ?>
            </tr>
            </tfoot>

        </table>
        <?php

        $this->display_tablenav( 'bottom' );
    }

    /**
     * @param $comment
     */
    public function column_comment( $comment )
    {
        echo '<div class="comment-author">';
        $this->column_author( $comment );
        echo '</div>';

        if ( $comment->comment_parent ) {
            $parent = get_comment( $comment->comment_parent );
            if ( $parent ) {
                $parent_link = esc_url( get_comment_link( $parent ) );
                $name        = get_comment_author( $parent );
                printf(
                /* translators: %s: Comment link. */
                    __( 'In reply to %s.', 'reviewx' ),
                    '<a href="' . $parent_link . '">' . $name . '</a>'
                );
            }
        }

        comment_text( $comment );

        if ( $this->user_can ) {
            /** This filter is documented in wp-admin/includes/comment.php */
            $comment_content = apply_filters( 'comment_edit_pre', $comment->comment_content );
            ?>
            <div id="inline-<?php echo $comment->comment_ID; ?>" class="hidden">
                <textarea class="comment" rows="1" cols="1"><?php echo esc_textarea( $comment_content ); ?></textarea>
                <div class="author-email"><?php echo esc_attr( $comment->comment_author_email ); ?></div>
                <div class="author"><?php echo esc_attr( $comment->comment_author ); ?></div>
                <div class="author-url"><?php echo esc_attr( $comment->comment_author_url ); ?></div>
                <div class="comment_status"><?php echo $comment->comment_approved; ?></div>
            </div>
            <?php
        }
    }

    /**
     * @param $item
     * @return array|\WP_Comment|null
     */
    public function get_single_comment_object( $item )
    {
        $comment 	 = get_comment( $item['id'] );
        return $comment;
    }

    /**
     * @param object $item
     */
    public function single_row( $item )
    {
        global $post, $comment;
        $comment = $item;

        $the_comment_class = wp_get_comment_status( $item['id'] );
        if ( ! $the_comment_class ) {
            $the_comment_class = '';
        }

        $the_comment_class = join( ' ', get_comment_class( $the_comment_class, $item, $comment['id'] ) );

        if ( $comment['post_id'] > 0 ) {
            $post = get_post( $comment['post_id'] );
        }
        $this->user_can = current_user_can( 'edit_comment', $comment['id'] );
        $comment_id = $comment['id'];
        echo "<tr id='comment-$comment_id' class='$the_comment_class'>";
        $this->single_row_columns( $comment );
        echo "</tr>\n";

        unset( $GLOBALS['post'], $GLOBALS['comment'] );
    }

    /**
     * Generate and display row actions links.
     *
     * @since 4.3.0
     *
     * @global string $comment_status Status for the current listed comments.
     *
     * @param WP_Comment $comment     The comment object.
     * @param string     $column_name Current column name.
     * @param string     $primary     Primary column name.
     * @return string Row actions output for comments. An empty string
     *                if the current column is not the primary column,
     *                or if the current user cannot edit the comment.
     */
    protected function handle_row_actions( $comment, $column_name, $primary )
    {
        global $comment_status;

        $comment = get_comment($comment['id']);

        if ( $primary !== $column_name ) {
            return '';
        }

        if ( ! $this->user_can ) {
            return '';
        }

        $the_comment_status = wp_get_comment_status( $comment );

        $out = '';

        $del_nonce     = esc_html( '_wpnonce=' . wp_create_nonce( "delete-comment_$comment->comment_ID" ) );
        $approve_nonce = esc_html( '_wpnonce=' . wp_create_nonce( "approve-comment_$comment->comment_ID" ) );

        $url = "comment.php?c=$comment->comment_ID";

        $approve_url   = esc_url( $url . "&action=approvecomment&$approve_nonce" );
        $unapprove_url = esc_url( $url . "&action=unapprovecomment&$approve_nonce" );
        $spam_url      = esc_url( $url . "&action=spamcomment&$del_nonce" );
        $unspam_url    = esc_url( $url . "&action=unspamcomment&$del_nonce" );
        $trash_url     = esc_url( $url . "&action=trashcomment&$del_nonce" );
        $untrash_url   = esc_url( $url . "&action=untrashcomment&$del_nonce" );
        $delete_url    = esc_url( $url . "&action=deletecomment&$del_nonce" );

        // Preorder it: Approve | Reply | Quick Edit | Edit | Spam | Trash.
        $actions = array(
            'approve'   => '',
            'unapprove' => '',
            'reply'     => '',
            'quickedit' => '',
            'edit'      => '',
            'spam'      => '',
            'unspam'    => '',
            'trash'     => '',
            'untrash'   => '',
            'delete'    => '',
        );

        // Not looking at all comments.
        if ( $comment_status && 'all' != $comment_status ) {
            if ( 'approved' === $the_comment_status ) {
                $actions['unapprove'] = sprintf(
                    '<a href="%s" data-wp-lists="%s" class="vim-u vim-destructive aria-button-if-js" aria-label="%s">%s</a>',
                    $unapprove_url,
                    "delete:the-comment-list:comment-{$comment->comment_ID}:e7e7d3:action=dim-comment&amp;new=unapproved",
                    esc_attr__( 'Unapprove this comment', 'reviewx' ),
                    __( 'Unapprove', 'reviewx' )
                );
            } elseif ( 'unapproved' === $the_comment_status ) {
                $actions['approve'] = sprintf(
                    '<a href="%s" data-wp-lists="%s" class="vim-a vim-destructive aria-button-if-js" aria-label="%s">%s</a>',
                    $approve_url,
                    "delete:the-comment-list:comment-{$comment->comment_ID}:e7e7d3:action=dim-comment&amp;new=approved",
                    esc_attr__( 'Approve this comment', 'reviewx' ),
                    __( 'Approve', 'reviewx' )
                );
            }
        } else {
            $actions['approve'] = sprintf(
                '<a href="%s" data-wp-lists="%s" class="vim-a aria-button-if-js" aria-label="%s">%s</a>',
                $approve_url,
                "dim:the-comment-list:comment-{$comment->comment_ID}:unapproved:e7e7d3:e7e7d3:new=approved",
                esc_attr__( 'Approve this comment','reviewx' ),
                __( 'Approve', 'reviewx' )
            );

            $actions['unapprove'] = sprintf(
                '<a href="%s" data-wp-lists="%s" class="vim-u aria-button-if-js" aria-label="%s">%s</a>',
                $unapprove_url,
                "dim:the-comment-list:comment-{$comment->comment_ID}:unapproved:e7e7d3:e7e7d3:new=unapproved",
                esc_attr__( 'Unapprove this comment', 'reviewx' ),
                __( 'Unapprove', 'reviewx' )
            );
        }

        if ( 'spam' !== $the_comment_status ) {
            $actions['spam'] = sprintf(
                '<a href="%s" data-wp-lists="%s" class="vim-s vim-destructive aria-button-if-js" aria-label="%s">%s</a>',
                $spam_url,
                "delete:the-comment-list:comment-{$comment->comment_ID}::spam=1",
                esc_attr__( 'Mark this comment as spam', 'reviewx' ),
                /* translators: "Mark as spam" link. */
                _x( 'Spam', 'verb', 'reviewx' )
            );
        } elseif ( 'spam' === $the_comment_status ) {
            $actions['unspam'] = sprintf(
                '<a href="%s" data-wp-lists="%s" class="vim-z vim-destructive aria-button-if-js" aria-label="%s">%s</a>',
                $unspam_url,
                "delete:the-comment-list:comment-{$comment->comment_ID}:66cc66:unspam=1",
                esc_attr__( 'Restore this comment from the spam', 'reviewx' ),
                _x( 'Not Spam', 'comment', 'reviewx' )
            );
        }

        if ( 'trash' === $the_comment_status ) {
            $actions['untrash'] = sprintf(
                '<a href="%s" data-wp-lists="%s" class="vim-z vim-destructive aria-button-if-js" aria-label="%s">%s</a>',
                $untrash_url,
                "delete:the-comment-list:comment-{$comment->comment_ID}:66cc66:untrash=1",
                esc_attr__( 'Restore this comment from the Trash', 'reviewx' ),
                __( 'Restore' , 'reviewx')
            );
        }

        if ( 'spam' === $the_comment_status || 'trash' === $the_comment_status || ! EMPTY_TRASH_DAYS ) {
            $actions['delete'] = sprintf(
                '<a href="%s" data-wp-lists="%s" class="delete vim-d vim-destructive aria-button-if-js" aria-label="%s">%s</a>',
                $delete_url,
                "delete:the-comment-list:comment-{$comment->comment_ID}::delete=1",
                esc_attr__( 'Delete this comment permanently', 'reviewx' ),
                __( 'Delete Permanently', 'reviewx' )
            );
        } else {
            $actions['trash'] = sprintf(
                '<a href="%s" data-wp-lists="%s" class="delete vim-d vim-destructive aria-button-if-js" aria-label="%s">%s</a>',
                $trash_url,
                "delete:the-comment-list:comment-{$comment->comment_ID}::trash=1",
                esc_attr__( 'Move this comment to the Trash', 'reviewx' ),
                _x( 'Trash', 'verb', 'reviewx' )
            );
        }

        $edit_url 		= admin_url('admin.php?page=reviewx-all');

        if ( 'spam' !== $the_comment_status && 'trash' !== $the_comment_status ) {
            $actions['edit'] = sprintf(
                '<a href="%s" aria-label="%s">%s</a>',
                "{$edit_url}&rxaction=editreview&amp;c={$comment->comment_ID}",
                esc_attr__( 'Edit this comment', 'reviewx' ),
                __( 'Edit', 'reviewx' )
            );

            $format = '<button type="button" data-comment-id="%d" data-post-id="%d" data-action="%s" class="%s button-link" aria-expanded="false" aria-label="%s">%s</button>';

        }

        /** This filter is documented in wp-admin/includes/dashboard.php */
        $actions = apply_filters( 'comment_row_actions', array_filter( $actions ), $comment );

        $i    = 0;
        $out .= '<div class="row-actions">';
        foreach ( $actions as $action => $link ) {
            ++$i;
            ( ( ( 'approve' === $action || 'unapprove' === $action ) && 2 === $i ) || 1 === $i ) ? $sep = '' : $sep = ' | ';

            // Reply and quickedit need a hide-if-no-js span when not added with ajax.
            if ( ( 'reply' === $action || 'quickedit' === $action ) && ! wp_doing_ajax() ) {
                $action .= ' hide-if-no-js';
            } elseif ( ( 'untrash' === $action && 'trash' === $the_comment_status ) || ( 'unspam' === $action && 'spam' === $the_comment_status ) ) {
                if ( '1' == get_comment_meta( $comment->comment_ID, '_wp_trash_meta_status', true ) ) {
                    $action .= ' approve';
                } else {
                    $action .= ' unapprove';
                }
            }

            $out .= "<span class='$action'>$sep$link</span>";
        }
        $out .= '</div>';

        $out .= '<button type="button" class="toggle-row"><span class="screen-reader-text">' . __( 'Show more details', 'reviewx' ) . '</span></button>';

        return $out;
    }

    /**
     * @param $review_id
     * @return array|object|null
     * @throws \WpFluent\Exception
     */
    public function get_review_info( $review_id )
    {
        return wpFluent()->table('comments')
            ->where('comment_type', 'review')
            ->where('comment_ID', '=', $review_id)->get();

    }
}