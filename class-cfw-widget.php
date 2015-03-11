<?php

/**

 * Plugin Name: WWM Registration Form Widget
 * Plugin URI: http://support.worldwidemarkets.com/wp-content/plugins/WWM-Registration-Form-Widget/readme.html
 * Description: Custom form widget for building your own users sign up form with WWM API
 * Version: 1.1
 * Author: WorldWideMarkets
 * Author URI: http://support.worldwidemarkets.com/wp-content/plugins/WWM-Registration-Form-Widget/readme.html
 * Text Domain: Optional. Plugin's text domain for localization. Example: mytextdomain
 * Domain Path: Optional. Plugin's relative directory path to .mo files. Example: /locale/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: A short license name. Example: GPL2
 */

/*
    Copyright(C) 2015 WorldWideMarkets(dtang@tabnetworks.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

Class Cfw_Widget extends WP_Widget {

    function Cfw_Widget() {
        parent::WP_Widget(false, $name = __('WWM Registration Form Widget', 'custom-form-wwm'),
        array( 'description' => __( 'Add a custom WWM registration form to your sidebar. Use shortcode to display form on pages.', 'WWM Registration Form Widget' )) );
    }

    // widget form creation--create the widget form in the administration
    function form($instance) {
        // Check values
        if( $instance) {
            $title = esc_attr($instance['title']);
            $platform = esc_attr($instance['platform']);
            $spreadType = esc_attr($instance['spreadType']);
            $accType = esc_attr($instance['accType']);
            $language = esc_attr($instance['language']);
            $themecolor = esc_attr($instance['themecolor']);
            $promo = esc_attr($instance['promo']);
            $btntext = esc_attr($instance['btntext']);
            } else {
            $title = '';
            $platform = '';
            $spreadType = '';
            $accType = '';
            $language = '';
            $themecolor = '';
            $promo = '';
            $btntext = '';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Form Title', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('platform'); ?>"><?php _e('Platform:', 'wp_widget_plugin'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('platform'); ?>" name="<?php echo $this->get_field_name('platform'); ?>">
                <?php $options = array( 'AlphaTrader','MetaTrader4' );
                foreach ( $options as $option ) {
                    echo '<option value="' . $option . '" id="' . $option . '"', $platform == $option ? ' selected="selected"' : '', '>' . $option . '</option>';
                }?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('spreadType'); ?>"><?php _e('Spread Type:', 'wp_widget_plugin'); ?></label>
            <a href="/wp-content/plugins/wwm-registration-form-widget/readme.html" target="_blank"><img src="/wp-content/plugins/wwm-registration-form-widget/lib/question-y.png" width="14"></a>
            <select class="widefat" id="<?php echo $this->get_field_id('spreadType'); ?>" name="<?php echo $this->get_field_name('spreadType'); ?>">
                <?php $options = array( 'Fixed','Variable' );
                foreach ( $options as $option ) {
                    echo '<option value="' . $option . '" id="' . $option . '"', $spreadType == $option ? ' selected="selected"' : '', '>' . $option . '</option>';
                }?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('accType'); ?>"><?php _e('Account Type:', 'wp_widget_plugin'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('accType'); ?>" name="<?php echo $this->get_field_name('accType'); ?>">
                <?php $options = array( 'Demo','Live' );
                foreach ( $options as $option ) {
                    echo '<option value="' . $option . '" id="' . $option . '"', $accType == $option ? ' selected="selected"' : '', '>' . $option . '</option>';
                }?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('language'); ?>"><?php _e('Select a Language:', 'wp_widget_plugin'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('language'); ?>" name="<?php echo $this->get_field_name('language'); ?>">
                <?php $options = array( 'English','العربية' ,'中文','русский','español');
                foreach ( $options as $option ) {
                    echo '<option value="' . $option . '" id="' . $option . '"', $language == $option ? ' selected="selected"' : '', '>' . $option . '</option>';
                }?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('themecolor'); ?>"><?php _e('Select a Theme:', 'wp_widget_plugin'); ?></label>
            <a href="/wp-content/plugins/wwm-registration-form-widget/readme.html" target="_blank"><img src="/wp-content/plugins/wwm-registration-form-widget/lib/question-y.png" width="14"></a><br>
            <input class="color" id="<?php echo $this->get_field_id('themecolor'); ?>"  name="<?php echo $this->get_field_name('themecolor'); ?>"  value="<?php echo $themecolor;?>" style="color:#fff;background-color:#<?php echo $themecolor;?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('promo'); ?>"><?php _e('Source:', 'wp_widget_plugin'); ?></label>
            <a href="/wp-content/plugins/wwm-registration-form-widget/readme.html" target="_blank"><img src="/wp-content/plugins/wwm-registration-form-widget/lib/question-y.png" width="14"></a>
            <input class="widefat" id="<?php echo $this->get_field_id('promo'); ?>" name="<?php echo $this->get_field_name('promo'); ?>" type="text" value="<?php echo $promo; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('btntext'); ?>"><?php _e('Button Text:', 'wp_widget_plugin'); ?></label>
            <a href="/wp-content/plugins/wwm-registration-form-widget/readme.html" target="_blank"><img src="/wp-content/plugins/wwm-registration-form-widget/lib/question-y.png" width="14"></a>
            <input class="widefat" id="<?php echo $this->get_field_id('btntext'); ?>" name="<?php echo $this->get_field_name('btntext'); ?>" type="text" value="<?php echo $btntext; ?>" placeholder="Enter the text you want to appear on the button"/>
        </p>
    <?php
    }

    // widget update--save widget data during edition
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['platform'] = strip_tags($new_instance['platform']);
        $instance['spreadType'] = strip_tags($new_instance['spreadType']);
        $instance['accType'] = strip_tags($new_instance['accType']);
        $instance['language'] = strip_tags($new_instance['language']);
        $instance['themecolor'] = strip_tags($new_instance['themecolor']);
        $instance['promo'] = strip_tags($new_instance['promo']);
        $instance['btntext'] = strip_tags($new_instance['btntext']);

        return $instance;
    }

    // widget display--display the widget content on the front-end
    function widget($args, $instance) {

        extract( $args );
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $platform = $instance['platform'];
        $spreadType = $instance['spreadType'];
        $accType = $instance['accType'];
        $language = $instance['language'];
        $themecolor = $instance['themecolor'];
        $promo = $instance['promo'];
        $btntext = $instance['btntext'];

        echo $before_widget;
        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box"><div class="wwm_widget_wrap"><div id="w_formbody"><form name="customForm" class="customForm">';

        if ( $title ) {
            // echo $before_title . $title . $after_title;
            echo  $before_title . $title. $after_title;
        }else{
            echo $before_title . $platform .' ' . $accType .' Sign up'. $after_title;}

        $url='http://';
        if(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on'){
            $url='https://'; }
        if($_SERVER['SERVER_PORT']!='80'){
            $url.=$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        }else{
            $url.=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        }

        if(strstr($url,'/ar/') ||strstr($url,'?lang=ar')){
            $slt_language = '2';
        }elseif(strstr($url,'/zh-hans/') ||strstr($url,'?lang=zh-hans')){
            $slt_language = '3';
        }elseif(strstr($url,'/ru/') ||strstr($url,'?lang=ru')){
            $slt_language = '4';
        }elseif(strstr($url,'/es/') ||strstr($url,'?lang=es')){
            $slt_language = '5';
        }else{
            if ( $language == 'English') { $slt_language = '1';
            }elseif( $language == 'العربية') { $slt_language = '2';
            }elseif( $language == '中文') { $slt_language = '3';
            }elseif( $language == 'русский') { $slt_language = '4';
            }elseif( $language == 'español') { $slt_language = '5';}
        }


        if ( $accType == 'Demo' ) {
            $accountType = '1';
        }elseif($accType == 'Live'){
            $accountType = '2';
        }

        if ( $platform == 'AlphaTrader' ) {
            $platformID = '1';
            $inst = '1';
        }elseif($platform == 'MetaTrader4'){
            $platformID = '2';
            if($accountType=='1'){$inst='100';}elseif($accountType=='2'){$inst='101';}
        }

        include('import_form.php');

        if ( $btntext ) { echo '<input type="submit" name="'.$btntext.'" class="w_submit_btn" id="w_submit_btn" value="'.$btntext.'"/>';}
        else {echo '<input type="submit" name="Get Started" class="w_submit_btn" id="w_submit_btn" value="Get Started"/>';}

        echo '</form></div></div></div>';
        echo $after_widget;
    }
}



    function cfw_load_widget(){
        register_widget('Cfw_Widget');
    }

add_action( 'widgets_init', 'cfw_load_widget' );

function widget_shortcode($type){
    extract(shortcode_atts(array(
        'type'  =>  'atdemo',
        'language'  => 'en',
        'themecolor' => 'F73',
        'ibid'    => 'BCCCB3E0D76A7D3777E29AB2702379615B083B46',
        'agentid'   =>'1541'
    ),$type));

    $url='http://';
    if(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on'){
        $url='https://'; }
    if($_SERVER['SERVER_PORT']!='80'){
        $url.=$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
    }else{
        $url.=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }

    if(strstr($url,'/ar/') ||strstr($url,'?lang=ar')){
        $slt_language = '2';
    }elseif(strstr($url,'/zh-hans/') ||strstr($url,'?lang=zh-hans')){
        $slt_language = '3';
    }elseif(strstr($url,'/ru/') ||strstr($url,'?lang=ru')){
        $slt_language = '4';
    }elseif(strstr($url,'/es/') ||strstr($url,'?lang=es')){
        $slt_language = '5';
    }else{
        if( $language == 'ar') { $slt_language = '2';
        }elseif( $language == 'cn') { $slt_language = '3';
        }elseif( $language == 'ru') { $slt_language = '4';
        }elseif( $language == 'es') { $slt_language = '5';
        }else{$slt_language = '1';}
    }

    switch($type){
        case 'atdemo':
            $platformID = '1';
            $accountType = '1';
            $inst = '1';
            echo '<div class="wwm_widget_wrap"><h4>AlphaTrader Demo Form Registration</h4><div id="w_formbody"><form id="customForm" class="customForm">';
            include('import_form.php');
            $btn= '<input type="submit" name="Get Started" id="w_submit_btn" class="w_submit_btn" value="Get Started"/>';
            echo $btn.'</form></div></div>';
            break;

        case 'atlive':
            $platformID = '1';
            $accountType = '2';
            $inst = '1';
            echo '<div class="wwm_widget_wrap"><h4>AlphaTrader Live Form Registration</h4><div id="w_formbody"><form id="customForm" class="customForm">';
            include('import_form.php');
            $btn= '<input type="submit" name="Get Started" id="w_submit_btn" class="w_submit_btn" value="Get Started"/>';
            echo $btn.'</form></div></div>';
            break;

        case 'mtdemo':
            $platformID = '2';
            $accountType = '1';
            $inst = '100';
            echo '<div class="wwm_widget_wrap"><h4>MetaTrader Demo Form Registration</h4><div id="w_formbody"><form id="customForm" class="customForm">';
            include('import_form.php');
            $btn= '<input type="submit" name="Get Started" id="w_submit_btn" class="w_submit_btn" value="Get Started"/>';
            echo $btn.'</form></div></div>';
            break;

        case 'mtlive':
            $platformID = '2';
            $accountType = '2';
            $inst = '101';
            echo '<div class="wwm_widget_wrap"><h4>MetaTrader Live Form Registration</h4><div id="w_formbody"><form id="customForm" class="customForm">';
            include('import_form.php');
            $btn= '<input type="submit" name="Get Started" id="w_submit_btn" class="w_submit_btn" value="Get Started"/>';
            echo $btn.'</form></div></div>';
            break;
    }
}

add_shortcode('customForm','widget_shortcode');

function wwm_enqueue_scripts() {

    if(!is_admin()) { //front-end scripts & stylesheet

        wp_enqueue_script('jquery');

        wp_register_script('jQuery-validate', '/wp-content/plugins/wwm-registration-form-widget/js/jquery.validate.min.js');
        wp_enqueue_script('jQuery-validate');

    }else {  //back-end scripts & stylesheet

        wp_register_script('jQuery-jscolor', '/wp-content/plugins/wwm-registration-form-widget/jscolor/jscolor.js');
        wp_enqueue_script('jQuery-jscolor');
    }
}

// return to init() function
add_action( 'init', 'wwm_enqueue_scripts' );


// create custom plugin settings menu
add_action('admin_menu', 'wwm_create_menu');

function wwm_create_menu() {

    add_options_page('WWM Registration Form Settings','WWM Registration Form','manage_options','WWM_Registration_Form_Settings','wwm_settings_page');
    add_action( 'admin_init', 'register_wwmsettings' );
}

function register_wwmsettings() {
    //register our settings
    register_setting( 'wwm-settings-group', 'ibhash' );
    register_setting( 'wwm-settings-group', 'affiliate_id' );
    register_setting( 'wwm-settings-group', 'click_id' );
    register_setting( 'wwm-settings-group', 'agent_id' );
    register_setting( 'wwm-settings-group', 'wwm-css-option' );
    register_setting( 'wwm-settings-group','wwm-recipient-email');
    register_setting( 'wwm-settings-group','wwm-email-subject');
    register_setting( 'wwm-settings-group','wwm-form-message');
    register_setting( 'wwm-settings-group','wwm-email-from');
}

function wwm_settings_page() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( 'You do not have sufficient permissions to access this page.' );
    }
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>WWM Registration Form Settings</h2>

        <form method="post" action="options.php">
            <?php settings_fields( 'wwm-settings-group' ); ?>
            <?php do_settings_sections( 'wwm-settings-group' ); ?>

            <h3>Form Input Value Settings</h3>
            <table class="form-table">
                <tr><th style="width:350px">Input form values below based on your user type</th></tr>
                <tr valign="top">
                    <th scope="row">IB Hash<a href="/wp-content/plugins/wwm-registration-form-widget/readme.html" target="_blank"><img src="/wp-content/plugins/wwm-registration-form-widget/lib/question-y.png" width="14"></a></th>
                    <td><input type="text" name="ibhash" value="<?php echo esc_attr( get_option('ibhash') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Agent ID<a href="/wp-content/plugins/wwm-registration-form-widget/readme.html" target="_blank"><img src="/wp-content/plugins/wwm-registration-form-widget/lib/question-y.png" width="14"></a></th>
                    <td><input type="text" name="agent_id" value="<?php echo esc_attr( get_option('agent_id') ); ?>" /></td>
                </tr>
                <tr><td style="font-weight:bold;font-size:1.3em;">OR</td></tr>
                <tr valign="top">
                    <th scope="row">Affiliate ID<a href="/wp-content/plugins/wwm-registration-form-widget/readme.html" target="_blank"><img src="/wp-content/plugins/wwm-registration-form-widget/lib/question-y.png" width="14"></a></th>
                    <td><input type="text" name="affiliate_id" value="<?php echo esc_attr( get_option('affiliate_id') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Click ID<a href="/wp-content/plugins/wwm-registration-form-widget/readme.html" target="_blank"><img src="/wp-content/plugins/wwm-registration-form-widget/lib/question-y.png" width="14"></a></th>
                    <td><input type="text" name="click_id" value="<?php echo esc_attr( get_option('click_id') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Form Message</th>
                    <td><textarea cols="63" rows="8" name="wwm-form-message" placeholder="Please enter a short message below and this message will display within the form under the form title."><?php echo esc_attr( get_option('wwm-form-message') ); ?></textarea></td>
                </tr>
            </table>

            <h3>Email Message Settings</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Recipient Emails</th>
                    <td><input type="text" name="wwm-recipient-email" value="<?php echo esc_attr( get_option('wwm-recipient-email') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Email Subject</th>
                    <td><input type="text" name="wwm-email-subject" value="<?php echo esc_attr( get_option('wwm-email-subject') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Override 'From' Email Address :</th>
                    <td><input type="text" name="wwm-email-from" value="<?php echo esc_attr( get_option('wwm-email-from') ); ?>" /></td>
                </tr>
            </table>

            <h3>Styling and Validation</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">CSS Option</th>
                    <td><input type="checkbox" name="wwm-css-option"  value="1" <?php checked( '1', get_option( 'wwm-css-option' ) ); ?>/> Use the plugin default stylesheet (un-tick to use your theme style sheet instead) </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php }

function wwm_scripts_load(){
    wp_enqueue_script('wwm-widget-js', plugins_url('js/widget_custom_ajax.js', __FILE__) );
    wp_localize_script('wwm-widget-js','wwmAjaxData',array( 'ajaxurl' => admin_url('admin-ajax.php') ) );
}
add_action('wp_enqueue_scripts', 'wwm_scripts_load');

add_action('wp_ajax_wwm_action','wwm_action_callback');
add_action('wp_ajax_nopriv_wwm_action','wwm_action_callback');

function wwm_action_callback(){

    if(!wp_verify_nonce($_REQUEST['_wpnonce'],'wwm_create_nonce')){
        die( 'Security check' );
    } else {
        if ($_POST) {
            // Sanitize form data
            $uname = isset($_POST["uname"]) ? filter_var($_POST["uname"], FILTER_SANITIZE_STRING) : 'N/A';
            $fname = isset($_POST["fname"]) ? filter_var($_POST["fname"], FILTER_SANITIZE_STRING) : 'N/A';
            $lname = isset($_POST["lname"]) ? filter_var($_POST["lname"], FILTER_SANITIZE_STRING) : 'N/A';
            $email = isset($_POST["email"]) ? filter_var($_POST["email"], FILTER_SANITIZE_STRING) : 'N/A';
            $phone = isset($_POST["phone"]) ? filter_var($_POST["phone"], FILTER_SANITIZE_STRING) : 'N/A';
            $password = isset($_POST["password"]) ? filter_var($_POST["password"], FILTER_SANITIZE_STRING) : 'N/A';
            $slt_country = isset($_POST['slt_country ']) ? $_POST['slt_country '] : 'N/A';
            $platformID = isset($_POST["platformID"]) ? filter_var($_POST["platformID"], FILTER_SANITIZE_STRING) : 'N/A';
            $accountType = isset($_POST["accountType"]) ? filter_var($_POST["accountType"], FILTER_SANITIZE_STRING) : 'N/A';
            $phonecode = isset($_POST["phonecode"]) ? filter_var($_POST["phonecode"], FILTER_SANITIZE_STRING) : 'N/A';
            $instance = isset($_POST["instance"]) ? filter_var($_POST["instance"], FILTER_SANITIZE_STRING) : 'N/A';
            $ipAddress = isset($_POST["ipAddress"]) ? filter_var($_POST["ipAddress"], FILTER_SANITIZE_STRING) : 'N/A';
            $affid = isset($_POST["affid"]) ? filter_var($_POST["affid"], FILTER_SANITIZE_STRING) : 'N/A';
            $form_id = isset($_POST["form_id"]) ? filter_var($_POST["form_id"], FILTER_SANITIZE_STRING) : 'N/A';
            $clickid = isset($_POST["clickid"]) ? filter_var($_POST["clickid"], FILTER_SANITIZE_STRING) : 'N/A';
            $source_id = isset($_POST["source_id"]) ? filter_var($_POST["source_id"], FILTER_SANITIZE_STRING) : 'N/A';


            if (isset($_POST['uname']) && isset($_POST["platformID"]) == '1') {$u_name = $_POST['uname'];} else {$u_name = '';}
            if (isset($_POST['address'])) { $address = $_POST['address'];} else {$address = ''; }
            if (isset($_POST['city'])) { $city = $_POST['city'];} else {$city = '';}
            if (isset($_POST['state'])) {$state = $_POST['state']; } else { $state = ''; }
            if (isset ($_POST['postal'])) { $postal = $_POST['postal'];} else {$postal = '';}
            if (isset ($_POST['language'])) { $slt_language = $_POST['language'];} else { $slt_language = '1';}
            if (isset ($_POST['ibhash'])) {$ibhash = $_POST['ibhash']; } else {  $ibhash = 'BCCCB3E0D76A7D3777E29AB2702379615B083B46';}
            if (isset ($_POST['agentid'])) { $agentid = $_POST['agentid'];} else {$agentid = '1541'; }
            if (isset ($_POST['affid'])) {$affid = $_POST['affid']; } else {$affid = ''; }
            if (isset ($_POST['clickid'])) {$clickid = $_POST['clickid']; } else { $clickid = '';}
            if (isset ($_POST['source_id'])) {if($_POST["source_id"]!=''){$source_id = $_POST['source_id'];}else{$source_id = 'Custom_Form_Widget';}}

            $phonewithcode = $phonecode . "-" . $_POST['phone'];

            $data_arr = array('messageID' => '4013',
                'platformID' => $_POST['platformID'],
                'ipAddress' => $_POST['ipAddress'],
                'mtAgent' => $agentid,
                'instance' => $_POST['instance'],
                'userType' => '1',
                'firstName' => $_POST['fname'],
                'lastName' => $_POST['lname'],
                'addressLine1' => $address,
                'addressLine2' => '',
                'city' => $city,
                'stateProvince' => $state,
                'countryID' => $_POST['slt_country'],
                'languageID' => $slt_language,
                'wlpHash' => '38A8F608F28E8028E9A76A9A24C918741747F173',
                'zipPostalCode' => $postal,
                'dob' => '',
                'emailAddress1' => $_POST['email'],
                'emailAddress2' => '',
                'phoneNumber' => $phonewithcode,
                'refNo' => '',
                'username' => $u_name,
                'password' => $_POST['pwd'],
                'accountType' => $_POST['accountType'],
                'currencyID' => '1',
                'ibHash' => $ibhash,
                'margin' => '0.0025',
                'spreadType' => 'F',
                'interestFree' => '0',
                'depositAmount' => '10000',
                'ibAgent' => $agentid,
                'affiliateID' => $affid,
                'formID' => $_POST['form_id'],
                'clickID' => $clickid,
                'sourceID' => $source_id
            );

            $countryID = $_POST['slt_country'];
            $csv = "lib/countrycodes.csv";
            $code = fopen($csv, "r");
            while ($data = fgetcsv($code, ",")) {
                if ($data[1] == $countryID) {
                    $country = $data[0];
                }
            }
            //send email
            if (isset($_POST['emailto'])) {if($_POST['emailto']!=''){$to = $_POST['emailto']; }else{$to = 'info@forexblast.com';} }
            if (isset ($_POST['emailsubject'])) {if($_POST['emailsubject']!=''){$subject = $_POST['emailsubject'];}else{$subject = 'WWM Registration';}}
            if ($accountType == '1') { $acct = 'Demo'; } else { $acc = 'Live'; }
            if ($platformID == '1') { $platForm = 'Alphatrader'; } else { $platForm = 'Metatrader'; }
            $message = '';
            $message .= 'Registration details are as follows: Testing final' . '<br /> <br />';
            $message .= 'Name: ' . $fname . ' ' . $lname . '<br /> <br />';
            $message .= 'Email: ' . $email . '<br /> <br />';
            $message .= 'Phone: ' . $phone . '<br /> <br />';
            $message .= 'Country: ' . $country . '<br /> <br />';
            $message .= 'Source ID: ' . $source_id . '<br /> <br />';
            $message .= 'Password: ' . $_POST['pwd'] . '<br /> <br />';
            $message .= '';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            if ($emailfrom != '') {
                $headers .= 'From: ' . $emailfrom . "\r\n";
            }
            mail($to, $subject, $message, $headers);

            //post to TAB-API
            $parms = http_build_query($data_arr);
            $url="https://reports.onlineglobalmarkets.com/TabWebGateway/TabWebGateway.api?".$parms;
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $curlcontent = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($curlcontent);

            if($output->isSuccessful==true){
                $accountInfo = $output->accountNo;
                $suc='1';
                if($platformID=='2'){
                    echo json_encode(array('acc' => $accountInfo,'password'=>$_POST['pwd'],'isSuc'=>$suc));
                }elseif($platformID=='1'){
                    echo json_encode(array('acc' => $u_name,'password'=>$_POST['pwd'],'isSuc'=>$suc));
                }
            }else{
                $suc='0';
                $errmsg = $output->errorMessage;
                $correlationID = $output->correlationID;
                echo json_encode(array('acc' => $errmsg,'password'=>$correlationID,'isSuc'=>$suc));
            }
        }//end post section
    } //end nonce check
    die();
}  //end callback function