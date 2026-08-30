
<?php
Yii::import('pendaftaranPenjadwalan.models.*');
    $this->widget(
        'ext.bootstrap.widgets.BootGridView',
        array(
            'id' => 'rawatJalan-grid',
            'dataProvider' => $modInfoVerifikasiKunjuganRJ->searchInformasiRJ(),
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
                    'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                    'type' => 'raw',
                    'value' => function ($data) {
                            $html = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . '<br>' . $data->no_pendaftaran;
    
                        return $html;
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    )
                ),
                /*
                    array(
                        'header'=>'No. Pendaftaran',
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'(!empty($data->no_pendaftaran) ? CHtml::link("<i class=icon-form-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pendaftaran_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk mencetak Status Pasien")) : "-")',
                        'htmlOptions'=>array('style'=>'text-align: center;')
                    ), */
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'no_rm',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->no_rekam_medik;
                    },
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;')
                ),/*
                    array(
                        'header'=>'Nama Depan',
                        'type'=>'raw',
                        'value'=>'$data->namadepan'
                    ), */
                array(
                    'header' => 'Nama Pasien/Tanggal Lahir/Jenis Kelamin/Alamat/Lihat Berkas',
                    'type' => 'raw',
                    'value' => function ($data) {
                        echo $data->namadepan . $data->nama_pasien;
                      
                        echo "<br>";
                        echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                        echo "<hr>";
                        echo $data->jeniskelamin;
                        echo "<hr>";
                        
                        echo $data->alamat_pasien;
                        echo "<hr>";
                        echo  CHtml::link(
                            '<i class="icon-form-lihat"></i> Lihat Berkas',
                            Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, 'lihat' => 1)),
                            array(
                                "rel" => "tooltip",
                                "title" => "Klik untuk melihat berkas pasien",
                                "target" => "blank",
                            )
                        );
                        // var_dump($model);
                    }
                ),
               
                array(
                    'name' => 'Jenis Kasus Penyakit',
                    'type' => 'raw',
                    'value' => '$data->jeniskasuspenyakit_nama',
                    'htmlOptions' => array(
                        'style' => 'text-align: left'
                        // 'class'=>'rajal'
                    )
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
                        
                    },
                ),
                array(
                    'name' => 'Jenis Penjamin/Penjamin',
                    'type' => 'raw',
                    
                    'value' => function ($data) {
                        if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                            return $data->CaraBayarPenjamin;
                        } else {
                            return ((!empty($data->CaraBayarPenjamin) && ($data->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA)) ?
                            $data->CaraBayarPenjamin : $data->CaraBayarPenjamin);
                            // return $data->CaraBayarPenjamin;
                        }
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: left;',
                        'class' => 'inap'
                    )
                ),
                
                array(
                    'name' => 'Poliklinik/<br>Nama Dokter/<br>Tracer Konsultasi',
                    'type' => 'raw',
                    'value' => function($data) {
                        echo $data->ruangan_nama;
                        echo "<br><hr>";
                        echo ((!empty($data->nama_pegawai)&& ($data->statusperiksa!=Params::STATUSPERIKSA_SUDAH_PULANG)) ? $data->nama_pegawai : $data->nama_pegawai)."<br>"."<hr><br>". $data->tracer_konsul;
                    },
                    'htmlOptions' => array(
                        'style' => ''
                        // 'class'=>'rajal'
                    )
                ), 
                array(
                    'header' => 'Status Periksa/<br/>Pembuatan SRK',
                    'name' => 'statusperiksa',
                    'type' => 'raw',
                    
                    'value' => function ($data) {
                        

                        $str = Params::getWrStatusPeriksa($data->statusperiksa);


                        $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));

                        if (($data->pasienpulang_id != 0)) {
                            $str .= "</br>";
                            $str .= "<hr>";
                            $str .= "DIRAWAT INAP";
                            $str .= "</br>";
                            // $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                            if (!empty($admisi)) {
                                $kamar = empty($admisi->kamarruangan_id) ? "" : ($admisi->kamarruangan->kamarruangan_nokamar . "<br>" . $admisi->kamarruangan->kamarruangan_nobed);
                                $ruangan = empty($admisi->ruangan_id) ? "" : $admisi->ruangan->ruangan_nama;

                                $str .= $ruangan . "</br>" . $kamar;
                            } else {
                               

                                
                            }
                        }
                       

                        return $str;
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                        'class' => 'status'
                    )
                ),
                [
                    'header' => 'Cara Keluar / <br> Kondisi Keluar',
                    'value' => function ($data) {
                        echo $data->carakeluar_nama;
                        echo ' / <br>';
                        echo $data->kondisikeluar_nama;
                    }
                ],
               
                
                array(
                    'header' => 'Petugas Loket',
                    'type' => 'raw',
                    'value' => function ($data) {
                        $lp = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                        return empty($lp->pegawai_id) ? $lp->nama_pemakai : $lp->pegawai->nama_pegawai;
                    }
                ),
                array(
                    'header' => 'Case Manager',
                    'type' => 'raw',
                    'value' => function ($data) {
                        $link = CHtml::link('<i class="icon-form-periksa"></i> ', Yii::app()->createUrl('rekamMedis/ManagerPelayananPasien/index', array("pendaftaran_id" => $data->pendaftaran_id, 'typeinstalasi' => 'RJ')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Case Manager"));
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
        )
    );
?>