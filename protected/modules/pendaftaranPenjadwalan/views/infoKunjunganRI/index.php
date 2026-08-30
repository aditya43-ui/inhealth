<style>
    .tr_isadmin {
        background-color: #f0baba !important;
        color: #111010;
    }

    .tr_isadmin:hover {
        background-color: #f0baba !important;
        color: #111010;
    }
    table a {
        color: #000000 !important;
        text-decoration: none;
    }
</style>

    <?php $linkHalaman = CustomFunction::getUrlByMenuID(1173); ?>
    <?php
    $this->breadcrumbs = array(
        'Informasi Pasien Rawat Inap',
    );
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    Yii::app()->clientScript->registerScript('search', "
$('#formCari').submit(function(){
    $('#btn_simpan').prop('disabled', true);
	$.fn.yiiGridView.update('PPInfoKunjungan-v', {
		data: $(this).serialize(),
        complete: function(){
            $('#btn_simpan').prop('disabled', false);
        }
	});
	return false;
});
");
    ?>
    <div class="panel panel-pr_imary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-users"></i> Informasi <b>Pasien Rawat Inap</b>
                <span class="pull-right">
                    <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                    </a>
                </span>
            </div>
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                        'id' => 'formCari',
                        'type' => 'horizontal',
                        'focus' => '#' . CHtml::activeId($modPPInfoKunjunganRIV, 'no_rekam_medik'),
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                    )); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'jns_periode', array('class' => 'span2')); ?>
                                <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'bln_awal', array('class' => 'span2')); ?>
                                <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'bln_akhir', array('class' => 'span2')); ?>
                                <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'thn_awal', array('class' => 'span2')); ?>
                                <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'thn_akhir', array('class' => 'span2')); ?>
                                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?= $form->radioButtonList($modPPInfoKunjunganRIV, 'pilihanPeriode', ['1' => 'Tgl. Masuk', '2' => 'Tgl. Keluar']) ?>
                                </div>
                                <div class="controls">
                                    <div class="daterange daterange-inline add-ranges input-inline span5" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPPInfoKunjunganRIV->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPPInfoKunjunganRIV->tgl_akhir)) ?>">
                                        <i class="entypo-calendar"></i>
                                        <span><?php echo date('d M Y', strtotime($modPPInfoKunjunganRIV->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPPInfoKunjunganRIV->tgl_akhir)) ?></span>
                                        <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'tgl_awal', array('class' => 'start')) ?>
                                        <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'tgl_akhir', array('class' => 'end')) ?>
                                    </div>
                                </div>
                                
                            </div>
                            <?php echo $form->textFieldRow($modPPInfoKunjunganRIV, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                            <?php echo $form->textFieldRow($modPPInfoKunjunganRIV, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                            <?php echo $form->textAreaRow($modPPInfoKunjunganRIV, 'alamat_pasien', array('placeholder' => 'Alamat Pasien', 'class' => 'span4 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'rows' => 2, 'maxlength' => 50)); ?>
                            <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'caramasuk_id', CHtml::listData(CaramasukM::model()->findAllByAttributes(array(
                                //'instalasi_id'=>Params::INSTALASI_ID_RI,
                                'caramasuk_aktif' => true,
                            ), array(
                                'order' => 'caramasuk_nama asc'
                            )), 'caramasuk_id', 'caramasuk_nama'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                            <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'status_konfirmasi', CustomFunction::getStatusKonfirmasi(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                            <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'carabayar_id', CHtml::listData($modPPInfoKunjunganRIV->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => 'PPInfoKunjunganRIV')),
                                    'update' => '#PPInfoKunjunganRIV_penjamin_id'  //selector to update
                                ),
                            )); ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPPInfoKunjunganRIV, 'penjamin_id', CHtml::listData($modPPInfoKunjunganRIV->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modPPInfoKunjunganRIV, 'no_identitas_pasien', array('placeholder' => 'NIK', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                            <div class="control-group">
                                <?php $modPPInfoKunjunganRIV->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPPInfoKunjunganRIV->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                                <?php echo CHtml::label(CHtml::activeCheckBox($modPPInfoKunjunganRIV, 'ceklis') . " <label for='PPInfoKunjunganRIV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPPInfoKunjunganRIV,
                                        'attribute' => 'tgl_awall',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php $modPPInfoKunjunganRIV->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPPInfoKunjunganRIV->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                                <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPPInfoKunjunganRIV,
                                        'attribute' => 'tgl_akhirl',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'asalrujukan_id', CHtml::listData(
                                AsalrujukanM::model()->findAll(array(
                                    'condition' => 'asalrujukan_aktif = true',
                                    'order' => 'asalrujukan_nama'
                                )),
                                'asalrujukan_id',
                                'asalrujukan_nama'
                            ), array(
                                'empty' => '-- Pilih --',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => get_class($modPPInfoKunjunganRIV))),
                                    'update' => '#' . CHtml::activeId($modPPInfoKunjunganRIV, 'rujukandari_id'),
                                )
                            )); ?>
                            <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'rujukandari_id', array(), array('empty' => '-- Pilih --')); ?>
                            <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                'instalasi_id' => array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU),
                                'ruangan_aktif' => true,
                            ), array(
                                'order' => 'ruangan_nama asc'
                            )), 'ruangan_id', 'ruangan_nama'), array(
                                'empty' => '-- Pilih --',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/actionDynamic/getKamarRuangan', array('encode' => false, 'namaModel' => get_class($modPPInfoKunjunganRIV))),
                                    'success' => 'function(data){$("#' . CHtml::activeId($modPPInfoKunjunganRIV, "kamarruangan_id") . '").html(data); }',
                                ),
                            )); ?>
                            <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'kelaspelayanan_id', CHtml::listData(
                                KelaspelayananM::model()->findAllByAttributes(array(
                                    'kelaspelayanan_aktif' => true,
                                ), array(
                                    'order' => 'kelaspelayanan_nama'
                                )),
                                'kelaspelayanan_id',
                                'kelaspelayanan_nama'
                            ), array(
                                'empty' => '-- Pilih --',
                            )); ?>
                            <div class="control-group">
                                <?php echo $form->label($modPPInfoKunjunganRIV, 'Kamar Ruangan', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPPInfoKunjunganRIV, 'kamarruangan_id', array(), array('empty' => '-- Pilih --')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($modPPInfoKunjunganRIV, 'dokterpenerima_id', array('class' => 'control-label', 'label' => 'Dokter Penerima')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPPInfoKunjunganRIV,
                                        'dokterpenerima_id',
                                        CHtml::listData(PegawaiV::model()->findAllByAttributes(array(
                                            'pegawai_aktif' => true,
                                            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                                            'jabatan_id' => Params::JABATAN_ID_DOKTER_UMUM,
                                        ), array(
                                            'order' => 'nama_pegawai asc'
                                        )), 'pegawai_id', 'namaLengkap'),
                                        array('empty' => '-- Pilih --')
                                    ); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($modPPInfoKunjunganRIV, 'pegawai_id', array('class' => 'control-label', 'label' => 'DPJP')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPPInfoKunjunganRIV,
                                        'pegawai_id',
                                        CHtml::listData(PegawaiV::model()->findAllByAttributes(array(
                                            'pegawai_aktif' => true,
                                            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                                        ), array(
                                            'condition' => 'jabatan_id <> ' . Params::JABATAN_ID_DOKTER_UMUM,
                                            'order' => 'nama_pegawai asc'
                                        )), 'pegawai_id', 'namaLengkap'),
                                        array('empty' => '-- Pilih --')
                                    ); ?>
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow(
                                $modPPInfoKunjunganRIV,
                                'statusperiksa',
                                Params::statusPeriksa(),
                                array('empty' => '-- Pilih --')
                            ); ?>
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
                                    echo $form->dropDownList($modPPInfoKunjunganRIV, 'create_loginpemakai_id', $arr, array('empty' => '-- Pilih --')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Status Verifikasi', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPPInfoKunjunganRIV, 'is_verifikasidiagnosa', ['0' => 'Belum Verifikasi', '1' => 'Sudah Verifikasi'], array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
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
                        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienRI', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Inap</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <?php
                    ///$tglSkral = Yii::app()->dateFormatter->formatDateTime(/
                    //                                        CDateTimeParser::parse($modPPInfoKunjunganRIV->tgl_awal, 'yyyy-MM-dd hh:mm:ss'));
                    //echo $tglSkr=date('Y-m-d H:i:s').'fffffffffffff';
                    //echo  $tanggalSaja=trim(substr($tglSkr,0,-8));
                        $this->renderPartial($this->path_view . '_table', ['modPPInfoKunjunganRIV' => $modPPInfoKunjunganRIV])
                    ?>
                </div>
            </div>
            <?php $this->endWidget();
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrintLembarPoli = Yii::app()->createUrl($module . 'pendaftaran/lembarPoliRI', array('pendaftaran_id' => ''));
            ?>
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'dialogHakKewajiban',
                'options' => array(
                    'title' => 'Hak & Kewajiban Pasien',
                    'autoOpen' => false,
                    'modal' => true,
                    'minWidth' => 960,
                    'height' => 580,
                    'resizable' => false,
                ),
            ));
            ?>
            <iframe name="iframeHakKewajiban" style="width: 100%; height: 98%;"></iframe>
            </iframe>
            <?php
            $this->endWidget();
            ?>
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'dialogVerifikasiDiagnosa',
                'options' => array(
                    'title' => 'Verifikasi Diagnosa',
                    'autoOpen' => false,
                    'modal' => true,
                    'zIndex' => 1002,
                    'minWidth' => 1124,
                    'height' => 610,
                    'resizable' => true,
                    'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
					data: $(this).serialize()
				}); }",
                ),
            ));
            ?>
            <iframe id="iframeVerifikasiDiagnosa" name="iframeVerifikasiDiagnosa" width="100%" height="550">
            </iframe>
            <?php $this->endWidget();

            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'dialogRingkasan',
                'options' => array(
                    'title' => 'Ringkasan Keluar dan Masuk',
                    'autoOpen' => false,
                    'modal' => true,
                    'zIndex' => 1002,
                    'minWidth' => 1124,
                    'height' => 610,
                    'resizable' => true,
                    'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $(this).serialize()
                    }); }",
                ),
            ));
            ?>
            <iframe id="iframeVerifikasiDiagnosa" name="iframeRingkasan" width="100%" height="550">
            </iframe>
            <?php $this->endWidget();
            ?>
            <?php
            //========= Ganti Poli Dialog =============================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'ganti_poli',
                'options' => array(
                    'title' => 'Ganti Ruangan Pasien - <span id="titleNamaPasien"></span>',
                    'autoOpen' => false,
                    'zIndex' => 1002,
                    'minWidth' => 400,
                    'modal' => true,
                ),
            ));
            ?>
            <table>
                <tr>
                    <td>Ruangan</td>
                    <td>:</td>
                    <td>
                        <?php echo CHtml::dropDownList('ruangan_sebelumnya', '', array(), array('disabled' => true)); ?>
                        <?php echo CHtml::hiddenField('ruangan_awal', '', array('readonly' => true)); ?>
                    </td>
                </tr>
                <tr>
                    <td>Alasan Perubahan <span class="required">*</span></td>
                    <td>:</td>
                    <td><?php echo CHtml::textArea('alasanperubahan', '', array()); ?></td>
                </tr>
                <tr>
                    <td>Menjadi Ruangan</td>
                    <td>:</td>
                    <td><?php echo CHtml::dropDownList('ruangan_id_ganti', 'ruangan_id_ganti', array(), array('empty' => '-- Pilih --',)); ?></td>
                </tr>
            </table>
            <?php
            echo CHtml::hiddenField('pendaftaran_id');
            echo CHtml::hiddenField('pasien_id');
            echo CHtml::hiddenField('pasienadmisi_id');
            echo CHtml::hiddenField('instalasi_id');
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'simpanRuanganBaru();')
            );
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-cancel"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => '$(\'#ganti_poli\').dialog(\'close\');')
            );
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            //========= end Ganti Ruangan Dialog =========================
            //Yii::app()->clientScript->registerScript('jsPendaftaran',$js, CClientScript::POS_HEAD);
            // ===========================Dialog Batal Periksa=================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'confirm',
                // additional javascript options for the dialog plugin
                'options' => array(
                    'title' => '',
                    'autoOpen' => false,
                    'show' => 'blind',
                    'hide' => 'explode',
                    'zIndex' => 1002,
                    'minWidth' => 500,
                    'height' => 100,
                    'resizable' => false,
                    'modal' => true,
                ),
            ));
            echo '<p style="margin: 0; text-align: center;">Apakah Anda Yakin Akan Membatalkan Pemeriksaan Pasien Ini?<br><br>';
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'ubahPeriksa();')
            );
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-cancel"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => '$(\'#confirm\').dialog(\'close\');')
            );
            echo CHtml::hiddenField('pendaftaran_id', '');
            echo CHtml::hiddenField('statusperiksa', '');
            //                            echo '14 April 2012 Belum Berjalan Karena untuk <br> 
            //                                Pengecekannya Harus Kasir Dulu N tabel yang diperlukan ataw 
            //                                view yang diperlukan belum ada';
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            //===============================Akhir Dialog Batal Periksa=====================
            //======================================================JAVA SCRIPT===================================================                          
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            //$urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaran/lembarPoliRI',array('pasienadmisi_id'=>''));
            $urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatInap/printStatusRI', array('pendaftaran_id' => ''));
            $urlPrintStatusPasien = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatInap/printStatus', array('pendaftaran_id' => ''));
            $urlPrintLabel = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printLabel', array('pendaftaran_id' => ''));
            $urlPrintStiker = Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRJ/printStiker', array('pendaftaran_id' => ''));
            $urlPrintCasemix = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printCasemix', array('pendaftaran_id' => ''));
            $urlPrintCasemixIden = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printCasemixIdentitas', array('id' => ''));
            $urlListDokterRuangan = $this->createUrl('listDokterRuangan');
            $urlGetRuangan = $this->createUrl('GetRuanganPasien');
            $simpanRuanganBaru = $this->createUrl('SaveRuanganBaru');
            $urlPrintKepalaLes = Yii::app()->createUrl('pendaftaranPenjadwalan/InfoKunjunganRI/printKepalaLes', array('pendaftaran_id' => ''));

            $statusPeriksaBatalPeriksa = Params::STATUSPERIKSA_BATAL_PERIKSA;
            $js = <<< JSCRIPT
