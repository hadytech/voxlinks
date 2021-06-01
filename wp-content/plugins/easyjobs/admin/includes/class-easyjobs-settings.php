<?php
/**
 * This class is responsible for all settings things happening in EasyJobs Plugin
 *
 * @link       https://easy.jobs
 * @since      1.0.0
 *
 * @package    EasyJobs
 * @subpackage EasyJobs/admin
 */
class EasyJobs_Settings {
    /**
     * @var string
     */
    private static $prefix = 'easyjobs_meta_';

    public static function init() {
        add_action('easyjobs_settings_header', array(__CLASS__, 'header_template'), 10);
        add_action('wp_ajax_easyjobs_general_settings', array(__CLASS__, 'general_settings_ac'), 10);
        add_action('wp_ajax_easyjobs_save_basic_info', array(__CLASS__, 'save_basic_info'), 10);
        add_action('wp_ajax_easyjobs_get_api_key', array(__CLASS__, 'get_api_key'), 10);
        add_action('wp_ajax_easyjobs_update_api_key', array(__CLASS__, 'update_api_key'), 10);
        add_action('wp_ajax_easyjobs_disconnect_api_key', array(__CLASS__, 'disconnect_api_key'), 10);
        add_action('wp_ajax_easyjobs_get_customizer_link', array(__CLASS__, 'get_customizer_link'), 10);
        add_action('wp_ajax_easyjobs_verify_company', array(__CLASS__, 'verify_company'), 10);
        add_action('wp_ajax_easyjobs_get_shortcodes', array(__CLASS__, 'get_shortcodes'), 10);
        add_action('wp_ajax_easyjobs_upload_company_image', array(__CLASS__, 'upload_company_image'), 10);
        add_action('wp_ajax_easyjobs_update_brand_color', array(__CLASS__, 'update_brand_color'), 10);
        add_action('wp_ajax_easyjobs_update_show_life', array(__CLASS__, 'update_show_life'), 10);
        add_action('wp_ajax_easyjobs_update_ai_setup', array(__CLASS__, 'update_ai_setup'), 10);
        add_action('wp_ajax_easyjobs_create_pipeline', array(__CLASS__, 'create_pipeline'), 10);
        add_action('wp_ajax_easyjobs_update_pipeline', array(__CLASS__, 'update_pipeline'), 10);
        add_action('wp_ajax_easyjobs_delete_pipeline', array(__CLASS__, 'delete_pipeline'), 10);
        add_action('wp_ajax_easyjobs_save_category', array(__CLASS__, 'save_category'), 10);
        add_action('wp_ajax_easyjobs_save_apply_settings', array(__CLASS__, 'save_apply_settings'), 10);
    }

    /**
     * This function is responsible for settings page header
     *
     * @hooked easyjobs_settings_header
     * @return void
     */
    public static function header_template() {
        ?>
        <?php include( EASYJOBS_ADMIN_DIR_PATH .'/partials/easyjobs-admin-header.php');?>
        <?php
    }

    /**
     * Get all settings fields
     *
     * @param  array $settings
     * @return array
     */
    private static function get_settings_fields($settings) {
        $new_fields = [];

        foreach ($settings as $setting) {
            $sections = isset($setting['sections']) ? $setting['sections'] : [];
            if (!empty($sections)) {
                foreach ($sections as $section) {
                    $fields = isset($section['fields']) ? $section['fields'] : [];
                    if (!empty($fields)) {
                        foreach ($fields as $id => $field) {
                            if (isset($field['type']) && $field['type'] === 'title') {
                                continue;
                            }
                            $new_fields[ $id ] = $field;
                        }
                    }
                }
            }
        }

        return apply_filters('easyjobs_settings_fields', $new_fields);
    }

    /**
     * Get the whole settings array
     *
     * @return void
     */
    public static function settings_args() {
        if (!function_exists('easyjobs_settings_args')) {
            require EASYJOBS_ADMIN_DIR_PATH . 'includes/easyjobs-settings-page-helper.php';
        }
        do_action('easyjobs_before_settings_load');
        return easyjobs_settings_args();
    }

    /**
     * Render the settings page
     *
     * @return void
     */
    public static function settings_page() {
        $settings_args = self::settings_args();
        $value = EasyJobs_DB::get_settings();
        include_once EASYJOBS_ADMIN_DIR_PATH . 'partials/easyjobs-settings-display.php';
    }

