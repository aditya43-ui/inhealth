<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB  
?>

<?php
$this->breadcrumbs = array(
    'Pencatatan Hasil Pemeriksaan',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-doc-text"></i> Pencatatan Hasil <b>Pemeriksaan</b>
        </div>
    </div>
    <div class="panel-body">
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
            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien laboratorium " . $modKunjungan->nama_pasien . " berhasil disimpan!");
        }
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title rim">
                    <i class="entypo-user"></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <!--fieldset class="box" id="form-datakunjungan"-->
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
                <!--</fieldset>-->
                <div class="row">
                    <div class="col-sm-6">
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'riwayat-anamnesa',
                            'content' => array(
                                'content-riwayat-anamnesa' => array(
                                    'header' => '<b>Riwayat Anamnesa</b>',
                                    'isi' => '<div class="content"></div>',
                                    'active' => false,
                                ),
                            ),
                        )); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'riwayat-pemeriksaan-fisik',
                            'content' => array(
                                'content-riwayat-pemeriksaan-fisik' => array(
                                    'header' => '<b>Riwayat Pemeriksaan Fisik</b>',
                                    'isi' => '<div class="content"></div>',
                                    'active' => false,
                                ),
                            ),
                        ));
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'riwayat-diagnosa',
                            'content' => array(
                                'content-riwayat-diagnosa' => array(
                                    'header' => '<b>Riwayat Diagnosa</b>',
                                    'isi' => '<div class="content"></div>',
                                    'active' => false,
                                ),
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-book"></i> Hasil Pemeriksaan Laboratorium
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-bordered table-condensed table-striped" style="margin-bottom: 17px !important;">
                    <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th <?php echo Params::HIDDEN_HARGA; ?>>Tarif</th>
                        <th <?php echo Params::HIDDEN_HARGA; ?>>Total</th>
                    </thead>
                    <tbody>
    <?php
    
  //  var_dump($_GET['id']); die;
    
    $modTindakans = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_GET['id']));

    if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {

        //   $pemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id));
        //   if (!empty($pemeriksaan)) {
        //     $modTindakan->pemeriksaanlab_id = $pemeriksaan->pemeriksaanlab_id;
        //     $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
        //     $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);

            echo $this->renderPartial("_tableHasilPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
          } ?>
                    </tbody>
                    <?php 
                    
                } ?>
                </table>
                <!-- <div class="row">
                    <div class="col-sm-12">
                        <?php
                        // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        //     'id' => 'form-tindakanpemeriksaan',
                        //     'content' => array(
                        //         'content-tindakan' => array(
                        //             'header' => '<b>Tabel Pemeriksaan</b>',
                        //             'isi' => '
                        //                     <table class="table table-bordered table-condensed table-striped">
                        //                         <thead>
                        //                             <th>No.</th>
                        //                             <th>Nama Pemeriksaan</th>
                        //                             <th>Jumlah</th>
                        //                             <th>Satuan</th>
                        //                             <th ' . Params::HIDDEN_HARGA . '>Tarif</th>
                        //                             <th ' . Params::HIDDEN_HARGA . '>Total</th>
                        //                         </thead>
                        //                         <tbody>
                        //                         </tbody>
                        //                     </table>',
                        //             'active' => false,
                        //         ),
                        //     ),
                        // ));
                        ?>
                    </div>
                </div> -->
                <?php
                if ($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
                    echo $this->renderPartial('_formHasilPemeriksaan', array('form' => $form, 'modHasilPemeriksaan' => $modHasilPemeriksaan));
                } else if ($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI) {
                    echo $this->renderPartial('_formHasilPemeriksaanPA', array('format' => $format));
                }

                // input dummy
                echo "<div hidden>";
                $this->widget('ext.redactorjs.Redactor',array('name'=>'dummy_txt'));
                $this->widget('MyDateTimePicker', array(
                    'name' => 'dummy_tgl',
                    'mode' => 'datetime',
                    'options' => array(
                        //                                'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 datetimemask realtime span3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                ));
                echo "</div>";
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => TRUE)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
                );
            }
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        //                                      'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
            }

            if (isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Hasil', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false", 'disabled' => false));
                if (!empty($modHasilPemeriksaan->tandatangandigital_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Sudah Dilakukan Tanda Tangan Elektronik', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info btn_ttd', 'onclick' => "getInfoTTD();"));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Tanda Tangan Elektronik', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info btn_ttd', 'onclick' => "tandaTanganElektronik();return false", 'disabled' => false));
                }
                    
                echo CHtml::hiddenField('data_pasienmasukpenunjang_id', $modKunjungan->pasienmasukpenunjang_id);
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Hasil', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                if (!empty($modHasilPemeriksaan->tandatangandigital_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Sudah Dilakukan Tanda Tangan Elektronik', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info btn_ttd', 'onclick' => "getInfoTTD();"));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Tanda Tangan Elektronik', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));

                }
            }

            $content = $this->renderPartial('tips/tipsPencatatanHasilPemeriksaan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan, 'dariHasil' => 1)); ?>
        <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'modHasilPemeriksaan' => $modHasilPemeriksaan, 'modTindakan' => $modTindakan)); ?>
    </div>
</div>



<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogInfoTTDE',
    'options'=>array(
        'title'=>'Verifikasi Tanda Tangan Elektronik',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));

?>
<div id="dialog_info_ttd" style="padding: 10px;"></div>
<?php $this->endWidget(); ?>


<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTTDE',
    'options'=>array(
        'title'=>'Verifikasi eSign',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>400,
        'height'=>200,
        'resizable'=>false,
    ),
));

?>
<div style="text-align: center">
    Masukkan kode verifikasi yang<br/>
    dikirimkan ke <span id="ttde_nomobile"></span>
    <br/><br/>
    <div class="switch_kirimulang kirimulang_timing">
        Kirim Ulang : <span id="kirim_ulang_menit">0</span>:<span id="kirim_ulang_detik">00</span>
    </div>
    <div class="switch_kirimulang kirimulang_tombol">
        <?php echo CHtml::link('Kirim Ulang', '#', array(
            'onclick'=>'kirimUlangVerifikasi(); return false;',
        )); ?>
    </div>
    <?php echo CHtml::textField('tdde_verifikasi', null, array()); ?>
    <br/><br/>
    <?php echo CHtml::htmlButton('Verifikasi', array(
        'class'=>'btn btn-primary btn_verifikasi', 'onclick'=>'verifikasiTTD()',
    )); ?>
    <?php echo CHtml::htmlButton('Batal', array(
        'class'=>'btn btn-danger', 'onclick'=>"$('#dialogTTDE').close();"
    )); ?>
</div>



<?php $this->endWidget(); ?>
