<?php
Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('gzpesanmenudietpasien-v-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
?>



<?php
Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form1').toggle();
                return false;
        });
        $('.search-form1 form').submit(function(){
                $.fn.yiiGridView.update('pasienbaru-m-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
?>
<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Menu Diet Pasien',
);
?>

<style>
    .tr_isadmin {
        background-color: #FFD700 !important;
        ;
    }

    .tr_isadmin:hover {
        background-color: #FFA07A !important;
        ;
    }

    .tr_sudahpesan {
        background-color: white !important;
    }

    .tr_belumpesan {
        background-color: #ffcece !important;
    }
    
</style>

<div class="panel panel-pr_imary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemesanan Menu Diet Pasien</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    
</div>

<div class="panel-body">
<?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form1">
            <?php $this->renderPartial($this->path_view . '_formPencarian', array(
                'modelRawatInap' => $modelRawatInap,
            )); ?>
        </div>
    <div class="panel panel-success">
       
        <div class="panel panel-success panel-shadow">
    <div class="panel-heading">

        <div class="panel-title">Data Pasien Rawat Inap</div>
    </div>

    <div class="panel-body" style="overflow-x:scroll">

        <div>
            <?php

            if (CustomFunction::isGridViewUpdate('pasienbaru-m-grid')) {



            $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                'id' => 'pasienbaru-m-grid',
                'dataProvider' => $modelRawatInap->searchPasienBaruRawatInap(),
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-bordered',
                // 'rowCssClassExpression' => ' date("Y-m-d", strtotime($data->tgladmisi)) ==  date("Y-m-d")  empty($data->pesanmenudiet_id) || $data->pesanmenudiet_id == null ?"tr_isadmin":""',
                'rowCssClassExpression' => '$data->sudahPesan() ?"tr_sudahpesan":"tr_belumpesan"',
                'items_perpage' => 5,
                'dropdownItemKelipatan' => 5,
                'columns' => array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align:right;'),
                    ),
                    array(
                        'header' => 'Tanggal Masuk',
                        'type' => 'raw',
                        'value' => function ($data) {
                            if (!empty($data->tgl_pendaftaran)) {
                                return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                                // return MyFormatter::formatDateTimeForUser($data->tgladmisi);
                                // echo date("Y-m-d", strtotime($data->tgladmisi));
                            } else {
                                return '-';
                            }
                        },
                    ),

                    array(
                        'header' => 'Tanggal Pendaftaran / No. Pendaftaran',
                        'type' => 'raw',
                        'value' => function ($data) {
                            if (!empty($data->tgl_pendaftaran)) {
                                return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . '/' . $data->no_pendaftaran;
                            } else {
                                return '-';
                            }
                        }
                    ),
                    array(
                        'header' => 'No. Rekam Medis',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->no_rekam_medik;
                        }
                    ),
                    array(
                        'header' => 'Nama Pasien',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->nama_pasien;
                        }
                    ),
                    array(
                        'header' => 'Instalasi',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->instalasiadmisi_nama;
                        }
                    ),
                    array(
                        'header' => 'Ruangan',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->ruanganadmisi_nama;
                        }
                    ),
                    // array(
                    //     'header' => 'Kamar / Nomor Bed',
                    //     'type' => 'raw',
                    //     'value' => function ($data) {
                    //         if (!empty($data->pasienadmisi_id)) {
                    //             $pasienadmisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                    //             if (!empty($pasienadmisi)) {
                    //                 $kamar = KamarruanganM::model()->findByPk($pasienadmisi->kamarruangan_id);
                    //                 if (!empty($kamar)) {
                    //                     return $kamar->kamarruangan_nokamar . ' / ' . $kamar->kamarruangan_nobed;
                    //                 } else {
                    //                     return '-';
                    //                 }
                    //             } else {
                    //                 return '-';
                    //             }
                    //         } else {
                    //             return '-';
                    //         }
                    //     }
                    // ),

                    array(
                        'header' => 'Kamar / Nomor Bed',
                        'type' => 'raw',
                        'value' => function ($data) {
                            if (!empty($data->kamarruangan_nokamar)) {
                                return $data->kamarruangan_nokamar . '/ ' . $data->kamarruangan_nobed;
                            } else {
                                return '-';
                            }
                        }
                    ),
                    array(
                        'header' => 'Kelas Perawatan',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->kelaspelayanan_nama;
                        }
                    ),
                    array(
                        'header' => 'Lama Dirawat',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CustomFunction::hitungHariRawat($data->tgl_pendaftaran, $data->tglselesaiperiksa) . ' Hari';
                        }
                    ),
                    array(
                        'header' => 'Status Periksa',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->statusperiksa;
                        }
                    ),
                    array(
                        'header' => 'Status Pemesanan',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->sudahPesan() ? "SUDAH" : "BELUM";
                        }
                    ),
                      
                ),
                'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                }',
            ));

            }
            ?>

        </div>

    </div>