    /**
     * This function is responsible for render settings field
     *
     * @param  string $key
     * @param  array  $field
     * @return void
     */
    public static function render_field($key = '', $field = []) {
        $post_id = '';
        $name = $key;
        $id = self::get_row_id($key);
        $file_name = isset($field['type']) ? $field['type'] : 'text';

        if ('template' === $file_name) {
            $default = isset($field['defaults']) ? $field['defaults'] : [];
        } else {
            $default = isset($field['default']) ? $field['default'] : '';
        }

        $saved_value = EasyJobs_DB::get_settings();
        if (isset($saved_value[ $name ])) {
            $value = $saved_value[ $name ];
        } else {
            $value = $default;
        }

        $class = 'easyjobs-settings-field';
        $row_class = self::get_row_class($file_name);

        $attrs = '';

        if (isset($field['toggle']) && in_array($file_name, array('checkbox', 'select', 'toggle', 'theme'))) {
            $attrs .= ' data-toggle="' . esc_attr(json_encode($field['toggle'])) . '"';
        }

        if (isset($field['hide']) && $file_name == 'select') {
            $attrs .= ' data-hide="' . esc_attr(json_encode($field['hide'])) . '"';
        }

        $field_id = $name;

        include EASYJOBS_ADMIN_DIR_PATH . 'partials/easyjobs-field-display.php';
    }

    /**
     * Get the row id ready
     *
     * @param  string $key
     * @return string
     */
    public static function get_row_id($key) {
        return str_replace('_', '-', self::$prefix) . $key;
    }

    /**
     * Get the row id ready
     *
     * @param  string $key
     * @return string
     */
    public static function get_row_class($file) {
        $prefix = str_replace('_', '-', self::$prefix);

        switch ($file) {
            case 'group':
                $row_class = $prefix . 'group-row';
                break;
            case 'colorpicker':
                $row_class = $prefix . 'colorpicker-row';
                break;
            case 'message':
                $row_class = $prefix . 'info-message-wrapper';
                break;
            case 'theme':
                $row_class = $prefix . 'theme-field-wrapper';
                break;
            default:
                $row_class = $prefix . $file;
                break;
        }

        return $row_class;
    }

    /**
     * This function is responsible for
     * save all settings data, including checking the disable field to prevent
     * users manipulation.
     *
     * @param  array $values
     * @return void
     */
    public static function save_settings($posted_fields = []) {
        $settings_args = self::settings_args();
        $fields = self::get_settings_fields($settings_args);
        $data = [];

        $fields_keys = array_fill_keys(array_keys($fields), 0);
        foreach ($posted_fields as $posted_field) {
            $posted_field['name'] = str_replace('[]', '', $posted_field['name']);
            if (array_key_exists($posted_field['name'], $fields)) {
                unset($fields_keys[ $posted_field['name'] ]);
                if (empty($posted_field['value'])) {
                    $posted_value = isset($fields[ $posted_field['name'] ]['default']) ? $fields[ $posted_field['name'] ]['default'] : '';
                }
                if (isset($fields[ $posted_field['name'] ]['disable']) && $fields[ $posted_field['name'] ]['disable'] === true) {
                    $posted_value = isset($fields[ $posted_field['name'] ]['default']) ? $fields[ $posted_field['name'] ]['default'] : '';
                }
                $posted_value = EasyJobs_Helper::sanitize_field($fields[ $posted_field['name'] ], $posted_field['value']);
                if (isset($data[ $posted_field['name'] ])) {
                    if (is_array($data[ $posted_field['name'] ])) {
                        $data[ $posted_field['name'] ][] = $posted_value;
                    } else {
                        $data[ $posted_field['name'] ] = array($posted_value, $data[ $posted_field['name'] ]);
                    }
                } else {
                    $data[ $posted_field['name'] ] = $posted_value;
                }
            }
        }

        $data = array_merge($fields_keys, $data);

        EasyJobs_DB::update_settings($data);
    }

    public static function general_settings_ac() {
        /**
         * Verify the Nonce
         */
        if ((!isset($_POST['nonce']) && !isset($_POST['key'])) || !wp_verify_nonce($_POST['nonce'], 'easyjobs_' . $_POST['key'] . '_nonce')) {
            return;
        }

        if (isset($_POST['form_data'])) {
            self::save_settings($_POST['form_data']);
            echo 'success';
        } else {
            echo 'error';
        }

        die;
    }

