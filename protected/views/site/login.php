<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/login.js"></script>
<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
$bulan = date('m');
$tahun = date('Y');
$tgl = date('d');
$jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
$date = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun.'-'.$bulan.'-'.$tgl),'full',null);
$this->widget('bootstrap.widgets.BootAlert'); ?>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />



<div>
    <div class="innova">
        <img src="<?php echo Yii::app()->getBaseUrl('webroot').'/data/images/ehealthsys.png'; ?>" alt="SIMRS" />
    </div>
    <div class="tablet">
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'login-form',
                        'enableClientValidation'=>true,
//			        'focus'=>'#LoginForm_username',
                        'clientOptions'=>array(
                                'validateOnSubmit'=>true,
                        ),
                        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);')
                )); ?>
                <div class="place">
                    <table width="100%" class="time">
                        <tr>
                                <td width="70%"><?php echo $date ?></td>
                                <td style="text-align:center;"><span id="clock" style="line-height:17px;font-size:11.5px;text-align:center;"></span></td>
                        </tr>
                    </table>
                        <div class="row">
                                <div class="rowlabel">
                                        <?php echo $form->labelEx($model,'Nama Pemakai',array('class'=>'label-login')); ?>
                                </div>
                                <div class="rowfield">
                                        <?php echo $form->textField($model,'username',array('onBlur'=>'cekUsername(this)', 'onkeyup'=>"return $(this).focusNextInputField(event);",'autofocus'=>true)); ?>
                                                        <?php echo CHtml::hiddenField('user_id') ?>
                                        <?php echo $form->error($model,'username'); ?>
                                </div>
                        </div>

                        <div class="row">
                                <div class="rowlabel">
                                        <?php echo $form->labelEx($model,'Kata Kunci',array('class'=>'label-login')); ?><img id="capsLockNotice" class="ssdlogo" alt="Caps Lock Is ON" title="Caps Lock Is ON" src="<?php echo Yii::app()->request->baseUrl; ?>/images/capslock-notice.png">
                                </div>
                                <div class="rowfield">
                                        <?php echo $form->passwordField($model,'password',array('class'=>'input capLocksCheck', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?> 
                                        <?php echo $form->error($model,'password'); ?>
                                </div>
                        </div>
                        <div class="row">
                                <div class="rowlabel">
                                        <?php echo $form->labelEx($model, 'instalasi',array('class'=>'label-login')); ?>
                                </div>
                                <div class="rowfield">
                                        <?php 
//											LOAD BY AJAX echo $form->dropDownList($model, 'instalasi', CHtml::listData(InstalasiM::model()->findAll(), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);",
//                                                                                                'ajax'=>array(
//                                                                                                    'type'=>'POST',
//                                                                                                    'url'=>  CController::createUrl('site/dynamicRuangan'),
//                                                                                                    'update'=>'#LoginForm_ruangan',))); ?>
                                        <?php 
                                                                                    echo $form->dropDownList($model, 'instalasi', array(),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);",
                                                                                            'ajax'=>array(
                                                                                                'type'=>'POST',
                                                                                                'url'=>  CController::createUrl('site/dynamicRuangan'),
                                                                                                //'update'=>'#LoginForm_ruangan',
                                                                                                'success'=>'function(data) {updateRuangan(data);}'))); ?>
                                                <?php echo $form->error($model,'instalasi'); ?>
                                </div>
                        </div>
                        <div class="row">
                                <div class="rowlabel">
                                        <?php echo $form->labelEx($model, 'ruangan',array('class'=>'label-login')); ?>
                                </div>
                                <div class="rowfield">
                                        <?php //LOAD BY AJAX echo $form->dropDownList($model, 'ruangan', CHtml::listData(RuanganM::model()->getRuanganByInstalasi($model->instalasi), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                                        <?php echo $form->dropDownList($model, 'ruangan', array(),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);", 'onchange'=>'pilihModul(this)')); ?>
                                                <?php echo $form->error($model,'ruangan'); ?>
                                </div>
                        </div>
                        <div class="row">
                                <div class="rowlabel">
                                        <?php echo $form->labelEx($model, 'modul',array('class'=>'label-login')); ?>
                                </div>
                                <div class="rowfield">
                                        <?php //LOAD BY AJAX echo $form->dropDownList($model, 'modul', CHtml::listData(ModulK::model()->findAll(),'modul_id','modul_nama'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                                        <?php echo $form->dropDownList($model, 'modul', array(),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                                        <?php echo $form->error($model,'modul'); ?>
                                </div>
                        <div class="rowbutton">
                                <?php echo CHtml::htmlButton(Yii::t('Login','{icon} Masuk',array('{icon}'=>' <i class="icon-user icon-white"></i>')),array('class'=>'btn2 btn-login', 'type'=>'submit','onkeyup'=>"formSubmit(this,event)", "name"=>"login", "value"=>"login")); ?>
                                <?php echo CHtml::htmlButton(Yii::t('Forgot Password','{icon} Lupa Kata Kunci',array('{icon}'=>' <i class="icon-remove icon-white"></i>')),array(
                                    'class'=>'btn2 btn-login', 
                                    'type'=>'submit',
                                    'onkeyup'=>"formSubmit(this,event)", 
                                    "name"=>"forgot", "value"=>"forgot", 
                                    "onclick"=>"return confirm('Apakah Anda yakin, karena Anda lupa password ?')",
                                    "style"=>"margin-top: 20px;"
                                )); ?>
                                </div>
                        </div>

                        <div class="copy">
                                Copyright &copy; <?php echo date('Y'); ?> by eHealthsys.
                        </div>
                </div>
            <?php $this->endWidget(); ?>
            </div><!-- form -->

    </div>
