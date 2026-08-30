<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Rujukan</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#search-penunjangrujukan-form').submit(function(){
        $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <?php if (!empty($_GET['pendaftaran_id'])) { ?>
        <div class="mds-form-message success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <?php
    if (!empty($_GET['succes'])) {
    ?>

        <div class="alert alert-block alert-success">
            <a class="close" data-dismiss="alert">×</a>
            <?php
            if ($_GET['succes'] == 2) {
            ?>
                Pemeriksaan Pasien berhasil di batalkan
            <?php
            }
            if ($_GET['succes'] == 1) {
            ?>
                Pasein Berhasil Di Rujuk
            <?php
            }
            ?>
        </div>

    <?php
    }
    ?>

    <div class="block-tabel">
        <h6>Tabel <b>Pasien Rujukan</b></h6>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pasienpenunjangrujukan-m-grid',
            'dataProvider' => $model->searchPasienRujukan(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                'tgl_pendaftaran',
                'tgl_kirimpasien',
                array(
                    'header' => 'Instalasi<br>Ruangan / Poliklinik Asal',
                    'name' => 'instalasi_ruangan',
                    'value' => '$data->InstalasiNamaRuanganNama',
                ),
                'no_pendaftaran',
                'no_rekam_medik',
                array(
                    'header' => 'Nama Pasien / Panggilan',
                    'name' => 'nama_pasien_panggilan',
                    'value' => '$data->NamaPasienNamaBin',
                ),
                array(
                    'header' => 'Jenis Penjamin / Penjamin',
                    'name' => 'cara_bayar_penjamin',
                    'value' => '$data->CaraBayarPenjaminNama',
                ),
                array(
                    'header' => 'Kasus Penyakit/<br>Kelas Pelayanan',
                    'name' => 'kasus_pelayanan',
                    'type' => 'raw',
                    'value' => '"$data->jeniskasuspenyakit_nama"."<br>"."$data->kelaspelayanan_nama"',
                ),
                //                'jeniskasuspenyakit_nama',
                //                'pendaftaran.umur',
                'alamat_pasien',
                //                'pemeriksaanrad_nama',
                //                array(
                //                    'header'=>'Periksa',
                //                    'type'=>'raw',
                //                    'value'=>'CHtml::Link("<i class=\"icon-user\"></i>",Yii::app()->controller->createUrl("masukPenunjang/",array("idPasienKirimKeUnitLain"=>$data->pasienkirimkeunitlain_id,"pendaftaran_id"=>$data->pendaftaran_id)),
                //                                    array("class"=>"icon-user", 
                //                                          "id" => "selectPasien",
                //                                          "rel"=>"tooltip",
                //                                          "title"=>"Klik untuk periksa pasien",
                //                                    ))',
                //TRIAL BETA
                array(
                    'header' => 'Periksa',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-periksa\"></i>",Yii::app()->controller->createUrl("pendaftaranBankDarahRujukanRS/index",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id)),
                                            array("class"=>"icon-form-periksa", 
                                                  "id" => "selectPasien",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk periksa pasien",
                                            ))',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                array(
                    'header' => 'Print',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<i class=\'icon-print\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->pasienkirimkeunitlain_id\')",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan"))',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                array(
                    'header' => 'Batal Rujukan',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->pasienkirimkeunitlain_id\')",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan"))',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                // array(
                //    'header'=>'Batal Periksa',
                //    'type'=>'raw',
                //    'value'=>'CHtml::link("<i class=\'icon-remove\'></i>", "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan"))',
                //    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                // ),            
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_formSearch', array('model' => $model, 'format' => $format)); ?>
    </fieldset>
</div>
<script type="text/javascript">
    //    document.getElementById('BDPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:none;");
    //    document.getElementById('BDPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:none;");
    function cekTanggal() {

        var checklist = $('#BDPasienKirimKeUnitLainV_cbTglMasuk');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('BDPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('BDPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('BDPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('BDPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }

    function batalperiksa(pendaftaran_id, idKirimUnit) {
        myConfirm('Anda yakin akan membatalkan rujukan bank darah pasien ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalRujuk') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        idKirimUnit: idKirimUnit
                    },
                    function(data) {
                        if (data.status == 'ok') {
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
                            // window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                            //                                 $('#dialogKonfirm div.divForForm').html(data.keterangan);
                            $('#dialogKonfirm').dialog('open');
                            console.log('test');
                            $('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
                            //                        JQuery('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
                        }
                    }, 'json'
                );
            }
        });
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php echo $this->renderPartial('_jsFunctions', array()); ?>