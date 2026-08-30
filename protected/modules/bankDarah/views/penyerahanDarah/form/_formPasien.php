<?php
$ruangan_id = $pendaftaran->ruangan_id;
$kelaspelayanan_id = $pendaftaran->kelaspelayanan_id;
$penjamin_id = $pendaftaran->penjamin_id;

if (!empty($pendaftaran->pasienadmisi_id)) {
    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
    $ruangan_id = $admisi->ruangan_id;
    $kelaspelayanan_id = $admisi->kelaspelayanan_id;
    $penjamin_id = $admisi->penjamin_id;
}

$ruangan = RuanganM::model()->findByPk($ruangan_id);
$kelas = KelaspelayananM::model()->findByPk($kelaspelayanan_id);

$diagnosapasien = PasienmorbiditasT::model()->findByAttributes(array(
    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
    'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
));

$penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);

$diagnosa_nama = "";
if (!empty($diagnosapasien)) {
    $diagnosa = DiagnosaM::model()->findByPk($diagnosapasien->diagnosa_id);
    $diagnosa_nama = $diagnosa->diagnosa_kode." ".$diagnosa->diagnosa_nama;
}

if (empty($ruangan)) {
    $ruangan = new RuanganM;
}

if (empty($kelas)) {
    $kelas = new KelaspelayananM;
}

if (empty($penjamin)) {
    $penjamin = new PenjaminpasienM;
}

if (empty($pendaftaran->pasien)) {
    $pendaftaran->pasien = new PasienM;
}

if (empty($pendaftaran->pegawai)) {
    $pendaftaran->pegawai = new PegawaiM;
}

?>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">No. Permintaan</label>
        <div class="controls">
            <?php 
            
            echo CHtml::activeHiddenField($model, 'permintaandarah_id', array(
                'class'=>'permintaandarah_id'
            ));
            echo CHtml::activeHiddenField($model, 'pendaftaran_id', array(
                'class'=>'pendaftaran_id'
            ));
            
            if (!empty($permintaan->permintaandarah_id)) {
                echo CHtml::textField('no_permintaan', $permintaan->no_permintaandarah, array('readonly'=>true)); 
            } else {
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute'=>'no_permintaandarah',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('autoCompletePermintaanDarahSudahSiap').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                     'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 3,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setPermintaan(ui.item);
                                return false;
                            }',
                    ),
                    'htmlOptions'=>array(
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span3 peg_referal_nama',
                        'disabled'=>!$model->isNewRecord,
                    ),
                    'tombolDialog'=>!$model->isNewRecord ? null : array('idDialog'=>'dialogPermintaan'),
                ));
            }
