<?php
$this->breadcrumbs = array(
    'Informasi Data Rujukan Internal',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#formCari').submit(function(){
	$.fn.yiiGridView.update('PPInformasiPasienPenunjang-v', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Data Rujukan Internal</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => 'formCari',
                'type' => 'horizontal',
                'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            )); ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                        <i class="entypo-calendar"></i>
                                        <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow($model, 'asalrujukan_id', CHtml::listData(
                                AsalrujukanM::model()->findAll(array(
                                    'condition' => 'asalrujukan_aktif = true',
                                    'order' => 'asalrujukan_nama'
                                )),
                                'asalrujukan_id',
                                'asalrujukan_nama'
                            ), array(
                                'empty' => '-- Pilih --',
                                'class' => 'span4',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => get_class($model))),
                                    'update' => '#' . CHtml::activeId($model, 'rujukandari_id'),
                                )
                            )); ?>
                            <?php echo $form->dropDownListRow($model, 'rujukandari_id', array(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6)); ?>
                            <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                            <?php
                            $carabayar = CarabayarM::model()->findAll(array(
                                'condition' => 'carabayar_aktif = true',
                                'order' => 'carabayar_nama',
                            ));
                            foreach ($carabayar as $idx => $item) {
                                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                    'carabayar_id' => $item->carabayar_id,
                                    'penjamin_aktif' => true,
                                ), array('order' => 'penjamin_nama ASC'));
                                if (empty($penjamins)) unset($carabayar[$idx]);
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
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --')); ?>
                            <?php echo $form->dropDownListRow($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                'instalasi_id' => array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI),
                                'ruangan_aktif' => true,
                            ), array(
                                'order' => 'ruangan_nama asc'
                            )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')); ?>
                            <?php //echo $form->dropDownListRow($model,'status_konfirmasi',CustomFunction::getStatusKonfirmasi(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); 
                            ?>
                            <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                'ruangan_id' => array(53, 56, 47, 57),
                                'ruangan_aktif' => true,
                            ), array(
                                'order' => 'ruangan_nama asc'
                            )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')); ?>
                            <?php //echo $form->dropDownListRow($model,'status_konfirmasi',CustomFunction::getStatusKonfirmasi(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); 
                            ?>
                            <?php
                            $pegawai = CHtml::listData(DokterV::model()->findAllByAttributes(array(
                                'instalasi_id' => array(5, 6, 8, 7, 10),
                                'pegawai_aktif' => true,
                            ), array('order' => 'nama_pegawai, gelardepan ASC')), 'pegawai_id', 'namaLengkap');
                            echo $form->dropDownListRow($model, 'pegawai_id', $pegawai, array(
                                'empty' => '-- Pilih --',
                            ));
                            ?>
                            <?php echo $form->dropDownListRow($model, 'statusperiksa_pendaftaran', Params::statusPeriksa(), array('empty' => '-- Pilih --')); ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Petugas Loket', 'create_loginpemakai_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $cp = new CDbCriteria;
                                    $cp->join = 'join pegawairuangan_v p on p.pegawai_id = t.pegawai_id';
                                    $cp->compare('p.ruangan_id', Yii::app()->user->getState('ruangan_id'));
                                    $cp->order = 't.nama_pemakai';
                                    $p = LoginpemakaiK::model()->findAll($cp);
                                    $arr = array();
                                    foreach ($p as $item) {
                                        if (!empty($item->pegawai_id)) {
                                            $arr[$item->loginpemakai_id] = $item->pegawai->nama_pegawai;
                                        }
                                    }
                                    // var_dump($arr); die;
                                    echo $form->dropDownList($model, 'create_loginpemakai_id', $arr, array('empty' => '-- Pilih --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                        );
                        ?>
                        <?php echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                            )
                        ); ?>
                        <?php
                        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienPenunjang', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Data Rujukan Internal</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'PPInformasiPasienPenunjang-v',
                    'dataProvider' => $model->searchPasienPenunjang(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                            'name' => 'pendaftaran.tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)."/<br>".$data->pendaftaran->no_pendaftaran',
                        ),
                        array(
                            'header' => 'Tgl. Masuk Penunjang/<br>No. Masuk Penunjang',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."/<br>".$data->no_masukpenunjang',
                        ),
                        array(
                            'header' => 'No. Rekam Medik<br>',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    return $data->pasien->no_rekam_medik;
                                } else {
                                    return CHtml::link(
                                        "<i class='icon-form-ubah'></i> " . $data->pasien->no_rekam_medik,
                                        Yii::app()->createUrl("/pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasienAjax", array("pendaftaran_id" => $data->pendaftaran_id)),
                                        array(
                                            "class" => "",
                                            "target" => "frameEditPasien",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk Mengubah Data Pasien",
                                            "onclick" => "$('#editPasien').dialog('open');return true;"
                                        )
                                    )
                                        . "<br>" .
                                        CHtml::link("<i class=icon-form-print></i> Status", "javascript:printStatus(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print status pasien"))
                                        . "<br>" .
                                        CHtml::link("<i class=icon-form-print></i> Struk", "javascript:printStruk(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print struk"));
                                }
                            },
                            'htmlOptions' => array('style' => 'width:120px')
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->pasien->namadepan.$data->pasien->nama_pasien',
                        ),
                        array(
                            'header' => 'Jenis Kasus Penyakit',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit->jeniskasuspenyakit_nama',
                            'htmlOptions' => array('style' => 'text-align: left; width: 75px;')
                        ),
                        array(
                            'header' => 'Ruangan Asal',
                            'type' => 'raw',
                            'value' => '$data->ruanganasal->ruangan_nama',
                        ),
                        array(
                            'header' => 'Ruangan Penunjang',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header' => 'Dokter',
                            'type' => 'raw',
                            'value' => 'empty($data->pegawai) ? "-" : $data->pegawai->namaLengkap',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                $carabayarpenjamin = $p->carabayar->carabayar_nama . "/ " . $p->penjamin->penjamin_nama;
                                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    return $carabayarpenjamin;
                                } else {
                                    return ((!empty($p->carabayar) && ($data->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA)) ?
                                        CHtml::Link(
                                            "<i class=icon-form-ubah></i>" . $carabayarpenjamin,
                                            Yii::app()->createUrl("pendaftaranPenjadwalan/informasiPasienPenunjang/ubahCaraBayar", array("id" => $data->pendaftaran_id, "frame" => true)),
                                            array(
                                                "class" => "",
                                                "onclick" => "$('#carabayardialog').dialog('open');loadFormCaraBayar(this);return false;",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk Mengubah Jenis Penjamin & Penjamin pasien",
                                            )
                                        ) : $carabayarpenjamin);
                                }
                            },
                            //'value'=>'$data->pendaftaran->carabayar->carabayar_nama."/<br>".$data->pendaftaran->penjamin->penjamin_nama',
                        ),
                        array(
                            'header' => 'Perujuk',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $p = PasienkirimkeunitlainT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
                                //$p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                //$r = RujukanT::model()->findByPk($p->rujukan_id);
                                return empty($p) ? "-" : $p->pegawai->namaLengkap;
                            }
                        ),
                        array(
                            'header' => 'Status Periksa Hasil',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
                                    $lab = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
                                    if (!empty($lab)) {
                                        if ($lab->statusperiksahasil == Params::STATUSPERIKSAHASIL_BELUM) {
                                            return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_BELUM);
                                        } elseif ($lab->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) {
                                            return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_SEDANG);
                                        } else {
                                            return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_SUDAH);
                                        }
                                    }
                                } elseif ($data->ruangan_id == Params::RUANGAN_ID_RAD) {
                                    $criRad = new CDbCriteria();
                                    $criRad->addCondition(" pendaftaran_id = '" . $data->pendaftaran_id . "' AND pasienmasukpenunjang_id = '" . $data->pasienmasukpenunjang_id . "' ");
                                    $criRad->addCondition(" (statusperiksahasil = '" . Params::STATUSPERIKSAHASIL_BELUM . "') OR (statusperiksahasil IS NULL)  ");
                                    $rad = HasilpemeriksaanradT::model()->findAll($criRad);
                                    if (count((array)$rad) > 0) {
                                        return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_BELUM);
                                    } else {
                                        return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_SUDAH);
                                    }
                                } elseif ($data->ruangan_id == Params::RUANGAN_ID_BEDAH) {
                                    $ren = RencanaoperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
                                    if (!empty($ren)) {
                                        if ($ren->statusoperasi == Params::STATUSPERIKSABEDAH_MULAI) {
                                            return Params::getWrStatusBedah(Params::STATUSPERIKSABEDAH_MULAI);
                                        } elseif ($ren->statusoperasi == Params::STATUSPERIKSABEDAH_SELESAI) {
                                            return Params::getWrStatusBedah(Params::STATUSPERIKSABEDAH_SELESAI);
                                        }
                                        if ($ren->statusoperasi == Params::STATUSPERIKSABEDAH_RENCANA) {
                                            return Params::getWrStatusBedah(Params::STATUSPERIKSABEDAH_RENCANA);
                                        }
                                    }
                                } elseif ($data->ruangan_id == Params::RUANGAN_ID_FISIOTERAPI) {
                                    $ren = HasilpemeriksaanrmT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id), array(
                                        'condition' => "(trim(hasilpemeriksaanrm) <> '' or trim(keteranganhasilrm) <> '' or trim(evaluasi) <> '')"
                                    ));
                                    if (!empty($ren)) {
                                        return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_SUDAH);
                                    } else {
                                        return Params::getWrStatusHasil(Params::STATUSPERIKSAHASIL_BELUM);
                                    }
                                }
                                //return Params::getWrStatusPeriksa($data->pendaftaran->statusperiksa);
                            },
                        ),
                        /*
                        array(
                            'header'=>'Kelas Pelayanan',
                            'type'=>'raw',
                            'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                        ), */
                        array(
                            'header' => 'Keterangan Pendaftaran',
                            'name' => 'pendaftaran.keterangan_pendaftaran',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $str = "<div style='width:100px;'>" . CHtml::link("<i class=icon-form-ubah></i>" . $data->pendaftaran->keterangan_pendaftaran, " ", array("onclick" => "ubahKeterangan('$data->pendaftaran_id');$('#editKeterangan').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Keterangan Pendaftaran")) . "</div>";
                                $str .= "<br/>" . CHtml::link('<i class="icon-form-detail"></i><br/>Riwayat Vaksinasi/<br/>Imunisasi', Yii::app()->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                )), array(
                                    'target' => 'frameRiwayatVaksinasi',
                                    'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
                                ));
                                return $str;
                            },
                            'htmlOptions' => array('style' => 'width: 60px; text-align: center;')
                        ),
                        array(
                            'header' => 'Petugas Loket',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                $lp = LoginpemakaiK::model()->findByPk($p->create_loginpemakai_id);
                                return empty($lp->pegawai_id) ? "-" : $lp->pegawai->namaLengkap;
                            }
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php $this->endWidget();
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRI', array('pendaftaran_id' => ''));
        $urlPrintStatusPasien = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranPenunjang/printStatus', array('pendaftaran_id' => ''));
        $urlPrintKarcisStruk = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranPenunjang/printKarcis', array('pendaftaran_id' => ''));
        ?>
        <?php
        //========================================= Jenis Penjamin dialog =============================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'carabayardialog',
            'options' => array(
                'title' => 'Ganti Jenis Penjamin dan Penjamin <span id="titleNamaPasienCaraBayar"></span>',
                'autoOpen' => false,
                'zIndex' => 1002,
                'minWidth' => 320,
                'height' => 480,
                'modal' => true,
                'resizable' => false,
                'close' => 'js:function() {$.fn.yiiGridView.update("PPInformasiPasienPenunjang-v")}'
                //'hide'=>explode,
            ),
        ));
        echo '<iframe id="iframeUbahCaraBayar" name="iframeUbahCaraBayar" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget('zii.widgets.jui.CJuiDialog');
        //========================================================= end cara bayar dialog =========
        //=============================== Ganti Data Pasien Dialog =======================================
        $this->beginWidget(
            'zii.widgets.jui.CJuiDialog',
            array(
                'id' => 'editPasien',
                'options' => array(
                    'title' => 'Ganti Data Pasien',
                    'autoOpen' => false,
                    'zIndex' => 1002,
                    'width' => 1000,
                    'height' => 560,
                    'resizable' => true,
                ),
            )
        );
        echo CHtml::hiddenField('temp_norekammedik', '', array('readonly' => true));
        echo '<iframe name="frameEditPasien" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>
        <?php
        //=============================== Dialog Riwayat Vaksinasi =======================================
        $this->beginWidget(
            'zii.widgets.jui.CJuiDialog',
            array(
                'id' => 'dialogRiwayatVaksinasi',
                'options' => array(
                    'title' => 'Riwayat Vaksinasi/Imunisasi',
                    'autoOpen' => false,
                    'zIndex' => 1002,
                    'width' => 1000,
                    'height' => 450,
                    'resizable' => true,
                    'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                data: $('#formCari').serialize()
                            }); }",
                ),
            )
        );
        echo '<iframe name="frameRiwayatVaksinasi" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>
        <?php
        //=============================== Ganti Data Keterangan pendaftaran =======================================
        $this->beginWidget(
            'zii.widgets.jui.CJuiDialog',
            array(
                'id' => 'editKeterangan',
                'options' => array(
                    'title' => 'Ubah keterangan Pendaftaran',
                    'autoOpen' => false,
                    'minWidth' => 500,
                    'modal' => true,
                ),
            )
        );
        echo CHtml::hiddenField('temp_idPendaftaranKet', '', array('readonly' => true));
        echo '<div class="divForFormEditKeterangan"></div>';
        $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>
    </div>
    <script type="text/javascript">
        function printStatus(pendaftaran_id) {
            window.open('<?php echo $urlPrintStatusPasien; ?>' + pendaftaran_id, 'printwin', 'left=100,top=100,width=700,height=600');
        }

        function loadFormCaraBayar(obj) {
            var url = $(obj).attr('href');
            $('#iframeUbahCaraBayar').attr('src', url);
        }

        function ubahKeterangan(pendaftaran_id) {
            $('#temp_idPendaftaranKet').val(pendaftaran_id);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('ubahKeteranganPendaftaran') ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#editKeterangan div.divForFormEditKeterangan').html(data.div);
                        $('#editKeterangan div.divForFormEditKeterangan form').submit(ubahKeterangan);
                    } else {
                        $('#editKeterangan div.divForFormEditKeterangan').html(data.div);
                        $.fn.yiiGridView.update('PPInformasiPasienPenunjang-v', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#editKeterangan').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }

        function printStruk(pendaftaran_id) {
            window.open('<?php echo $urlPrintKarcisStruk; ?>' + pendaftaran_id, 'printwin', 'left=100,top=100,width=400,height=700');
        }

        $(document).ready(function() {
            var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

            jQuery(penj).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '240px',
                enableCaseInsensitiveFiltering: true
            }).hide();
        });
    </script>
</div>