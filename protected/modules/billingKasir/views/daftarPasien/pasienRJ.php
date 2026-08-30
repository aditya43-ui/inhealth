<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('/billingKasir/daftarPasien'),
    'PasienRJ',
); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'method' => 'GET',
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
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pasien Rawat Jalan</b>
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
                <?php echo $this->renderPartial('_formKriteriaPencarian', array('model' => $modRJ, 'form' => $form, 'format' => $format), true); ?>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array(
                            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Jalan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $modRJ->searchDialogKunjungan(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    /*
									'mergeHeaders'=>array(
										array(
											'name'=>'<center>Penjamin</center>',
											'start'=>5,
											'end'=>6,
										),
									),
									 *
									 */
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                            'name' => 'tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->Tanggal."/<br>".$data->no_pendaftaran',
                        ),
                        /*
										array(
											'header'=>'Nama Instalasi',
											'name'=>'instalasi_nama',
											'type'=>'raw',
											'value'=>'$data->instalasi_nama',
											'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
										),
										 *
										 *//*
										array(
											'name'=>'no_pendaftaran',
											'type'=>'raw',
											'value'=>'$data->no_pendaftaran',
											'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
										), */
                        array(
                            'header' => 'Nama Pasien / No. Rekam Medik / Umur / Alamat',
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => function ($data) {
                                echo CHtml::link(
                                    "<b>".$data->namadepan . $data->nama_pasien. "</b>",
                                    Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
                                    array(
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                                        "target" => "frameRiwayatPasien",
                                        "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
                                    )
                                );
                                echo "<br>";
                                echo $data->no_rekam_medik;
                                echo "<br>";
                                echo $data->umur;
                                echo "<br>";
                                echo $data->alamat_pasien;
                            },
                        ),
                        array(
                            'header' => 'Jenis Kasus Penyakit',
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header' => 'Alamat',
                            'name' => 'alamat_pasien',
                            'type' => 'raw',
                            'value' => '$data->alamat_pasien',
                        ),
                        array(
                            'header' => 'Dokter/<br>Poliklinik',
                            'name' => 'ruangan_nama',
                            'type' => 'raw',
                            'value' => function ($data) {
                                echo $data->gelardepan . $data->nama_pegawai . ", " . $data->gelarbelakang_nama;
                                echo "<hr>";
                                echo $data->ruangan_nama;
                            },
                        ),
                        /*
										array(
											'header'=>'Nama Panggilan',
											'name'=>'nama_bin',
											'type'=>'raw',
											'value'=>'$data->nama_bin',
											'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;')
										), */
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'name' => 'carabayar_nama',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama."/<br>".$data->penjamin_nama',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:left;')
                        ),
                        array(
                            'header' => 'Dokter',
                            'name' => 'nama_pegawai',
                            'type' => 'raw',
                            'value' => '$data->gelardepan.$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                        ),
                        /*
										array(
											'header'=>'Penjamin',
											'name'=>'penjamin_nama',
											'type'=>'raw',
											'value'=>'$data->penjamin_nama',
											'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;')
										), *//*
										array(
											'header'=>'Penanggung Jawab',
											'name'=>'nama_pj',
											'type'=>'raw',
											'value'=>'isset($data->nama_pj) ? CHtml::Link($data->nama_pj,Yii::app()->controller->createUrl("DaftarPasien/informasiPenanggung",array("id"=>$data->no_pendaftaran,"frame"=>true)),array("class"=>"", "target"=>"iframeInformasiPenanggung", "onclick"=>"$(\"#dialogInformasiPenanggung\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk melihat Informasi Penanggung Jawab",)) : "-"',
											'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
										),*//*
										array(
											'header'=>'Nama Instalasi<br/> /<br/> Ruangan',
											'name'=>'instalasi_nama',
											'type'=>'raw',
											'value'=>'$data->instalasi_nama." / <br/> ".$data->ruangan_nama',
										), */
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $ubah_status = array(
                                    Params::STATUSPERIKSA_SUDAH_DIPERIKSA => array(
                                        "onclick" => "ubahStatus(" . $data->pendaftaran_id . ", '" . Params::STATUSPERIKSA_SEDANG_PERIKSA . "');",
                                    )
                                );
                                return CHtml::htmlButton($data->statusperiksa, array(
                                    'class' => 'btn ' . Params::statusPeriksaCol()[$data->statusperiksa],
                                    'style' => 'min-width: 200px;',
                                    'onclick' => empty($ubah_status[$data->statusperiksa]) ? "return false;" : $ubah_status[$data->statusperiksa]['onclick'],
                                ));
                            }, //'$data->statusperiksa',
                        ),
                        array(
                            'header' => 'Total Tagihan (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $total = 0;
                                $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ), array('condition' => 'tindakansudahbayar_id is null and verifikasitagihan_id is not null'));
                                $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ), array('condition' => 'oasudahbayar_id is null and verifikasitagihan_id is not null'));
                                foreach ($tindakan as $item) {
                                    // $total += $item->tarif_satuan * $item->qty_tindakan;
                                    $total += $item->tarif_tindakan;
                                }
                                foreach ($oa as $item) {
                                    //if (!empty($item->penjualanresep_id) && $item->penjamin_id == Params::PENJAMIN_ID_UMUM)
                                    //	continue;
                                    // $total += $item->qty_oa * $item->hargasatuan_oa;
                                    $total += $item->hargajual_oa;
                                }
                                // return count((array)$tindakan)." ".count((array)$oa);
                                return MyFormatter::formatNumberForPrint($total, 2);
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                        ),
                        /*
										array(
											'header'=>'Status Pembayaran',
											'type'=>'raw',
											'value'=>function($data) use (&$sb) {
												$tindakan = TindakanpelayananT::model()->findByAttributes(array(
													'pendaftaran_id'=>$data->pendaftaran_id,
												), array('condition'=>'tindakansudahbayar_id is null'));
												$oa = ObatalkespasienT::model()->findByAttributes(array(
													'pendaftaran_id'=>$data->pendaftaran_id,
												), array('condition'=>'oasudahbayar_id is null'));
												$sb = !empty($oa) || !empty($tindakan);
												return $sb?"Belum Lunas":"Sudah Lunas";
											}//'(empty($data->pembayaranpelayanan_id) ? "Belum Lunas" : "Sudah Lunas")'
										),
									 *
									 */
                        //                    array(
                        //                        'header'=>'Rincian Tagihan',
                        //                        'type'=>'raw',
                        //                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        //                        'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/rincianBelumBayar",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                        //                                    array("class"=>"",
                        //                                          "target"=>"iframeRincianTagihan",
                        //                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                        //                                          "rel"=>"tooltip",
                        //                                          "title"=>"Klik untuk melihat Rincian Tagihan",
                        //                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                        //                    ),
                        array(
                            'header' => 'Rincian Tagihan',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>"","frame"=>true)),
														array("class"=>"",
															  "target"=>"iframeRincianTagihan",
															  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
															  "rel"=>"tooltip",
															  "title"=>"Klik untuk melihat Rincian Tagihan",
														))',          'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
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
															  "target"=>"iframeRincianTagihanFarmasi",
															  "onclick"=>"$(\"#dialogRincianTagihanFarmasi\").dialog(\"open\");",
															  "rel"=>"tooltip",
															  "title"=>"Klik untuk melihat Rincian Farmasi",
														))',          'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Grup Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarGrup",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>"","frame"=>true)),
														array("class"=>"",
															  "target"=>"iframeRincianTagihanGroup",
															  "onclick"=>"$(\"#dialogRincianTagihanGroup\").dialog(\"open\");",
															  "rel"=>"tooltip",
															  "title"=>"Klik untuk melihat Grup Rincian",
														))',          'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
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
                                if (empty($td) && empty($oa)) return "BELUM ADA TRANSAKSI";
                                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ), array('condition' => 'tindakansudahbayar_id is null'));
                                $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ), array('condition' => 'oasudahbayar_id is null '));

                                $verifikasi = TindakanpelayananT::model()->find(" pendaftaran_id = $data->pendaftaran_id and verifikasitagihan_id is not null");
                                $verifikasi_oa = ObatalkespasienT::model()->find(" pendaftaran_id = $data->pendaftaran_id and verifikasitagihan_id is not null");
                                $opacity = (empty($verifikasi) && empty($verifikasi_oa)) ? 0.4 : 1;
                                $click = (empty($verifikasi) && empty($verifikasi_oa)) ? '' : "cekStatusPasien(" . $data->pendaftaran_id . ");";
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
                                        "style" => "opacity: $opacity;",
                                        //"target"=>"iframePembayaran",
                                        "onclick" => "$click", //"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
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
                               
                                $verifikasi = TindakanpelayananT::model()->find(" pendaftaran_id = $data->pendaftaran_id and verifikasitagihan_id is not null ");
                                $verifikasi_oa = ObatalkespasienT::model()->find(" pendaftaran_id = $data->pendaftaran_id and verifikasitagihan_id is not null");

                                if (empty($verifikasi) && empty($verifikasi_oa)) {
                                    return CHtml::link(
                                        '<button class="btn btn-gold">BELUM<br>VERIFIKASI</button>',
                                        $this->createUrl('verifikasiTagihan/index', array('pendaftaran_id' => $data->pendaftaran_id)),
                                        array(
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Klik untuk melakukan Verifikasi Tagihan Pasien.',
                                            "onclick" => "gotoVerifikasi(" . $data->pendaftaran_id . "); return false;",
                                        )
                                    );
                                }
                                return CHtml::link(
                                    '<button class="btn btn-info">SUDAH<br>VERIFIKASI</button>',
                                    $this->createUrl('verifikasiTagihan/index', array('pendaftaran_id' => $data->pendaftaran_id)),
                                    array(
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Klik untuk melakukan Verifikasi Tagihan Pasien.',
                                        "onclick" => "gotoVerifikasi(" . $data->pendaftaran_id . "); return false;",
                                    )
                                );
                            }
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPasien',
    'options' => array(
        'title' => 'Riwayat Pemeriksaan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogPembayaranKasir',
    'options'=>array(
        'title'=>'Pembayaran Kasir',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>1124,
        'minHeight'=>510,
        'resizable'=>true,
        'close'=>"js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
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
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogRincianTagihan',
    'options'=>array(
        'title'=>'Rincian Tagihan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>1024,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogRincianTagihanFarmasi',
    'options'=>array(
        'title'=>'Rincian Farmasi',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>1024,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihanFarmasi" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogRincianTagihanGroup',
    'options'=>array(
        'title'=>'Grup Rincian',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>1024,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihanGroup" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogInformasiPenanggung',
    'options'=>array(
        'title'=>'Informasi Penanggung',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>350,
        'zIndex'=>1001,
        'minHeight'=>200,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeInformasiPenanggung" width="100%" height="200" ></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailVerifikasi',
    'options'=>array(
        'title'=>'Detail Verifikasi Tagihan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>1024,
        'minHeight'=>510,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeDetailVerifikasi" width="100%" height="500" >
</iframe>
<?php
$this->endWidget();
?>
<script>
    var url_bayar = '<?php echo Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array("instalasi_id"=>Params::INSTALASI_ID_RJ)); ?>';
    var url_verifikasi = '<?php echo Yii::app()->controller->createUrl("verifikasiTagihan/index"); ?>';

    function cekStatusPasien(id) {
        $.post('<?php echo $this->createUrl('cekStatusPasienRJ'); ?>', {id: id}, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
            } else {
                window.location.href = url_bayar + '&pendaftaran_id=' + id;
                // $("#dialogPembayaranKasir iframe").prop('src', url_bayar + '&pendaftaran_id=' + id);
                // $("#dialogPembayaranKasir").dialog("open");
            }
        }, 'json');
    }

    function ubahStatus(id, status) {
        myConfirm("Anda yakin untuk mengubah status periksa pasien ini menjadi " + status + "?", "Perhatian", function(r) {
            if (r) {
                $.post("<?php echo $this->createUrl("ubahStatus"); ?>", {id: id, status: status}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update("pencarianpasien-grid");
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            } else {
                $.fn.yiiGridView.update("pencarianpasien-grid");
            }
        });
    }

    function gotoVerifikasi(id) {
            window.location.href = url_verifikasi + '&pendaftaran_id=' + id;
    }

</script>
