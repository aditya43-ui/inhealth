<style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
<div class="col-sm-6">
    <?php /*
    <div class="control-group">
        <?php echo CHtml::label("Barcode", 'cari_pendaftaran_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('instalasi_id',$modKunjungan->instalasi_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('cari_pendaftaran_id',$modKunjungan->pendaftaran_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
	 * 
	 */ ?>
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran", 'no_pendaftaran', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pendaftaran_id', $modKunjungan->pendaftaran_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php
            $pasienadmisi_id = (isset($modKunjungan->pasienadmisi_id) ? $modKunjungan->pasienadmisi_id : null);
            echo CHtml::hiddenField('pasienadmisi_id', $pasienadmisi_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
            ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'no_pendaftaran',
                'value' => $modKunjungan->no_pendaftaran,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_pendaftaran: request.term,
                                                       instalasi_id: $("#instalasi_id").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                            setResume(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogKunjungan'),
                'htmlOptions' => array(
                    'placeholder' => 'No. Pendaftaran', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'No. pendaftaran / klik icon untuk mencari data kunjungan',
                    'onkeyup' => "if($(this).val() == ''){ $(no_pendaftaran).focus() }else{return $(this).focusNextInputField(event)}", 'onchange' => "if($(this).val() == '') setKunjunganReset();"
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran', $modKunjungan->tgl_pendaftaran, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Poliklinik / Ruangan Terakhir", 'ruangan_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruangan_id', $modKunjungan->ruangan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('ruangan_nama', $modKunjungan->ruangan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kelas Pelayanan Terakhir", 'kelaspelayanan_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('kelaspelayanan_id', $modKunjungan->kelaspelayanan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('kelaspelayanan_nama', $modKunjungan->kelaspelayanan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('jeniskasuspenyakit_id', $modKunjungan->jeniskasuspenyakit_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('jeniskasuspenyakit_nama', $modKunjungan->jeniskasuspenyakit_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Penjamin Terakhir", 'carabayar_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('carabayar_id', $modKunjungan->carabayar_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('carabayar_nama', $modKunjungan->carabayar_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penjamin Terakhir", 'penjamin_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id', $modKunjungan->penjamin_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama', $modKunjungan->penjamin_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Istri / Suami / Anak ", 'pegawaipenanggung_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('pegawaipenanggung_nama', $modKunjungan->pegawaipenanggung_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('pegawaipenanggung_id', $modKunjungan->pegawaipenanggung_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">

    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id', $modKunjungan->pasien_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php // echo CHtml::textField('no_rekam_medik',$modKunjungan->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'no_rekam_medik',
                'value' => $modKunjungan->no_rekam_medik,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                       instalasi_id: $("#instalasi_id").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                            setResume(ui.item.pendaftaran_id);
											return false;
                                        }',
                ),
                //'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                'htmlOptions' => array(
                    'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. rekam medik untuk mencari data kunjungan',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3 numbers-only',
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('namadepan', $modKunjungan->namadepan, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'nama_pasien',
                'value' => $modKunjungan->nama_pasien,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                                   dataType: "json",
                                                   data: {
                                                       nama_pasien: request.term,
                                                       instalasi_id: $("#instalasi_id").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
											setResume(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                ),
                'htmlOptions' => array(
                    'class' => 'span3', 'placeholder' => 'Nama Pasien', 'rel' => 'tooltip', 'title' => 'Ketik nama pasien untuk mencari data kunjungan',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                ),
            ));
            ?>
        </div>
    </div>
    <?php /*
		<div class="control-group">
			<?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	 * 
	 */ ?>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir', $modKunjungan->tanggal_lahir, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur', $modKunjungan->umur, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin', $modKunjungan->jeniskelamin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id', $modKunjungan->penanggungjawab_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj', $modKunjungan->nama_pj, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Dokter Yang Menangani ", 'dokterpenanggungjawab_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('dokterpenanggungjawab_nama', $modKunjungan->dokterpenanggungjawab_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Keluar RS', 'tglpasienpulang', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tglpasienpulang', $modKunjungan->tglpasienpulang, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <!--RND-3002 >>    <div class="control-group">
        <?php // echo CHtml::label("Status Penanggung Jawab", 'pengantar', array('class'=>'control-label')); 
        ?>
        <div class="controls">
            <?php // echo CHtml::textField('pengantar',$modKunjungan->pengantar,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>-->

</div>
<div class="col-sm-6">
    <div style="text-align: center;">
        <?php
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien ?>" width="128px" />
    </div><br>
    <div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien', $modKunjungan->alamat_pasien, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<?php
// LNG-221 Jika Memakai dialog box akan memberatkan load data pasien, solusinya dengan menggunakan autocomplete
// ========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKunjungan',
    'options' => array(
        'title' => 'Pencarian Data Kunjungan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 500,
        'resizable' => false,
    ),
));


$modDialogKunjungan = new RKInfopasienpengunjungV('searchDialogKunjungan');
$modDialogKunjungan->unsetAttributes();

// $modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['RKInfopasienpengunjungV'])) {
    $modDialogKunjungan->attributes = $_GET['RKInfopasienpengunjungV'];
    $modDialogKunjungan->no_pendaftaran = (isset($_GET['RKInfopasienpengunjungV']['no_pendaftaran']) ? $_GET['RKInfopasienpengunjungV']['no_pendaftaran'] : "");
    $modDialogKunjungan->no_rekam_medik = (isset($_GET['RKInfopasienpengunjungV']['no_rekam_medik']) ? $_GET['RKInfopasienpengunjungV']['no_rekam_medik'] : "");
    $modDialogKunjungan->nama_pasien = (isset($_GET['RKInfopasienpengunjungV']['nama_pasien']) ? $_GET['RKInfopasienpengunjungV']['nama_pasien'] : "");
    $modDialogKunjungan->carabayar_nama = (isset($_GET['RKInfopasienpengunjungV']['carabayar_nama']) ? $_GET['RKInfopasienpengunjungV']['carabayar_nama'] : "");
    $modDialogKunjungan->ruangan_nama = (isset($_GET['RKInfopasienpengunjungV']['ruangan_nama']) ? $_GET['RKInfopasienpengunjungV']['ruangan_nama'] : "");
}

if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ || Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI || Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD) {
    $dataProvider = $modDialogKunjungan->searchKunjunganRuanganDialog();
} else {
    $dataProvider = $modDialogKunjungan->searchDialogKunjungan();
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $dataProvider,
    'filter' => $modDialogKunjungan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setKunjungan($data->pendaftaran_id, \"\", \"\", \"\");											
                                            setResume($data->pendaftaran_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
        ),
        'no_pendaftaran',
        array(
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' => false,
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'name' => 'nama_pasien',
            'value' => '$data->namadepan.$data->nama_pasien',
        ),
        //                    'jeniskelamin',
        array(
            'name' => 'jeniskelamin',
            'header' => 'Jenis Kelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ), /*
                    array(
                        'header'=>'Instalasi',
                        'name'=>'instalasi_id',
                        'value'=>'$data->instalasi_nama',
                        'type'=>'raw',
//                        'filter'=>CHtml::listData(BKPendaftaranT::model()->getInstalasis(),'instalasi_id','instalasi_nama'), //dipilih dari instalasi form kunjungan
                        'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id'),
                    ),
                    array(
                        'header'=>'Ruangan',
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                    ), */
        array(
            'header' => 'Jenis Penjamin',
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//======= end pendaftaran dialog =============
?>