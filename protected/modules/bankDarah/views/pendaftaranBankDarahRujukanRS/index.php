<div class="white-container">
    <legend class="rim2">Pendaftaran Bank Darah <b>Rujukan Rumah Sakit</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pemeriksaanlaboratorium-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#no_pendaftaran',
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pemeriksaan pasien bank darah berhasil disimpan!");
        $this->widget('bootstrap.widgets.BootAlert');
    }
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php
            if (Yii::app()->user->getState('issmsgateway')) {
                $this->renderPartial($this->path_view . '_formSms', array('form' => $form, 'modSmsgateway' => $modSmsgateway));
            }
            ?>
        </div>
    </div>
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim">Data Rujukan
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
        </legend>
        <div class="row">
            <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
        </div>
    </fieldset>

    <fieldset class="box">
        <div class="row">
            <div class="span8">
                <fieldset class="box2">
                    <legend class="rim">Daftar Pemeriksaan Bank Darah</legend>
                    <div id='content-pemeriksaan-lab' class='box'>
                        <?php
                        $this->renderPartial($this->path_view_pendaftaran . '_formCariPemeriksaan', array(
                            'modPemeriksaanLab' => $modPemeriksaanLab,
                        )); ?>
                        <div class='checklists'></div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-4">
                <fieldset class="box2">
                    <legend class="rim">Data Kunjungan Bank Darah</legend>
                    <?php echo $this->renderPartial('_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
                </fieldset>
                <?php if (!isset($_GET['sukses'])) { ?>
                    <div class="block-tabel">
                        <h6>Tabel Permintaan <b>Ke Penunjang</b></h6>
                        <div id="form-permintaankepenunjang">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Nama Pemeriksaan Permintaan</th>
                                    <th width="20%">Status</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Dokter Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('pegawai_id', $modKunjungan->pegawai_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::textField('nama_pegawai', $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Catatan Dokter Perujuk", 'catatandokterpengirim', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textArea('catatandokterpengirim', $modKunjungan->catatandokterpengirim, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="block-tabel">
                        <h6>Tabel <b>Pemeriksaan</b> <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); ?></h6>
                        <div id="form-tindakanpemeriksaan">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Nominal Tarif</th>
                                    <th>Cyto</th>
                                    <th>Tarif Cyto</th>
                                    <th>Total Tarif</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <?php
            if (isset($_GET['sukses'])) {
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'riwayat-obatalkespasien-t',
                    'content' => array(
                        'content-riwayat-obatalkespasien-t' => array(
                            'header' => '<b>Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                            'isi' => '
                                        <table class="table table-condensed table-bordered">
                                            <thead>
                                                <th>No.</th>
                                                <th>Tgl. Pelayanan</th>
                                                <th>Obat / Alat Kesehatan</th>
                                                <th>Satuan Kecil</th>
                                                <th>Jumlah</th>
                                                <th>Hapus</th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=7>Data tidak ditemukan</td></tr>
                                            </tbody>
                                        </table>',
                            'active' => true,
                        ),
                    ),
                ));
            } else {
            ?>
                <div class="col-sm-4">
                    <fieldset class="box2">
                        <legend class='rim'>Pemakaian Bahan</legend>
                        <div id="form-tambahobatalkes">
                            <!--<div class="row box">-->
                            <?php $this->renderPartial('_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
                            <!--</div>-->
                        </div>
                    </fieldset>
                </div>
                <div class="span8">
                    <div class="block-tabel">
                        <h6>Tabel Pemakaian Bahan <b>dan Alat Kesehatan</b></h6>
                        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Bahan dan Alat Kesehatan</th>
                                    <th>Satuan Kecil</th>
                                    <!--RND-3097 <th>Harga</th>-->
                                    <th>Stok</th>
                                    <th>Jumlah</th>
                                    <!--RND-3097 <th>Sub Total</th>-->
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </fieldset>
    <div class="form-actions">
        <?php
        if (!$modPasienMasukPenunjang->pasienmasukpenunjang_id) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
        }
        if (!isset($_GET['frame'])) {
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->module->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                )
            );
        }
        if (!$modPasienMasukPenunjang->pasienmasukpenunjang_id) {
            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
            echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemakaianOa(" . (isset($_GET['pasienmasukpenunjang_id']) ? $_GET['pasienmasukpenunjang_id'] : null) . ");return false"));
        }
        $content = $this->renderPartial('tips/tipsPendaftaranBankDarahRujukanRS', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modObatAlkesPasien' => $modObatAlkesPasien,)); ?>
</div>