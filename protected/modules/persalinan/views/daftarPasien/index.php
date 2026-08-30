<?php
    $this->breadcrumbs = array(
        'Informasi Daftar Pasien',
    );
    ?>
 <!--div class='white-container'-->
 <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
 <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $modul  = $this->module->name;
    $control = $this->id;
    Yii::app()->clientScript->registerScript('cari wew', "
		$('#daftarPasien-form').submit(function(){
			$.fn.yiiGridView.update('daftarPasien-grid', {
				data: $(this).serialize()
			});
			return false;
		});
		");
    ?>
 <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
 <div class="panel panel-gradient">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="entypo-info-circled"></i> Informasi <b>Daftar Pasien</b>
         </div>
     </div>
     <div class="panel-body">
         <?php
        //  penambahan $form
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => 'daftarPasien-form',
                'type' => 'horizontal',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
            ));
            ?>
         <div class="panel panel-success">
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class='entypo-search'></i> Pencarian
                 </div>
             </div>
             <div class="panel-body">
                 <div class="row">
                     <div class="col-sm-12">
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
                     </div>
                     <div class="col-sm-6">
                         <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 12)); ?>
                         <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6)); ?>
                         <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                         <div class="control-group">
                                <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                                </div>
                            </div>

                         <div class="control-group">
                             <?php $model->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                             <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " <label for='PSInfokunjunganpersalinanV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
                             <div class="controls">
                                 <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
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
                             <?php $model->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                             <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                             <div class="controls">
                                 <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
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
                            echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                            ?>
                         <?php
                            $dok = CHtml::listData(DokterV::model()->findAllByAttributes(array(
                                'pegawai_aktif' => true,
                                'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                            ), array(
                                'order' => 'nama_pegawai'
                            )), 'pegawai_id', 'namaLengkap');

                            $kel = CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array(
                                'kelaspelayanan_aktif' => true,
                            ), array(
                                'order' => 'kelaspelayanan_nama'
                            )), 'kelaspelayanan_id', 'kelaspelayanan_nama');
                            $kamar = CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
                                'ruangan_id' => Yii::app()->user->getState('ruangan_id')
                            )), 'kamarruangan_id', 'kamarDanTempatTidurPolos');
                            echo $form->dropDownListRow($model, 'pegawai_id', $dok, array('empty' => '-- Pilih --', 'class' => 'span4'));
                            echo $form->dropDownListRow($model, 'kelaspelayanan_id', $kel, array(
                                'empty' => '-- Pilih --',
                                'class' => 'span4',
                            ));
                            //	echo $form->dropDownListRow($model, 'kamarruangan_id', $kamar, array('empty'=>'-- Pilih --', 'class'=>'span4'));

                            echo $form->dropDownListRow($model, 'statusperiksa',  LookupM::getItems('statusperiksa'), array('class' => 'span4', 'empty' => '-- Pilih --'))
                            ?>
                     </div>
                 </div>

                 <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                    );
                    echo CHtml::hiddenField('pendaftaran_id');
                    if (isset($_GET['data'])) {
                        echo CHtml::hiddenField('jumlahPersalinan', $_GET['data']);
                    }
                    echo CHtml::hiddenField('pasien_id');
                    ?>
                 <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href ;}); return false;'
                        )
                    );
                    ?>
                 <?php
                    $content = $this->renderPartial('../daftarPasien/tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                 <?php $this->endWidget(); ?>
             </div>
         </div>
         <div class="panel panel-success">
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class="entypo-credit-card"></i> Tabel <strong>Daftar Pasien</strong>
                 </div>
             </div>
             <div class="panel-body table-responsive">
                 <div class='block-tabel'>
                     <?php
                        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) { //Jika Bukan Rawat Jalan
                            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'daftarPasien-grid',
                                'dataProvider' => $model->searchPasien(),
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                                'columns' => array(
                                    array(
                                        'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                                        'name' => 'tgl_pendaftaran',
                                        'type' => 'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                                    ),
                                    array(
                                        'header' => 'No.Rekam Medik/<br>NIK',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            return $data->no_rekam_medik . "/<br>" . $data->no_identitas_pasien;
                                        },
                                    ),
                                    array(
                                        'header' => 'Nama Pasien / Alias',
                                        'value' => '$data->namadepan.$data->nama_pasien'
                                    ),
                                    array(
                                        'header' => 'Jenis Penjamin / Penjamin',
                                        'type' => 'raw',
                                        //'value'=>'$data->caraBayarPenjamin2',
                                        'value' => function ($data) {
                                            return $data->carabayar_nama . "/<br>" . $data->penjamin_nama;
                                        },
                                    ),
                                    array(
                                        'header' => 'Ruangan',
                                        'type' => 'raw',
                                        'value' => '$data->ruangan_nama',
                                    ),
                                    array(
                                        'name' => 'Cara Masuk / Transportasi',
                                        'type' => 'raw',
                                        'value' => '$data->caraMasukTransportasi',
                                    ),
                                    array(
                                        'name' => 'Dokter / Rujukan',
                                        'type' => 'raw',
                                        'value' => '$data->nama_pegawai' . " / " . '(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                                    ),
                                    // array(
                                    //     'name' => 'Rujukan',
                                    //     'type' => 'raw',
                                    //     'value' => '(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                                    // ),
                                    array(
                                        'header' => 'Kasus Penyakit/<br>Kelas Pelayanan',
                                        'type' => 'raw',
                                        'value' => '"$data->jeniskasuspenyakit_nama"."<br>"."$data->kelaspelayanan_nama"',
                                    ),
                                    array(
                                        'name' => 'alamat_pasien',
                                        'type' => 'raw',
                                        'value' => '$data->alamat_pasien',
                                    ),
                                    array(
                                        'name' => 'statusperiksa',
                                        'type' => 'raw',
                                        'value' => '$data->statusperiksa',
                                    ),
                                    array(
                                        'header' => 'Periksa Kehamilan',
                                        'class' => 'bootstrap.widgets.BootButtonColumn',
                                        'template' => '{lihat}',
                                        'buttons' => array(
                                            'lihat' => array(
                                                'label' => "<i class='icon-form-ubah'></i>",
                                                'options' => array('title' => 'Persalinan'),
                                                'url' => 'Yii::app()->createUrl("persalinan/periksaKehamilan/index",array("pendaftaran_id"=>"$data->pendaftaran_id"))',
                                            ),
                                        ),  'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'header' => 'Imunisasi',
                                        'class' => 'bootstrap.widgets.BootButtonColumn',
                                        'template' => '{lihat}',
                                        'buttons' => array(
                                            'lihat' => array(
                                                'label' => "<i class='icon-pencil-yellow'></i>",
                                                'options' => array('title' => 'Kelahiran', 'class' => 'kelahiran'),
                                                'url' => 'Yii::app()->createUrl("persalinan/Imunisasi/index",array("pendaftaran_id"=>"$data->pendaftaran_id"))',
                                            ),
                                        ),  'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'header' => 'Keluarga Berencana',
                                        'class' => 'bootstrap.widgets.BootButtonColumn',
                                        'template' => '{lihat}',
                                        'buttons' => array(
                                            'lihat' => array(
                                                'label' => "<i class='icon-pencil'></i>",
                                                'options' => array('title' => 'Kelahiran', 'class' => 'kelahiran'),
                                                'url' => 'Yii::app()->createUrl("persalinan/KeluargaBerencana/index",array("pendaftaran_id"=>"$data->pendaftaran_id"))',
                                            ),
                                        ),  'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'header' => 'Kegiatan Bayi Tabung',
                                        'class' => 'bootstrap.widgets.BootButtonColumn',
                                        'template' => '{lihat}',
                                        'buttons' => array(
                                            'lihat' => array(
                                                'label' => "<i class='icon-pencil'></i>",
                                                'options' => array('title' => 'Kelahiran', 'class' => 'kelahiran'),
                                                'url' => 'Yii::app()->createUrl("persalinan/kegiatanBayiTabung/index",array("pendaftaran_id"=>"$data->pendaftaran_id"))',
                                            ),
                                        ),
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'name' => 'Pemeriksaan Pasien',
                                        'type' => 'raw',
                                        'value' => 'CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/persalinan/anamnesa",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'header' => 'Tindak Lanjut RI',
                                        'type' => 'raw',
                                        'value' => '(!empty($data->pasienpulang_id) ? "Pasien Rawat Inap" : CHtml::link("<i class=\'icon-user\'></i> ".$data->pasienpulang_id, "javascript:tindakLanjutRI(\'$data->pendaftaran_id\');",array("title"=>"Klik untuk Mendaftarkan ke Rawat Inap"))) ',
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'header' => 'Rincian Tagihan',
                                        'type' => 'raw',
                                        'value' => 'CHtml::link("<icon class=\'icon-list-brown\'></idcon>", Yii::app()->createUrl("' . $modul . '/' . $controller . '/rincian", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'header' => 'Batal Periksa',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            $rd = InfokunjunganrdV::model()->findByAttributes(array(
                                                'pendaftaran_id' => $data->pendaftaran_id
                                            ));

                                            $pen = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                            $cekDok = false;
                                            if (!empty($pen->pengirimanrm_id)) {
                                                if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
                                                    if (empty($pen->pengirimanrm->tglterimadokrm)) {
                                                        return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap terima dan kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                                                    } else {
                                                        return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                                                    }
                                                } else {
                                                    $cekDok = true;
                                                }
                                            } else {
                                                $cekDok = true;
                                            }

                                            if ($cekDok == true) {
                                                if (($rd->pasienpulang_id != 0) || ($rd->carakeluar != ""))
                                                    return "-";
                                                $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                                                if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalperiksa($data->pendaftaran_id)", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", "data-placement" => "left"));
                                                else return "-";
                                            }
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                            ));
                        } else if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) {
                            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'daftarPasien-grid',
                                'dataProvider' => $model->searchPasien(),
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-striped table-condensed',
                                'columns' => array(
                                    array(
                                        'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                                        'name' => 'tgl_pendaftaran',
                                        'type' => 'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                                    ),
                                    array(
                                        'header' => 'No.Rekam Medik',
                                        'type' => 'raw',
                                        'value' => '$data->no_rekam_medik ',
                                    ),
                                    array(
                                        'header' => 'Nama Pasien',
                                        'value' => '$data->namadepan.$data->nama_pasien'
                                    ),
                                    'umur',
                                    array(
                                        'header' => 'Alamat Pasien',
                                        'type' => 'raw',
                                        'value' => '$data->alamat_pasien',
                                    ),
                                    array(
                                        'header' => 'Jenis Kasus Penyakit',
                                        'type' => 'raw',
                                        'value' => '$data->jeniskasuspenyakit_nama',
                                    ),
                                    array(
                                        'header' => 'Rujukan',
                                        'type' => 'raw',
                                        'value' => '(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                                    ),
                                    array(
                                        'header' => 'Jenis Penjamin / Penjamin',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            return $data->carabayar_nama . "/<br>" . $data->penjamin_nama;
                                        }, //'$data->caraBayarPenjamin2',
                                    ),
                                    array(
                                        'header' => 'Ruangan / Kelas Pelayanan',
                                        'type' => 'raw',
                                        'value' => '$data->ruangan_nama' . " / " . 'kelaspelayanan_nama',
                                    ),
                                    // array(
                                    //     'header' => 'Kelas Pelayanan',
                                    //     'name' => 'kelaspelayanan_nama',
                                    // ),
                                    array(
                                        'header' => 'Kamar Ruangan/<br>No. Bed',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            $ad = PasienadmisiT::model()->findByAttributes(array(
                                                'pendaftaran_id' => $data->pendaftaran_id,
                                            ));
                                            if (!empty($ad)) {
                                                $kamar = KamarruanganM::model()->findByPk($ad->kamarruangan_id);
                                                if (!empty($kamar)) {
                                                    return $kamar->kamarruangan_nokamar . "/<br>Bed " . $kamar->kamarruangan_nobed;
                                                }
                                                return "-";
                                            }
                                            return "-";
                                        }
                                    ),
                                    array(
                                        'header' => 'Dokter',
                                        'type' => 'raw',
                                        'value' => '$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                                        // 'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-pencil-brown></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\',\'$data->pasienadmisi_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Dokter Periksa")) . "</div>"',
                                    ),
                                    array(
                                        'header' => 'Status Periksa',
                                        'type' => 'raw',
                                        'value' => '$data->statusperiksa',
                                    ),
                                    array(
                                        'header' => 'Persalinan',
                                        'class' => 'bootstrap.widgets.BootButtonColumn',
                                        'template' => '{lihat}',
                                        'buttons' => array(
                                            'lihat' => array(
                                                'label' => "<i class='icon-form-persalinan'></i>",
                                                'options' => array('title' => 'Persalinan'),
                                                'url' => 'Yii::app()->createUrl("persalinan/persalinanT/index",array("id"=>"$data->pendaftaran_id"))',
                                            ),
                                        ),
                                    ),
                                    array(
                                        'header' => 'Kelahiran',
                                        'class' => 'bootstrap.widgets.BootButtonColumn',
                                        'template' => '{lihat}',
                                        'buttons' => array(
                                            'lihat' => array(
                                                'label' => "<i class='icon-form-kelahiran'></i>",
                                                'options' => array('title' => 'Kelahiran', 'class' => 'kelahiran'),
                                                'url' => 'Yii::app()->createUrl("persalinan/kelahiranbayiT/index",array("id"=>"$data->pendaftaran_id"))',
                                            ),
                                        ),
                                    ),
                                    array(
                                        'name' => 'Pemeriksaan Pasien',
                                        'type' => 'raw',
                                        'value' => 'CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/persalinan/pemeriksaanPasienPersalinan",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'header' => 'Batal Periksa',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            $rd = InfokunjunganrdV::model()->findByAttributes(array(
                                                'pendaftaran_id' => $data->pendaftaran_id
                                            ));

                                            if (!empty($rd)) {
                                                if (($rd->pasienpulang_id != 0) || ($rd->carakeluar != ""))
                                                    return "-";
                                            }

                                            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                                            if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalperiksa($data->pendaftaran_id)", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan"));
                                            else return "-";
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                            ));
                        } else {
                            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'daftarPasien-grid',
                                'dataProvider' => $model->searchPasien(),
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-striped table-condensed',
                                'columns' => array(
                                    // array(
                                    //     'header' => 'No.',
                                    //     'value' => '($this->grid->dataProvider->pagination) ? 
                                    // 		($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    // 		: ($row+1)',
                                    // ),
                                    array(
                                        'header' => 'No. / Tanggal Pendaftaran',
                                        'name' => 'tgl_pendaftaran',
                                        'type' => 'raw',
                                        'value' => '(($this->grid->dataProvider->pagination) ? 
                                                		($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                		: ($row+1))." / ".MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                                    ),
                                    array(
                                        'header' => 'No. Pendaftaran / No. Rekam Medik',
                                        'type' => 'raw',
                                        // 'value' => '$data->noPendaftaranRekammedik',
                                        'value' => function ($data) {
                                            $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                            $html = $data->noPendaftaranRekammedik; 
                                            if(!empty($pendaftaran) && $pendaftaran->isbacahakpasien == true){
                                                $html .= "<br/>";
                                                $html .= CHtml::Link("<i class=icon-form-detail></i> <br/> Hak & Kewajiban",Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRJ/hakKewajiban",array("pendaftaran_id"=>$data->pendaftaran_id)),
                                                            array("class"=>"", 
                                                                "target"=>"iframeHakKewajiban",
                                                                "onclick"=>"$(\"#dialogHakKewajiban\").dialog(\"open\");",
                                                                "rel"=>"tooltip",
                                                                "title"=>"Klik Lihat Hak & Kewajiban",
                                                    ));
                                            }
                                            
                                            return $html;
                                        },
                                    ),
                                    array(
                                        'header' => 'Nama Pasien / Panggilan',
                                        'value' => '$data->namaNamaBin'
                                    ),
                                    array(
                                        'header' => 'Tanggal Lahir',
                                        'name' => 'tanggal_lahir',
                                        'type' => 'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)'
                                    ),
                                    array(
                                        'header' => 'Jenis Penjamin / Penjamin',
                                        'type' => 'raw',
                                        //'value'=>'$data->caraBayarPenjamin2',
                                        'value' => function ($data) {
                                            return $data->carabayar_nama . "/<br>" . $data->penjamin_nama;
                                        },
                                    ),
                                    array(
                                        'header' => 'Ruangan / Kelas Pelayanan',
                                        'type' => 'raw',
                                        'value' => '$data->ruangan_nama."/".$data->kelaspelayanan_nama',
                                    ),
                                    // array(
                                    //     'header' => 'Kelas Pelayanan',
                                    //     'name' => 'kelaspelayanan_nama',
                                    // ),
                                    array(
                                        'header' => 'Cara Masuk / Transportasi',
                                        'type' => 'raw',
                                        'value' => '$data->caraMasukTransportasi',
                                    ),
                                    array(
                                        'header' => 'Dokter / Rujukan / PPDS',
                                        'type' => 'raw',
                                        'value' =>
                                         function ($data) {
                                            echo $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama;
                                            echo (!empty($data->asalrujukan_nama)) ? $data->asalrujukan_nama : "-";
                                            echo "<br>";  echo "<br>";

                                          if(Yii::app()->user->getState('isppds')) {
                                            echo CHtml::link(
                                                '<i class="icon-pencil-brown"></i>Tambah PPDS',
                                                    Yii::app()->controller->createUrl(Yii::app()->controller->id . "/create", array("pendaftaran_id" => $data->pendaftaran_id)),
                                                    array("title" => "Klik untuk Tambah PPDS", "target" => "iframeDetailPPDS", "onclick" => '$("#dialogDetailPPDS").dialog("open");', "rel" => "tooltip")
                                                );
                                                $ppds = PasienPpdsT::model()->findAllByAttributes(array(
                                                    'pendaftaran_id' => $data->pendaftaran_id
                                                ));

                                                $itemz ='';      
                                                $x =1;   
                                                
                                                foreach($ppds as $itemz){
                                                    echo '<br>';
                                                    echo '<i class="icon-pencil-brown"></i>PPDS &nbsp;',$x++.'-'.$itemz->ppds->ppds_nama;
                                                }
                                        
                                            } 
                                        
                                        }
                                        
                                        // 'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-pencil-brown></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\',\'$data->pasienadmisi_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Dokter Periksa")) . "</div>"',
                                    ),
                                    // array(
                                    //     'header' => 'Rujukan',
                                    //     'type' => 'raw',
                                    //     'value' => '(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                                    // ),
                                    array(
                                        'header' => 'Nama Jenis Kasus Penyakit',
                                        'type' => 'raw',
                                        'value' => '$data->jeniskasuspenyakit_nama',
                                    ),
                                    array(
                                        'header' => 'Alamat Pasien',
                                        'type' => 'raw',
                                        'value' => '$data->alamat_pasien',
                                    ),
                                    array(
                                        'header' => 'Status Periksa',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            //return Params::getWrStatusPeriksa($data->statusperiksa);
                                            return $data->getStatus($data->statusperiksa, $data->pendaftaran_id, $data);
                                        },
                                    ),
                                    array(
                                        'header' => 'Pemeriksaan Partograf',
                                        'type' => 'raw',
                                        'value' => function($data) {
                                            $link = CHtml::link('<i class="icon-form-detail"></i> ', Yii::app()->createUrl("/persalinan/partografPasien/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Partograf Pasien"));
                                            return $link;
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                                    ),
                                    array(
                                        'header' => 'Persalinan',
                                        /*'class'=>'bootstrap.widgets.BootButtonColumn',
												'template'=>'{lihat}',
												'buttons'=>array(
													'lihat' => array (
														'label'=>"<i class='icon-form-persalinan'></i>",
														'options'=>array('title'=>'Persalinan'),
														'url'=>'Yii::app()->createUrl("persalinan/persalinanT/index",array("id"=>"$data->pendaftaran_id"))',                            
													),
												),*/
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            // if ($data->statusperiksa == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP) {
                                            //     return CHtml::link("<i class='icon-form-persalinan'></i>", 'javascript:;', array('onclick' => 'myAlert("Anda tidak dapat melanjutkan transaksi ini, karena status pasien ' . $data->statusperiksa . ' ")'));
                                            // } else {
                                                return CHtml::link("<i class='icon-form-persalinan'></i>", Yii::app()->createUrl("persalinan/persalinanT/index", array("id" => "$data->pendaftaran_id")), array('onclick' => 'return cekPegawai(); return false;'));
                                            // }
                                        }
                                    ),
                                    array(
                                        'header' => 'Kelahiran',
                                        'type' => 'raw',
                                        /*'class'=>'bootstrap.widgets.BootButtonColumn',
												'template'=>'{lihat}',
												'buttons'=>array(
													'lihat' => array (
														'label'=>"<i class='icon-form-kelahiran'></i>",
														'options'=>array('title'=>'Kelahiran', 'class'=>'kelahiran'),
														'url'=>'Yii::app()->createUrl("persalinan/kelahiranbayiT/index",array("id"=>"$data->pendaftaran_id"))',                            
													),
												),*/
                                        'value' => function ($data) {

                                            $kelBayi = KelahiranbayiT::model()->findAllByAttributes(array('persalinan_id' => $data->persalinan_id));

                                            $link_kelahiran = CHtml::link("<i class='icon-form-kelahiran'></i>", Yii::app()->createUrl("persalinan/kelahiranbayiT/index", array("id" => $data->pendaftaran_id)), array('title' => 'kelahiran', 'class' => 'kelahiran'));

                                            if (count((array)$kelBayi) == 0) {

                                                // if ($data->statusperiksa == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP) {
                                                //     return CHtml::link("<i class='icon-form-kelahiran'></i>", 'javascript:;', array('onclick' => 'myAlert("Anda tidak dapat melanjutkan transaksi ini, karena status pasien ' . $data->statusperiksa . ' ")'));
                                                // } else {
                                                    return $link_kelahiran;
                                                // }
                                            } else {
                                                echo $link_kelahiran . CHtml::link(
                                                    '<i class="icon-form-detail"></i>',
                                                    Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailKelahiranBayiMain", array("persalinan_id" => $data->persalinan_id)),
                                                    array(
                                                        "target" => "frameDetailKelahiran",
                                                        "onclick" => "$('#dialogDetailKelahiran').dialog('open');",
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk melihat detail kelahiran",
                                                    )
                                                );
                                            }
                                        }
                                    ),
                                    array(
                                        'name' => 'Pemeriksaan Pasien',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            if ($data->statusperiksa == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP || $data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO || $data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                                return CHtml::link("<i class='icon-form-periksa'></i> ", 'javascript:;', array('onclick' => 'myAlert("Anda tidak dapat melanjutkan transaksi ini, karena status pasien ' . $data->statusperiksa . ' ")'));
                                            } else {
                                                return CHtml::link("<i class='icon-form-periksa'></i> ", Yii::app()->controller->createUrl("/persalinan/pemeriksaanPasienPersalinan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
                                            }
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'name' => 'Riwayat Vaksinasi/Imunisasi',
                                        'type' => 'raw',
                                        // 'value' => '',
                                        'value' => function ($data) {
                                            return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                                                'pendaftaran_id'=>$data->pendaftaran_id,
                                            )), array(
                                                'target'=>'frameRiwayatVaksinasi',
                                                'onclick'=>"$('#dialogRiwayatVaksinasi').dialog('open');",
                                            ));
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    // array(
                                    //     'name' => 'Persetujuan',
                                    //     'type' => 'raw',
                                    //     'value' => function ($data) {

                                    //         $link = CHtml::link('<i class="icon-form-ubah"></i><br>Tindakan', Yii::app()->controller->createUrl("PersetujuanTindakanTPS/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan"));
                                    //         $link .= CHtml::link('<i class="icon-form-ubah"></i><br>Inform Consent', Yii::app()->controller->createUrl("PersetujuanTindakanUmumPS/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Persetujuan)"));
                                    //         $link .= CHtml::link('<br><i class="icon-form-ubah"></i><br>Anastesi', Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiPS/index", array("pendaftaran_id" => $data->pendaftaran_id, "noframe" => 1)), array("id" => $data->no_pendaftaran . "_antrian", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan anastesi"));

                                    //         return $link;
                                    //     },
                                    //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    // ),
                                    // array(
                                    //     'name' => 'Penolakan',
                                    //     'type' => 'raw',
                                    //     'value' => function ($data) {

                                    //         $link = CHtml::link('<i class="icon-form-silang"></i><br>Tindakan ', Yii::app()->controller->createUrl("PersetujuanTindakanTPS/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan"));
                                    //         $link .= CHtml::link('<i class="icon-form-silang"></i><br>Inform Refusal', Yii::app()->controller->createUrl("PersetujuanTindakanUmumPS/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Penolakan)"));
                                    //         $link .= CHtml::link('<i class="icon-form-silang"></i><br>Anastesi', Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiPS/penolakan", array("pendaftaran_id" => $data->pendaftaran_id, "noframe" => 1)), array("id" => $data->no_pendaftaran . "_antrian", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan anastesi"));

                                    //         return $link;
                                    //     },
                                    //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    // ),
                                    // array(
                                    //     'name' => 'Penolakan',
                                    //     'type' => 'raw',
                                    //     'value' => '(CHtml::link("<i class=\'icon-form-silang\'></i><br>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanUmumPS/penolakan",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat penolakan tindakan")))."<br>"'
                                    //         . '.(CHtml::link("<i class=\'icon-form-silang\'></i><br>Anastesi", Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiPS/penolakan",array("pendaftaran_id"=>$data->pendaftaran_id, "noframe"=>1)),array("id"=>$data->no_pendaftaran."_antrian","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat penolakan tindakan anastesi")))',
                                    //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    // ),
                                    // array(
                                    //     'header' => 'Detail Persetujuan & Penolakan',
                                    //     'type' => 'raw',
                                    //     'value' => function ($data) {

                                    //         $str = "";

                                    //         $umum = SuratpersetujuanumumT::model()->findByAttributes(array(
                                    //             'pendaftaran_id' => $data->pendaftaran_id,
                                    //         ));
                                    //         if (!empty($umum)) {
                                    //             $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>General<br>Consent", Yii::app()->controller->createUrl('suratPersetujuanUmumPS/view', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameGeneralConsent", "rel" => "tooltip", "title" => "Klik untuk melihat General Consent", "onclick" => "$('#dialogGeneralConsent').dialog('open');"));
                                    //         }

                                    //         $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Detail Persetujuan <br>& Penolakan", Yii::app()->controller->createUrl('pencarianPasienPS/detailPersetujuanTindakan', array('id' => $data->pendaftaran_id)), array("target" => "framePersetujuanTindakan", "rel" => "tooltip", "title" => "Klik untuk melihat Detail Persetujuan & Penolakan", "onclick" => "$('#dialogPersetujuanTindakan').dialog('open');"));
                                    //         $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Inform<br>Consent", Yii::app()->controller->createUrl('pencarianPasienPS/detailInformConsent', array('id' => $data->pendaftaran_id)), array("target" => "frameInformConsent", "rel" => "tooltip", "title" => "Klik untuk melihat Inform Consent", "onclick" => "$('#dialogInformConsent').dialog('open');"));
                                    //         $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Anestesi", Yii::app()->controller->createUrl('pencarianPasienPS/detailTindakanAnestesi', array('id' => $data->pendaftaran_id)), array("target" => "frameTindakanAnestesi", "rel" => "tooltip", "title" => "Klik untuk melihat Persetujuan Tindakan Anestesi", "onclick" => "$('#dialogTindakanAnestesi').dialog('open');"));

                                    //         return $str;
                                    //     },
                                    //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    // ),

                                    /*array(
												'header'=>'Tindak Lanjut',
												'type'=>'raw',
												'value'=>'(($data->pasienpulang_id != "") OR ($data->carakeluar_nama != "")) ? $data->carakeluar_nama : 
													$data->getTindakLanjut($data->statusperiksa,$data->pendaftaran_id,$data->no_pendaftaran,$data->pasienpulang_id,$data->carakeluar_id,$data->alihstatus)',
												'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
											),*/
                                    array(
                                        'header' => 'Tindak Lanjut',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            if (!empty($data->konsulpoli_id)) {
                                                return "PASIEN KONSUL";
                                            }

                                            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                                            if (!empty($admisi)) {
                                                $kamar = empty($admisi->kamarruangan_id) ? "" : ($admisi->kamarruangan->kamarruangan_nokamar . "<br>" . $admisi->kamarruangan->kamarruangan_nobed);
                                                $ruangan = empty($admisi->ruangan_id) ? "" : $admisi->ruangan->ruangan_nama;

                                                return $ruangan . "</br>" . $kamar;
                                            }
                                            if (($data->pasienpulang_id != '') or ($data->carakeluar_nama != "")) {

                                                // $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                                                if (!empty($admisi)) {
                                                    $kamar = empty($admisi->kamarruangan_id) ? "" : ($admisi->kamarruangan->kamarruangan_nokamar . "<br>" . $admisi->kamarruangan->kamarruangan_nobed);
                                                    $ruangan = empty($admisi->ruangan_id) ? "" : $admisi->ruangan->ruangan_nama;

                                                    return $ruangan . "</br>" . $kamar;
                                                } else {
                                                    $pemPel = PembayaranpelayananT::model()->find("pendaftaran_id = '" . $data->pendaftaran_id . "'  and orderbatalpembayaranpelayanan_id is null");
                                                    if (empty($pemPel)) {
                                                        $pen = PendaftaranT::model()->findByPk($data->pendaftaran_id);

                                                        if (!empty($pen->pasienpulang_id)) {
                                                            return "Pasien di Rawat Inap" . CHtml::link("<i class='icon-form-silang'></i>", Yii::app()->createUrl("/rawatDarurat/DaftarPasien/BatalRawatInap", array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Batal Proses Tindak Lanjut Pasien", "target" => "iframeBatalRawatInap", "onclick" => "$('#dialogBatalRawatInap').dialog('open');", "rel" => "tooltip"));
                                                        } else {
                                                            return CHtml::link(
                                                                '<icon class="icon-form-ri"></icon>',
                                                                '#',
                                                                array(
                                                                    "target" => "iframePasienPulang",
                                                                    "onclick" => "cekVerifikasiTindakLanjut(this,'" . $data->pendaftaran_id . "'); return false;",
                                                                    "rel" => "tooltip",
                                                                    "title" => "Klik untuk menambahkan tindak lanjut",

                                                                )
                                                            );
                                                        }
                                                    } else {
                                                        return $data->carakeluar_nama . CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;', array("title" => "Klik untuk Batal Proses Tindak Lanjut Pasien", "onclick" => "alert('Maaf, Pembayaran Pada Pasien ini Belum Dibatalkan')", "rel" => "tooltip"));
                                                    }
                                                }
                                            } else {
                                                if ($data->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
                                                    return "-";
                                                }

                                                return CHtml::link(
                                                    '<icon class="icon-form-ri"></icon>',
                                                    Yii::app()->createUrl("/rawatDarurat/daftarPasien/PasienPulang", array("pendaftaran_id" => $data->pendaftaran_id, "dialog" => true)),
                                                    array(
                                                        "target" => "iframePasienPulang",
                                                        "onclick" => "cekVerifikasiTindakLanjut(this,'" . $data->pendaftaran_id . "'); return false;",
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk menambahkan tindak lanjut",

                                                    )
                                                );
                                            }
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                        //'(($data->pasienpulang_id != 0) OR ($data->carakeluar != "")) ? $data->carakeluar : 
                                    ),
                                    /*	
											array(
												'name'=>'Tindak Lanjut<br>ke Rawat Inap',
												'type'=>'raw',
												'value'=>function($data){
													if ($data->statusperiksa == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP){
														return "Pasien di Rawat Inap".CHtml::link("<i class='icon-form-silang'></i>", 
															'javascript:;', 
															array(
																"title"=>"Klik untuk Batal Proses Tindak Lanjut Pasien",
																"target"=>"iframeBatalRawatInap", 
																"onclick"=>'myAlert("Anda tidak dapat melanjutkan transaksi ini, karena status pasien '.$data->statusperiksa.' ")', 
																"rel"=>"tooltip"
														));
													}else{
														if (!empty($data->pasienpulang_id)){
															return "Pasien di Rawat Inap".CHtml::link("<i class='icon-form-silang'></i>", Yii::app()->createUrl("/rawatDarurat/DaftarPasien/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$('#dialogBatalRawatInap').dialog('open');", "rel"=>"tooltip"));
														}elseif($data->statusperiksa==Params::STATUSPERIKSA_BATAL_PERIKSA){
															return "";
														}else{
															return CHtml::link("<i class='icon-user'></i>", Yii::app()->createUrl("/rawatJalan/DaftarPasien/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id)),array("class"=>"",
																"target"=>"frameTindakLanjut",
																"rel"=>"tooltip",
																"title"=>"Klik untuk Proses Tindak Lanjut Pasien",
																"onclick"=>"$('#dialogTindakLanjut').dialog('open');"));
														}
													}
												},
												'htmlOptions'=>array('style'=>'text-align: center; width:60px')
											),
											 * */
                                    array(
                                        'header' => 'Catatan Edukasi',
                                        'type' => 'raw',
                                        'value' => function($data) {
                                            return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('/persalinan/catatanEdukasiPS/create', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                                                'rel'=>'tooltip',
                                                'title'=>'Catatan Edukasi Pasien',
                                            ));
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                                    ),
                                    array(
                                        'name'=>'Catatan Perkembangan Pasien Terintegrasi (CPPT)',
                                        'type'=>'raw',
                                        'value'=>function($data) {
                                            return CHtml::link('<i class="icon-form-detail"></i> ', Yii::app()->createUrl("/persalinan/CPPTPS/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Catatan Perkembangan Pasien Terintegrasi (CPPT)"));
                                        },
                                        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),        
                                    array(
                                        'header' => 'Pemindahan Pasien',
                                        'type' => 'raw',
                                        'value' => function($data) {
                                            $htmlLink = CHtml::link('<i class="icon-form-detail"></i><br>Transfer', Yii::app()->createUrl('/persalinan/pemindahanPasienPS/index', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                                                'rel'=>'tooltip',
                                                'title'=>'Pemindahan Pasien',
                                            ));
                            
                                            $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id'=>Yii::app()->user->getState("ruangan_id"),'pendaftaran_id'=>$data->pendaftaran_id),array('condition'=>'(ispasienditerima IS NULL OR ispasienditerima = false)'));
                                            $linkPenerima = "";
                                            if(isset($modFormTransfer) && count($modFormTransfer) > 0){
                                                $linkPenerima = CHtml::link('<i class="icon-form-check"></i> ', Yii::app()->createUrl("/persalinan/pemindahanPasienPS/index",array("pendaftaran_id"=>$data->pendaftaran_id,'pasienditerima'=>'diterima')),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Penerimaan Pemindahaan Pasien"));
                                            }

                                            $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));
                                            if (!empty($modPemindahanPasien)) {
                                                $linkLihat = CHtml::link(
                                                    '<icon class="icon-form-detail"></icon><br>Lihat Transfer',
                                                    $this->createUrl("/persalinan/pemindahanPasienPS/detail", array("pemindahanpasien_id" => $modPemindahanPasien->pemindahanpasien_id)),
                                                    array(
                                                        "target" => "frameDetail",
                                                        "onclick" => "$('#dialogDetail').dialog('open');",
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                            
                                                    )
                                                );
                                            } else {
                                                $linkLihat = "";
                                            }
                            
                                            return $htmlLink .'<br/>'.$linkPenerima.'<br/>'.$linkLihat;
                                        },
                                        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),
                                    // array(
                                    //     'header' => 'Catatan Pemindahan Pasien',
                                    //     'type' => 'raw',
                                    //     'value' => function ($data) {
                                    //         $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));
                                    //         if (!empty($modPemindahanPasien)) {
                                    //             return CHtml::link(
                                    //                 '<icon class="icon-form-detail"></icon>',
                                    //                 $this->createUrl("/persalinan/pemindahanPasienPS/detail", array("pemindahanpasien_id" => $modPemindahanPasien->pemindahanpasien_id)),
                                    //                 array(
                                    //                     "target" => "frameDetail",
                                    //                     "onclick" => "$('#dialogDetail').dialog('open');",
                                    //                     "rel" => "tooltip",
                                    //                     "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                            
                                    //                 )
                                    //             );
                                    //         } else {
                                    //             return "";
                                    //         }
                                    //     },
                                    //     'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                                    // ),        
                                    array(
                                        'header' => 'Status Dokumen',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            $status_dokumen = PSPendaftaranT::model()->findByPk($data->pendaftaran_id);
                                            $dok =   CHtml::link("<icon class='icon-file' style='font-size:48px;'></icon><br>File Rekam Medik<br>", Yii::app()->controller->createUrl('DaftarPasien/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medik", "onclick" => "$('#dialogDokFilerm').dialog('open');"));

                                            // if ($status_dokumen->statusdokrm == "SUDAH DITERIMA") {

                                            //     if ($status_dokumen->pengirimanrm->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')) {

                                            //         if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                                            //             return CHtml::link(
                                            //                 "<i></i> $status_dokumen->statusdokrm",
                                            //                 Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $status_dokumen->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
                                            //                 array(
                                            //                     "class" => "btn btn-primary",
                                            //                     "target" => "frameStatusDokumen",
                                            //                     "rel" => "tooltip",
                                            //                     "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                            //                     "onclick" => 'myConfirm("Pasien Masih Dalam Status Menunggu Admisi. Apakah Anda akan melanjutkan transaksi?","Perhatian",function(r){if(r){$("#dialogStatusDokumen").dialog("open")}});'
                                            //                 )
                                            //             ).'<br><br>'.$dok;
                                            //         } else {
                                            //             return CHtml::link(
                                            //                 "<i></i> $status_dokumen->statusdokrm",
                                            //                 Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $status_dokumen->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
                                            //                 array(
                                            //                     "class" => "btn btn-primary",
                                            //                     "target" => "frameStatusDokumen",
                                            //                     "rel" => "tooltip",
                                            //                     "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                            //                     "onclick" => '$("#dialogStatusDokumen").dialog("open");'
                                            //                 )
                                            //             ).'<br><br>'.$dok;
                                            //         }
                                            //     } else {
                                            //         return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id).'<br><br>'.$dok;
                                            //     }
                                            // } else {
                                            //     return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id).'<br><br>'.$dok;
                                            // }
                                            return $dok;
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                    array(
                                        'header' => 'Batal Periksa',
                                        'type' => 'raw',
                                        'value' => function ($data) {

                                            if (!empty($data->konsulpoli_id)) {
                                                return "-";
                                            }

                                            $rd = InfokunjunganpersalinanV::model()->findByAttributes(array(
                                                'pendaftaran_id' => $data->pendaftaran_id
                                            ));


                                            $pen = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                            $cekDok = false;

                                            if (!empty($pen->pengirimanrm_id)) {
                                                if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
                                                    if (empty($pen->pengirimanrm->tglterimadokrm)) {
                                                        return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap terima dan kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                                                    } else {
                                                        return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                                                    }
                                                } else {
                                                    $cekDok = true;
                                                }
                                            } else {
                                                $cekDok = true;
                                            }

                                            if ($cekDok) {
                                                if (($rd->pasienpulang_id != 0) || ($rd->carakeluar_nama != ""))
                                                    return "-";

                                                $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                                                //if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan","data-placement"=>"left"));
                                                //else return "-";
                                                if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', 'javascript:dialogBatalPeriksaRd(' . $data->pendaftaran_id . ',"' . $data->statusperiksa . '","' . $data->nama_pasien . '")', array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", "data-placement" => "left"));
                                                else return "-";
                                            }
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                            ));
                        }
                        ?>
                 </div>
                 <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                        'id' => 'dialogRincian',
                        'options' => array(
                            'title' => 'Rincian Tagihan Pasien',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 900,
                            'resizable' => false,
                        ),
                    )); ?>
                 <iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
                 <?php $this->endWidget(); ?>

             </div>
         </div>
     </div>
 </div>

 <?php echo $this->renderPartial("_dialogPersetujuan", array(), true); ?>

 <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Riwayat Peminahaan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'height' => 550,
            'resizable' => false
        ),
    ));
    ?>
	<iframe name='frameDetail' width="100%" height="98%"></iframe>
	<?php $this->endWidget(); ?>

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
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokFilerm',
    'options' => array(
        'title' => 'Riwayat Dokumen File Rekam Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

 <?php
    // Dialog untuk pasienpulang_t =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogPasienPulang',
        'options' => array(
            'title' => 'Tindak Lanjut Pasien Persalinan',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 1000,
            'height' => 600,
            'resizable' => false,
        ),
    )); ?>
 <iframe src="" id="iframePasienPulang" name="iframePasienPulang" width="100%" height="900">
 </iframe>
 <?php

    $this->endWidget();
    //========= end pasienpulang_t dialog =============================

    // Dialog untuk Batal Rawat Inap =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogBatalRawatInap',
        'options' => array(
            'title' => 'Pembatalan Rawat Inap/ Pulang Pasien Rawat Darurat',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'resizable' => false,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
						data: $('#daftarPasien-form').serialize()
					}); }",
        ),
    ));
    ?>
 <iframe src="" name="iframeBatalRawatInap" width="100%" height="900">
 </iframe>
 <?php

    $this->endWidget();
    //========= end ubah status periksa dialog =============================
    ?>
 <?php
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogTindakLanjut',
        'options' => array(
            'title' => 'Tindak Lanjut Rawat Inap',
            'autoOpen' => false,
            'modal' => true,
            'width' => 950,
            'height' => 550,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
						data: $('#daftarPasien-form').serialize()
					}); }",
        ),
    ));
    ?>
 <iframe name='frameTindakLanjut' style="width: 100%; height: 98%;"></iframe>
 <?php $this->endWidget(); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailPPDS',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">PPDS</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'height' => 570,
        'resizable' => true
    ),
));
?>
<iframe name='iframeDetailPPDS' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>


 <?php
    // ===========================Dialog Batal Periksa=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'DialogBatalperiksa_rd',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Batal Periksa - <span id="titleNamaPasienBatal_rd"></span>',
            'autoOpen' => false,
            'show' => 'blind',
            'hide' => 'explode',
            'zIndex' => 1002,
            'minWidth' => 500,
            'minHeight' => 100,
            'resizable' => false,
            'modal' => true,
        ),
    ));
    $this->renderPartial('_formBatalPeriksaDialog');

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Batal Periksa================================
    ?>

 <script>
     function batalperiksa(pendaftaran_id) {
         myConfirm("Anda yakin akan membatalkan pemeriksaan/persalinan pasien ini?", "Perhatian!", function(r) {
             if (r) {
                 $.ajax({
                     type: 'POST',
                     url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPeriksa'); ?>',
                     data: {
                         pendaftaran_id: pendaftaran_id
                     }, //
                     dataType: "json",
                     success: function(data) {
                         if (data.status == true) {
                             myAlert(data.pesan);
                             $.fn.yiiGridView.update('daftarPasien-grid', {
                                 data: $(this).serialize()
                             });
                         } else if (data.pesan == 'exist') {
                             myAlert('Pasien telah melakukan pemeriksaan');
                         } else {
                             myAlert(data.pesan);
                         }
                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                         console.log(errorThrown);
                     }
                 });
             }
         });
     }
     // document.getElementById('PSInfokunjunganpersalinanV_tgl_awal_date').setAttribute("style","display:none;");
     // document.getElementById('PSInfokunjunganpersalinanV_tgl_akhir_date').setAttribute("style","display:none;");
     function cekTanggal() {

         var checklist = $('#PSInfokunjunganpersalinanV_ceklis');
         var pilih = checklist.attr('checked');
         if (pilih) {
             document.getElementById('PSInfokunjunganpersalinanV_tgl_awal_date').setAttribute("style", "display:block;");
             document.getElementById('PSInfokunjunganpersalinanV_tgl_akhir_date').setAttribute("style", "display:block;");
         } else {
             document.getElementById('PSInfokunjunganpersalinanV_tgl_awal_date').setAttribute("style", "display:none;");
             document.getElementById('PSInfokunjunganpersalinanV_tgl_akhir_date').setAttribute("style", "display:none;");
         }
     }

     function addPasienPulang(pendaftaran_id, pasien_id) {
         $('#pendaftaran_id').val(pendaftaran_id);
         $('#pasien_id').val(pasien_id);

         <?php
            echo CHtml::ajax(array(
                'url' => $this->createUrl('addPasienPulang'),
                'data' => "js:$(this).serialize()",
                'type' => 'post',
                'dataType' => 'json',
                'success' => "function(data)
			{
				if (data.status == 'create_form')
				{
					$('#dialogPasienPulang div.divForForm').html(data.div);
					$('#dialogPasienPulang div.divForForm form').submit(addPasienPulang);

					jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
					jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','minDate'  : 'd','timeText':'Waktu','hourText':'Jam',
						 'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));

				}
				else
				{
					$('#dialogPasienPulang div.divForForm').html(data.div);
					$.fn.yiiGridView.update('daftarPasien-grid');
					setTimeout(\"$('#dialogPasienPulang').dialog('close') \",1000);
				}

			} ",
            ))
            ?>;
         return false;
     }

     function cekStatus(status) {
         var status = status;
         myAlert("Pasien " + status + " Tidak bisa melanjutkan pemeriksaan atau tindak lanjut");
     }
 </script>

 <?php
    $urlSession = $this->createUrl('buatSessionPendaftaranPasien');
    $urlPasienRujukRI = Yii::app()->createUrl('daftarPasien/PasienRujukRI');
    $urlFormulirBayi = $this->createUrl('FormuliIdentitasBayiCapJari');

    $jscript = <<< JS
function buatSession(pendaftaran_id,pasien_id)
{
	$.post("${urlSession}", { pendaftaran_id: pendaftaran_id,pasien_id: pasien_id },
		function(data){
			'sukses';
	}, "json");
}

function printFormulirBayi(kelahiranbayi_id)
{
   window.open('${urlFormulirBayi}&kelahiranbayi_id='+kelahiranbayi_id,'printwin','left=100,top=100,width=1000,height=1000');    
}
JS;
    Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
    ?>

 <?php
    $jscript = <<< JS
function tindakLanjutRI(pendaftaran_id)
{
	$('#dialogRujukanRI').dialog('open');
	$('#pendaftaran_id').val(pendaftaran_id);
}

function simpanPasienPulang()
{
	pendaftaran_id=$('#pendaftaran_id').val();
	myAlert(pendaftaran_id);
	$.post("${urlPasienRujukRI}", { pendaftaran_id: pendaftaran_id},
		function(data){
		myAlert(data.pesan);
		$('#dialogRujukanRI').dialog('close')
	}, "json");
}

JS;
    Yii::app()->clientScript->registerScript('rujukKerawatInap', $jscript, CClientScript::POS_HEAD);

    // ===========================Dialog Rujukan ke RI=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogRujukanRI',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Konfirmasi',
            'autoOpen' => false,
            'width' => 500,
            'resizable' => false,
            //                        'hide'=>explode,    
        ),
    ));
    ?>
 <div style="text-align: center;">Anda Yakin Akan Melakukan Tindak Lanjut Ke Rawat Inap ?
     <br>
     <?php echo CHtml::hiddenField('pendaftaran_id'); ?>
     <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanPasienPulang()')); ?>
     <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tidak', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => '$(\'#dialogRujukanRI\').dialog(\'close\')')); ?>

 </div>
 <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Rujukan ke RI================================

    ?>
 <?php
    //======================= Edit Dokter Periksa ======================= 
    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'editDokterPeriksa',
            'options' => array(
                'title' => 'Ganti Dokter Periksa',
                'autoOpen' => false,
                'minWidth' => 500,
                'modal' => true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaranDP', '', array('readonly' => true));
    echo CHtml::hiddenField('temp_idPasienadmisiDP', '', array('readonly' => true));
    echo '<div class="divForFormEditDokterPeriksa"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>

 <script>
     function cekVerifikasiTindakLanjut(obj, id) {
         $.post('<?php echo $this->createUrl('verifikasiTindakLanjut') ?>', {
             id: id
         }, function(data) {
             if (data.ok == 1) {

                 console.log('<?php echo Yii::app()->controller->createUrl("/rawatDarurat/daftarPasien/PasienPulang"); ?>&pendaftaran_id=' + id +
                     '&dialog=1');

                 $("#iframePasienPulang").prop('src', '<?php echo Yii::app()->controller->createUrl("/rawatDarurat/daftarPasien/PasienPulang"); ?>&pendaftaran_id=' + id +
                     '&dialog=1');
                 $("#dialogPasienPulang").dialog('open');
             } else {

                 if (data.is_confirm == 1) {
                     myConfirm(data.msg, "Peringatan", function(r) {
                         if (r) {
                             $("#iframePasienPulang").prop('src', '<?php echo Yii::app()->controller->createUrl("/rawatDarurat/daftarPasien/pasienPulang"); ?>&pendaftaran_id=' + id +
                                 '&dialog=1');
                             $("#dialogPasienPulang").dialog('open');
                         }
                     });
                 } else {
                     myAlert(data.msg);
                 }
             }
         }, 'json');
     }

     function ubahDokterPeriksa(pendaftaran_id, pasienadmisi_id) {
         $('#temp_idPendaftaranDP').val(pendaftaran_id);
         $('#temp_idPasienadmisiDP').val(pasienadmisi_id);
         jQuery.ajax({
             'url': '<?php echo $this->createUrl('ubahDokterPeriksa') ?>',
             'data': $(this).serialize(),
             'type': 'post',
             'dataType': 'json',
             'success': function(data) {
                 if (data.status == 'create_form') {
                     $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                     $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
                 } else {
                     $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                     $.fn.yiiGridView.update('daftarPasien-grid', {
                         data: $('form').serialize()
                     });
                     setTimeout("$('#editDokterPeriksa').dialog('close') ", 500);
                 }
             },
             'cache': false
         });
         return false;
     }

     function cekPegawai() {
         var pegawai_id = "<?php echo Yii::app()->user->getState('pegawai_id'); ?>";

         if (pegawai_id != '') {
             return true
         } else {
             myAlert("Maaf, <b>Nama Pemakai (user login)</b> Anda tidak bisa untuk melakukan transaksi ini. <br> <b>'Mohon untuk menghubungi Sistem Administrator'</b>");
             return false;
         }
     }

     function verifikasiKirimanRM(id, kirimrm) {
         myConfirm('Yakin untuk Menerima Dokumen Rekam Medis Pasien? ', 'Perhatian!', function(r) {
             if (r) {
                 $.post('<?php echo $this->createUrl('terimaDokumen'); ?>', {
                     pendaftaran_id: id,
                     pengirimanrm_id: kirimrm
                 }, function(data) {
                     if (data.sukses != 0) {
                         if (data.status == 'proses_form') {
                             //$('#dialogStatusDokumen div.divForForm').html(data.div);
                             $.fn.yiiGridView.update('daftarPasien-grid');
                             //setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
                         }
                     } else {
                         alert(data.pesan);
                     }
                 }, 'json');
             } else {
                 preventDefault();
             }
         });
     }

     function setStatus(obj, status, pendaftaran_id) {
         var status = status;
         var pendaftaran_id = pendaftaran_id;

         myConfirm(' Yakin Akan Merubah Status Periksa Pasien? ', 'Perhatian!', function(r) {
             if (r) {
                 $.post('<?php echo $this->createUrl('UbahStatusPeriksaPasien'); ?>', {
                     status: status,
                     pendaftaran_id: pendaftaran_id
                 }, function(data) {
                     if (data.status == 'proses_form') {
                         //$('#dialogUbahStatusPasien div.divForForm').html(data.div);
                         $.fn.yiiGridView.update('daftarPasien-grid');
                         setTimeout("$('#dialogUbahStatus').dialog('close')", 1000);
                     } else {
                         myAlert(data.pesan);
                     }
                 }, 'json');
             } else {
                 preventDefault();
             }
         });
     }

     /**
      * 
      * @param {type} pendaftaran_id
      * @param {type} statusperiksa
      * @param {type} namaPasien
      * @returns {undefined}
      */
     function dialogBatalPeriksaRd(pendaftaran_id, statusperiksa, namaPasien) {
         $('#titleNamaPasienBatal_rd').html(namaPasien);
         $('#DialogBatalperiksa_rd #pendaftaran_id_rd').val(pendaftaran_id);
         $('#DialogBatalperiksa_rd #statusperiksa_rd').val(statusperiksa);
         $('#DialogBatalperiksa_rd').dialog('open');
     }

     function ubahPeriksaKarenaBatal() {
         var pendaftaran_id = $('#DialogBatalperiksa_rd #pendaftaran_id_rd').val();
         var tglbatal = $('#DialogBatalperiksa_rd #tglbatal_rd').val();
         var keterangan_batal = $('#DialogBatalperiksa_rd #keterangan_batal_rd').val();

         $('#DialogBatalperiksa_rd #keterangan_batal_rd').attr('class', '');
         if (keterangan_batal == '') {
             myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
             $('#DialogBatalperiksa_rd #keterangan_batal_rd').attr('class', 'error');
             return false;
         }

         $.ajax({
             type: 'POST',
             url: '<?php echo $this->createUrl('batalPeriksa'); ?>',
             data: {
                 pendaftaran_id: pendaftaran_id,
                 tglbatal: tglbatal,
                 keterangan_batal: keterangan_batal
             }, //
             dataType: "json",
             success: function(data) {
                 if (data.status == true) {
                     myAlert(data.pesan);
                     $('#DialogBatalperiksa_rd').dialog('close');
                     $.fn.yiiGridView.update('daftarPasien-grid', {
                         data: $(this).serialize()
                     });
                 } else if (data.pesan == 'exist') {
                     myAlert('Pasien telah melakukan pemeriksaan');
                 } else {
                     myAlert(data.pesan);
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 console.log(errorThrown);
             }
         });

     }
 </script>

 <?php
    // Dialog untuk kirim dokumen RM =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogStatusDokumen',
        'options' => array(
            'title' => 'Pengiriman Dokumen Ke-Ruangan Lain',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 400,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                                    data: $('#daftarPasien-form').serialize()
                                }); }",
        ),
    ));
    ?>
 <iframe name='frameStatusDokumen' style="width: 100%; height: 98%;"></iframe>
 <?php $this->endWidget();
    // end ============== 
    ?>


 <?php
    // Dialog untuk melihat detail persalinan=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetailPersalinan',
        'options' => array(
            'title' => 'Detail Persalinan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 950,
            'height' => 550,
            'resizable' => true,

        ),
    ));
    ?>
 <iframe name='frameDetailPersalinan' style="width: 100%; height: 98%;"></iframe>
 <?php $this->endWidget(); ?>

 <?php
    // Dialog untuk melihat detail persalinan=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetailKelahiran',
        'options' => array(
            'title' => 'Detail Kelahiran',
            'autoOpen' => false,
            'modal' => true,
            'width' => 950,
            'height' => 550,
            'resizable' => true,

        ),
    ));
    ?>
 <iframe name='frameDetailKelahiran' style="width: 100%; height: 98%;"></iframe>
 <?php $this->endWidget(); ?>

 <?php
    // Dialog untuk CetakSuratKelahiran=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogCetakSuratKelahiran',
        'options' => array(
            'title' => 'Cetak',
            'autoOpen' => false,
            'modal' => true,
            'width' => 950,
            'height' => 550,
            'resizable' => true,

        ),
    ));
    ?>
 <iframe name='frameCetakSuratKelahiran' style="width: 100%; height: 98%;"></iframe>
 <?php $this->endWidget(); ?>
