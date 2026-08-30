<!--div class="white-container"-->
<style>
    .container {
        display: flex;
        justify-content: space-between;
        width: 169px;
    }

    .column {
        flex: 1 1 0%; /* untuk mengatur lebar kolom */
        margin: 0 10px; /* untuk mengatur jarak antar kolom */
    }
    #daftarpasien-v-grid {
        width: 100%;
        height: 500px;
        overflow: auto;
    }

    #daftarpasien-v-grid table thead {
        position: sticky;
        top: 0;
        background-color: #f5f5f5;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Informasi Daftar Pasien',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$autoopen = Yii::app()->user->getState('isantrian');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Daftar Pasien</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
        //CHtml::link($text, $url, $htmlOptions)
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'daftarPasien-form',
            'type' => 'horizontal',
            'htmlOptions' => array(),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Masuk Penunjang", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Rencana Pemeriksaan", 'tgl_tindakan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_awall2)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_akhirl2)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_awall2)) ?> - <?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_akhirl2)) ?></span>
                                    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_awall2', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_akhirl2', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->hiddenField($modPasienMasukPenunjang, 'jenis_pasien', array('class' => 'jenis_pasien')) ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_pendaftaran', array('autofocus' => true, 'class' => 'span4 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 12, 'placeholder' => 'No. Pendaftaran')); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_rekam_medik', array('autofocus' => true, 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 8, 'placeholder' => 'No. Rekam Medik')); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array('class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
                        <div class="control-group hide">
                            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPasienMasukPenunjang, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php $modPasienMasukPenunjang->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($modPasienMasukPenunjang, 'ceklis') . " Tanggal Lahir", 'tanggal_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_awall',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modPasienMasukPenunjang->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_akhirl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'nama_dokterasal', DokterV::model()->getDropDokterResepByNama(), array('multiple' => 'multiple')) ?>
                        <?php
                        $carabayar = CarabayarM::model()->findAll(array(
                            'condition' => 'carabayar_aktif = true',
                            'order' => 'carabayar_nourut',
                        ));
                        foreach ($carabayar as $idx => $item) {
                            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                'carabayar_id' => $item->carabayar_id,
                                'penjamin_aktif' => true,
                            ));
                            if (empty($penjamins)) unset($carabayar[$idx]);
                        }
                        $penjamin = PenjaminpasienM::model()->findAll(array(
                            'condition' => 'penjamin_aktif = true',
                            'order' => 'penjamin_nama',
                        ));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modPasienMasukPenunjang, "penjamin_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
                        ?>
                        <?php
                        $instalasi = InstalasiM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                        ));
                        $ruangan = RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                            'ruangan_aktif' => true,
                        ), array(
                            'order' => 'instalasi_id, ruangan_nama',
                        ));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modPasienMasukPenunjang, "ruanganasal_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
                        ?>
                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'statusperiksa',  LookupM::getItems('statusperiksa'), array('empty' => '-- Pilih --', 'class' => 'span3')) ?>
                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'nama_pegawai', DokterV::model()->getDropDokterResepByNama(), array('empty' => '-- Pilih --', 'class' => 'span3')) ?>
                        <?php //echo $form->dropDownList($modPasienMasukPenunjang,'statusperiksahasil',  CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'statusperiksahasil', 'lookup_aktif'=>true)), 'lookup_value', 'lookup_name'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                        ?>
                    </div>
                </div>
                <?php // echo $form->textFieldRow($modPasienMasukPenunjang,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Alias')); 
                ?>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger cari-pasien', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    );
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                    ?>
                    <?php $content = $this->renderPartial('../tips/informasiDaftarPasien', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <iframe id="suarapanggilan" src="" style="display: none;"></iframe>
            </div>
        </div>
        <iframe id="frameWeasis" hidden></iframe>
        <br>
        <?php

            $this->widget('bootstrap.widgets.BootMenu', array(
                'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
                'stacked'=>false, // whether this is a stacked menu
                'items'=>array(      
                    array('label'=>'PASIEN RUJUKAN PELAYANAN', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setJenisPasien(this, "rujukan");')),
                    array('label'=>'PASIEN APS', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setJenisPasien(this, "aps");')),
                ),
                'htmlOptions'=>[
                    'id'=>'tab-periksa'
                ] 
            ));
        ?>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Pasien</b>
                    <?php echo ($autoopen == true) ? CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian terakhir', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'ambilAntrianTerakhir();', 'style' => 'font-size:10px;')) : ''; ?>
                    <?php //echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian terakhir','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'ambilAntrianTerakhir();','style'=>'font-size:10px;')); 
                    ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                Yii::app()->clientScript->registerScript('cari cari', "
								$('#daftarPasien-form').submit(function(){
									$.fn.yiiGridView.update('daftarpasien-v-grid', {
										data: $(this).serialize()
									});
									return false;
								});
								");
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php //$this->widget('ext.bootstrap.widgets.BootGridView', array( 
                    $this->renderPartial('_table', [
                        'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 
                        'controller' => $controller,
                        'module' => $module
                    ]);
                ?>
                <br>
            </div>
        </div>
        
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogCetakUlang',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Cetak Ulang</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 400,
        'resizable' => true
    ),
));
?>
<iframe name='iframeCetakUlang' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPersetujuanTindakan',
    'options' => array(
        'title' => 'Detail Persetujuan Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='framePersetujuanTindakan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAnestesi',
    'options' => array(
        'title' => 'Anestesi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameAnestesi' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>


<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKonsultasi',
    'options' => array(
        'title' => 'Konsultasi Poli',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameKonsultasi' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>



<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogCPPT',
    'options' => array(
        'title' => 'CPPT',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameCPPT' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>


<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogReseptur',
    'options' => array(
        'title' => 'Reseptur',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameReseptur' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVerifHasilPemeriksaan',
    'options' => array(
        'title' => 'Verifikasi DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 300,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameVerifHasilPemeriksaan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPasien',
    'options' => array(
        'title' => 'Riwayat Pemeriksaan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatPasien' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogRiwayatVaksinasi',
        'options' => array(
            'title' => 'Riwayat Vaksinasi/Imunisasi',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 450,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $('#formCari').serialize()
                    }); }",
        ),
    )
);
echo '<iframe name="frameRiwayatVaksinasi" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
// Dialog untuk Lihat Hasil =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLihatHasil',
    'options' => array(
        'title' => 'Hasil Pemeriksaan Radiologi',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 950,
        'height' => 450,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeLihatHasil" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end Lihat Hasil =============================
?>
<?php
// Dialog untuk ambil Hasil =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAmbilHasil',
    'options' => array(
        'title' => 'Penyerahan Hasil Radiologi',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe src="" name="iframeAmbilHasil" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end ambil Hasil =============================
?>
<?php
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogInformConsent',
    'options' => array(
        'title' => 'Inform Consent',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
    ),
));
?>
<iframe name='frameInformConsent' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php
   // Dialog Radiografer =========================
   $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogRadiografer',
                'options'=>array(
                    'title'=>'Ubah Radiografer',
                    'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid'); }",
                    'autoOpen'=>false,
                    'modal'=>true,
                    'minWidth'=>950,
                    'minHeight'=>450,
                    'resizable'=>true,
                ),
   ));
    ?>
    <iframe src="" name="iframeUbahRadiografer" width="100%" height="500">
    </iframe>

    <?php
    $this->endWidget();
    //========= end Ubah Radiografer =============================
    ?>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 425,
        'minHeight' => 100,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
