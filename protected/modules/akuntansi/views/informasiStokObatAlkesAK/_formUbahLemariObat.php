<fieldset class="box">
    <legend class="rim">Ubah Data Lokasi Obat </legend>
    <?php
    $disabled = true;
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
                    $disabled = false;
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <br>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'ubahLokasiObat-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            )
        );
    ?>
    <?php echo $form->errorSummary($modViewStokOA); ?>

    <div class="row">
            <div class="span8">
                    <?php echo $form->textFieldRow($modViewStokOA, 'ruangan_nama',array('readonly'=>true)); ?>
                    <?php echo $form->textFieldRow($modViewStokOA, 'obatalkes_nama',array('readonly'=>true)); ?>
            </div>
    </div>
    <fieldset class="box2">
        <legend class="rim">Data Lokasi Obat </legend>
        <div class="row">
                <div class="span5">
                        <?php echo $form->dropDownListRow($modViewStokOA,'lokasiobat_id', CHtml::listData($modLokasiObat->getLokasiObatItems(), 'lokasiobat_id', 'lokasiobat_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;')); ?>
                        <?php echo $form->dropDownListRow($modViewStokOA,'rakobat_id', CHtml::listData($modRakObat->getRakObatItems(), 'rakobat_id', 'rakobat_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;')); ?>
                </div>	
                <div class="span5">
                        <div class="control-group">
                                <?php echo CHtml::label('Lokasi Obat Baru','tglfaktur', array('class'=>'control-label')) ?>
                                <div class="controls">
                                        <?php echo CHtml::dropDownList('lokasiobat_id','lokasiobat_id', CHtml::listData($modLokasiObat->getLokasiObatItems(), 'lokasiobat_id', 'lokasiobat_nama') ,array('disabled'=>false,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;')); ?>
                                </div>
                        </div>
                        <div class="control-group">
                                <?php echo CHtml::label('Rak Obat Baru','tglfaktur', array('class'=>'control-label')) ?>
                                <div class="controls">
                                        <?php echo CHtml::dropDownList('rakobat_id','rakobat_id', CHtml::listData($modRakObat->getRakObatItems(), 'rakobat_id', 'rakobat_nama') ,array('disabled'=>false,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;')); ?>
                                </div>
                        </div>
                </div>
        </div>
    </fieldset>
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','disabled'=>!$disabled,'onKeypress'=>'return formSubmit(this,event)'));
        ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                                                                                            Yii::app()->createUrl('gudangFarmasi/InformasiStokObatAlkes/ubahLokasiObat&obatalkes_id='.$modViewStokOA->obatalkes_id.'&ruangan_id='.$modViewStokOA->ruangan_id), 
                                                                                                            array('class' => 'btn btn-default',
                                                                                                             'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
    <?php $this->endWidget(); ?>
</fieldset>