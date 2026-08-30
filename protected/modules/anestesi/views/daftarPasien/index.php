<style>
    .glyphicon{
        font-size: 21px !important;
    }
    .button-status {
        margin-right: 8px;
    }
    .badge-status {
        position: relative;
        top: 8px;
        left: 8px;
    }
    .btn-status {
        min-width: 150px;
    }
</style>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

Yii::app()->clientScript->registerScript('cariwew', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarpasien-v-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi Pasien <b>Anestesi</b></div>
    </div>
    <div class="panel-body">

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Pasien <b>Anestesi</b></div>
            </div>
            <div class="panel-body overflow-x">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarpasien-v-grid',
                    'dataProvider' => $modPasienMasukPenunjang->searchBS(),
                    'replaceUrl' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Masuk Penunjang<br/>No. Penunjang',
                            'name' => 'no_masukpenunjang',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br/>".$data->no_masukpenunjang',
                        ),
                        array(
                            'header' => 'Instalasi/<br/>Ruangan Asal',
                            'name' => 'ruanganasal_nama',
                            'type' => 'raw',
                            'value' => function($data) {
                                return $data->instalasiasal_nama . "/<br/>" . $data->ruanganasal_nama; //."/<br/>".(empty($pegawai)?"-":$pegawai->namaLengkap);
                            },
                        ),
                        array(
                            'header' => 'Tanggal Anestesi',
                            'name' => 'tglanastesi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglanastesi)'
                        ),
                        array(
                            'name' => 'tgl_pendaftaran',
                            'header' => 'No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
                            'htmlOptions' => array('width' => '100px'),
                        ),
                        array(
                            'header' => 'No. RM',
                            'name' => 'no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'value' => '$data->namadepan.$data->nama_pasien'
                        ),
                        array(
                            'header' => 'Umur',
                            'type' => 'raw',
                            'value' => '$data->umur',
                        ),
                        'alamat_pasien',
                        array(
                            'header' => 'Kasus Penyakit / <br> Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
                        ),
                        array(
                            'header' => 'Jenis Penjamin / Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
//                        array(
//                            'header' => 'Status Periksa',
//                            'type' => 'raw',
//                            'value' => '$data->getStatusAnastesi($data->statusperiksa,$data->pendaftaran_id,$data->pasienmasukpenunjang_id)'
//                        ),
                        array(
                            'header' => 'Dokter Pemeriksa',
                            'type' => 'raw', 'value' => function($data) {
                                $p = PegawaiM::model()->findByPk($data->pegawai_id);
                                return $p->namaLengkap;
                            },
                        ),
                        array(    
                            'header'=>'Evaluasi Pra Anestesi',
                            'type'=>'raw',
                            'value'=>function($data){
                                return CHtml::link("<i class='icon-medical-list'></i>", Yii::app()->createUrl("/anestesi/EvaluasiPraAnestesi/index", array('pendaftaran_id' => $data->pendaftaran_id, 'pasienkirimkeunitlain_id'=>$data->pasienkirimkeunitlain_id, 'pasienanastesi_id' => $data->pasienanastesi_id)), array('rel' => 'tooltip', 'data-original-title' => 'Klik icon ini, untuk masuk ke transaksi evaluasi pra anestesi', 'data-placement'=>'left'));
                            },
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
                        ),
                        array(
                            'header' => 'Pra Anestesi',
                            'type' => 'raw',
                            'value' => function($data) {
                                $button = CHtml::link("<i class='icon-medical-suntik'></i>", Yii::app()->createUrl("/anestesi/PraAnestesi/index", array('pendaftaran_id' => $data->pendaftaran_id)), array('rel' => 'tooltip', 'data-original-title' => 'Klik icon ini, untuk masuk ke transaksi pra anestesi', 'data-placement' => 'left'));

                                return $button;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px ')
                        ),
                        array(
                            'header' => 'Intra Anestesi',
                            'type' => 'raw',
                            'value' => function($data) {
                                $button = CHtml::link("<i class='icon-medical-suntik'></i>", Yii::app()->createUrl("/anestesi/IntraAnestesiT/index", array('pasienanastesi_id' => $data->pasienanastesi_id)), array('rel' => 'tooltip', 'data-original-title' => 'Klik icon ini, untuk masuk ke transaksi intra anestesi', 'data-placement' => 'left'));

                                return $button;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px ')
                        ),
                        array(
                            'header' => 'Monitoring Intra Anestesi/Sedasi',
                            'type' => 'raw',
                            'value' => function($data) {
                                $buton = "";
                                $buton .= CHtml::link("<i class='" . MyIcon::getIcons('periksa') . "'></i>", Yii::app()->createUrl("/anestesi/monitoringIntraAnastesi/index", array('pasienanastesi_id' => $data->pasienanastesi_id)), array('rel' => 'tooltip', 'data-original-title' => 'Klik icon ini, untuk masuk ke transaksi monitoring intra anestesi', 'data-placement' => 'left'));
                                if (!empty($data->getMonitoringIntraAnastesi($data->pasienanastesi_id))) {
                                    $buton .= CHtml::link("<i class='icon-medical-list'></i>", Yii::app()->createUrl("/anestesi/grafikMonitoringIntraAnastesi/index", array('pasienanastesi_id' => $data->pasienanastesi_id, 'pendaftaran_id'=>$data->pendaftaran_id, 'pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id)), array('rel' => 'tooltip', 'data-original-title' => 'Klik icon ini, untuk masuk ke transaksi grafik monitoring intra anestesi', 'data-placement' => 'left'));
                                } else {
                                    $buton .= CHtml::link("<i class='icon-medical-list'></i>", "#", array('rel' => 'tooltip', 'data-original-title' => 'Silahkan melakukan monitoring terlebih dahulu', 'onclick' => 'myAlert("Silahkan melakukan monitoring terlebih dahulu"); return false;', 'data-placement' => 'left'));
                                }

                                return $buton;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px ')
                        ),
                        array(
                            'header' => 'Pasca Anestesi',
                            'type' => 'raw',
                            'value' => function($data) {
                                $button = CHtml::link("<i class='" . MyIcon::getIcons('periksa') . "'></i>", Yii::app()->createUrl("/anestesi/EvaluasiPascaAnestesi/index",array('pasienanastesi_id' => $data->pasienanastesi_id, 'pendaftaran_id'=>$data->pendaftaran_id, 'pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id)), array('rel' => 'tooltip', 'data-original-title' => 'Klik icon ini, untuk masuk ke transaksi pasca anestesi', 'data-placement' => 'left'));

                                return $button;
                            },
                        ),
                        array(
                            'header' => 'Tindakan',
                            'type' => 'raw',
                            'value' => '',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>

        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'daftarPasien-form',
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>

        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">		
                        <?php echo CHtml::label("Tanggal Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span ><?php echo date('d M Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label for="noPendaftaran" class="control-label">No. Pendaftaran </label>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'no_pendaftaran', array('placeholder' => 'Ketik No. Pendaftaran')); ?>
                        </div>
                    </div> 
                    <div class="control-group ">
                        <label for="noRekamMedik" class="control-label">No. Rekam Medik </label>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'no_rekam_medik', array('class' => 'numbers-only', 'maxlength' => 8, 'placeholder' => 'Ketik No. Rekam Medik')); ?>
                        </div>
                    </div>    
                    <div class="control-group ">
                        <label for="namaPasien" class="control-label">Nama Pasien </label>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'nama_pasien', array('placeholder' => 'Ketik Nama Pasien')); ?>
                        </div>
                    </div> 
                </div>
                <div class="col-sm-6">
                    <div class="control-group">	
                        <?php
                        $carabayar = CarabayarM::model()->findAll(array('condition' => 'carabayar_aktif = true', 'order' => 'carabayar_nourut',));
                        $penjamin = PenjaminpasienM::model()->findAll(array('condition' => 'penjamin_aktif = true', 'order' => 'penjamin_nama',));
                        $dokter = DokterV::model()->findAll(array('condition' => 'pegawai_aktif = true and ruangan_id = ' . Yii::app()->user->getState('ruangan_id'), 'order' => 'nama_pegawai',));
                        foreach ($carabayar as $idx => $item) {
                            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                'carabayar_id' => $item->carabayar_id,
                                'penjamin_aktif' => true,
                            ));
                            if (empty($penjamins))
                                unset($carabayar[$idx]);
                        }

                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                            'instalasi_id' => array(2, 3, 4),
                                            'ruangan_aktif' => 'true'
                                                ), array(
                                            'order' => 'instalasi_id, ruangan_nama',
                                        )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));

                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'pegawai_id', CHtml::listData($dokter, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3'));

                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3',
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modPasienMasukPenunjang, "penjamin_id") . '").html(data); }',
                            ),
                        ));

                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
                        ?>
                        <?php echo CHtml::label("Status Periksa", '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPasienMasukPenunjang, 'statuspendaftaran', LookupM::getItems('statusperiksa'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>

                </div>
                <div class="clear"></div>
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'));
                    ?>        
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                    ?>

                    <?php
                    $content = $this->renderPartial($this->path_view . 'tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>	
                </div>

            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>



    <iframe id="suarapanggilan" src="" style="display: none;"></iframe>

    <script type="text/javascript">
        function cekTanggal() {

            var checklist = $('#BSMasukPenunjangV_ceklis');
            var pilih = checklist.attr('checked');
            if (pilih) {
                document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:block;");
                document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:block;");
            } else {
                document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:none;");
                document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:none;");
            }
        }
        function batalPeriksa(idPenunjang) {
            myConfirm("Apakah anda yakin akan membatalkan pemeriksaan Operasi Bedah pasien ini?", "Perhatian!", function (r) {
                if (r) {
                    $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalPeriksa') ?>', {idPenunjang: idPenunjang},
                            function (data) {
                                if (data.status == 'ok' && data.pesan != 'exist') {
                                    window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                                } else {
                                    if (data.pesan == 'exist' && data.status == 'ok')
                                    {
                                        if (data.smspasien == 0) {
                                            var params = [];
                                            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS PASIEN', isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'}; // 16 
                                            insert_notifikasi(params);
                                        }
                                        $('#dialogKonfirm div.divForForm').html(data.keterangan);
                                        $('#dialogKonfirm').dialog('open');
                                        $('#daftarpasien-v-grid').addClass('animation-loading');
                                        $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                            data: $(this).serialize()
                                        });
                                    }
                                }
                            }, 'json'
                            );

                }
            });
        }

        function ambilAntrianTerakhir() {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
                dataType: "json",
                success: function (data) {
                    if (data.pesan == "") {
                        panggilAntrian(data.pasienmasukpenunjang_id);
                        setSuaraPanggilanSingle(data.ruangan_singkatan, data.no_urutperiksa, data.ruangan_id);
                    } else {
                        myAlert(data.pesan);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
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
                data: {pasienmasukpenunjang_id: pasienmasukpenunjang_id},
                dataType: "json",
                success: function (data) {
                    if (data.pesan !== "") {
                        myAlert(data.pesan);
                    }
<?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                        socket.emit('send', {conversationID: 'antrian', panggil: 1, antrian_id: pasienmasukpenunjang_id});
<?php } ?>
                    $.fn.yiiGridView.update('daftarpasien-v-grid');
                },
                error: function (jqXHR, textStatus, errorThrown) {
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



        /**
         * 
         * @param {type} pendaftaran_id
         * @param {type} statusperiksa
         * @param {type} namaPasien
         * @returns {undefined}
         */
        function dialogBatalPeriksa(pendaftaran_id, penunjang_id, namaPasien)
        {
            $('#titleNamaPasienBatal').html(namaPasien);
            $('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
            $('#DialogBatalperiksa #penunjang_id').val(penunjang_id);
            $('#DialogBatalperiksa').dialog('open');
        }

        function ubahPeriksaKarenaBatal() {
            var pendaftaran_id = $('#DialogBatalperiksa #pendaftaran_id').val();
            var penunjang_id = $('#DialogBatalperiksa #penunjang_id').val();
            var tglbatal = $('#DialogBatalperiksa #tglbatal').val();
            var keterangan_batal = $('#DialogBatalperiksa #keterangan_batal').val();

            $('#DialogBatalperiksa #keterangan_batal').attr('class', '');
            if (keterangan_batal == '') {
                myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
                $('#DialogBatalperiksa #keterangan_batal').attr('class', 'error');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('BatalPeriksa'); ?>',
                data: {pendaftaran_id: pendaftaran_id, tglbatal: tglbatal, keterangan_batal: keterangan_batal, idPenunjang: penunjang_id}, //
                dataType: "json",
                success: function (data) {
                    if (data.status == 'ok' && data.pesan != 'exist') {
                        window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                    } else {
                        if (data.pesan == 'exist' && data.status == 'ok')
                        {
                            if (data.smspasien == 0) {
                                var params = [];
                                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS PASIEN', isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'}; // 16 
                                insert_notifikasi(params);
                            }
                            $('#DialogBatalperiksa').dialog('close');
                            $('#dialogKonfirm div.divForForm').html(data.keterangan);
                            $('#dialogKonfirm').dialog('open');
                            $('#daftarpasien-v-grid').addClass('animation-loading');
                            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                data: $(this).serialize()
                            });
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }

        function pindahTransaksi(obj) {
            var id = $(obj).attr('data_id');

            window.location.href = '<?php Yii::app()->user->getState('/anestesi/monitoringIntraAnastesi/index'); ?>&pasienanastesi_id' + id;
        }

    </script>
