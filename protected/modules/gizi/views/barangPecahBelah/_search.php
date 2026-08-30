<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'barangpecahbelah-t-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pencatatan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'Instalasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true)), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                    )
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', 'Ruangan', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'barangpecahbelah_no', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barangpecahbelah_no', array('placeholder' => 'No. Pencatatan', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $tips = array(
        '0' => 'cari',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>