    public static function package_tab_content() {
        $data = Easyjobs_Api::get('packages');
        $packages = array();
        if ($data->status == 'success') {
            $packages = $data->data;
        }
        $subscription_keys = Easyjobs_Helper::subscription_constants();
        include EASYJOBS_ADMIN_DIR_PATH . 'partials/easyjobs-packages.php';
    }

    public static function shortcodes_tab_content() {
        $data = Easyjobs_Api::get('published_jobs');

        $jobs = array();
        if ($data->status == 'success') {
            $jobs = $data->data;
        }
        include EASYJOBS_ADMIN_DIR_PATH . 'partials/easyjobs-shortcodes-display.php';
    }
    
    public static function design_tab_content()
    {
        // http://wp-dev.local/wp-admin/customize.php?autofocus[panel]=betterdocs_customize_options&return=http://wp-dev.local/wp-admin/edit.php?post_type=docs&url=http://wp-dev.local/docs
        $query['autofocus[panel]'] = 'easyjobs_customize_options';
        $query['return'] = admin_url( 'admin.php?page=easyjobs-settings' );
    
        $job_landing_page = Easyjobs_Helper::get_landing_page();
        if(!empty($job_landing_page)){
            $query['url'] = get_permalink($job_landing_page->ID);
        }
        
        $customizer_link = add_query_arg( $query, admin_url( 'customize.php' ) );
        
        $html = '<div class="ej-customizer-design-box">';
        $html .= '<h3>Design your content live with customizer</h3>';
        $html .= '<a href="'.$customizer_link.'" class="ej-customizer-btn">Go To Customizer</a>';
        $html.="</div>";
        
        echo $html;
    }

    public static function save_basic_info()
    {
        if(!isset($_POST['form_data'])){
            echo Easyjobs_Helper::get_error_response('Form data not found');
            wp_die();
        }
        $response = Easyjobs_Api::post('settings_basic_info', null, json_decode(stripslashes($_POST['form_data'])));

        echo Easyjobs_Helper::get_generic_response($response);

        wp_die();
    }

