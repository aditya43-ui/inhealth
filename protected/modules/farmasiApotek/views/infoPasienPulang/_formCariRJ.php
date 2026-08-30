<!--div class="biru"-->
<!--div class="white"-->
<?php echo $this->renderPartial('_formKriteriaPencarian', array('model' => $model, 'form' => $form, 'format' => $format), true); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Jalan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <!--<legend class="rim">Tabel Pasien Rawat Jalan</legend>-->
        <?php
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id' => 'pencarianpasien-grid',
            'dataProvider' => $model->searchRJ(),
            //                'filter'=>$model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            /*
                    'mergeHeaders'=>array(
                        array(
                            'name'=>'<p style="margin: 0; text-align: center;">Penjamin</p>',
                            'start'=>5,
                            'end'=>6,
                        ),
                    ),*/
            'columns' => array(
                array(
                    'header' => 'Tanggal Pendaftaran',
                    'name' => 'tgl_pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'name' => 'no_pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->no_pendaftaran',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'no_rekam_medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Nama Pasien',
                    'name' => 'nama_pasien',
                    'type' => 'raw',
                    'value' => '$data->namadepan.$data->nama_pasien',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'name' => 'umur',
                    'type' => 'raw',
                    'value' => '$data->umur',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Alamat',
                    'name' => 'alamat_pasien',
                    'type' => 'raw',
                    'value' => '$data->alamat_pasien',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
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
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ), /*
                        array(
                            'header'=>'Alias',
                            'name'=>'nama_bin',
                            'type'=>'raw',
                            'value'=>'$data->nama_bin',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;')
                        ), */
                array(
                    'header' => 'Jenis Penjamin',
                    'name' => 'carabayar_nama',
                    'type' => 'raw',
                    'value' => '$data->carabayar_nama',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;')
                ),
                array(
                    'header' => 'Penjamin',
                    'name' => 'penjamin_nama',
                    'type' => 'raw',
                    'value' => '$data->penjamin_nama',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;')
                ),
                array(
                    'header' => 'Ruangan',
                    'name' => 'ruangan_nama',
                    'type' => 'raw',
                    'value' => '$data->ruangan_nama',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;')
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
        <?php
        // Dialog untuk ubah status periksa =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogUbahStatusFarmasi',
            'options' => array(
                'title' => 'Ubah Status Farmasi',
                'autoOpen' => false,
                'modal' => true,
                'zIndex' => 1002,
                'minWidth' => 600,
                'minHeight' => 500,
                'resizable' => false,
            ),
        ));
        echo '<div class="divForForm"></div>';
        $this->endWidget();
        //========= end ubah status periksa dialog =============================
        ?>
    </div>
</div>
<script>
    function ubahStatusFarmasi(idpendaftaran) {
        var idpendaftaran = idpendaftaran;
        var status = "RJ";
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