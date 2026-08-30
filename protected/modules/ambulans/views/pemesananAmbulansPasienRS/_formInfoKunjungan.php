<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('pendaftaran_id', $modKunjungan->pendaftaran_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php
        $pasienadmisi_id = (isset($modKunjungan->pasienadmisi_id) ? $modKunjungan->pasienadmisi_id : null);
        echo CHtml::hiddenField('pasienadmisi_id', $pasienadmisi_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));

        ?>
        <div class="control-group">
            <?php
            echo CHtml::label("Instalasi <span class='required'>*</span>", 'instalasi_id', array('class' => 'control-label required'));
            ?>
            <div class="controls">
                <?php
                if (!empty($modKunjungan->pendaftaran_id)) {
                    echo CHtml::hiddenField('instalasi_id', $modKunjungan->instalasi_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    echo CHtml::textField('instalasi_nama', $modKunjungan->instalasi_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                } else {
                    if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_AMBULANS or Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PENDAFTARAN) {
                        echo CHtml::dropDownList('instalasi_id', $modKunjungan->instalasi_id, CHtml::listData(AMInstalasiM::model()->getInstalasiPelayanans(), 'instalasi_id', 'instalasi_nama'), array('onchange' => 'setKunjunganReset();refreshDialogKunjungan();', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)",));
                    } else {
                        $instalasinama = Yii::app()->user->getState('instalasi_nama');
                        $instalasiId = Yii::app()->user->getState('instalasi_id');
                        echo CHtml::hiddenField('instalasi_id', $instalasiId, array('readonly' => true, 'class' => 'span4', 'value' => $instalasinama, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo CHtml::TextField('instalasi_nama', $instalasinama, array('readonly' => true, 'class' => 'span4', 'value' => $instalasinama, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    }
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Barcode <span class='required'>*</span>", 'cari_pendaftaran_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::textField('cari_pendaftaran_id', $modKunjungan->pendaftaran_id, array('onchange' => "if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')", 'class' => 'span4', 'placeholder' => 'Scan Barcode pada Print Status', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
            <div class="controls">
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
                        'minLength' => 3,
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
                        'placeholder' => 'No. Pendaftaran', 'autofocus' => true, 'class' => 'all-caps span4', 'rel' => 'tooltip', 'title' => 'No. pendaftaran / klik icon untuk mencari data kunjungan',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('tgl_pendaftaran', $modKunjungan->tgl_pendaftaran, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::hiddenField('tglselesaiperiksa', $modKunjungan->tglselesaiperiksa, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Poliklinik / Ruangan", 'ruangan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $ruangan_id = null;
                if (isset($modKunjungan->ruangan_id)) {
                    $ruangan_id = $modKunjungan->ruangan_id;
                } else if (isset($modKunjungan->ruanganakhir_id)) {
                    $ruangan_id = $modKunjungan->ruanganakhir_id;
                }
                echo CHtml::hiddenField('ruangan_id', $ruangan_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
                <?php echo CHtml::textField('ruangan_nama', $modKunjungan->ruangan_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('kelaspelayanan_id', $modKunjungan->kelaspelayanan_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::textField('kelaspelayanan_nama', $modKunjungan->kelaspelayanan_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('jeniskasuspenyakit_id', $modKunjungan->jeniskasuspenyakit_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::textField('jeniskasuspenyakit_nama', $modKunjungan->jeniskasuspenyakit_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('carabayar_id', $modKunjungan->carabayar_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::textField('carabayar_nama', $modKunjungan->carabayar_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('penjamin_id', $modKunjungan->penjamin_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::textField('penjamin_nama', $modKunjungan->penjamin_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Status Periksa", 'statusperiksa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('statusperiksa', $modKunjungan->statusperiksa, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No. Rekam Medik <span class='required'>*</span>", 'no_rekam_medik', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('pasien_id', $modKunjungan->pasien_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php // echo CHtml::textField('no_rekam_medik',$modKunjungan->no_rekam_medik,array('class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
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
                        'minLength' => 3,
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
                        'class' => 'numbers-only span4',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Pasien <span class='required'>*</span>", 'nama_pasien', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('namadepan', $modKunjungan->namadepan, array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
                        'minLength' => 3,
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
                        'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4'
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textArea('alamat_pasien', $modKunjungan->alamat_pasien, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Alias', 'nama_bin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('nama_bin', $modKunjungan->nama_bin, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('tanggal_lahir', $modKunjungan->tanggal_lahir, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Umur", 'umur', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('umur', $modKunjungan->umur, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('jeniskelamin', $modKunjungan->jeniskelamin, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('penanggungjawab_id', $modKunjungan->penanggungjawab_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::textField('nama_pj', $modKunjungan->nama_pj, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div style="text-align: center;">
            <?php
            $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
            ?>
            <img id="photo-preview" src="<?php echo $url_photopasien ?>" width="128px" />
        </div><br>
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
$modDialogKunjungan = new AMInfokunjunganrjV('searchDialogKunjungan');
$modDialogKunjungan->unsetAttributes();

$instalasi_id = Yii::app()->user->getState('instalasi_id');
$ruangan_nama = Yii::app()->user->getState('ruangan_nama');
if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_AMBULANS or Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PENDAFTARAN) {
    $modDialogKunjungan->instalasi_id = (isset($modKunjungan->instalasi_id) && !empty($modKunjungan->instalasi_id)) ? $modKunjungan->instalasi_id : Params::INSTALASI_ID_RJ;
} else {
    $modDialogKunjungan->instalasi_id = $instalasi_id;
    $modDialogKunjungan->ruangan_nama = $ruangan_nama;
} //$modDialogKunjungan->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['AMInfokunjunganrjV'])) {
    $modDialogKunjungan->attributes = $_GET['AMInfokunjunganrjV'];
    if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_AMBULANS or Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PENDAFTARAN) {
        //$modDialogKunjungan->instalasi_id = $_GET['AMInfokunjunganrjV']['instalasi_id'];
        // $modDialogKunjungan->instalasi_id = (isset($modKunjungan->instalasi_id)&&!empty($modKunjungan->instalasi_id))? $modKunjungan->instalasi_id : Params::INSTALASI_ID_RJ;
        $modDialogKunjungan->instalasi_id = $_GET['AMInfokunjunganrjV']['instalasi_id'];
        $modDialogKunjungan->ruangan_nama = (isset($_GET['AMInfokunjunganrjV']['ruangan_nama']) ? $_GET['AMInfokunjunganrjV']['ruangan_nama'] : "");
    } else {
        $modDialogKunjungan->instalasi_id = $instalasi_id;
        $modDialogKunjungan->ruangan_nama = $ruangan_nama;
        //$modDialogKunjungan->instalasi_id = $_GET['AMInfokunjunganrjV']['instalasi_id'];
        //$modDialogKunjungan->ruangan_nama = (isset($_GET['AMInfokunjunganrjV']['ruangan_nama']) ? $_GET['AMInfokunjunganrjV']['ruangan_nama'] : "");

    }
    $modDialogKunjungan->no_pendaftaran = (isset($_GET['AMInfokunjunganrjV']['no_pendaftaran']) ? $_GET['AMInfokunjunganrjV']['no_pendaftaran'] : "");
    $modDialogKunjungan->no_rekam_medik = (isset($_GET['AMInfokunjunganrjV']['no_rekam_medik']) ? $_GET['AMInfokunjunganrjV']['no_rekam_medik'] : "");
    $modDialogKunjungan->nama_pasien = (isset($_GET['AMInfokunjunganrjV']['nama_pasien']) ? $_GET['AMInfokunjunganrjV']['nama_pasien'] : "");
    $modDialogKunjungan->carabayar_nama = (isset($_GET['AMInfokunjunganrjV']['carabayar_nama']) ? $_GET['AMInfokunjunganrjV']['carabayar_nama'] : "");
    $modDialogKunjungan->instalasi_nama = (isset($_GET['AMInfokunjunganrjV']['instalasi_nama']) ? $_GET['AMInfokunjunganrjV']['instalasi_nama'] : "");
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
            //'header'=>'Tanggal Pendaftaran / Masuk Kamar',
            'header' => 'Tanggal Pendaftaran ',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($modDialogKunjungan, 'instalasi_id'),
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)
						.(isset($data->tglmasukkamar) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmasukkamar) : "")',
            //'filter'=> CHtml::activeTextField($modDialogKunjungan, 'tgl_pendaftaran', array('class'=>'span4','readonly'=>true)),
            /*$this->widget('MyDateTimePicker', array(
					'model' => $modDialogKunjungan,
					'attribute' => 'tgl_pendaftaran',
					'mode' => 'date', //date / datetime
					'gridFilter' => true,
					'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
					'maxDate'=>'d',
					),
					'htmlOptions' => array('readonly' => true, 'class' => "span2",
					'onkeypress' => "return $(this).focusNextInputField(event)"),
					),true),*/
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        'nama_pasien',
        //                    'jeniskelamin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'instalasi_id',
            'value' => '$data->instalasi_nama',
            'type' => 'raw',
            //'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id').CHtml::activeTextField($modDialogKunjungan,'instalasi_nama'),
            //'filter'=> CHtml::activeDropDownList($modDialogKunjungan, 'instalasi_id',CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true,'revenuecenter'=>true),array('order'=>'instalasi_nama')),'instalasi_id','instalasi_nama'), array('empty'=>'-- Pilih --')),
            'filter' => false,
            'visible' => Yii::app()->user->getState('modul_id') == Params::MODUL_ID_AMBULANS,
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'filter' => false,
            'visible' => Yii::app()->user->getState('modul_id') == Params::MODUL_ID_AMBULANS,
        ),
        array(
            'name' => 'carabayar_nama',
            'type' => 'raw',
            //'filter'=>false,
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
            'name' => 'penjamin_nama',
            'type' => 'raw',
            //'filter'=>false,
            'value' => '$data->penjamin_nama',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'penjamin_id', CHtml::listData(
                PenjaminpasienM::model()->findAllByAttributes(array(
                    'penjamin_aktif' => true,
                ), array('order' => 'penjamin_nama')),
                'penjamin_id',
                'penjamin_nama'
            ), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'name' => 'statusperiksa',
            'type' => 'raw',
            //                /'filter'=>false,
            'value' => '$data->statusperiksa',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'statusperiksa', Params::statusPeriksa(), array('empty' => '-- Pilih --')),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
				jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//				jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//				jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker("show");});
                                jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").daterangepicker({
                                    "maxDate": "' . date('m/d/Y') . '",
                                    "showDropdowns": true,
                                });
			}',
));
$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function() {
        $('input[name="AMInfokunjunganrjV[tgl_pendaftaran]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>