<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'samodul-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SAModulK_modul_kategori',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow(
                    $model,
                    'modul_kategori',
                    LookupM::getItems('kategorimodul'),
                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAModulK_kelompokmodul_id','')")
                ); ?>
                <?php echo $form->dropDownListRow(
                    $model,
                    'kelompokmodul_id',
                    CHtml::listData($model->getKelompokModulItems(), 'kelompokmodul_id', 'kelompokmodul_nama'),
                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAModulK_modul_nama','')")
                ); ?>
                <?php echo $form->textFieldRow($model, 'modul_nama', array('placeholder' => 'Modul', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAModulK_modul_namalainnya','SAModulK_kelompokmodul_id')", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'modul_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAModulK_modul_fungsi','SAModulK_modul_nama')", 'maxlength' => 50)); ?>
                <?php echo $form->textAreaRow($model, 'modul_fungsi', array('placeholder' => 'Fungsi', 'rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAModulK_tglrevisimodul','SAModulK_modul_namalainnya')")); ?>

            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglrevisimodul', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglrevisimodul',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'span2', 'readonly' => true)
                        )); ?>
                        <?php echo $form->error($model, 'tglrevisimodul'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglupdatemodul', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglupdatemodul',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'span2', 'readonly' => true)
                        )); ?>
                        <?php echo $form->error($model, 'tglupdatemodul'); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'tglrevisimodul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); 
                ?>
                <?php //echo $form->textFieldRow($model,'tglupdatemodul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); 
                ?>

                <?php echo $form->dropDownListRow($model, 'url_modul', CustomFunction::getModules(), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAModulK_icon_modul','SAModulK_tglupdatemodul')", 'maxlength' => 50)); ?>
                <!--<div class="control-group">
                        <?php echo CHtml::label('Url', 'SAModulK_url_modul', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::textField('SAModulK[url_modul]', '', array('class' => 'span3', 'maxlength' => 50)); ?>
                            <?php echo CHtml::link('<i class="icon-edit icon-white"></i>', '#modalURL', array('class' => 'btn btn-danger', 'data-toggle' => 'modal')); ?>
                        </div>   
                    </div>-->
                <?php echo $form->fileFieldRow($model, 'icon_modul', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'hint' => 'Isi kolom untuk mengubah icon', 'readonly' => true)); ?>
                <div class="control-group">
                    <div class="controls">
                        <?php echo CHtml::image(Params::urlIconModulDirectory() . $model->icon_modul, 'Icon ' . $model->modul_nama, array()); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'modul_key', array('placeholder' => 'Modul Key', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'modul_urutan', array('placeholder' => 'Urutan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <div>
                    <div class="control-group">
                        <?php echo CHtml::label("", 'modul_aktif', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($model, 'modul_aktif', array()); ?>
                            <label for="SAModulK_modul_aktif">Aktif</label>
                        </div>
                    </div>
                    <?php //echo $form->checkBoxRow($model,'modul_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
                    ?>
                </div>
            </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Modul', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>