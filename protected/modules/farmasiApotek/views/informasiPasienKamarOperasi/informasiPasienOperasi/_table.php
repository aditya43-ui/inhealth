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
            'header' => 'Nama Pasien / <br> Tgl. Lahir / <br> Umur',
            'value' => function($data) {
                echo $data->namadepan . $data->nama_pasien;
                echo ' / <br>';
                echo MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                echo ' / <br>';
                echo $data->umur;
            },
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
        [
            'header' => 'Diagnosa',
            'type' => 'raw',
            'value' => function ($data) {
                $morbid = PasienmorbiditasT::model()->findAllByAttributes(array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                    // 'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
                ));
                
                $morbid_res = array();
                foreach ($morbid as $item) {
                    if (empty($morbid_res[$item->ruangan_id])) {
                        $morbid_res[$item->ruangan_id] = array();
                    }
                    $morbid_res[$item->ruangan_id][] = $item;
                }
                echo '<div style="overflow: auto; height: 150px;">';
                if(!empty($data->pendaftaran_id)){
                    if(count((array)$morbid) > 0) {
                        foreach ($morbid_res as $ruangan_id => $item) {
                            $ruangan = RuanganM::model()->findByPk($ruangan_id);
                            echo $ruangan->ruangan_nama."<br>";
                            echo "Diagnosa". ":<br><ul>";
                            foreach ($item as $detail) {
                                echo "<li>".$detail->diagnosa->diagnosa_kode." ".$detail->diagnosa->diagnosa_nama."</li>";
                                // echo "<li>".$detail->ket_diagnosa."</li>";
                            }
                            echo "</ul>";
                        }
                    }
                    
                }
                echo '</div>';

                
            }
        ],
    ),
    'afterAjaxUpdate' => 'function(id, data){ubahWarna();jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

?>