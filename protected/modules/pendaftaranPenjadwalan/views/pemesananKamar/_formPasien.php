<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jpegcam/assets/webcam.js');   
?>
<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");
?>

<style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Pribadi</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php
                            $modPasien->isPasienLama = true;
                            echo $form->hiddenField($modPasien, 'isPasienLama', array('readonly' => true));
                            ?>
                            <?php echo CHtml::label("Cari NIP", 'nomorindukpegawai', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'cari_nomorindukpegawai',
                                    'value' => $modPegawai->nomorindukpegawai,
                                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutocompletePasienLama') . '",
								dataType: "json",
								data: {
									nomorindukpegawai: request.term,
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
								setPasienLama(ui.item.pasien_id);
								return false;
							}',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPasienBadak'),
                                    'htmlOptions' => array(
                                        'placeholder' => 'NIP', 'rel' => 'tooltip', 'title' => 'Ketik NIP untuk mencari pasien',
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        //                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                                        'class' => 'span3 numbers-only'
                                    ),
                                ));
                                ?>
                                <?php // echo $form->error($modPasien,'no_rekam_medik'); 
                                ?>
                                <?php // echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Cari " . $modPasien->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'cari_no_rekam_medik',
                                    'value' => $modPasien->no_rekam_medik,
                                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutocompletePasienLama') . '",
								dataType: "json",
								data: {
									no_rekam_medik: request.term,
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
								setPasienLama(ui.item.pasien_id);
								return false;
							}',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPasien'),
                                    'htmlOptions' => array(
                                        'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'onblur' => "if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                                        'class' => 'span3 numbers-only'
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($modPasien, 'no_rekam_medik'); ?>
                                <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'no_identitas_pasien', array('class' => 'control-label refreshable')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPasien, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',));
                                ?>
                                <br><br>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modPasien,
                                    'attribute' => 'no_identitas_pasien',
                                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutocompletePasienLama') . '",
								dataType: "json",
								data: {
									no_identitas_pasien: request.term,
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
								$(this).val( ui.item.no_identitas_pasien);
								setPasienLama(ui.item.pasien_id);
								return false;
							}',
                                    ),
                                    'htmlOptions' => array('placeholder' => 'No. Identitas Pasien', 'rel' => 'tooltip', 'title' => 'No. Identitas untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'),
                                ));
                                ?>

                                <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
                                <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPasien, 'namadepan', LookupM::getItems('namadepan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'style' => 'float:left;'));
                                ?>
                                <br><br>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modPasien,
                                    'attribute' => 'nama_pasien',
                                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePasienLama') . '",
										   dataType: "json",
										   data: {
											   nama_pasien: request.term,
											   tanggal_lahir: $("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").val(),
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
								$(this).val( ui.item.nama_pasien);
								setPasienLama(ui.item.pasien_id);
								return false;
							}',
                                    ),
                                    'htmlOptions' => array('placeholder' => 'Nama Lengkap Pasien', 'rel' => 'tooltip', 'title' => 'Ketik Nama untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 ' . $nama_kapital),
                                ));
                                ?>
                                <?php echo $form->error($modPasien, 'namadepan'); ?>
                                <?php echo $form->error($modPasien, 'nama_pasien'); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('placeholder' => 'Alias / Nama Panggilan Pasien', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modPasien, 'tempat_lahir', array('placeholder' => 'Kota/Kabupaten Kelahiran', 'class' => 'span3 all-caps', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'tanggal_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $modPasien->tanggal_lahir = (!empty($modPasien->tanggal_lahir) ? date("d/m/Y", strtotime($modPasien->tanggal_lahir)) : null);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasien,
                                    'attribute' => 'tanggal_lahir',
                                    'mode' => 'date',
                                    'options' => array(
                                        //                                            'dateFormat'=>Params::DATE_FORMAT,
                                        'showOn' => false,
                                        'maxDate' => 'd',
                                        'onkeyup' => "js:function(){setUmur(this.value);}",
                                        'onSelect' => 'js:function(){setUmur(this.value);}',
                                        'yearRange' => "-150:+0",
                                    ),
                                    'htmlOptions' => array(
                                        'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onblur' => 'setUmur(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'span3 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                        <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => '')); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPasien, 'golongandarah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'));
                                ?>
                                <div class="radio inline">
                                    <div class="form-inline">
                                        <?php echo $form->radioButtonList($modPasien, 'rhesus', LookupM::getItems('rhesus'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'rhesus')); ?>
                                    </div>
                                </div>
                                <?php echo $form->error($modPasien, 'golongandarah'); ?>
                                <?php echo $form->error($modPasien, 'rhesus'); ?>
                            </div>
                        </div>
                        <?php echo $form->dropDownListRow($modPasien, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaDepan()', 'class' => 'span3')); ?>
                        <?php echo $form->textFieldRow($modPasien, 'nama_ayah', array('placeholder' => 'Nama Ayah Kandung Pasien', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success ">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <!--<i class="glyphicon glyphicon-camera"></i> Foto Pasien
                            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>-->
                            <a class="btn btn-default" onclick="$('#dialog-addphoto').dialog('open'); putarWebcam();" id="btn-addphoto" onkeyup="return $(this).focusNextInputField(event)">
                                <i class="glyphicon glyphicon-camera"></i> Ambil Foto
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->hiddenField($modPasien, 'photopasien', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                        <div style="text-align: center;">
                            <?php
                            $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
                            ?>
                            <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;">
                        </div>
                    </div>
                </div>
                <div class="panel panel-success ">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-map-marker"></i> Alamat dan Kontak
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 50, 'class' => 'autogrow span3 ' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'rt', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPasien, 'rt', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbers-only', 'maxlength' => 3, 'placeholder' => 'RT')); ?> /
                                <?php echo $form->textField($modPasien, 'rw', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbers-only', 'maxlength' => 3, 'placeholder' => 'RW')); ?>
                                <?php echo $form->error($modPasien, 'rt'); ?>
                                <?php echo $form->error($modPasien, 'rw'); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'propinsi_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modPasien, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))),
                                        'update' => "#" . CHtml::activeId($modPasien, 'kabupaten_id'),
                                    ),
                                    'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                                ));
                                ?>
                                <?php /* RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                          array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialog-addpropinsi').dialog('open');}",
                          'id'=>'btn-addpropinsi','onkeyup'=>"return $(this).focusNextInputField(event)",
                          'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('propinsi_id'))) */ ?>
                                <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modPasien, 'kabupaten_id', CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array(
                                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                                        'update' => "#" . CHtml::activeId($modPasien, 'kecamatan_id'),
                                    ),
                                    'onchange' => "setClearDropdownKelurahan();",
                                ));
                                ?>
                                <?php /* RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                          array('class'=>'btn btn-primary','onclick'=>"{addKabupaten(); $('#dialog-addkabupaten').dialog('open');}",
                          'id'=>'btn-addkabupaten','onkeyup'=>"return $(this).focusNextInputField(event)",
                          'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('kabupaten_id'))) */ ?>
                                <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modPasien, 'kecamatan_id', CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array(
                                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                                        'update' => "#" . CHtml::activeId($modPasien, 'kelurahan_id'),
                                    ),
                                    'onchange' => "",
                                ));
                                ?>
                                <?php /* RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                          array('class'=>'btn btn-primary','onclick'=>"{addKecamatan(); $('#dialogAddKecamatan').dialog('open');}",
                          'id'=>'btn-addkecamatan','onkeyup'=>"return $(this).focusNextInputField(event)",
                          'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('kecamatan_id'))) */ ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'kelurahan_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php // $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id))?$modPasien->kelurahan_id:Yii::app()->user->getState('kelurahan_id');
                                ?>
                                <?php echo $form->dropDownList($modPasien, 'kelurahan_id', CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                ?>
                                <?php /* RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                          array('class'=>'btn btn-primary','onclick'=>"{addKelurahan(); $('#dialog-addkelurahan').dialog('open');}",
                          'id'=>'btn-addkelurahan','onkeyup'=>"return $(this).focusNextInputField(event)",
                          'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('kelurahan_id'))) */ ?>
                                <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("No. Handphone Pasien", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                                <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
                            </div>
                        </div>

                        <?php echo $form->textFieldRow($modPasien, 'no_telepon_pasien', array('placeholder' => 'No. Telepon', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'pekerjaan_id', array('class' => 'control-label refreshable')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPasien, 'agama', array('class' => 'control-label refreshable')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPasien, 'agama', LookupM::getItems('agama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-6">
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-detailpasien',
                    'content' => array(
                        'content-detailpasien' => array(
                            'header' => '<b>Detail Pasien</b>',
                            'isi' => $this->renderPartial($this->path_view . '_formDetailPasien', array(
                                'form' => $form,
                                'model' => $model,
                                'modPasien' => $modPasien,
                                'nama_kapital' => $nama_kapital,
                            ), true),
                            'active' => false,
                        ),
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pegawai',
                    'content' => array(
                        'content-pegawai' => array(
                            'header' => '<b>Pegawai Penanggung Jawab</b>',
                            'isi' => $this->renderPartial($this->path_view . '_formPegawai', array(
                                'form' => $form,
                                'model' => $model,
                                'modPasien' => $modPasien,
                                'modPegawai' => $modPegawai,
                            ), true),
                            'active' => !empty($modPasien->pegawai_id) ? true : false,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian No Rekam Medik Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDataPasien = new PPPasienM('searchDialog');
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
$modDataPasien->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
    //        $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
    $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modDataPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modDataPasien->searchDialog(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasienLama(\"$data->pasien_id\");
                                            $(\"#dialogPasien\").dialog(\"close\");
                                        "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasienM[jeniskelamin]', $modDataPasien->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
        ),
        //                    array(
        //                        'name'=>'tanggal_lahir',
        //                        'type'=>'raw',
        //                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
        //                    ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            'filter' => false,
            //            'filter' => $this->widget('MyDateTimePicker', array(
            //                'model' => $modDataPasien,
            //                'attribute' => 'tanggal_lahir',
            //                'mode' => 'date',
            //                'options' => array(
            //                    'dateFormat' => Params::DATE_FORMAT,
            //                ),
            //                'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
            //                    ), true
            //            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
        ),
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama'
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasienM[statusrekammedis]', $modDataPasien->statusrekammedis, LookupM::getItems('statusrekammedis'), array('empty' => '-- Pilih --')),
            'value' => '$data->statusrekammedis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
//                        showMonthAfterYear:false}, 
//                        jQuery.datepicker.regional[\'id\'], 
//                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
//                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
//                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
//                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienBadak',
    'options' => array(
        'title' => 'Pencarian NIP Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienbadak-m-grid',
    'dataProvider' => $modDataPasien->searchDialogBadak(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasienLama(\"$data->pasien_id\");
                                            $(\"#dialogPasienBadak\").dialog(\"close\");
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => '$data->pegawai->nomorindukpegawai',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasienM[jeniskelamin]', $modDataPasien->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
        ),
        //                    array(
        //                        'name'=>'tanggal_lahir',
        //                        'type'=>'raw',
        //                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
        //                    ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modDataPasien,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
        ),
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama'
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasienM[jeniskelamin]', $modDataPasien->jeniskelamin, LookupM::getItems('statusrekammedis'), array('empty' => '-- Pilih --')),
            'value' => '$data->statusrekammedis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
));
$this->endWidget();
?>
<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addpropinsi',
    'options' => array(
        'title' => 'Menambah data Provinsi',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end propinsi dialog =============================
// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addkabupaten',
    'options' => array(
        'title' => 'Menambah data Kabupaten',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kabupaten dialog =============================
// Dialog buat nambah data kecamatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKecamatan',
    'options' => array(
        'title' => 'Menambah data Kecamatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kecamatan dialog =============================
// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addkelurahan',
    'options' => array(
        'title' => 'Menambah data Kelurahan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kelurahan dialog =============================
?>
<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addphoto',
    'options' => array(
        'title' => 'Ambil Foto',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 360,
        'height' => 250,
        'resizable' => false,
    ),
));
?>

<div id="dialog-content" style="text-align: center;">
    <div id="cam-preview"></div>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-cog"></i>')), array('rel' => 'tooltip', 'title' => 'Konfigurasi Kamera', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'webcam.configure();', 'style' => 'font-size:10px; width:32px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil', array('{icon}' => '<i class="entypo-camera"></i>')), array('id' => 'btn_ambil_gambar', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'ambilGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-download-alt icon-white"></i>')), array('id' => 'btn_simpan_gambar', 'disabled' => true, 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'simpanGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_ulang_gambar', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'ulangGambar();', 'style' => 'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    <?php
    $random = rand(0000000000000000, 9999999999999999);
    ?>
    /**
     * ambil gambar pada webcam
     * @returns {Boolean}
     */
    function ambilGambar() {
        webcam.freeze();
        $("#btn_ambil_gambar").attr("disabled", true);
        $("#btn_simpan_gambar").removeAttr("disabled");
    }
    /**
     * menyimpan / meng-upload gambar
     * @returns {undefined}
     */
    function simpanGambar() {
        $("#btn_simpan_gambar").attr("disabled", true);
        document.getElementById('upload_results').innerHTML = '<h3>Proses Penyimpanan...</h3>';
        //    webcam.snap(); << sering bugs hasil photo blank putih
        webcam.upload();
    }
    /**
     * mengulang pengambilan gambar
     * @returns {undefined}
     */
    function ulangGambar() {
        $("#btn_ambil_gambar").removeAttr("disabled");
        $("#btn_simpan_gambar").attr("disabled", true);
        webcam.reset();
    }
    /**
     * keterangan setelah berhasil ambil gambar webcam
     * @returns {Boolean}
     */
    function suksesUpload(msg) {
        if (msg == 'OK') {
            $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
            setTimeout(function() {
                document.getElementById('upload_results').innerHTML = '';
                $("#<?php echo CHtml::activeId($modPasien, 'photopasien') ?>").val("<?php echo $random ?>.jpg")
                $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" . $random; ?>.jpg');
                $('#dialog-addphoto').dialog('close');
            }, 3000);

        } else {
            myAlert("PHP Error: " + msg);
        }
    }
    $(document).ready(function() {
        /**
         * set webcam
         * @returns {Boolean}
         */
        <?php if (!isset($_GET['sukses'])) { ?>

            function setWebcam() {
                webcam.set_api_url('index.php?r=photoWebCam/jpegcam.saveJpg&random=<?php echo $random; ?>&pathTumbs=<?php echo Params::pathPasienTumbsDirectory(); ?>&path=<?php echo Params::pathPasienDirectory(); ?>');
                webcam.set_quality(90);
                webcam.set_shutter_sound(false);
                webcam.set_stealth(1);
                webcam.set_swf_url('<?php echo Yii::app()->baseUrl . '/js/jpegcam/assets/'; ?>webcam.swf');
                $('#cam-preview').append(webcam.get_html(303, 320));
                webcam.set_hook('onComplete', 'suksesUpload');
            }
            setWebcam();
        <?php } ?>
    });
</script>
<script>
    function showDateTime() {
        $("#PPPasienM_tanggal_lahir").datepicker();
    }
</script>

<?php //================= end dialog webcam =====================  
?>