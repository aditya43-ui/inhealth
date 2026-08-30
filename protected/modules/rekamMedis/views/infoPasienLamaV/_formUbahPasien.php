<div class="row">
    <?php echo $form->errorSummary($model); ?>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Cari NIP", 'nomorindukpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPegawai, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'cari_nomorindukpegawai',
                    'value' => $modPegawai->nomorindukpegawai,
                    'source' => 'js: function(request, response) {
													   $.ajax({
														   url: "' . $this->createUrl('AutocompleteNobadge') . '",
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
													 $("#cari_nomorindukpegawai").val(ui.item.value);
													 $("#' . CHtml::activeId($modPegawai, 'pegawai_id') . '").val(ui.item.pegawai_id);
													return false;
												}',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasienBadak'),
                    'htmlOptions' => array(
                        'placeholder' => 'NIP', 'rel' => 'tooltip', 'title' => 'Ketik NIP untuk mencari pasien',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        //                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                        'class' => 'numbers-only'
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("Cari No. Badge", 'nomorindukpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPegawai, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'cari_nomorindukpegawai',
                    'value' => $modPegawai->nomorindukpegawai,
                    'source' => 'js: function(request, response) {
                                                                                                       $.ajax({
                                                                                                               url: "' . $this->createUrl('AutocompleteNobadge') . '",
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
                                                                                                     $("#cari_nomorindukpegawai").val(ui.item.value);
                                                                                                     $("#' . CHtml::activeId($modPegawai, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                                                                                    return false;
                                                                                            }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasienBadak'),
                    'htmlOptions' => array(
                        'placeholder' => 'No. Badge', 'rel' => 'tooltip', 'title' => 'No. Badge untuk mencari pasien',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        //                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                        'class' => 'numbers-only'
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($model, 'no_rekam_medik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => TRUE)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgl_rekam_medik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tgl_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => TRUE)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'no_identitas_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'jenisidentitas',
                    LookupM::getItems('jenisidentitas'),
                    array(
                        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1'
                    )
                ); ?>
                <?php echo $form->textField($model, 'no_identitas_pasien', array('placeholder' => 'No. Identitas', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                <?php echo $form->error($model, 'jenisidentitas'); ?><?php echo $form->error($model, 'no_identitas'); ?>
            </div>
        </div>
        <?php // echo $form->textFieldRow($model,'no_identitas_pasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); 
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nama_pasien', array('class' => 'control-label')) ?>
            <div class="controls inline">

                <?php echo $form->dropDownList(
                    $model,
                    'namadepan',
                    LookupM::getItems('namadepan'),
                    array(
                        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1', "disabled" => false,
                    )
                ); ?>
                <?php echo $form->textField($model, 'nama_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>

                <?php echo $form->error($model, 'namadepan'); ?><?php echo $form->error($model, 'nama_pasien'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_bin', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'tempat_lahir', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                )); ?>
                <?php echo $form->error($model, 'tanggal_lahir'); ?>
            </div>
        </div>
        <?php // echo $form->textFieldRow($modPendaftaran,'umur',array('placeholder'=>'00 Thn 00 Bln 00 Hr','class'=>'span3 umur', 'onblur'=>'setTglLahir(this);','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); 
        ?>
        <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaGelar()", 'class' => 'reqPasien jk')); ?>
        <?php echo $form->dropDownListRow($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaGelar()', 'class' => 'span3')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'golongandarah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'golongandarah',
                    LookupM::getItems('golongandarah'),
                    array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')
                ); ?>
                <div class="radio inline">
                    <div class="form-inline">
                        <?php echo $form->radioButtonList($model, 'rhesus', LookupM::getItems('rhesus'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'golongandarah'); ?>
                <?php echo $form->error($model, 'rhesus'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_ibu', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Ibu')); ?>
        <?php echo $form->textFieldRow($model, 'nama_ayah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Ayah')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'alamat_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'rt', array('class' => 'control-label inline')) ?>

            <div class="controls">
                <?php echo $form->textField($model, 'rt', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'maxlength' => 3)); ?> /
                <?php echo $form->textField($model, 'rw', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'maxlength' => 3)); ?>
                <?php echo $form->error($model, 'rt'); ?>
                <?php echo $form->error($model, 'rw'); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow(
            $model,
            'propinsi_id',
            CHtml::listData(PropinsiM::model()->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
            array(
                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
                    'update' => '#PPPasienM_kabupaten_id'
                )
            )
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'kabupaten_id',
            CHtml::listData(KabupatenM::model()->getKabupatenItemsProp($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
            array(
                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
                    'update' => '#PPPasienM_kecamatan_id'
                )
            )
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'kecamatan_id',
            CHtml::listData(KecamatanM::model()->getKecamatanItemsKab($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
            array(
                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($model))),
                    'update' => '#PPPasienM_kelurahan_id',
                )
            )
        ); ?>
        <?php echo $form->dropDownListRow($model, 'kelurahan_id', CHtml::listData(KelurahanM::model()->getKelurahanItemsKec($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

        <?php echo $form->dropDownListRow(
            $model,
            'pekerjaan_id',
            CHtml::listData(PekerjaanM::model()->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'),
            array(
                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekStatusPekerjaan(this)',
                //                                                                    'ajax'=>array('type'=>'POST',
                //                                                                                  'url'=>$this->createUrl('GetPekerjaan',array('encode'=>false,'namaModel'=>'RKPasienM')),
                //                                                                                  'update'=>'#PPPasienM_pekerjaan_id'
                //                                                                                  )
            )
        ); ?>

        <?php echo $form->textFieldRow($model, 'no_telepon_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_mobile_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'agama', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'warga_negara', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>

        <div style="text-align: center;">
            <?php
            if (!empty($model->photopasien)) {
                echo CHtml::image(Params::urlPasienTumbsDirectory() . 'kecil_' . $model->photopasien, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
            } else {
                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
            }
            ?>
        </div>
        <br>
        <div class="control-group">
            <div class="control-label">
                Foto Pasien
            </div>
            <div class="controls">
                <?php echo $form->fileField($model, 'photopasien', array('onchange' => "readURL(this);", 'maxlength' => 254, 'hint' => 'Isi jika akan mengganti photo', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <p class="help-block">Isi jika akan mengganti photo</p>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienBadak',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDataPasien = new RKPasienM('search');
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
$modDataPasien->ispasienluar = FALSE;
if (isset($_GET['RKPasienM'])) {
    $modDataPasien->attributes = $_GET['RKPasienM'];
    //        $modDataPasien->tanggal_lahir =  isset($_GET['RKPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['RKPasienM']['tanggal_lahir']) : null;
    $modDataPasien->cari_kelurahan_nama = $_GET['RKPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['RKPasienM']['cari_kecamatan_nama'];
    if (isset($_GET['RKPasienM']['nomorindukpegawai'])) {
        $modDataPasien->nomorindukpegawai = $_GET['RKPasienM']['nomorindukpegawai'];
    }
}
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
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setNobadge(\"$data->pegawai_id\");
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
            'filter' => LookupM::model()->getItems('jeniskelamin'),
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
            'filter' => LookupM::getItems('statusrekammedis'),
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


<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#photo_pasien')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script type="text/javascript">
    // here is the magic
    function convertToUpper(obj) {
        var string = obj.value;
        $(obj).val(string.toUpperCase());
    }

    function setNamaGelar() {
        var statusperkawinan = $('#PPPasienM_statusperkawinan').val();
        var namadepan = $('#PPPasienM_namadepan');
        var umur = $("#<?php echo CHtml::activeId($model, 'thn'); ?>").val();
        // umur = parseInt(umur);

        if (umur <= 5) {
            var namadepan = $('#PPPasienM_namadepan').val('By.');
            if (statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR") {
                $('#PPPasienM_statusperkawinan').val('');
                myAlert('Maaf status perkawinan belum cukup usia');
            }
        } else if (umur <= 13) { //
            var namadepan = $('#PPPasienM_namadepan').val('An.');
            if (statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR") {
                $('#PPPasienM_statusperkawinan').val('');
                myAlert('Maaf status perkawinan belum cukup usia');
            }
        } else {
            if ($('#PPPasienM_jeniskelamin_0').is(':checked')) {
                if (statusperkawinan !== 'JANDA') {
                    var namadepan = $('#PPPasienM_namadepan').val('Tn.');
                } else {
                    myAlert('Silakan pilih status pernikahan yang sesuai!');
                    $('#PPPasienM_statusperkawinan').val('KAWIN');
                    var namadepan = $('#PPPasienM_namadepan').val('Tn.');
                }

            }

            if ($('#PPPasienM_jeniskelamin_1').is(':checked')) {
                if (statusperkawinan !== 'DUDA') {
                    if (statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI') {
                        var namadepan = $('#PPPasienM_namadepan').val('Ny.');
                    } else {
                        var namadepan = $('#PPPasienM_namadepan').val('Nn');
                    }
                } else {
                    myAlert('Silakan pilih status pernikahan yang sesuai!');
                    $('#PPPasienM_statusperkawinan').val('KAWIN');
                    var namadepan = $('#PPPasienM_namadepan').val('Ny.');
                }
            }

            if (statusperkawinan == "DIBAWAH UMUR") {
                myAlert('Silakan pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
            }
        }

    }

    function cekJenisKelamin(obj) {
        var is_true = true;
        var namadepan = $('#PPPasienM_namadepan').val();
        if (namadepan.length != 0) {
            if (obj.value == 'PEREMPUAN') {
                if (namadepan != 'Nn.' && namadepan != 'Ny.' && namadepan != 'By.') {
                    myAlert('Silakan pilih Jenis kelamin yang sesuai!');
                    $('#PPPasienM_jeniskelamin_0').attr('checked', true);
                    is_true = false;
                }
            } else {
                if (namadepan != 'Tn.' && namadepan != 'An.' && namadepan != 'By.') {
                    myAlert('Silakan pilih Jenis kelamin yang sesuai!');
                    $('#PPPasienM_jeniskelamin_1').attr('checked', true);
                    is_true = false;
                }
            }
        } else {
            $(obj).attr('checked', false);
            myAlert('Silakan pilih gelar kehormatan terlebih dahulu!');
        }
    }

    function setValueStatus(obj) {
        var gelar = obj.value;
        if (gelar === 'Tn.') {
            $('#PPPasienM_jeniskelamin_0').attr('checked', true);
            $('#PPPasienM_statusperkawinan').val('KAWIN');

        } else if (gelar === 'An.') {
            $('#PPPasienM_jeniskelamin_0').attr('checked', true);
            $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
        } else {
            if (gelar === 'Nn' || gelar === 'By.') {
                $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
            } else {
                $('#PPPasienM_statusperkawinan').val('KAWIN');
            }
            $('#PPPasienM_jeniskelamin_1').attr('checked', true);
        }
    }

    function setStatusPerkawinan(obj) {
        var status = obj.value;
        var namaDepan = $('#PPPasienM_namadepan').val();

        if (status === 'BELUM KAWIN') {
            if (namaDepan !== 'An.' && namaDepan !== 'Nn' && namaDepan !== 'By.') {
                myAlert('Silakan pilih status perkawinan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('KAWIN');
            }
        } else {
            if (status === 'KAWIN' || status === 'NIKAH SIRIH' || status === 'POLIGAMI') {
                if (namaDepan !== 'Tn.' && namaDepan !== 'Ny.') {
                    myAlert('Silakan pilih status perkawinan yang sesuai!');
                    $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
                }
            } else if (status === 'JANDA') {
                if (namaDepan !== 'Ny.') {
                    myAlert('Silakan pilih status perkawinan yang sesuai!');
                    if (namaDepan === 'Tn.') {
                        $('#PPPasienM_statusperkawinan').val('KAWIN');
                    } else {
                        $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
                    }
                }
            } else if (status === 'DUDA') {
                if (namaDepan !== 'Tn.') {
                    myAlert('Silakan pilih status perkawinan yang sesuai!');
                    if (namaDepan === 'Ny.') {
                        $('#PPPasienM_statusperkawinan').val('KAWIN');
                    } else {
                        $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
                    }
                }
            }
        }
    }

    function cekStatusPekerjaan(obj) {
        var namaDepan = $('#PPPasienM_namadepan').val();
        var namaPekerjaan = obj.value;
        var umur = $("#<?php echo CHtml::activeId($model, 'thn'); ?>").val();
        // umur = parseInt(umur);

        if (namaDepan.length > 0) {
            if (umur < 15) {
                if (namaPekerjaan !== '12') {
                    if (namaPekerjaan !== '') {
                        myAlert('Pasien masih di bawah umur,silakan cek kembali!');
                    }
                    $(obj).val('');
                } else {
                    $(obj).val(namaPekerjaan);
                }
            } else {
                if (namaPekerjaan === '12') {
                    if (namaDepan === 'Ny.') {
                        $(obj).val('9');
                    } else if (namaDepan === 'Nn' && namaPekerjaan === '9') {
                        myAlert('Pasien belum menikah,silakan cek kembali!');
                        $(obj).val('');
                    } else {
                        $(obj).val('');
                    }
                    myAlert('Silakan pilih pekerjaan yang tepat');
                } else {
                    if (namaPekerjaan === '9') {
                        if (namaDepan !== 'Ny.') {
                            myAlert('Pasien seorang laki-laki,silakan cek kembali!');
                            $(obj).val('');
                        }
                    }
                }
            }
            /*        
                    if(namaPekerjaan === '12' && umur < 17)
                    {
                        if(namaDepan !== 'BY. Ny.' && namaDepan !== 'An.' && namaDepan !== 'Nn')
                        {
                            myAlert('Silakan pilih pekerjaan yang sesuai!');
                            $(obj).val('');
                        }
                    }else{
                        if(namaDepan === 'BY. Ny.')
                        {
                            myAlert('Silakan pilih pekerjaan yang sesuai!');
                            $(obj).val('');
                        }else{
                            if(namaPekerjaan === '11' || namaPekerjaan === '10')
                            {
                                if(namaDepan !== 'An.' && namaDepan !== 'Nn'){
                                    myAlert('Silakan pilih pekerjaan yang sesuai!');
                                    $(obj).val('');
                                }
                            }else{
                                if(namaPekerjaan !== '13' && namaPekerjaan !== '14')
                                {
                                    if(namaPekerjaan === '9' && namaDepan !== 'Ny.')
                                    {
                                        myAlert('Silakan pilih pekerjaan yang sesuai!');
                                        $(obj).val('');
                                    }else{
                                        if((namaDepan === 'An.' || namaDepan === 'Nn') && umur < 25){
                                            myAlert('Silakan pilih pekerjaan yang sesuai!');
                                            $(obj).val('');
                                        }                        
                                    }
                                }
                            }
                        }
                    }
            */
        } else {
            $(obj).val('');
            myAlert('Silakan pilih gelar kehormatan terlebih dahulu!');
        }

    }

    /**
     * set nilai tanggal_lahir dari umur 
     * @param {type} obj
     * @returns {undefined} */
    function setTglLahir(obj) {
        var str = obj.value;
        obj.value = str.replace(/_/gi, "0");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggalLahir'); ?>',
            data: {
                umur: obj.value
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "tanggal_lahir"); ?>").val(data.tanggal_lahir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nilai umur dari tanggal_lahir 
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmur(tanggal_lahir) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmur'); ?>',
            data: {
                tanggal_lahir: tanggal_lahir
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php // echo CHtml::activeId($modPendaftaran,"umur");
                    ?>").val(data.umur);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setNobadge(pegawai_id) {
        $("#cari_nomorindukpegawai").parents(".control-group").addClass("animation-loading-1");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetNobadge'); ?>',
            data: {
                pegawai_id: pegawai_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#cari_nomorindukpegawai").val(data);
                $("#<?php echo CHtml::activeId($modPegawai, 'pegawai_id'); ?>").val(pegawai_id);
                $("#cari_nomorindukpegawai").parents(".control-group").removeClass("animation-loading-1");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function() {
        tglLahir = $("#<?php echo CHtml::activeId($model, "tanggal_lahir"); ?>").val();
        //  setUmur(tglLahir);
    })
</script>