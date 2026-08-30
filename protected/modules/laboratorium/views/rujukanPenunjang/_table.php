<style>
    .merah td {
        background-color: #f1a9a9 !important;
    }
    .kuning td {
        background-color: #ffffa1 !important;
    }
</style>
<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienpenunjangrujukan-m-grid',
    'dataProvider' => $model->searchPasienRujukan(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'rowCssClassExpression' => '($data->is_bga) ?"kuning":(($data->is_cyto) ? "merah" : "")',
    'columns' => array(
        array(
            'header' => 'Tanggal Rujukan',
            'name' => 'tgl_kirimpasien',
            'type' => 'raw',
            'value' => '$data->tgl_kirimpasien'
        ),
        array(
            'header' => 'Tgl. Rencana Pemeriksaan',
            'value' => function ($data) {
                // echo MyFormatter::formatDateTimeForUser($data->tglrencanapemeriksaan);

                $dialog = '';

                if(empty($data->tglrencanapemeriksaan)) {
                    $dialog = CHtml::Link("Pilih<br>Tgl. Pemeriksaan",Yii::app()->createUrl("laboratorium/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
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
                    $dialog = CHtml::Link("$tgl",Yii::app()->createUrl("laboratorium/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
                            array("class"=>"btn btn-success", 
                                "target"=>"framePilihTglPeriksa",
                                "onclick"=>"$(\"#dialogPilihTglPeriksa\").dialog(\"open\");",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk memilih tanggal pemeriksaan", 
                    ));
                   
                    // $dialog = CHtml::Link("$tgl<br>$jam","#",
                    //             array("class"=>"btn btn-success", "target"=>"", "onclick"=>"",
                    //         ));
                }
                echo "<center>$dialog</center>";
            },
        ),
        // 'tgl_kirimpasien',
        array(
            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => '$data->tgl_pendaftaran."/<br>".$data->no_pendaftaran',
        ),
        array(
            'header' => 'Instalasi/<br>Ruangan',
            'type' => 'raw',
            'name' => 'instalasi_ruangan',
            'value' => '$data->InstalasiNamaRuanganNama',
        ),
        array(
            'header' => 'Dokter Pengirim',
            'value' => '$data->namaLengkap'
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien/<br>NIK',
            'name' => 'nama_pasien_panggilan',
            'value' => '$data->nama_pasien."/".$data->pasien_id',
        ),
        array(
            'header' => 'Diagnosa Pasien',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        array(
            'header' => 'Kasus Penyakit',
            'name' => 'kasus_pelayanan',
            'type' => 'raw',
            'value' => '"$data->jeniskasuspenyakit_nama"',
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'name' => 'cara_bayar_penjamin',
            'value' => '$data->CaraBayarPenjaminNama',
        ),
        //                'jeniskasuspenyakit_nama',
        //                'pendaftaran.umur',
        //                'pemeriksaanrad_nama',
        //                array(
        //                    'header'=>'Periksa',
        //                    'type'=>'raw',
        //                    'value'=>'CHtml::Link("<i class=\"icon-user\"></i>",Yii::app()->controller->createUrl("masukPenunjang/",array("idPasienKirimKeUnitLain"=>$data->pasienkirimkeunitlain_id,"pendaftaran_id"=>$data->pendaftaran_id)),
        //                                    array("class"=>"icon-user", 
        //                                          "id" => "selectPasien",
        //                                          "rel"=>"tooltip",
        //                                          "title"=>"Klik untuk periksa pasien",
        //                                    ))',
        //TRIAL BETA
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'value' => function ($data) {
                return Params::getWrStatusPeriksa($data->statusperiksa);
            }
        ), //myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien '.$data->statusperiksa.'","Perhatian !")'
        array(
            'header' => 'Cyto',
            'type' => 'raw',
            'value' => function($data){
                if($data->is_cyto == 1){
                    echo "Cyto";
                }else{
                    echo "Biasa";
                }
            }
        ),
        array(
            'header' => 'Print',
            'type' => 'raw',
            'value' => 'CHtml::link("<i class=\'icon-print\'></i>", "javascript:printStatus(\'$data->pendaftaran_id\',\'$data->pasienkirimkeunitlain_id\')",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan"))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Periksa',
            'type' => 'raw',
            'value' => function ($data) {
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG ) {
                    return CHtml::Link(
                        "<i class='icon-form-periksa'></i>",
                        'javascript:;',
                        array(
                            "class" => "icon-form-periksa",
                            "id" => "selectPasien",
                            "rel" => "tooltip",
                            "title" => "Klik untuk periksa pasien",
                            'onclick' => 'myAlert("Anda tidak dapat menginput pemeriksan, karena status pasien ' . $data->statusperiksa . '","Perhatian !")'
                        )
                    );
                } else if(empty($data->tglrencanapemeriksaan)) {
                    return CHtml::Link(
                        "<i class='icon-form-periksa'></i>",
                        'javascript:;',
                        array(
                            "class" => "icon-form-periksa",
                            "id" => "selectPasien",
                            "rel" => "tooltip",
                            "title" => "Klik untuk periksa pasien",
                            'onclick' => 'myAlert("Silahkan Isi Tgl Rencana Pemeriksan Terlebih Dahulu","Perhatian !")'
                        )
                    );
                } else {
                    return CHtml::Link(
                        "<i class='icon-form-periksa'></i>",
                        Yii::app()->controller->createUrl("pendaftaranLaboratoriumRujukanRS/index", array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id)),
                        array(
                            "class" => "icon-form-periksa",
                            "id" => "selectPasien",
                            "rel" => "tooltip",
                            "title" => "Klik untuk periksa pasien",
                        )
                    );
                }
            },
        ),
        array(
            'header' => 'Batal Rujuk',
            'type' => 'raw',
            'value' => function ($data) {
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array('onclick' => 'myAlert("Anda tidak dapat membatalkan rujukan ini, karena status pasien ' . $data->statusperiksa . '","Perhatian !")', "id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left"));
                } else {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(" . $data->pendaftaran_id . "," . $data->pasienkirimkeunitlain_id . ")", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left"));
                    //												/dialogBatalPeriksa
                    //return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;",array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan","data-placement"=>"left",'onclick'=>'dialogBatalPeriksa('.$data->pendaftaran_id.','.$data->pasienkirimkeunitlain_id.',"'.$data->nama_pasien.'")'));
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        // array(
        //    'header'=>'Batal Periksa',
        //    'type'=>'raw',
        //    'value'=>'CHtml::link("<i class=\'icon-remove\'></i>", "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan"))',
        //    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
        // ),            
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

?>