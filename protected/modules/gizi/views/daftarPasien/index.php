<?php
$this->breadcrumbs = array(
    'Informasi Daftar Pasien Gizi',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Daftar Pasien Gizi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('cari cari', "
        $('#daftarPasien-form').submit(function(){
                $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        if (!empty($_GET['succes'])) { ?>
            <div class="alert alert-block alert-success">
                <a class="close" data-dismiss="alert">×</a>
                <?php if ($_GET['succes'] == 2) { ?> Pemeriksaan Pasien berhasil di batalkan<?php }
                                                                                        if ($_GET['succes'] == 1) { ?>Pasein Berhasil Di Rujuk<?php } ?>
            </div>
        <?php } ?>

        <?php
        //CHtml::link($text, $url, $htmlOptions)
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'daftarPasien-form',
            'type' => 'horizontal',
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
                            <label class="control-label">Tgl. Masuk Penunjang</label>
                            <div class="controls">
                                <?php
                                //$modPasienMasukPenunjang->tgl_awal = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_awal);
                                //$modPasienMasukPenunjang->tgl_akhir = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_akhir);
                                $modPasienMasukPenunjang->tgl_awal = date('d M Y',strtotime($modPasienMasukPenunjang->tgl_awal));
                                $modPasienMasukPenunjang->tgl_akhir = date('d M Y',strtotime($modPasienMasukPenunjang->tgl_akhir));
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span2',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label(' Sampai Dengan', ' s/d', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
                                    //                                         'maxdate'=>'d',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate'     => 'd'
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span2',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'autofocus' => true, 'placeholder' => 'No. Rekam Medik')); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_pendaftaran', array('class' => 'span4 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'No. Pendaftaran')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array('class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
                        <?php
                        $mods = LookupM::getItems('statusperiksa');
                        unset($mods['BATAL PERIKSA']);
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'statusperiksa', $mods, array('class' => 'span4', 'empty' => '-- Pilih --',)); ?>
                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'carabayar_id', CHtml::listData($modPasienMasukPenunjang->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                'update' => '#' . CHtml::activeId($modPasienMasukPenunjang, 'penjamin_id') . ''  //selector to update
                            ),
                        )); ?>
                        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'penjamin_id', CHtml::listData($modPasienMasukPenunjang->getPenjaminItems($modPasienMasukPenunjang->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                    );
                    ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiDaftarPasien', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Pasien Gizi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->widget('bootstrap.widgets.BootAlert');
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'daftarpasien-v-grid',
                        'dataProvider' => $modPasienMasukPenunjang->searchKonsulGizi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-condensed',
                        'columns' => array(
                            /* array(
                        'name'=>'no_urutperiksa',
                        'type'=>'raw',
                        'header'=>'No. Antrian/<br>Panggil Antrian',
                        'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br> / ".((($data->panggilantrian) || "'.date('Y-m-d',strtotime($modPasienMasukPenunjang->tglmasukpenunjang)).'" != "'.date('Y-m-d').'") ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
                    ),*/
                            array(
                                'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                                'type' => 'raw',
                                'value' => '$data->tgl_pendaftaran." / <br>".$data->no_pendaftaran'
                            ),
                            'tglmasukpenunjang',
                            'no_rekam_medik',
                            array(
                                'header' => 'Nama Pasien',
                                'type' => 'raw',
                                'value' => '$data->namadepan." ".$data->nama_pasien',
                            ),
                            'alamat_pasien',
                            array(
                                'header' => 'Jenis Penjamin <br> / Penjamin',
                                'type' => 'raw',
                                'value' => '$data->caraBayarPenjamin',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'Dokter',
                                'type' => 'raw',
                                'value' => function ($data) use (&$admisi) {
                                    // if (!empty($admisi)) return $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama;
                                    return $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama;
                                },
                                'htmlOptions' => array(
                                    'style' => 'text-align:center;',
                                    'class' => 'rajal'
                                )
                            ),
                            'jeniskasuspenyakit_nama',
                            array(
                                'header' => 'Status Periksa',
                                'type' => 'raw',
                                'value' => '$data->statusperiksa',
                            ),
                            'ruanganasal_nama',
                            array(
                                'header' => 'Konsultasi Gizi',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\"icon-form-konsulgizi\"></i>",Yii::app()->controller->createUrl("/gizi/pemeriksaanGizi",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienadmisi_id"=>$data->pasienadmisi_id, "pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)), array("rel"=>"tooltip","title"=>"Klik untuk Konsultasi Gizi","data-placement"=>"left"))', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
       
        <?php
        // Dialog untuk Lihat Hasil =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogLihatHasil',
            'options' => array(
                'title' => 'Pemeriksaan Gizi',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 950,
                'height' => 450,
                'resizable' => true,
            ),
        ));
        ?>
        <iframe src="" name="iframeLihatHasil" width="100%" height="500">
        </iframe>
        <?php
        $this->endWidget();
        //========= end Lihat Hasil =============================
        ?>
    </div>
</div>
<iframe id="suarapanggilan" src="#" style="display: none;"></iframe>
<script type="text/javascript">
    function batalperiksa(idpendaftaran) {
        myConfirm('anda yakin akan membatalkan pemeriksaan gizi pasien ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('BatalPeriksaPasienLuar') ?>', {
                            idpendaftaran: idpendaftaran
                        },
                        function(data) {
                            if (data.status == 'success') {
                                window.location = "<?php echo $this->createUrl('index&succes=2') ?>";
                            }
                        }, 'json'
                    );
                }
            });
        //    if(alasan==''){
        //        myAlert('Anda Belum Mengisi Alasan Pembatalan');
        //    }else{
        //        $.post('<?php //echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap');
                            ?>', $('#formAlasan').serialize(), function(data){
        ////            if(data.error != '')
        ////                myAlert(data.error);
        ////            $('#'+data.cssError).addClass('error');
        //            if(data.status=='success'){
        //                batal();
        //                myAlert('Data Berhasil Disimpan');
        //                location.reload();
        //            }else{
        //                myAlert(data.status);
        //            }
        //        }, 'json');
        //   }     
    }

    function ambilAntrianTerakhir() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
            dataType: "json",
            success: function(data) {
                if (data.pesan == "") {
                    panggilAntrian(data.pasienmasukpenunjang_id);
                    setSuaraPanggilanSingle(data.ruangan_singkatan, data.no_urutperiksa, data.ruangan_id);
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * memanggil antrian ke poliklinik
     * @param {type} pendaftaran_id
     * @returns {undefined} */
    function panggilAntrian(pasienmasukpenunjang_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('Panggil'); ?>',
            data: {
                pasienmasukpenunjang_id: pasienmasukpenunjang_id
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan !== "") {
                    myAlert(data.pesan);
                }
                if (data.smspasien == 0) {
                    var params = [];
                    params = {
                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                        modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                        judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                        isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                    }; // 16 
                    insert_notifikasi(params);
                }
                <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                    socket.emit('send', {
                        conversationID: 'antrian',
                        panggil: 1,
                        antrian_id: pasienmasukpenunjang_id
                    });
                <?php } ?>
                $.fn.yiiGridView.update('daftarpasien-v-grid');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * suara panggilan per ruangan
     * @param {type} param
     * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
     */
    function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id) {
        $("#suarapanggilan").attr("src", "<?php echo $this->createUrl('/antrian/tampilAntrianKePenunjang/suaraPanggilanSingle'); ?>&kodeantrian=" + kodeantrian + "&noantrian=" + noantrian + "&ruangan_id=" + ruangan_id);
    }
</script>