?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">No. Pendaftaran</label>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran', $pendaftaran->no_pendaftaran, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tgl. Pendaftaran</label>
        <div class="controls">
            <?php echo CHtml::textField('no_pendaftaran', MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran), array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Ruangan</label>
        <div class="controls">
            <?php echo CHtml::textField('ruangan', $ruangan->ruangan_nama, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Kelas Pelayanan</label>
        <div class="controls">
            <?php echo CHtml::textField('kelaspelayanan', $kelas->kelaspelayanan_nama, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Diagnosis</label>
        <div class="controls">
            <?php echo CHtml::textField('diagnosis', $permintaan->diagnosis, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Penjamin</label>
        <div class="controls">
            <?php echo CHtml::textField('penjamin', $penjamin->penjamin_nama, array('readonly'=>true)); ?>
        </div>
    </div>
    
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">No Rekam Medis</label>
        <div class="controls">
            <?php echo CHtml::textField('no_rekam_medik', $pendaftaran->pasien->no_rekam_medik, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Nama Pasien</label>
        <div class="controls">
            <?php echo CHtml::textField('nama_pasien', $pendaftaran->pasien->namadepan.$pendaftaran->pasien->nama_pasien, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Alamat Pasien</label>
        <div class="controls">
            <?php echo CHtml::textArea('alamatpasien', $pendaftaran->pasien->alamat_pasien, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tanggal lahir</label>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir', MyFormatter::formatDateTimeForUser($pendaftaran->pasien->tanggal_lahir), array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Umur</label>
        <div class="controls">
            <?php echo CHtml::textField('umur', $pendaftaran->umur, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Jenis Kelamin</label>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin', $pendaftaran->pasien->jeniskelamin, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group hide">
        <label class="control-label">Golongan Darah / Rhesus</label>
        <div class="controls">
            <?php echo CHtml::textField('golongandarah', $pendaftaran->pasien->golongandarah." / ".$pendaftaran->pasien->rhesus, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Dokter yang Menangani</label>
        <div class="controls">
            <?php echo CHtml::textField('doktermenangani', $pendaftaran->pegawai->namaLengkap, array('readonly'=>true)); ?>
        </div>
    </div>
</div>



<?php
//========= Dialog buat data Permintaan Darah yang sudah Disiapkan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPermintaan',
    'options' => array(
        'title' => 'Daftar Permintaan Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPermintaan = new BDInfopermintaandarahpasien();
$modPermintaan->unsetAttributes();  // clear any default values
$format = new MyFormatter();
if (isset($_GET['BDInfopermintaandarahpasien'])){
    $modPermintaan->attributes = $_GET['BDInfopermintaandarahpasien']; 
    $modPermintaan->jeniskelamin = $_GET['BDInfopermintaandarahpasien']['jeniskelamin']; 
    $modPermintaan->alamat_pasien = $_GET['BDInfopermintaandarahpasien']['alamat_pasien']; 
    $modPermintaan->no_rekam_medik = $_GET['BDInfopermintaandarahpasien']['no_rekam_medik']; 
    $modPermintaan->nama_pasien = $_GET['BDInfopermintaandarahpasien']['nama_pasien']; 
    $modPermintaan->no_pendaftaran = $_GET['BDInfopermintaandarahpasien']['no_pendaftaran']; 
    // $modPermintaan->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDInfopermintaandarahpasien']['tgl_awal']);
    // $modPermintaan->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDInfopermintaandarahpasien']['tgl_akhir']);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'permintaandarah-grid',
    'dataProvider' => $modPermintaan->searchDialogUntukPenyerahanDarah(),
    'filter' => $modPermintaan,
    'template' => "{items}\n{pager}",
//    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
    
                $item = $data;
    
                $uji = UjidarahpasienT::model()->findByAttributes(array(
                    'metodedarah_id'=>Params::METODE_DARAH_ID_TUBE_TEST,
                    'permintaandarah_id'=>$item->permintaandarah_id,
                ));

                if (empty($uji)) return "-";

                $sub = $item->attributes;

                $pendaftaran = PendaftaranT::model()->findByPk($item->pendaftaran_id);

                $pendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran);

                $ruangan_id = $pendaftaran->ruangan_id;
                $kelaspelayanan_id = $pendaftaran->kelaspelayanan_id;
                $penjamin_id = $pendaftaran->penjamin_id;

                if (!empty($pendaftaran->pasienadmisi_id)) {
                    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                    $ruangan_id = $admisi->ruangan_id;
                    $kelaspelayanan_id = $admisi->kelaspelayanan_id;
                    $penjamin_id = $admisi->penjamin_id;
                }

                $ruangan = RuanganM::model()->findByPk($ruangan_id);
                $kelas = KelaspelayananM::model()->findByPk($kelaspelayanan_id);

                if (empty($ruangan)) {
                    $ruangan = new RuanganM;
                }

                if (empty($kelas)) {
                    $kelas = new KelaspelayananM;
                }

                $diagnosapasien = PasienmorbiditasT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                    'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
                ));

                $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);

                if (empty($penjamin)) {
                    $penjamin = new PenjaminpasienM;
                }

                if (empty($pendaftaran->pasien)) {
                    $pendaftaran->pasien = new PasienM;
                } else {
                    $pendaftaran->pasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($pendaftaran->pasien->tanggal_lahir);
                }

                if (empty($pendaftaran->pegawai)) {
                    $pendaftaran->pegawai = new PegawaiM;
                }

                $diagnosa_nama = "";
                if (!empty($diagnosapasien)) {
                    $diagnosa = DiagnosaM::model()->findByPk($diagnosapasien->diagnosa_id);
                    $diagnosa_nama = $diagnosa->diagnosa_kode." ".$diagnosa->diagnosa_nama;
                }

                $sub['diagnosa_nama'] = $diagnosa_nama;
                $sub['nama_pegawai'] = $pendaftaran->pegawai->namaLengkap;
                $sub['nama_pasien'] = $pendaftaran->pasien->nama_pasien;
                $sub['penjamin_nama'] = $penjamin->penjamin_nama;
                $sub['kelaspelayanan_nama'] = $kelas->kelaspelayanan_nama;
                $sub['ruangan_nama'] = $ruangan->ruangan_nama;
                $sub['pasien'] = $pendaftaran->pasien->attributes;
                $sub['pendaftaran'] = $pendaftaran->attributes;

                $sub['label'] = $item->no_permintaandarah." - ".$pendaftaran->no_pendaftaran." - ".$pendaftaran->pasien->nama_pasien;
                $sub['value'] = $item->permintaandarah_id;
    
                $res = CJSON::encode($sub);
                
                return CHtml::Link('<i class="icon-form-check"></i>','#',array('class'=>'btn-small', 
                'id' => 'selectBahan',
                'onClick' => '
                    setPermintaan('.$res.');
                    $("#dialogPermintaan").dialog("close");
                    return false;'
                ));
    
            },
        ),
        array(
            'header'=>'Tanggal Pendaftaran',
            'value'=>function($data){
                return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
            },
        ), 
        array(
            'header'=>'Nomor Pendaftaran',
            'name'=>'no_pendaftaran',
            'value'=>function($data){
                return $data->no_pendaftaran;
            },
        ), 
        array (
            'header' => 'Tanggal Permintaan',
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tglpermintaan);
            }
        ),
        array (
            'header' => 'No. Formulir',
            'name' => 'no_permintaandarah',
            'value' => function($data){
                return $data->no_permintaandarah;
            }
        ),
        array(
            'header' => 'Ruangan / DPJP ',
            'value' => function ($data) {
                $pe = PegawaiM::model()->findByPk($data->dpjp_id);
                $r = RuanganM::model()->findByPk($data->ruanganpemesan_id);
                
                $pe_nama = "";
                
                if (!empty($pe)) {
                    $pe_nama = $pe->namaLengkap;
                }
                
                echo $r->ruangan_nama." / ".$pe_nama;
            }
        ),         
        array(
            'header' => 'No. RM',
            'name' => 'no_rekam_medik',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien', 
            'name' => 'nama_pasien',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Jenis Kelamin', 
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($modPermintaan, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array(
                'empty'=>'-- Pilih --',
            )),
        ),
        array(
            'header' => 'Alamat', 
            'name' => 'alamat_pasien',
            'value' => '$data->alamat_pasien',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
