<?php
//require_once(ABSPATH .'wp-includes/pluggable.php');
if (!function_exists('add_action')) {
   require_once("../../../wp-load.php");
}
include_once(ABSPATH .'wp-admin/includes/plugin.php');
if ( is_plugin_active( 'wwm-registration-form-widget/class-cfw-widget.php' ) ) {
   // if (!check_ajax_referer("wwm_create_nonce")) {
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


            if (isset($_POST['uname']) && isset($_POST["platformID"]) == '1') {
                $u_name = $_POST['uname'];
            } else {
                $u_name = '';
            }
            if (isset($_POST['address'])) {
                $address = $_POST['address'];
            } else {
                $address = '';
            }
            if (isset($_POST['city'])) {
                $city = $_POST['city'];
            } else {
                $city = '';
            }
            if (isset($_POST['state'])) {
                $state = $_POST['state'];
            } else {
                $state = '';
            }
            if (isset ($_POST['postal'])) {
                $postal = $_POST['postal'];
            } else {
                $postal = '';
            }
            if (isset ($_POST['language'])) {
                $slt_language = $_POST['language'];
            } else {
                $slt_language = '1';
            }
            if (isset ($_POST['ibhash'])) {
                $ibhash = $_POST['ibhash'];
            } else {
                $ibhash = 'BCCCB3E0D76A7D3777E29AB2702379615B083B46';
            }
            if (isset ($_POST['agentid'])) {
                $agentid = $_POST['agentid'];
            } else {
                $agentid = '1541';
            }
            if (isset ($_POST['affid'])) {
                $affid = $_POST['affid'];
            } else {
                $affid = '';
            }
            if (isset ($_POST['clickid'])) {
                $clickid = $_POST['clickid'];
            } else {
                $clickid = '';
            }
            if (isset ($_POST['source_id'])) {
                if($_POST["source_id"]!=''){$source_id = $_POST['source_id'];
                }else{$source_id = 'Custom_Form_Widget';}
            }

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
            if (isset($_POST['emailto'])) {
                if($_POST['emailto']!=''){$to = $_POST['emailto'];
                }else{$to = 'dee.t1989@gmail.com';}
            }
            if (isset ($_POST['emailsubject'])) {
                if($_POST['emailsubject']!=''){$subject = $_POST['emailsubject'];
                }else{$subject = 'WWM Registration';}
            }
            if ($accountType == '1') {
                $acct = 'Demo';
            } else {
                $acc = 'Live';
            }
            if ($platformID == '1') {
                $platForm = 'Alphatrader';
            } else {
                $platForm = 'Metatrader';
            }

             $message = '';
             $message .= 'Registration details are as follows:' . '<br /> <br />';
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
             /*$headers = 'From: info@forexblast.com' . "\r\n" .
                 'Reply-To: info@forexblast.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();*/
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
        }

    }
}

