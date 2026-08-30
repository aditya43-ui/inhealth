<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienrujukan-m-grid',
    'dataProvider' => $dataProvider,
    'replaceUrl' => true,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tanggal Permintaan HD',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_kirimpasien)',
        ),
        array(
            'header' => 'Tgl. Rencana Pemeriksaan',
            'value' => function ($data) {
                // echo MyFormatter::formatDateTimeForUser($data->tglrencanapemeriksaan);

                $dialog = '';

                if(empty($data->tglrencanapemeriksaan)) {
                    $dialog = CHtml::Link("Pilih<br>Tgl. Pemeriksaan",Yii::app()->createUrl("/tindakan/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
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
                    $dialog = CHtml::Link("$tgl",Yii::app()->createUrl("tindakan/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")), array(
                                            "class"=>"btn btn-success", 
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
            'header' => 'Tgl. Pendaftaran/<br/>No. Pendaftaran',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br/>".$data->no_pendaftaran'
        ),
        array(
            'header' => 'Instalasi Asal',
            'value' => '$data->instalasi_asal'
        ),
        array(
            'header' => 'Ruangan Asal',
            'value' => '$data->ruangan_asal'
        ),
        array(
            'header' => 'Dokter Pengirim',
            'value' => '$data->nama_pegawai'
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan.$data->nama_pasien',
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'value' => '$data->carabayar_nama." / ".$data->penjamin_nama',
        ),
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
        array(
            'header' => 'Periksa',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class='icon-form-periksa'></i>", Yii::app()->controller->createUrl("/hemodialisa/periksaRujukan/index", array("pendaftaran_id" => $data->pendaftaran_id, "pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id)), array("class" => "icon-form-periksa",

                            "id" => "selectPasien",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Periksa Pasien",
                ));
            },
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Batal Periksa',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(" . $data->pasienkirimkeunitlain_id . ")", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left"));
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

?>