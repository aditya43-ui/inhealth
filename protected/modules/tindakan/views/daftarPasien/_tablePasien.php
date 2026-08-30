<style>

	.is_ada_ttv td {
		background-color: #dcdcdc !important;
	}

</style>

<?php 

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id;
$modul_name = $this->module->name;
$controler_name = $this->id;
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'items_perpage' => 50,
    'dataProvider' => $model->searchDaftarPasien(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-condensed',
    'columns' => array(
        array(
            'name' => 'no_urutantri',
            'type' => 'raw',
            'header' => 'Antrian',
            'value' => function ($data) use (&$modPasienMasukPenunjang){
                $criteria = new CDbCriteria();
                $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => $data->ruangan_id]);
                $label = '';
               
                
                if(!empty($data->no_urutantri) && !empty($data->ruangan_singkatan)) {
                    $label = '<a href="#" onclick="return false;" rel="tooltip" title="Tgl. Dilayani : ' . (empty($data->tglakandilayani) ? "-" : MyFormatter::formatDateTimeForUser($data->tglakandilayani)) . '">'
                        . $data->ruangan_singkatan."-".$modPasienMasukPenunjang->no_urutperiksa. '</a>';

                }

                $jns_kunjungan = $data->jenis_kunjungan;

                $jns_kunjungan_c = CHtml::hiddenField('warna', $jns_kunjungan, array('class' => 'ubah'));


                return $jns_kunjungan_c . "<br>" . $label . "<br>"
                    . (!in_array($data->statusperiksa, array(Params::STATUSPERIKSA_ANTRIAN, Params::STATUSPERIKSA_SEDANG_PERIKSA)) ? "" : CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => "<i class='icon-volume-up icon-white'></i>")), array("class" => "btn btn-primary", "onclick" => "panggilAntrian('" . $data->pendaftaran_id . "'); ", "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini"))); //setSuaraPanggilanSingle('".$data->ruangan_singkatan."','".$data->no_urutantri."','".$data->ruangan_id."')
            },
        ),
        array(
            'header' => 'Tgl/<br>Masuk Penunjang',
            'type' => 'raw',
            'value' => function ($data){
                $html = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "<br>";
                      
                return $html;
            },
        ),
        array(
            'header' => 'Instalasi / Ruangan Asal',
            'type' => 'raw',
            'value' => function($data) use (&$modPasienMasukPenunjang) {
                $html = '';
                
                if(!empty($modPasienMasukPenunjang)) {
                    $html .= $modPasienMasukPenunjang->ruanganasal->instalasi->instalasi_nama . " /<br>";
                    $html .= $modPasienMasukPenunjang->ruanganasal->ruangan_nama;
                }
                
                return $html;
            }
        ),
        array(
            'header' => 'Ruangan / Dokter Perujuk',
            'type' => 'raw',
            'value' => function($data) use (&$modPasienKirimKeUnitLain){
                $modPasienKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);

                $html = '';
                
                if(!empty($modPasienKirimKeUnitLain)) {
                    $html .= $modPasienKirimKeUnitLain->createruangan->ruangan_nama . " /<br>";
                    $html .= $modPasienKirimKeUnitLain->pegawai->namaLengkap;
                }
                
                return $html;
            }
        ),
        'no_pendaftaran',
        'no_rekam_medik',
        'nama_pasien',
        // array(
        //     'header' => 'Nama Pasien/<br>No. Rekam Medis/<br>NIK/<br>Tanggal Lahir',
        //     //                        'value'=>'$data->namadepan.$data->nama_pasien'
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         echo  CHtml::link(
        //             "<b>" . $data->namadepan . $data->nama_pasien . "</b>",
        //             Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
        //             array(
        //                 "rel" => "tooltip",
        //                 "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
        //                 "target" => "frameRiwayatPasien",
        //                 "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
        //             )
        //         );
        //         echo "<br>";
        //         echo "<b>" . $data->no_rekam_medik . "</b>";
        //         echo "<br>";
        //         echo "<b>" . $data->no_identitas_pasien . "</b>";
        //         echo "<br>";
        //         echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
        //         echo "<br>";
        //         // echo $data->alamat_pasien;
        //     },
        //     'headerHtmlOptions' => array('colspan' => 1, 'style' => ''),
        // ),
        array(
            'name' => 'Jenis Penjamin' . '/<br>' . 'Penjamin',
            'type' => 'raw',
            'value' => '"$data->carabayar_nama"."<br>"."$data->penjamin_nama"',
        ),
        array(
            'header' => 'Dokter Pemeriksa / PPDS',
            'type' => 'raw',
            'value' => function ($data) use (&$modPasienMasukPenunjang) {
                $html = '';
               
                if(!empty($data->nama_pegawai)) {
                    $html .= $data->gelardepan . $data->nama_pegawai . $data->gelarbelakang_nama .  ' /<br>';
                } 
                if(!empty($modPasienMasukPenunjang->ppds)) {
                    $html .= $modPasienMasukPenunjang->ppds->ppds_nama;
                }
               

               return $html;
                  
            },
            'htmlOptions' => array(
                'class' => 'rajal'
            )
        ),
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'value' => function ($data) {
                echo $data->getStatus($data->statusperiksa, $data->pendaftaran_id, $data);
                
            }
        ),
        array(
            'header' => 'Pemeriksaan Pasien',
            'type' => 'raw',
            'value' => function ($data) {
                $link = '';
                $link .= '<div class="small-container">';
                $link .= $data->linkPeriksaPasien;
                $link .= '<br>';
                $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/nurse.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Perawat / Bidan ', Yii::app()->controller->createUrl("RekamMedikElektronikTindakan/index", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id, 'type' => 'Perawat')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh perawat"));
                $link .= '</div>';

                echo $link;
            },
            'htmlOptions' => array('style' => 'text-align: center; ')
        ),
        array(
            'name' => 'masukanHasil',
            'type' => 'raw',
            'value' => function($data) use (&$modPasienMasukPenunjang){
                // $modPenunjang = PasienmasukpenunjangV::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);
                $button = 'Bukan Pasien Masuk Penunjang';
                if(!empty($modPasienMasukPenunjang)) {
                    $button = CHtml::link("<i class=icon-form-input></i>",Yii::app()->controller->createUrl("/tindakan/daftarPasien/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$modPasienMasukPenunjang->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Memasukkan hasil"));
                }
                echo $button;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Lihat Hasil',
            'type' => 'raw',
            'value' => function($data) use (&$modPasienKirimKeUnitLain) {
                if(!empty($modPasienKirimKeUnitLain)) {
                    echo CHtml::Link(
                        "<i class=icon-form-eye></i>",
                        Yii::app()->createUrl("rawatJalan/ruangTindakan/lihatDetailHasilPemeriksaan", array(
                            "pasienkirimkeunitlain_id" => $modPasienKirimKeUnitLain->pasienkirimkeunitlain_id,
                            'pendaftaran_id' => $data->pendaftaran_id,
                            'pasien_id' => $data->pasien_id
                        )),
                        array(
                            "class" => "",
                            "target" => "iframeDetailPemeriksaan",
                            "onclick" => "$('#dialogDetailPemeriksaan').dialog('open');",
                            "rel" => "tooltip",
                            "title" => "Lihat Detail Hasil Pemeriksaan",
                        )
                    );
                }
            }
        ),
        
        // array(
        //     'header' => 'Rincian Tagihan',
        //     'name'   => 'rincian',
        //     'type'   => 'raw',
        //     'value'  =>  function ($data) use (&$modPasienMasukPenunjang) {
        //         $str = "";
        //         if(!empty($modPasienMasukPenunjang)) {
        //             $str .= CHtml::Link(
        //                 "<i class=\"icon-form-detailtagihan\"></i>",
        //                 Yii::app()->controller->createUrl("/tindakan/daftarPasien/Rincian", array("id" => $data->pendaftaran_id, "frame" => true)),
        //                 array(
        //                     "target" => "iframeRincianTagihan",
        //                     "onclick" => "$(\"#dialogDetailRincianTagihan\").dialog(\"open\");",
        //                     "rel" => "tooltip",
        //                     "title" => "Klik untuk melihat Rincian Tagihan",
        //                 )
        //             );
        //         }
        //         return $str;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px; vertical-align: initial !important'),
        // ),
        array(
            'name' => 'Persetujuan',
            'type' => 'raw',
            'value' => '(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanUmumRM/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat persetujuan tindakan")))."<br>"'
                . '.(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Anastesi", Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiRM/index",array("pendaftaran_id"=>$data->pendaftaran_id, "noframe"=>1)),array("id"=>$data->no_pendaftaran."_antrian","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat persetujuan tindakan anastesi")))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'name' => 'Penolakan',
            'type' => 'raw',
            'value' => '(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanUmumRM/penolakan",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat penolakan tindakan")))."<br>"'
                . '.(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Anastesi", Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiRM/penolakan",array("pendaftaran_id"=>$data->pendaftaran_id, "noframe"=>1)),array("id"=>$data->no_pendaftaran."_antrian","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat penolakan tindakan anastesi")))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Detail Persetujuan & Penolakan',
            'type' => 'raw',
            'value' => function ($data) {
                $str = "";
                $umum = SuratpersetujuanumumT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                ));
                if (!empty($umum)) {
                    $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>General<br>Consent", Yii::app()->controller->createUrl('suratPersetujuanUmumRM/view', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameGeneralConsent", "rel" => "tooltip", "title" => "Klik untuk melihat General Consent", "onclick" => "$('#dialogGeneralConsent').dialog('open');"));
                }
                $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Tindakan", Yii::app()->controller->createUrl('pencarianPasienRM/detailPersetujuanTindakan', array('id' => $data->pendaftaran_id)), array("target" => "framePersetujuanTindakan", "rel" => "tooltip", "title" => "Klik untuk melihat Persetujuan Tindakan", "onclick" => "$('#dialogPersetujuanTindakan').dialog('open');"));
                $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Inform<br>Consent", Yii::app()->controller->createUrl('pencarianPasienRM/detailInformConsent', array('id' => $data->pendaftaran_id)), array("target" => "frameInformConsent", "rel" => "tooltip", "title" => "Klik untuk melihat Inform Consent", "onclick" => "$('#dialogInformConsent').dialog('open');"));
                $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Anestesi", Yii::app()->controller->createUrl('pencarianPasienRM/detailTindakanAnestesi', array('id' => $data->pendaftaran_id)), array("target" => "frameTindakanAnestesi", "rel" => "tooltip", "title" => "Klik untuk melihat Persetujuan Tindakan Anestesi", "onclick" => "$('#dialogTindakanAnestesi').dialog('open');"));
                return $str;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Catatan Edukasi',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('catatanEdukasiRM/create', array('pendaftaran_id' => $data->pendaftaran_id)), array(
                    'rel' => 'tooltip',
                    'title' => 'Catatan Edukasi Pasien',
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        array(
            'name' => 'Catatan Perkembangan Pasien Terintegrasi (CPPT)',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-detail"></i> ', Yii::app()->createUrl("/rehabMedis/CPPTRM/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Catatan Perkembangan Pasien Terintegrasi (CPPT)"));
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        array(
            'header'         => 'Batal Periksa',
            'type'             => 'raw',
            'value'             => '($data->statusperiksa != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->statusperiksa\',\'$data->nama_pasien\')",array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan")) : null',
            'htmlOptions'     => array('style' => 'text-align: center; width:40px'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
        // ubahWarna();
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
			// setPunyaTTV(); 
            disableLink();
        }',
)); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Riwayat Peminahaan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'height' => 550,
            'resizable' => false
        ),
    ));
    ?>
	<iframe name='frameDetail' width="100%" height="98%"></iframe>
	<?php $this->endWidget(); ?>
    
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSuratPerintahRanap',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Surat Perintah Rawat Inap</span><span style="float: right !important;">RM RI. 03 REV 02</span> </span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 650,
        'resizable' => true
    ),
));
?>
<iframe name='frameSuratPerintahRanap' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEdukasiAnestesi',
        'options' => array(
            'title' => 'Formulir Edukasi Tindakan Anestesi dan Sedasi',
            'autoOpen' => false,
            'width' => 1000,
            'height' => 600,
            'resizable' => true,
        ),

    )
);
echo '<iframe name="frameEdukasiAnestesi" width="100%" height="100%"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

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
<!-- LIST DOKUMEN RM -->
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokFilerm',
    'options' => array(
        'title' => 'Riwayat Dokumen File Rekam Medis',
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
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!-- END DOKUMEN -->
<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogRiwayatVaksinasi',
        'options' => array(
            'title' => 'Riwayat Vaksinasi/Imunisasi',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 450,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $('#formCari').serialize()
                    }); }",
        ),
    )
);
echo '<iframe name="frameRiwayatVaksinasi" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPemeriksaan',
    'options' => array(
        'title' => 'Lihat Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'height' => 580,
        'resizable' => false,
    ),
));
?>
<iframe name="iframeDetailPemeriksaan" style="width: 100%; height: 98%;"></iframe>
</iframe>
<?php
$this->endWidget();
?>

