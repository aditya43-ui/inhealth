<?php 
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'rawatInap-grid',
        'dataProvider' => $modPPInfoKunjunganRIV->searchInformasiRI(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-condensed',
        'rowCssClassExpression' => '($data->is_verifikasidiagnosa)?"tr_isadmin":""',
        'replaceUrl' => true,
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '($this->grid->dataProvider->pagination) ? 
            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
            : ($row+1)',
            ),
            [
                'header' => 'Tgl. Masuk Kamar',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgladmisi)'
            ],
            array(
                'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                'name' => 'tgl_pendaftaran',
                'type' => 'raw',
                'value' => function ($data) {
                    $html = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . '<br>' . $data->no_pendaftaran;
                    

                    return $html;
                },
            ),
          
            array(
                'header' => 'No. Rekam Medik',
                'name' => 'no_rekam_medik',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => function ($data) {
                    return $data->no_rekam_medik;
                    
                }
            ), 
            array(
                'header' => 'Nama Pasien/Tanggal lahir/Jenis Kelamin/Lihat Berkas',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->namadepan . $data->nama_pasien;
                    echo "<br>";
                    echo "<hr>";
                    echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                    echo "<br>";
                    echo "<hr>";
                    echo $data->jeniskelamin;
                  
                    echo "<br>";
                    echo "<hr>";
                    echo  CHtml::link(
                        '<i class="icon-form-lihat"></i> Lihat Berkas',
                        Yii::app()->controller->createUrl("/rawatInap/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id,'lihat' => 1)),
                        array(
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat berkas pasien",
                            "target" => "blank",
                        )
                    );
                }
            ),
            array(
                'header' => 'Status Masuk/<br>Cara Masuk',
                'type' => 'raw',
                'value' => '$data->statusmasuk."/<br>".$data->caramasuk_nama',
            ),
            array(
                'header' => 'Perujuk',
                'type' => 'raw',
                'value' => function ($data) {
                    $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    $r = RujukanT::model()->findByPk($p->rujukan_id);
                    return CHtml::Link(
                        $data->asalrujukan_nama . "/<br>" . ((empty($r) || empty($r->rujukandari)) ? ($r->nama_perujuk ?? '-') : $r->rujukandari->namaperujuk)
                    );
                },
            ),
            array(
                'name' => 'CaraBayar/Penjamin',
                'type' => 'raw',
               
                'value' => '$data->CaraBayarPenjamin',
                'htmlOptions' => array(
                    'style' => 'text-align: left;',
                    'class' => 'inap'
                )
            ),
           
            
            array(
                'header' => 'Ruangan/<br>Kelas Pelayanan/<br>Kamar',
                'name' => 'ruangan_nama',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->ruangan_nama . "/<br>" . $data->kelaspelayanan_nama;
                    echo "/<br>";
                    echo "Kamar: " . $data->kamarruangan_nokamar . "<br>" . "Bed: " . $data->kamarruangan_nobed;
                    echo "<hr>";
                    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    if ($cekPembayaran == 'ada') {
                        $alert = 'Pasien sudah membuat rencana pulang';
                    } else {
                        $alert = 'Tagihan Pasien Sudah Lunas. Anda tidak dapat melakukan transaksi ini.';
                    }
                    if (empty($data->renPulang)) {
                        if (!empty($data->pasienpulang_id)) {
                            echo $data->carakeluar;
                        } else {
                            if (!empty($data->kamarruangan_nokamar)) {
                                $time_masukkamar = strtotime($data->tglmasukkamar);
                                
                            } else {
                                
                            }
                        }
                    } else {
                        
                    }
                },
              
                'htmlOptions' => array(
                    'style' => 'text-align: left;',
                    //'class'=>'inap'
                )
            ),
           
            array(
                'header' => 'Dokter Penerima/<br>DPJP',
                'type' => 'raw',
                'value' => function ($data) {
                    $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                    if (empty($admisi->dokterpenerima_id)) return null;
                    $penerima = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
                    echo $penerima->namaLengkap;
                    echo "/<br><hr>";
                    if (!empty($data->nama_pegawai) && ($data->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA)) {
                        echo  $data->gelardepan . ' ' . $data->nama_pegawai . ' ' . $data->gelarbelakang_nama;
                    } else {
                        echo $data->gelardepan;
                    }
                },
            ),
           
            
            array(
                'header' => 'Status Periksa / <br> Check Pemeriksaan',
                'name' => 'statusperiksa',
                'type' => 'raw',
                'value' => function ($data) {
                    $str = Params::getWrStatusPeriksa($data->statusperiksa);
                    
                    return $str;
                },
                'htmlOptions' => array(
                    'style' => 'text-align: left;',
                    'class' => 'status'
                )
            ),
            [
                'header' => 'Cara Keluar / <br> Kondisi Keluar',
                'value' => function ($data) {
                    echo $data->carakeluar;
                    echo ' / <br>';
                    echo $data->kondisikeluar_nama;
                }
            ],
            
            array(
                'header' => 'Petugas Loket',
                'type' => 'raw',
                'value' => function ($data) {
                    $lp = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                    return empty($lp->pegawai_id) ? $lp->nama_pemakai : $lp->pegawai->namaLengkap;
                }
            ),
            array(
                'header' => 'Case Manager',
                'type' => 'raw',
                'value' => function ($data) {
                    $link = CHtml::link('<i class="icon-form-periksa"></i> ', Yii::app()->createUrl('rekamMedis/ManagerPelayananPasien/index', array("pendaftaran_id" => $data->pendaftaran_id, 'typeinstalasi' => 'RI')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Case Manager"));
                    return $link;
                },
                'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                'visible' => ((Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_REKAM_MEDIS) ? true : false)
            )
        ),
        'afterAjaxUpdate' => 'function(id, data){
    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
    disableLink();
}',
    )
);

?>