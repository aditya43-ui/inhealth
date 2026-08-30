<?php 

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienpenunjangrujukan-m-grid',
    'dataProvider' => $dataProvider,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'replaceUrl' => true,
    'columns' => array(
        'tgl_kirimpasien',
        array(
            'header' => 'Tgl. Rencana Pemeriksaan',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglrencanapemeriksaan)',
        ),
        array(
            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => function ($data) {

                echo $data->tgl_pendaftaran."/<br>".$data->no_pendaftaran . "<br>";
                $dialog = CHtml::Link("Pilih Pendaftaran",Yii::app()->createUrl("laboratorium/rujukanPenunjang/pilihPendaftaran",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
                        array("class"=>"btn btn-info", 
                            "target"=>"framePilihPendaftaran",
                            "onclick"=>"$(\"#dialogPilihPendaftaran\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk memilih pendaftaran", 
            ));
                echo $data->pendaftaran_id == null ? $dialog : null;
            },
        ),
        array(
            'header' => ' Instalasi/<br>Ruangan',
            'value' => '$data->InstalasiNamaRuanganNama',
        ),
        array(
            'header' => 'Dokter Pengirim',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama'
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan.$data->nama_pasien',
        ),
        //'alamat_pasien',										
        //'jeniskasuspenyakit_nama',             
        array(
            'header' => 'Kasus Penyakit',
            'value' => '$data->jeniskasuspenyakit_nama'
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'value' => '$data->CaraBayarPenjaminNama',
        ),
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'value' => function ($data) {                                
                $cito = "";

                if (!empty($data->pasienkirimkeunitlain_id)) {

                    $modUnitLain = PasienkirimkeunitlainT::model()->findByPk($data->pasienkirimkeunitlain_id);

                    if ($modUnitLain->is_cito == true) {
                        $cito = "cito";
                    }
                }
                echo CHtml::hiddenField('warna', $cito, array('class' => 'ubah'));

                return Params::getWrStatusPeriksa($data->statusperiksa);
            }
        ),
        array(
            'header' => 'Persetujuan',
            'type' => 'raw',
            'value' => function ($data) use ($module) {
                return CHtml::link("<icon class='icon-form-operasi'></icon> ", Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/Index', array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id)), array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk menyetujui", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        
        array(
            'header' => 'Periksa',
            'type' => 'raw',
            'value' => function ($data) {
            
                $url = Yii::app()->controller->createUrl("pendaftaranBedahSentralRujukanRS/index", array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id));
                $opacity = '';
                if ($data->pendaftaran_id == null){
                    $url = 'javascript:;';
                    $opacity = 'disabled-icon';
                }
                
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::Link(
                                    "<i class='icon-form-roperasi '></i>",
                                    'javascript:;',
                                    array(
                                        "class" => "icon-form-roperasi ".$opacity,
                                        "id" => "selectPasien",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk periksa pasien",
                                        'onclick' => 'myAlert("Anda tidak dapat menginput pemeriksan, karena status pasien ' . $data->statusperiksa . '","Perhatian !")'
                                    )
                    );
                } else {
                    return CHtml::Link(
                                    "<i class='icon-form-roperasi'></i>",
                                    $url,
                                    array(
                                        "class" => "icon-form-roperasi ".$opacity,
                                        "id" => "selectPasien",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk periksa pasien",
                                    )
                    );
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Batal Rujukan',
            'type' => 'raw',
            'value' => function ($data) {
                
                $url = "javascript:batalperiksa(" . $data->pendaftaran_id . "," . $data->pasienkirimkeunitlain_id . ")";
                $opacity = '';
                if ($data->pendaftaran_id == null){
                    $url = 'javascript:;';
                    $opacity = 'disabled-icon';
                }
                
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left", "onclick" => 'myAlert("Anda tidak dapat membatalkan rujukan, karena status pasien ' . $data->statusperiksa . '","Perhatian !")','class'=>$opacity));
                } else {
                    return CHtml::link("<i class='icon-form-silang'></i>", $url, array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left",'class'=>$opacity));
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){ubahWarna();jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

?>