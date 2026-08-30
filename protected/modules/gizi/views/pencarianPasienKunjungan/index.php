<?php
//$arrMenu = array();
   //             array_push($arrMenu,array('label'=>Yii::t('mds','Search Patient'), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//$this->menu=$arrMenu;
//$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'caripasien-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));

Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form form').submit(function(){
	$.fn.yiiGridView.update('pencarianpasien-grid', {
		data: $(this).serialize()
	});
	return false;
});
");?>
<fieldset>
    <legend class="rim2">Informasi Pasien Kunjungan</legend>
	 <legend class="rim">Asal Instalasi</legend>
    <table style="width: 100%; border: none;">
    <tr>
        <td><?php echo CHtml::radioButton('instalasi', $cekRJ, array('value'=>'RJ','onClick'=>'submitForm(this)','class'=>'ceklis')) ?> Rawat Jalan</td>
        <td><?php echo CHtml::radioButton('instalasi', $cekRI, array('value'=>'RI','onClick'=>'submitForm(this)','class'=>'ceklis')) ?> Rawat Inap</td>
        <td><?php echo CHtml::radioButton('instalasi', $cekRD, array('value'=>'RD','onClick'=>'submitForm(this)','class'=>'ceklis')) ?> Rawat Darurat</td>
    </tr>
</table>
</fieldset>
<?php 
     if($cekRJ == TRUE)
     {
       echo $this->renderPartial('_formCariRJ', array('model'=>$modRJ,'form'=>$form),true); 
     }
     elseif($cekRI == TRUE)
     {
       
       echo $this->renderPartial('_formCariRI', array('model'=>$modRI,'form'=>$form),true); 
     }
     elseif($cekRD == TRUE)
     {
       echo $this->renderPartial('_formCariRD', array('model'=>$modRD,'form'=>$form),true); 
     }
?>

      
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
); ?>
			<?php 
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>

    </div>


<?php $this->endWidget(); ?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$cetak = Yii::app()->createUrl('pendaftaranPenjadwalan/pencarianPasien/printKartu',array('id'=>''));
$js = <<< JSCRIPT
function submitForm(obj)
{
    $('#patokanInstalasi').val(obj.value);
    $(obj).closest('form').submit();
}
// ==* Fungsi Print *== //

function print(id,umur)
   {    
               window.open('${url}/printKartu/id/'+id+'/umur/'+umur,'printwin','left=100,top=100,width=355,height=255,scrollbars=0');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('jsPencarianPasien',$js, CClientScript::POS_HEAD);
?>

<?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $urlDaftarKunjungan=Yii::app()->createAbsoluteUrl($module.'/pendaftaranPasienKunjungan/index');
$js = <<< JSCRIPT

function daftarPasienKunjungan(pendaftaran_id)
{
    $('#pendaftaran_id').val(pendaftaran_id);
    $('#form_hidden').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php $forms=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'form_hidden',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'action'=>$urlDaftarKunjungan,
        'htmlOptions'=>array('target'=>'_new'),
)); ?>
<?php echo CHtml::hiddenField('pendaftaran_id');?>
<?php $this->endWidget(); ?>

