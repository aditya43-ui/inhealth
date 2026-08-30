<?php 

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienpenunjangrujukan-m-grid',
    'dataProvider' => $model->searchPasienRujukan(),
    'replaceUrl' => true,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'replaceUrl' => true,
    'columns' => array(
        /*array(
            'name'=>'no_urutantri',
            'type'=>'raw',
            'header'=>'No. Antrian <br>/ Panggil Antrian',
            'value'=>function($data){
                if(empty($data->pasienmasukpenunjang_id)){
                    if(!empty($data->panggil_loginpemakai_id) && ($data->panggil_loginpemakai_id != Yii::app()->user->getState('loginpemakai_id'))){
                        return "Dipanggil loket lain";
                    }else{
                        if(!empty($data->jml_panggil)){
                            $badge = "<span class=\"badge badge-info pull-right badge-status-jmlPanggil\">".$data->jml_panggil."x</span>";
                        }else{
                            $badge = '';
                        }
                        return 
                            $badge.
                            CHtml::htmlButton(Yii::t("mds","".$data->nourut." <i class='entypo-megaphone'></i>",array()),array("class"=>"btn btn-primary btn-icon","onclick"=>"panggilAntrian('".$data->pasienkirimkeunitlain_id."','".$data->jml_panggil."');","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"));
                    }
                
                }
            },
            'htmlOptions'=>array(
                'style'=>'text-align:center;',
            ),
        ),*/
        [
            'header' => 'Tgl Rujukan',
            'name' => 'tgl_kirimpasien'
        ],	
        array(
            'header' => 'Tanggal Rencana Pemeriksaan',
            'type' => 'raw',
            'value' => function ($data) {
                $dialog = '';

                if(empty($data->tglrencanapemeriksaan)) {
                    $dialog = CHtml::Link("Pilih<br>Tgl. Pemeriksaan",Yii::app()->createUrl("laboratorium/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true", "is_mikro"=>1)),
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
                    $dialog = CHtml::Link("$tgl",Yii::app()->createUrl("laboratorium/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true", "is_mikro"=>1)),
                            array("class"=>"btn btn-success", 
                                "target"=>"framePilihTglPeriksa",
                                "onclick"=>"$(\"#dialogPilihTglPeriksa\").dialog(\"open\");",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk memilih tanggal pemeriksaan", 
                    ));
                 
                }
                echo "<center>$dialog</center>";
               
                
            },
            'htmlOptions' => array('style' => 'text-align:center;'),

        ),

        array(
            'header' => 'Tgl Pendaftaran/<br/>No Pendaftaran',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => '$data->tgl_pendaftaran."/<br/>".$data->no_pendaftaran',
        ),
       								
        array(
            'header' => 'Instalasi/<br/>Ruangan',
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
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien_panggilan',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'name' => 'cara_bayar_penjamin',
            'value' => '$data->CaraBayarPenjaminNama',
        ),
        [
            'header' => 'Diagnosa',
            'value'  => function ($data) {
                $modPasienMorbi = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));

                $diagnosa = '';
                if (!empty($modPasienMorbi)) {
                    foreach ($modPasienMorbi as $row) {
                        $diagnosa .= $row->diagnosa->diagnosa_nama . ', <br>';
                    }
                }

                echo $diagnosa;
            }
        ],
        [
            'header' => 'Jenis Permintaan',
            'value'  => function ($data) {
                if($data->is_nonprogram) {
                    return "Non Program";
                } else if($data->is_programtbc){
                    return "TBC";
                } else if($data->is_programhiv) {
                    return "HIV";
                } else {
                    return "-";
                }
            }
        ],
        [
            'header' => 'Cyto',
            'value'  => '$data->is_cyto == 1 ? "Cyto" : "Biasa"',
        ], 
        [
            'header' => 'Jenis Pemeriksaan',
            'value'  => function($data) {

                $crit = new CDbCriteria;
                $crit->select = 'j.jenispemeriksaanlab_id, j.jenispemeriksaanlab_nama';
                $crit->join = "join pemeriksaanlab_m p on p.pemeriksaanlab_id = t.pemeriksaanlab_id join jenispemeriksaanlab_m j on j.jenispemeriksaanlab_id = p.jenispemeriksaanlab_id";
                $crit->distinct = true;
                $crit->addCondition('t.pasienkirimkeunitlain_id = ' . $data->pasienkirimkeunitlain_id);

                $permintaan = PermintaankepenunjangT::model()->findAll($crit);

                // echo 'pasienkirim: ' . count($permintaan);

                if(!empty($permintaan)) {
                    echo "<ul>";
                    foreach($permintaan as $p) {
                        if(!empty($p->jenispemeriksaanlab_nama)) {
                            echo "<li>" . $p->jenispemeriksaanlab_nama . "</li>";
                        }
                    }
                    echo "</ul>";

                    // return empty($permintaan->pemeriksaanlab_id) ? $permintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama : "";
                } else {
                    return "";
                }
                
            },
        ],  
        [
            'header' => 'Sample Lab',
            'value'  => function($data) {
                
                $crit = new CDbCriteria;
                $crit->select = 's.samplelab_id, s.samplelab_nama';
                $crit->join = "join samplelab_m s on s.samplelab_id = t.samplelab_id";
                $crit->distinct = true;
                $crit->addCondition('t.pasienkirimkeunitlain_id = ' . $data->pasienkirimkeunitlain_id);

                $permintaan = PermintaankepenunjangT::model()->findAll($crit);

                if(!empty($permintaan)) {
                    echo "<ul>";
                    foreach($permintaan as $p) {
                        if(!empty($p->samplelab_nama)) {
                            echo "<li>" . $p->samplelab_nama . "</li>";
                        }
                    }
                    echo "</ul>";

                    // return empty($permintaan->pemeriksaanlab_id) ? $permintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama : "";
                } else {
                    return "";
                }
                
            },
        ],   
        array(
            'header' => 'Pemeriksaan',
            'type' => 'raw',
            'value' => function ($data) {

                $program = '';

                if($data->is_nonprogram) {
                    $program =  "non";
                } else if($data->is_programtbc){
                    $program =  "tbc";
                } else if($data->is_programhiv) {
                    $program =  "hiv";
                }

                if(!empty($data->tglrencanapemeriksaan)) 
                {
                return CHtml::Link("<i class='icon-form-periksa'></i>", Yii::app()->controller->createUrl("pendaftaranLaboratoriumRujukanRSMK/index", array('pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id, 'program'=>$program)), array(
                    "class" => "icon-form-periksa",
                    "id" => "selectPasien",
                    "rel" => "tooltip",
                    "title" => "Klik untuk Pemeriksaan Pasien",
                ));
            } else {
                return CHtml::Link("<i class='icon-form-periksa'></i>", 'javascript:void(0)', array(
                    "class" => "icon-form-periksa",
                    "id" => "selectPasien",
                    "rel" => "tooltip",
                    "title" => "Pilih tanggal pemeriksaan terlebih dahulu",
                    "style" => "cursor: not-allowed; opacity:0.6"
                ));
            }
            },
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Minta&nbsp;Sampel&nbsp;Ulang',
            'type' => 'raw',
            'value' => function ($data) {

                if(empty($data->tglrencanapemeriksaan)) {
                    return CHtml::Link("<i class='icon-form-ambilsample'></i>", 'javascript:void(0);', array(
                        "class" => "",
                        "id" => "selectPasien",
                        "rel" => "tooltip",
                        "title" => "Klik untuk minta sampel ulang",
                        "target" => "frameMintaUlang",
                        "onclick" => "myAlert('Silahkan memilih tanggal pemeriksaan terlebih dahulu');",
                    ));
                } else {
                    return CHtml::Link("<i class='icon-form-ambilsample'></i>", Yii::app()->controller->createUrl("rujukanPenunjang/mintaSampelUlang", array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id)), array(
                        "class" => "",
                        "id" => "selectPasien",
                        "rel" => "tooltip",
                        "title" => "Klik untuk minta sampel ulang",
                        "target" => "frameMintaUlang",
                        "onclick" => "$('#dialogMintaUlang').dialog('open')",
                    ));
                }
            },
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Konsultasi',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link("<i class='icon-form-input'></i>", Yii::app()->controller->createUrl("konsulPoli/index", array("pendaftaran_id" => $data->pendaftaran_id, 'idPasienKirimKeUnitLain' => $data->pasienkirimkeunitlain_id)), array(
                    "class" => "",
                    "id" => "selectPasien",
                    "rel" => "tooltip",
                    "title" => "Klik untuk Konsultasi",
                    "target" => "frameKonsultasi",
                    "onclick" => "$('#dialogKonsultasi').dialog('open')",
                ));
            },
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Batal Rujuk',
            'type' => 'raw',
            'value' => function ($data) {
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array('onclick' => 'myAlert("Anda tidak dapat membatalkan rujukan ini, karena status pasien ' . $data->statusperiksa . '","Perhatian !")', "id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left"));
                } else {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(" . $data->pendaftaran_id . "," . $data->pasienkirimkeunitlain_id . ")", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left"));
                   
                }
            },
            'htmlOptions' => array('style' => 'text-align: left; width:40px'),
        ),
                
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));