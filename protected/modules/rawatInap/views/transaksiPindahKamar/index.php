<?php $linkHalaman = CustomFunction::getUrlByMenuID(268); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pindahkamar-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
$this->breadcrumbs = array(
    'Transaksi Pindah Kamar'
);
$this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    tr td .add-on {
        margin: 0 !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Data <b>Pasien</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3')); ?></td>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                <td>
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPasienRIV,
                        'attribute' => 'no_rekam_medik',
                        'value' => '',
                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienRawatInap'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                  $("#' . CHtml::activeId($modPasienRIV, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                  $("#' . CHtml::activeId($modPasienRIV, 'umur') . '").val(ui.item.umur);     
                                  $("#' . CHtml::activeId($modPasienRIV, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
                                  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                  $("#' . CHtml::activeId($modPasienRIV, 'nama_pasien') . '").val(ui.item.nama_pasien);     
                                  $("#' . CHtml::activeId($modPasienRIV, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
                                  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
                                  $("#' . CHtml::activeId($modPasienRIV, 'nama_bin') . '").val(ui.item.nama_bin);   
                                  $("#' . CHtml::activeId($modPindahKamar, 'pasien_id') . '").val(ui.item.pasien_id);     
                                  $("#' . CHtml::activeId($modPindahKamar, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);    
                                  $("#' . CHtml::activeId($modPindahKamar, 'masukkamar_id') . '").val(ui.item.masukkamar_id);    
                                  $("#' . CHtml::activeId($modPindahKamar, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);}'
                        ),
                        'htmlOptions' => array('class' => 'span3', 'placeholder' => 'No. Rekam Medik',),
                    )); ?>
                </td>
            </tr>
            <tr>
                <td><label class="control-label">No. Pendaftaran</label></td>
                <td>
                    <?php echo CHtml::activeTextField($modPasienRIV, 'no_pendaftaran', array('readonly' => true, 'class' => 'span3')); ?>
                </td>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskelamin', array('readonly' => true, 'class' => 'span3')); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'umur', array('readonly' => true, 'class' => 'span3')); ?></td>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_pasien', array('readonly' => true, 'class' => 'span3')); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskasuspenyakit_nama', array('readonly' => true, 'class' => 'span3')); ?></td>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_bin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_bin', array('readonly' => true, 'class' => 'span3')); ?></td>
            </tr>
        </table>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pindah Kamar</b>
                </div>
            </div>
            <div class="panel-body">
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->errorSummary(array($modPindahKamar)); ?>
                        <?php echo $form->hiddenField($modPindahKamar, 'pasien_id'); ?>
                        <?php echo $form->hiddenField($modPindahKamar, 'pendaftaran_id'); ?>
                        <?php echo $form->hiddenField($modPindahKamar, 'pasienadmisi_id'); ?>
                        <?php echo $form->hiddenField($modPindahKamar, 'masukkamar_id'); ?>
                        <?php echo $form->dropDownListRow(
                            $modPindahKamar,
                            'ruangan_id',
                            CHtml::listData($modPindahKamar->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'),
                            array(
                                'empty' => '-- Pilih --',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onChange' => 'updateKamarRuangan(this.value)',
                                'class' => 'span3'
                            )
                        ); ?>
                        <?php echo $form->dropDownListRow(
                            $modPindahKamar,
                            'kamarruangan_id',
                            array(),
                            array(
                                'empty' => '-- Pilih --',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3'
                            )
                        ); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modPindahKamar, 'tglpindahkamar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modPindahKamar,
                                    'attribute' => 'tglpindahkamar',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'dtPicker3 span3',
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                )); ?>
                                <?php echo $form->error($modPindahKamar, 'tglpindahkamar'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPindahKamar, 'jampindahkamar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modPindahKamar,
                                    'attribute' => 'jampindahkamar',
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'tPicker3 span3',
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                )); ?>
                                <?php echo $form->error($modPindahKamar, 'jampindahkamar'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        $modPindahKamar->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php
                    $tips = array(
                        '0' => 'simpan',
                        '1' => 'ulang',
                    );
                    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>