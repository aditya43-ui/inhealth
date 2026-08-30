<?php $linkHalaman = CustomFunction::getUrlByMenuID(754); ?>
<?php
$j = JabatanM::model()->findByPk(Params::JABATAN_ID_KASI_PERSONALIA);
$jabAkses = array(
    'jabatan_id' => Yii::app()->user->getState('jabatan_id'),
    'jabatan_nama' => (!empty($j)) ? $j->jabatan_nama : null,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Presensi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Presensi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->breadcrumbs = array(
                    'Informasi Presensi',
                );
                Yii::app()->clientScript->registerScript('search', "
                           $('#kppresensi-t-search').submit(function(){
                                $.fn.yiiGridView.update('kppresensi-t-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                           });
                           ");
                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kppresensi-t-grid',
                    'dataProvider' => $model->searchInfoTable(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                        ),
                        array(
                            'header' => 'No. FP',
                            'name' => 'no_fingerprint'
                        ),
                        array(
                            'header' => 'Kelompok Pegawai/<br> Jabatan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data["kelompokpegawai_nama"] . '/<br>' . $data["jabatan_nama"];
                            }
                        ),
                        array(
                            'header' => 'NIP',
                            'name' => 'nomorindukpegawai'
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'nama_pegawai'
                        ),
                        array(
                            'header' => 'Shift Kerja',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data['shift_id'])) {
                                    return $data['shift_nama'] . '/<br>' . $data['shift_jamawal'] . '-' . $data['shift_jamakhir'];
                                }
                            }
                        ),
                        array(
                            'header' => 'Tgl. Presensi',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data['tglpresensi']);
                            }
                        ),
                        array(
                            'header' => 'Masuk',
                            'value' => '$data["jamscan_masuk"]'
                        ),
                        array(
                            'header' => 'Keluar',
                            'value' => '$data["jamscan_keluar"]'
                        ),
                        array(
                            'header' => 'Datang',
                            'value' => '$data["jamscan_datang"]'
                        ),
                        array(
                            'header' => 'Pulang',
                            'value' => '$data["jamscan_pulang"]'
                        ),
                        array(
                            'header' => 'Terlambat',
                            'value' => function ($data) {
                                if (!empty($data['terlambat_mnt']) || $data['terlambat_mnt'] > 0) {
                                    return $data['terlambat_mnt'] . 'm';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Pulang Awal',
                            'value' => function ($data) {
                                if (!empty($data['pulangawal_mnt']) || $data['pulangawal_mnt'] > 0) {
                                    return $data['pulangawal_mnt'] . 'm';
                                }
                                /*if ($data['verifikasi'] != true){
													if (!empty($data['shift_id'] && !empty($data['jamscan_pulang']))){
														if ($data['shift_jamawal'] < $data['shift_jamakhir']){
															if ($data['verifikasi'] != true){
																$shiftakhir = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['shift_jamakhir']);
																$scantakhir = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_pulang']);
															}else{
																$shiftakhir = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjapulang']);
																$scantakhir = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_pulang']);
															}
															$jam = round(round(abs($scantakhir - $shiftakhir) / 60,2));
															if ($data['jamscan_pulang'] < $data['shift_jamakhir']){
																if ($jam > 0){															
																	return $jam.'m';																																														
																}
															}
														}
													}
												}else{
													return $data['pulangawal_mnt'].'m';
												}*/
                            },
                            'htmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Status Kehadiran',
                            'type' => 'raw',
                            'value' => function ($data) use ($jabAkses, &$status) {
                                $data['jabatanuser_id'] = $jabAkses['jabatan_id'];
                                $data['jabatanuser_nama'] = $jabAkses['jabatan_nama'];
                                $status = $data['statuskehadiran_nama'];
                                if ($data['verifikasi'] != true) {
                                    if (empty($data['jamscan_masuk']) || empty($data['jamscan_pulang'])) {
                                        $status = Params::STATUSKEHADIRAN_NAMA_ALPHA;
                                        return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, $data['verifikasi'], $data);
                                    }
                                    return Params::getWarnaKehadiran($data['statuskehadiran_nama'], $data['verifikasi'], $data);
                                    // return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, $data['verifikasi'],$data);																										
                                } else {
                                    return  Params::getWarnaKehadiran($data['statuskehadiran_nama'], $data['verifikasi'], $data);
                                }
                            },
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => function ($data) use (&$is_kosong) {
                                if ($data['keterangan'] != '') {
                                    return $data['keterangan'];
                                }
                                $is_kosong = true;
                                if (!empty($data['shift_id'])) {
                                    $pesan = 'Tidak ada';
                                    if (empty($data['jamscan_masuk'])) {
                                        $pesan .= ' jam masuk ';
                                    } else {
                                        $is_kosong = false;
                                    }
                                    if (empty($data['jamscan_pulang'])) {
                                        if ($pesan == 'Tidak ada') {
                                            if ($data['tglpresensi'] . ' ' . $data['shift_jamakhir'] <= date('Y-m-d H:i:s')) {
                                                $pesan .= ' jam pulang ';
                                            }
                                        } else {
                                            if ($data['tglpresensi'] . ' ' . $data['shift_jamakhir'] <= date('Y-m-d H:i:s')) {
                                                $pesan .= ' dan jam pulang ';
                                            }
                                        }
                                    } else {
                                        $is_kosong = false;
                                    }
                                    if ($pesan != 'Tidak ada') {
                                        return "<span style='color:#aa0808'>" . $pesan . "</span>";
                                    }
                                } else {
                                    return "<span style='color:#aa0808'>Shift belum di set</span>";
                                }
                            }
                        ),
                        array(
                            'header' => 'Hapus Absensi',
                            'type' => 'raw',
                            'value' => function ($data) use (&$is_kosong, &$status) {
                                //                                                if ($is_kosong && !in_array($status, array(
                                //                                                    Params::STATUSKEHADIRAN_NAMA_CUTI,
                                //                                                    Params::STATUSKEHADIRAN_NAMA_DINAS,
                                //                                                    Params::STATUSKEHADIRAN_NAMA_IZIN,
                                //                                                    Params::STATUSKEHADIRAN_NAMA_SAKIT,
                                //                                                ))) {
                                //                                                    return "";
                                //                                                }
                                $data['tglpresensi_format'] = MyFormatter::formatDateTimeForUser($data['tglpresensi']);
                                //                                                if (empty($data['isfingerprintscan']) || $data['isfingerprintscan'] == false) {
                                return CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                                    'rel' => 'tooltip',
                                    'title' => 'Klik untuk hapus presensi.',
                                    'onclick' => 'formHapusPresensi(' . CJSON::encode($data) . '); return false;',
                                ));
                                //                                                }
                                //                                                return "-";
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center',
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<?php
//.'/images/ajax-loader.gif'
$url_image = Yii::app()->getBaseUrl('webroot');
Yii::app()->clientScript->registerScript('onheadfungsi', '
        var interval;
    function updateTable(){
        $.fn.yiiGridView.update("kppresensi-t-grid", {
                data: $(".search-form form").serialize()
        });
    }
    function setAuto(){
        if ($("#atur").is(":checked")){
            atur = $("#atur").val();
        }else{
            atur = 0;
        }
        $.post("' . Yii::app()->createUrl('actionAjax/turnAutoRefresh') . '",{atur:atur},function(data){
        });
    }
    function ambilData(ip,key){
        $.post("' . Yii::app()->createUrl('kepegawaian/presensiT/ambilData') . '",{ip:ip,key:key},function(data){
            if (data == 1){
                updateTable();
                hideLoadingMsg();
                $("#finger").val("");
            }
        });
    }
    function beat(){
        $.post("' . Yii::app()->createUrl('kepegawaian/presensiT/ambilData') . '",{},function(data){
            if (data == 1){
                updateTable();
            }
        });
    }
    function statusOff()
    {
        setInterval(function(){
            hideLoadingMsg();
        },10000);
    }
    function showLoadingMsg()
    {
        var over = \'<div id="overlay">\' + \'<img id="loading" src="images/ajax-loader.gif">\' + \'</div>\';
        $(over).appendTo(\'body\');
    }
    function hideLoadingMsg()
    {
        $(\'#overlay\').remove();
        aktifkanFinger($("#is_disconnect"), true);
    }    
function aktifkanFinger(obj,disconnect){
    var idAlat = $("#finger").val();
    var data = {idAlat:idAlat};
    if (disconnect){
        data = {idAlat:idAlat,disconnect:true};
    }
    if (jQuery.isNumeric(idAlat)){
        $(obj).parents(".controls").find("select, input#connect").attr("disabled","disabled");
        $.ajax({
            dataType:"json",
            data: data,
            success:function(data){
                if (disconnect){
                   if (data.success == true){
                        clearInterval(interval);
                        if ($("#infokoneksi").not(":hidden")){
                            $("#infokoneksi").slideUp();
                        }
                        $("#status-connection").html("");
                        $("#ip-connection").html("");
                        $("#lokasi-connection").html("");
                        $("select#finger, input#connect").removeAttr("disabled");
                        //clearInterval(interval);
                    }
                }else{
                    if ($("#infokoneksi").is(":hidden")){
                        $("#infokoneksi").slideDown();
                    }
                    var statusKoneksi;
                    if(data.success == 1 && data.connection == true){
                        showLoadingMsg();
                        //interval = setInterval(function(){ambilData(data.data.ipfinger, data.data.keyfinger);},5000);
                        statusKoneksi = "Connect ("+data.time+") <a onclick=\"aktifkanFinger(this, true);\" id=\"is_disconnect\" style=\"line-height:8px;\" class=\"btn btn-danger\">disconnect</a>";
                        ambilData(data.data.ipfinger, data.data.keyfinger);
                    }
                    else{
                        $(obj).parents(".controls").find("select, input#connect").removeAttr("disabled");
                        statusKoneksi = "<div class=\'error\'>Failed";
                    }
                    $("#status-connection").html(statusKoneksi);
                    $("#ip-connection").html("<div class=\'control-label\' style=\'width: 0;\'>"+data.data.ipfinger+"</div>");
                    $("#lokasi-connection").html("<div class=\'control-labe\' style=\'width: 0;\'>"+data.data.lokasifinger+"</div>");
                }
            }
        });
    }
    return false;
}
', CClientScript::POS_HEAD); ?>
<script>
    function formHapusPresensi(data) {
        $("#hapus_presensi_nama_pegawai").val(data.nama_pegawai);
        $("#hapus_presensi_presensimasuk_id").val(data.presensimasuk_id);
        $("#hapus_presensi_presensipulang_id").val(data.presensipulang_id);
        $("#hapus_presensi_shift_id").val(data.shift_id);
        $("#hapus_presensi_pegawai_id").val(data.pegawai_id);
        $("#hapus_presensi_shift").val(data.shift_nama);
        $("#hapus_presensi_tgl_presensi").val(data.tglpresensi_format);
        $("#hapus_presensi_status_kehadiran").val(data.statuskehadiran_nama);
        $("#hapus_presensi_keterangan").val(data.keterangan);
        $("#dialogHapusPresensi").dialog("open");
    }

    function hapusPresensi() {
        $.post('<?php echo $this->createUrl('hapusPresensi'); ?>', $("#hapus-presensi-form").serialize(), function(data) {
            if (data.ok == 1) {
                myAlert("Presensi berhasil dihapus.");
                $("#dialogHapusPresensi").dialog("close");
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }
</script>
<?php
// Dialog untuk mengubah data presensi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogUbahPresensi',
    'options' => array(
        'title' => 'Ubah Data Presensi',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('kppresensi-t-grid', {
				data: $('#kppresensi-t-search').serialize()
			}); }",
    ),
));
?>
<iframe name='frameUbahPresensi' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk mengubah data presensi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogHapusPresensi',
    'options' => array(
        'title' => 'Hapus Data Presensi',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 400,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ 
                $('#hapus-presensi-form input, #hapus-presensi-form textarea').val('');
                $.fn.yiiGridView.update('kppresensi-t-grid', {
				data: $('#kppresensi-t-search').serialize()
			}); }",
    ),
));
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'hapus-presensi-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
)); ?>
<div class="control-group">
    <label class="control-label">Pegawai</label>
    <div class="controls">
        <?php echo CHtml::textField('hapus_presensi[nama_pegawai]', '', array('readonly' => true)); ?>
        <?php echo CHtml::hiddenField('hapus_presensi[presensimasuk_id]', '', array('readonly' => true)); ?>
        <?php echo CHtml::hiddenField('hapus_presensi[presensipulang_id]', '', array('readonly' => true)); ?>
        <?php echo CHtml::hiddenField('hapus_presensi[shift_id]', '', array('readonly' => true)); ?>
        <?php echo CHtml::hiddenField('hapus_presensi[pegawai_id]', '', array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Shift Kerja</label>
    <div class="controls">
        <?php echo CHtml::textField('hapus_presensi[shift]', '', array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Tgl. Presensi</label>
    <div class="controls">
        <?php echo CHtml::textField('hapus_presensi[tgl_presensi]', '', array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Status Kehadiran</label>
    <div class="controls">
        <?php echo CHtml::textField('hapus_presensi[status_kehadiran]', '', array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Keterangan</label>
    <div class="controls">
        <?php echo CHtml::textField('hapus_presensi[keterangan]', '', array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Alasan</label>
    <div class="controls">
        <?php echo CHtml::textArea('hapus_presensi[alasan]', ''); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton('<i class="entypo-check"></i> OK', array(
        'class' => 'btn btn-danger',
        'onclick' => 'hapusPresensi();'
    )); ?>
</div>
<?php
$this->endWidget();
$this->endWidget();
// end ============== 
?>
<script>
    function cekPetugas(obj) {
        $("#frameUbahPresensi").dialog("open");
    }
</script>