</div>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogHakKewajiban',
            'options' => array(
                'title' => 'Hak & Kewajiban Pasien',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 960,
                'height' => 580,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe name="iframeHakKewajiban" style="width: 100%; height: 98%;"></iframe>
        </iframe>
        <?php
        $this->endWidget();
        ?>
        <?php
        // Dialog untuk kirim dokumen RM =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogStatusDokumen',
            'options' => array(
                'title' => 'Pengiriman Dokumen Ke-Ruangan Lain',
                'autoOpen' => false,
                'modal' => true,
                'zIndex' => 1002,
                'width' => 1000,
                'height' => 400,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                                data: $('#daftarPasien-form').serialize()
                            }); }",
            ),
        ));
        ?>
        <iframe name='frameStatusDokumen' style="width: 100%; height: 98%;"></iframe>
        <?php $this->endWidget();
        // end ============== 
        ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogRincian',
            'options' => array(
                'title' => 'Rincian Tagihan Pasien',
                'autoOpen' => false,
                'modal' => true,
                'width' => 1000,
                'height' => 550,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
        <?php $this->endWidget(); ?>
        <div style='display:none'>
            <?php
            $this->widget('MyDateTimePicker', array(
                //      'model'=>$modMasukKamar,
                'name' => 'jammasukkamar',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::TIME_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'span3 dtPicker3',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
            ));
            ?>
        </div>
    </div>
    <div class="panel panel-success">
        
        <div class="panel-body">
        <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body search-form">
                        <?php
                        $this->renderPartial($this->path_view . '_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Menu Diet Pasien</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php 
                            $this->renderPartial($this->path_view . '_tablePemesananMenuDiet', ['model' => $model]);
                        ?>
        
                        <br>
                        <?php echo Chtml::dropDownList('jeniswaktu_id', 'jeniswaktu_id', CHtml::listData(JeniswaktuM::model()->findAllByAttributes(array('jeniswaktu_aktif' => true)), 'jeniswaktu_id', 'jeniswaktu_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'printPemesanan(\'PDF\');')) . "&nbsp&nbsp"; ?>
                    </div>
                </div>
            </div>
        
    </div>
</div>

<?php
$js = <<< JSCRIPT
function openDialog(id){
    $('#dialogDetail').dialog('open');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('head', $js, CClientScript::POS_HEAD);
?>
<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Pemesanan Menu Diet Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
// Dialog untuk Batal Pesan Menu Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalPesan',
    'options' => array(
        'title' => 'Batal Pesan Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= Dialog untuk Batal Pesan Menu Diet =============================
?>
<?php
// Dialog buat Detail Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Print Etiket',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeDetailPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<script>
    function verifikasiAll() {
        var jeniswaktu_id = $('#GZPesanmenudietT_jeniswaktu_id').val();
        myConfirm('Yakin ingin verifikasi semua pesanan?','Perhatian !', function(r) {
            if(r){
                $.post('<?= $this->createUrl('verifikasiAll') ?>', {
                    jeniswaktu_id:jeniswaktu_id
                }, function(data){
                    if(data.sukses == 1) {
                        myAlert('Berhasil melakukan verifikasi');
                        
                    } else {
                        myAlert('gagal melakukan verifikasi');
                    }
                    $.fn.yiiGridView.update('gzpesanmenudietpasien-v-grid');
                }, 'json');
            }
        });
    }

    function verifikasi(pesanmenudetail_id) {
        // gzpesanmenudietpasien-v-grid
        myConfirm('Yakin Ingin Verifikasi?','Perhatian !', function(r) {
            if(r){
                $.post('<?= $this->createUrl('verifikasi') ?>', {
                    pesanmenudetail_id:pesanmenudetail_id
                }, function(data){
                    if(data.sukses == 1) {
                        myAlert('Berhasil melakukan verifikasi');
                        
                    } else {
                        myAlert('gagal melakukan verifikasi');
                    }
                    $.fn.yiiGridView.update('gzpesanmenudietpasien-v-grid');
                }, 'json');
            }
        });
    }

    function batalPesan(idPesanDiet) {
        var idPesanDiet = idPesanDiet;
        //var answer = myConfirm('Yakin Akan Membatalkan Pemesanan Diet?');
        myConfirm('Apakah Anda yakin ingin membatalkan pemesanan menu diet?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalMenuDiet'); ?>', {
                    idPesanDiet: idPesanDiet
                }, function(data) {
                    if (data.status == 'create_form') {
                        setTimeout("$('#dialogBatalPesan').dialog('open') ", 1000);
                        $('#dialogBatalPesan div.divForForm').html(data.div);
                        $('#dialogBatalPesan div.divForForm form #idPesanDiet').val(data.idPesan);
                        $('#dialogBatalPesan div.divForForm form').submit(konfirmBatal);
                    } else {
                        $('#dialogBatalPesan div.divForForm').html(data.div);
                        $.fn.yiiGridView.update('gzpesanmenudietpasien-v-grid');
                        setTimeout("$('#dialogBatalPesan').dialog('close') ", 1000);
                    }
                }, 'json');
            }
        });
    }

    function konfirmBatal() {
        <?php
        echo CHtml::ajax(array(
            'url' => $this->createUrl('batalMenuDiet'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogBatalPesan div.divForForm').html(data.div);
                    $('#dialogBatalPesan div.divForForm form').submit(konfirmBatal);
                }
                else
                {
                    $('#dialogBatalPesan div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('gzpesanmenudietpasien-v-grid');
                    setTimeout(\"$('#dialogBatalPesan').dialog('close') \",3000);
                }
            } ",
        ))
        ?>;
        return false;
    }

    function terimaKonfirmasi(idPesan) {
        var url = '<?php echo $this->createUrl("terimaKonfirmasi"); ?>';
        myConfirm('Apakah Anda yakin ingin mengubah status menjadi <b>Sudah Diterima</b>?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        idPesan: idPesan
                    },
                    function(data) {
                        if (data.status == 'sukses') {
                            $.fn.yiiGridView.update('gzpesanmenudietpasien-v-grid');
                        } else if (data.status == 'gagal') {
                            myAlert('Data gagal diubah menjadi status diterima');
                        } else {
                            myAlert(data.pesan);
                        }
                    }, "json");
            }
        });
    }
