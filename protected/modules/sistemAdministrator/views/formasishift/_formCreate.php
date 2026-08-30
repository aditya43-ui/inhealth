<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saformasishift-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $modInstalasi,
                    'instalasi_id',
                    $instalasiTujuans,
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modInstalasi))),
                            'update' => '#ruangan_id',
                        )
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('ruangan_id', 'ruangan_id', $ruanganTujuans, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Shift', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('shift_id', 'shift_id', CHtml::listData(SAShiftM::model()->findAll(array('order' => 'shift_id'), 'shift_aktif = true'), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jumlah Formasi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('jmlformasi', '1', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                    'onclick' => 'tambahFormasi();return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "tambahFormasi();return false;",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan ruangan ke formasi",
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Formasi Shift</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="items table table-bordered table-striped table-condensed" id="table-formasiShift">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Ruangan</th>
                    <th>Shift</th>
                    <th>Jumlah Formasi</th>
                    <th>Aktif</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Formasi Shift', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit3b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>