//======================= Edit Dokter Periksa ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editDokterPeriksa',
        'options' => array(
            'title' => 'Ganti Dokter Perujuk',
            'autoOpen' => false,
            'minWidth' => 500,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_idPendaftaranDP', '', array('readonly' => true));
echo '<div class="divForFormEditDokterPeriksa"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogKonfigurasiLabel',
        'options' => array(
            'title' => 'Konfigurasi Cetak Label',
            'autoOpen' => false,
            'modal' => true,
            'width' => 400,
            'height' => 160,
            'resizable' => false,
        ),
    ));

    echo '<div class="form-horizontal" id="konfigurasi-label" style="padding:10px;"></div>';

    $this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'editPemeriksa',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Ubah Dokter Pemeriksa</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'height' => 480,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeEditPemeriksa' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function printUlangNotaTindakan(pendaftaran_id)
    {
        window.open('<?php echo $this->createUrl('/laboratorium/daftarPasien/PrintUlangTindakan'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=1080,height=640');
    }
    
    {
        function printLabel(id) {
            window.open('<?php echo $this->createUrl('printLabel'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
        }
        function batalperiksa(pendaftaran_id, penunjang_id) {
            myConfirm("Anda yakin akan membatalkan pemeriksaan radiologi pasien ini?", "Perhatian!", function(r) {
                if (r) {
                    $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPemeriksaan') ?>', {
                            pendaftaran_id: pendaftaran_id,
                            idPenunjang: penunjang_id
                        },
                        function(data) {
                            if (data.status == 'ok') {
                                /*
                                if(data.smspasien==0){
                                  var params = [];
                                  params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16
                                  insert_notifikasi(params);
                                }
                                */
                                if (data.pesan == 'exist') {
                                    myAlert(data.keterangan);
                                } else {
                                    //window.location = "<?php //echo Yii::app()->createUrl('index&status=1')
                                                            ?>";
                                    $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                        data: $(this).serialize()
                                    });
                                }
                            } else {
                                if (data.status == 'exist') {
                                    myAlert('Pasien telah melakukan pemeriksaan');
                                }
                            }
                        }, 'json'
                    );
                }
            });
        }

        function ambilAntrianTerakhir() {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
                dataType: "json",
                success: function(data) {
                    if (data.pesan == "") {
                        panggilAntrian(data.pasienmasukpenunjang_id);
                        setSuaraPanggilanSingle(data.ruangan_singkatan, data.no_urutperiksa, data.ruangan_id);
                    } else {
                        myAlert(data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
        /**
         * memanggil antrian ke poliklinik
         * @param {type} pendaftaran_id
         * @returns {undefined} */
        function panggilAntrian(pasienmasukpenunjang_id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('Panggil'); ?>',
                data: {
                    pasienmasukpenunjang_id: pasienmasukpenunjang_id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.pesan !== "") {
                        myAlert(data.pesan);
                    }
                    if (data.smspasien == 0) {
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                            judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                            isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                        }; // 16
                        insert_notifikasi(params);
                    }
                    <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                        console.log("ANTRIAN PENUNJANG : emitting...");
                        socket.emit('send', {
                            conversationID: 'antrian',
                            panggil: 3,
                            antrian_id: pasienmasukpenunjang_id
                        });
                        setSuaraPanggilanSingle(data.ruangan_singkatan, data.no_urutperiksa, data.ruangan_id);
                    <?php } ?>
                    $.fn.yiiGridView.update('daftarpasien-v-grid');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
        /**
         * suara panggilan per ruangan
         * @param {type} param
         * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
         */
        function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id) {
            $("#suarapanggilan").attr("src", "<?php echo $this->createUrl('/antrian/tampilAntrianKePenunjang/suaraPanggilanSingle'); ?>&kodeantrian=" + kodeantrian + "&noantrian=" + noantrian + "&ruangan_id=" + ruangan_id);
        }
    }
    /**
     *
     * @param {type} pendaftaran_id
     * @param {type} statusperiksa
     * @param {type} namaPasien
     * @returns {undefined}
     */
    function dialogBatalPeriksa(pendaftaran_id, penunjang_id, namaPasien) {
        $('#titleNamaPasienBatal').html(namaPasien);
        $('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
        $('#DialogBatalperiksa #penunjang_id').val(penunjang_id);
        $('#DialogBatalperiksa').dialog('open');
    }

    function ubahPeriksaKarenaBatal() {
        var pendaftaran_id = $('#DialogBatalperiksa #pendaftaran_id').val();
        var penunjang_id = $('#DialogBatalperiksa #penunjang_id').val();
        var tglbatal = $('#DialogBatalperiksa #tglbatal').val();
        var keterangan_batal = $('#DialogBatalperiksa #keterangan_batal').val();
        $('#DialogBatalperiksa #keterangan_batal').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
            $('#DialogBatalperiksa #keterangan_batal').attr('class', 'error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('batalPemeriksaan'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                tglbatal: tglbatal,
                keterangan_batal: keterangan_batal,
                idPenunjang: penunjang_id
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    /*
				if(data.smspasien==0){
				  var params = [];
				  params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16
				  insert_notifikasi(params);
				}
				*/
                    if (data.pesan == 'exist') {
                        myAlert(data.keterangan);
                    } else {
                        //window.location = "<?php //echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1')
                                                ?>";
                        $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $(this).serialize()
                        });
                        $('#DialogBatalperiksa #keterangan_batal').val('');
                        $('#DialogBatalperiksa').dialog('close');
                    }
                } else {
                    if (data.status == 'exist') {
                        myAlert('Pasien telah melakukan pemeriksaan');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function lihatHasilPeriksa(studyID, accessionNumber, patientID) {
        var server = "";
        <?php if (Yii::app()->user->getState('weasis_aktif') == true) {
             $modKonfig = KonfigsystemK::model()->find();
             $host_temp =  $modKonfig->weasis_host;
             $host_temp2 =  $modKonfig->weasis_port;
             $host_temp3 = $host_temp.":".$host_temp2;
             $host = "http://".$host_temp3;
        ?>

            $("#frameWeasis").attr("src", "<?php echo $host; ?>/weasis-pacs-connector/weasis?patientID=" + patientID + "&&studyUID=" + studyID);

        <?php } ?>

        <?php if (Yii::app()->user->getState('oviyam_aktif') == true) {
            $modKonfig = KonfigsystemK::model()->find();
            $host_temp =  $modKonfig->oviyam_host;
            $host_temp2 =  $modKonfig->oviyam_port;
            $host_temp3 = $host_temp.":".$host_temp2;
            $host = $host_temp3;
            $server = Yii::app()->user->getState('oviyam_server');


        ?>
            server = "<?php echo !empty($server) ? $server : "" ?>";
            window.open("<?php echo $host; ?>/oviyam2/oviyam?patientID=" + patientID + "&studyUID=" + studyID + "&serverName=" + server, "_blank", "location=_new, width=1024px");
            console.log("host temp "+'<?= $host_temp?>');
            console.log("host temp 2"+'<?= $host_temp2?>');
            console.log("host temp 3"+'<?= $host_temp3?>');
            console.log("host "+'<?= $host?>');
            // link-nya 
            // http://192.168.214.222:8080/oviyam2/viewer.html?patientID=1253&studyUID=1.2.840.86.755.8.3453.1.20769.100023007220202154343594031698&serverName=ServerUbuntu
            // link yang lama 
            // window.open("<?php // echo $host ?>/oviyam2/oviyam?patientID="+instalasi_id+"&pendaftaran_id="+pendaftaran_id,"",'location=_new, width=1024px');

            // $("#frameOviyam").attr("src", "<?php // echo $host; ?>/oviyam2/oviyam?serverName=<?php // echo $server; ?>&studyUID=" + studyID + "&accessionNumber=" + accessionNumber + "&patientID=" + patientID);
            // $("#dialogOviyam").dialog("open");
        <?php } ?>
    }

    function ubahDokterPeriksa(pendaftaran_id) {
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('ubahDokterPeriksa') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
                } else {
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('form').serialize()
                    });
                    setTimeout("$('#editDokterPeriksa').dialog('close') ", 500);
                }
            },
            'cache': false
        });
        return false;
    }


    function pemeriksaanSelesai(id) {
        
        myConfirm("Apakah anda yakin ingin pemeriksaan sudah selesai dilakukan?","Perhatian!", function(r){            
            if (r){
                $.ajax({
                    type:'POST',
                    url: '<?php echo Yii::app()->controller->createUrl('daftarPasien/pemeriksaanSelesai') ?>&id=' + id,
                    data: {
                        // pasienmasukpenunjang_id: id,                
                    },
                    dataType: "json",
                    success:function(data){                
                        if (data.sukses == 1){
                            toastr.success("Data berhasil diupdate","Perhatian!");

                            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                data: $("#daftarPasien-form").serialize()
                            });
                        }else{
                            toastr.error("Data gagal diupdate","Perhatian!");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
            }
        });
    }

    $(document).ready(function() {
        jQuery($("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'nama_dokterasal') ?>")).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });

    function verifikasi(pasienmasukpenunjang_id) {
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('cekVerifikasi'); ?>',
                data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
                dataType: "json",
                    success:function(data){
                        if(data.status == true){
                             $.fn.yiiGridView.update('daftarpasien-v-grid');
                        }else{
                            myAlert(data.pesan);
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

    function siapKirimRad(pasienmasukpenunjang_id) {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('siapKirimRad'); ?>',
            data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
            dataType: "json",
                success:function(data){
                    if(data.status == true){
                         $.fn.yiiGridView.update('daftarpasien-v-grid');
                    }else{
                        myAlert(data.pesan);
                    }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    function terimaHasilRad(pasienmasukpenunjang_id) {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('terimaHasilRad'); ?>',
            data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
            dataType: "json",
                success:function(data){
                    if(data.status == true){
                         $.fn.yiiGridView.update('daftarpasien-v-grid');
                    }else{
                        myAlert(data.pesan);
                    }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

    function ambilHasilRad(pasienmasukpenunjang_id) {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('ambilHasilRad'); ?>',
            data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
            dataType: "json",
                success:function(data){
                    if(data.status == true){
                         $.fn.yiiGridView.update('daftarpasien-v-grid');
                    }else{
                        myAlert(data.pesan);
                    }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });

    }

    function ubahWarna(){
        // find baris kolom 
        $('#daftarpasien-v-grid > table > tbody > tr').each (function(){
            var tbl = $(this).find('.ubah').val();
            var tbl_selesai = $(this).find('.ubah-selesai').val();
            
            if (tbl === "ya") {
                // set jika nilai selain kondisi di atas warna merah
                $(this).find('td').attr('style', 'background: #F5B9B9 !important');
            } else {
                 // set jika kondisi di atas warna putih
                $(this).find('td').attr('style', 'background: white !important'); 
            }

            if(tbl_selesai == "ya") {
                $(this).find('td').attr('style', 'background: #9ADBB3 !important');
            }


        }); 
    }

    function verifikasiAntrian(pasienmasukpenunjang_id){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('VerifikasiAntrian'); ?>',
                data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
                dataType: "json",
                success:function(data){
                    if(data.pesan !== ""){
                        myAlert(data.pesan);
                        $.fn.yiiGridView.update('daftarpasien-v-grid');
                    }else{
                        myAlert("Pasien sudah diverifikasi");
                        $.fn.yiiGridView.update('daftarpasien-v-grid');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }

        const konfigurasiLabel = (id) => {
        $.get('<?= $this->createUrl('loadKonfigurasiLabel') ?>', {
            id: id
        },
        function(data) {            
            $("#dialogKonfigurasiLabel").dialog("open");                            
            $("#konfigurasi-label").html(data.html);
        }, "json");    
    }

    function setJenisPasien(obj, jenis) {
        console.log('jenis pasien: ' + jenis);

        $('#tab-periksa li').removeClass('active');
        $(obj).addClass('active');
        $('.jenis_pasien').val(jenis);

        $('#daftarPasien-form').submit();

    }

    $(document).ready(function () {

        ubahWarna();
    });
    
</script>


<?php
// Dialog untuk Melihat dokumen RM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokFilerm',
    'options' => array(
        'title' => 'Riwayat Dokumen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!-- END DOKUMEN -->