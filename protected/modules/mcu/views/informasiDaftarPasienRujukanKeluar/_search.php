<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
    'htmlOptions' => array(),
));
?>
<fieldset class="row box">
    <div class="rim"><i class="entypo-search"></i> Pencarian</div>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3', 'maxlength' => 20)); ?>
                    <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span3', 'maxlength' => 10)); ?>
                    <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'maxlength' => 50)); ?>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label for="namaPasien" class="control-label">Status Periksa</label>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="namaPasien" class="control-label">Dokter Penanggung Jawab</label>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'nama_pegawai', CHtml::listData(DokterV::model()->findAll(), 'nama_pegawai', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions" style="padding: 5px 0px 20px 20px">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
        );
        ?>
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
        $content = $this->renderPartial('tips/informasiPasienRujukKeluar', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>