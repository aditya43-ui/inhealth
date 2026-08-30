<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kupenggajianpeg-t-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'nomorindukpegawai'),
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nopenggajian',array('class'=>'span3')); ?>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'penggajianpeg_id',array('class'=>'span5')); ?>
<div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('PenggajianpegT/Informasi'), array('class'=>'btn btn-danger')); ?>
        <?php
            $content = $this->renderPartial('../tips/informasi_penggajianKaryawan',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
</div>

<?php $this->endWidget(); ?>
