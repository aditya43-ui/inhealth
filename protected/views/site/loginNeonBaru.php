<?php
// $this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>
<!--<div class="error-a">
<?php //$this->widget('bootstrap.widgets.BootAlert'); 
?>
</div>-->

<style>
    .form-login-error {
        background: #fee2e2;
        border: 1px solid #f87171;
        border-radius: 10px;
        padding: 10px 15px;
        margin-bottom: 15px;
        color: #991b1b;
        display: none;
    }
    .form-login-error h3 {
        margin: 0 0 5px;
        font-size: 14px;
        font-weight: 700;
        color: #991b1b;
    }
    .form-login-error p {
        margin: 0;
        font-size: 12px;
    }

    .form-group {
        margin-bottom: 12px !important;
    }

    .form-control.log-input,
    .form-control.required,
    select.log-input {
        height: 40px !important;
        border-radius: 10px !important;
        border: 1.5px solid #c9ded7 !important;
        background-color: rgba(255, 255, 255, 0.95) !important;
        color: #1e3d34 !important;
        font-size: 13px !important;
        padding: 6px 12px !important;
        transition: all 0.25s ease !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
    }

    .form-control.log-input:focus,
    .form-control.required:focus,
    select.log-input:focus {
        border-color: #3d8b7a !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3.5px rgba(61, 139, 122, 0.18) !important;
        outline: none !important;
    }

    .cont-pass {
        display: flex !important;
        width: 100% !important;
        align-items: stretch !important;
        justify-content: space-between !important;
        border: 1.5px solid #c9ded7 !important;
        border-radius: 10px !important;
        background-color: rgba(255, 255, 255, 0.95) !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
        transition: all 0.25s ease !important;
    }

    .cont-pass:focus-within {
        border-color: #3d8b7a !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3.5px rgba(61, 139, 122, 0.18) !important;
    }

    .cont-pass .pass {
        flex: 1 1 auto !important;
        width: calc(100% - 42px) !important;
        display: flex !important;
        align-items: center !important;
    }

    .cont-pass .pass input {
        border: none !important;
        background: transparent !important;
        height: 38px !important;
        box-shadow: none !important;
        padding: 6px 12px !important;
        font-size: 13px !important;
        color: #1e3d34 !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .cont-pass .pass input:focus {
        box-shadow: none !important;
        border: none !important;
        outline: none !important;
    }

    .cont-pass .eye {
        flex: 0 0 42px !important;
        width: 42px !important;
        min-width: 42px !important;
        max-width: 42px !important;
        height: 38px !important;
        margin-left: auto !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        background-color: #f0f7f4 !important;
        color: #52796f !important;
        border-left: 1px solid #c9ded7 !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
    }

    .cont-pass .eye:hover {
        background-color: #e0f0eb !important;
        color: #1b4332 !important;
    }

    .btn.btn-login,
    button#login-button {
        background: linear-gradient(135deg, #2d6a4f 0%, #1b4332 100%) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 13.5px !important;
        letter-spacing: 0.6px !important;
        padding: 10px !important;
        border-radius: 10px !important;
        height: 42px !important;
        margin-top: 6px !important;
        box-shadow: 0 4px 14px rgba(27, 67, 50, 0.35) !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .btn.btn-login:hover,
    button#login-button:hover {
        background: linear-gradient(135deg, #1b4332 0%, #0d291e 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(27, 67, 50, 0.45) !important;
    }

    .btn.btn-login:active,
    button#login-button:active {
        transform: translateY(0) !important;
    }

    .error-a {
        font-size: 11px;
        color: #dc2626;
        margin-top: 2px;
    }
