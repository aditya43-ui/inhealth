<?php $linkHalaman = CustomFunction::getUrlByMenuID(63); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppbooking-kamar-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pesan Kamar',
); ?>
<?php echo CHtml::hiddenField('statuta', ''); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pesan Kamar</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pesan Kamar</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ppbooking-kamar-t-grid',
                    'dataProvider' => $model->searchBooking(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'bookingkamar_id',
                        array(
                            'name' => 'tgltransaksibooking',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgltransaksibooking)',
                        ),
                        array(
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => '(isset($data->no_pendaftaran) ? CHtml::hiddenField("BookingkamarT[$data->bookingkamar_id][idBooking]", $data->bookingkamar_id, array("id"=>"idBooking","class"=>"span3")).$data->pendaftaran->no_pendaftaran : "")',
                        ),
                        array(
                            'name' => 'tglbookingkamar',
                            'type' => 'raw',
                            'value' => '(isset($data->bookingkamar_id) ? CHtml::hiddenField("BookingkamarT[$data->tglbookingkamar][tglbookingkamar]", MyFormatter::formatDateTimeForUser($data->tglbookingkamar), array("id"=>"tglbookingkamar","class"=>"span3")).MyFormatter::formatDateTimeForUser($data->tglbookingkamar) : "")',
                        ),
                        array(
                            'name' => 'pasien_id',
                            'type' => 'raw',
                            'value' => '(!empty($data->pasien_id) ? $data->pasien->no_rekam_medik: "-") ',
                            'htmlOptions' => array('style' => 'text-align: left')
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->NamaAlias',
                        ),
                        array(
                            'header' => 'No. Handphone Pasien',
                            'type' => 'raw',
                            'value' => '$data->pasien->no_mobile_pasien',
                        ),
                        array(
                            'name' => 'ruangan_id',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'name' => 'kamarruangan_id',
                            'type' => 'raw',
                            'value' => '$data->kamarruangan->kamarruangan_nokamar',
                        ),
                        array(
                            'name' => 'kelaspelayanan_id',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
                        ),
                        //                'bookingkamar_no',
                        'statusbooking',
                        array(
                            'header' => 'Status Konfirmasi',
                            //                    'name'=>'statuskonfirmasi',
                            'type' => 'raw',
                            'value' => '$data->getStatus($data->statuskonfirmasi,$data->pasien_id,$data->bookingkamar_id,$data->kamarruangan_id)',
                            //                    'value'=>'($data->statuskonfirmasi != "BATAL BOOKING" OR $data->statuskonfirmasi == "") ? "$data->statuskonfirmasi".CHtml::link("<i class=icon-pencil></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Mengubah Status Konfirmasi Pemesanan Kamar","onclick"=>"{buatSessionUbahStatusKonfirmasiBooking($data->bookingkamar_id); ubahStatusKonfirmasiBooking(); $(\'#dialogUbahStatusKonfirmasiBooking\').dialog(\'open\');}return false;")) : "$data->statuskonfirmasi"',
                        ),
                        array(
                            'header' => 'Pendaftaran <br>Rawat Inap',
                            'type' => 'raw',
                            'value' => '(empty($data->pasienadmisi_id)  ? CHtml::link("<i class=\'icon-form-ri\'></i> ", "javascript:daftarKeRI(\'$data->pasien_id\',\'$data->pendaftaran_id\',\'$data->bookingkamar_id\');",array("id"=>"$data->pasien_id","rel"=>"tooltip","title"=>"Klik untuk Mendaftarkan ke Rawat Inap")) : "Pasien Sudah Didaftarkan <br> Ke Rawat Inap") ',
                            'htmlOptions' => array('style' => 'text-align:center'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=icon-form-lihat></i>",Yii::app()->createUrl("pendaftaranPenjadwalan/bookingKamarT/view",array("id"=>$data->bookingkamar_id)),
                                             array("class"=>"view",
                                                   "rel"=>"tooltip",
                                                   "title"=>"Lihat Data Pesan Kamar",
                                     ))',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            )
                        ),
                        array(
                            'header' => 'Ubah',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=icon-form-ubah></i>",Yii::app()->createUrl("pendaftaranPenjadwalan/bookingKamarT/update",array("id"=>$data->bookingkamar_id)),
                                             array("class"=>"update",
                                                   "rel"=>"tooltip",
                                                   "title"=>"Ubah Data Pesan Kamar",
                                     ))',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            )
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i> ", "javascript:deleteRecord($data->bookingkamar_id)",array("id"=>"$data->bookingkamar_id","rel"=>"tooltip","title"=>"Batalkan Pemesanan Kamar"))',
                            'htmlOptions' => array(
                                'style' => 'text-align:left',
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
        $urlPendaftaranRI = Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/PendaftaranRawatInap');
        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppbuat-janji-poli-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function daftarKeRI(pasien_id,pendaftaran_id,bookingkamar_id)
{
    $('#pasien_id').val(pasien_id);
    $('#pendaftaran_id').val(pendaftaran_id);
    $('#bookingkamar_id').val(bookingkamar_id);
    $('#form_hidden').submit();
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'form_hidden',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'action' => $urlPendaftaranRI,
            'htmlOptions' => array('target' => '_new'),
        )); ?>
        <?php echo CHtml::hiddenField('pasien_id', '', array('readonly' => true)); ?>
        <?php echo CHtml::hiddenField('pendaftaran_id', '', array('readonly' => true)); ?>
        <?php echo CHtml::hiddenField('bookingkamar_id', '', array('readonly' => true)); ?>
        <?php $this->endWidget(); ?>
        <?php
        // Dialog untuk ubah status konfirmasi booking =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogUbahStatusKonfirmasiBooking',
            'options' => array(
                'title' => 'Ubah Status Konfirmasi Pemesanan Kamar',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 600,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        echo '<div class="divForForm"></div>';
        $this->endWidget();
        //========= end ubah status konfirmasibooking dialog =============================
        ?>
        <script type="text/javascript">
            setInterval( // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
                function() {
                    $.fn.yiiGridView.update('ppbooking-kamar-t-grid', { // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
                        data: $('#ppbooking-kamar-t-search').serialize()
                    });
                    return false;
                },
                20000 // fungsi di eksekusi setiap 5 detik sekali
            );
        </script>
        <script>
            function setStatus(obj, status, idpasien, idbooking, idkamarruangan) {
                var status = status;
                var idpasien = idpasien;
                var idbooking = idbooking;
                var idkamarruangan = idkamarruangan;
                //            myAlert(status);
                //            myAlert(idpendaftaran);var answer = confirm('Yakin Akan Merubah Status Pemesanan Kamar Pasien?');
                myConfirm("Yakin Akan Merubah Status Pemesanan Kamar Pasien?", "Perhatian!", function(r) {
                    if (r) {
                        $.post('<?php echo $this->createUrl('ubahStatusKonfirmasiBooking'); ?>', {
                            status: status,
                            idpasien: idpasien,
                            idbooking: idbooking,
                            idkamarruangan: idkamarruangan
                        }, function(data) {
                            if (data.status == 'berhasil') {
                                myAlert('Status Pemesanan Kamar Berhasil Berubah!');
                                $('#dialogUbahStatusPasien div.divForForm').html(data.div);
                                $.fn.yiiGridView.update('ppbooking-kamar-t-grid');
                                setTimeout("$('#dialogUbahStatusKonfirmasiBooking').dialog('close')", 1000);
                                // Notifikasi Pasien
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
                            } else {
                                $('#alertDiv').show();
                            }
                        }, 'json');
                    } else {
                        myAlert('Status Pemesanan Kamar Tidak Berubah!');
                    }
                });
            }
            function ubahStatusKonfirmasiBooking()
            {
                <?php
                echo CHtml::ajax(array(
                    'url' => $this->createUrl('ubahStatusKonfirmasiBooking'),
                    'data' => "js:$(this).serialize()",
                    'type' => 'post',
                    'dataType' => 'json',
                    'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogUbahStatusKonfirmasiBooking div.divForForm').html(data.div);
                    $('#dialogUbahStatusKonfirmasiBooking div.divForForm form').submit(ubahStatusKonfirmasiBooking);
                }
                else
                {
                    $('#dialogUbahStatusKonfirmasiBooking div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('ppbooking-kamar-t-grid');
                    setTimeout(\"$('#dialogUbahStatusKonfirmasiBooking').dialog('close') \",5000);
                }
            } ",
                ))
                ?>;
                return false;
            }
        </script>
        <?php
        $urlSessionUbahStatus = $this->createUrl('buatSessionUbahStatusKonfirmasiBooking');
        $jscript = <<< JS
