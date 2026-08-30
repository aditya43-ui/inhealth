<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Instalasi Hemodialisa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pasien' => array('/billingKasir/daftarPasien'),
            'PasienRD',
        ); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'caripasien-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php echo $this->renderPartial('_formKriteriaPencarianHD', array('model' => $modHD, 'form' => $form, 'format' => $format), true); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Instalasi Hemodialisa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $modHD->searchHD(),
                    'template' => "{summary}\n{pager}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pendaftaran/<br>Tanggal Pulang',
                            'name' => 'tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->TanggalDaftarPulang',
                        ),
                        array(
                            'header' => 'Cara Pulang/<br>Kondisi Pulang',
                            'name' => 'instalasi_nama',
                            'type' => 'raw',
                            'value' => '$data->carakeluar."/<br>".$data->kondisipulang',
                        ),
                        array(
                            'header' => 'Nama Ruangan',
                            'name' => 'instalasi_nama',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
                            //                                        'value'=>'$data->no_pendaftaran.CHtml::Link("<i class=\"icon-form-periksa\"></i>",Yii::app()->controller->createUrl("PelayananPasien/index",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                            //                                                array("rel"=>"tooltip",
                            //                                                      "title"=>"Klik untuk pelayanan pasien",
                            //                                                ))',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
                            'htmlOptions' => array('style' => 'text-align: center;')
                        ),
                        array(
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Shift',
                            'type' => 'raw',
                            'value' => '$data->getShiftNama()',
                        ),
                        array(
                            'header' => 'Nama Pasien/<br>Alias',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien."/<br>".$data->nama_bin',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'name' => 'carabayar_nama',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama."/<br>".$data->penjamin_nama',
                        ),
                        array(
                            'header' => 'Nama Jenis Kasus Penyakit',
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header' => 'Nama Dokter',
                            'name' => 'nama_pegawai',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
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
                            'header' => 'Kamar Bed',
                            'type' => 'raw',
                            'value' => '$data->getNoBed()',
                        ),
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::htmlButton($data->statusperiksa, array(
                                    'class' => 'btn ' . Params::statusPeriksaCol()[$data->statusperiksa],
                                    'style' => 'min-width: 200px;'
                                ));
                            }, //'$data->statusperiksa',
                        ),
                        array(
                            'header' => 'Rincian Tagihan',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>"","frame"=>true)),
                                                                array("class"=>"", 
                                                                      "target"=>"iframeRincianTagihan",
                                                                      "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                                                      "rel"=>"tooltip",
                                                                      "title"=>"Klik untuk melihat Rincian Tagihan",
                                                                ))', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Rincian Farmasi',
                            'type' => 'raw',
                            'htmlOptions' => array(
                                'style' => 'text-align: rcenter',
                            ),
                            'value' => '($data->penjamin_id == 1)?"-":' .
                                'CHtml::Link("<i class=\"icon-form-rtfarmasi\"></i>",Yii::app()->controller->createUrl("RincianTagihanFarmasi/RincianBiayaFarmasi",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                                                                array("class"=>"", 
                                                                      "target"=>"iframeRincianTagihan",
                                                                      "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                                                      "rel"=>"tooltip",
                                                                      "title"=>"Klik untuk melihat Rincian Farmasi",
                                                                ))', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Grup Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarGrup",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>"","frame"=>true)),
                                                                array("class"=>"", 
                                                                      "target"=>"iframeRincianTagihan",
                                                                      "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                                                      "rel"=>"tooltip",
                                                                      "title"=>"Klik untuk melihat Grup Rincian",
                                                                ))', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Pembayaran Kasir',
                            'type' => 'raw',
                            'value' => function ($data) use (&$sb) {
                                // return $data->total_belum." : ".$data->total_oa_belum;
                                $td = TindakanpelayananT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ));
                                $oa = ObatalkespasienT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ));
                                if (empty($td) && empty($oa))
                                    return "BELUM ADA TRANSAKSI";
                                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ), array('condition' => 'tindakansudahbayar_id is null'));
                                $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ), array('condition' => 'oasudahbayar_id is null '));
                                /*
                                                      $of = ObatalkespasienT::model()->findAllByAttributes(array(
                                                      'pendaftaran_id'=>$data->pendaftaran_id,
                                                      ), array('condition'=>'penjualanresep_id is not null and penjamin_id = '.Params::PENJAMIN_ID_UMUM));
                                                      foreach ($oa as $idx=>$val) {
                                                      if (in_array($val, $of)) {
                                                      unset($oa[$idx]);
                                                      }
                                                      }
                                                     * 
                                                     */
                                $sb = count((array)$oa) > 0 || !empty($tindakan);
                                return $sb ? CHtml::Link(
                                    "<i class=\"icon-form-bayar\"></i>",
                                    'javascript:void(0)',
                                    //Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array("instalasi_id"=>Params::INSTALASI_ID_RJ,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                                    array(
                                        "class" => "",
                                        //"target"=>"iframePembayaran",
                                        "onclick" => "cekStatusPasien(" . $data->pendaftaran_id . ");", //"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk membayar ke kasir",
                                    )
                                ) : "SUDAH<br>LUNAS";
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Verifikasi<br>Tagihan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ), array(
                                    'order' => 'verifikasitagihan_id desc',
                                ));
                                if (empty($verifikasi)) {
                                    return CHtml::link('<button class="btn btn-gold">BELUM<br>VERIFIKASI</button>', $this->createUrl('verifikasiTagihan/index', array('pendaftaran_id' => $data->pendaftaran_id)), array(
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Klik untuk melakukan Verifikasi Tagihan Pasien.',
                                        "onclick" => "gotoVerifikasi(" . $data->pendaftaran_id . "); return false;",
                                    ));
                                }
                                return CHtml::link('<button class="btn btn-info">SUDAH<br>VERIFIKASI</button>', $this->createUrl('verifikasiTagihan/detail', array('id' => $verifikasi->verifikasitagihan_id)), array(
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Klik untuk melihat detail Verifikasi Tagihan Pasien',
                                    'target' => 'iframeDetailVerifikasi',
                                    'onclick' => '$("#dialogDetailVerifikasi").dialog("open");'
                                ));
                            }
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogPembayaranKasir',
        'options' => array(
            'title' => 'Pembayaran Kasir',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1001,
            'minWidth' => 1124,
            'height' => 510,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe src="" name="iframePembayaran" width="100%" height="550">
    </iframe>
    <?php
    $this->endWidget();
    ?>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 1024,
        'height' => 510,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<script>
    var url_bayar = '<?php echo Yii::app()->controller->createUrl("PembayaranTagihanPasien/index", array("instalasi_id" => Params::INSTALASI_ID_HD)); ?>';
    var url_verifikasi = '<?php echo Yii::app()->controller->createUrl("verifikasiTagihan/index"); ?>';

    function cekStatusPasien(id) {
        $.post('<?php echo $this->createUrl('cekStatusPasienHD'); ?>', {
            id: id
        }, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
            } else {
                window.location.href = url_bayar + '&pendaftaran_id=' + id;
                // $("#dialogPembayaranKasir iframe").prop('src', url_bayar + '&pendaftaran_id=' + id);
                // $("#dialogPembayaranKasir").dialog("open");
            }
        }, 'json');
    }

    function gotoVerifikasi(id) {
        window.location.href = url_verifikasi + '&pendaftaran_id=' + id;
    }
</script>