<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rujukan' => array('rujukanPenunjang/index'),
    'Rujukan Rumah Sakit',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pendaftaran Laboratorium <b>Rujukan Rumah Sakit</b>
        </div>
    </div>
    <div class="panel-body">
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

            $this->widget('bootstrap.widgets.BootAlert');
        }
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Rujukan</b>
                    <span class='tombol'
                        style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <!--fieldset class="box"-->
                <div class="row">
                    <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
                <!--</fieldset>-->
            </div>
        </div>

        <div class="row" style="margin-top: 17px;">
            <div class="col-md-5 col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan Laboratorium</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>

                        <?php /*
                            <div class="block-tabel">
                                <h6>Kirim <b>SMS</b></h6>
                                <div>
                                    <?php 
                                    if(Yii::app()->user->getState('issmsgateway')){
                                       $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway)); 
                                    }
                                    ?>
                    </div>
                </div>
                *
                */ ?>

            </div>
        </div>
        <?php // if (!isset($_GET['sukses'])) { 
            $instalasi = Yii::app()->user->getState('instalasi_id');            
            ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan ke Penunjang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div id="form-permintaankepenunjang" style="margin-bottom: 17px;">
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <th>No.</th>
                            <th hidden>Nama Pemeriksaan Permintaan</th>
                            <th>Jenis Pemeriksaan</th>
                            <th>Pemeriksaan</th>
                            <th>Sample Lab</th>
                             <?php if($instalasi == Params::INSTALASI_ID_LAB_PA) { echo '<th hidden>Cara Ambil</th>';} else {echo '<th>Cara Ambil</th>';}  ?>
                            <th hidden>Tarif</th>
                            <th hidden>Status</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <?php $kirim = PasienkirimkeunitlainT::model()->findByPk($modKunjungan->pasienkirimkeunitlain_id);?>
                <div class="control-group">
                    <?php echo CHtml::label("Antibiotik yang diberikan", 'antibiotikygdiberi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('antibiotikygdiberi', $kirim->antibiotikygdiberi , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <?php if($instalasi !== Params::INSTALASI_ID_LAB_PA) { ?>
                <div class="control-group">
                    <?php echo CHtml::label("Waktu ambil sample", 'waktuambilspesimen', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php 
        // $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_tindakan);
                        $this->widget('MyDateTimePicker',array(
                                            'model' => $kirim,
                                            'attribute' => 'waktuambilspesimen',
                                            'mode'=>'time',
                                            'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                            'htmlOptions'=>array('class'=>'span3', 'readonly' => true,
                                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); 
                    ?>
                    </div>
                </div>
                <?php } ?>

                <div class="control-group">
                    <?php echo CHtml::label("Dokter Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('pegawai_id', $modKunjungan->pegawai_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('nama_pegawai', $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("PPDS Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('ppds_id', $modKunjungan->ppds_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('ppds_nama', $modKunjungan->ppds_nama , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("No. Telepon PPDS", 'pegawai_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('no_ppds', $modKunjungan->no_ppds , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
                                echo CHtml::textField('is_cyto', $modKunjungan->is_cyto, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                            }else{
                                $modKunjungan->is_cyto = 'Biasa';
                                echo CHtml::textField('is_cyto', $modKunjungan->is_cyto, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                            }
                                
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <?php if($instalasi !== Params::INSTALASI_ID_LAB_PA) { ?>

        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-detail',
                    'content' => array(
                        'content-detail' => array(
                            'header' => 'Tabel <b>Detail Order Laboratorium PA</b>',
                            'isi' => $this->renderPartial($this->path_view . '_formDetail', array(
                                'form' => $form,
                                'modKirimKeUnitLain' => $modKirimKeUnitLain,
                            ), true),
                            'active' => false,
                        ),
                    ),
                ));
        ?>

        <?php  } ?>


        <?php echo $form->hiddenField($modPasienMasukPenunjang, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-karcis',
                    'content' => array(
                        'content-karcis' => array(
                            'header' => '<b>Karcis</b>',
                            'isi' => '<div id="content-karcis-html">'
                                . $this->renderPartial($this->path_view . '_formKarcis', array(
                                    'form' => $form,
                                    'model' => $modPasienMasukPenunjang,
                                    'modTindakan' => $modTindakan,
                                    'modKarcisV' => $modKarcisV
                                ), true)
                                . '</div>',
                            'active' => $modPasienMasukPenunjang->is_adakarcis,
                        ),
                    ),
                )); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemakaian Bahan
                </div>
            </div>
            <div class="panel-body">
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
                    <div class="col-sm-12">
                        <!--fieldset class="box2"-->
                        <div id="form-tambahobatalkes">
                            <!--<div class="row box">-->
                            <?php $this->renderPartial('_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
                            <!--</div>-->
                        </div>
                        <!--</fieldset>-->
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-default panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="entypo-credit-card"></i> Tabel <b>Obat dan Alat Kesehatan</b>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table class="items table table-bordered table-striped table-condensed"
                                    id="table-obatalkespasien">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Obat / Alat Kesehatan</th>
                                            <!--th>Satuan Kecil</th-->
                                            <!--RND-3097 <th>Harga</th>-->
                                            <!--th>Stok</th-->
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
                    </div>
                    <?php
                            }
                            ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-7">

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                    <?php 
                            // echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); 
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-mini btn-success', 'type' => 'button', "onclick" => "$('#dialogLab').dialog('open')", 'rel' => 'tooltip', 'title' => 'Klik untuk menambah pemeriksaan')); 
                            ?>
                </div>
            </div>
            <div id="form-tindakanpemeriksaan" class="panel-body table-responsive">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>No.</th>
                        <th>No. Lab</th>
                        <th>Pemeriksaan</th>
                        <th>Sample Lab</th>
                        <?php if($instalasi == Params::INSTALASI_ID_LAB_PA) { echo '<th hidden>Cara Ambil</th>';} else {echo '<th>Cara Ambil</th>';}  ?>
                        <th>Kode Tindakan</th>
                        <th hidden>Jumlah</th>
                        <th hidden>Harga</th>
                        <th hidden>Satuan</th>
                        <th>Nominal Tarif</th>
                        <th hidden>Total Tarif</th>
                        <th>Batal</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
            if (empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
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
            if (empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));

            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
                echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemakaianOa(" . $modPasienMasukPenunjang->pasienmasukpenunjang_id . ");return false"));
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcodeLab();return false"));

                
            }
            $content = $this->renderPartial('tips/tipsPendaftaranLaboratoriumRujukanRS', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_LAB){
                if (empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/index", array("instalasi_id"=>$modKunjungan->instalasiasal_id,"pendaftaran_id"=>$modKunjungan->pendaftaran_id, "frame" => true, 'pelayanan' => "RLB")), array("target"=>"iframePembayaran",'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => FALSE));
                }
            }
            
            if (empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
                echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$modKunjungan->pendaftaran_id.');'));
            }
            ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modObatAlkesPasien' => $modObatAlkesPasien,)); ?>
<?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
</div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBayarKarcis',
    'options' => array(
        'title' => 'Pembayaran Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'zIndex' => 1001,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php    

$modTindakan = new LBTindakanpelayananT; 
$modTindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
$modTindakan->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
$modTindakan->nopelayanan = '- terisi otomatis -';



?>


<?php

    /** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLab',
    'options' => array(
        'title' => 'Daftar Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'width' => 800,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modTarif = new LBTariftindakanM('search');
$modTarif->unsetAttributes();
$modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
if (isset($_GET['LBTariftindakanM'])) {
    $modTarif->attributes = $_GET['LBTariftindakanM'];
    $modTarif->kategoritindakan_nama = $_GET['LBTariftindakanM']['kategoritindakan_nama'] ?? "";
    $modTarif->daftartindakan_kode = $_GET['LBTariftindakanM']['daftartindakan_kode'] ?? "";
    $modTarif->daftartindakan_nama = $_GET['LBTariftindakanM']['daftartindakan_nama'] ?? "";
    $modTarif->pemeriksaanlab_nama = $_GET['LBTariftindakanM']['pemeriksaanlab_nama'] ?? "";
    $modTarif->paket = $_GET['LBTariftindakanM']['paket'] ?? "";
}

if ($modTarif->paket == "paket") {

    $modTarif->unsetAttributes();
    if (isset($_GET['LBTariftindakanM'])) {
        $modTarif->attributes = $_GET['LBTariftindakanM'];
        $modTarif->tipepaket_nama = $_GET['LBTariftindakanM']['tipepaket_nama'] ?? "";
        $modTarif->paket = $_GET['LBTariftindakanM']['paket'];
    }


    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dialog-tariftindakan-m-grid',
        'dataProvider' => $modTarif->searchPaket(),
        'filter' => $modTarif,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'filter' => CHtml::dropDownList('LBTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                'value' => function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                "onclick" => "pilihPemeriksaanIniDialogPaket(".$data->tipepaket_id."); $('#dialogLab').dialog('close'); return false;"));
                },
            ),
            array(
                'header' => 'Nama Paket',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'tipepaket_nama', array('class' => 'span3')),
                'value' => '$data->tipepaket_nama',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    

} else {

    $modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dialog-tariftindakan-m-grid',
        'dataProvider' => $modTarif->search2(),
        'filter' => $modTarif,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'filter' => CHtml::dropDownList('LBTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                'value' => function($data) {
                    echo CHtml::hiddenField('daftartindakan_kode', $data->daftartindakan->daftartindakan_kode, array('class' => 'span3 daftartindakan_kode'));
                    echo CHtml::hiddenField('pemeriksaanlab_id', $data->pemeriksaanlab_id, array('class' => 'span3 pemeriksaanlab_id_dialog'));
                    echo CHtml::hiddenField('pemeriksaanlab_nama', $data->pemeriksaanlab_nama, array('class' => 'span3 pemeriksaanlab_nama'));
                    echo CHtml::hiddenField('daftartindakan_id', $data->daftartindakan_id, array('class' => 'span3 daftartindakan_id'));
                    echo CHtml::hiddenField('jenistarif_id', $data->jenistarif_id, array('class' => 'span3 jenistarif_id'));
                    echo CHtml::hiddenField('harga_tariftindakan', $data->harga_tariftindakan, array('class' => 'span3 harga_tariftindakan'));
                    echo CHtml::hiddenField('kelaspelayanan_id', $data->kelaspelayanan_id, array('class' => 'span3 kelaspelayanan_id_dialog'));
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                "onclick" => "pilihPemeriksaanIniDialog(this); $('#dialogLab').dialog('close'); return false;"));
                },
            ),
            array(
                'header' => 'Kategori Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'kategoritindakan_nama', array('class' => 'span3')),
                'value' => '$data->daftartindakan->kategoritindakan->kategoritindakan_nama',
            ),
            array(
                'header' => 'Kode Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_kode', array('class' => 'span3')),
                'value' => '$data->daftartindakan->daftartindakan_kode',
            ),
            array(
                'header' => 'Nama Pemeriksaan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'pemeriksaanlab_nama', array('class' => 'span3')),
                'value' => '$data->pemeriksaanlab_nama',
            ),
            array(
                'header' => 'Uraian Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_nama', array('class' => 'span3')),
                'value' => '$data->daftartindakan->daftartindakan_nama',
            ),
            array(
                'header' => 'Kelas Pelayanan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::dropDownList('LBTariftindakanM[kelaspelayanan_id]', $modTarif->kelaspelayanan_id, CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif IS TRUE"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --')),
                'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

}


$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================

?>

<script>

    function pilihPemeriksaanIniDialogPaket(id) {

        var pasienkirimkeunitlain_id = '<?php echo $modKunjungan->pasienkirimkeunitlain_id; ?>';

        $.post('<?php echo $this->createUrl('tambahTarifTindakanPaket'); ?>', {
            tipepaket_id: id,
            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
        }, function(data) {
            $("#form-tindakanpemeriksaan table > tbody").append(data.rows);
            renameInputRow($("#form-tindakanpemeriksaan"));
        }, 'json');

    }

            /**
     * Centang pemeriksaan rad dari checkboxlist
     */
    function pilihPemeriksaanIniDialog(obj) {

        console.log('pilih pemeriksaan dialog');

        var pemeriksaanlab_nama = $(obj).parent().find('.pemeriksaanlab_nama').val();
        var pemeriksaanlab_id = $(obj).parent().find('.pemeriksaanlab_id_dialog').val();
        var daftartindakan_id = $(obj).parent().find('.daftartindakan_id').val();
        var jenistarif_id = $(obj).parent().find('.jenistarif_id').val();
        var harga_tariftindakan = $(obj).parent().find('.harga_tariftindakan').val();
        var daftartindakan_kode = $(obj).parent().find('.daftartindakan_kode').val();
        var kelaspelayanan_id = $(obj).parent().find('.kelaspelayanan_id_dialog').val();
        var rowtindakan = '<?php echo CJSON::encode($this->renderPartial('laboratorium.views.pendaftaranLaboratoriumRujukanRS._rowTindakanPemeriksaan', array('modTindakan' => $modTindakan), true)); ?>';

        var ada = $('.daftartindakan_id_dialog[value="' + daftartindakan_id + '"]').length > 0;
        if (!ada) {
            $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][kelaspelayanan_id]"]').val(kelaspelayanan_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
            $("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(formatInteger(harga_tariftindakan));
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
            $("#form-tindakanpemeriksaan tbody tr:last .tindakan_kode").html(daftartindakan_kode);
        } else {

            myAlert('Pemeriksaan sudah dipilih');
        //     var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value="' + pemeriksaanlab_id + '"]').parents('tr');
        //     delete_row.detach();
        }
        renameInputRow($("#form-tindakanpemeriksaan"));
    }

       /**
     * rename input row yang terakhir di tambahkan
     * @param {type} obj_table
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                var new_name = $(this).attr("name").replace("ii", (row));
                $(this).attr("name", new_name);
            });
            $(this).find('span[name$="[pemeriksaanlab_nama]"]').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 2) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[1] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }

    function hapusPeriksa(obj) {
        $(obj).parents("tr").remove();
        renameInputRow($("#form-tindakanpemeriksaan"));
    }

    function printBarcodeLab()
        {
            window.open('<?php echo $this->createUrl('PrintBarcode', array('kantongdarah_id' => '')); ?>', 'printwin', 'left=100,top=100,width=700,height=640');

        }

    </script>