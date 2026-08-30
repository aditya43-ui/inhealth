<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakomponen-tarif-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#SAKomponenTarifM_komponentarif_nama',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php //echo $form->dropDownListRow($model, 'kelompokkomponentarif_id', 
            //  CHtml::listData(SAKelompokkomponentarifM::model()->findAll('kelompokkomponentarif_aktif = true order by kelompokkomponentarif_nama'), 'kelompokkomponentarif_id', 'kelompokkomponentarif_nama'),
            //  array('empty'=>'-- Pilh --', 'class'=>'span3')); 
            ?>
            <?php echo $form->textFieldRow($model, 'komponentarif_nama', array('placeholder' => 'Nama Komponen Tarif', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
            <?php echo $form->textFieldRow($model, 'komponentarif_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
            <?php echo $form->textFieldRow($model, 'komponentarif_urutan', array('placeholder' => '00', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

            <div class="control-group">
                <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'ispembayaranjasa', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => 'ispembayaranjasa')) . ' Komponen Pembayaran Jasa'; ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'komponentarif_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => 'komponentarif_aktif')) . ' Aktif'; ?>
                </div>
            </div>
            <?php //echo $form->checkBoxRow($model,'komponentarif_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>

        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'Instalasi', array('class' => 'control-label required')); ?>
        <div class="control-group">
            <div class="controls">

                <?php

                $this->widget(
                    'application.extensions.emultiselect.EMultiSelect',
                    array('sortable' => true, 'searchable' => true)
                );
                echo CHtml::dropDownList(
                    'instalasi_id[]',
                    '',

                    CHtml::listData(SAInstalasiM::model()->findAll(array('order' => 'instalasi_nama')), 'instalasi_id', 'instalasi_nama'),
                    array('multiple' => 'multiple', 'key' => 'instalasi_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                );
                ?>

            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="entypo-credit-card"></i> Persentase Kelompok Komponen Tarif</div>
    </div>
    <div class="panel-body table-responsive">

        <table class="table table-bordered table-condensed dataTable" id="detail-kelompok">
            <thead>
                <tr>
                    <th>Kelompok Komponen Tarif</th>
                    <th>Persentase</th>
                    <th style="text-align: center"><?php echo CHtml::link('<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>', '#', array(
                                                        'onclick' => 'tambahKelompok();return false;',
                                                        'class' => 'btn btn-danger',
                                                        'style' => 'color:white !important;'
                                                    )); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $kel = PersenkelkomponentarifM::model()->findAllByAttributes(array(
                    'komponentarif_id' => $model->komponentarif_id,
                ));
                foreach ($kel as $item) {
                    echo $this->renderPartial($this->path_view . '_rowKelKomponen', array('kel' => $item->kelompokkomponentarif_id, 'persen' => $item->persentase));
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl(
            Yii::app()->controller->id . '/admin',
            array('modul_id' => Yii::app()->session['modul_id'])
        ),
        array(
            'title' => 'Ulang', 
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Komponen Tarif', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array(), true); ?>