</script>

<?php
// ===========================Dialog Details Laporan Penerimaan Sponsorship=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogCetak',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cetak Label Makanan',
        'autoOpen' => false,
        'width' => 900,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframeCetak" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Laporan Penerimaan Sponsorship================================
?>
<?php
$controller = Yii::app()->controller->id;
$module = Yii::app()->controller->module->id;
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrintPemesanan = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/cetakInformasiLabelMakanan');
$js = <<< JSCRIPT
function printpilihPermintaan(caraPrint, jeniswaktu_id){
    window.open("${urlPrintPemesanan}/"+$('#gzpesanmenudietpasien-v-grid').serialize()+"&caraPrint="+caraPrint+"&jeniswaktu_id="+jeniswaktu_id,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function ubahWarna() {
        // find baris kolom 
        $('#gzpesanmenudietpasien-v-grid > table > tbody > tr').each(function() {
            var tbl = $(this).find('.ubah').val();
            if (tbl >= 1) {
                $(this).find('td').attr('style', 'background-color: #ffcece !important;');
            }

            var create = $(this).find('.ubah_craate').val();
            if (create != '') {
                $(this).find('td').attr('style', 'background-color: #FFDEAD !important;');
            }

            var ubah = $(this).find('.ubah_update').val();
            if (ubah != '') {
                $(this).find('td').attr('style', 'background-color: #d5f5e3  !important;');
            }

        });
    }

    function pilihSemua(obj) {
        if ($(obj).is(":checked")) {
            $(".checklist").prop("checked", true);
        } else {
            $(".checklist").prop("checked", false);
        }
    }

    function setNol(obj) {
        if ($(obj).is(":checked")) {
            obj.prop("checked", true);
        } else {
            obj.prop("checked", false);
        }
    }

    function printPemesanan(caraPrint) {
        var html = [];
        var i = 0;
        var cek = $(".table-pesan-menu-diet > tbody > tr").find('.checklist:checked').length;

        if (cek < 1) {
            window.parent.myAlert("Pilih Minimal Satu Daftar Pemesanan Menu");
            return false;
        }

        $(".table-pesan-menu-diet > tbody > tr").find('.checklist:checked').each(function() {
            html[i] = $(this).val();
            console.log(html[i]);
            i++;
        });

        console.log(html);

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setprint'); ?>',
            data: {
                id: html
            },
            dataType: "json",
            success: function(data) {
                if (html != "") {
                    var jeniswaktu_id = $('#jeniswaktu_id').val();
                    console.log('jeniswaktu_id', jeniswaktu_id);
                    printpilihPermintaan(caraPrint, jeniswaktu_id);
                } else {
                    myAlert("Silahkan Pilih Minimal Satu Daftar Pemesanan Menu");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function() {
        ubahWarna();
    });
</script>