//====================================Awal Ubah Jenis Penjamin============================================================
//=====================================Akhir Ubah Jenis Penjamin============================================================    
//======================================Awal batal Periksa==============================================================
function dialogConfirm(pendaftaran_id,statusperiksa)
   {
        $('#confirm #pendaftaran_id').val(pendaftaran_id);
        $('#confirm #statusperiksa').val(statusperiksa);
        $('#confirm').dialog('open');
   } 
function ubahPeriksa()
    {
      var url =$('#url').val();
      var statusperiksa=$('#confirm #statusperiksa').val();
      var pendaftaran_id=$('#confirm #pendaftaran_id').val(); 
      if(statusperiksa=='${statusPeriksaBatalPeriksa}')
        {
            myAlert('PasienSudah Dibatalkan');
        }
      else
        {
             $.post("${url}/ubahPeriksa", {pendaftaran_id: pendaftaran_id,statusperiksa:statusperiksa},
                function(data){
                     myAlert(data.message);
                },"json");
        }
    }   
//=======================================Akhir Batal Periksa=============================================================   
//=======================================Awal Print Lembar Poli==========================================================
function print(pendaftaran_id)
{
   window.open('${urlPrintLembarPoli}'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=400');    
}
function printStatus(pendaftaran_id)
{
   window.open('${urlPrintStatusPasien}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
}     

function printCasemix(pendaftaran_id)
{
   window.open('${urlPrintCasemix}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
}

function printCasemixIden(pendaftaran_id)
{
   window.open('${urlPrintCasemixIden}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
}

function printLabel(pendaftaran_id)
{
   window.open('${urlPrintLabel}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
}
function printKepalaLes(pendaftaran_id) {
    window.open('${urlPrintKepalaLes}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600'); 
}


function printStiker(pendaftaran_id)
{
   window.open('${urlPrintStiker}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
}

//========================================Akhir Print Lembar Poli========================================================
//========================================Awal Ganti Ruangan==================================================================
function gantiPoli(pendaftaran_id,ruangan_id,instalasi_id,pasien_id,namaPasien,pasienadmisi_id)
    {
        $('#titleNamaPasien').html(namaPasien);
           $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id,instalasi_id:instalasi_id,pasien_id:pasien_id},
           function(data){
            $('#ganti_poli').dialog('open');
            $('#ganti_poli #ruangan_awal').val(ruangan_id);
            $('#ganti_poli #ruangan_sebelumnya').html(data.dropDown);
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
            $('#ganti_poli #pendaftaran_id').val(pendaftaran_id);
            $('#ganti_poli #pasien_id').val(pasien_id);
            $('#ganti_poli #pasienadmisi_id').val(pasienadmisi_id);
            $('#ganti_poli #instalasi_id').val(instalasi_id);
        }, "json");
    }
 function simpanRuanganBaru()
    {
        if($('#ganti_poli #alasanperubahan').val()==''){
           myAlert('Alasan Perubahan tidak boleh kosong!');
           $('#ganti_poli #alasanperubahan').addClass('error');
           return false;
        }
        $('#ganti_poli').dialog('close');
        var pendaftaran_id= $('#ganti_poli #pendaftaran_id').val();
        var pasien_id= $('#ganti_poli #pasien_id').val();
        var pasienadmisi_id= $('#ganti_poli #pasienadmisi_id').val();
        var ruangan_id= $('#ganti_poli #ruangan_id_ganti').val();
        var ruangan_awal= $('#ganti_poli #ruangan_awal').val();
        var alasan = $('#ganti_poli #alasanperubahan').val();
        $.post("${simpanRuanganBaru}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, ruangan_awal: ruangan_awal, alasan:alasan, pasien_id:pasien_id,pasienadmisi_id:pasienadmisi_id},
            function(data){
                if(data.status=='Gagal'){
                    myAlert(data.status);
                }else if(data.status =='OK'){
                    myAlert("Data berhasil diubah");
                }else{
                    myAlert(data.status);
                }
                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $('#formCari').serialize()
                });
            }, "json");
    }
//========================================Akhir Ganti Ruangan=========================================================
JSCRIPT;
            Yii::app()->clientScript->registerScript('javascript', $js, CClientScript::POS_HEAD);
            $js = <<< JS
$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";
if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}
if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
            Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
            ?>
            <?php
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
                        'close' => 'js:function(){
                    $.fn.yiiGridView.update(\'PPInfoKunjungan-v\')
                }',
                    ),
                )
            );
            echo CHtml::hiddenField('temp_norekammedik', '', array('readonly' => true));
            echo '<iframe name="frameEditPasien" style="width: 100%; height: 98%;"></iframe>';
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>

            <?php
            // Dialog untuk batal Rawat Inap =========================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'dialogBatalRawatInap',
                'options' => array(
                    'title' => 'Pembatalan Pasien Rawat Inap',
                    'autoOpen' => false,
                    'modal' => true,
                    'minWidth' => 800,
                    'height' => 500,
                    'resizable' => true,
                    'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                    data: $('#formCari').serialize()
                }); }",
                ),
            ));
            ?>
            <iframe src="" name="iframeBatalRawatInap" style="width: 100%; height: 98%;"></iframe>
            <?php $this->endWidget(); ?>

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
            //=============================== Ganti Data Jenis Kelamin Dialog =======================================
            $this->beginWidget(
                'zii.widgets.jui.CJuiDialog',
                array(
                    'id' => 'editJenisKelamin',
                    'options' => array(
                        'title' => 'Ganti Data Jenis Kelamin',
                        'autoOpen' => false,
                        'zIndex' => 1002,
                        'minWidth' => 500,
                        'modal' => true,
                    ),
                )
            );
            echo CHtml::hiddenField('temp_norekammedik', '', array('readonly' => true));
            echo '<div class="divForFormEditJenisKelamin"></div>';
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
            <?php
            //=============================== Ganti Data Kelas Pelayanan Dialog =======================================
            $this->beginWidget(
                'zii.widgets.jui.CJuiDialog',
                array(
                    'id' => 'editKelasPelayanan',
                    'options' => array(
                        'title' => 'Ganti Kelas Pelayanan',
                        'autoOpen' => false,
                        'zIndex' => 1002,
                        'minWidth' => 500,
                        'modal' => true,
                    ),
                )
            );
            echo CHtml::hiddenField('temp_idPendaftaranKP', '', array('readonly' => true));
            echo '<div class="divForFormEditKelasPelayanan"></div>';
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
            <?php
            //========================================= Jenis Penjamin dialog =============================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'carabayardialog',
                'options' => array(
                    'title' => 'Ganti Jenis Penjamin dan Penjamin',
                    'autoOpen' => false,
                    'zIndex' => 1002,
                    'minWidth' => 300,
                    'height' => 450,
                    'modal' => true,
                    'resizable' => false,
                    'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', { }); }",
                    //'hide'=>explode,
                ),
            ));
            echo '<iframe id="iframeUbahCaraBayar"  name="iframeUbahCaraBayar" style="width: 100%; height: 98%;"></iframe>';
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            //========================================================= end cara bayar dialog =========
            $this->beginWidget(
                'zii.widgets.jui.CJuiDialog',
                array(
                    'id' => 'editDokterPeriksa',
                    'options' => array(
                        'title' => 'Ubah DPJP Rawat Inap',
                        'autoOpen' => false,
                        'zIndex' => 1002,
                        'minWidth' => 300,
                        'height' => 500,
                        'modal' => true,
                        'resizable' => false,
                        'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', { }); }",
                    ),
                )
            );
            //    echo CHtml::hiddenField('temp_idPendaftaranDP','',array('readonly'=>true));
            //    echo '<div class="divForFormEditDokterPeriksa"></div>';
            echo '<iframe id="iframeDokterPeriksa"  name="iframeDokterPeriksa" style="width: 100%; height: 98%;">
		</iframe>';
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
            <?php
            // $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            //     'id' => 'dialogPindahKamar',
            //     'options' => array(
            //         'title' => 'Pindah Kamar Pasien',
            //         'autoOpen' => false,
            //         'modal' => true,
            //         'zIndex' => 1002,
            //         'minWidth' => 1124,
            //         'height' => 610,
            //         'resizable' => true,
            //         'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
            // 			data: $(this).serialize()
            // 		}); }",
            //     ),
            // ));
            ?>
            <!-- <iframe id="iframePindahKamar" name="iframePindahKamar" width="100%" height="550">
        </iframe> -->
            <?php //$this->endWidget(); 
            ?>
            <!-- Penambahan dialog untuk riwayat pemeriksaan pasien -->
            <?php
            // Dialog untuk Melihat pemeriksaan pasien =========================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id' => 'dialogRiwayatPasien',
                'options' => array(
                    'title' => 'Riwayat Pemeriksaan Pasien',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 950,
                    'height' => 550,
                    'resizable' => true,
                    'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                data: $('#daftarPasien-form').serialize()
                            }); }",
                ),
            ));
            ?>
            <iframe name='frameRiwayatPasien' style="width: 100%; height: 98%;"></iframe>
            <?php $this->endWidget(); ?>
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id' => 'dialogAkadIjarah',
                'options' => array(
                    'title' => 'Buat Akad Ijarah',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 800,
                    'height' => 500,
                    'resizable' => true,
                ),
            ));
            ?>
            <iframe id="frameAkadIjarah" name='frameAkahIjarah' style="width: 100%; height: 98%;"></iframe>
            <?php $this->endWidget(); ?>
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id' => 'dialogFormulirPenetapan',
                'options' => array(
                    'title' => 'Formulir Penetapan DPJP',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 800,
                    'height' => 500,
                    'resizable' => true,
                ),
            ));
            ?>
            <iframe id="frameFormulirPenetapan" name='frameFormulirPenetapan' style="width: 100%; height: 98%;"></iframe>
            <?php $this->endWidget(); ?>
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id' => 'dialogPernyataanPersetujuan',
                'options' => array(
                    'title' => 'Buat Pernyataan Persetujuan',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 800,
                    'height' => 500,
                    'resizable' => true,
                ),
            ));
            ?>

            <iframe id="framePernyataanPersetujuan" name='framePernyataanPersetujuan' style="width: 100%; height: 98%;"></iframe>

            <?php $this->endWidget(); ?>

            <!-- End Penambahan dialog untuk riwayat pemeriksaan pasien -->

            <?php
            // Dialog untuk pasien pulang =========================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'dialogTindakLanjut',
                'options' => array(
                    'title' => 'Transaksi Pemulangan Pasien',
                    'autoOpen' => false,
                    'modal' => true,
                    'minWidth' => 1100,
                    'height' => 700,
                    'resizable' => true,
                    'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                    data: $('#daftarPasien-form').serialize()
                                }); }",
                ),
            ));
            ?>
            <iframe src="" name="iframeTindakLanjut" style="width: 100%; height: 98%;"></iframe>
            <?php
            $this->endWidget();
            //========= end pasienpulang dialog =============================
            ?>

            <?php
            //========================================= Ubah Perujuk Dialog =============================//
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'DialogPerujuk',
                'options' => array(
                    'title' => 'Ubah Data Perujuk',
                    'autoOpen' => false,
                    'zIndex' => 1002,
                    'minWidth' => 550,
                    'height' => 500,
                    'modal' => true,
                    'resizable' => false,
                    'close' => 'js:function() {$.fn.yiiGridView.update("PPInfoKunjungan-v")}'
                    //'hide'=>explode,
                ),
            ));
            echo '<iframe id="iframeUbahPerujuk"  name="iframeUbahPerujuk" style="width: 100%; height: 98%;"></iframe>';
            // $this->renderPartial($this->path_view . '_formRujukan');
            ?>
            <?php
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>

            <script type="text/javascript">
                function disableLink() {
                    var status = null;
                    $("#PPInfoKunjungan-v tbody").find('tr > td[class="inap"]').each(
                        function() {
                            status = $(this).parent().find('td[class="status"]');
                            var xxx = $(this).find('a');
                            if (status.text() == 'SUDAH PULANG') {
                                $(this).text($.trim(xxx.text()));
                                $(this).find('a').remove();
                            }
                        }
                    );
                }
                disableLink();

                function ubahCaraBayar(namaPasien, id = null) {
                    $('#titleNamaPasienCaraBayar').html(namaPasien);
                    jQuery.ajax({
                        'url': '<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRI/ubahCaraBayarRI') ?>',
                        'data': $(this).serialize() + '&id=' + id,
                        'type': 'post',
                        'dataType': 'json',
                        'success': function(data) {
                            if (data.status == 'create_form') {
                                $('#carabayardialog div.divForFormUbahCaraBayar').html(data.div);
                                $('#carabayardialog div.divForFormUbahCaraBayar form').submit(ubahCaraBayar);
                            } else {
                                $('#carabayardialog div.divForFormUbahCaraBayar').html(data.div);
                                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                    data: $(this).serialize()
                                });
                                setTimeout("$('#carabayardialog').dialog('close') ", 500);
                            }
                        },
                        'cache': false
                    });
                    return false;
                }

                function listCaraBayar(idCaraBayar) {
                    $('#carabayardialog #tempCaraBayarId').val(idCaraBayar);
                    return false;
                }

                function setIdPendaftaran(pendaftaran_id, noPendaftaran) {
                    $('#carabayardialog #tempPendaftaranId').val(pendaftaran_id);
                    $('#carabayardialog #tempNoPendaftaran').val(noPendaftaran);
                }

                function ubahJenisKelamin(norm) {
                    $('#temp_norekammedik').val(norm);
                    jQuery.ajax({
                        'url': '<?php echo $this->createUrl('ubahJenisKelamin') ?>',
                        'data': $(this).serialize(),
                        'type': 'post',
                        'dataType': 'json',
                        'success': function(data) {
                            if (data.status == 'create_form') {
                                $('#editJenisKelamin div.divForFormEditJenisKelamin').html(data.div);
                                $('#editJenisKelamin div.divForFormEditJenisKelamin form').submit(ubahJenisKelamin);
                            } else {
                                $('#editJenisKelamin div.divForFormEditJenisKelamin').html(data.div);
                                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                    data: $(this).serialize()
                                });
                                setTimeout("$('#editJenisKelamin').dialog('close') ", 500);
                            }
                        },
                        'cache': false
                    });
                    return false;
                }

                function ubahKelasPelayanan(pendaftaran_id) {
                    $('#temp_idPendaftaranKP').val(pendaftaran_id);
                    jQuery.ajax({
                        'url': '<?php echo $this->createUrl('ubahKelasPelayananRI') ?>',
                        'data': $(this).serialize(),
                        'type': 'post',
                        'dataType': 'json',
                        'success': function(data) {
                            if (data.status == 'create_form') {
                                $('#editKelasPelayanan div.divForFormEditKelasPelayanan').html(data.div);
                                $('#editKelasPelayanan div.divForFormEditKelasPelayanan form').submit(ubahKelasPelayanan);
                            } else {
                                $('#editKelasPelayanan div.divForFormEditKelasPelayanan').html(data.div);
                                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                    data: $(this).serialize()
                                });
                                setTimeout("$('#editKelasPelayanan').dialog('close') ", 500);
                            }
                        },
                        'cache': false
                    });
                    return false;
                }

                function ubahDokterPeriksa(pendaftaran_id) {
                    $('#temp_idPendaftaranDP').val(pendaftaran_id);
                    jQuery.ajax({
                        'url': '<?php echo $this->createUrl('ubahDokterPeriksaRI') ?>',
                        'data': $(this).serialize(),
                        'type': 'post',
                        'dataType': 'json',
                        'success': function(data) {
                            if (data.status == 'create_form') {
                                $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                                $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
                            } else {
                                $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                    data: $(this).serialize()
                                });
                                setTimeout("$('#editDokterPeriksa').dialog('close') ", 500);
                            }
                        },
                        'cache': false
                    });
                    return false;
                }

                function verifikasiPulangPasien(pendaftaran_id) {
                    $("#judul_pulang").html("Pulang");
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->createUrl('VerifikasiRencanaPulang'); ?>',
                        data: {
                            pendaftaran_id: pendaftaran_id,
                            status: 'pulang'
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.status == true) {
                                if (data.verifikasinull != '') {
                                    myAlert(data.pesan);
                                } else {
                                    $("#dialogTindakLanjut").dialog("open");
                                }
                            } else {
                                myConfirm(data.pesan, "Perhatian!", function(r) {
                                    if (r) {
                                        $("#dialogTindakLanjut").dialog("open");
                                        if (data.statusbayar == 'ada') {
                                            // daftarPasien
                                        };
                                    }
                                })
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }

                function carakeluar(value) {
                    if (value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>") {

                        $('#divRujukan input').removeAttr('disabled');
                        $('#divRujukan select').removeAttr('disabled');
                        $('#divRujukan').slideToggle(500);
                        $('#isDead').prop('checked', false);
                        $('#isKontrol').prop('checked', false);
                        $('#pakeRujukan').attr('checked', true);
                        $('#pakeRujukan').attr('disabled', false);
                        $('#isDead').attr('disabled', true);
                        $('#isKontrol').attr('disabled', true);
                        // $("#<?php //echo CHtml::activeId($modRujukanKeluar, 'pegawai_id') 
                                ?>").val($("#pegawaiPemeriksa").val());
                        // $("#<?php //echo CHtml::activeId($modRujukanKeluar, 'ruanganasal_id') 
                                ?>").val($("#ruanganAsal").val());

                    } else if (value == "<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>") {
                        var date = new Date();
                        $('#pakeRujukan').removeAttr('checked');
                        $('#divRujukan input').attr('disabled', 'true');
                        $('#divRujukan select').attr('disabled', 'true');
                        $('#divRujukan input').attr('value', '');
                        $('#divRujukan select').attr('value', '');
                        $('#divRujukan').hide(500);
                        $('#RIPasienPulangT_tgl_meninggal').val('<?php
                                                                    echo Yii::app()->dateFormatter->formatDateTime(
                                                                        CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss')
                                                                    );
                                                                    ?>');
                        $('#isKontrol').attr('disabled', true);
                        $('#isDead').prop('checked', true);
                        $('#isDead').attr('disabled', false);
                        $('#pakeRujukan').attr('disabled', true);
                        $('#pakeRujukan').prop('checked', false);
                        $('#isKontrol').prop('checked', false);
                    } else if (value == "<?php echo Params::CARAKELUAR_ID_DIPULANGKAN ?>") {
                        var date = new Date();
                        $('#pakeRujukan').removeAttr('checked');
                        $('#divRujukan input').attr('disabled', 'true');
                        $('#divRujukan select').attr('disabled', 'true');
                        $('#divRujukan input').attr('value', '');
                        $('#divRujukan select').attr('value', '');
                        $('#divRujukan').hide(500);
                        $('#isKontrol').attr('disabled', false);
                        $('#isDead').attr('disabled', true);
                        $('#pakeRujukan').attr('disabled', true);
                        $('#isDead').prop('checked', false);
                        $('#pakeRujukan').prop('checked', false);
                    } else {
                        $('#pakeRujukan').removeAttr('checked');
                        $('#divRujukan input').attr('disabled', 'true');
                        $('#divRujukan select').attr('disabled', 'true');
                        $('#divRujukan input').attr('value', '');
                        $('#divRujukan select').attr('value', '');
                        $('#divRujukan').hide(500);
                        $('#isKontrol').attr('disabled', true);
                        $('#isDead').attr('disabled', true);
                        $('#pakeRujukan').attr('disabled', true);
                        $('#isDead').prop('checked', false);
                        $('#pakeRujukan').prop('checked', false);
                        $('#isKontrol').prop('checked', false);
                    }

                    if ($("#statusdokrm").val() == 'belum-dikembalikan') {
                        $("#formKirimDok").val('ada');
                        $(".boxkirimdokumen").show();
                        $(".boxkirimdokumen").find("input, textarea, select").each(function() {
                            $(this).attr("disabled", false);
                        });
                    } else {
                        $("#formKirimDok").val('');
                        $(".boxkirimdokumen").hide();
                        $(".boxkirimdokumen").find("input, textarea, select").each(function() {
                            $(this).attr("disabled", true);
                        });
                    }
                }

                function verifikasiPasienMeninggal() {
                    $("#judul_pulang").html("Meninggal");
                    $("#dialogTindakLanjut").dialog("open");
                }

                function loadFormCaraBayar(obj) {
                    var url = $(obj).attr('href');
                    $('#iframeUbahCaraBayar').attr('src', url);
                }

                function loadFormDokterPeriksa(obj) {
                    var url = $(obj).attr('href');
                    $('#iframeDokterPeriksa').attr('src', url);
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
                                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                    data: $(this).serialize()
                                });
                                setTimeout("$('#editKeterangan').dialog('close') ", 500);
                            }
                        },
                        'cache': false
                    });
                    return false;
                }

                function printLabelGelang(pasien_id, pendaftaran_id) {
                    window.open('<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printLabelGelang', array()); ?>&tipe=1&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
                }

                function printLabelGelangAnak(pasien_id, pendaftaran_id) {
                    window.open('<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printLabelGelang', array()); ?>&tipe=2&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
                }

                $(document).ready(function() {
                    var penj = jQuery('#<?php echo CHtml::activeId($modPPInfoKunjunganRIV, 'penjamin_id') ?>');

                    jQuery(penj).multiselect({
                        includeSelectAllOption: true,
                        buttonClass: "form-control",
                        maxHeight: 300,
                        buttonWidth: '240px',
                        enableCaseInsensitiveFiltering: true
                    }).hide();
                });

                var urlAkad = '<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratAkadIjarah/index'); ?>';
                var urlDpjp = '<?php echo $this->createUrl('/pendaftaranPenjadwalan/formulirPenetapanDpjp/index'); ?>';
                var urlSuratPeryataan = '<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratPernyataanPersetujuan/index'); ?>';

                function setAkad(id) {
                    var url_lengkap = urlAkad + "&pasienadmisi_id=" + id;

                    $("#dialogAkadIjarah").dialog("open");
                    $("#frameAkadIjarah").prop("src", url_lengkap);
                }

                function setFormulirPenetapan(id) {
                    var url_lengkap = urlDpjp + "&pasienadmisi_id=" + id;

                    $("#dialogFormulirPenetapan").dialog("open");
                    $("#frameFormulirPenetapan").prop("src", url_lengkap);
                }

                function printRM1(id) {
                    window.open('<?php echo $this->createUrl('pendaftaranRawatInapDariRJRD/printRM1'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=860,height=480');
                }

                function loadFormCaraBayar(obj) {
                    var url = $(obj).attr('href');
                    $('#iframeUbahCaraBayar').attr('src', url);
                }

                function loadFormPerujuk(obj) {
                    var url = $(obj).attr('href');
                    $('#iframeUbahPerujuk').attr('src', url);
                }

                function printGC(id) {
                    window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratPersetujuanUmum/PrintGeneralConsent'); ?>&pendaftaran_id=' + id, 'printwin', 'left=100,top=100,width=860,height=480');
                }

                function printDPJP(id) {
                    window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratPernyataanPersetujuan/PrintDPJP'); ?>&pendaftaran_id=' + id, 'printwin', 'left=100,top=100,width=860,height=480');
                }

                function printAllDPJP(id) {
                    window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/formulirPenetapanDpjp/PrintGabung'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=860,height=480');
                }


                function setSuratPeryataan(id) {
                    var url_lengkap = urlSuratPeryataan + "&pendaftaran_id=" + id;

                    $("#dialogPernyataanPersetujuan").dialog("open");
                    $("#framePernyataanPersetujuan").prop("src", url_lengkap);
                }

                function validasiSep(pendaftaran_id) {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo $this->createUrl('validasiSEP'); ?>',
                        data: {
                            id: pendaftaran_id
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.is_sep == 1) {
                                myAlert("Kunjungan tidak dapat dibatalkan karena sudah diterbitkan SEP!");
                                return false;
                            } else {
                                $('#dialogBatalRawatInap').dialog('open');
                            }



                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            </script>
            <!--UNTUK PERUBAHAN JENIS KASUS PENYAKIT DI UBAH POLI-->
            <?php
            $js = <<< JSCRIPT
function getKasusPenyakit(){
    ruangan_id = $('#ruangan_id_ganti').val();
    pendaftaran_id = $('#pendaftaran_id').val();
    pasien_id = $('#pasien_id').val();
    instalasi_id = $('#instalasi_id').val();
    jeniskasuspenyakit_id = '';  
   $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, instalasi_id:instalasi_id, pasien_id:pasien_id,
   jeniskasuspenyakit_id:jeniskasuspenyakit_id},
   function(data){
            $('#ganti_poli').dialog('open');            
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
//            $('#ganti_poli #jeniskasuspenyakit_id_ganti').html(data.jenisKasusPenyakit);
    }, "json");
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('getKasusPenyakit', $js, CClientScript::POS_HEAD);
            ?>
            <!--UNTUK PERUBAHAN JENIS KASUS PENYAKIT DI UBAH POLI-->
        </div>
    </div>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogChecklistBerkas',
        'options' => array(
            'title' => 'Checklist Kelengkapan Berkas',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'minWidth' => 1124,
            'height' => 700,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
					data: $(this).serialize()
				}); }",
        ),
    ));
    ?>

    <iframe id="iframeChecklistBerkas" name="iframeChecklistBerkas" style="width: 100%; height: 98%;"></iframe>

    <?php $this->endWidget(); ?>