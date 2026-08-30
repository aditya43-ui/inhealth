<?php
    $artab = array(
        array(
            'header' => CHtml::checkBox('is_pilihsemua', false, array('onclick' => 'pilihSemua(this)', 'title' => 'Klik untuk pilih semua', 'rel' => 'tooltip')),
            'type' => 'raw', //$row+1
            'value' => '
                CHtml::hiddenField(\'PesanmenudietT[\'.($row+1).\'][pesanmenudiet_id]\',$data->pesanmenudiet_id).
                CHtml::checkBox(\'PesanmenudietT[\'.($row+1).\'][checklist]\', false, array(\'class\'=>\'checklist\', \'onclick\'=>\'setNol(this);\', \'value\'=> $data->pesanmenudiet_id));
                ',
        ),
        array(
            'header' => 'Tanggal Pesan',
            //				'name'=>'tglpesanmenu',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
        ),
        // array(
        //     'header' => 'No. Pesan',
        //     'type' => 'raw',
        //     'value' => '$data->nopesanmenu'
        // //                            'name' => 'nopesanmenu',                            
        // ),
    );
    array_push(
        $artab,
        array(
            'header' => 'No Rekam Medik',
            'type' => 'raw',
            'value' => function ($data) {
                $criteria = new CDbCriteria();
                $criteria->select = 'distinct(t.pasienadmisi_id), t.pasien_id';
                $criteria->join = " JOIN pasienadmisi_t p ON p.pasienadmisi_id = t.pasienadmisi_id ";
                $criteria->addCondition("pesanmenudiet_id = " . $data->pesanmenudiet_id);
                $criteria->addCondition("pasienpulang_id IS NULL");
                $modDetail = PesanmenudetailT::model()->findAll($criteria);

                foreach ($modDetail as $key => $value) {
                    $modPasien = PasienM::model()->findByPk($value->pasien_id);
                    echo $modPasien->no_rekam_medik . '<br>';
                    // echo $data->pesanmenudiet_id;
                }
            }
        )
    );
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
        array_push($artab, array(
            'header' => 'Instalasi / Kamar Ruangan / Bed',
            'type' => 'raw',
            'value' => function ($data) {
                $criteria = new CDbCriteria();
                $criteria->select = 'distinct(t.pasienadmisi_id)';
                $criteria->join = " JOIN pasienadmisi_t p ON p.pasienadmisi_id = t.pasienadmisi_id ";
                $criteria->addCondition("pesanmenudiet_id = " . $data->pesanmenudiet_id);
                $criteria->addCondition("pasienpulang_id IS NULL");
                $modDetail = PesanmenudetailT::model()->findAll($criteria);

                foreach ($modDetail as $key => $value) {
                    $modAdmisi = PasienadmisiT::model()->findByAttributes(['pasienadmisi_id' => $value->pasienadmisi_id]);
                    echo $modAdmisi->ruangan->instalasi->instalasi_nama . " / " . (!empty($modAdmisi->kamarruangan->kamarruangan_nokamar) ? $modAdmisi->kamarruangan->kamarruangan_nokamar : '-') . " / " . (!empty($modAdmisi->kamarruangan->kamarruangan_nobed) ? $modAdmisi->kamarruangan->kamarruangan_nobed : '-') . '<br>';
                }
            },
        ));
    }
    array_push(
        $artab,
        array(
            'header' => 'Nama Pasien',
            'type' => 'raw',
            'value' => function ($data) {
                $criteria = new CDbCriteria();
                $criteria->select = 'distinct(t.pasienadmisi_id), t.pasien_id';
                $criteria->join = " JOIN pasienadmisi_t p ON p.pasienadmisi_id = t.pasienadmisi_id ";
                $criteria->addCondition("pesanmenudiet_id = " . $data->pesanmenudiet_id);
                $criteria->addCondition("pasienpulang_id IS NULL");
                $modDetail = PesanmenudetailT::model()->findAll($criteria);

                foreach ($modDetail as $key => $value) {
                    $modPasien = PasienM::model()->findByPk($value->pasien_id);
                    echo $modPasien->nama_pasien . '<br>';
                }
            }
        )
    );
    // array_push(
    //     $artab,
    //     array(
    //         'header' => 'Bentuk Diet',
    //         'type' => 'raw',
    //         'value' => function ($data) {
    //             $criteria = new CDbCriteria();
    //             $criteria->select = 'distinct(t.pasienadmisi_id), tipediet_id';
    //             $criteria->join = " JOIN pasienadmisi_t p ON p.pasienadmisi_id = t.pasienadmisi_id ";
    //             $criteria->addCondition("pesanmenudiet_id = " . $data->pesanmenudiet_id);
    //             $criteria->addCondition("pasienpulang_id IS NULL");
    //             $modDetail = PesanmenudetailT::model()->findAll($criteria);

    //             foreach ($modDetail as $key => $value) {
    //                 $modTipeDiet = TipeDietM::model()->findByPk($value->tipediet_id);
    //                 echo (!empty($modTipeDiet->tipediet_nama) ? '- ' . $modTipeDiet->tipediet_nama : '') . '<br>';
    //             }
    //         }
    //     )
    // );
    array_push(
        $artab, 
        array(
            'header' => 'Jenis Diet',
            'type' => 'raw',
            'value' => '$data->jenisdiet->jenisdiet_nama'
        ));
    array_push(
        $artab,
        array(
            'header' => 'Menu Diet' . CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("rel"=>"tooltip","title"=>"Klik Untuk Verifikasi Semua","class"=>"btn_small",
                "id"=>"verifikasi",
                "onClick"=>"verifikasiAll()",
            )),
            'type' => 'raw',
            'value' => function ($data) {
                $jeniswaktu_id = null;
                if (isset($_GET['GZPesanmenudietT']['jeniswaktu_id'])){
                    $jeniswaktu_id =  $_GET['GZPesanmenudietT']['jeniswaktu_id'];
                }
                $criteria = new CDbCriteria();
                $criteria->select = 'distinct(t.pasienadmisi_id), menudiet_id, pesanmenudetail_id, verifikasi_id';
                $criteria->join = " JOIN pasienadmisi_t p ON p.pasienadmisi_id = t.pasienadmisi_id ";
                $criteria->addCondition("pesanmenudiet_id = " . $data->pesanmenudiet_id);
                $criteria->addCondition("pasienpulang_id IS NULL");
                if(!empty($jeniswaktu_id)) {
                    $criteria->addCondition('jeniswaktu_id=' . $jeniswaktu_id);
                }
                $modDetail = PesanmenudetailT::model()->findAll($criteria);

                foreach ($modDetail as $key => $value) {
                    $linkVerif = CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("rel"=>"tooltip","title"=>"verifikasi","class"=>"btn_small",
                    "id"=>"verifikasi",
                    "onClick"=>"verifikasi('" . $value->pesanmenudetail_id . "')",
                    ));
                    $modMenuDietM = MenuDietM::model()->findByPk($value->menudiet_id);

                    
                    if(!empty($value->verifikasi_id)) {
                        if(!empty($value->pegawaiverif)) {
                            $linkVerif = '<br> <b>Sudah Diverifikasi Oleh :</b> <br><b>' . $value->pegawaiverif->namaLengkap . '</b>';
                        }
                    }
                    echo (!empty($modMenuDietM->menudiet_nama) ? '- ' . $modMenuDietM->menudiet_nama : '') . $linkVerif . '<br><hr>';
                }
            }
        )
    );
    array_push(
        $artab,
        // array(
        //     'header' => 'Rincian',
        //     'type' => 'raw',
        //     'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/PesanmenudietT/detailPesanMenuDiet",array("id"=>$data->pesanmenudiet_id)),array("id"=>"$data->pesanmenudiet_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk rincian pemesanan menu diet", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: left')
        //         ), 
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function ($data) {
                $modCek = GZPesanmenudietT::getRencanaPulang($data->pesanmenudiet_id);
                $modCekCreate = GZPesanmenudietT::getWarnaCreate($data->pesanmenudiet_id);
                $modCekUpdate = GZPesanmenudietT::getWarnaUpdate($data->pesanmenudiet_id);

                echo CHtml::hiddenField('warna', $modCek['jumlah_rencana'], array('class' => 'ubah'));
                echo CHtml::hiddenField('create', $modCekCreate['warna'], array('class' => 'ubah_craate'));
                echo CHtml::hiddenField('update', $modCekUpdate['warna'], array('class' => 'ubah_update'));

                $tgl = explode(' ', $data->tglpesanmenu);


                $tgl_pesan = isset($tgl[0]) ? $tgl[0] : null;

                if ($tgl_pesan < date('Y-m-d')) {
                    echo CHtml::link("<i class='entypo-pencil' style='font-size:15pt; text-align: center'></i>", '#', array("rel" => "tooltip", 'onclick'=>"myAlert('Data backdate tidak bisa diubah'); return false;"));
                } else {
                    if ($data->jenispesanmenu == 'Pasien') {
                        echo CHtml::link("<i class='entypo-pencil' style='font-size:15pt; text-align: center'></i>", $this->createUrl('/gizi/pesanmenudietpasienT/index', array('id' => $data->pesanmenudiet_id)), array("rel" => "tooltip"));
                    } else {
                        echo CHtml::link("<i class='entypo-pencil' style='font-size:15pt; text-align: center'></i>", $this->createUrl('/gizi/pesanmenudietpegawaiT/index', array('id' => $data->pesanmenudiet_id)), array("rel" => "tooltip"));
                    }
                }


            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        // array(
        // 'header' => 'Etiket',
        // 'type' => 'raw',
        // 'value' => function ($data) {
        //     return CHtml::link("<i class='icon-form-detail'></i>", Yii::app()->createUrl('/gizi/PesanmenudietT/PrintGizi', array(
        //                         'pesanmenudiet_id' => $data->pesanmenudiet_id, 'caraPrint' => 'dialog'
        //                     )), array(
        //                 'target' => 'iframeDetailPenjualan',
        //                 'rel' => 'tooltip',
        //                 'title' => 'Klik untuk print etiket',
        //                 'onclick' => '$("#dialogDetailPenjualan").dialog("open")'
        //     ));
        // }
        //     ), 
        array(
            'header' => 'Cetak Label',
            'type' => 'raw',
            'value' => function ($data) {
                return '<center>' . CHtml::link("<i class='entypo-print' style='font-size:15pt'></i>", Yii::app()->createUrl('gizi/PesanmenudietT/cetakLabel', array('pesanmenudiet_id' => $data->pesanmenudiet_id)), array(
                    'class' => 'hover',
                    "rel" => "tooltip",
                    "target" => "iframeCetak",
                    "onclick" => "$('#dialogCetak').dialog('open');",
                    "title" => "Klik untuk Mencetak Label Makanan"
                )) . '</center>';
            },
            'htmlOptions' => array(
                'style' => 'text-align: left',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        )
    );
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
        // array_push($artab, array(
        //     'header' => 'Kirim Menu Diet',
        //     'type' => 'raw',
        //     //'value'=>'(($data->jenispesanmenu == "'.Params::JENISPESANMENU_PASIEN.'") ? CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")) : CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")))','htmlOptions'=>array('style'=>'text-align: left')
        //     'value' => function ($data) {
        //         if (empty($data->kirimmenudiet_id)) {
        //             //                                    if ($data->jenispesanmenu == Params::JENISPESANMENU_PASIEN){
        //             echo '<center>' . CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index", array("idPesan" => $data->pesanmenudiet_id)), array("rel" => "tooltip", "title" => "Klik untuk Melanjutkan ke Pengiriman")) . '</center>';
        //             //                                    }else{
        //             //                                        echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman"));
        //             //                                    }                                    
        //         } else {
        //             if ($data->status_terima == TRUE) {
        //                 echo "Sudah Dikirim";
        //             } else {
        //                 echo "Sedang Dikirim";
        //             }
        //         }
        //     }
        // ));
    }
    // array_push($artab, array(
    //     'header' => 'Batal <br> Pesan',
    //     'type' => 'raw',
    //     //'value'=>'CHtml::link("<i class=icon-form-silang></i>","#",array("idPesanDiet"=>$data->pesanmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Batal Pesan Menu Diet","onclick"=>"batalPesan(\'$data->pesanmenudiet_id\'); return false;"))',
    //     'value' => function ($data) {
    //         if (empty($data->kirimmenudiet_id)) {
    //             echo '<center>' . CHtml::link("<i class=icon-form-silang></i>", "#", array("idPesanDiet" => $data->pesanmenudiet_id, "href" => "#", "rel" => "tooltip", "title" => "Klik untuk Batal Pesan Menu Diet", "onclick" => "batalPesan('" . $data->pesanmenudiet_id . "'); return false;")) . '</center>';
    //         } else {
    //             echo "Sudah Diproses";
    //         }
    //     }
    // ));
    // array_push($artab, array(
    //     'header' => 'Status Terima',
    //     'type' => 'raw',
    //     'value' => function ($data) {
    //         $kirim = KirimmenudietT::model()->findByAttributes(array(
    //             'pesanmenudiet_id' => $data->pesanmenudiet_id,
    //         ));
    //         if (empty($kirim)) {
    //             echo "Pemesanan Belum Diproses";
    //         } else {
    //             if ($data->status_terima == TRUE) {
    //                 echo "Sudah Diterima";
    //             } else {
    //                 if ($data->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
    //                     echo Chtml::link("<button class='btn btn-danger'><i class='entypo-check'></i> Konfirmasi</button>", '#', array("onclick" => "terimaKonfirmasi('" . $data->pesanmenudiet_id . "')"));
    //                 } else {
    //                     echo "Belum Diterima";
    //                 }
    //             }
    //         }
    //     }
    // ));
    // if(!in_array(Yii::app()->user->getState('modul_id'), [Params::MODUL_ID_ICU, Params::MODUL_ID_RI])) {
    //     array_push($artab, array(
    //         'header' => 'Verifikasi Gizi' . CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("rel"=>"tooltip","title"=>"Klik Untuk Verifikasi Semua","class"=>"btn_small",
    //         "id"=>"verifikasi",
    //         "onClick"=>"verifikasiAll()",
    //         )),
    //         'type' => 'raw',
    //         'value' => function ($data) {
    //             if(!empty($data->verifikasi_id)) {
    //                 echo 'Sudah Diverifikasi Oleh : ';
    //                 echo '<br><b>';
    //                 echo $data->pegawaiverif->namaLengkap ?? '';
    //                 echo '</b>';
    //             } else {
    //                 echo CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("rel"=>"tooltip","title"=>"verifikasi","class"=>"btn_small",
    //                 "id"=>"verifikasi",
    //                 "onClick"=>"verifikasi('" . $data->pesanmenudiet_id . "')",
    //                 ));
    //             }
                
    //         }
    //     ));
    // }
    array_push(
        $artab,
        array(
            'header' => 'Keterangan',
            'type' => 'raw',
            'value' => '$data->keterangan_pesan'
        )
    );
    array_push(
        $artab,
        array(
            'header' => 'Alergi Makanan',
            'type' => 'raw',
            'value' => '$data->adaalergimakanan'
        )
    );
    // array_push($artab, array(
    //     'header'=>'Pesan Kembali',
    //     'type'=>'raw',
    //     'value'=> function($data){                
    //         $dis = true;
    //         if (!empty($data->kirimmenudiet_id) && $data->status_terima == true){
    //             $dis = false;
    //         }

    //         $url = 'javascript:;';
    //         if ($data->jenispesanmenu == 'Pasien') {
    //             $url = $this->createUrl('/gizi/pesanmenudietpasienT/index', array('id' => $data->pesanmenudiet_id,'jenis'=>'pesan-ulang'));
    //         }

    //         return CHtml::Link("<span style='font-size:12px;' class=\"entypo-arrows-ccw\"></span>",$url,
    //             array(
    //                 "class"=>"btn-sm btn-info btn",                 
    //                 // 'disabled'=>$dis,
    //              )
    //         );
    //     },
    //     'htmlOptions'=>[
    //         'style'=>'text-align:center; width:50px;'
    //     ]
    // ));

    if (CustomFunction::isGridViewUpdate('gzpesanmenudietpasien-v-grid')) {

    $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
        'id' => 'gzpesanmenudietpasien-v-grid',
        'dataProvider' => $model->searchInformasiMenuPasien(),
        //	'filter'=>$model,
        // 'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed table-pesan-menu-diet',
        'rowCssClassExpression' => 'empty($data->pesanmenudiet_id) ?"tr_isadmin":""',

        'columns' => $artab,
        // 'items_perpage' => 5,
        // 'dropdownItemKelipatan' => 5,
        'afterAjaxUpdate' => 'function(id, data){ubahWarna();
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
    ));
    }
    ?>