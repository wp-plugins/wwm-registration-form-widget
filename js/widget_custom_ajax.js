
jQuery.noConflict();

jQuery(document).ready(function ($) {


    //for custom plugin begin
    jQuery(".wwm_widget_wrap").each(function(i){

        //for themecolor change
        var form = jQuery(this).html();
        var themeclr = jQuery(this).children('div').children('form').children('.custom_color').html();
        if(themeclr!='' && themeclr!= null){
            jQuery(this).css("border-top", "2px solid #" + themeclr + "");
            jQuery(this).children('div').children('form').children(".wwm-form-section").children("input").css("border", "1px solid #" + themeclr + "");
            jQuery(this).children('div').children('form').children(".wwm-form-section").children("input").css("background-color", "#fff !important");
            jQuery(this).children('div').children('form').children(".wwm-form-section").children(".wwm_input_field").children("input").css("border", "1px solid #" + themeclr + "");
            jQuery(this).children('div').children('form').children(".wwm-form-section").children(".wwm_input_field").children("span").children("input").css("border", "1px solid #" + themeclr + "");
            jQuery(this).children('div').children('form').children(".wwm-form-section").children(".wwm_input_field").children("select").css("border", "1px solid #" + themeclr + "");
            jQuery(this).children('div').children('form').children(".w_submit_btn").css("border", "none");
            jQuery(this).children('div').children('form').children(".w_submit_btn").css("background-color", "#" + themeclr);
            jQuery(this).children(".w_success").children("h6").css("color", "#" + themeclr);
            jQuery(this).children(".w_info").css("color", "#" + themeclr);
            jQuery(this).children("h4").css("color", "#" + themeclr);
        }

        //some style change for lang and accoutType
        if(jQuery("#w_accountType").val()=='2' && jQuery("#w_source_id").val()=='custom_form_plugin'){
            jQuery("label .error-wwm").css('color','#f33');
        }
        if(jQuery(this).children('div').children('form').children('input[name=language]').val()=='2') {
            jQuery(this).css('direction', 'rtl');
            jQuery(this).children('div').children('form').children(".w_submit_btn").css('margin-right','25%');
        }else {
            jQuery(this).children('div').children('form').children(".w_submit_btn").css('margin-left','25%');
        }
    });  //end each .wwm_widget_wrap

    // custom form country & phonecode change begin
    function loadCountryCodes(){
        jQuery.ajax({
            type: "GET",
            url: "/wp-content/plugins/wwm-registration-form-widget/lib/phonecountrycodes.csv",
            dataType: "text/csv",
            error: function(data){},
            success: function(data) {},
            complete: function(data){processData(data.responseText);}
        });
    }
    loadCountryCodes();
    var lines = [];
    function processData(allText) {
        var allTextLines = allText.split(".");
        for (var i=0; i<allTextLines.length; i++) {
            var data = allTextLines[i].split(',');
            lines[(i+3)] = data[1];
        }

        jQuery("select[name*='slt_country']").each(function(i){
            jQuery(this).change(function(){
            var countryid = jQuery(this).val();
            if(countryid !=='Select Country'){
                var countrycode = "+"+lines[countryid];
                jQuery(this).parent().parent().next().children('.wwm_input_field').children('span').children('input[name=phonecode]').val(countrycode);
            }
            else{ countrycode = "+";
                jQuery(this).parent().parent().next().children('.wwm_input_field').children('span').children('input[name=phonecode]').val(countrycode);
            }
            });
        });
    } //end phonecode change


    //form validation start
    function formValidation() {

        var register_form = jQuery('.customForm');

        register_form.each(function (i) {
            var $this = jQuery(this);

            var default_lang = jQuery(this).children("input[name='language']").val();
            var actType = jQuery(this).children("input[name='accountType']").val();

            if(default_lang=='2') {
                jQuery.validator.addMethod('pwdCheck',
                    function(value,element){
                        return this.optional(element) || /^(?=.*\d)(?=.*[a-zA-Z]).{8,30}$/.test(value);},"يجب أن تتكون كلمة السر من أحرف وأرقام معاً" );
                jQuery.validator.addMethod('unameSpaceChk',
                    function(value,element){
                        return this.optional(element) || /^\S+$/.test(value); },"لا يمكن أن تحتوي على اسم المستخدم الفضاء" );
                $this.validate({
                    errorClass: 'error-wwm',
                    rules: {
                        uname: { required: true, minlength: 2,unameSpaceChk:true},
                        fname: { required: true, minlength: 2},
                        lname: { required: true, minlength: 2},
                        email: { required: true, email: true},
                        phone: { required: true, number: true,minlength: 7},
                        pwd: { required: true, minlength: 8,pwdCheck:true},
                        postal: (actType == '2') ? "required" : "notrequired",
                        address: (actType == '2') ? "required" : "notrequired",
                        city: (actType == '2') ? "required" : "notrequired",
                        state: (actType == '2') ? "required" : "notrequired",
                        slt_language: (actType == '2') ? "digits" : "notdigits",
                        slt_country:{digits:true}
                    },
                    messages: {
                        uname: {required: 'اسم المستخدم مطلوب',minlength: 'يرجى كتابة حرفين على الأقل' },
                        fname: {required: 'اسمك الأول مطلوب',minlength: 'يرجى كتابة حرفين على الأقل'},
                        lname: {required: 'اسمك الأخير مطلوب',minlength: 'يرجى كتابة حرفين على الأقل' },
                        email: {required: 'إيميلك مطلوب',email: 'يرجى إدخال إيميل صحيح'},
                        phone: {required: 'رقم هاتفك مطلوب',number: 'يرجى كتابة أرقام فقط',minlength: 'يرجى كتابة 7 أرقام على الأقل'},
                        pwd: {required: "يجب أن تتألف كلمة السر من 8 خانات على الأقل",minlength: "لايمكن أن تكون كلمة السر أقل من 8 خانات"},
                        postal: {required: 'رمزك البريدي مطلوب'},
                        address: {required: 'عنوان منزلك مطلوب'},
                        city: {required: 'مدينتك مطلوبة'},
                        state: {required: 'محافظتك مطلوبة'},
                        slt_language: {digits: 'يرجى اختيار اللغة المفضلة'},
                        slt_country:{digits:"يرجى اختيار دولتك" }
                    },
                    submitHandler: function (form) {
                        var ajaxurl = wwmAjaxData.ajaxurl;
                        var platformID = $this.children("input[name='platformID']").val();
                        var pclink;
                        var mobilelink;
                        if (platformID == '1') {
                            pclink = '<a href="https://reports.onlineglobalmarkets.com/software/resources/DesktopTrader/desktoptrader.exe" target="_blank"><div class="w_pclink_btn">AlphaTrader Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank"><div class="w_mobile_btn">FlashTrader Web</div></a><span class="txt-11">(Mac® and Windows friendly)</span><div class="w_sltor">or</div><a href="https://alphatrader.mobi" target="_blank"><div class="w_pclink_btn">AlphaTrader Mobile</div></a><span class="txt-11">(Mobile phone friendly)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://alphatrader.mobi" target="_blank">iPhone</a>® | <a href="https://alphatrader.mobi" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">iPad</a>® | <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">Android</a>™</li></ul>';
                        } else if (platformID == '2') { //MT4
                            pclink = '<a href="http://d3fiu9susooo15.cloudfront.net/app/mt4/38A8F608F28E8028E9A76A9A24C918741747F173/1/wwm4setup.exe" target="_blank"><div class="w_pclink_btn">MetaTrader 4 Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank"><div class="w_mobile_btn">MetaTrader 4 iPhone</div></a><span class="txt-11">(iPhone, iPad and iPod Touch)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPhone</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPad</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li></ul>';
                        }
                        var dataString ='action=wwm_action&' + $this.serialize();
                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            cache: false,
                            data: dataString,
                            dataType: 'json',
                            success: function (data) {
                                if(data.isSuc=='1') {
                                    var login_msg = '<div class="w_success"><h6>تهانينا!</h6><p>حساب التداول الخاص بك WorldWideMarkets نشط الآن.</p></div><div class="w_step"><i class="w_step-num">1</i><span class="w_step-title"> تسجيل الدخول إلى حسابك</span></div><div class="w_info">Login:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">Password:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    var msg2 = '<p class="w_extraMsg">* هام: يرجى تسجيل أوراق اعتماد تسجيل الدخول الخاص بك، والمضي قدما لتحميل. تم بالبريد الإلكتروني تسجيل الدخول وكلمة المرور أيضا لك.</p><div class="w_step"><i class="w_step-num2"> 2 </i><span class="w_step-title"> اختيار منصة التداول</span></div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password).append(msg2).append(pclink).append(mobilelink).append(altlinks);
                                }else if(data.isSuc=='0'){
                                    var login_msg = '<div class="w_success"><h6>خطأ !</h6><p>حساب WorldWideMarkets الخاص بك هو فشل طلب التسجيل.</p></div><div class="w_step"><span class="w_step-title"> يرجى الاتصال WWM:<a href="mailto:backoffice@worldwidemarkets.com">backoffice@worldwidemarkets.com</a></span></div><div class="w_info">رسالة الخطأ:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">correlationID:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password);
                                }
                            }
                        });  //end ajax
                    }  // end submitHandler
                });
            }else if(default_lang=='3'){
                jQuery.validator.addMethod('pwdCheck',
                    function(value,element){
                        return this.optional(element) || /^(?=.*\d)(?=.*[a-zA-Z]).{8,30}$/.test(value);},"密码必须同时包含数字和密码" );
                jQuery.validator.addMethod('unameSpaceChk',
                    function(value,element){
                        return this.optional(element) || /^\S+$/.test(value); },"用户名不能包含空格" );
                $this.validate({
                    errorClass: 'error-wwm',
                    rules: {
                        uname: { required: true, minlength: 2,unameSpaceChk:true},
                        fname: { required: true, minlength: 2},
                        lname: { required: true, minlength: 2},
                        email: { required: true, email: true},
                        phone: { required: true, number: true,minlength: 7},
                        pwd: { required: true, minlength: 8,pwdCheck:true},
                        postal: (actType == '2') ? "required" : "notrequired",
                        address: (actType == '2') ? "required" : "notrequired",
                        city: (actType == '2') ? "required" : "notrequired",
                        state: (actType == '2') ? "required" : "notrequired",
                        slt_language: (actType == '2') ? "digits" : "notdigits",
                        slt_country:{digits:true}
                    },
                    messages: {
                        uname: {required: '请填写用户名',minlength: '用户名不能少于2个字符' },
                        fname: {required: '请填写您的名字',minlength: '名字不能少于2个字符'},
                        lname: {required: '请填写您的姓氏',minlength: '姓氏不能少于2个字符' },
                        email: {required: '请填写您的电子邮箱',email: '请输入有效的电子邮箱地址'},
                        phone: {required: '请输入您的电话号码',number: '请输入有效的电话号码',minlength: '您的电话号码不能少于7位'},
                        pwd: {required: "请输入密码",minlength: "您的密码不能少于8个字符"},
                        postal: {required: '请输入邮政编码'},
                        address: {required: '请输入街道地址'},
                        city: {required: '请输入城市'},
                        state: {required: '请输入省份或直辖市'},
                        slt_language: {digits: '请选择偏好语言'},
                        slt_country:{digits:"请选择国家" }
                    },
                    submitHandler: function (form) {
                        var ajaxurl = wwmAjaxData.ajaxurl;
                        var platformID = $this.children("input[name='platformID']").val();
                        var pclink;
                        var mobilelink;
                        if (platformID == '1') {
                          pclink = '<a href="https://reports.onlineglobalmarkets.com/software/resources/DesktopTrader/desktoptrader.exe" target="_blank"><div class="w_pclink_btn">AlphaTrader Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank"><div class="w_mobile_btn">FlashTrader Web</div></a><span class="txt-11">(Mac® and Windows friendly)</span><div class="w_sltor">or</div><a href="https://alphatrader.mobi" target="_blank"><div class="w_pclink_btn">AlphaTrader Mobile</div></a><span class="txt-11">(Mobile phone friendly)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://alphatrader.mobi" target="_blank">iPhone</a>® | <a href="https://alphatrader.mobi" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">iPad</a>® | <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">Android</a>™</li></ul>';
                        } else if (platformID == '2') { //MT4
                            pclink = '<a href="http://d3fiu9susooo15.cloudfront.net/app/mt4/38A8F608F28E8028E9A76A9A24C918741747F173/1/wwm4setup.exe" target="_blank"><div class="w_pclink_btn">MetaTrader 4 Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank"><div class="w_mobile_btn">MetaTrader 4 iPhone</div></a><span class="txt-11">(iPhone, iPad and iPod Touch)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPhone</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPad</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li></ul>';
                        }

                        var dataString ='action=wwm_action&' + $this.serialize();
                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            cache: false,
                            data: dataString,
                            dataType: 'json',
                            success: function (data) {
                              //  alert(dataString);
                                if(data.isSuc=='1') {
                                    var login_msg = '<div class="w_success"><h6>祝贺您!</h6><p>您的 WorldWideMarkets 交易账户现已激活.</p></div><div class="w_step"><i class="w_step-num">1</i><span class="w_step-title"> 登陆您的账户</span></div><div class="w_info">Login:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">Password:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    var msg2 = '<p class="w_extraMsg">*重要提示：请记录下您的登录凭据并继续下载。您的登录名和密码将通过电子邮件发送给您。</p><div class="w_step"><i class="w_step-num2"> 2 </i><span class="w_step-title"> 请选择交易平台</span></div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password).append(msg2).append(pclink).append(mobilelink).append(altlinks);
                                }else if(data.isSuc=='0'){
                                    var login_msg = '<div class="w_success"><h6>很抱歉，出现错误!</h6><p>您的 WorldWideMarkets 交易账户注册失败.</p></div><div class="w_step"><span class="w_step-title"> 请联系WWM: <a href="mailto:backoffice@worldwidemarkets.com">backoffice@worldwidemarkets.com</a></span></div><div class="w_info">Error Message:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">correlationID:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password);
                                }
                            }
                        });  //end ajax

                    }  // end submitHandler
                });
            }else if(default_lang=='4'){
                jQuery.validator.addMethod('pwdCheck',
                    function(value,element){
                        return this.optional(element) || /^(?=.*\d)(?=.*[a-zA-Z]).{8,30}$/.test(value);},"Пароль должен содержать как цифры, так и буквы" );
                jQuery.validator.addMethod('unameSpaceChk',
                    function(value,element){
                        return this.optional(element) || /^\S+$/.test(value);},"Имя пользователя не может содержать пространство" );
                $this.validate({
                    errorClass: 'error-wwm',
                    rules: {
                        uname: { required: true, minlength: 2,unameSpaceChk:true},
                        fname: {required: true, minlength: 2},
                        lname: { required: true, minlength: 2},
                        email: { required: true, email: true },
                        phone: {  required: true,  number: true, minlength: 7 },
                        pwd: {required: true, minlength: 8, pwdCheck:true },
                        postal: (actType == '2') ? "required" : "notrequired",
                        address: (actType == '2') ? "required" : "notrequired",
                        city: (actType == '2') ? "required" : "notrequired",
                        state: (actType == '2') ? "required" : "notrequired",
                        slt_language: (actType == '2') ? "digits" : "notdigits",
                        slt_country:{ digits:true }
                    },
                    messages: {
                        uname: { required: 'Ваше имя пользователя требуется', minlength: 'Пожалуйста, введите по крайней мере, 2 символов' },
                        fname: {required: 'Ваше имя требуется', minlength: 'Пожалуйста, введите по крайней мере, 2 символов' },
                        lname: { required: 'Ваша фамилия не требуется', minlength: 'Пожалуйста, введите по крайней мере, 2 символов' },
                        email: {required: 'Ваш адрес электронной почты требуется', email: 'Пожалуйста, введите верный адрес' },
                        phone: { required: 'Требуется Ваш номер телефона', number: 'Пожалуйста, вводите только цифры',minlength: 'Пожалуйста, введите по крайней мере, 7 цифр' },
                        pwd: { required: "Пароль требуется не менее 8 символов",minlength: "Пароль не может быть короче, чем 8 символов" },
                        postal: {required: 'Ваш почтовый код требуется'},
                        address: {required: 'Ваш адрес требуется'},
                        city: {required: 'Требуется Ваш город'},
                        state: {required: 'Требуется Ваше состояние'},
                        slt_language: {digits: 'Пожалуйста, выберите нужный язык'},
                        slt_country:{ digits:"Пожалуйста, выберите страну," }
                    },
                    submitHandler: function (form) {
                        var ajaxurl = wwmAjaxData.ajaxurl;
                        var platformID = $this.children("input[name='platformID']").val();
                        var pclink;
                        var mobilelink;
                        if (platformID == '1') {
                           pclink = '<a href="https://reports.onlineglobalmarkets.com/software/resources/DesktopTrader/desktoptrader.exe" target="_blank"><div class="w_pclink_btn">AlphaTrader Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank"><div class="w_mobile_btn">FlashTrader Web</div></a><span class="txt-11">(Mac® and Windows friendly)</span><div class="w_sltor">or</div><a href="https://alphatrader.mobi" target="_blank"><div class="w_pclink_btn">AlphaTrader Mobile</div></a><span class="txt-11">(Mobile phone friendly)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://alphatrader.mobi" target="_blank">iPhone</a>® | <a href="https://alphatrader.mobi" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">iPad</a>® | <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">Android</a>™</li></ul>';
                        } else if (platformID == '2') { //MT4
                            pclink = '<a href="http://d3fiu9susooo15.cloudfront.net/app/mt4/38A8F608F28E8028E9A76A9A24C918741747F173/1/wwm4setup.exe" target="_blank"><div class="w_pclink_btn">MetaTrader 4 Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank"><div class="w_mobile_btn">MetaTrader 4 iPhone</div></a><span class="txt-11">(iPhone, iPad and iPod Touch)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPhone</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPad</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li></ul>';
                        }
                        var dataString ='action=wwm_action&' + $this.serialize();
                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            cache: false,
                            data: dataString,
                            dataType: 'json',
                            success: function (data) {
                                if(data.isSuc=='1') {
                                    var login_msg = '<div class="w_success"><h6>Поздравляем!</h6><p>Ваше WorldWideMarkets торговый счет теперь активен.</p></div><div class="w_step"><i class="w_step-num">1</i><span class="w_step-title"> Войти в свой аккаунт</span></div><div class="w_info">Login:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">Password:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    var msg2 = '<p class="w_extraMsg">* Важно: Пожалуйста, запишите свой логин и пароль и нажмите кнопку скачать. Логин и пароль также по электронной почте к вам.</p><div class="w_step"><i class="w_step-num2"> 2 </i><span class="w_step-title"> Выберите торговую платформу</span></div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password).append(msg2).append(pclink).append(mobilelink).append(altlinks);
                                }else if(data.isSuc=='0'){
                                    var login_msg = '<div class="w_success"><h6>ошибка !</h6><p>Ваши WorldWideMarkets кабинет Регистрация просьба не удалось.</p></div><div class="w_step"><span class="w_step-title"> Пожалуйста, свяжитесь с WWM: <a href="mailto:backoffice@worldwidemarkets.com">backoffice@worldwidemarkets.com</a></span></div><div class="w_info">Сообщение об ошибке:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">correlationID:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password);
                                }
                            }
                        });  //end ajax
                    }  // end submitHandler
                });
            }else if(default_lang=='5'){
                jQuery.validator.addMethod('pwdCheck',
                    function(value,element){
                        return this.optional(element) || /^(?=.*\d)(?=.*[a-zA-Z]).{8,30}$/.test(value);},"La contraseña debe tener números y letras" );
                jQuery.validator.addMethod('unameSpaceChk',
                    function(value,element){
                        return this.optional(element) || /^\S+$/.test(value); },"Nombre de usuario no puede contener espacio");
                $this.validate({
                    errorClass: 'error-wwm',
                    rules: {
                        uname: { required: true, minlength: 2,unameSpaceChk:true},
                        fname: { required: true, minlength: 2},
                        lname: { required: true, minlength: 2},
                        email: { required: true, email: true},
                        phone: { required: true, number: true,minlength: 7},
                        pwd: { required: true, minlength: 8,pwdCheck:true},
                        postal: (actType == '2') ? "required" : "notrequired",
                        address: (actType == '2') ? "required" : "notrequired",
                        city: (actType == '2') ? "required" : "notrequired",
                        state: (actType == '2') ? "required" : "notrequired",
                        slt_language: (actType == '2') ? "digits" : "notdigits",
                        slt_country:{digits:true}
                    },
                    messages: {
                        uname: {required: 'Su contraseña es requerida',minlength: 'Por favor entre al menos dos caracteres' },
                        fname: {required: 'Su primer Nombre es requerido',minlength: 'Por favor entre al menos dos caracteres'},
                        lname: {required: 'Su apellido es requerido',minlength: 'Por favor entre al menos dos caracteres' },
                        email: {required: 'Su correo Electrónico es requerido',email: 'Por favor escriba su correo electrónico valido'},
                        phone: {required: 'Su número de Teléfono es requerido',number: 'Por favor escriba solo números',minlength: 'Por favor escriba al menos 7 dígitos'},
                        pwd: {required: "La contraseña requiere al menos 8 caracteres",minlength: "La contraseña no puede ser menor de 8 caracteres"},
                        postal: {required: 'Su código postal es requerido'},
                        address: {required: 'Su dirección es requerida'},
                        city: {required: 'Su ciudad es requerida'},
                        state: {required: 'Su estado es requerido'},
                        slt_language: {digits: 'Por favor seleccione su idioma'},
                        slt_country:{digits:"Por favor seleccione su país" }
                    },
                    submitHandler: function (form) {
                        var ajaxurl = wwmAjaxData.ajaxurl;
                        var platformID =$this.children("input[name='platformID']").val();
                        var pclink;
                        var mobilelink;
                        if (platformID == '1') {
                        pclink = '<a href="https://reports.onlineglobalmarkets.com/software/resources/DesktopTrader/desktoptrader.exe" target="_blank"><div class="w_pclink_btn">AlphaTrader Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank"><div class="w_mobile_btn">FlashTrader Web</div></a><span class="txt-11">(Mac® and Windows friendly)</span><div class="w_sltor">or</div><a href="https://alphatrader.mobi" target="_blank"><div class="w_pclink_btn">AlphaTrader Mobile</div></a><span class="txt-11">(Mobile phone friendly)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://alphatrader.mobi" target="_blank">iPhone</a>® | <a href="https://alphatrader.mobi" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">iPad</a>® | <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">Android</a>™</li></ul>';
                        } else if (platformID == '2') { //MT4
                            pclink = '<a href="http://d3fiu9susooo15.cloudfront.net/app/mt4/38A8F608F28E8028E9A76A9A24C918741747F173/1/wwm4setup.exe" target="_blank"><div class="w_pclink_btn">MetaTrader 4 Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank"><div class="w_mobile_btn">MetaTrader 4 iPhone</div></a><span class="txt-11">(iPhone, iPad and iPod Touch)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPhone</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPad</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li></ul>';
                        }
                        var dataString ='action=wwm_action&' + $this.serialize();
                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            cache: false,
                            data: dataString,
                            dataType: 'json',
                            success: function (data) {
                                if(data.isSuc=='1') {
                                    var login_msg = '<div class="w_success"><h6>¡Enhorabuena!</h6><p>WorldWideMarkets su cuenta de operaciones se ha activado.</p></div><div class="w_step"><i class="w_step-num">1</i><span class="w_step-title"> Ingrese a su cuenta</span></div><div class="w_info">Login:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">Password:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    var msg2 = '<p class="w_extraMsg">* Importante: Por favor, registre sus credenciales de inicio de sesión y proceder a la descarga. Nombre de usuario y la contraseña también fueron enviadas por correo electrónico.</p><div class="w_step"><i class="w_step-num2"> 2 </i><span class="w_step-title"> Elija una plataforma de negociación</span></div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password).append(msg2).append(pclink).append(mobilelink).append(altlinks);
                                }else if(data.isSuc=='0'){
                                    var login_msg = '<div class="w_success"><h6>Error !</h6><p>Sus WorldWideMarkets representan solicitud de registro se falla.</p></div><div class="w_step"><span class="w_step-title"> Póngase en contacto con WWM: <a href="mailto:backoffice@worldwidemarkets.com">backoffice@worldwidemarkets.com</a></span></div><div class="w_info">Error Mensaje:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">correlationID:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password);
                                }
                            }
                        });  //end ajax
                    }  // end submitHandler
                });
            }else{
                jQuery.validator.addMethod('pwdCheck',
                    function (value, element) {
                        return this.optional(element) || /^(?=.*\d)(?=.*[a-zA-Z]).{8,30}$/.test(value);
                    }, "Password must contain both numbers and letters"
                );
                jQuery.validator.addMethod('unameSpaceChk',
                    function (value, element) {
                        return this.optional(element) || /^\S+$/.test(value);
                    }, "Username cannot contain space"
                );
                $this.validate({
                    errorClass: 'error-wwm',
                    rules: {
                        uname: {required: true, minlength: 2, unameSpaceChk: true},
                        fname: {required: true, minlength: 2},
                        lname: {required: true, minlength: 2},
                        email: {required: true, email: true},
                        phone: {required: true, number: true, minlength: 7},
                        pwd: {required: true, minlength: 8, pwdCheck: true},
                        postal: (actType == '2') ? "required" : "notrequired",
                        address: (actType == '2') ? "required" : "notrequired",
                        city: (actType == '2') ? "required" : "notrequired",
                        state: (actType == '2') ? "required" : "notrequired",
                        slt_language: (actType == '2') ? "digits" : "notdigits",
                        slt_country: {digits: true}
                    },
                    messages: {
                        uname: {required: 'Your username is required', minlength: 'Please enter at least 2 characters'},
                        fname: {required: 'Your first name is required',minlength: 'Please enter at least 2 characters'},
                        lname: {required: 'Your last name is required',minlength: 'Please enter at least 2 characters' },
                        email: {required: 'Your email is required', email: 'Please enter a valid email address'},
                        phone: {required: 'Your phone number is required',number: 'Please enter only numbers',minlength: 'Please enter at least 7 digits'},
                        pwd: {required: "Password requires at least 8 characters",minlength: "Password cannot be shorter than 8 characters"},
                        postal: {required: 'Your postal code is required'},
                        address: {required: 'Your address is required'},
                        city: {required: 'Your city is required'},
                        state: {required: 'Your state is required'},
                        slt_language: {digits: 'Please select your preferred language'},
                        slt_country: {digits: "Please select a country"}
                    },
                    submitHandler: function (form) {

                        var ajaxurl = wwmAjaxData.ajaxurl;
                        var platformID = $this.children("input[name='platformID']").val();
                        var pclink;
                        var mobilelink;
                        if (platformID == '1') { // AT
                            pclink = '<a href="https://reports.onlineglobalmarkets.com/software/resources/DesktopTrader/desktoptrader.exe" target="_blank"><div class="w_pclink_btn">AlphaTrader Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank"><div class="w_mobile_btn">FlashTrader Web</div></a><span class="txt-11">(Mac® and Windows friendly)</span><div class="w_sltor">or</div><a href="https://alphatrader.mobi" target="_blank"><div class="w_pclink_btn">AlphaTrader Mobile</div></a><span class="txt-11">(Mobile phone friendly)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://alphatrader.mobi" target="_blank">iPhone</a>® | <a href="https://alphatrader.mobi" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">iPad</a>® | <a href="http://www.worldwidemarkets.com/launcherTrader/" target="_blank">Android</a>™</li></ul>';
                        } else if (platformID == '2') { //MT4
                            pclink = '<a href="http://d3fiu9susooo15.cloudfront.net/app/mt4/38A8F608F28E8028E9A76A9A24C918741747F173/1/wwm4setup.exe" target="_blank"><div class="w_pclink_btn">MetaTrader 4 Desktop</div></a><span class="txt-11">(Windows only)</span><div class="w_sltor">or</div>';
                            mobilelink = '<a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank"><div class="w_mobile_btn">MetaTrader 4 iPhone</div></a><span class="txt-11">(iPhone, iPad and iPod Touch)</span>';
							altlinks = '<ul class="margin-bottom-0"><li class="padding-bottom-5"><strong>PHONES</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPhone</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li><li class="padding-bottom-5"><strong>TABLETS</strong> <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596" target="_blank">iPad</a>® | <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4" target="_blank">Android</a>™</li></ul>';
                        }
                        var dataString ='action=wwm_action&' + $this.serialize();
                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            cache: false,
                            data: dataString,
                            dataType: 'json',
                            success: function (data) {
                                if(data.isSuc=='1') {
                                    var login_msg = '<div class="w_success"><h6>Congratulations!</h6><p>Your WorldWideMarkets trading account is now active.</p></div><div class="w_step"><i class="w_step-num">1</i><span class="w_step-title"> Log On to Your Account</span></div><div class="w_info">Login:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">Password:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    var msg2 = '<p class="w_extraMsg">*Important: Please record your Login credentials and proceed to download. Your Login and Password were also emailed to you.</p><div class="w_step"><i class="w_step-num2"> 2 </i><span class="w_step-title"> Choose a Trading Platform</span></div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password).append(msg2).append(pclink).append(mobilelink).append(altlinks);
                                }else if(data.isSuc=='0'){
                                    var login_msg = '<div class="w_success"><h6>Error !</h6><p>Your WorldWideMarkets account registration request is failed.</p></div><div class="w_step"><span class="w_step-title"> Please Contact WWM: <a href="mailto:backoffice@worldwidemarkets.com">backoffice@worldwidemarkets.com</a></span></div><div class="w_info">Error Message:</div>';
                                    var accname = data.acc;
                                    var accno = '<div class="w_returnInfo">' + accname + '</div>';
                                    var login_msg2 = '<div class="w_info">correlationID:</div>';
                                    var password = '<div class="w_returnInfo">' + data.password + '</div>';
                                    $this.parent().html(login_msg).append(accno).append(login_msg2).append(password);
                                }
                            }
                        });  //end ajax

                    }  // end event handler
                });
            }

        });

    }

    formValidation();            //excute formValidation


});  //end form validation & submit
