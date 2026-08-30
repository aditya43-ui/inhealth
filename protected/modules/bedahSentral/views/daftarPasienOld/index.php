<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Bedah Sentral',
);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
Yii::app()->clientScript->registerScript('cariwew', "
    $('#daftarPasiens-form').submit(function(){
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
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Bedah Sentral</b>
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
                <?php
                //CHtml::link($text, $url, $htmlOptions)
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'daftarPasiens-form',
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label for="namaPasien" class="control-label">
                                <?php // echo CHtml::activecheckBox($modPasienMasukPenunjang, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal'));
                                ?>
                                Tanggal Masuk
                            </label>
                            <div class="controls">
                                <?php $format = new MyFormatter; ?>
                                <?php 
                                    $modPasienMasukPenunjang2 = clone $modPasienMasukPenunjang;
                                    $modPasienMasukPenunjang2->tgl_awal = $format->formatDateTimeForUser($modPasienMasukPenunjang2->tgl_awal); ?>
                                <?php
                                // $format = new MyFormatter;
                                // $modPasienMasukPenunjang->tgl_awal = date("d-m-Y", strtotime($modPasienMasukPenunjang->tgl_awal));
                                // $modPasienMasukPenunjang->tgl_akhir = date("d-m-Y", strtotime($modPasienMasukPenunjang->tgl_akhir));
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang2,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label(' Sampai Dengan', ' s/d', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $format = new MyFormatter; ?>
                                <?php 
                                    $modPasienMasukPenunjang2 = clone $modPasienMasukPenunjang;
                                    $modPasienMasukPenunjang2->tgl_akhir = $format->formatDateTimeForUser($modPasienMasukPenunjang2->tgl_akhir); ?>
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang2,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <div class="control-group">
                            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPasienMasukPenunjang, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modPasienMasukPenunjang->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($modPasienMasukPenunjang, 'ceklis', array('id' => 'tanggal_lahir')) . " Tanggal Lahir", 'tanggal_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_awall',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modPasienMasukPenunjang->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_akhirl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                            'order' => 'carabayar_nourut',
                        ));
                        $penjamin = PenjaminpasienM::model()->findAll(array(
                            'condition' => 'penjamin_aktif = true',
                            'order' => 'penjamin_nama',
                        ));
                        $dokter = DokterV::model()->findAll(array(
                            'condition' => 'pegawai_aktif = true and ruangan_id = ' . Yii::app()->user->getState('ruangan_id'),
                            'order' => 'nama_pegawai',
                        ));
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
                        )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'pegawai_id', CHtml::listData($dokter, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modPasienMasukPenunjang, "penjamin_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label("Status Periksa", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPasienMasukPenunjang, 'statuspendaftaran', LookupM::getItems('statusperiksa'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                    );
                    ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Bedah Sentral</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarpasien-v-grid',
                    'dataProvider' => $modPasienMasukPenunjang->searchBS(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        //            array(
                        //                    'name'=>'no_urutperiksa',
                        //                    'type'=>'raw',
                        //                    'header'=>'No. Antrian/<br>Panggil Antrian',
                        //                    'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".(($data->panggilantrian == TRUE) ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
                        //                ),
                        array(
                            'header' => 'Tgl. Masuk Penunjang<br>No. Penunjang',
                            'name' => 'no_masukpenunjang',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br>".$data->no_masukpenunjang',
                        ),
                        array(
                            'header' => 'Instalasi/<br>Ruangan Asal',
                            'name' => 'ruanganasal_nama',
                            'type' => 'raw',
                            'value' => function ($data) {
                                //$pegawai = PegawaiM::model()->findByAttributes(array(
                                //    'nama_pegawai'=>$data->nama_dokterasal,
                                //));
                                return $data->instalasiasal_nama . "/<br>" . $data->ruanganasal_nama; //."/<br>".(empty($pegawai)?"-":$pegawai->namaLengkap);
                            },
                        ),
                        array(
                            'name' => 'tgl_pendaftaran',
                            'header' => 'No. Pendaftaran / No. RM',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran." / ". $data->no_rekam_medik',
                            'htmlOptions' => array('width' => '100px'),
                        ),
                        // array(
                        //     'header' => 'No. RM',
                        //     'name' => 'no_rekam_medik',
                        // ),
                        array(
                            'header' => 'NIK/ Nama Pasien / Tanggal Lahir / Umur',
                            'type' => 'raw',
                            // 'value' => '$data->namadepan',
                            'value' => function ($data) {
                                return $data->no_identitas_pasien."<br>". $data->namadepan . $data->nama_pasien . '<br>' . MyFormatter::formatDateTimeForUser($data->tanggal_lahir) . '<br>' . $data->umur;
                            }
                            //
                            // 'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                            // 'value' => '$data->nama_pasien'.'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)' .
                            // '$data->umur'
                        ),
                        // array(
                        //     'header' => 'Tanggal Lahir',
                        //     'name' => 'tanggal_lahir',
                        //     'type' => 'raw',
                        //     'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        // ),
                        // array(
                        //     'header' => 'Umur',
                        //     'type' => 'raw',
                        //     'value' => '$data->umur',
                        // ),
                        'alamat_pasien',
                        array(
                            'header' => 'Kasus Penyakit/<br>Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '"$data->jeniskasuspenyakit_nama"."<br>"."$data->kelaspelayanan_nama"',
                        ),
                        //            'jeniskasuspenyakit_nama',
                        array(
                            'header' => 'Jenis Penjamin / Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        array(
                            'header' => 'Dokter Pemeriksa',
                            'type' => 'raw',
                            //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                            'value' => function ($data) {
                                $p = PegawaiM::model()->findByPk($data->pegawai_id);
                                return isset($p->namaLengkap) ? $p->namaLengkap : "-" ;
                            }, //'$data->pegawai_id',
                        ),
                        array(
                            'header' => 'Dokter Operator',
                            'type' => 'raw',
                            //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                            'value' => function ($data) {
                                $op = RencanaoperasiT::model()->findByAttributes(array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id
                                ));
                                if (empty($op)) {
                                    return "-";
                                }
                                $peg = PegawaiM::model()->findByPk($op->dokterpelaksana1_id);
                                return $peg->namaLengkap;
                            }, //'$data->pegawai_id',
                        ),
                        array(
                            'header' => 'Dokter Anestesi',
                            'type' => 'raw',
                            //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                            'value' => function ($data) {
                                $op = RencanaoperasiT::model()->findByAttributes(array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id
                                ));
                                if (empty($op)) {
                                    return "-";
                                }
                                $peg = PegawaiM::model()->findByPk($op->dokteranastesi_id);
                                if (empty($peg)) {
                                    return "-";
                                } else {
                                    return $peg->namaLengkap;
                                }
                            }, //'$data->pegawai_id',
                        ),
                        array(
                            'header' => 'Diagnosa',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $morbid = PasienmorbiditasT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                    'kelompokdiagnosa_id' => 2,
                                    'ruangan_id' => $data->ruanganasal_id
                                ), array(
                                    'order' => 'pasienmorbiditas_id desc',
                                ));
                                if (empty($morbid)) {
                                    $morbid = PasienmorbiditasT::model()->findByAttributes(array(
                                        'pendaftaran_id' => $data->pendaftaran_id,
                                        'ruangan_id' => $data->ruanganasal_id
                                    ), array(
                                        'order' => 'pasienmorbiditas_id desc',
                                    ));
                                    if (empty($morbid)) {
                                        return "-";
                                    }
                                }
                                $diag = DiagnosaM::model()->findByPk($morbid->diagnosa_id);
                                return $diag->diagnosa_kode . " - " . $diag->diagnosa_nama;
                            }
                        ),
                        array(
                            'header' => 'Kirim Ke Patologi Anatomi',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return CHtml::link("<i class='icon-periksalab'></i> ",  Yii::app()->controller->createUrl(
                                    "patologiAnatomiTBS/index",
                                    array("pendaftaran_id" => $data->pendaftaran_id)
                                ), array("target" => "detailDialogi", "rel" => "tooltip", "title" => "Klik untuk kirim ke Patologi Anatomi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData');", "dialog-text" => "Kirim Ke Patologi Anatomi"));
                            },
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                        ),
                        array(
                            'header' => 'Tindakan Operasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $rencana = RencanaoperasiT::model()->findAllByAttributes(array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                ), array(
                                    'join' => 'join operasi_m o on o.operasi_id = t.operasi_id',
                                    'select' => 't.*, o.operasi_nama',
                                ));
                                if (count((array)$rencana) == 0) {
                                    return "-";
                                }
                                $str = '<ul>';
                                foreach ($rencana as $item) {
                                    $str .= '<li>' . $item->operasi_nama . '</li>';
                                }
                                $str .= '</ul>';
                                return $str;
                            }
                        ),
                        array(
                            'header' => 'PPDS',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $ppds = PasienmasukpenunjangT::model()->findByPk(['ppds_id' => $data->ppds_id]);
                                $ppds = !empty($ppds->ppds->ppds_nama) ? $ppds->ppds->ppds_nama : " &nbsp; - ";
                                return $ppds; 
                            }
                        ),
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return Params::getWrStatusPeriksa($data->statuspendaftaran);
                            }
                        ),
                        array(
                            'header' => 'Riwayat Pasien <hr /> Observasi Pasien',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-detail"></i><br>Riwayat', $this->createUrl("riwayatPasienBS/index", array(
                                    'id' => $data->pasien_id,
                                )), array(
                                    'target' => 'frameRiwayat',
                                    'onclick' => '$("#dialogRiwayat").dialog("open");'
                                )) . '<br><br><hr>' . CHtml::link('<img src="' . Yii::app()->getBaseUrl('webroot') . '/images/icon/nurse.png" style="width:30px;height:30px;"><br>Perawat/Bidan', Yii::app()->controller->createUrl("RekamMedikElektronikPasienBS/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Perawat')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik Observasi Pasien"));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            )
                        ),
                        array(
                            'header' => 'Verifikasi Rencana Operasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    return CHtml::link("<i class='icon-form-roperasi'>", 'javascript:;', array(
                                        "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi rencana operasi, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengisi mengubah rencana operasi", 'data-placement' => 'left'
                                    ));
                                } else {
                                    return (($data->getPegawaiMengetahuiOperasi($data->pasienmasukpenunjang_id) == null) ? "" : "Sudah diverifikasi") . (($data->getStatusOperasi($data->pasienmasukpenunjang_id) != "RENCANA") ?
                                        " - " : CHtml::Link("<i class='icon-form-roperasi'></i>", Yii::app()->controller->createUrl("PendaftaranBedahSentralRujukanRS/index/", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array(
                                            "class" => "icon-form-roperasi",
                                            "id" => "selectPasien",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk ubah rencana operasi pasien"
                                        )));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Catatan Anestesi & Sedasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-detail"></i><br>Anestesi', Yii::app()->createUrl('/bedahSentral/catatanAnestesi/index', array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                )), array(
                                    'rel' => 'tooltip',
                                    'title' => 'Catatan Anestesi & Sedasi'
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Sign In',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) use (&$is_signin) {
                                $is_signin = true;
                                $modRencanaOpterasiT = BSRencanaOperasiT::model()->findByAttributes(array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));
                                if (empty($modRencanaOpterasiT->tgl_mengetahui)) {
                                    $is_signin = false;
                                    return "";
                                }
                                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    return CHtml::link("<i class='" . MyIcon::getIcons('signin') . "'>", 'javascript:;', array(
                                        "onclick" => 'myAlert("Anda tidak dapat menginput sign in, karena status pasien ' . $data->statusperiksa . '","Perhatian !")',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengisi form sign in", 'data-placement' => 'left'
                                    ));
                                } else {
                                    return CHtml::link("<i class='" . MyIcon::getIcons('signin') . "'>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/rujukanPenunjang/signIn', array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id, "pendaftaran_id" => $data->pendaftaran_id)), array(
                                        "target" => "frameSignIn",
                                        "onclick" => '$("#dialogSignIn").dialog("open");',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengisi form sign in", 'data-placement' => 'left'
                                    ));
                                }
                            }
                        ),
                        array(
                            'header' => 'Time Out',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                $dataSignIn = BSOperasisigninT::model()->findByAttributes(array(
                                    'pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id,
                                ));
                                if (empty($dataSignIn)) {
                                    return "-";
                                }
                                $penunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);
                                if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    return CHtml::link("<i class='" . MyIcon::getIcons('timeout') . "'>", 'javascript:;', array(
                                        "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengisi form time out", 'data-placement' => 'left'
                                    ));
                                } else {
                                    if (!empty($penunjang->pasienkirimkeunitlain_id)) {
                                        //var_dump($penunjang->pasienkirimkeunitlain_id);
                                        $signin = BSOperasisigninT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $penunjang->pasienkirimkeunitlain_id));
                                        //
                                        if (!empty($signin)) {
                                            return CHtml::link("<i class='" . MyIcon::getIcons('timeout') . "'>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/timeOut', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "pendaftaran_id" => $data->pendaftaran_id)), array(
                                                "target" => "frameTimeOut",
                                                "onclick" => '$("#dialogTimeOut").dialog("open");',
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk mengisi form time out", 'data-placement' => 'left'
                                            ));
                                        } else {
                                            return CHtml::link("<i class='" . MyIcon::getIcons('timeout') . "'>", 'javascript:;', array(
                                                "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign in belum diinput","Perhatian !")',
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk mengisi form time out", 'data-placement' => 'left'
                                            ));
                                        }
                                    } else {
                                        return CHtml::link("<i class='" . MyIcon::getIcons('timeout') . "'>", 'javascript:;', array(
                                            "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign in belum diinput","Perhatian !")',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengisi form time out", 'data-placement' => 'left'
                                        ));
                                        //	return CHtml::link("<i class='".MyIcon::getIcons('timeout')."'>",'javascript',array(
                                        //						"onclick"=>'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign in belum diinput","Perhatian !")',
                                        //						"rel"=>"tooltip",
                                        //						  "title"=>"Klik untuk mengisi form time out", 'data-placement'=>'left'));
                                    }
                                }
                            }
                        ),
                        array(
                            'header' => 'Approve / Operasi',
                            'type' => 'raw',
                            'value' => function ($data) use ($module, $controller) {
                                if ($data->getPegawaiMengetahuiOperasi($data->pasienmasukpenunjang_id) == null) {
                                    return "BELUM DI APPROVE";
                                }
                                $modRencanaOpterasiT = BSRencanaOperasiT::model()->findByAttributes(array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));
                                if (isset($modRencanaOpterasiT)) {
                                    if (isset($modRencanaOpterasiT->pegmengetahui_id)) {
                                        if (isset($modRencanaOpterasiT->tgl_mengetahui)) {
                                            if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                                if ($data->getStatusOperasi($data->pasienmasukpenunjang_id) != '') {
                                                    if ($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "MULAI") {
                                                        return "<div class='inap' style='background-color:#FFFF00; text-align: center;'>SEDANG OPERASI</div>";
                                                    } elseif ($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "SELESAI") {
                                                        return "<div class='inap' style='background-color:#33FF00; text-align: center'>SELESAI OPERASI</div>";
                                                    } else {
                                                        return CHtml::link("<i class='icon-form-operasi'>", 'javascript:;', array(
                                                            "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi operasi, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                                                            "rel" => "tooltip",
                                                            "title" => "Klik untuk mengisi operasi", 'data-placement' => 'left'
                                                        ));
                                                    }
                                                } else {
                                                    return CHtml::link("<i class='icon-form-operasi'>", 'javascript:;', array(
                                                        "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi operasi, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk mengisi operasi", 'data-placement' => 'left'
                                                    ));
                                                }
                                            } else {
                                                $dataTimeOut = BSOperasitimeoutT::model()->findByAttributes(array(
                                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                                ));
                                                if (empty($dataTimeOut)) {
                                                    return "-";
                                                }
                                                return ($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "MULAI") ? "<div class='inap' style='background-color:#FFFF00; text-align: center;'>" .
                                                    CHtml::link("SEDANG OPERASI", Yii::app()->controller->createUrl("/bedahSentral/daftarPasien/selesaiOperasi", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Menyelesaikan Operasi", "target" => "frameSelesaiOperasi", "onclick" => "$('#selesaiOperasi').dialog('open');return true;")) : (($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "SELESAI") ? "<div class='inap' style='background-color:#33FF00; text-align: center'>SELESAI OPERASI" :
                                                        CHtml::link("<i class=icon-form-operasi></i>", Yii::app()->controller->createUrl("/" . $module . '/' . $controller . '/updateRencana', array("id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Melakukan Operasi")));
                                            }
                                        } else {
                                            $dataDialog = 'myAlert("Hanya ' . (isset($modRencanaOpterasiT->pegmengetahui_id) ? $modRencanaOpterasiT->pegmengetahuis->namaLengkap : "-") . ' yang bisa mengakses");';
                                            //if ($modRencanaOpterasiT->pegmengetahui_id == Yii::app()->user->getState('pegawai_id')) {
                                            $dataDialog = "$('#dialogApproveMengetahui').dialog('open');";
                                            //}
                                            return CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->controller->createUrl("/" . $module . '/' . $controller . '/ApproveMengetahui', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "frame" => true)), array("target" => "frameApproveMengetahui", "rel" => "tooltip", "title" => "Klik untuk Approve Menyetujui", "onclick" => $dataDialog));
                                        }
                                    } else {
                                        return "";
                                    }
                                } else {
                                    return "";
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Sign Out',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                $modRencanaOpterasiT2 = RencanaoperasiT::model()->findByAttributes(array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                ), array(
                                    'condition' => 'tindakanpelayanan_id is not null'
                                ));
                                if (empty($modRencanaOpterasiT2)) {
                                    return "-";
                                }
                                $dataTimeOut = BSOperasitimeoutT::model()->findByAttributes(array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                ));
                                if (empty($dataTimeOut)) {
                                    return "";
                                }
                                //$penunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);
                                if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    return CHtml::link("<i class='" . MyIcon::getIcons('signout') . "'>", 'javascript:;', array(
                                        "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi sign out, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengisi form sign out", 'data-placement' => 'left'
                                    ));
                                } else {
                                    if (!empty($data->pasienmasukpenunjang_id)) {
                                        //var_dump($penunjang->pasienkirimkeunitlain_id);
                                        $signin = BSOperasitimeoutT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
                                        //
                                        if (!empty($signin)) {
                                            return CHtml::link("<i class='" . MyIcon::getIcons('signout') . "'>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/signOut', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "pendaftaran_id" => $data->pendaftaran_id, 'timeout_id' => $signin->operasitimeout_id)), array(
                                                "target" => "frameSignOut",
                                                "onclick" => '$("#dialogSignOut").dialog("open");',
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk mengisi form sign out", 'data-placement' => 'left'
                                            ));
                                        } else {
                                            return CHtml::link("<i class='" . MyIcon::getIcons('signout') . "'>", 'javascript:;', array(
                                                "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign out belum diinput","Perhatian !")',
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk mengisi form sign out", 'data-placement' => 'left'
                                            ));
                                        }
                                    } else {
                                        return CHtml::link("<i class='" . MyIcon::getIcons('signout') . "'>", 'javascript:;', array(
                                            "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign out belum diinput","Perhatian !")',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengisi form sign out", 'data-placement' => 'left'
                                        ));
                                        //	return CHtml::link("<i class='".MyIcon::getIcons('timeout')."'>",'javascript',array(
                                        //						"onclick"=>'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign in belum diinput","Perhatian !")',
                                        //						"rel"=>"tooltip",
                                        //						  "title"=>"Klik untuk mengisi form time out", 'data-placement'=>'left'));
                                    }
                                }
                            }
                        ),
                        array(
                            'header' => 'Catatan/Laporan Tindakan Bedah & Prosedur Invasif Anestesi Lokal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $str = CHtml::link('<i class="icon-form-detail"></i><br>Catatan', Yii::app()->createUrl('/bedahSentral/catatanTindakanBedah/index', array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                )), array(
                                    'rel' => 'tooltip',
                                    'title' => 'Catatan Tindakan Bedah & Prosedur Invasif Anestesi Lokal'
                                ));
                                $str .= "<br>";
                                $str .= CHtml::link('<i class="icon-form-detail"></i><br>Laporan', Yii::app()->createUrl('/bedahSentral/catatanTindakanBedah/laporan', array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                )), array(
                                    'target' => 'frameLaporanAnestesiLokal',
                                    'rel' => 'tooltip',
                                    'title' => 'Laporan Catatan Tindakan Bedah & Prosedur Invasif Anestesi Lokal',
                                    'onclick' => "$('#dialogLaporanAnestesiLokal').dialog('open');"
                                ));
                                return $str;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Catatan Perawatan Ruang Pulih',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $str = "";
                                if (in_array($data->instalasiasal_id, array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU)) || !empty($data->pasienadmisi_id)) {
                                    $str .= CHtml::link('<i class="icon-form-detail"></i><br>Catatan', Yii::app()->createUrl('/bedahSentral/catatanRuangPulih/index', array(
                                        'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                    )), array(
                                        'rel' => 'tooltip',
                                        'title' => 'Catatan Perawatan Ruang Pulih'
                                    ));
                                }
                                $ruangpulih = PasienruangpulihT::model()->findByAttributes(array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id
                                ));
                                $pegawailogin_id = Yii::app()->user->getState('pegawai_id');
                                // if (!empty($ruangpulih)
                                    //                                && (
                                    //                                    $pegawailogin_id == $ruangpulih->dokteranastesi_id
                                    //                                    || $pegawailogin_id == $ruangpulih->perawatanastesi_id
                                    //                                    || $pegawailogin_id == $ruangpulih->petugas_saatkeluarruangpulih_id
                                    //                                )
                                // ) {
                                    $str .= CHtml::link('<i class="icon-form-detail"></i><br>Verfikasi Keluar', Yii::app()->createUrl('/bedahSentral/verifikasiKeluarRuangPulih/index', array(
                                        'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                    )), array(
                                        'rel' => 'tooltip',
                                        'target' => 'frameVerifikasiRuangPulih',
                                        'title' => 'Verfikasi Keluar Ruang Pulih',
                                        'onclick' => "$('#dialogVerifikasiRuangPulih').dialog('open');"
                                    ));
                                // }
                                return $str;
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                         array(
                            'header' => 'Laporan Operasi',
                            'type' => 'raw',
                            'value' => function($data) {


                                // if ($data->getStatusOperasi($data->pasienmasukpenunjang_id) != "SELESAI") {
                                //     return "";
                                // }

                                return CHtml::link('<i class="icon-form-detail"></i><br/>Laporan Operasi', Yii::app()->createUrl('/bedahSentral/catatanLaporanOperasiPasien/create', array(
                                        'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                    )), array(
                                    'target' => 'frameLaporanOperasi',
                                    'onclick' => "$('#dialogLaporanOperasi').dialog('open')",
                                    'rel' => 'tooltip',
                                    'title' => 'Laporan Operasi'
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center',
                            ),
                        ),
                        // array(
                        //     'header' => 'Laporan Operasi',
                        //     'type' => 'raw',
                        //     'value' => function ($data) {
                        //         if ($data->getStatusOperasi($data->pasienmasukpenunjang_id) != "SELESAI") {
                        //             return "";
                        //         }
                        //         return CHtml::link('<i class="icon-form-detail"></i><br>Laporan Operasi', Yii::app()->createUrl('/bedahSentral/catatanLaporanOperasiPasien/create', array(
                        //             'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                        //         )), array(
                        //             'target' => 'frameLaporanOperasi',
                        //             'onclick' => "$('#dialogLaporanOperasi').dialog('open')",
                        //             'rel' => 'tooltip',
                        //             'title' => 'Laporan Operasi'
                        //         ));
                        //     },
                        //     'htmlOptions' => array(
                        //         'style' => 'text-align: center;',
                        //     ),
                        // ),
                        array(
                            'name' => 'Riwayat Vaksinasi/Imunisasi',
                            'type' => 'raw',
                            // 'value' => '',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-detail"></i><br>Vaksinasi', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                )), array(
                                    'target' => 'frameRiwayatVaksinasi',
                                    'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
                                ));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        // array(
                        //     'header' => 'Persetujuan/<br/>BA Jaringan/Impan',
                        //     'type' => 'raw',
                        //     'value' => function ($data) use ($module, $controller) {
                        //         if (!empty($data->pasienkirimkeunitlain_id)) {
                        //             $kirim = PersetujuananestesiT::model()->findByAttributes(array(
                        //                 'pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id
                        //             ));
                        //             if (!empty($kirim)) {
                        //                 $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/Index', array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id));
                        //             }
                        //         }
                        //         if (empty($url)) {
                        //             $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/Index', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));
                        //         }
                        //         $link = (CHtml::link("<i class='icon-form-ubah'></i><br/>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanTBS/index", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => 1)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan", "target" => "framePersetujuan", "onclick" => "$('#dialogPersetujuan').dialog('open');"))) . "<br/>";
                        //         $link .= CHtml::link("<icon class='icon-form-ubah'></icon><br/>Inform Consent", Yii::app()->controller->createUrl("/" . $module . '/PersetujuanTindakanUmumBS/Index', array("pendaftaran_id" => $data->pendaftaran_id, 'frame' => 1)), array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Persetujuan)", "onclick" => "$('#dialogPersetujuan').dialog('open');")) . "<br/>";
                        //         $link .= CHtml::link("<icon class='icon-form-ubah'></icon><br/>Anastesi", $url, array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan anastesi", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
                                
                        //         $link .= '<br/>'.CHtml::link("<icon class='icon-form-ubah'></icon><br/>BA Jaringan/Implan", $this->createUrl('baSerahTerimaJaringan/index',['pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id]), array("target" => "frameBA", "rel" => "tooltip", "title" => "Klik untuk berita acara serath terima jaringan/implan", "onclick" => "$('#dialogBA').dialog('open');"));
                        //         return $link;
                        //     },
                        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        // ),
                        // array(
                        //     'header' => 'Penolakan',
                        //     'type' => 'raw',
                        //     'value' => function ($data) use ($module, $controller) {
                        //         if (!empty($data->pasienkirimkeunitlain_id)) {
                        //             $kirim = PersetujuananestesiT::model()->findByAttributes(array(
                        //                 'pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id
                        //             ));
                        //             if (!empty($kirim)) {
                        //                 $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/penolakan', array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id));
                        //             }
                        //         }
                        //         if (empty($url)) {
                        //             $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/penolakan', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));
                        //         }
                        //         $link = (CHtml::link("<i class='icon-form-silang'></i><br/>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanTBS/penolakan", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => 1)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan", "target" => "framePersetujuan", "onclick" => "$('#dialogPersetujuan').dialog('open');"))) . "<br/>";
                        //         $link .= CHtml::link("<icon class='icon-form-silang'></icon><br/>Inform Refusal", Yii::app()->controller->createUrl("/" . $module . '/PersetujuanTindakanUmumBS/penolakan', array("pendaftaran_id" => $data->pendaftaran_id, 'frame' => 1)), array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Penolakan)", "onclick" => "$('#dialogPersetujuan').dialog('open');")) . "<br/>";
                        //         $link .= CHtml::link("<icon class='icon-form-silang'></icon><br/>Anastesi", $url, array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan anastesi", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
                        //         return $link;
                        //         //                                return (CHtml::link("<i class='icon-form-silang'></i><br>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanUmumBS/penolakan", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => 1)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan", "target" => "framePenolakan", "onclick" => "$('#dialogPenolakan').dialog('open');"))) . "<br>" .
                        //         //                                    CHtml::link("<icon class='icon-form-silang'></icon>Anastesi", $url, array("target" => "framePenolakan", "rel" => "tooltip", "title" => "Klik untuk menyetujui", "onclick" => "$('#dialogPenolakan').dialog('open');"));
                        //     },
                        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        // ),
                        // array(
                        //     'header' => 'Detail Persetujuan & Penolakan',
                        //     'type' => 'raw',
                        //     'value' => function ($data) use ($module, $controller) {
                        //         $str = "";
                        //         $anastesi = PersetujuananestesiT::model()->findByAttributes(array(
                        //             'pendaftaran_id' => $data->pendaftaran_id,
                        //         ), array(
                        //             'condition' => "create_ruangan <> " . Yii::app()->user->getState('ruangan_id'),
                        //             'order' => 'create_time desc',
                        //         ));
                        //         $tindakan = SuratpersetujuantmT::model()->findByAttributes(array(
                        //             'pendaftaran_id' => $data->pendaftaran_id,
                        //         ), array(
                        //             'condition' => "ruangan_id <> " . Yii::app()->user->getState('ruangan_id'),
                        //             'order' => 'tglpersetujuan desc',
                        //         ));
                        //         if (!empty($tindakan)) {
                        //             if ($tindakan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) {
                        //                 $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanTBS/index', array("pendaftaran_id" => $data->pendaftaran_id, 'suratpersetujuantm_id' => $tindakan->suratpersetujuantm_id, "frame" => 1));
                        //             } else {
                        //                 $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanTBS/penolakan', array("pendaftaran_id" => $data->pendaftaran_id, 'suratpersetujuantm_id' => $tindakan->suratpersetujuantm_id, "frame" => 1));
                        //             }
                        //             $str .= CHtml::link("<icon class='icon-form-detail'></icon>Detail Persetujuan & Penolakan", $url, array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk melihat Detail Persetujuan & Penolakan", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
                        //         }
                        //         if (!empty($anastesi)) {
                        //             if ($anastesi->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) {
                        //                 $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/index', array("pendaftaran_id" => $data->pendaftaran_id, 'persetujuananestesi_id' => $anastesi->persetujuananestesi_id));
                        //             } else {
                        //                 $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/penolakan', array("pendaftaran_id" => $data->pendaftaran_id, 'persetujuananestesi_id' => $anastesi->persetujuananestesi_id));
                        //             }
                        //             $str .= CHtml::link("<icon class='icon-form-detail'></icon>Anastesi", $url, array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk melihat surat persetujuan", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
                        //         }
                        //         return $str;
                        //     },
                        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        // ),
                        // array(
                        //     'header' => 'Monitoring Transfusi Darah',
                        //     'type' => 'raw',
                        //     'value' => function ($data) {
                        //         $model = PenyerahandarahT::model()->findByAttributes(array(
                        //             'pendaftaran_id' => $data->pendaftaran_id,
                        //         ), array(
                        //             'order' => 'penyerahandarah_id desc'
                        //         ));
                        //         if (empty($model)) {
                        //             return "";
                        //         }
                        //         return CHtml::link("<icon class='icon-form-periksa'></icon>", $this->createUrl('monitoringTransfusiDarah/create', array('pendaftaran_id' => $data->pendaftaran_id, 'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Monitoring Transfusi Darah"));
                        //     },
                        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        // ),
                        array(
                            'header' => 'Catatan Edukasi',
                            'type' => 'raw',
                            'value' => function($data) {
                                return CHtml::link('<i class="icon-form-detail"></i><br>Edukasi', $this->createUrl('/bedahSentral/catatanEdukasiBS/create', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                                    'rel'=>'tooltip',
                                    'title'=>'Catatan Edukasi Pasien',
                                ));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                        ),
                        array(
                            'name'=>'CPPT',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return CHtml::link('<i class="icon-form-detail"></i><br>Cppt', Yii::app()->createUrl("/bedahSentral/CPPTBS/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Catatan Perkembangan Pasien Terintegrasi (CPPT)"));
                            },
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                        ), 
                        array(
                            'header' => 'Pemindahan Pasien',
                            'type' => 'raw',
                            'value' => function($data) {
                              $htmlLink = CHtml::link('<i class="icon-form-detail"></i><br> Transfer', Yii::app()->createUrl('/bedahSentral/pemindahanPasienBS/index', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                                  'rel'=>'tooltip',
                                  'title'=>'Pemindahan Pasien',
                              ));
                
                              $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id'=>Yii::app()->user->getState("ruangan_id"),'pendaftaran_id'=>$data->pendaftaran_id),array('condition'=>'(ispasienditerima IS NULL OR ispasienditerima = false)'));
                              $linkPenerima = "";
                              if(isset($modFormTransfer) && count($modFormTransfer) > 0){
                                  $linkPenerima = CHtml::link('<i class="icon-form-check"></i> ', Yii::app()->createUrl("/bedahSentral/pemindahanPasienBS/index",array("pendaftaran_id"=>$data->pendaftaran_id,'pasienditerima'=>'diterima')),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Penerimaan Pemindahaan Pasien"));
                              }
                
                              return $htmlLink .'<br/>'.$linkPenerima;
                            },
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                        ),
                        array(
                            'header' => 'Catatan Pemindahan Pasien',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));
                                if (!empty($modPemindahanPasien)) {
                                    return CHtml::link(
                                        '<icon class="icon-form-detail"></icon>',
                                        $this->createUrl("/bedahSentral/pemindahanPasienBS/detail", array("pemindahanpasien_id" => $modPemindahanPasien->pemindahanpasien_id)),
                                        array(
                                            "target" => "frameDetail",
                                            "onclick" => "$('#dialogDetail').dialog('open');",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                
                                        )
                                    );
                                } else {
                                    return "";
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                        ),
                        array(
                            'header' => 'Status Dokumen',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $status_dokumen = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                $dok =   CHtml::link("<icon class='icon-file' style='font-size:48px;'></icon><br>File Rekam Medik<br>", Yii::app()->controller->createUrl('DaftarPasien/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medik", "onclick" => "$('#dialogDokFilerm').dialog('open');"));
                                // if ($status_dokumen->statusdokrm == "SUDAH DITERIMA") {
                                //     if (Yii::app()->user->getState('ruangan_id') == $status_dokumen->pengirimanrm->ruanganpenerima_id) {
                                //         //var_dump($data->statusperiksa);
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
                                //             ) . '<br><br>' . $dok;
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
                                //             ) . '<br><br>' . $dok;
                                //         }
                                //     } else {
                                //         return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id) . '<br><br>' . $dok;
                                //     }
                                // } else {
                                //     return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id) . '<br><br>' . $dok;
                                // }
                                return $dok;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal Periksa',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan Pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Anda tidak dapat mebatalkan pasien, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")'));
                                } else {
                                    if (in_array($data->getStatusOperasi($data->pasienmasukpenunjang_id), array("MULAI", "SELESAI")))
                                        return "-";
                                    //								return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalPeriksa(".$data->pasienmasukpenunjang_id.")",array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan", 'data-placement'=>'left'));
                                    //return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:ubahPeriksaKarenaBatal('.$data->pendaftaran_id.','.$data->pasienmasukpenunjang_id.',"'.$data->nama_pasien.'")',array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan", 'data-placement'=>'left'));
                                    return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPeriksa(' . $data->pendaftaran_id . ',' . $data->pasienmasukpenunjang_id . ',"' . $data->nama_pasien . '")', array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan Pemeriksaan", "data-placement" => "left"));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    // array(
                    //     'header' => 'Batal Operasi',
                    //     'type' => 'raw',
                    //     'value' => function($data) {
                    //         if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    //             return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan Pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Anda tidak dapat mebatalkan pasien, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")'));
                    //         } else {
                    //             if ($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "SELESAI")
                    //                 return CHtml::Link("<i class='entypo-back'></i>", Yii::app()->controller->createUrl("PendaftaranBedahSentralRujukanRS/index/", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, 'statusoperasi' => Params::STATUSOPERASI_RENCANA)), array("class" => "",
                    //                             "id" => "selectPasien",
                    //                             "rel" => "tooltip",
                    //                             "title" => "Klik untuk kembali ke rencana operasi pasien", 'style' => 'font-size: 25px'));
                    //								if (in_array($data->getStatusOperasi($data->pasienmasukpenunjang_id),array("MULAI", "SELESAI"))) return CHtml::Link("<i class='entypo-back'></i>",Yii::app()->controller->createUrl("PendaftaranBedahSentralRujukanRS/index/",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,'statusoperasi'=>Params::STATUSOPERASI_RENCANA)),
                    //																	array("class"=>"",
                    //																			  "id" => "selectPasien",
                    //																			  "rel"=>"tooltip",
                    //																			  "title"=>"Klik untuk kembali ke rencana operasi pasien", 'style'=>'font-size: 25px'));
                    //								return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalPeriksa(".$data->pasienmasukpenunjang_id.")",array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan", 'data-placement'=>'left'));
                    //return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:ubahPeriksaKarenaBatal('.$data->pendaftaran_id.','.$data->pasienmasukpenunjang_id.',"'.$data->nama_pasien.'")',array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan", 'data-placement'=>'left'));
                    //                 if ($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "RENCANA")
                    //                     return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPeriksa(' . $data->pendaftaran_id . ',' . $data->pasienmasukpenunjang_id . ',"' . $data->nama_pasien . '")', array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan Pemeriksaan", "data-placement" => "left"));
                    //             }
                    //         },
                    //         'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                    //     ),
                    // ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

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
<!--<iframe id="suarapanggilan" src="#" style="display: none;"></iframe>-->
<iframe id="suarapanggilan" src=""></iframe>
<script type="text/javascript">
    //document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style","display:none;");
    //document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
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
        myConfirm("Apakah Anda yakin akan membatalkan pemeriksaan Operasi Bedah pasien ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalPeriksa') ?>', {
                        idPenunjang: idPenunjang
                    },
                    function(data) {
                        if (data.status == 'ok' && data.pesan != 'exist') {
                            window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                        } else {
                            if (data.pesan == 'exist' && data.status == 'ok') {
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
    /**
     *
     * @param {type} pendaftaran_id
     * @param {type} statusperiksa
     * @param {type} namaPasien
     * @returns {undefined}
     */
    function dialogBatalPeriksa(pendaftaran_id, penunjang_id, namaPasien) {
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
            data: {
                pendaftaran_id: pendaftaran_id,
                tglbatal: tglbatal,
                keterangan_batal: keterangan_batal,
                idPenunjang: penunjang_id
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok' && data.pesan != 'exist') {
                    window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                } else {
                    if (data.pesan == 'exist' && data.status == 'ok') {
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
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    $(document).ready(function() {
        $("#suarapanggilan").attr('style', 'display: none');
    });
</script>
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
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
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
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
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
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKonfirm',
    'options' => array(
        'title' => '',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 500,
        'height' => 200,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    'options' => array(
        'title' => '',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe name="frameRiwayat" style="width:100%; height: 98%;"></iframe>';
$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<?php
//=============================== Ganti Data Pasien Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'selesaiOperasi',
        'options' => array(
            'title' => 'Selesai Operasi Pasien',
            'autoOpen' => false,
            'width' => 480,
            'height' => 320,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
        ),
    )
);
//    echo CHtml::hiddenField('temp_norekammedik','',array('readonly'=>true));
echo '<iframe name="frameSelesaiOperasi" style="width:100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
// Dialog untuk mengisi form time out =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTimeOut',
    'options' => array(
        'title' => 'Transaksi Time Out',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 700,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $('#daftarPasien-form').serialize()
		}); }",
    ),
));
?>
<iframe name='frameTimeOut' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>
<?php
// Dialog untuk mengisi form sign out =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSignOut',
    'options' => array(
        'title' => 'Transaksi Sign Out',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 700,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $('#daftarPasien-form').serialize()
		}); }",
    ),
));
?>
<iframe name='frameSignOut' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!--Dialog untuk mengetahui-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogApproveMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $(this).serialize()
                }); }",
    ),
));
?>
<iframe name='frameApproveMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<!--ialog untuk persetujuan-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPersetujuan',
    'options' => array(
        'title' => 'Detail Persetujuan & Penolakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        //        'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
        //                        data: $(this).serialize()
        //                }); }",
    ),
));
?>
<iframe name='framePersetujuan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<!--ialog untuk penolakan-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenolakan',
    'options' => array(
        'title' => 'Penolakan Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        //        'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
        //                        data: $(this).serialize()
        //                }); }",
    ),
));
?>
<iframe name='framePenolakan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => '',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe name="detailDialog" style="width:100%; height: 98%;"></iframe>';
$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<?php
// Dialog untuk mengisi form sign in =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSignIn',
    'options' => array(
        'title' => 'Transaksi Sign In',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 700,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $('#daftarPasien-form').serialize()
		}); }",
    ),
));
?>
<iframe name='frameSignIn' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>
<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLaporanAnestesiLokal',
    'options' => array(
        'title' => 'Laporan Tindakan Bedah & Prosedur Infasif dengan Anestesi Lokal',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameLaporanAnestesiLokal' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>
<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVerifikasiRuangPulih',
    'options' => array(
        'title' => 'Verifikasi Keluar Ruang Pulih',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameVerifikasiRuangPulih' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>
<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLaporanOperasi',
    'options' => array(
        'title' => 'Laporan Operasi Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameLaporanOperasi' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>
<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMonitoringTransfusi',
    'options' => array(
        'title' => 'Monitoring Transfusi Darah',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameMonitoringTransfusi' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBA',
    'options' => array(
        'title' => 'Berita Acara Serah Terima Jaringan/Implan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,

    ),
));
?>
<iframe name='frameBA' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>