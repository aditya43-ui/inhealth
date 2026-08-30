<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'sajenis-profilrumahsakit-m-search',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'nama_rumahsakit',array('class'=>'span3','maxlength'=>25)); ?>
            <?php echo $form->textAreaRow($model,'alamatlokasi_rumahsakit',array('rows'=>6, 'cols'=>30, 'class'=>'span4')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'website',array('class'=>'span3','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'email',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'profilrs_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'tahunprofilrs',array('class'=>'span5','maxlength'=>4)); ?>

	<?php //echo $form->textFieldRow($model,'kodejenisrs_profilrs',array('class'=>'span5','maxlength'=>1)); ?>

	<?php //echo $form->textFieldRow($model,'jenisrs_profilrs',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'statusrsswasta',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'namakepemilikanrs',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'kodestatuskepemilikanrs',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'statuskepemilikanrs',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'pentahapanakreditasrs',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'statusakreditasrs',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'nokode_rumahsakit',array('class'=>'span5','maxlength'=>10)); ?>

	<?php //echo $form->textFieldRow($model,'kelas_rumahsakit',array('class'=>'span5','maxlength'=>1)); ?>

	<?php //echo $form->textFieldRow($model,'namadirektur_rumahsakit',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'nomor_suratizin',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'tgl_suratizin',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'oleh_suratizin',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textFieldRow($model,'sifat_suratizin',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'masaberlakutahun_suratizin',array('class'=>'span5','maxlength'=>4)); ?>

	<?php //echo $form->textAreaRow($model,'motto',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textAreaRow($model,'visi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'no_faksimili',array('class'=>'span5','maxlength'=>15)); ?>

	<?php //echo $form->textFieldRow($model,'logo_rumahsakit',array('class'=>'span5','maxlength'=>254)); ?>

	<?php //echo $form->textFieldRow($model,'path_logorumahsakit',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'npwp',array('class'=>'span5','maxlength'=>25)); ?>

	<?php //echo $form->textFieldRow($model,'tahun_diresmikan',array('class'=>'span5','maxlength'=>4)); ?>

	<?php //echo $form->textFieldRow($model,'nama_kepemilikanrs',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textFieldRow($model,'status_kepemilikanrs',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'khususuntukswasta',array('class'=>'span5','maxlength'=>1)); ?>

	<?php //echo $form->textFieldRow($model,'no_telp_profilrs',array('class'=>'span5','maxlength'=>15)); ?>

	<div class="form-actions"> 
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