<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogDetailTandaVital',
        'options' => array(
            'title' => 'Detail Pemeriksaan Fisik | Data Pemeriksaan dan Tanda Vital',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 550,
            'resizable' => true
        ),
    )
);
echo '<iframe name="frameDetailTandaVital" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>




<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailPPDS',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">PPDS</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'height' => 570,
        'resizable' => true
    ),
));
?>
<iframe name='iframeDetailPPDS' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>


<?php echo $this->renderPartial($this->path_view . "_dialogPersetujuan", array(), true); ?>
<script type="text/javascript">
    function setPunyaTTV() {
        $("#daftarpasien-v-grid tbody tr").each(function() {
            if ($(this).find(".is_ttv").length != 0) {
                $(this).addClass("is_ada_ttv");
            }
        });
    }

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
                                // Notifikasi Dokter
                                if (data.smsdokter == 0) {
                                    var params = [];
                                    params = {
                                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                        modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                                        judulnotifikasi: 'GAGAL KIRIM SMS DOKTER',
                                        isinotifikasi: 'dr. ' + data.nama_pegawai + ' tidak memiliki nomor mobile'
                                    }; // 16 
                                    insert_notifikasi(params);
                                }
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

        function setSedangPeriksa(pendaftaran_id, nama_pasien) {
            myConfirm(' Apakah pasien atas nama ' + nama_pasien + ' sudah selesai periksa? ', 'Perhatian!', function(r) {
                if (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'SetSedangPeriksa'); ?>',
                        data: {
                            pendaftaran_id: pendaftaran_id
                        }, //
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $.fn.yiiGridView.update('daftarpasien-v-grid');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        }
    }
    /**
     * 
     * @param {type} pendaftaran_id
     * @param {type} statusperiksa
     * @param {type} namaPasien
     * @returns {undefined}
     */
    function dialogBatalPeriksaRj(pendaftaran_id, statusperiksa, namaPasien) {
        $('#titleNamaPasienBatal_rj').html(namaPasien);
        $('#DialogBatalperiksa_rj #pendaftaran_id_rj').val(pendaftaran_id);
        $('#DialogBatalperiksa_rj #statusperiksa_rj').val(statusperiksa);
        $('#DialogBatalperiksa_rj').dialog('open');
    }

    function ubahPeriksaKarenaBatal() {
        var pendaftaran_id = $('#DialogBatalperiksa_rj #pendaftaran_id_rj').val();
        var tglbatal = $('#DialogBatalperiksa_rj #tglbatal_rj').val();
        var keterangan_batal = $('#DialogBatalperiksa_rj #keterangan_batal_rj').val();
        $('#DialogBatalperiksa_rj #keterangan_batal_rj').attr('class', '');

        if (cekAlasanBatal($("#keterangan_batal_rj")) == false) {
            return false;
        }

        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
            $('#DialogBatalperiksa_rj #keterangan_batal_rj').attr('class', 'error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('batalPeriksa'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                tglbatal: tglbatal,
                keterangan_batal: keterangan_batal
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    myAlert(data.pesan);
                    $('#DialogBatalperiksa_rj').dialog('close');
                    $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $(this).serialize()
                    });
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
                    // Notifikasi Dokter
                    if (data.smsdokter == 0) {
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                            judulnotifikasi: 'GAGAL KIRIM SMS DOKTER',
                            isinotifikasi: 'dr. ' + data.nama_pegawai + ' tidak memiliki nomor mobile'
                        }; // 16 
                        insert_notifikasi(params);
                    }
                } else if (data.pesan == 'exist') {
                    myAlert('Pasien telah melakukan pemeriksaan');
                    $('#DialogBatalperiksa_rj').dialog('close');
                } else {
                    myAlert(data.pesan);
                    $('#DialogBatalperiksa_rj').dialog('close');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    const cekAlasanBatal = (obj) => {
        let word = ($(obj).val()).replace(/ /g, "");
        var count = (word).length;

        if (count < 10) {
            toastr.error("Alasan batal tidak boleh kurang dari 10 karakter, spasi tidak termasuk", "Perhatian!");
            return false;
        }
        return true;
    }


    function ubahWarna(){
        // find baris kolom 
        $('#daftarpasien-v-grid > table > tbody > tr').each (function(){
            var tbl = $(this).find('.ubah').val();

            console.log('jns: ' + tbl);
            if (tbl == "Fast Track") {
                // set jika nilai selain kondisi di atas warna merah
                $(this).find('td').attr('style', 'background: #F5B9B9 !important');
            } else {
                 // set jika kondisi di atas warna putih
                $(this).find('td').attr('style', 'background: white !important'); 
            }
        }); 
    }

    $(document).ready(function() {
        // setPunyaTTV();
        // ubahWarna();
    });
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailRincianTagihan',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'height' => 570,
        'resizable' => true
    ),
));
?>
<iframe name='iframeRincianTagihan' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>