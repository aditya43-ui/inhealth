<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Data <b>Kunjungan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Instalasi", 'instalasi_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                            echo CHtml::dropDownList('instalasi_id', $modKunjungan->instalasi_id, CHtml::listData(BKInstalasiM::model()->getInstalasiPelayanans(), 'instalasi_id', 'instalasi_nama'), array('onchange' => 'resetPencarianRuangan(); setKunjunganReset(); refreshDialogKunjungan();', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
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
                                'minLength' => 4,
                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val( "");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.value);
                                                        setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                                        return false;
                                                    }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKunjungan'),
                            'htmlOptions' => array(
                                'placeholder' => 'No. Pendaftaran', 'class' => 'all-caps span3 required', 'rel' => 'tooltip', 'title' => 'No. pendaftaran / klik icon untuk mencari data kunjungan',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('tgl_pendaftaran', $modKunjungan->tgl_pendaftaran, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::hiddenField('tglselesaiperiksa', MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s")), array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Poliklinik / Ruangan", 'ruangan_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('ruangan_id', $modKunjungan->ruangan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('ruangan_nama', $modKunjungan->ruangan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('kelaspelayanan_id', $modKunjungan->kelaspelayanan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('kelaspelayanan_nama', $modKunjungan->kelaspelayanan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Kelas Tanggungan", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('kelastanggungan_nama', null, array('readonly' => true, 'class' => 'span3 info_kelastanggungan_id', 'onkeyup' => "return $(this).focusNextInputField(event);", 'data-weight' => 0)); ?>
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
                    <?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('carabayar_id', $modKunjungan->carabayar_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('carabayar_nama', $modKunjungan->carabayar_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('penjamin_id', $modKunjungan->penjamin_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('penjamin_nama', $modKunjungan->penjamin_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('pasien_id', $modKunjungan->pasien_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. rekam medik untuk mencari data kunjungan',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'numbers-only span3 required',
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
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Nama Pasien', 'rel' => 'tooltip', 'title' => 'Ketik nama pasien untuk mencari data kunjungan',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 required',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Alias', 'nama_bin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('nama_bin', $modKunjungan->nama_bin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
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
                    <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textArea('alamat_pasien', $modKunjungan->alamat_pasien, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKunjungan',
    'options' => array(
        'title' => 'Pencarian Data Kunjungan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogKunjungan = new BKInformasikasirrawatjalanV('searchDialogKunjungan');
$modDialogKunjungan->unsetAttributes();
$modDialogKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
if (isset($_GET['BKInformasikasirrawatjalanV'])) {
    $modDialogKunjungan->attributes = $_GET['BKInformasikasirrawatjalanV'];
    $modDialogKunjungan->instalasi_id = $_GET['BKInformasikasirrawatjalanV']['instalasi_id'];
    $modDialogKunjungan->no_pendaftaran = (isset($_GET['BKInformasikasirrawatjalanV']['no_pendaftaran']) ? $_GET['BKInformasikasirrawatjalanV']['no_pendaftaran'] : "");
    $modDialogKunjungan->no_rekam_medik = (isset($_GET['BKInformasikasirrawatjalanV']['no_rekam_medik']) ? $_GET['BKInformasikasirrawatjalanV']['no_rekam_medik'] : "");
    $modDialogKunjungan->nama_pasien = (isset($_GET['BKInformasikasirrawatjalanV']['nama_pasien']) ? $_GET['BKInformasikasirrawatjalanV']['nama_pasien'] : "");
    $modDialogKunjungan->carabayar_nama = (isset($_GET['BKInformasikasirrawatjalanV']['carabayar_nama']) ? $_GET['BKInformasikasirrawatjalanV']['carabayar_nama'] : "");
    $modDialogKunjungan->ruangan_nama = (isset($_GET['BKInformasikasirrawatjalanV']['ruangan_nama']) ? $_GET['BKInformasikasirrawatjalanV']['ruangan_nama'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogKunjungan->searchDialogKunjungan(),
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
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')) .
                CHtml::activeHiddenField($modDialogKunjungan, 'instalasi_id'),
        ), /*
			array(
				'name'=>'instalasi_id',
				'value'=>'$data->instalasi_nama',
				'type'=>'raw',
//                        'filter'=>CHtml::listData(BKPendaftaranT::model()->getInstalasis(),'instalasi_id','instalasi_nama'), //dipilih dari instalasi form kunjungan
				'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id'),
			),
             * 
             */
        array(
            'header' => 'Ruangan',
            'name' => 'ruangan_id',
            'type' => 'raw',
            'value' => '$data->ruangan_nama',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'ruangan_id', CHtml::listData(
                RuanganM::model()->findAllByAttributes(array(
                    'instalasi_id' => $modDialogKunjungan->instalasi_id,
                    'ruangan_aktif' => true,
                ), array('order' => 'ruangan_nama')),
                'ruangan_id',
                'ruangan_nama'
            ), array(
                'empty' => '-- Pilih --', 'id' => 'dialog_pasien_ruangan_id'
            )),
        ),
        array(
            'header' => 'Jenis Penjamin',
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', CHtml::listData(
                CarabayarM::model()->findAllByAttributes(array(
                    'carabayar_aktif' => true,
                ), array('order' => 'carabayar_nama')),
                'carabayar_id',
                'carabayar_nama'
            ), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Status Periksa',
            'name' => 'statusperiksa',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'statusperiksa', Params::statusPeriksa(), array('empty' => '-- Pilih --')),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>