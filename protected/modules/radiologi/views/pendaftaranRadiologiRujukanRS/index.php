<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rujukan' => Yii::app()->request->getUrlReferrer(),
    'Pendaftaran Radiologi Rujukan Rumah Sakit',
);
$arrMenu = array();
$this->menu = $arrMenu;
// $this->widget('bootstrap.widgets.BootAlert'); 
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pendaftaran Radiologi Rujukan Rumah Sakit
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
             Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); 
             Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); 
        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemeriksaanradiologi-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>
        <?php
        //        if(isset($_GET['sukses'])){
        //            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien radiologi berhasil disimpan!");
        //            $this->widget('bootstrap.widgets.BootAlert');
        //        }
        ?>
        <div class="panel panel-success" id="form-datakunjungan">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Rujukan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>

        <div class="row" style="margin: 17px -15px;">
            <div class="col-sm-5">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan Radiologi</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan)); ?>
                    </div>
                </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Permintaan Ke Penunjang</b>
                            </div>
                        </div>
                        <div id="form-permintaankepenunjang" class="panel-body table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th width="80%">Nama Pemeriksaan Permintaan</th>
                                    <th>Kode Tarif</th>
                                    <th>Harga</th>
                                    <th>Kelas</th>
                                    <!-- <th>Tarif</th> -->
                                    <th>Status</th>
                                    <th>Tambah</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <div class="control-group">
                                <?php echo CHtml::label("Dokter Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::hiddenField('pegawai_id', $modKunjungan->pegawai_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo CHtml::textField('nama_pegawai', $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo CHtml::label("PPDS", 'ppds_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::hiddenField('ppds_id', $modKunjungan->ppds_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                  <?php echo CHtml::textArea('ppds_nama', isset($modKunjungan->ppds_nama) ? $modKunjungan->ppds_nama : '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Catatan Dokter Perujuk", 'catatandokterpengirim', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::textArea('catatandokterpengirim', isset($modKunjungan->catatandokterpengirim) ? $modKunjungan->catatandokterpengirim : '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
                            <div class="control-group">

                                <?php echo CHtml::label("Diagnosa Klinis", 'diagnosaklinis', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php

                                        $morbid = PasienmorbiditasR::model()->findAll('pendaftaran_id = ' . $modKunjungan->pendaftaran_id . " and is_verifikasidiagnosa = false");
                                        $mb_arr = [];

                                        $klinis = '';

                                        if(!empty($morbid)) {
                                        
                                            foreach($morbid as $mb) {
                                                array_push($mb_arr, $mb->diagnosa->diagnosa_nama);
                                            }
                                        
                                            $klinis = implode(', ', $mb_arr);
                                        } 

                                    ?>
                                    <?php echo CHtml::textArea('diagnosaklinis', $klinis, array('readonly' => true, 'class' => 'span3', 'rows' => 5, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </div>
                    </div>

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
                            'active' => false,
                        ),
                    ),
                )); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Kirim SMS
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (Yii::app()->user->getState('issmsgateway')) {
                            $this->renderPartial($this->path_view . '_formSms', array('form' => $form, 'modSmsgateway' => $modSmsgateway));
                        }
                        ?>
                    </div>
                </div>
                <div hidden>
                        <?php
                        echo $this->renderPartial($this->path_view . '_formCariPemeriksaan', array(
                            'modPemeriksaanRad' => $modPemeriksaanRad,
                            'modKunjungan' => $modKunjungan,
                        ), true); ?>
                </div>
            </div>
            <div class="col-sm-7">
                

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b> 
                            <?php 
                            // echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); 
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-mini btn-success', 'type' => 'button', "onclick" => "$('#dialogRad').dialog('open')", 'rel' => 'tooltip', 'title' => 'Klik untuk menambah pemeriksaan')); 
                            ?>
                        </div>
                    </div>
                    <div id="form-tindakanpemeriksaan" class="panel-body table-responsive">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Tgl. Rencana Pemeriksaan</th>
                                <th>Elektif</th>
                                <th>Kode Tarif</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Satuan</th>
                                <th hidden>Nominal Tarif</th>
                                <th hidden>Total Tarif</th>
                                <th>Hapus</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <?php
                             echo CHtml::hiddenField('is_elektif_kirim', '0', array('class' => 'span3 is_elektif'));
                        ?>

                    </div>
                </div>

                <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Pemakaian Bahan
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="form-tambahobatalkes">
                                <!--<div class="row box">-->
                                <?php $this->renderPartial('_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
                                <!--</div>-->
                            </div>
                        </div>
                </div>

                <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Obat dan Alat Kesehatan</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">

                            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Obat / Alat Kesehatan</th>
                                        <!--th>Satuan Kecil</th-->
                                        <!--RND-3097 <th>Tarif</th>-->
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
                <div class="form-actions">
                    <?php
                    if ($modPasienMasukPenunjang->isNewRecord) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons("simpan") . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons("simpan") . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    }
                    if (!isset($_GET['frame'])) {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="' . MyIcon::getIcons("ulang") . '"></i>')),
                            $this->createUrl('index'),
                            array(
                                'class' => 'btn btn-default',
                                'onclick' => 'return refreshForm(this);'
                            )
                        );
                    }
                    if (!isset($_GET['pasienmasukpenunjang_id'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Nota Tindakan', array('{icon}' => '<i class="' . MyIcon::getIcons("cetak") . '"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                        echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}' => '<i class="' . MyIcon::getIcons("cetak") . '"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Nota Tindakan', array('{icon}' => '<i class="' . MyIcon::getIcons("cetak") . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
                        echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}' => '<i class="' . MyIcon::getIcons("cetak") . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemakaianOa(" . $_GET['pasienmasukpenunjang_id'] . ");return false"));
                    }
                    $content = $this->renderPartial('tips/tipsPendaftaranRadiologiRujukanRS', array(), true);
                    
                    // if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RAD){
                    //     if (!isset($_GET['pasienmasukpenunjang_id'])) {
                    //         echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    //     } else {
                    //         echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/index", array("instalasi_id"=>$modKunjungan->instalasiasal_id,"pendaftaran_id"=>$modKunjungan->pendaftaran_id, "frame" => true, 'pelayanan' => "RO")), array("target"=>"iframePembayaran",'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => FALSE));
                    //     }
                    // }
                    
                    // if (!isset($_GET['pasienmasukpenunjang_id'])) {
                    //     echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    // } else {
                    //     echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$modKunjungan->pendaftaran_id.');'));
                    // }

                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                    ?>
                </div>

                
            </div>
        </div>

        <div class="row hide">
            <?php
            if (isset($_GET['sukses'])) {
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'riwayat-obatalkespasien-t',
                    'content' => array(
                        'content-riwayat-obatalkespasien-t' => array(
                            'header' => '<b>Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                            'isi' => '
                                        <table class="table table-condensed table-striped">
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
                    
                <?php
            }
                ?>

                
                <?php $this->endWidget(); ?>
                <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
                </div>
        </div>
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