function buatSessionUbahStatusKonfirmasiBooking(idBooking)
{
        myConfirm("Yakin Akan Merubah Status Pemesanan Kamar Pasien?","Perhatian!",function(r) {
        if(r){
            $.post("${urlSessionUbahStatus}", {idBooking: idBooking },
                function(data){
                    'sukses';
            }, "json");
        }
        else
        {
        }
    });
}
JS;
        Yii::app()->clientScript->registerScript('jsBookingKamar', $jscript, CClientScript::POS_BEGIN);
        ?>
        <script type="text/javascript">
            setInterval(
                function() {
                    var statusnya = $("#statuta").val(); // mengetahui status apakah sedang ada fungsi autosave yang sedang berjalan
                    if (statusnya != "on") // jika tidak ada fungsi yang berjalan, maka jalankan fungsi
                    {
                        //           $("#btn-save").attr("disabled",true);  // selama fungsi berjalan, user tidak bisa menekan tombol save
                        var tglbookingkamar = $("#tglbookingkamar").val(); // menangkap nilai dari form input
                        var idBooking = $("#idBooking").val(); // menangkap nilai dari form input
                        //           myAlert(tglbookingkamar);
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/bookingKamarT/updateStatusKonfirmasi') ?>", // memanggil sebuah fungsi untuk autosave
                            type: "post",
                            dataType: "json",
                            data: {
                                "tglbookingkamar": tglbookingkamar,
                                "idBooking": idBooking
                            },
                            beforeSend: function() {
                                $("#statuta").val("on");
                            },
                            success: function(data) {
                                $("#statuta").val("off");
                                if (data.satu.length > 0) {
                                    window.location = data.satu; // jika data berhasil disimpan, maka akan redirect
                                } else {
                                    //                       $("#btn-save").attr("disabled",false);
                                }
                            },
                        });
                    }
                },
                200000 // operasi auto save dilakukan 2 jam  sekali
            );
            function deleteRecord(id) {
                var id = id;
                var url = '<?php echo $url . "/delete"; ?>';
                myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
                    if (r) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('ppbooking-kamar-t-grid');
                                } else {
                                    myAlert('Data gagal dihapus karena data digunakan oleh Master Penjamin Pasien.');
                                }
                            }, "json");
                    }
                });
            }
        </script>
    </div>
</div>