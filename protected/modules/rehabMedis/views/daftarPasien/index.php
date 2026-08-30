	<?php
    /**
     * view utama menampilkan menu informasi daftar pasien
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * @version     2.0.0
     * @link    <http://piindonesia.co.id>
     */
    $this->breadcrumbs = array(
        'Informasi Daftar Pasien',
    );
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $modul = $this->module->name;
    $control = $this->id;
    Yii::app()->clientScript->registerScript('cari wew', "
$('#daftarPasien-form').submit(function(){
	$.fn.yiiGridView.update('daftarpasien-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
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
                'action'         => Yii::app()->createUrl($this->route),
                'method'         => 'get',
                'id'             => 'daftarPasien-form',
                'type'             => 'horizontal',
                'focus'             => '#' . CHtml::activeId($modPasienMasukPenunjang, 'no_pendaftaran'),
                'htmlOptions'     => array('enctype' => 'multipart/form-data'),
            ));
            ?>
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
	                            <label for="namaPasien" class="control-label">Tanggal Masuk</label>
	                            <div class="controls">
	                                <?php
                                    $format = new MyFormatter;
                                    $this->widget('MyDateTimePicker', array(
                                        'model'             => $modPasienMasukPenunjang,
                                        'attribute'         => 'tgl_awal',
                                        'mode'             => 'date',
                                        'options'         => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate'     => 'd',
                                        ),
                                        'htmlOptions'     => array('readonly' => true, 'class' => 'dtPicker3 span3'),
                                    ));
                                    ?>
	                            </div>
	                        </div>
	                        <div class="control-group">
	                            <?php echo CHtml::label(' Sampai Dengan', ' s/d', array(
                                    'class' => 'control-label'
                                )) ?>
	                            <div class="controls">
	                                <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model'             => $modPasienMasukPenunjang,
                                        'attribute'         => 'tgl_akhir',
                                        'mode'             => 'date',
                                        'options'         => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate'     => 'd',
                                        ),
                                        'htmlOptions'     => array('readonly' => true, 'class' => 'dtPicker3 span3'),
                                    ));
                                    ?>
	                            </div>
	                        </div>
	                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_pendaftaran', array(
                                'placeholder' => 'No. Pendaftaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'maxlength' => 50
                            )); ?>
	                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array(
                                'placeholder' => 'Nama Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'maxlength' => 50
                            )); ?>
	                        <div class="control-group">
	                            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
	                            <div class="controls">
	                                <?php echo $form->textField($modPasienMasukPenunjang, 'no_identitas_pasien', array('class' => 'span3 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
	                            </div>
	                        </div>
	                        <div class="control-group">
	                            <?php $modPasienMasukPenunjang->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
	                            <?php echo CHtml::label(CHtml::activeCheckBox($modPasienMasukPenunjang, 'ceklis') . " <label for='RMMasukPenunjangV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
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
                                            'readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>
	                            </div>
	                        </div>
	                        <div class="control-group">
	                            <?php $modPasienMasukPenunjang->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
	                            <?php echo CHtml::label(' Sampai Dengan', '', array('class' => 'control-label')) ?>
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
                                            'readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-6">

	                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_bin', array(
                                'placeholder' => 'Nama Panggilan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'maxlength' => 50
                            )); ?>
	                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_rekam_medik', array(
                                'placeholder' => 'No. Rekam Medik', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'maxlength' => 50
                            )); ?>
	                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'pegawai_id', CHtml::listData(RMPendaftaranT::model()->getDokterItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
	                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'statusperiksa', Params::statusPeriksa(), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
	                        <?php
                            echo $form->dropDownListRow($modPasienMasukPenunjang, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->getInstalasiPelayanans(), 'instalasi_id', 'instalasi_nama'), array(
                                'empty' => '-- Pilih --',
                                'class' => 'span3',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                    'success' => 'function(data){$("#' . CHtml::activeId($modPasienMasukPenunjang, "ruanganasal_id") . '").html(data); }',
                                ),
                            ));
                            echo $form->dropDownListRow($modPasienMasukPenunjang, 'ruanganasal_id',  CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array('order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
                            ?>
	                        <?php //echo $form->dropDownListRow($modPasienMasukPenunjang, 'instalasi_id', CHtml::listData(InstalasiM::model()->getInstalasiPelayanans(), 'instalasi_id', 'instalasi_nama'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",)); 
                            ?>
	                        <?php //echo $form->dropDownListRow($modPasienMasukPenunjang, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array('order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",)); 
                            ?>
	                    </div>
	                </div>
	                <div class="form-actions">
	                    <?php
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                            array(
                                'title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'
                            )
                        );
                        ?>
	                    <?php echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl('daftarPasien/index'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default'
                            )
                        ); ?>
	                    <?php
                        $content = $this->renderPartial('../tips/informasi', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        ?>
	                </div>
	            </div>
	        </div>
	        <div class="panel panel-success">
	            <div class="panel-heading">
	                <div class="panel-title">
	                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Pasien</b>
	                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array(
                            '{icon}' => '<i class="icon-volume-up icon-white"></i>'
                        )), array(
                            'title' => 'Klik untuk memanggil antrian terakhir',
                            'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'ambilAntrianTerakhir();',
                            'style' => 'font-size:10px;'
                        )); ?>
	                </div>
	            </div>
	            <div class="panel-body table-responsive">
	                <?php
                        $this->renderPartial('_tablePasien',['modPasienMasukPenunjang' => $modPasienMasukPenunjang]);
                    ?>
	            </div>
	        </div>
	        <?php echo $this->renderPartial("_dialogPersetujuan", array(), true); ?>
	        <iframe id="suarapanggilan" src="" style="display: none;"></iframe>
	        <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id'         => 'dialogLihatHasil',
                'options'     => array(
                    'title'         => 'Detail Hasil Pemeriksaan',
                    'autoOpen'     => false,
                    'modal'         => true,
                    'width'         => 900,
                    'height'     => 400,
                    'resizable'     => false,
                ),
            ));
            ?>
	        <iframe name='frameLihatHasil' src="" style="width:100%; height: 98%;"></iframe>
	        <?php $this->endWidget(); ?>
	        <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'         => 'dialogRincianTagihan',
                'options'     => array(
                    'title'         => 'Rincian Tagihan',
                    'autoOpen'     => false,
                    'modal'         => true,
                    'zIndex'     => 1001,
                    'minWidth'     => 1024,
                    'height'     => 400,
                    'resizable'     => true,
                ),
            ));
            ?>
	        <iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
	        <?php
            $this->endWidget();
            ?>
	        <?php $this->endWidget(); ?>
	    </div>
	</div>
	<script type="text/javascript">
	    //	document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:none;");
	    //	document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:none;");

        function cektindaklanjut() {
            myAlert("Pasien sudah ditindak lanjut");
        }
	    function cekTanggal() {
	        var checklist = $('#RMMasukPenunjangV_ceklis');
	        var pilih = checklist.attr('checked');
	        // var tgl_masuk = $(document)
	        if (pilih) {
	            // document.getElementById('RMMasukPenunjangV_tgl_awal').disabled = false;
	            // document.getElementById('RMMasukPenunjangV_tgl_akhir').disabled = false;
	            document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:block;");
	            document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:block;");
	        } else {
	            // document.getElementById('RMMasukPenunjangV_tgl_awal').disabled = true;
	            // document.getElementById('RMMasukPenunjangV_tgl_akhir').disabled = true;
	            document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:none;");
	            document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:none;");
	        }
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
	                    simpanNotifikasi(params);
	                }
	                <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
	                    socket.emit('send', {
	                        conversationID: 'antrian',
	                        panggil: 1,
	                        antrian_id: pasienmasukpenunjang_id
	                    });
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
	</script>
	<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'         => 'DialogBatalperiksa',
        // additional javascript options for the dialog plugin
        'options'     => array(
            'title'         => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
            'autoOpen'     => false,
            //		'show'=>'blind',
            //		'hide'=>'explode',
            'zIndex'     => 1002,
            'minWidth'     => 500,
            'height'     => 100,
            'resizable'     => false,
            'modal'         => true,
        ),
    ));
    $this->renderPartial('_formBatalPeriksaDialog');
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>

	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Riwayat Peminahaan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'height' => 550,
            'resizable' => false
        ),
    ));
    ?>
	<iframe name='frameDetail' width="100%" height="98%"></iframe>
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
    $urlPrintKlaim = Yii::app()->createUrl('rehabMedis/PendaftaranRehabilitasiMedis/printKlaim', array('pendaftaran_id' => ''));
    $js = <<< JSCRIPT
//=======================================Awal Print Lembar Poli==========================================================
function print(pendaftaran_id)
{
   window.open('${urlPrintKlaim}'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=400');    
}
//========================================Akhir Ganti Ruangan===========================================================
JSCRIPT;
    ?>
	<?php echo $this->renderPartial('_jsFunctions', array()); ?>

    <?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBuatJadwal',
    'options' => array(
        'title' => 'Kunjungan Rehab Medis',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<iframe id='frameBuatJadwal', name='frameBuatJadwal' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>