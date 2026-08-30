<!--div class="biru"-->
<!--div class="white"-->
<?php echo $this->renderPartial('_formKriteriaPencarian', array('model' => $model, 'form' => $form, 'format' => $format), true); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Darurat</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <!--<legend class="rim">Tabel Pasien Rawat Darurat</legend>-->
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pencarianpasien-grid',
            'dataProvider' => $model->searchRD(),
            //                'filter'=>$model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tanggal Pendaftaran',
                    'name' => 'tgl_pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'name' => 'no_pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'no_rekam_medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'name' => 'nama_pasien',
                    'type' => 'raw',
                    'value' => '$data->nama_pasien',
                ),
                array(
                    'name' => 'umur',
                    'type' => 'raw',
                    'value' => '$data->umur',
                ),
                array(
                    'name' => 'alamat_pasien',
                    'type' => 'raw',
                    'value' => '$data->alamat_pasien',
                ),
                array(
                    'header' => 'Penanggung',
                    'name' => 'nama_pj',
                    'type' => 'raw',
                    'value' => 'isset($data->nama_pj) ? CHtml::Link($data->nama_pj,Yii::app()->controller->createUrl("DaftarPasien/informasiPenanggung",array("id"=>$data->no_pendaftaran,"frame"=>true)),array("class"=>"", "target"=>"iframeInformasiPenanggung", "onclick"=>"$(\"#dialogInformasiPenanggung\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk melihat Informasi Penanggung Jawab",)) : "-"',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Jenis Kasus Penyakit',
                    'name' => 'jeniskasuspenyakit_nama',
                    'type' => 'raw',
                    'value' => '$data->jeniskasuspenyakit_nama',
                ), /*
                        array(
                            'header'=>'Nama Instalasi',
                            'name'=>'instalasi_nama',
                            'type'=>'raw',
                            'value'=>'$data->instalasi_nama',
                        ), */
                array(
                    'header' => 'Jenis Penjamin',
                    'name' => 'carabayar_nama',
                    'type' => 'raw',
                    'value' => '$data->carabayar_nama',
                ),
                array(
                    'header' => 'Penjamin',
                    'name' => 'penjamin_nama',
                    'type' => 'raw',
                    'value' => '$data->penjamin_nama',
                ),
                array(
                    'header' => 'Dokter',
                    //'name'=>'pegawai_nama',
                    'type' => 'raw',
                    'value' => function ($data) {
                        $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                        return $p->pegawai->namaLengkap;
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;')
                ), /*
                        array(
                            'name'=>'nama_bin',
                            'type'=>'raw',
                            'value'=>'$data->nama_bin',
                        ), */
                array(
                    'header' => 'Rincian Tagihan Farmasi',
                    'type' => 'raw',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:left;'),
                    'value' => 'CHtml::Link("<i class=\"icon-form-rtfarmasi\"></i>",Yii::app()->createUrl("billingKasir/RincianTagihanFarmasi/rincian",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                                array("class"=>"", 
                                    "target"=>"iframeRincianTagihan",
                                    "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk melihat Rincian Tagihan Farmasi",
                                ))',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                array(
                    'header' => 'Status<br>Farmasi',
                    'type' => 'raw',
                    'value' => '$data->getFarmasiStatus($data->pendaftaran_id)',
                    //                    'value'=>'CHtml::link("<i class=icon-list-alt></i>","",array("href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Mengubah Status Farmasi","onclick"=>"ubahStatusFarmasi($data->pendaftaran_id);"))',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogRincianTagihan',
            'options' => array(
                'title' => 'Rincian Tagihan',
                'autoOpen' => false,
                'modal' => true,
                'zIndex' => 1002,
                'minWidth' => 980,
                'minHeight' => 610,
                'resizable' => true,
            ),
        ));
        ?>
        <iframe src="" name="iframeRincianTagihan" width="100%" height="550">
        </iframe>
        <?php
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogPembayaranKasir',
            'options' => array(
                'title' => 'Pembayaran Kasir',
                'autoOpen' => false,
                'modal' => true,
                'zIndex' => 1002,
                'minWidth' => 1024,
                'minHeight' => 610,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                                data: $('#caripasien-form').serialize()
                            }); }",
            ),
        ));
        ?>
        <iframe src="" name="iframePembayaran" id="iframePembayaran" width="100%" height="550">
        </iframe>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>
<script>
    $('document').ready(function() {
        $('#pencarianpasien-grid button').each(function() {
            $('#red').removeAttr('class');
            $('#green').removeAttr('class');
            $('#red').attr('class', 'btn btn-primary');
            $('#green').attr('class', 'btn btn-danger');
        });
    });

    function ubahStatusFarmasi(idpendaftaran) {
        var idpendaftaran = idpendaftaran;
        var status = "RD";
        myConfirm("Yakin akan memverifikasi status farmasi pasien?", "Perhatian!",
            function(r) {
                if (r) {
                    $('#pencarianpasien-grid').addClass('animation-loading');
                    $.post('<?php echo Yii::app()->createUrl('farmasiApotek/infoPasienPulang/UbahStatusFarmasi'); ?>', {
                        idpendaftaran: idpendaftaran,
                        status: status
                    }, function(data) {
                        if (data.pesan != 'Berhasil') {
                            myAlert('Status Farmasi gagal diubah');
                        }
                        $.fn.yiiGridView.update('pencarianpasien-grid');
                    }, 'json');
                } else {
                    preventDefault();
                }
            });
    }
</script>