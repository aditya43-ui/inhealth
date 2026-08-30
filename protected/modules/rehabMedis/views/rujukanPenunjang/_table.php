<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienpenunjangrujukan-m-grid',
    'dataProvider' => $dataProvider,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        'tgl_pendaftaran',
        'tgl_kirimpasien',
        array(
            'header' => 'Tanggal Rencana Pemeriksaan',
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
        array(
            'header' => 'Pemeriksaan',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'value' => function ($data) {
                $link =Yii::app()->controller->createUrl("pendaftaranRehabilitasiMedisRujukanRS/index",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id));
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
                                        //   "target"=>"blank",
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