    public function get_api_key()
    {
        $key = EasyJobs_DB::get_settings('easyjobs_api_key');
        if($key){
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'api_key' => $key
                ]
            ]);
        }else{
            echo Easyjobs_Helper::get_error_response('Api key not found');
        }
        wp_die();
    }

    public static function update_api_key()
    {
        if(empty($_POST['api_key'])){
            echo Easyjobs_Helper::get_error_response('Api key not found');
            wp_die();
        }

        if(Easyjobs_Api::authenticate($_POST['api_key'])){
            try{
                self::save_settings([[
                    'name' => 'easyjobs_api_key',
                    'value' => $_POST['api_key']
                ]]);
                echo json_encode([
                    'status' => 'success',
                    'data' => [
                        'api_key' => $_POST['api_key']
                    ]
                ]);
            }catch (Exception $e){
                echo Easyjobs_Helper::get_error_response('Failed to save api key, please tyr again or contact support');
            }
        }else{
            echo Easyjobs_Helper::get_error_response('Api key is not valid');
        }
        wp_die();
    }

    public function get_customizer_link()
    {
        $query['autofocus[panel]'] = 'easyjobs_customize_options';
        $query['return'] = admin_url( urlencode('admin.php?page=easyjobs#/settings') );

        $job_landing_page = Easyjobs_Helper::get_landing_page();

        if(!empty($job_landing_page)){
            $query['url'] = get_permalink($job_landing_page->ID);
        }

        $customizer_link = add_query_arg( $query, admin_url( 'customize.php' ) );

        echo json_encode([
           'status' => 'success',
           'data' => [
               'link' => $customizer_link
           ]
        ]);

        wp_die();
    }

    public function disconnect_api_key()
    {
        if(delete_option('easyjobs_settings')){
            echo json_encode([
                'status' => 'success',
            ]);
        }else{
            echo Easyjobs_Helper::get_error_response('Api disconnect failed');
        }

        wp_die();
    }

    public function verify_company()
    {
        if(!isset($_POST['is_verified'])){
            echo Easyjobs_Helper::get_error_response('Verification status not sent.');
            wp_die();
        }
        $response = Easyjobs_Api::post(
            'settings_verify',
            null,
            ['is_verified' =>  sanitize_text_field($_POST['is_verified']) === 'true']
        );
        set_transient('easyjobs_company_verification_status', $response->data->is_verified ? 'yes' : 'no', 3600);
        echo Easyjobs_Helper::get_generic_response($response);
        wp_die();
    }

    public function get_shortcodes()
    {
        $data = Easyjobs_Api::get('published_jobs');
        if ($data->status != 'success') {
            echo Easyjobs_Helper::get_error_response('Unable to get jobs from api');
        }
        $shortcodes = [
            ['name' => 'Landing page with profile', 'code' => '[easyjobs]'],
            ['name' => 'All jobs list', 'code' => '[easyjobs_list]'],
        ];
        foreach ($data->data as $job){
            $shortcodes[] = [
                'name' => $job->title,
                'code' => '[easyjobs_details id=' . $job->id . ']'
            ];
        }

        echo json_encode([
            'status' => 'success',
            'data' => $shortcodes
        ]);

        wp_die();
    }

    public function upload_company_image()
    {
        echo Easyjobs_Helper::get_generic_response(Easyjobs_Api::postWithFile(
            'company_photo',
            [
                'target' => $_POST['target'],
            ],
            $_FILES['file']
        ));
        wp_die();
    }

    public function update_brand_color()
    {
        if(!isset($_POST['brand_color'])){
            echo Easyjobs_Helper::get_error_response('Color not provided');
        }

        echo Easyjobs_Helper::get_generic_response(Easyjobs_Api::post(
           'brand_color',
            null,
            ['brand_color' => $_POST['brand_color']]
        ));

        wp_die();
    }

    public function update_show_life()
    {
        if(!isset($_POST['show_life'])){
            echo Easyjobs_Helper::get_error_response('Status not provided');
        }

        echo Easyjobs_Helper::get_generic_response(Easyjobs_Api::post(
            'show_life',
            null,
            ['show_life' => (string) $_POST['show_life'] === "true"]
        ));

        wp_die();
    }
    public function update_ai_setup()
    {
        $fields = ['is_ai_enabled','run_batch_score'];
        $data = [];
        foreach ($_POST as $name => $value){
            if(in_array($name, $fields)){
                $data[$name] = sanitize_text_field($value) === "true";
            }
        }
        $response = Easyjobs_Api::post(
            'ai_setup',
            null,
            $data
        );
        if(Easyjobs_Helper::is_success_response($response->status)){
            EasyJobs_DB::update_settings((int) $response->data->ai_setup_enabled === 1 ? 'yes' : 'no', 'easyjobs_ai_setup');
        }
        echo Easyjobs_Helper::get_generic_response($response);
        wp_die();
    }

    public function create_pipeline()
    {
        echo Easyjobs_Helper::get_generic_response(
            Easyjobs_Api::post(
                'create_pipeline',
                null,
                [
                    'name' => sanitize_text_field($_POST['name']),
                    'steps' => json_decode(stripslashes($_POST['steps']))
                ]
            )
        );
        wp_die();
    }

    public function update_pipeline()
    {
        if(!isset($_POST['id'])){
            echo Easyjobs_Helper::get_error_response('Pipeline id not provided');
            wp_die();
        }
        echo Easyjobs_Helper::get_generic_response(
            Easyjobs_Api::post(
                'update_pipeline',
                $_POST['id'],
                [
                    'name' => sanitize_text_field($_POST['name']),
                    'steps' => json_decode(stripslashes($_POST['steps']))
                ]
            )
        );
        wp_die();
    }

    public function delete_pipeline()
    {
        if(!isset($_POST['pipeline_id'])){
            echo Easyjobs_Helper::get_error_response('Pipeline id not provided');
            wp_die();
        }
        echo Easyjobs_Helper::get_generic_response(
            Easyjobs_Api::post(
                'delete_pipeline',
                abs($_POST['pipeline_id'])
            )
        );
        wp_die();
    }

    /**
     * Ajax callback for easyjobs_save_apply_settings action
     * Save candidate apply settings data
     * @since 1.3.0
     */
    public function save_apply_settings()
    {
        echo Easyjobs_Helper::get_generic_response(
            Easyjobs_Api::post(
                'save_apply_settings',
                null,
                [
                    'login_option' => json_decode(stripslashes($_POST['login_option'])),
                    'custom_fields' => json_decode(stripslashes($_POST['custom_fields'])),
                ]
            )
        );
        wp_die();
    }

}
