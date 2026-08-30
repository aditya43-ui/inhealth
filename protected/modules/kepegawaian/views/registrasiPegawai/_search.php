<legend class="rim">Pencarian</legend>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapegawai-m-search',
        'type'=>'horizontal',
)); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3','maxlength'=>30)); ?>
                    <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>50)); ?>
                    <?php echo $form->dropDownListRow($model,'jabatan_id',CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'),array('class'=>'span3','maxlength'=>50, 'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'nipsampai',array('class'=>'span3','maxlength'=>30)); ?>
                    <?php echo $form->textFieldRow($model,'namasampai',array('class'=>'span3','maxlength'=>50)); ?>
                    <?php echo $form->dropDownListRow($model,'jabatansampai',CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'),array('class'=>'span3','maxlength'=>50, 'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($model,'kelompoksampai',CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                </td>
            </tr>
        </table>
	<div class="form-actions">
            <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-cancel"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); ?>
        </div>
<?php $this->endWidget(); ?>
