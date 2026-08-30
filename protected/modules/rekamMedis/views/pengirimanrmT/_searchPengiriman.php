<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'post',
    'id'=>'rkdokumenpasienrmlama-v-search',
    'type'=>'horizontal',
)); ?>
<fieldset class="box">
<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model, 'tglrekammedis', array('class' => 'span3')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPengiriman, 'tglrekammedis', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $modPengiriman->tgl_rekam_medik = MyFormatter::formatDateTimeForUser($modPengiriman->tgl_rekam_medik);
                    $modPengiriman->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForUser($modPengiriman->tgl_rekam_medik_akhir);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPengiriman,
                        'attribute' => 'tgl_rekam_medik',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPengiriman,
                        'attribute' => 'tgl_rekam_medik_akhir',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                    ));
					$modPengiriman->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($modPengiriman->tgl_rekam_medik);
                    $modPengiriman->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForDb($modPengiriman->tgl_rekam_medik_akhir);
                    ?>
                </div>
            </div>
            <?php //echo $form->textFieldRow($model, 'instalasi_nama', array('class' => 'span3', 'maxlength' => 50)); ?>
			<?php echo $form->textFieldRow($modPengiriman, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10)); ?>
            <div class="control-group">
                <?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPengiriman, 'no_rekam_medik_akhir', array('class' => 'span3', 'maxlength' => 10)); ?>
                </div>
            </div>
        </td>
        <td>
            
            <?php echo $form->textFieldRow($modPengiriman, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50)); ?>
            <?php //echo $form->dropDownListRow($model, 'statusrekammedis', LookupM::getItems('statusrekammedis')
//                    , array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 10)); ?>
            <?php echo $form->dropDownListRow($modPengiriman, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true)), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onchange'=>'getRuangan();')); ?>
         </td>
        <td>
            <?php echo $form->dropDownListRow($modPengiriman, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true)), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($modPengiriman, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 20)); ?>
        </td>
    </tr>
</table>

<?php //echo $form->textFieldRow($model,'warnadokrm_id',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'warnadokrm_namawarna',array('class'=>'span5','maxlength'=>20)); ?>

    <?php //echo $form->textFieldRow($model,'warnadokrm_kodewarna',array('class'=>'span5','maxlength'=>20)); ?>

    <?php //echo $form->textFieldRow($model,'lokasirak_id',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'lokasirak_nama',array('class'=>'span5','maxlength'=>100)); ?>

    <?php //echo $form->textFieldRow($model,'nodokumenrm',array('class'=>'span5','maxlength'=>20)); ?>
    <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span5')); ?>
    <?php //echo $form->textFieldRow($model,'tgl_rekam_medik',array('class'=>'span5')); ?>
<?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span5','maxlength'=>30)); ?>

    <?php // echo $form->textFieldRow($model,'jeniskelamin',array('class'=>'span5','maxlength'=>20)); ?>

    <?php //echo $form->textFieldRow($model,'tanggal_lahir',array('class'=>'span5')); ?>

    <?php //echo $form->textAreaRow($model,'alamat_pasien',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <?php //echo $form->textFieldRow($model,'tempat_lahir',array('class'=>'span5','maxlength'=>25)); ?>

    <?php //echo $form->textFieldRow($model,'tglmasukrak',array('class'=>'span5')); ?>
<?php //echo $form->textFieldRow($model,'nomortertier',array('class'=>'span5','maxlength'=>2)); ?>

    <?php //echo $form->textFieldRow($model,'nomorsekunder',array('class'=>'span5','maxlength'=>2)); ?>

    <?php //echo $form->textFieldRow($model,'nomorprimer',array('class'=>'span5','maxlength'=>2)); ?>

    <?php //echo $form->textFieldRow($model,'warnanorm_i',array('class'=>'span5','maxlength'=>50)); ?>

    <?php //echo $form->textFieldRow($model,'warnanorm_ii',array('class'=>'span5','maxlength'=>50)); ?>

    <?php //echo $form->textFieldRow($model,'tglkeluarakhir',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'tglmasukakhir',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'dokrekammedis_id',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span5')); ?>
<?php //echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span5')); ?>

    <div class="form-actions">
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
    </div>

<?php $this->endWidget(); ?>
</fieldset>

<script>
    function getRuangan(){
        var value = $('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id'); ?>').val();
        if (jQuery.isNumeric(value)){
            $.post('<?php echo $this->createUrl('getRuanganPasien'); ?>', {instalasi_id:value}, function(data){
                $('#<?php echo CHtml::activeId($modPengiriman, 'ruangan_id'); ?>').html('<option value="">-- Pilih --</option>'+data.dropDown);
            }, 'json');
        }
        else{
            
        }
    }
</script>