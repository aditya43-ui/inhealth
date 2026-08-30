<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'rawatDarurat-grid',
        'dataProvider' => $modInfoKunjunganRDV->searchInformasiRD(),
        //        'filter'=>$modInfoKunjunganRDV,
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
            array(
                'header' => 'Tanggal Pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            ),
            
            array(
                'header' => 'No. Pendaftaran',
                'name' => 'no_pendaftaran',
                'type' => 'raw',
                'value' => function ($data) {
                    $html = $data->no_pendaftaran;
                    return $html;
                },
                'htmlOptions' => array('style' => 'text-align: center;')
            ),
            array(
                'header' => 'No. Rekam Medik',
                'name' => 'no_rekam_medik',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => function ($data) {
                    echo $data->no_rekam_medik;
                   
                    
                }
            ),
            array(
                'header' => 'Nama Pasien/ Tanggal Lahir/Alamat/Lihat Berkas',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->namadepan . $data->nama_pasien ;
                    echo "<br>";
                    echo "<hr>";

                    echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                    echo "<br>";
                    echo $data->alamat_pasien;
                    echo "<br>";
                    echo "<hr>";
                    echo  CHtml::link(
                        '<i class="icon-form-lihat"></i> Lihat Berkas',
                        Yii::app()->controller->createUrl("/rawatDarurat/pemeriksaanPasienTRD", array("pendaftaran_id" => $data->pendaftaran_id, 'lihat' => 1)),
                        array(
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat berkas pasien",
                            "target" => "blank",
                        )
                    );
                },
            ),
            
            array(
                'header' => 'Cara Masuk',
                'type' => 'raw',
                'value' => '$data->statusmasuk',
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
                'header' => 'Jenis Penjamin/<br>Penjamin',
                'type' => 'raw',
                'value' => function ($data) {
                    if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        return $data->CaraBayarPenjamin;
                    } else {
                        return $data->CaraBayarPenjamin;
                    }
                },
                'htmlOptions' => array(
                    'style' => 'text-align: left;',
                    'class' => 'inap'
                )
            ),
            array(
                'header' => 'Status Konfirmasi',
                'type' => 'raw',
                'value' => '($data->status_konfirmasi == "" ) ? "-" : $data->status_konfirmasi',
            ),
                            
            array(
                'header' => 'Dokter / Ruangan',
                'type' => 'raw',
                'value' => function ($data) {
                    echo  "<div style='width:120px;'>" . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama . "</div>";
                    echo "<br>";
                    if (!empty($data->ruangan_nama) && ($data->statusperiksa == Params::STATUSPERIKSA_ANTRIAN)) {
                        echo $data->ruangan_nama;
                    } else {
                        echo $data->ruangan_nama;
                    }
                    echo "<br>";
                    
                },
            ), 
            
            array(
                'header' => 'Status Periksa / <br> Check Pemeriksaan',
                'type' => 'raw',
            
                'value' => function ($data) {
                 
                    $str = Params::getWrStatusPeriksa($data->statusperiksa);

                    
                    if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                        $str .= "<hr>";
                       
                        $str .= $data->carakeluar . "<br>";
                    }

                    
                    return $str;
                }, //'',
                'htmlOptions' => array(
                    'style' => 'text-align: center;',
                    'class' => 'status'
                )
            ),
            [
                'header' => 'Cara Keluar / <br> Kondisi Keluar',
                'value' => function ($data) {
                    echo $data->carakeluar;
                    echo ' / <br>';
                    echo $data->kondisipulang;
                }
            ],
            array(
                'header' => 'Petugas Loket',
                'type' => 'raw',
                'name' => 'create_loginpemakai_id',
                'value' => function ($data) {
                    $lp = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                    return isset($lp->pegawai_id) ? $lp->pegawai->namaLengkap : '-';
                }
            ),
            array(
                'header' => 'Case Manager',
                'type' => 'raw',
                'value' => function ($data) {
                    $link = CHtml::link('<i class="icon-form-periksa"></i> ', Yii::app()->createUrl('rekamMedis/ManagerPelayananPasien/index', array("pendaftaran_id" => $data->pendaftaran_id, 'typeinstalasi' => 'RD')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Case Manager"));
                    return $link;
                },
                'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                'visible' => ((Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_REKAM_MEDIS) ? true : false)
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            disableLink();
    }',
    )); ?>