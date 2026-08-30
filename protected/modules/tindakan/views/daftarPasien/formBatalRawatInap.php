<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
$pasienAdmisi = $modPendaftaran->pasienadmisi_id;
if (!empty($pasienAdmisi)) {
    $admisi = PasienadmisiT::model()->findByPk($pasienAdmisi);
    $ruangan = RuanganM::model()->findByPk($admisi->ruangan_id);
?>
    <br>
    <br>
    <div align="center" style="font-size: 14px;">
        <br>
        <br>
        <br>
        <br>
        <br>
        Maaf Anda tidak dapat melakukan pembatalan Pasien : <b><?php echo $modPasien->nama_pasien; ?> </b>disini,<br>
        Pasien sudah di rawat inap di ruangan <b><?php echo $ruangan->ruangan_nama; ?></b> pada tanggal <b><?php echo $admisi->tgladmisi; ?></b><br>
        Silakan hubungi petugas Ruangan Rawat Inap yang bersangkutan ?
    </div>
    <div id=""></div>
    <div class="form-actions" align="center">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Yes', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => "parent.$('#dialogBatalRawatInap').dialog('close');")
        ); ?> </div>
<?php } else {
?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'batalrawatinap-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'method' => 'POST',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#',
    ));
    $this->widget('bootstrap.widgets.BootAlert');
    echo $form->errorSummary(array($modPasienBatalPulang)); ?>

    <div class="row">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-file-alt"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">

                <table class="table table-condensed">
                    <?php
                    echo CHtml::hiddenField('pendaftaran_id', $modPendaftaran->pendaftaran_id);
                    echo CHtml::hiddenField('pasienpulang_id', $modPendaftaran->pasienpulang_id);
                    ?>
                    <tr>
                        <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                        <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?> </td>
                        <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik') ?></td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')) ?></td>
                        <td>
                            <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                        </td>

                        <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                        <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
                    </tr>
                    <tr>
                        <td><?php //echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_nama',array('class'=>'control-label')); 
                            echo CHtml::label('Jenis Kasus Penyakit', 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?></td>

                        <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-ban"></i> Alasan Batal <?php $pulang = PasienpulangT::model()->findByPk($modPendaftaran->pasienpulang_id);
                                                            echo isset($pulang->carakeluar_id) ? ucwords(strtolower($pulang->carakeluar->carakeluar_nama)) : ""; ?>
                </div>
            </div>
            <div class="panel-body">

                <div class="control-group">
                    <?php echo $form->labelEx($modPasienBatalPulang, 'tglpembatalan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPasienBatalPulang,
                            'attribute' => 'tglpembatalan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'timeFormat' =>  Params::TIME_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => 'dtPicker3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                        )); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modPasienBatalPulang, 'alasanpembatalan'); ?>


                <div class="form-actions">
                    <?php
                    $disableSave = false;
                    $disableSave = (($tersimpan == 'Ya') ? true : false);
                    ?>
                    <?php $disablePrint = ($disableSave) ? false : true; ?>
                    <?php echo CHtml::htmlButton(
                        $modPasienBatalPulang->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        'javascript:void(0);',
                        array(
                            'class' => 'btn btn-default',
                            'onclick' => 'closeDialog(); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/transaksi', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->endWidget();
    //if($tersimpan=='Ya'){
    ?>
    <script>
        //parent.location.reload();
        function closeDialog() {
            myConfirm("Apakah Anda ingin mengulang", "perhatian!", function(r) {
                if (r) {
                    window.location.href = window.location.href;
                }
            });
        }
    </script>
<?php
    //}
}
?>