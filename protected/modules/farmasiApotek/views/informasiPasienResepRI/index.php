<?php
$this->breadcrumbs = array(
    'Informasi Pasien Resep',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Resep Rawat Inap</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Resep Rawat Inap</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
                <?php
                $this->widget('bootstrap.widgets.BootAlert');

                Yii::app()->clientScript->registerScript('cariPasien', "
                        $('#caripasien-form button[type=\'reset\']').click(function(){
                            $('#caripasien-form')[0].reset();
                            $.fn.yiiGridView.update('pencarianpasien-grid', {
                                data: $('#caripasien-form').serialize()
                            });
                            return false;
                        });
                        ");
                ?>
                <div class='block-tabel'>
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'pencarianpasien-grid',
                        'dataProvider' => $model->searchInformasiPasienResepRI(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'No. Antrian',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $modAntrian = AntrianfarmasiT::model()->findByAttributes(array('reseptur_id' => $data->reseptur_id), array(
                                        'order' => 'antrianfarmasi_id desc'
                                    ));
                                    if (!empty($modAntrian->antrianfarmasi_id)) {

                                        $modelLoket = ModelantrianM::model()->findByPk(array(
                                            $modAntrian->modelantrian_id
                                        ));

                                        $str = $modAntrian->racikan->racikan_singkatan . "-" . $modAntrian->noantrian . '<br>';

                                        if (!empty($modelLoket)) {
                                            $str = $modelLoket->modelantrian_kode . $str;
                                        }

                                        if ($modAntrian->panggilantrian && $modAntrian->jumlah_panggil == 30) {
                                            return $str . "Sudah Dipanggil";
                                        }

                                        return $str . "<br>" . CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => '<i class="icon-volume-up icon-white"></i>')), array(
                                                    "class" => "btn btn-primary",
                                                    "onclick" => 'panggilAntrian("' . $modAntrian->antrianfarmasi_id . '")', "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini"
                                        ));
                                    } else {
                                        return CHtml::link('<i class="entypo-megaphone"></i><i class="icon-plus icon-white"></i>', $this->createUrl('ambilKarcisFarmasiApotek/index', array(
                                                            'reseptur_id' => $data->reseptur_id,
                                                        )), array(
                                                    'class' => 'btn btn-success',
                                                    'rel' => 'tooltip',
                                                    'title' => 'Klik untuk Tiket Antrian Farmasi'
                                        ));
                                    }
                                },
                                'htmlOptions' => array('style' => 'text-align: center;'),
                            ),
                            array(
                                'header' => 'Tgl. Resep/<br>No. Resep',
                                'name' => 'tglreseptur."/<br>".$data->noreseptur',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglreseptur)."<br>".$data->noreseptur'
                            ),
                            array(
                                'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                                'type' => 'raw',
                                'name' => 'tgl_pendaftaran',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                            ),
                            //'no_pendaftaran',
                            array(
                                'header' => 'Nama Pasien/ No. Rekam Medik /Jenis Kelamin/<br>Umur ',
                                'name' => 'nama_pasien',
                                'value' => function ($data) {
                                    echo $data->namadepan . $data->nama_pasien;
                                    echo "<br>";
                                    echo $data->no_rekam_medik;
                                    echo "<br>";
                                    echo $data->jeniskelamin . "/<br>" . $data->umur;
                                },
                            ),
                            'jeniskasuspenyakit_nama',
                            //'nama_bin',
                            array(
                                'header' => 'Jenis Penjamin/<br>Penjamin',
                                'type' => 'raw',
                                'value' => '$data->carabayar_nama."/<br>".$data->penjamin_nama',
                            ),
                            array(
                                'header' => 'Dokter/<br>Ruangan',
                                'name' => 'pegawai_nama',
                                'type' => 'raw',
                                'value' => '$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama."/<br>".$data->ruanganreseptur_nama',
                            ),
                            array(
                                'header' => 'Status Periksa',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $pd = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                    return $pd->statusperiksa;
                                },
                            ),
                            array(
                                'header' => 'Diagnosa',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return Yii::app()->controller->renderPartial('_diagnosa', array('pendaftaran_id' => $data->pendaftaran_id), true);
                                }
                            ),
                            array(
                                'header' => 'Alergi Obat',
                                'type' => 'raw',
                                'value' => '$data->AlergiObat',
                                //'htmlOptions'=>array('style'=>'text-align: left; width:120px'),
                                'headerHtmlOptions' => array('style' => 'width:120px'),
                            ),
                            array(
                                'header' => 'Riwayat Obat Pasien',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return CHtml::Link(
                                            "<i class='icon-form-verifikasi'></i>",
                                            Yii::app()->controller->createUrl("riwayat", array("id" => $data->reseptur_id, 'pendaftaran_id' => $data->pendaftaran_id)),
                                            array(
                                                "class" => "",
                                                "target" => "iframeRiwayatObat",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk menjual resep",
                                                "onclick" => '$("#dialogRiwayatObat").dialog("open");',
                                            )
                                    );
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width:120px'),
                            ),
                            array(
                                'header' => 'Reseptur',
                                'type' => 'raw',
                                'value' => function ($data) use (&$ada_racikan, &$ada_nonracikan) {
                                    $link = array();

                                    $ada_racikan = false;
                                    $ada_nonracikan = false;

                                    $racikan = ResepturdetailT::model()->findByAttributes(array(
                                        'reseptur_id' => $data->reseptur_id,
                                        'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                                    ));
                                    $nonRacikan = ResepturdetailT::model()->findByAttributes(array(
                                        'reseptur_id' => $data->reseptur_id,
                                        'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                                    ));

                                    if (!empty($racikan)) {
                                        $ada_racikan = true;
                                        $link[] = CHtml::Link(
                                                        '<i class="icon-form-reseptur"></i><br>Racikan',
                                                        Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter", array("id" => $data->reseptur_id, "racikan_id" => Params::RACIKAN_ID_RACIKAN, "frame" => 1)),
                                                        array(
                                                            "class" => "",
                                                            "target" => "iframeReseptur",
                                                            "onclick" => "$(\"#dialogReseptur\").dialog(\"open\");",
                                                            "rel" => "tooltip",
                                                            "title" => "Klik untuk print reseptur dokter (Racikan)",
                                                        )
                                        );
                                    }

                                    if (!empty($nonRacikan)) {
                                        $ada_nonracikan = true;
                                        $link[] = CHtml::Link(
                                                        '<i class="icon-form-reseptur"></i><br>Non Racikan',
                                                        Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter", array("id" => $data->reseptur_id, "racikan_id" => Params::RACIKAN_ID_NONRACIKAN, "frame" => 1)),
                                                        array(
                                                            "class" => "",
                                                            "target" => "iframeReseptur",
                                                            "onclick" => "$(\"#dialogReseptur\").dialog(\"open\");",
                                                            "rel" => "tooltip",
                                                            "title" => "Klik untuk print reseptur dokter (Non Racikan)",
                                                        )
                                        );
                                    }

                                    $modReseptur = ResepturT::model()->findByPk($data->reseptur_id);

                                    if($modReseptur->isterapipulang == true)
                                        $link[] = "Terapi Pulang";

                                    return implode("<br>", $link);
                                },
                                'htmlOptions' => array(
                                    "nowrap" => "",
                                    'style' => 'text-align: center;',
                                )
                            ),
                            array(
                                'header' => 'Penjualan Resep',
                                'type' => 'raw',
                                'value' => function ($data) {

                                    if ($data->isclose) {
                                        return CHtml::Link("<i class='icon-form-jualresep'></i>",
                                                        'javascript:;',
                                                        array(
                                                            "class" => "nohover",
                                                            "rel" => "tooltip",
                                                            "title" => "Klik untuk menjual resep",
                                                            "disabled" => true,
                                                            'style' => 'opacity:0.4'
                                                        )
                                        );
                                    }

                                    return CHtml::Link(
                                            "<i class='icon-form-jualresep'></i>",
                                            Yii::app()->controller->createUrl("PenjualanDariReseptur/Index", array("reseptur_id" => $data->reseptur_id, "dilayani" => true)),
                                            array(
                                                "class" => "",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk menjual resep",
                                            )
                                    );
                                },
                                'htmlOptions' => array('style' => 'text-align: center;'),
                            ),
                            [
                                'header' => 'Close Resep',
                                'type' => 'raw',
                                'value' => function ($row) {
                                    if ($row->isclose) {
                                        return 'Resep Terpenuhi';
                                    } else {
                                        return CHtml::Link("<i class='fa fa-check'></i>",
                                                        'javascript:;',
                                                        array(
                                                            "class" => "",
                                                            "rel" => "tooltip",
                                                            "title" => "Klik untuk menjual resep",
                                                            'onclick' => 'closeResep(' . $row->reseptur_id . ')'
                                                        )
                                        );
                                    }
                                },
                                'htmlOptions' => ['style' => 'text-align:center;']
                            ]
//                            array(
//                                'header' => 'Etiket',
//                                'type' => 'raw',
//                                'value' => function ($data) use (&$is_dijual, &$ada_racikan, &$ada_nonracikan) {
//                                    if (!$is_dijual) {
//                                        return "-";
//                                    }
//
//                                    $str = array();
//
//                                    if ($ada_racikan) {
//                                        $str[] = CHtml::link('<i class="icon-form-print"></i><br>Racikan', '#', array(
//                                            'onclick' => 'printEtiket(' . $data->penjualanresep_id . ', true); return false;'
//                                        ));
//                                    }
//                                    if ($ada_nonracikan) {
//                                        $str[] = CHtml::link('<i class="icon-form-print"></i><br>Non Racikan', '#', array(
//                                            'onclick' => 'printEtiket(' . $data->penjualanresep_id . ', false); return false;'
//                                        ));
//                                    }
//
//                                    return implode("<br>", $str);
//                                }
//                            ),
//                            array(
//                                'header' => 'Petugas Farmasi',
//                                'type' => 'raw',
//                                'value' => function ($data) {
//                                    $pd = PendaftaranT::model()->findByPk($data->pendaftaran_id);
//                                    $statusperiksa = $pd->statusperiksa;
//
//                                    $oabayar = false;
//                                    if (!empty($data->pendaftaran_id)) {
//                                        $cek = ObatalkespasienT::model()->find(" pendaftaran_id = '" . $data->pendaftaran_id . "' AND oasudahbayar_id IS NOT NULL ");
//
//                                        if (!empty($cek)) {
//                                            $oabayar = true;
//                                        }
//                                    }
//
//                                    $lanjut_transaksi = false;
//                                    if ($data->instalasireseptur_id == Params::INSTALASI_ID_RD || $data->instalasireseptur_id == Params::INSTALASI_ID_RJ) {
//                                        if (($statusperiksa == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) && ($oabayar == true)) {
//                                            $lanjut_transaksi = true;
//                                        } elseif (($statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) && ($oabayar == true)) {
//                                            $lanjut_transaksi = true;
//                                        } else {
//                                            if (($statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG)) {
//                                                $lanjut_transaksi = true;
//                                            } elseif (($statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO)) {
//                                                $lanjut_transaksi = true;
//                                            } else {
//                                                if ($oabayar == true) {
//                                                    $lanjut_transaksi = true;
//                                                }
//                                            }
//                                        }
//                                    }
//
//                                    // if ($lanjut_transaksi) return "-";
//
//                                    if (empty($data->penjualanresep_id)) return "-";
//                                    $jual = PenjualanresepT::model()->findByPk($data->penjualanresep_id);
//                                    $login = LoginpemakaiK::model()->findByPk($jual->create_loginpemakai_id);
//
//                                    if (empty($login->pegawai_id)) return "-";
//                                    $peg = PegawaiM::model()->findByPk($login->pegawai_id);
//                                    return $peg->namaLengkap;
//
//                                    return "-";
//                                },
//                            ),
//                            /*array(
//                                            'header'=>'Copy Resep',
//                                            'type'=>'raw',
//                                            'value'=>'(!$data->penjualanresep_id) ? "<p style=\"margin: 0; text-align: center;\">-</p>" :
//                                                CHtml::Link("<i class=\"icon-form-copy\"></i>",Yii::app()->controller->createUrl("PenjualanDariReseptur/CopyResep",array("penjualanresep_id"=>$data->penjualanresep_id,"pasien_id"=>$data->pasien_id)),
//                                                array("class"=>"",
//                                                    "target"=>"iframeCopyResep",
//                                                    "onclick"=>"$(\"#dialogCopyResep\").dialog(\"open\");",
//                                                    "rel"=>"tooltip",
//                                                    "title"=>"Klik untuk Copy Resep ",
//                                                ))',
//                                            'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
//                                        ),*/
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    $this->widget('bootstrap.widgets.BootAlert');
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'caripasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#FAResepturT_noresep',
                    'method' => 'post',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <label class='control-label'>
                                <?php echo CHtml::activeCheckBox($model, 'is_tgl', array('onClick' => 'cekTanggal()', 'rel' => 'tooltip', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal resep')); ?>
                                Tgl. Resep</label>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'noreseptur', array('placeholder' => 'No. Resep', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $carabayar = CarabayarM::model()->findAll(array(
                            'condition' => 'carabayar_aktif = true',
                            'order' => 'carabayar_nama ASC',
                        ));
                        foreach ($carabayar as $idx => $item) {
                            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                'carabayar_id' => $item->carabayar_id,
                                'penjamin_aktif' => true,
                            ));
                            if (empty($penjamins))
                                unset($carabayar[$idx]);
                        }
                        $penjamin = PenjaminpasienM::model()->findAll(array(
                            'condition' => 'penjamin_aktif = true',
                            'order' => 'penjamin_nama',
                        ));
                        echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                        echo $form->dropDownListRow($model, 'status_terpenuhi', LookupM::getItems('statusterpenuhifarmasi'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                        ?>

                    </div>
                    <div class="col-sm-6">
                        <?php
                        $pegawai = CHtml::listData(DokterV::model()->findAllByAttributes(array(
                                            'instalasi_id' => array(2, 3, 4),
                                                ), array(
                                            'order' => 'nama_pegawai asc',
                                        )), 'pegawai_id', 'namaLengkap');

                        echo $form->dropDownListRow($model, 'pegawai_id', $pegawai, array(
                            'empty' => '-- Pilih --', 'class' => 'span4'
                        ));
                        ?>
                        <?php
                        $instalasi = InstalasiM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                        ));
                        $ruangan = RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                            'ruangan_aktif' => true,
                                ), array(
                            'order' => 'instalasi_id, ruangan_nama',
                        ));
                        echo $form->dropDownListRow($model, 'instalasireseptur_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/GetRuangResepturDariInsReseptur', array('encode' => false, 'namaModel' => get_class($model))),
                                'success' => 'function(data){$("#' . CHtml::activeId($model, "ruanganreseptur_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($model, 'ruanganreseptur_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        ?>
                        <?php echo $form->dropDownListRow($model, 'statusperiksa', Params::statusPeriksa(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                        <?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'statusJual', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'statusJual', array(1 => 'Sudah Dijual', 2 => 'Belum Dijual'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiPasienResep', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  
    
    function printEtiket(penjualanresep_id, racikan) {
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/printEtiket'); ?>&racikan=' + (racikan ? 1 : 0) + '&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    const refreshTable = () => {
        $.fn.yiiGridView.update('pencarianpasien-grid', {
            data: $('#caripasien-form').serialize()
        });
    }

    const closeResep = (id) => {
        myConfirm("Apakah resep sudah terpenuhi semua?", "Perhatian!", function (r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('closeResep'); ?>',
                    data: {id: id},
                    dataType: "json",
                    success: function (data) {
                        if (data.sukses == 1) {
                            myAlert("Resep berhasil di close");

                            refreshTable();
                        } else {
                            myInfo("Resep gagal di close");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        })
    }
</script>

<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenjualanResep',
    'options' => array(
        'title' => 'Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframePenjualanResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>

<?php
// Dialog buat Detail Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetailPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end Detail Penjualan dialog =============================
?>

<?php
// Dialog untuk menampilkan riwayat reseptur=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReseptur',
    'options' => array(
        'title' => 'Resep Dokter',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 1100,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeReseptur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end dialog reseptur riwayat =============================
?>

<?php
// Dialog buat Copy Resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogCopyResep',
    'options' => array(
        'title' => 'Salinan Resep',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1250,
        'zIndex' => 1004,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeCopyResep" style="width: 100%; height: 98%;"></iframe>
    <?php
    $this->endWidget();
//========= end Copy Resep dialog =============================
    ?>

<?php
// Dialog buat Riwayat Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayatObat',
    'options' => array(
        'title' => 'Riwayat Obat Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'zIndex' => 1004,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRiwayatObat" width="100%" height="89%"></iframe>
<?php
$this->endWidget();
//========= end  Riwayat Obat =============================
?>