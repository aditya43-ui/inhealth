<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pendaftaran Laboratorium <strong>Rujukan Rumah Sakit</strong></div>
                <?php /* if (!empty($modKunjungan->pasienkirimkeunitlain_id)): ?>
                  <div class="panel-options">
                  <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>
                  </div>
                  <?php elseif (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)): ?>
                  <div class="panel-options">
                  <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'backMenu(); return false;', 'style' => 'color: white;')) ?>
                  </div>

                  <?php endif; */ ?>
            </div>
            <div class="panel-body">
                <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'pemeriksaanlaboratorium-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#no_pendaftaran',
                ));
                ?>
                <?php
                if (isset($_GET['sukses'])) {

                    $this->widget('bootstrap.widgets.BootAlert');
                }
                ?>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Data <b> Rujukan </b> </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></div>
                    </div>
                    <div class="panel-body" id="form-datakunjungan">
                        <!--fieldset class="box" -->
                        <div class="row-fluid">
                            <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                        </div>
                        <!--/fieldset-->
                    </div>
                </div>	
                <div class="row-fluid">					
                    <div class="col-sm-6">
                        <div class="panel panel-success panel-shadow">
                            <div class="panel-heading">
                                <div class="panel-title">Data <b> Kunjungan Laboratorium </b></div>
                            </div>
                            <div class="panel-body">
                                <div class="">
                                    <fieldset class="box2">
                                        <?php echo $this->renderPartial('_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
                                        <?php echo CHtml::hiddenField("jenisdialog", "", array('readonly' => true)); ?>
                                        <?php echo CHtml::hiddenField("norow", "", array('readonly' => true)); ?>
                                    </fieldset>
                                    <?php if (!isset($_GET['sukses'])) { ?>
                                        <div class="panel panel-default panel-primary">
                                            <div class="panel-heading">
                                                <div class="panel-title">Tabel Permintaan <strong>Ke Penunjang</strong></div>
                                            </div>
                                            <div class="panel-body overflow-x">
                                                <div class="block-tabel">
                                                    <div id="form-permintaankepenunjang" style="">
                                                        <table class="table table-bordered table-condensed table-striped">
                                                            <thead>
                                                            <th>No.</th>
                                                            <th>Nama Pemeriksaan Permintaan</th>
                                                            <th>Jumlah</th>
                                                            <th>Satuan</th>
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
                                                            <?php echo CHtml::textArea('catatandokterpengirim', $modKunjungan->catatandokterpengirim, array('readonly' => true, 'class' => 'span3', 'placeholder' => 'Ketik Catatan', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="panel panel-primary panel-default">
                                        <div class="panel-heading">
                                            <div class="panel-title">Tabel <b>Pemeriksaan</b> <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); ?></div>
                                        </div>
                                        <div class="panel-body" style="overflow-x: scroll">
                                            <div class="block-tabel">
                                                <div id="form-tindakanpemeriksaan" style="">
                                                    <table class="table table-bordered table-condensed table-striped">
                                                        <thead>
                                                        <th>No.</th>
                                                        <th>Nama Pemeriksaan</th>
                                                        <th>Jumlah</th>
                                                        <th>Satuan</th>
                                                        <th <?php echo Params::HIDDEN_HARGA ?>>Nominal Tarif</th>
                                                        <th <?php echo Params::HIDDEN_HARGA ?>>Total Tarif</th>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-success panel-shadow">
                            <div class="panel-heading">
                                <div class="panel-title">Daftar <b> Pemeriksaan Laboratorium </b></div>
                            </div>
                            <div class="panel-body">
                                <!--fieldset class="box2"--><p></p>
                                <div id='content-pemeriksaan-lab'>
                                    <?php
                                    echo $this->renderPartial($this->path_view_pendaftaran . '_formCariPemeriksaan', array(
                                        'modPemeriksaanLab' => $modPemeriksaanLab,
                                            ), true);
                                    ?>
                                    <div class='checklists'></div>
                                </div>
                                <!--/fieldset-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form-actions">
                    <?php
//                    if(!$modPasienMasukPenunjang->pasienmasukpenunjang_id){
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
                    echo "&nbsp;";
//                    }else{
//                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true, 'style'=>'cursor:not-allowed;')); 
//                            echo "&nbsp;";
//                    }
                    if (!isset($_GET['frame'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->module->id . '/index'), array('class' => 'btn btn-danger',
                            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'));
                        echo "&nbsp;";
                    }
                    if (!$modPasienMasukPenunjang->pasienmasukpenunjang_id) {
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Status', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Bukti Pelayanan', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Pemakaiaan Bahan', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info'));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print QR Code', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info'));
                        echo "&nbsp;";
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Status', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Bukti Pelayanan', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBukti(" . $_GET['pasienmasukpenunjang_id'] . ");return false"));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak Pemakaiaan Bahan', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemakaianOa(" . $_GET['pasienmasukpenunjang_id'] . ");return false"));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcodeLab();return false"));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print QR Code', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printQrCodeLab();return false"));
                        echo "&nbsp;";
                    }
                    $content = $this->renderPartial('tips/tipsPendaftaranLaboratoriumRujukanRS', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?> 
                    <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')); ?>
                </div>
                <?php $this->endWidget(); ?>
                <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modObatAlkesPasien' => $modObatAlkesPasien,)); ?>
                <?php $this->renderPartial($this->path_view . '_dialog', array()); ?>
            </div>
        </div>
    </div>
</div>      
<script type="text/javascript">
    function printBarcodeLab()
    {
        window.open('<?php echo $this->createUrl('PrintBarcode', array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }

    function printQrCodeLab()
    {
        window.open('<?php echo $this->createUrl('PrintQrCode', array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }
</script>