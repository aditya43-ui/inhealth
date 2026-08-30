<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'guinvjalan-t-search',
    'type' => 'horizontal',
)); ?>
<br>
 <div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'invjalan_kode',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik kode')); ?>
        <?php echo $form->textFieldRow($model,'invjalan_noregister',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik no. register')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'invjalan_namabrg',array('class'=>'span3','maxlength'=>100,'placeholder'=>'Ketik nama barang')); ?>
    </div>
</div>

<?php //echo $form->textFieldRow($model,'invjalan_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'pemilikbarang_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'asalaset_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'barang_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'lokasi_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_kontruksi',array('class'=>'span3','maxlength'=>20)); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_panjang',array('class'=>'span3','maxlength'=>30)); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_lebar',array('class'=>'span3','maxlength'=>30)); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_luas',array('class'=>'span3','maxlength'=>30)); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_letak',array('class'=>'span3','maxlength'=>30)); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_tgldokumen',array('class'=>'span3')); 
?>

<?php // echo $form->textFieldRow($model,'invjalan_tglguna',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_nodokumen',array('class'=>'span3','maxlength'=>30)); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_statustanah',array('class'=>'span3','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_keadaaan',array('class'=>'span3','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_harga',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'invjalan_akumsusut',array('class'=>'span3')); 
?>

<?php // echo $form->textFieldRow($model,'invjalan_ket',array('class'=>'span3','maxlength'=>100)); 
?>

<?php //echo $form->textFieldRow($model,'craete_time',array('class'=>'span3')); 
?>

<?php // echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); 
?>

<?php // echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class'=>'btn btn-default',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php  
		$content = $this->renderPartial('/tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>

<?php $this->endWidget(); ?>