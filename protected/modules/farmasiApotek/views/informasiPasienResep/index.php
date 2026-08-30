<?php
$this->breadcrumbs = array(
    'Informasi Pasien Resep',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Resep</b>
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
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'caripasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#FAResepturT_noresep',
                    'method' => 'get',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Resep", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'noreseptur', array('placeholder' => 'No. Resep', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <div class="control-group">
                            <?php echo Chtml::label("NIK", 'pasien_noidentitas', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'pasien_noidentitas', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $carabayar = CarabayarM::model()->findAll(array(
                            'condition' => 'carabayar_aktif = true',
                            'order' => 'carabayar_nama ASC',
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
                        echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'multiple' => 'multiple',
                            'class' => 'span4 multiselect carabayar_id',
                            'onchange' => 'console.log("ini nilainya: " + $(this).val());',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model), 'is_informasi' => 1)),
                                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        $pegawai = CHtml::listData(DokterV::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                        ), array(
                            'order' => 'nama_pegawai asc',
                        )), 'pegawai_id', 'namaLengkap');

                        echo $form->dropDownListRow($model, 'pegawai_id', $pegawai, array(
                            'empty' => '-- Pilih --', 'class' => 'span4'
                        ));
                        ?>
                        <?php
                        $instalasi = InstalasiM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4, 8, 14, 18, 20, 38, 70, 73, 79, 83, 85, 101),
                        ));
                        $ruangan = RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4, 8, 14, 18, 20, 38, 70, 73, 79, 83, 85, 101),
                            'ruangan_aktif' => true,
                        ), array(
                            'order' => 'instalasi_id, ruangan_nama',
                        ));
                        echo $form->dropDownListRow($model, 'instalasireseptur_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/GetRuangResepturDariInsReseptur', array('encode' => false, 'namaModel' => get_class($model))),
                                'success' => 'function(data){$("#' . CHtml::activeId($model, "ruanganreseptur_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($model, 'ruanganreseptur_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));

                        ?>
                        <?php echo $form->dropDownListRow($model, 'statusperiksa', Params::statusPeriksa(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                        <?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'statusJual', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'statusJual', array(1 => 'Sudah Dijual', 2 => 'Belum Dijual'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Status Obat</label>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'isbatal', array(0 => 'Belum', 1 => 'Batal'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Status Pasien</label>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'statuspasien', array(1=>'Pasien Baru', 2=>'Pasien Pulang'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiPasienResep', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Resep</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                Yii::app()->clientScript->registerScript('cariPasien', "
//                         RSPMC-1027
//                        fungsi pencarian menggunakan ajax dicomment karena ingin ketika reload browser pencarian tetap berdasarkan kondisi form pencarian.
                        $('#caripasien-form').submit(function(){
                            $.fn.yiiGridView.update('pencarianpasien-grid', {
                                data: $(this).serialize()
                            });
                            return false;
                        });
                        $('#caripasien-form button[type=\'reset\']').click(function(){
                            $('#caripasien-form')[0].reset();
                            $.fn.yiiGridView.update('pencarianpasien-grid', {
                                data: $('#caripasien-form').serialize()
                            });
                            return false;
                        });
                        "); ?>
                <div class='block-tabel'>
                    <?php
                        $this->renderPartial('_table', ['model' => $model]);
                        $this->widget('bootstrap.widgets.BootAlert');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogEtiket',
    'options' => array(
        'title' => 'Etiket',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameEtiket' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPasien',
    'options' => array(
        'title' => 'Riwayat Pemeriksaan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1280,
        'height' => 720,
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
// Dialog buat lihat riwayat obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayatObat',
    'options' => array(
        'title' => 'Riwayat Obat',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="frameRiwayatObat" width="100%" height="550"></iframe>
<?php
$this->endWidget();
//========= end lihat riwayat obat =============================
?>



<script type="text/javascript">
    function printEtiket(penjualanresep_id, racikan) {
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/printEtiket'); ?>&racikan=' + (racikan ? 1 : 0) + '&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    function printEtiketRanap(penjualanresep_id, racikan) {
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/printEtiketRanap'); ?>&racikan=' + (racikan ? 1 : 0) + '&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    function printetiketRanapNew(penjualanresep_id) {
        var caraPrint = 'PRINT';
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/printEtiketRanapNew'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    /**
     * memanggil antrian ke farmasi apotek
     * @param {type} penjualanresep_id
     * @returns {undefined} */
    function panggilAntrian(antrianfarmasi_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('panggilAntrian'); ?>',
            data: {
                antrianfarmasi_id: antrianfarmasi_id
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
                    console.log("Panggil");
                    socket.emit('send', {
                        conversationID: 'antrian',
                        panggil: 5,
                        antrian_id: antrianfarmasi_id
                    });
                <?php } ?>
                $.fn.yiiGridView.update('pencarianpasien-grid');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    // const batalResep = (id) => {    
    //     myConfirm("Apakah resep akan dibatalkan?", "Perhatian!", function (r) {
    //         if (r) {
    //             $.ajax({
    //                 type: 'POST',
    //                 url: '<?php echo $this->createUrl('batalResep'); ?>',
    //                 data: {id: id},
    //                 dataType: "json",
    //                 success: function (data) {
    //                     if (data.sukses == 1) {
    //                         myAlert("Resep berhasil di batalkan");

    //                         refreshTable();
    //                     } else {
    //                         myInfo("Resep gagal di batalkan");
    //                     }
    //                 },
    //                 error: function (jqXHR, textStatus, errorThrown) {
    //                     console.log(errorThrown);
    //                 }
    //             });
    //         }
    //     })
    // }

    function hapusresep(reseptur_id,obj)
    {
        window.parent.myConfirm('Apakah anda akan menghapus Reseptur ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('hapusRiwayatReseptur'); ?>',
                    data: {reseptur_id:reseptur_id},
                    dataType: "json",
                    success:function(data){
                        if(data.sukses){
                            $.fn.yiiGridView.update('daftarriwayat-v-grid', {
                                data:{
                                    "RJPenjualanresepT[pasien_id]":data.pasien_id,
                                }
                            });
                        }
                        window.parent.myAlert(data.pesan);
                        refreshTable();
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });

            }
        });
    }
    
    const refreshTable = () => {
        $.fn.yiiGridView.update('pencarianpasien-grid', {
            data: $('#caripasien-form').serialize()
        });
    }

    function printIdentitas(id)
    {
        window.open("<?php echo $this->createUrl('/rawatJalan/informasiDaftarPasienPoliklinik/printIdentitas'); ?>&pasien_id=" + id + "&caraPrint=PDF","",'location=blank, width=900px');
    }

    function riwayatPelayanan(noka, kodedokter) {
        console.log(noka, kodedokter);
        $("#dialogFrameRiwayat").dialog('open')
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('/rawatJalan/daftarPasien/riwayatPelayananPasien'); ?>',
            data: {
                noka: noka,
                kodedokter: kodedokter,
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan != '') {
                    myAlert(data.pesan);
                }
                if (data.url != "" || data.url != null) {
                    // $("#dialogFrameRiwayat").dialog('open')
                    $('#iframeRiwayatPelayanan').attr('src', data.url);
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
</script>
<?php
//bpjs ICARE
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogFrameRiwayat',
    'options' => array(
        'title' => 'Riwayat Pelayanan BPJS-Kes (I-Care)',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe id="iframeRiwayatPelayanan" name="iframeRiwayatPelayanan" style="width: 100%; height: 98%;"></iframe>
</iframe>
<?php
$this->endWidget();
?>
<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenjualanResep',
    'options' => array(
        'title' => 'Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframePenjualanResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>
<?php
// Dialog buat Detail Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetailPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end Detail Penjualan dialog =============================
?>
<?php
// Dialog untuk menampilkan riwayat reseptur=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogResepturPenjualan',
    'options' => array(
        'title' => 'Resep Dokter',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 1100,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeResepturPenjualan" style="width: 100%; height: 98%;"></iframe>                                                                                                                                                                    <iframe src="" name="iframeResepturPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end dialog reseptur riwayat =============================
?>
<?php
// Dialog buat Copy Resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogCopyResep',
    'options' => array(
        'title' => 'Salinan Resep',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1250,
        'zIndex' => 1004,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeCopyResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end Copy Resep dialog =============================
?>

<?php
// Dialog untuk menampilkan dialog sep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_sep',
    'options' => array(
        'title' => 'Detail SEP',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="frame_sep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end dialog detail SEP =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianTagihanSementara',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Rincian Tagihan Sementara</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));

$r_login = Yii::app()->user->getState('ruangan_id');

// var_dump($r_login); die;
?>
<iframe name='iframeRincianTagihanSementara' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<script>

$(document).ready(function(){
        $(".carabayar_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '240px',
            enableCaseInsensitiveFiltering: true
        }).hide();
        
});

</script>