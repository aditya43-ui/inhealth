<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'guinvtanah-t-search',
	'type' => 'horizontal',
)); ?>
<br>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'invtanah_kode',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik kode tanah')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'invtanah_noregister',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik no. register')); ?>
        </td>
        
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'invtanah_namabrg',array('class'=>'span3','maxlength'=>100,'placeholder'=>'Ketik nama barang')); ?>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'invtanah_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'pemilikbarang_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'barang_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'asalaset_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'lokasi_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'invtanah_luas',array('class'=>'span3','maxlength'=>30)); 
?>

<?php //echo $form->textFieldRow($model,'invtanah_thnpengadaan',array('class'=>'span3','maxlength'=>5)); 
?>

<?php // echo $form->textFieldRow($model,'invtanah_tglguna',array('class'=>'span3')); 
?>

<?php // echo $form->textAreaRow($model,'invtanah_alamat',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); 
?>

<?php // echo $form->textFieldRow($model,'invtanah_status',array('class'=>'span3','maxlength'=>50)); 
?>

<?php // echo $form->textFieldRow($model,'invtanah_tglsertifikat',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'invtanah_nosertifikat',array('class'=>'span3','maxlength'=>100)); 
?>

<?php ///echo $form->textFieldRow($model,'invtanah_penggunaan',array('class'=>'span3','maxlength'=>100)); 
?>

<?php //echo $form->textFieldRow($model,'invtanah_harga',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'invtanah_ket',array('class'=>'span3','maxlength'=>100)); 
?>

<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); 
?>

<?php ///echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); 
?>

<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); 
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