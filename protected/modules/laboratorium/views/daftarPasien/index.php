<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$autoopen = Yii::app()->user->getState('isantrian');
?>
<?php
$this->breadcrumbs = array(
    'Informasi Daftar Pasien'
);
//    $this->breadcrumbs=array(
//	'Informasi Daftar Pasien'=>Yii::app()->request->getUrlReferrer(),
//	'Daftar Pasien',
//);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Daftar Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] > 0) { // Jika berhasil disimpan
                Yii::app()->user->setFlash('success', "Data pemeriksaan lab berhasil disimpan!");
            }
        }
        ?>
        <?php
        //============= PRINT LABEL sebelumnya ==============
        // if(isset($_GET['caraPrint'])){
        // $pendaftaran_id = $_GET['id'];
        // $urlPrint=  Yii::app()->createAbsoluteUrl('laboratorium/pendaftaranPasienLuar/print', array('id_pendaftaran'=>$pendaftaran_id));
        // $js = <<< JSCRIPT
        // function printLabel(caraPrint)
        // {
        //     window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
        // }
        //     printLabel('PRINT');
        // JSCRIPT;
        // Yii::app()->clientScript->registerScript('printLabel',$js,CClientScript::POS_HEAD);     
        // }
        ?>
        <?php
        //============= PRINT LABEL DAN TINDAKAN ==============
        if (isset($_GET['caraPrint'])) {
            $pendaftaran_id = $_GET['id'];
            $id_pasienpenunjang = $_GET['idPasienPenunjang'];
            $labelOnly = 1;
            $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/pendaftaranPasienLuar/print', array('id_pendaftaran' => $pendaftaran_id, 'id_pasienpenunjang' => $id_pasienpenunjang, 'labelOnly' => $labelOnly));
            $urlPrintTindakan =  Yii::app()->createAbsoluteUrl($this->module->id . '/pendaftaranLab/print', array('id_pendaftaran' => $pendaftaran_id, 'labelOnly' => $labelOnly));
            // $js = <<< JSCRIPT
            // 	function printLabel(caraPrint)
            // 	{
            // 		window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
            // 		window.open("${urlPrintTindakan}&caraPrint="+caraPrint,"",'location=_new, width=980px');
            // 	}
            // 	printLabel('PRINT');
            //     JSCRIPT;
            // Yii::app()->clientScript->registerScript('printLabel', $js,  CClientScript::POS_HEAD);
        }
        ?>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('cari cari', "
				$('#daftarPasien-form').submit(function(){
					$('#daftarpasien-v-grid').addClass('animation-loading');
					$.fn.yiiGridView.update('daftarpasien-v-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
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
                    'focus' => '#' . CHtml::activeId($modPasienMasukPenunjang, 'no_rekam_medik'),
                    'htmlOptions' => array(),
                )); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Masuk Penunjang", 'tglmasukpenunjang', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Status Permeriksaan</label>
                            <div class="controls">
                                <?php // echo $form->textField($modPasienMasukPenunjang,'statusperiksahasil',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                                ?>
                                <?php echo $form->dropDownList($modPasienMasukPenunjang, 'statusperiksahasil',  CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'statusperiksahasil', 'lookup_aktif' => true)), 'lookup_value', 'lookup_name'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $prefix = array(
                                    0 => Params::PREFIX_RAWAT_DARURAT,
                                    1 => Params::PREFIX_RAWAT_INAP,
                                    2 => Params::PREFIX_RAWAT_JALAN,
                                    // 3 => Params::PREFIX_LABORATORIUM
                                );
                                echo $form->dropDownList($modPasienMasukPenunjang, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                                ?>
                                <?php echo $form->textField($modPasienMasukPenunjang, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 12, 'placeholder' => 'No. Pendaftaran')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">No. Rekam Medik</label>
                            <div class="controls">
                                <?php echo $form->textField($modPasienMasukPenunjang, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 8)); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <div class="control-group">
                            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPasienMasukPenunjang, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modPasienMasukPenunjang->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($modPasienMasukPenunjang, 'ceklis') . " <label for='LBPasienMasukPenunjangV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
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
                                        'readonly' => true, 'class' => 'dtPicker3 span4', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                                        'readonly' => true, 'class' => 'dtPicker3 span4', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'nama_dokterasal', DokterV::model()->getDropDokterResepByNama(), array('multiple' => 'multiple')) ?>
                        <?php $instalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_id' => array(2, 3, 4),));
                        $ruangan = RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                            'ruangan_aktif' => true,
                        ), array(
                            'order' => 'instalasi_id, ruangan_nama',
                        ));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modPasienMasukPenunjang, "ruanganasal_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        ?>
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
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modPasienMasukPenunjang, "penjamin_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        ?>
                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'statusperiksa',  LookupM::getItems('statusperiksa'), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array(
                            'autofocus' => true,
                            'class' => 'btn btn-danger',
                            'title' => 'Cari',
                            'type' => 'submit',
                            'id' => 'btn_simpan'
                        )
                    );
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-default',
                            'title' => 'Ulang',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                </div>
                <?php $this->endWidget(); ?>
                <iframe id="suarapanggilan" src="" style="display: none;"></iframe>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Pasien</b>&nbsp;
                    <?php echo ($autoopen == true) ? CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian terakhir', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'ambilAntrianTerakhir();', 'style' => 'font-size:10px;')) : ''; ?>
                    <?php //echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian terakhir','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'ambilAntrianTerakhir();','style'=>'font-size:10px;')); 
                    ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $daftar = $modPasienMasukPenunjang->searchLab();
                if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_ANATOMI) {
                    $daftar = $modPasienMasukPenunjang->searchLabAnatomi();
                }

                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <div class="block-tabel">
                   <?php $this->renderPartial('_tablePasien', ['daftar' => $daftar]) ?>
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
                // Dialog untuk Lihat Hasil =========================
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'dialogLihatHasil',
                    'options' => array(
                        'title' => 'Hasil Pemeriksaan Laboratorium',
                        'autoOpen' => false,
                        'modal' => true,
                        'minWidth' => 980,
                        'height' => 450,
                        'resizable' => true,
                    ),
                ));
                ?>
                <iframe src="" name="iframeLihatHasil" width="100%" height="500">
                </iframe>
                <?php
                $this->endWidget();
                //========= end Lihat Hasil =============================
                ?>
                <?php
                // Dialog untuk Pengambilan Hasil =========================
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'dialogAmbilHasil',
                    'options' => array(
                        'title' => 'Penyerahan Hasil Laboratorium',
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
                <iframe src="" name="iframeAmbilHasil" width="100%" height="500">
                </iframe>
                <?php
                $this->endWidget();
                //========= end Pengambilan Hasil =============================
                ?>
            </div>
        </div>
    </div>
</div>
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
        'minWidth' => 500,
        'minHeight' => 100,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================
?>
<script type="text/javascript">
    function printUlangNotaTindakan(pendaftaran_id)
    {
        window.open('<?php echo $this->createUrl('/laboratorium/daftarPasien/PrintUlangTindakan'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=1080,height=640');
    }

    function batalstatusperiksa(pendaftaran_id, idPenunjang) {
        myConfirm('Apakah Anda akan membatalkan status pemeriksaan ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/CancelPemeriksaanAjax') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        idPenunjang: idPenunjang
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            // window.location = "<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1') ?>";
                            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                data: $(this).serialize()
                            });
                        } else {
                            if (data.status == 'gagal') {
                                myAlert('Pembatalan pemeriksaan gagal');
                            }
                        }
                    }, 'json'
                );
            }
        });
    }

    function approveperiksa(pendaftaran_id, idPenunjang) {
        myConfirm('Apakah Anda akan menyetujui pemeriksaan ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/ApprovePemeriksaanAjax') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        idPenunjang: idPenunjang
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            //window.location = "<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1') ?>";
                            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                data: $(this).serialize()
                            });
                        } else {
                            if (data.status == 'gagal') {
                                myAlert('Pemeriksaan gagal disetujui');
                            }
                        }
                    }, 'json'
                );
            }
        });
    }

    function batalperiksa(pendaftaran_id, idPenunjang) {
        myConfirm('Anda yakin akan membatalkan pemeriksaan laboratorium pasien ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/batalPenunjang') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        idPenunjang: idPenunjang
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
                                //window.location = "<?php //echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1')
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
            } else {
                //       myAlert('tidak');
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

    function verifkirim(pendaftaran_id, pasienmasukpenunjang_id) {
        myConfirm('Apakah Anda ingin mengirim pesan ke Whatsapp Pasien?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/Kirimwapas') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        pasienmasukpenunjang_id: pasienmasukpenunjang_id
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            //window.location = "<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1') ?>";
                            // $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            //     data: $(this).serialize()
                            // });
                            // var params = [];
                            // params = {
                            //     instalasi_id: <?php //echo Yii::app()->user->getState("instalasi_id"); ?>,
                            //     modul_id: <?php //echo Yii::app()->session['modul_id']; ?>,
                            //     judulnotifikasi: 'Pesan Whatsapp Terkirim',
                            //     isinotifikasi: 'Pesan terkirim kepada ' + data.nama_pasien + data.no_rekam_medik
                            // }; // 16 
                            // insert_notifikasi(params);
                        } else {
                            var params = [];
                            params = {
                                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                                judulnotifikasi: 'Pesan Whatsapp Gagal Terkirim',
                                isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                            }; // 16 
                            insert_notifikasi(params);
                            // if (data.status == 'gagal') {
                            //     myAlert('Pasien tidak memiliki No. Mobile');
                            // }
                        }
                    }, 'json'
                );
            }
        });
    }

    function verifkirimdpjp(pendaftaran_id, pasienmasukpenunjang_id) {
        myConfirm('Apakah Anda ingin mengirim pesan ke Whatsapp Dokter Penanggungjawab?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/Kirimwadp') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        pasienmasukpenunjang_id: pasienmasukpenunjang_id
                    },
                    function(data) {
                        if (data.status == 'ok') {
                        } else {
                            var params = [];
                            params = {
                                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                                judulnotifikasi: 'Pesan Whatsapp Gagal Terkirim',
                                isinotifikasi: 'Dokter Penanggungjawab tidak memiliki nomor mobile' //' + data.nama_pegawai + ' 
                            }; // 16 
                            insert_notifikasi(params);
                        }
                    }, 'json'
                );
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
    //    if(alasan==''){
    //        myAlert('Anda Belum Mengisi Alasan Pembatalan');
    //    }else{
    //        $.post('<?php //echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap');
                        ?>', $('#formAlasan').serialize(), function(data){
    ////            if(data.error != '')
    ////                myAlert(data.error);
    ////            $('#'+data.cssError).addClass('error');
    //            if(data.status=='success'){
    //                batal();
    //                myAlert('Data Berhasil Disimpan');
    //                location.reload();
    //            }else{
    //                myAlert(data.status);
    //            }
    //        }, 'json');
    //   }     
    $(document).ready(function() {
        jQuery($("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'nama_dokterasal') ?>")).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
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
            url: '<?php echo $this->createUrl('batalPenunjang'); ?>',
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
                      params = {instalasi_id:<?php //echo Yii::app()->user->getState("instalasi_id"); 
                                                ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                      insert_notifikasi(params);
                    }
                    */
                    if (data.pesan == 'exist') {
                        myAlert(data.keterangan);
                    } else {
                        // window.location = "<?php //echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1') 
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
</script>
<?php
// Dialog untuk diagnosa=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 700,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDiagnosa" width="100%" height="700"></iframe>
<?php $this->endWidget(); ?>

<?php
//=============================== Dialog Upload Dokumen Rekam Medis =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogUploadFile',
        'options' => array(
            'title' => 'Upload Dokumen Rekam Medis',
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

echo '<iframe name="frameUploadFile" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailDataPenunjang',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1200,
        'height' => 700,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogPenunjang" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

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