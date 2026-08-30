<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    $modPesan = new GZPesanmenudietT();
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pesan Menu", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglpesanmenu',
                        'value'=>null,
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                               //  'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class'=>'tgl_rencanapemeriksaan required',
                                'style' => 'width: 150px;',
                        ),
                    ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Instalasi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData($modPesan->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                    'ajax' => array('type' => 'POST',
                        'url' => $this->createUrl('pesanmenudietT/setDropdownRuangan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                        'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($modPesan->getRuanganItems($model->instalasi_id), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearAll()')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Kelas', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif is true'), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearAll()')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'title' => 'Cari',
            'class' => 'btn btn-danger',
            'type' => 'submit', 'id' => 'btn_simpan', 'onclick' => 'CekCaraBayar();return false;'
        )
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
</div>

<?php 
    $this->endWidget();
?>