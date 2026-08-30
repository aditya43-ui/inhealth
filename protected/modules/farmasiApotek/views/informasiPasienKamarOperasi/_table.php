<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'tabelPasienOperasi',
        'dataProvider' => $modPasienMasukPenunjang->searchPasienOperasi(),
        //        'filter'=>$model,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
        'columns' => array(
           [
                'header' => 'Tgl. Masuk Penunjang / <br> No. Masuk Penunjang',
                'value' => function ($data) {
                    echo MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang);
                    echo '<br>';
                    echo $data->no_masukpenunjang;
                }
            ],
            [
                'header' => 'Instalasi / <br> Ruangan Asal',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->instalasiasal_nama;
                    echo ' / <br>';
                    echo $data->ruanganasal_nama;
                }
            ],
            [
                'header' => 'No. Pendaftaran / <br> No. RM',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->no_pendaftaran;
                    echo ' / <br>';
                    echo $data->no_rekam_medik;
                }
            ],
            [
                'header' => 'Nama Pasien / <br> Tgl. Lahir / <br> Umur',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->nama_pasien;
                    echo ' / <br>';
                    echo MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                    echo ' / <br>';
                    echo $data->umur;
                }
            ],
            'alamat_pasien',
            [
                'header' => 'Kasus Penyakit / <br> Kelas Pelayanan',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->jeniskasuspenyakit_nama;
                    echo ' / <br>';
                    echo $data->kelaspelayanan_nama;
                }
            ],
            [
                'header' => 'Jenis Penjamin / <br> Penjamin / <br> No. SEP',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->carabayar_nama;
                    echo ' / <br>';
                    echo $data->penjamin_nama;
                    echo ' / <br>';
                    if(!empty($data->nosep)) {
                       echo $data->nosep;
                    }
                }
            ],
            [
                'header' => 'Dokter Pemeriksa',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->gelardepan . ' ' . $data->nama_pegawai . ' ' . $data->gelarbelakang_nama;
                    
                }
            ],
            [
                'header' => 'Dokter Operator',
                'type' => 'raw',
                'value' => function ($data) {
                    $op = RencanaoperasiT::model()->findByAttributes(array(
                        'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id
                    ));

                    if (empty($op)) {
                        return "-";
                    }

                    $peg = PegawaiM::model()->findByPk($op->dokterpelaksana1_id);
                    return $peg->namaLengkap;
                }
            ],
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
            [
                'header' => 'Tindakan Operasi',
                'type' => 'raw',
                'value' => function($data) {
                    $rencana = RencanaoperasiT::model()->findAllByAttributes(array(
                        'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                    ), array(
                        'join' => 'join operasi_m o on o.operasi_id = t.operasi_id',
                        'select' => 't.*, o.operasi_nama',
                    ));

                    if (count((array)$rencana) == 0) {
                        return "-";
                    }

                    $str = '<ul>';
                    foreach ($rencana as $item) {
                        $str .= '<li>' . $item->operasi_nama . '</li>';
                    }
                    $str .= '</ul>';
                    return $str;
                }
            ],
            [
                'header' => 'Rincian Tagihan Sementara',
                'type' => 'raw',
                'value' => function($data) {
                    $htmlLink2 = '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Rincian Tagihan Sementara', Yii::app()->controller->createUrl('/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarRD', array(
                        "instalasi_id" => $data->instalasi_id, "pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, "frame" => true)),
                         array('target' => 'iframeRincianTagihanSementara',  "rel" => "tooltip", "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                        'onclick' => "$('#dialogRincianTagihanSementara').dialog('open');",
                    )) . '</div>';
    
                    echo $htmlLink2;
                }
            ],
            [
                'header' => 'Pengambilan Obat',
                'type' => 'raw',
                'value' => function($data) {
                    echo CHtml::link('<i class="icon-form-jualresep"></i> Pengambilan Obat', $this->createUrl('pengambilanObatOK', ['pendaftaran_id' => $data->pendaftaran_id, 'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id]), array(
                       'class' => 'btn btn-secondary'
                    ));
                }   
            ]
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));