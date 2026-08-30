<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pasienpenunjangrujukan-m-grid',
        'dataProvider' => $dataProvider,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            'tgl_pendaftaran',
            array(
                'header' => 'Tanggal Rencana Tindakan',
                'value' => function ($data) {
                    $dialog = '';

                    if(empty($data->tglrencanapemeriksaan)) {
                        $dialog = CHtml::Link("Pilih<br>Tgl. Pemeriksaan",Yii::app()->createUrl("tindakan/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
                                array("class"=>"btn btn-info", 
                                    "target"=>"framePilihTglPeriksa",
                                    "onclick"=>"$(\"#dialogPilihTglPeriksa\").dialog(\"open\");",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk memilih tanggal pemeriksaan", 
                        ));
                    } else {

                        $tgl1 = explode(" ", $data->tglrencanapemeriksaan);
                        $tgl = MyFormatter::formatDateTimeForUser($tgl1[0]);
                        $jam = $tgl1[1];
                        $dialog = CHtml::Link("$tgl",Yii::app()->createUrl("tindakan/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
                        array("class"=>"btn btn-success", 
                                        "target"=>"framePilihTglPeriksa",
                                        "onclick"=>"$(\"#dialogPilihTglPeriksa\").dialog(\"open\");",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk memilih tanggal pemeriksaan", 
                            ));
                    }
                    echo "<center>$dialog</center>";
                },
            ),
            array(
                'header' => 'Instalasi / Ruangan Asal',
                'value' => '$data->InstalasiNamaRuanganNama',
            ),

            'no_pendaftaran',
            'no_rekam_medik',
            array(
                'header' => 'Nama Pasien / Alias',
                'value' => '$data->NamaPasienNamaBin',
            ),
            array(
                'header' => 'Jenis Penjamin / Penjamin',
                'value' => '$data->CaraBayarPenjaminNama',
            ),
            'jeniskasuspenyakit_nama',
            //                'umur',
            'alamat_pasien',
            //                'pemeriksaanrad_nama',
            [
                'header' => 'Lihat Berkas',
                'type' => 'raw',
                'value' => function ($data) {
                    $link = '';
                    $dataGet = [];
                    $href = 'javascript:void(0)';
                    if($data->instalasiasal_id == Params::INSTALASI_ID_RJ) {
                        $link = '/rawatJalan/PemeriksaanPasien';
                        $dataGet = ['pendaftaran_id' => $data->pendaftaran_id, 'lihat' => 1];
                    }
                    if($data->instalasiasal_id == Params::INSTALASI_ID_RD) {
                        $link = '/rawatDarurat/pemeriksaanPasienTRD';
                        $dataGet = ['pendaftaran_id' => $data->pendaftaran_id, 'lihat' => 1];
                    }
                    if(in_array($data->instalasiasal_id, Params::INSTALASI_ID_RI_ARR)) {
                        $modPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                        $link = '/rawatInap/PemeriksaanPasien';
                        $dataGet = ['pendaftaran_id' => $data->pendaftaran_id, 'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id ?? '', 'lihat' => 1];
                    }

                    if(!empty($link) && !empty($dataGet)) {
                        $href = $this->createUrl($link, $dataGet);
                    }

                    echo CHtml::link('<i class="icon-form-eye"></i>', $href);

                }
            ],
            // array(
            //     'header' => 'Buat Jadwal',
            //     'type' => 'raw',
            //     'htmlOptions' => array('style' => 'text-align: center;'),
            //     'value' => function($data) {
            //         $html = CHtml::Link("<i class='icon-form-buatjadwal'></i>",Yii::app()->controller->createUrl("buatJadwal",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id)),
            //                             array("class"=>"icon-form-buatjadwal", 
            //                                     "id" => "selectPasien",
            //                                     "rel"=>"tooltip",
            //                                     "title"=>"Klik untuk rencana operasi pasien",
            //                                     "target"=>"frameBuatJadwal",
            //                                     "onclick"=>"$('#dialogBuatJadwal').dialog('open')",
            //         ));
            //         $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($data->pasienkirimkeunitlain_id);

            //         if(!empty($modKirimKeUnitLain->tgl_jadwalpemeriksaan)) {
            //             $html .= '<br> <b> TERJADWAL </b>';
            //         }

            //         return $html;
            //     },
            // ),
            
            array(
                'header' => 'Pemeriksaan',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => function ($data) {

                    $link = Yii::app()->controller->createUrl("/rehabMedis/pendaftaranRehabilitasiMedisRujukanRS/indexTindakan",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id));
                    $style = '';
                    if(empty($data->tglrencanapemeriksaan)) {
                        $link = 'javascript:pemberitahuan()';
                        $style = 'opacity:40%';
                    }
                    echo CHtml::Link("<i class='icon-form-periksa'></i>",$link,
                                        array("class"=>"icon-form-periksa", 
                                                "id" => "selectPasien",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk rencana operasi pasien",
                                                // "target"=>"blank",
                                                'style' => $style
                                        ));
                },
            ),
            array(
                'header' => 'Batal Rujukan',
                'type' => 'raw',
                'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->pasienkirimkeunitlain_id\')",array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan"))',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
?>

<script>
    function pemberitahuan(){
        window.parent.myAlert("Belum ada tanggal rencana pemeriksaan");
        return false;
    }
</script>