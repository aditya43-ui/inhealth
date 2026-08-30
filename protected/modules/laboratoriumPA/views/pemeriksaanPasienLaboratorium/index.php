<style>
    body {
        color: black;
    }

    .tab_header {
        width: 100%;
    }

    .tab_header td {
        padding: 2px;
        vertical-align: top;
    }

    .tab_header .unwrap {
        width:100%;
    }

    .tab_header td:not(.unwrap) {
        white-space: nowrap;
    }
</style>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pemeriksaan <strong>Pasien Laboratorium</strong></div>
            </div>
            <div class="panel-body">
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
                    Yii::app()->user->setFlash('success', "Data pemeriksaan pasien laboratorium berhasil disimpan !");
                    $this->widget('bootstrap.widgets.BootAlert');
                }
                ?>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></div>
                    </div>
                    <div class="panel-body" id="form-datakunjungan">
                        <!--fieldset class="box" id="form-datakunjungan"-->
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
                                <div class="panel-title">Daftar Pemeriksaan Laboratorium</div>
                            </div>
                            <div class="panel-body" id='content-pemeriksaan-lab'>
                                <!--fieldset id='content-pemeriksaan-lab' class='box2'-->
                                <?php
                                //$this->renderPartial($this->path_view_pendaftaran . '_formCariPemeriksaan', array(
                                //'modPemeriksaanLab' => $modPemeriksaanLab,
                                //));																			

                                $this->renderPartial($this->path_view_pendaftaran . '_formDialogTindakan', array(
                                    'modPemeriksaanLab' => $modPemeriksaanLab,
                                ));
                                ?>


                                <!--<div class='checklists'></div>-->
                                <!--/fieldset-->
                            </div>
                        </div>	
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-success panel-shadow">
                            <div class="panel-heading">
                                <div class="panel-title">Data Kunjungan Laboratorium</div>
                            </div>
                            <div class="panel-body">
                                <!--fieldset class="box2"-->
                                <div id="form-masukpenunjang">
                                    <?php echo $this->renderPartial('_formUbahMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
                                </div>
                                <!--/fieldset-->
                            </div>
                        </div>	
                        <?php /*
                        <div class = "panel panel-success panel-shadow">
                            <div class = "panel-heading">
                                <div class = "panel-title">Rujukan Keluar <?php echo CHtml::htmlButton("<i class='icon icon-white icon-plus'></i>", array('id' => 'btn_add_rujukan_keluar', 'onclick' => 'addRowRujukan(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk rujukan keluar', 'class' => 'btn btn-primary'));
                                    ?></div>
                            </div>
                            <div class="panel-body">
                                <div id="rujukanKeluar">
                                    <table width="100%" id="table-rujukankeluar">
                                        <tbody>
                                            <?php
                                            $modRujukKeluar = PemeriksaankeluarT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id), array('order' => 'tindakanpelayanan_id ASC'));

                                            if (count($modRujukKeluar) > 0) {
                                                foreach ($modRujukKeluar as $i => $val) {
                                                    // var_dump($val->attributes); die;
                                                    $tindakan = TindakanpelayananT::model()->findByPk($val->tindakanpelayanan_id);
                                                    $val->supir_id = $tindakan->supir_id;
                                                    $val->perawat_id = $tindakan->perawat_id;
                                                    $val->daftartindakan_id = $tindakan->daftartindakan_id;
                                                    $this->renderPartial("_formGetRujukan", array('form' => $form, 'modRujukKeluar' => $val, 'i' => $i, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang));
                                                }
                                            } else {


                                                $i = 0;
                                                $modRujukKeluar = new PemeriksaankeluarT();
                                                $this->renderPartial("_formGetRujukan", array('form' => $form, 'modRujukKeluar' => $modRujukKeluar, 'i' => $i, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang));
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        */ 
                        ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Pemeriksaan</div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <!--fieldset class="box2"-->
                        <div id="form-tindakanpemeriksaan">
                            <table class="table table-bordered table-condensed table-striped" >
                                <thead>
                                <th>No.</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th <?php echo Params::HIDDEN_HARGA ?>>Nominal Tarif</th>
                                <th <?php echo Params::HIDDEN_HARGA ?>>Total Tarif</th>
                                <th>Rujuk Keluar</th>
                                <th></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!--/fieldset-->
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
//                        if (isset($_GET['sukses'])){	
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('id' => 'btn_submit', 'class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onclick' => 'setVerifikasi(this);', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onkeypress' => 'formSubmit(this,event);'));
                        echo "&nbsp;";
//                        }else{
//                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
//                                echo "&nbsp;";
//                        }
                        if (!isset($_GET['frame'])) {
                            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="' . MyIcon::getIcons('ulang') . '"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                                //                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                            echo "&nbsp;";
                        }

                        if (isset($_GET['sukses'])) {
                            echo CHtml::link(Yii::t('mds', '{icon} Cetak Status', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
                            echo "&nbsp;";
                        } else {
                            echo CHtml::link(Yii::t('mds', '{icon} Cetak Status', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                            echo "&nbsp;";
                        }

                        $content = $this->renderPartial('tips/tipsPemeriksaanPasienLaboratorium', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        ?> 

                        <?php
                        if (!empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
                            echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
                        }
                        ?>
                    </div>
                </div>
                <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modRujukKeluar' => $modRujukKeluar, 'form' => $form, 'modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan)); ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailRujuk',
    'options' => array(
        'title' => 'Detail Rujukan Keluar',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe id="frameDetailRujuk" name="frameDetailRujuk" style="border: none; width: 100%; height: 350px;"></iframe>
    <?php
    $this->endWidget();
////======= end pendaftaran dialog =============
    ?>




<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRujukPasien',
    'options' => array(
        'title' => 'Rujukan Keluar',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

echo $this->renderPartial('_formRujukKeluar', array(
    //'form' => $form,
    'i' => 0,
    'modRujukKeluar' => $modRujukKeluar,
    'modPasienMasukPenunjang' => $modPasienMasukPenunjang
        ), true);
$this->endWidget();
////======= end pendaftaran dialog =============
?>