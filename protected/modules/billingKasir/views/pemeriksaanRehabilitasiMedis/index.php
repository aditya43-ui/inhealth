<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
?>
<?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'table-riwayattindakan',
    'content' => array(
        'content-riwayattindakan' => array(
            'header' => '<b>Riwayat Tindakan</b>',
            'isi' => $this->renderPartial($this->path_view . '_tableRiwayatTindakan', array(
                'format' => $format,
                'modRiwayatTindakans' => $modRiwayatTindakans,
                'modPendaftaran' => $modPendaftaran
            ), true),
            'active' => true,
        ),
    ),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemeriksaanrehabilitasimedis-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#no_pendaftaran',
)); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data pemeriksaan pasien rehabilitasi medis berhasil disimpan!");
}
?>
<?php echo $form->errorSummary($modPasienMasukPenunjang); ?>
<fieldset>
    <div class="row">
        <div class="col-sm-6">
            <?php
            $kelaspelayanan_id = (!empty($modPasienAdmisi->kelaspelayanan_id) ? $modPasienAdmisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id);
            $carabayar_id = (!empty($modPasienAdmisi->carabayar_id) ? $modPasienAdmisi->carabayar_id : $modPendaftaran->carabayar_id);
            $penjamin_id = (!empty($modPasienAdmisi->penjamin_id) ? $modPasienAdmisi->penjamin_id : $modPendaftaran->penjamin_id);
            $instalasi_id = (!empty($modPasienAdmisi->ruangan->instalasi_id) ? $modPasienAdmisi->ruangan->instalasi_id : $modPendaftaran->ruangan->instalasi_id);
            $ruangan_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan_id : $modPendaftaran->ruangan_id);
            ?>
            <div style="display:none;">
                <?php echo Chtml::textField('pendaftaran_id', $modPendaftaran->pendaftaran_id, array('readonly' => true)); ?>
                <?php echo Chtml::textField('pasienadmisi_id', $modPasienAdmisi->pasienadmisi_id, array('readonly' => true)); ?>
                <?php echo Chtml::textField('kelaspelayanan_id', $kelaspelayanan_id, array('readonly' => true)); ?>
                <?php echo Chtml::textField('carabayar_id', $carabayar_id, array('readonly' => true)); ?>
                <?php echo Chtml::textField('penjamin_id', $penjamin_id, array('readonly' => true)); ?>
                <?php echo Chtml::textField('instalasi_id', $instalasi_id, array('readonly' => true)); ?>
                <?php echo Chtml::textField('ruangan_id', $ruangan_id, array('readonly' => true)); ?>
            </div>
            <fieldset id='content-pemeriksaan-lab' class=''>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Daftar Pemeriksaan Rehabilitas Medis
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $this->renderPartial($this->path_view . '_formCariPemeriksaan', array(
                            'modPemeriksaanRehab' => $modPemeriksaanRehab,
                        )); ?>
                        <div class='checklists'></div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan Rehabilitasi Medis</b>
                    </div>
                </div>
                <div class="panel-body">
                    <fieldset class="">
                        <?php echo $this->renderPartial('_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modKunjungan' => $modKunjungan, 'modPendaftaran' => $modPendaftaran, 'modPasienAdmisi' => $modPasienAdmisi)); ?>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <div id="form-tindakanpemeriksaan">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php
        if ($modPasienMasukPenunjang->isNewRecord) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
        }
        if (!isset($_GET['frame'])) {
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                "javascript:void(0);",
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'refreshHalaman();'
                )
            );
        }
        if (!isset($_GET['sukses'])) {
            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
        }
        $content = $this->renderPartial('tips/tipsPemeriksaanRehabilitasiMedis', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</fieldset>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPendaftaran' => $modPendaftaran, 'modPasienAdmisi' => $modPasienAdmisi, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan)); ?>