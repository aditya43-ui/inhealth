<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>
<!--<div class="error-a">
	<?php //$this->widget('bootstrap.widgets.BootAlert'); 
    ?>
</div>-->
<div class="form-status">
    <div class="form-login-error">
        <h3>Login Gagal!</h3>
        <p><span id='message-login'></span></p>
    </div>
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form_login',
            'focus' => array($model, 'username'),
            //			'enableClientValidation'=>true,
            //'clientOptions'=>array(
            //	'validateOnSubmit'=>true,
            //	),
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>
        <div class="form-group" style="border-bottom: 2px solid #000;">
            <div class="input-group" data-original-title="Nama login" data-placement="left" data-toggle="tooltip">
                <div class="input-group-addon">
                    <?php echo CHtml::image('data/images/use.png', 'username', array('width' => '100%')) ?>
                </div>
                <?php echo $form->textField($model, 'username', array(
                    'class' => 'log-input form-control required',
                    'placeholder' => 'Username',
                    'autocomplete' => 'off',
                    'onBlur' => 'cekUsername(this)',
                    'onkeyup' => "disabledLogin();",
                    'onfocus' => 'disabledLogin();',
                    'onchange' => 'disabledLogin();'
                )); ?>
                <?php echo $form->error($model, 'username', array('class' => 'error-a')); ?>
            </div>
        </div>
        <div class="form-group" style="border-bottom: 2px solid #000;">
            <div class="input-group" data-original-title="Password" data-placement="left" data-toggle="tooltip">
                <div class="input-group-addon">
                    <?php echo CHtml::image('data/images/w.png', 'username', array('width' => '100%')) ?>
                </div>
                <?php echo $form->passwordField($model, 'password', array(
                    'class' => 'log-input form-control required',
                    'placeholder' => 'Password',
                    'autocomplete' => 'off',
                    'autocomplete' => 'off',
                    'onBlur' => 'cekUsername(this)',
                    'onkeyup' => "disabledLogin();",
                    'onfocus' => 'disabledLogin();',
                    'onchange' => 'disabledLogin();'
                )); ?>
                <?php echo $form->error($model, 'password', array('class' => 'error-a')); ?>
            </div>
        </div>
        <div class="form-group" style="border-bottom: 2px solid #000;">
            <div class="input-group" data-original-title="Instalasi" data-placement="left" data-toggle="tooltip">
                <div class="input-group-addon">
                    <?php echo CHtml::image('data/images/instalasi.png', 'instalasi', array('width' => '100%')) ?>
                </div>
                <?php echo $form->dropDownList($model, 'instalasi', array(), array(
                    'empty' => '-- Pilih --',
                    'class' => 'log-input form-control styled-select.slate',
                    'onkeyup' => "return $(this).focusNextInputField(event);",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' =>  CController::createUrl('site/dynamicRuangan'),
                        'success' => 'function(data) {updateRuangan(data);}'
                    )
                )); ?>
                <?php echo $form->error($model, 'instalasi'); ?>
            </div>
        </div>
        <div class="form-group" style="border-bottom: 2px solid #000;">
            <div class="input-group" data-original-title="Ruangan" data-placement="left" data-toggle="tooltip">
                <div class="input-group-addon">
                    <?php echo CHtml::image('data/images/ruangan.png', 'ruangan', array('width' => '100%')) ?>
                </div>
                <?php echo $form->dropDownList($model, 'ruangan', array(), array(
                    'empty' => '-- Pilih --',
                    'class' => 'log-input form-control select-style',
                    'onkeyup' => "return $(this).focusNextInputField(event);",
                    'onchange' => 'pilihModul(this)',
                    //	'ajax'=>array(
                    //		'type'=>'POST',
                    //			'url'=>  CController::createUrl('site/dynamicModul'),
                    //		'update'=>'#LoginForm_modul')
                )); ?>
            </div>
        </div>
        <div class="form-group" style="border-bottom: 2px solid #000;">
            <div class="input-group" data-original-title="Modul" data-placement="left" data-toggle="tooltip">
                <div class="input-group-addon">
                    <?php echo CHtml::image('data/images/modul.png', 'modul', array('width' => '100%')) ?>
                </div>
                <?php echo $form->dropDownList($model, 'modul', array(), array(
                    'empty' => '-- Pilih --',
                    'class' => 'form-control log-input  select-style',
                    'onkeyup' => "return $(this).focusNextInputField(event);",
                    'onchange' => 'disabledLogin();',
                    'onblur' => 'disabledLogin();',
                )); ?>
            </div>
        </div>
        <!--<div class="form-group">
	<?php echo $form->checkBox($model, 'rememberMe', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->label($model, 'rememberMe'); ?>
	<?php echo $form->error($model, 'rememberMe'); ?>
</div>-->
        <br />
        <div class="form-group">
            <div class="col-sm-6">
                <?php //echo CHtml::HtmlButton('<center><i class="entypo-login"></i> <span>Masuk</span></center>',array('class'=>'btn btn-success btn-block btn-login','onKeypress'=>'formSubmit();', 'onClick'=>'formSubmit();')); 
                ?>
                <?php echo CHtml::tag('button', array('class' => 'btn btn-success btn-block btn-login', 'type' => 'submit', 'id' => 'login-button'), 'Masuk'); ?>
            </div>
            <div class="col-sm-6">
                <?php echo CHtml::HtmlButton('<center><i class="entypo-help"></i> <span>Lupa Password</span></center>', array('class' => 'btn btn-danger btn-block btn-login', 'onKeypress' => 'formForget();', 'onClick' => 'formForget();')); ?>
                <?php //echo Chtml::link(CHtml::HtmlButton('<center><i class="glyphicon glyphicon-registration-mark"></i> <span>Registrasi Demo</span></center>',array('class'=>'btn btn-danger btn-block btn-login')), array('site/registrasi')); 
                ?>
            </div>
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
</script>