</div>
<!--<div class="right">
	<div class="logo"></div>
	<div class="flash">
    	<?php $this->widget('bootstrap.widgets.BootCarousel', array(
			'items'=>array(
				array('image'=>Yii::app()->getBaseUrl('webroot').'/css/image1.jpg', 'label'=>''),
				array('image'=>Yii::app()->getBaseUrl('webroot').'/css/image2.jpg', 'label'=>''),
				array('image'=>Yii::app()->getBaseUrl('webroot').'/css/image3.jpg', 'label'=>''),
				array('image'=>Yii::app()->getBaseUrl('webroot').'/css/image4.jpg', 'label'=>''),
				array('image'=>Yii::app()->getBaseUrl('webroot').'/css/image5.jpg', 'label'=>''),
			),
		)); ?> 
		 <div class="welcome"></div> 
    </div>
<div class="tuta"></div>
</div>-->


<?php
$url = CController::createUrl('site/AjaxCekUsername');
$js = <<< JSCRIPT

   function cekUsername(obj){
        $.post("${url}", { username: obj.value},
        function(data){
            $('#user_id').val(data.id);
            $('#LoginForm_instalasi').html(data.instalasi)
            $('#LoginForm_ruangan').html(data.ruangan)
            $('#LoginForm_modul').html(data.modul)
        }, "json");
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('hapusPenjualan', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
var error = $('.close').length;
if(error > 0){
	$('#LoginForm_username').removeAttr('autofocus','1'); 
	$('#LoginForm_password').focus();
	getInstalasi();
	getRuangan();
}
function getInstalasi(){
	var username = $('#LoginForm_username').val();
	var instalasi = $('#LoginForm_instalasi').val();
	var ruangan = $('#LoginForm_ruangan').val();
	var modul = '<?php echo isset($_POST['LoginForm']['modul']) ? $_POST['LoginForm']['modul'] : null; ?>';
		
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('DynamicInstalasi'); ?>',
		data: {username : username, instalasi:instalasi, ruangan:ruangan, modul:modul},//
		dataType: "json",
		success:function(data){
			$('#LoginForm_instalasi').html(data.instalasi);
			$('#LoginForm_modul').html(data.modul);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}
function getRuangan(){
	var instalasi = $('#LoginForm_instalasi').val();
	
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('DynamicRuangan'); ?>',
		data: {instalasi:instalasi},//
		dataType: "json",
		success:function(data){
                    $('#LoginForm_ruangan').change();
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function updateRuangan(data) {
    $('#LoginForm_ruangan').html(data).change();
}


function pilihModul(obj) {
    var ruangan_id = $(obj).val();
    
    $.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('pilihModul'); ?>',
		data: {ruangan_id:ruangan_id},//
		dataType: "json",
		success:function(data){
                    $("#LoginForm_modul").val(data.modul_id);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
</script>