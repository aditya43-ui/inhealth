<!--div class="biru"-->
<!--div class="white"-->
<?php echo $this->renderPartial('_formKriteriaPencarian', array('model' => $model, 'form' => $form, 'format' => $format), true); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Inap</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <!--<legend class="rim">Tabel Pasien Rawat Inap</legend>-->
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pencarianpasien-grid',
            'dataProvider' => $model->searchRI(),
            //                'filter'=>$model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tanggal Admisi',
                    'name' => 'tgl_pulang',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgladmisi)'
                ),
                array(
                    'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                    'name' => 'no_pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                ), /*
                    array(
                        'header'=>'Nama Instalasi',
                        'name'=>'instalasi_nama',
                        'type'=>'raw',
                        'value'=>'$data->instalasi_nama',
                    ), */
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'no_rekam_medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'name' => 'nama_pasien',
                    'type' => 'raw',
                    'value' => '$data->nama_pasien',
                ),
                array(
                    'name' => 'umur',
                    'type' => 'raw',
                    'value' => '$data->umur',
                ), /*
                    array(
                        'header'=>'Alias',
                        'name'=>'nama_bin',
                        'type'=>'raw',
                        'value'=>'$data->nama_bin',
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
                    'header' => 'Jenis Kasus Penyakit',
                    'name' => 'jeniskasuspenyakit_nama',
                    'type' => 'raw',
                    'value' => '$data->jeniskasuspenyakit_nama',
                ),
                array(
                    'name' => 'kelaspelayanan_nama',
                    'type' => 'raw',
                    'value' => '$data->kelaspelayanan_nama',
                ),
                array(
                    'header' => 'Ruangan/<br>Kamar',
                    'type' => 'raw',
                    'value' => function ($data) use (&$admisi) {
                        $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                        return $admisi->ruangan->ruangan_nama . "/<br>"
                            . (!empty($admisi->kamarruangan_id) ? ($admisi->kamarruangan->kamarruangan_nokamar
                                . ":Bed " . $admisi->kamarruangan->kamarruangan_nobed) : "-");
                    },
                ),
                array(
                    'header' => 'Dokter',
                    //'name'=>'pegawai_nama',
                    'type' => 'raw',
                    'value' => function ($data) use (&$admisi) {
                        return $admisi->pegawai->namaLengkap;
                    },
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;')
                ),
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
                    //                'value'=>'CHtml::link("<i class=icon-list-alt></i>","",array("href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Mengubah Status Farmasi","onclick"=>"ubahStatusFarmasi($data->pendaftaran_id);"))',
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
    </div>
</div>
<script>
    function ubahStatusFarmasi(idpendaftaran) {
        var idpendaftaran = idpendaftaran;
        var status = "RI";
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