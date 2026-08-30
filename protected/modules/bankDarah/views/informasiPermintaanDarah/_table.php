<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'permintaandarah-r-grid',
    'replaceUrl' => true,
    'dataProvider' => $model->searchInformasiKirimUnitLainT(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                : ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
        ),
        array(
            'header' => 'Tanggal Pendaftaran / Nomor Pendaftaran',
            'value' => function ($data) {
                echo MyFormatter::formatDateTimeForUser($data['tgl_pendaftaran']) . " / " . $data['no_pendaftaran'];
            },
        ),
        array(
            'header' => 'Tanggal Permintaan / No. Permintaan',
            'value' => function ($data) {
                echo MyFormatter::formatDateTimeForUser($data['tgl_kirimpasien']) . " / " . $data['no_permintaan'];
            }
        ),
        array(
            'header' => 'Instalsi Asal / Ruangan Asal / DPJP ',
            'value' => function ($data) {
               
                $modAdmisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                if(!empty($modAdmisi->ruangan_id)) {
                    echo $modAdmisi->ruangan->instalasi->instalasi_nama . ' / <br>' .$modAdmisi->ruangan->ruangan_nama . " /  <br>" . $data['nama_pegawai'];
                } else {
                    if(!empty($data->pendaftaran)) {
                        echo $data->pendaftaran->ruangan->instalasi->instalasi_nama . ' / <br>' .$data->pendaftaran->ruangan->ruangan_nama . " /  <br>" . $data['nama_pegawai'];
                    }
                }
            }
        ),
        array(
            'header' => 'No. RM',
            'value' => '$data["no_rekam_medik"]',
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data["nama_pasien"]',
        ),
        array(
            'header' => 'Jenis Kelamin',
            'value' => '$data["jeniskelamin"]',
        ),
        array(
            'header' => 'Alamat',
            'value' => '$data["alamat_pasien"]',
        ),
        array(
            'header' => 'Umur',
            'value' => '$data["umur"]',
        ),
        array(
            'header' => 'Gol. Darah / Rhesus',
            'value' => function ($data) {
                echo $data['golongandarah'] . " / " . $data['rhesus'];
            }
        ),
        //                                array(
        //                                    'header' => 'Gol. Darah', 
        //                                    'value' => '$data["golongandarah"]',
        //                                ),
        //                                array(
        //                                    'header' => 'Rhesus', 
        //                                    'value' => '$data["rhesus"]',
        //                                ),
        array(
            'header' => 'Jenis Permintaan',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'value' => function ($data) {
                // echo $data->jenis_permintaan;
                $permintaankepenunjang = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id]);

                if(!empty($permintaankepenunjang) && count($permintaankepenunjang) > 0) {
                    foreach($permintaankepenunjang as $i => $val) {
                        if(!empty($val->jenispermintaan)) {
                            $jenis = '<b>*</b>' . $val->jenispermintaan;
                        } else {
                            $jenis = '';
                        }
                        echo  ' ' . $jenis . '<br>';
                    }
                }
            }
        ),
        array(
            'header' => 'Pemeriksaan',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'type' => 'raw',
            'value' => function ($data) {
                // $penunjang = PasienmasukpenunjangT::model()->findByAttributes(array(
                //     'pasienkirimkeunitlain_id'=>$data->pasienkirimkeunitlain_id
                // ), array(
                //     'order'=>'pasienmasukpenunjang_id desc'
                // ));

                // if (!empty($penunjang)) {
                //     return "-";
                // }

                return CHtml::link("Pemeriksaan", Yii::app()->createUrl('bankDarah/verifikasiPermintaanDarahPasien/index&pasienkirimkeunitlain_id=' . $data->pasienkirimkeunitlain_id . '&pendaftaran_id=' . $data->pendaftaran_id), array('class' => 'btn btn-black btn-status', "rel" => "tooltip", "title" => "Klik untuk menambahkan data transaksi pengujian golongan darah"));
            }
        ),
        array(
            'header' => 'Cetak Ulang',
            'type' => 'raw',
            'value' => function($data) {
                $penunjang = PasienmasukpenunjangT::model()->findByAttributes(array(
                    'pasienkirimkeunitlain_id'=>$data->pasienkirimkeunitlain_id
                ), array(
                    'order'=>'pasienmasukpenunjang_id desc'
                ));

                if (empty($penunjang)) {
                    return "-";
                }

                return  CHtml::link(
                Yii::t(
                    'mds',
                    '{icon}',
                    array('{icon}' => '<i class="icon-form-print"></i>')
                ),
                Yii::app()->controller->createUrl("printUlangTindakanPenunjangDialog", array("pasienmasukpenunjang_id" => $penunjang->pasienmasukpenunjang_id)),
                array(
                    "title" => "Klik untuk Cetak Ulang Nota Tindakan", 
                    "target" => "iframeCetakUlang", 
                    "onclick" => '$("#dialogCetakUlang").dialog("open");', 
                    "rel" => "tooltip", 
                ));


            }
        ),
        array(
            'header' => 'Buat Jadwal',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'value' => function($data) {
                $html = CHtml::Link("<i class='icon-form-buatjadwal'></i>",Yii::app()->controller->createUrl("buatJadwal",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id)),
                                    array("class"=>"icon-form-buatjadwal", 
                                          "id" => "selectPasien",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk rencana operasi pasien",
                                          "target"=>"frameBuatJadwal",
                                          "onclick"=>"$('#dialogBuatJadwal').dialog('open')",
                ));
                

                if(!empty($data->tgl_jadwalpemeriksaan)) {
                    $html .= '<br> <b> TERJADWAL </b>';
                }

                return $html;
            },
        ),
        array(
            'header' => 'Konsultasi',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:center;'),
            'value' => function($data){                                    
                $html = CHtml::Link("<i class='icon-stetoskopblack'></i>",Yii::app()->controller->createUrl("/rawatJalan/konsulPoli/index",array('pendaftaran_id' =>$data->pendaftaran_id,"pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id)),
                array("class"=>"icon-stetoskopblack", 
                      "id" => "selectPasien",
                      "rel"=>"tooltip",
                      "title"=>"Klik Konsultasi pasien",
                      "target"=>"frameKonsul",
                        "onclick"=>"$('#dialogKonsul').dialog('open')",
                ));  
                
                $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);
                if(!empty($modKonsul)) {
                    $html .= '<br> <b> DIKONSULTASIKAN </b>';
                }
                echo $html;
            }
        ),
        array(
            'header' => 'Batal',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => function ($data) {
                if (!empty($data['penyerahandarah'])) {
                    echo "";
                } else {
                    echo CHtml::link("<i class='icon-form-silang'></i>", Yii::app()->createUrl('bankDarah/informasiPermintaanDarahPasien/batal&permintaandarah_id=' . $data['permintaandarah_id']), array("rel" => "tooltip", "title" => "Klik untuk Membatalkan Permintaan Darah", "target" => "framePembuatan", "onclick" => "window.parent.$(\"#dialogPembuatan\").dialog(\"open\");"));
                }
            }
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>