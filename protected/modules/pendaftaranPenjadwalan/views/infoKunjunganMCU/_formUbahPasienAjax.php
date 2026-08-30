<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'pppendaftaran-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
                'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
            )); ?>
            <?php echo $form->errorSummary($modPasien); ?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jpegcam/assets/webcam.js'); ?>
            <?php
            $nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
            $alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");
            ?>
            <div class="col-sm-6">
                <div class="control-group" hidden>
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
                                'class' => 'numbers-only'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label($modPasien->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPasien, 'no_rekam_medik', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                        <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modPasien,
                            'jenisidentitas',
                            LookupM::getItems('jenisidentitas'),
                            array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'style' => 'float:left; width:80px')
                        ); ?>
                        <?php echo $form->textField(
                            $modPasien,
                            'no_identitas_pasien',
                            array(
                                'placeholder' => 'No. Identitas Pasien',
                                'rel' => 'tooltip',
                                'title' => 'No. Identitas untuk masukan data / mencari pasien',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span2'

                            )
                        );
                        ?>
                        <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
                        <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php //echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                        //    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:80px')); 
                        ?>
                        <?php echo $form->textField(
                            $modPasien,
                            'nama_pasien',
                            array(
                                'placeholder' => 'Nama Lengkap Pasien',
                                'rel' => 'tooltip',
                                'title' => 'Ketik Nama untuk masukan data / mencari pasien',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span2 ' . $nama_kapital
                            )
                        );
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
                                'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onblur' => 'setUmur(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                        <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($modPendaftaran, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'span3 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

                <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => '')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modPasien,
                            'golongandarah',
                            LookupM::getItems('golongandarah'),
                            array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1')
                        ); ?>
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
                <?php echo $form->textFieldRow($modPasien, 'nama_ibu', array('placeholder' => 'Nama Ibu Kandung Pasien', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 50, 'class' => 'span3 ' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
                        <?php echo $form->dropDownList(
                            $modPasien,
                            'propinsi_id',
                            CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))),
                                    'update' => "#" . CHtml::activeId($modPasien, 'kabupaten_id'),
                                ),
                                'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                            )
                        ); ?>
                        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialog-addpropinsi').dialog('open');}",
                                      'id'=>'btn-addpropinsi','onkeyup'=>"return $(this).focusNextInputField(event)",
                                      'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('propinsi_id'))) */ ?>
                        <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">

                <div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modPasien,
                            'kabupaten_id',
                            CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                                    'update' => "#" . CHtml::activeId($modPasien, 'kecamatan_id'),
                                ),
                                'onchange' => "setClearDropdownKelurahan();",
                            )
                        ); ?>
                        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                                    array('class'=>'btn btn-primary','onclick'=>"{addKabupaten(); $('#dialog-addkabupaten').dialog('open');}",
                                                          'id'=>'btn-addkabupaten','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                          'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('kabupaten_id'))) */ ?>
                        <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modPasien,
                            'kecamatan_id',
                            CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                                    'update' => "#" . CHtml::activeId($modPasien, 'kelurahan_id'),
                                ),
                                'onchange' => "",
                            )
                        ); ?>
                        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
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
                        <?php echo $form->dropDownList(
                            $modPasien,
                            'kelurahan_id',
                            CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")
                        ); ?>
                        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                                    array('class'=>'btn btn-primary','onclick'=>"{addKelurahan(); $('#dialog-addkelurahan').dialog('open');}",
                                                          'id'=>'btn-addkelurahan','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                          'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('kelurahan_id'))) */ ?>
                        <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->textFieldRow($modPasien, 'no_telepon_pasien', array('placeholder' => 'No. Telepon', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
                <?php echo $form->dropDownListRow($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($modPasien, 'agama', LookupM::getItems('agama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                <?php echo  $form->hiddenField($modPasien, 'photopasien', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <div style="text-align: center;">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Ambil Foto', array('{icon}' => '<i class="entypo-camera"></i>')),
                        array(
                            'class' => 'btn btn-primary', 'onclick' => "$('#dialog-addphoto').dialog('open');",
                            'id' => 'btn-addphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk Ambil Foto'
                        )
                    ) ?>
                    <br>
                    <?php
                    $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
                    ?>
                    <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;">
                </div>
                <?php echo $form->textFieldRow($modPasien, 'alamatemail', array('placeholder' => 'contoh: info@.com', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->dropDownListRow($modPasien, 'suku_id', CHtml::listData($modPasien->getSukuItems(), 'suku_id', 'suku_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($modPasien, 'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($modPasien, 'nama_ayah', array('placeholder' => 'Nama Ayah Kandung Pasien', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'anakke', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPasien, 'anakke', array('class' => 'span1 integer', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' dari '; ?>
                        <?php echo $form->textField($modPasien, 'jumlah_bersaudara', array('class' => 'span1 integer', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' bersaudara'; ?>
                    </div>
                </div>


            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-primary', 'type' => 'submit', 'onkeypress' => 'setVerifikasi();')
            ); //formSubmit(this,event) 
            ?>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
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
            'filter' => CHtml::dropDownList('PPPasienM[statusrekammedis]', $modDataPasien->statusrekammedis, LookupM::getItems('statusrekammedis'), array('empty' => '-- Pilih --')),
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

<div id="dialog-content" style="text-align: center;">
    <div id="cam-preview"></div>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-cog icon-white"></i>')), array('rel' => 'tooltip', 'title' => 'Konfigurasi Kamera', 'class' => 'btn btn-mini btn-primary', 'type' => 'button', 'onclick' => 'webcam.configure();', 'style' => 'font-size:10px; width:32px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil', array('{icon}' => '<i class="entypo-camera"></i>')), array('id' => 'btn_ambil_gambar', 'class' => 'btn btn-mini btn-primary', 'type' => 'button', 'onclick' => 'ambilGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-download-alt icon-white"></i>')), array('id' => 'btn_simpan_gambar', 'disabled' => true, 'class' => 'btn btn-mini btn-primary', 'type' => 'button', 'onclick' => 'simpanGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_ulang_gambar', 'class' => 'btn btn-mini btn-danger', 'type' => 'button', 'onclick' => 'ulangGambar();', 'style' => 'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>

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
        /**
         * set webcam
         * @returns {Boolean}
         */
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
    });
</script>
<script>
    function showDateTime() {
        $("#PPPasienM_tanggal_lahir").datepicker();
    }

    function setUmur(tanggal_lahir) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmur'); ?>',
            data: {
                tanggal_lahir: tanggal_lahir
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPendaftaran, "umur"); ?>").val(data.umur);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /** bersihkan dropdown kecamatan */
    function setClearDropdownKecamatan() {
        $("#<?php echo CHtml::activeId($modPasien, "kecamatan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    /** bersihkan dropdown kelurahan */
    function setClearDropdownKelurahan() {
        $("#<?php echo CHtml::activeId($modPasien, "kelurahan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
</script>

<?php //================= end dialog webcam ===================== 
?>