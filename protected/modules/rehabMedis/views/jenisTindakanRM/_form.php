<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Jenis Rehab Medis</b>
        </div>
    </div>
    <div class="panel-body">

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'rmjenis-tindakanrm-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($model, 'jenistindakanrm_nama'),
        )); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'jenistindakanrm_nama', array('placeholder' => 'Nama jenis tindakan', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'jenistindakanrm_namalainnya', array('placeholder' => 'Nama jenis tindakan lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                '',
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Tindakan', array('{icon}' => '<i class="icon-file icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
            $this->widget('UserTips', array('type' => 'create', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <script type="text/javascript">
            function namaLain(nama) {
                document.getElementById('RMJenisTindakanrmM_jenistindakanrm_namalainnya').value = nama.value.toUpperCase();
            }
        </script>
    </div>
</div>