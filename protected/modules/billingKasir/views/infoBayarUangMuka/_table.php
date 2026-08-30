<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pencarianpasien-grid',
    'dataProvider' => $model->searchInformasi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl. Pembayaran Uang Muka Pasien/<br/>No. Pembayaran<br>',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgluangmuka) . " <br> " . $data->nouangmuka ',
        ),
        array(
            'header' => 'Tgl. Pendaftaran/<br/>No. Pendaftaran<br>',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . " <br> " . $data->no_pendaftaran ',
        ),
        array(
            'header' => 'Instalasi / Ruangan',
            'type' => 'raw',
            'value' => 'isset($data->instalasi_nama)?$data->ruangan_nama. " / ".$data->ruangan_nama:" - "',
        ),
        array(
            'header' => 'Jenis Penjamin/<br/>Penjamin',
            'type' => 'raw',
            'value' => '$data->carabayar_nama."/<br/>".$data->penjamin_nama',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Total Uang Muka',
            'type' => 'raw',
            'value' => function($data) {
                $str = "Rp. ".MyFormatter::formatNumberForPrint($data->jumlahuangmuka,2);
                if ($data->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                    if ($data->jumlahuangmuka >= 2000000) {
                        $str .= '<span class="sorot_merah">&nbsp;</span>';
                    } else {
                        $str .= '<span class="sorot_kuning">&nbsp;</span>';
                    }
                }
                return $str;
            }, //'"Rp. ".MyFormatter::formatNumberForPrint($data->jumlahuangmuka,2)',
            'htmlOptions' => array('style' => 'text-align: left; width:80px'),
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Total Pemakaian',
            'type' => 'raw',
            'value' => function ($data) {
                return "Rp. " . MyFormatter::formatNumberForPrint($data->uangmukadipakai, 2);
            },
            'htmlOptions' => array('style' => 'text-align: left; width:80px'),
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Sisa Uang Muka',
            'type' => 'raw',
            'value' => function ($data) {
                return "Rp. " . MyFormatter::formatNumberForPrint(($data->jumlahuangmuka - $data->uangmukadipakai), 2);
            },
            'htmlOptions' => array('style' => 'text-align: left; width:80px'),
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Sisa Pembayaran',
            'type' => 'raw',
            'value' => '"Rp. ".MyFormatter::formatNumberForPrint($data->sisaPembayaran($data->jmlpembayaran,$data->jumlahuangmuka+$data->jmlpembulatan),2)',
            'htmlOptions' => array('style' => 'text-align: left; width:80px'),
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Keterangan',
            'type' => 'raw',
            'value' => '$data->keteranganuangmuka'
        ),
        array(
            'header' => 'Petugas Kasir',
            'type' => 'raw',
            'value' => function ($data) use (&$bayar) {
                $bayar = BayaruangmukaT::model()->findByPk($data->bayaruangmuka_id);
                $login = LoginpemakaiK::model()->findByPk($bayar->create_loginpemakai_id);
                if (empty($login->pegawai_id)) return "-";
                $peg = PegawaiM::model()->findByPk($login->pegawai_id);
                return $peg->namaLengkap;
            },
        ),
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'value' => function ($data) {
                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                return CHtml::htmlButton($p->statusperiksa, array(
                    'class' => 'btn ' . Params::statusPeriksaCol()[$p->statusperiksa],
                    'style' => 'min-width: 200px;'
                ));
            },
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:left;'),
        ),
        array(
            'header' => 'Rincian',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('detailUangMuka', array('id' => $data->bayaruangmuka_id)), array(
                    'target' => 'iframeDetail',
                    'onclick' => '$("#dialogDetail").dialog("open");',
                    'data-toggle' => 'tooltip',
                    'title' => 'Klik untuk melihat Rincian Pembayaran Uang Muka',
                ));
            }
        ),
        array(
            'header' => 'Order Batal',
            'type' => 'raw',
            'value' => function ($data) use (&$bayar) {

                if (!empty($bayar->orderbataluangmuka_id)) {
                    return "SUDAH VERIFIKASI BATAL DEPOSIT";
                }

                $pakai = PemakaianuangmukaT::model()->findAllByAttributes(array(
                    'bayaruangmuka_id' => $data->bayaruangmuka_id,
                ));
                if ($data->pemakaianuangmuka > 0) return "SUDAH DIBAYAR";

                $order = OrderbataluangmukaT::model()->findByAttributes(array(
                    'bayaruangmuka_id'=>$data->bayaruangmuka_id
                ));//
                if (!empty($order)) {
                    return "SUDAH ORDER BATAL DEPOSIT";
                }


                if (!empty($data->pembatalanuangmuka_id)) {
                    $bkk = TandabuktikeluarT::model()->findByAttributes(array(
                        'pembatalanuangmuka_id' => $data->pembatalanuangmuka_id
                    ));
                    return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($bkk->tglkaskeluar) . "/<br/>" . $bkk->nokaskeluar . '</u>', $this->createUrl('print/pembatalanUangMuka', array(
                        'idTandaBukti' => $bkk->tandabuktikeluar_id,
                    )), array(
                        'target' => 'iframeDetailBatal',
                        'onclick' => '$("#dialogDetailBatal").dialog("open");',
                        'data-toggle' => 'tooltip',
                        'title' => 'Klik untuk melihat detail Pembatalan Uang Muka',
                    ));
                }
                foreach ($pakai as $item) {
                    $bayar = PembayaranpelayananT::model()->findByPk($item->pembayaranpelayanan_id);
                    $tandabukti = TandabuktibayarT::model()->findByAttributes(array(
                        'pembayaranpelayanan_id' => $bayar->pembayaranpelayanan_id,
                    ), array(
                        'condition' => 'closingkasir_id is not null',
                    ));
                    if (!empty($tandabukti)) {
                        return "SUDAH DI CLOSING";
                    }
                }
                return CHtml::Link(
                    "<i class=\"icon-form-silang\"></i>",
                    '#',
                    //Yii::app()->controller->createUrl("pembatalanUangMuka/index",array("idBayarUangMuka"=>$data->bayaruangmuka_id,"frame"=>true)),
                    array(
                        "onclick" => "confirmBatal(" . $data->bayaruangmuka_id . "); return false;",
                        "rel" => "tooltip",
                        "title" => "Klik untuk membatalkan uang muka",
                    )
                );
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px')
        ),
        array(
            'header' => 'Pengembalian',
            'type' => 'raw',
            'value' => function ($data) {
                if (!empty($data->pembatalanuangmuka_id)) {
                    $batal = PembatalanuangmukaT::model()->findByPk($data->pembatalanuangmuka_id);
                    if ($batal->is_pengembalian) {
                        $bkk = TandabuktikeluarT::model()->findByAttributes(array(
                            'pembatalanuangmuka_id' => $data->pembatalanuangmuka_id
                        ));
                        return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($bkk->tglkaskeluar) . "/<br/>" . $bkk->nokaskeluar . '</u>', $this->createUrl('print/pembatalanUangMuka', array(
                            'idTandaBukti' => $bkk->tandabuktikeluar_id,
                        )), array(
                            'target' => 'iframeDetailBatal',
                            'onclick' => '$("#dialogDetailBatal").dialog("open");',
                            'data-toggle' => 'tooltip',
                            'title' => 'Klik untuk melihat detail Pembatalan Uang Muka',
                        ));
                    }
                    return "<a data-toggle = 'tooltip' title = '".$batal->keterangan_batal."'> SUDAH DIBATALKAN OLEH ".$batal->login->pegawai->namaLengkap."</a>";
                }

                $pakai = PemakaianuangmukaT::model()->findAllByAttributes(array(
                    'bayaruangmuka_id' => $data->bayaruangmuka_id,
                ));

                $sisa = $data->jumlahuangmuka - $data->pemakaianuangmuka;

                if ($sisa > 0) {
                    if ($data->jumlahuangmuka == $data->uangmukadipakai) {
                        return "SUDAH DIPAKAI";
                    }

                    foreach ($pakai as $item) {
                        $bayar = PembayaranpelayananT::model()->findByPk($item->pembayaranpelayanan_id);
                        $tandabukti = TandabuktibayarT::model()->findByAttributes(array(
                            'pembayaranpelayanan_id' => $bayar->pembayaranpelayanan_id,
                        ), array(
                            'condition' => 'closingkasir_id is not null',
                        ));

                        if (!empty($tandabukti)) {
                            return "SUDAH DI CLOSING";
                        }
                    }

                    return CHtml::Link(
                        "<i class=\"icon-form-bayar\"></i>",
                        '#',
                        //Yii::app()->controller->createUrl("pembatalanUangMuka/index",array("idBayarUangMuka"=>$data->bayaruangmuka_id,"frame"=>true)),
                        array(
                            "onclick" => "confirmPengembalian(" . $data->bayaruangmuka_id . ");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengembalikan uang muka",
                        )
                    );
                }

                return "-";
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); sorotTabel();}',
));
?>