</style>
<div class="form-status">
    <div class="form-login-error">
        <h3>Login Gagal!</h3>
        <p><span id='message-login'></span></p>
    </div>
    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form_login',
            'focus' => array($model, 'username'),
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <div class="form-group">
            <?php
            echo $form->textField($model, 'username', array(
                'class' => 'log-input form-control required',
                'placeholder' => 'Nama Pemakai / Username',
                'autocomplete' => 'off',
                'onBlur' => 'cekUsername(this)',
                'onkeyup' => "disabledLogin();",
                'onfocus' => 'disabledLogin();',
                'onchange' => 'disabledLogin();'
            ));
            ?>
            <?php echo $form->error($model, 'username', array('class' => 'error-a')); ?>
        </div>
        <div class="form-group" id="show_hide_password">
            <div class="cont-pass">
                <div class="pass">
                    <?php
                    echo $form->passwordField($model, 'password', array(
                        'class' => 'form-control required',
                        'placeholder' => 'Kata Kunci / Password',
                        'autocomplete' => 'off',
                        'onBlur' => 'cekUsername(this)',
                        'onkeyup' => "disabledLogin();",
                        'onfocus' => 'disabledLogin();',
                        'onchange' => 'disabledLogin();'
                    ));
                    ?>
                </div>
                <div class="eye">
                    <div class="keymouse">
                        <i class="fa fa-eye-slash fa-lg" aria-hidden="true"></i>
                    </div>    
                </div>
            </div>
            <?php echo $form->error($model, 'password', array('class' => 'error-a')); ?>
        </div>
        <div class="form-group">
            <?php
            echo $form->dropDownList($model, 'instalasi', array(), array(
                'empty' => '-- Pilih Unit --',
                'class' => 'log-input form-control',
                'onkeyup' => "return $(this).focusNextInputField(event);",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => CController::createUrl('site/dynamicRuangan'),
                    'success' => 'function(data) {updateRuangan(data);}'
                )
            ));
            ?>
            <?php echo $form->error($model, 'instalasi'); ?>
        </div>
        <div class="form-group">
            <?php
            echo $form->dropDownList($model, 'ruangan', array(), array(
                'empty' => '-- Pilih Ruangan --',
                'class' => 'log-input form-control',
                'onkeyup' => "return $(this).focusNextInputField(event);",
                'onchange' => 'pilihModul(this)',
            ));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $form->dropDownList($model, 'modul', array(), array(
                'empty' => '-- Pilih Modul --',
                'class' => 'log-input form-control',
                'onkeyup' => "return $(this).focusNextInputField(event);",
                'onchange' => 'disabledLogin();',
                'onblur' => 'disabledLogin();',
            ));
            ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::tag('button', array('class' => 'btn btn-success btn-block btn-login', 'type' => 'submit', 'id' => 'login-button'), 'Masuk'); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<?php
$url = CController::createUrl('site/AjaxCekUsername');
$urlLupa = CController::createUrl('site/hitungLupaPassword');
$js = <<< JSCRIPT
   function cekUsername(obj){
        $.post("${url}", { username: $('#LoginForm_username').val()},
        function(data) {
            $('#user_id').val(data.id);
            user_id = data.id;
            $('#LoginForm_instalasi').html(data.instalasi);
            $('#LoginForm_ruangan').html(data.ruangan);
			//$("#LoginForm_ruangan").html("<option value=''>-- Pilih --</option>");
            $('#LoginForm_modul').html(data.modul);
			disabledLogin();
        }, "json");
   }
JSCRIPT;
Yii::app()->clientScript->registerScript('hapusPenjualan', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    var user_id = null;

    function formSubmit() {
        var selected = 0;
        $("select.required").each(function() {
            if ($(this).val() != "") {
                selected++;
            }
        });
        console.log(selected);
        if ($("input.required").val() === "" || $("input.required").val() === null || selected < 3) {
            myAlert('Silakan lengkapi form!');
            if ($("input.required").val() != "")
                setTimeout(function() {
                    $("#LoginForm_instalasi").focus();
                }, 500);
            else
                setTimeout(function() {
                    $("#LoginForm_username").focus();
                }, 500);
        } else {
            $('#login-form').submit();
        }
        return false;
    }

    function formForget() {
        if (!user_id) {
            myAlert("Pengguna tidak valid");
            return false;
        }
        $.post('<?php echo $urlLupa; ?>', {
            id: user_id
        }, function(data) {
            myAlert(data.warning);
        }, 'json');
    }

    function disabledLogin() {
        var user = jQuery("#LoginForm_username").val();
        var pass = jQuery("#LoginForm_password").val();
        var ruangan = jQuery("#LoginForm_ruangan").val();
        var instalasi = jQuery("#LoginForm_instalasi").val();
        var modul = jQuery("#LoginForm_modul").val();
        if (user == '' || pass == '' || ruangan == '' || instalasi == '' || modul == '') {
            //alert("wew");
            $("#login-button").attr("disabled", true);
        } else {
            $("#login-button").attr("disabled", false);
        }
    }

    function updateRuangan(data) {
        $('#LoginForm_ruangan').html(data).change();
        disabledLogin();
    }

    function pilihModul(obj) {
        var ruangan_id = $(obj).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('pilihModul'); ?>',
            data: {
                ruangan_id: ruangan_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#LoginForm_modul").val(data.modul_id);
                disabledLogin();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    $(function() {
        disabledLogin();
    });

    $(document).ready(function() {
        $("#show_hide_password .keymouse").on('mousedown', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').removeClass( "fa fa-eye" );
                $('#show_hide_password i').addClass("fa fa-eye-slash");
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa fa-eye-slash");
                $('#show_hide_password i').addClass( "fa fa-eye" );
            }
        });

        $("#show_hide_password .keymouse").on('mouseup', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa fa-eye-slash");
                $('#show_hide_password i').addClass( "fa fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').removeClass( "fa fa-eye" );
                $('#show_hide_password i').addClass("fa fa-eye-slash");
            }
        });
    });
</script>