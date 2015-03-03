<?php

//plugin is activated
include('lib/multi_lang.php');

// get options value
global $options;

if(get_option('affiliate_id') !=''  ){$affid=get_option('affiliate_id');}
if(get_option('ibhash')!=''){$ibid=get_option('ibhash');}
if(get_option('agent_id')!=''){$agentid=get_option('agent_id');}
if(get_option('click_id')!=''){$clickid=get_option('click_id');}
if(get_option('wwm-form-message')!=''){$form_msg=get_option('wwm-form-message');?><p><?php echo $form_msg;?></p><?}
if(get_option('wwm-recipient-email')!=''){  $emailto = get_option('wwm-recipient-email');}
if(get_option('wwm-email-subject')!=''){ $emailsubject = get_option('wwm-email-subject');}
if(get_option('wwm-email-from')!=''){ $emailfrom = get_option('wwm-email-from');}
if(get_option('wwm-css-option')=='1'||  (get_option('wwm-css-option')!=='' && get_option('wwm-css-option')== false)){
    if($slt_language=='2'){
        wp_enqueue_style('jQuery-wwm-widget', '/wp-content/plugins/wwm-registration-form-widget/css/custom_style_ar.css');
    }else{
        wp_enqueue_style('jQuery-wwm-widget', '/wp-content/plugins/wwm-registration-form-widget/css/custom_style.css');
    }
}
?>

<input type="hidden" name="accountType" id="w_accountType" value="<?php echo $accountType;?>"/>
<input type="hidden" name="platformID" id="w_platformID" value="<?php echo $platformID;?>"/>
<?if(getenv('HTTP_CLIENT_IP')) {
    $onlineip = getenv('HTTP_CLIENT_IP');
} elseif(getenv('HTTP_X_FORWARDED_FOR')) {
    $onlineip = getenv('HTTP_X_FORWARDED_FOR');
} elseif(getenv('REMOTE_ADDR')) {
    $onlineip = getenv('REMOTE_ADDR');
} else {
    $onlineip = $_SERVER['REMOTE_ADDR'];
}
    wp_nonce_field( 'wwm_create_nonce' );
    ?>
<input type="hidden" name="ipAddress" value="<?=$onlineip;?>"/>

<input type="hidden" name="instance" id="w_instance" value="<?php echo $inst;?>"/> <!-- To Due: 1 is AT, 100 is MT-->

<input type="hidden" name="user_type" value="1"/>

<input type="hidden" name="language" id="w_language" value="<?php echo $slt_language;?>"/>

<input type="hidden" id="w_affid" name="affid" value="<?php echo $affid;?>"/>

<input type="hidden" id="form_id" name="form_id" value="Y"/>

<input type="hidden" id="w_clickid" name="clickid" value="<?php echo $clickid;?>"/>

<input type="hidden" id= "w_source_id" name="source_id" value="<?php echo $promo;?>"/>

<input type="hidden" id= "w_ibid" name="ibhash" value="<?php echo $ibid;?>"/>

<input type="hidden" id="w_agentid" name="agentid" value="<?php echo $agentid;?>">

<input type="hidden" name="emailto" value="<?php echo $emailto;?>">
<input type="hidden" name="emailsubject" value="<?php echo $emailsubject;?>">
<input type="hidden" name="emailfrom" value="<?php echo $emailfrom;?>">

<div class="wwm-form-section">
    <label for="email"><?php echo $ms_email;?></label>
    <div class="wwm_input_field">
    <input type="email" id="w_email" name="email" class="form-control" placeholder="<?php echo $ms_email;?>"></div>
</div>

<div class="wwm-form-section">
    <label for="slt_country"><?php echo $ms_country;?></label>
    <div class="wwm_input_field">
        <select class="form-control"  id="w_slt_country" name="slt_country">
            <option><?php echo $ms_sltCountry;?></option>
            <?php
            $rows = array();
            $value =array();
            $csv='wp-content/plugins/wwm-registration-form-widget/lib/countrycodes.csv';
            $code = file($csv);
            foreach($code as $key => $val){
                $rowarray = explode(",",$val);
                $rows[] = $rowarray[0];}
            asort($rows);
            foreach($rows as $key => $val){
                $sortedlist = explode(",",$code[$key]);
                echo '<option value='.$sortedlist[1].'>'.$sortedlist[0].'</option>';}
            ?>
        </select>
    </div>
</div>

<div class="wwm-form-section">
    <label for="phone"><?php echo $ms_phone;?></label>
    <div class="wwm_input_field">
         <span style="display:block;" id="w_mainCWrapper">
            <input type="text" id="w_phonecode" name="phonecode" class="form-control" style="display: none;" placeholder="+ " readonly/>
         </span>
        <input type="text" id="w_phone" name="phone" class="form-control" placeholder="<?php echo $ms_phone;?>"/>
    </div>
</div>

<?if($platformID=='1'){?>
    <div class="wwm-form-section" id="w_username">
        <label for="uname"><?php echo $ms_uname;?></label>
        <div class="wwm_input_field">
        <input type="text" id="w_uname" name="uname" class="form-control" placeholder="<?php echo $ms_uname;?>"></div>
    </div>
<?}?>

<div class="wwm-form-section">
    <label for="pwd"><?php echo $ms_pwd;?></label>
    <div class="wwm_input_field">
    <input type="password" id="w_pwd" name="pwd" class="form-control" placeholder="<?php echo $ms_pwd;?>"></div>
</div>


<div class="wwm-form-section">
    <label for="fname"><?php echo $ms_fname;?></label>
    <div class="wwm_input_field">
    <input type="text" id="w_fname" name="fname" class="form-control" placeholder="<?php echo $ms_fname;?>"></div>
</div>

<div class="wwm-form-section">
    <label for="lname"><?php echo $ms_lname;?></label>
    <div class="wwm_input_field">
    <input type="text" id="w_lname" name="lname" class="form-control" placeholder="<?php echo $ms_lname;?>"></div>
</div>

<?if($accountType=='2'){?><!-- Live Account Fields Start -->
<div class="wwm-form-section">
    <label for="postal"><?php echo $ms_postal;?></label>
    <div class="wwm_input_field">
    <input type="text" id="w_postal" name="postal" class="form-control" placeholder="<?php echo $ms_postal;?>"></div>
</div>


<div class="wwm-form-section">
    <label for="address"><?php echo $ms_street;?></label>
    <div class="wwm_input_field">
    <input type="text" id="w_address" name="address" class="form-control" placeholder="<?php echo $ms_street;?>"></div>
</div>

<div class="wwm-form-section">
    <label for="city"><?php echo $ms_city;?></label>
    <div class="wwm_input_field">
    <input type="text" id="w_city" name="city" class="form-control" placeholder="<?php echo $ms_city;?>"></div>
</div>

<div class="wwm-form-section">
    <label for="state"><?php echo $ms_state;?></label>
    <div class="wwm_input_field">
    <input type="text" id="w_state" name="state" class="form-control" placeholder="<?php echo $ms_state;?>"></div>
</div>
<?}?><!-- Live Account Fields Ends -->

<?if($accountType=='2'){?>
<div class="checkbox">
    <label>
        <input type="checkbox" id="w_reg_check" name="reg_check"> <?php echo $ms_chkbox;?>
    </label>
</div>
<?}?>

<p class="help-block"><?php echo $ms_helpmsg;?></p>

<div id="themecolor" class="custom_color" style="display:none;"><?php if(get_option('wwm-css-option')=='1'||  (get_option('wwm-css-option')!=='' && get_option('wwm-css-option')== false)){echo $themecolor;}?></div>