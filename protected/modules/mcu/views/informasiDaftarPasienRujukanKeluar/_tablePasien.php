<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pasien Rujukan Ke Luar</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'daftarpasien-v-grid',
            'dataProvider' => $model->searchDaftarPasienRujukan(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tgl. Pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)',
                ),
                array(
                    'header' => 'No. Pendaftaran' . '/<br>' . 'No. Rekam Medik',
                    'type' => 'raw',
                    'value' => '$data->pendaftaran->no_pendaftaran." <br> ".$data->pasien->no_rekam_medik',
                ),
                array(
                    'header' => 'Nama Pasien' . '/<br>' . 'Alias',
                    'type' => 'raw',
                    'value' => '$data->pasien->nama_pasien."<br>".$data->pasien->nama_bin',
                ),
                array(
                    'header' => 'Alamat Pasien' . '/<br>' . 'RT RW',
                    'type' => 'raw',
                    'value' => 'CHtml::hiddenField("MCPasiendirujukkeluarT[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3")).$data->pasien->alamat_pasien."<br>"."$data->RTRW"',
                ),
                array(
                    'header' => 'Penjamin' . '/<br>' . 'Jenis Penjamin',
                    'type' => 'raw',
                    'value' => '$data->pendaftaran->penjamin->penjamin_nama."<br>".$data->pendaftaran->carabayar->carabayar_nama',
                ),
                array(
                    'header' => 'Dokter Pemeriksa/<br>Kelas Pelayanan',
                    'type' => 'raw',
                    'value' => '"<div style=\'width:100px;\'>" . CHtml::link("<icon class=\'icon-form-ubah\' ></icon> ", Yii::app()->createUrl("/mcu/informasiDaftarPasienRujukanKeluar/ubahDokterPeriksa", array("pendaftaran_id"=>$data->pendaftaran_id,"pasiendirujukkeluar_id"=>$data->pasiendirujukkeluar_id,"frame"=>true)), array("target"=>"iframeUbahDokterPeriksa","rel"=>"tooltip", "title"=>"klik untuk ubah dokter pemeriksa", "onclick"=>"$(\'#dialogUbahDokterPeriksa\').dialog(\'open\');"))." ".(isset($data->dokterpemeriksa) ? $data->dokterpemeriksa : "-")."</div>"."<br>".$data->pendaftaran->kelaspelayanan->kelaspelayanan_nama',
                    'htmlOptions' => array(
                        'style' => 'text-align:center;',
                        'class' => 'rajal'
                    )
                ),
                array(
                    'header' => 'Status Periksa',
                    'type' => 'raw',
                    'value' => '$data->getStatus($data->pendaftaran->statusperiksa,$data->pendaftaran_id)',
                    'htmlOptions' => array('style' => 'text-align:center;')
                ),
                array(
                    'name' => 'Periksa Pasien',
                    'type' => 'raw',
                    'value' => '(($data->pendaftaran->alihstatus==FALSE) ? CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/mcu/pemeriksaanPasienMC",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>$data->pendaftaran->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien MCU")): CHtml::link("<i class=\'icon-list-alt\'></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien MCU")))',
                    'htmlOptions' => array('style' => 'text-align: center; width:60px')
                ),
                array(
                    'header' => 'Rencana Kontrol',
                    'type' => 'raw',
                    'value' => '((!empty($data->pendaftaran->tglrenkontrol)) ? MyFormatter::formatDateTimeForUser($data->pendaftaran->tglrenkontrol) : "-")',
                    'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                ),
                array(
                    'header' => 'Print Surat Rujukan',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<icon class=\'icon-form-print\' ></icon> ", Yii::app()->createUrl("/mcu/pendaftaranMcuRujukanLuar/printSuratMcu", array("pendaftaran_id"=>$data->pendaftaran_id,"pasiendirujukeluar_id"=>$data->pasiendirujukkeluar_id,"frame"=>true)), array("target"=>"frameSuratRujukan","rel"=>"tooltip", "title"=>"print surat MCU rujukan ke luar", "onclick"=>"$(\'#dialogSuratRujukan\').dialog(\'open\');"))', 'htmlOptions' => array('style' => 'text-align: center; width:40px ')
                ),
                array(
                    'header' => 'Masukan Tagihan MCU/<br>Rincian Tagihan',
                    'type' => 'raw',
                    //                            'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->createUrl("/mcu/informasiDaftarPasienRujukanKeluar/printDetailRincianBelumBayar", array("instalasi_id"=>$data->pendaftaran->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"input tagihan mcu", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))."<br>".CHtml::link("<icon class=\'icon-form-detail\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id"=>$data->pendaftaran->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
                    'value' => 'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->createUrl("/mcu/informasiDaftarPasienRujukanKeluar/printDetailRincianBelumBayar", array("instalasi_id"=>$data->pendaftaran->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"input tagihan mcu", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))."<br>".CHtml::link("<icon class=\'icon-form-detail\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/RincianTagihanPasien", array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
                    'htmlOptions' => array('style' => 'text-align: center; width:40px ')
                ),
                array(
                    'header' => 'Batal Periksa',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>$data->pendaftaran->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
                    'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            }',
        )); ?>
    </div>
</div>
<script type="text/javascript">
    {
        function batalperiksa(pendaftaran_id) {
            myConfirm("Anda yakin akan membatalkan pemeriksaan rawat jalan pasien ini?", "Perhatian!", function(r) {
                if (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPeriksa'); ?>',
                        data: {
                            pendaftaran_id: pendaftaran_id
                        }, //
                        dataType: "json",
                        success: function(data) {
                            if (data.status == true) {
                                myAlert(data.pesan);
                                $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                    data: $(this).serialize()
                                });
                            } else if (data.pesan == 'exist') {
                                myAlert('Pasien telah melakukan pemeriksaan');
                            } else {
                                myAlert(data.pesan);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        }
        //validasi pemeriksaan
        function cektindaklanjut() {
            myAlert("Pasien sudah ditindak lanjut ke Rawat Inap!");
        }

    }
</script>