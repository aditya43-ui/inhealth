<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Bedah Sentral' => Yii::app()->request->getUrlReferrer(),
    'Rencana Operasi',
);

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

Yii::app()->clientScript->registerScript('cariwew', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarpasien-v-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rencanaoperasi-form',
    'enableAjaxValidation' => false, // Ini yang bikin gw jadi gila selama 3 hari (from TRUE to FALSE)
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'requiredCheck(this); '),
    'focus' => '#no_pendaftaran',
)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Rencana Operasi
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data rencana operasi berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert');
        }
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Rujukan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
            </div>
        </div>

        <div class="row" style="margin-top: 17px;">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Rencana Operasi</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('_formRencanaOperasi', array('form' => $form, 'modRencanaOperasi' => $modRencanaOperasi)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan Bedah Sentral</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label("Dokter Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('pegawai_id', $modKunjungan->pegawai_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::textField('nama_pegawai', $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("PPDS Perujuk", 'ppds_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('ppds_id', $modKunjungan->ppds_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::textField('ppds_nama', $modKunjungan->ppds_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Catatan Dokter Perujuk", 'catatandokterpengirim', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textArea('catatandokterpengirim', $modKunjungan->catatandokterpengirim, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo CHtml::label("Cyto", 'is_cyto', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php 
                                    
                                    if($modKunjungan->is_cyto == 1){
                                        $modKunjungan->is_cyto = 'Cyto';
                                        echo CHtml::textField('is_cyto', $modKunjungan->is_cyto, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                    }else{
                                        $modKunjungan->is_cyto = 'Biasa';
                                        echo CHtml::textField('is_cyto', $modKunjungan->is_cyto, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                    }
                                    
                                     ?>
                                </div>
                            </div>
                    </div>
                </div>
                <?php if (!isset($_GET['sukses'])) { ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Permintaan ke Penunjang</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive" id="form-permintaankepenunjang">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th width="90%">Nama Pemeriksaan Permintaan</th>
                                    <th>Tarif</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); ?>
                            Tabel <b>Rencana Operasi</b>
                        </div>
                    </div>
                    <div class="panel-body" id="form-tindakanpemeriksaan">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Nama Tindakan Operasi</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th hidden>Nominal Tarif</th>
                                <th hidden>Total Tarif</th>
                                <th hidden>Cyto</th>
                                <th hidden>Tarif Cyto</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><br>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Daftar Rencana Operasi
                </div>
            </div>
            <div class="panel-body" id='content-pemeriksaan-bedah'>
                <?php $this->renderPartial('_formCariPemeriksaan', array('modPemeriksaanBedah' => $modPemeriksaanBedah, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
                <div class='checklists'></div>
            </div>
        </div>

        <?php echo $this->renderPartial("_formPenandaanAreaOperasi", array('form' => $form, 'modBagianTubuh' => $modBagianTubuh, 'modGambarTubuh' => $modGambarTubuh, 'modKunjungan' => $modKunjungan, 'modAreaOperasi' => $modAreaOperasi, 'modAreaDetOp' => $modAreaDetOp)) ?>

        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekForm();', 'onkeypress' => 'formSubmit(this,event);')
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
            }
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            $content = $this->renderPartial('tips/tipsPendaftaranBedahSentralRujukanRS', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modRencanaOperasi' => $modRencanaOperasi)); ?>