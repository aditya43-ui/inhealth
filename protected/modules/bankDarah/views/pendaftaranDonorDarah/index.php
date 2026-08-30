<?php Yii::app()->clientScript->registerScriptFile('js/dropdownMulti.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pendaftaranDonorDarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>

<div class="panel panel-gradient">	

    <div class="panel-heading">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel-title">Pendaftaran Donor Darah</div>
    </div><br>
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($modDaftarDonasi); ?>
    <?php echo $form->errorSummary($modPendonor); ?>
    <div class="panel-body">
        <div class="panel panel-primary panel-success" id="form-data-pendonor">
            <div class="panel-heading">
                <div class="panel-title">											
                    Pendaftaran Donor Darah																	
                </div>
            </div>
            <div class="row-fluid"><br><br>
                <div class="col-sm-6">  
                    <div class="control-group">
                        <?php echo CHtml::label('No. Formulir', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modDaftarDonasi, 'no_formulir', array('class' => 'span3 skip', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Cari Pegawai", 'pegawai_id', array('class' => 'control-label')) ?>
                        <div class = "controls">
                            <?php
                            echo $form->hiddenField($modPendonor, 'pegawai_id',array('class'=>'pegid reset'));
                            echo CHtml::hiddenField("sudahAdaPendonor",'');
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPendonor,
                                'attribute' => 'pegawai_nama',
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                        url: "' . Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat') . '",
                                                        dataType: "json",
                                                        data: {
                                                            term: request.term,
                                                        },
                                                        success: function (data) {
                                                            response(data);
                                                        }
                                                    })
                                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.nama_pegawai);
                                                        return false;
                                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                        //$("#' . Chtml::activeId($modPendonor, 'pegawai_id') . '").val(ui.item.pegawai_id);                                                             
                                                        cekData("pendonor",ui.item.pegawai_id);
                                                        return false;
                                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => 'Ketikan Nama Pegawai',
                                    'class' => 'span3 hurufs-only pegnama'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Cari Donor', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php 
                            echo $form->hiddenField($modPendonor, 'pendonor_id', array('readonly' => true, 'class'=>'donorid reset')); 
                            echo CHtml::hiddenField("sudahAdaPegawai",'');
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'no_lengkap',
                                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompletePendonor') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                    }',
                                    'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($modPendonor, 'pendonor_id') . '").val(ui.item.pendonor_id); 
                            return false;
                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Ketik Nomor Donor Lama',
                                    'class' => 'span3 donornama',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPendonor'),
                            ));
                            ?>
                        </div>
                    </div>   
                    <div class="control-group ">
                        <?php echo CHtml::label("No Identitas <span class=\"required\">*</span>", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPendonor, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control required jenisidentitas', 'onchange' => 'cekLength(this); valNIK(this);'));
                            ?>   
                            <br><br>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPendonor,
                                'attribute' => 'no_identitas',
                                'source' => 'js: function(request, response) {
                                    var jenisidentitas = $("#'.CHtml::activeId($modPendonor,"jenisidentitas").'").val();
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompleteNomorIdentitas') . '",
                                        dataType: "json",
                                        data: {
                                            no_identitas: request.term,
                                            jenisidentitas: jenisidentitas,
                                        },
                                        success: function (data) {
                                            response(data);
                                        }
                                    })
                                }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        cekData("pasien",ui.item.pasien_id);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'No. Identitas',
                                    'rel' => 'tooltip',
                                    'title' => 'Ketik No. Identitas',
                                    'onkeyup' => "setNumbersOnly(this);return $(this).focusNextInputField(event);",
                                    'onblur' => "valNIK(this);",
                                    'class' => 'form-control span3 alphanumeric-only required all-caps',
                                ),
                            ));
                            ?>
                        </div>
                    </div>                  
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Lengkap <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPendonor,
                                'attribute' => 'nama_lengkap',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutocompleteNamaLengkap') . '",
                                            dataType: "json",
                                            data: {
                                            nama_lengkap: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        //$(this).val(ui.item.value);
                                        cekData("pegawai",ui.item.pendonor_id);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Nama Lengkap',
                                    'rel' => 'tooltip',
                                    'title' => 'Ketik Nama Lengkap',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'required form-control span3 hurufs-only all-caps',
                                    'onblur' => "$('#BDPendonorM_donasi_ke').blur()",
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tempat Lahir <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPendonor,
                                'attribute' => 'tempat_lahir',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutocompleteTempatLahir') . '",
                                            dataType: "json",
                                            data: {
                                            tempat_lahir: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        $(this).val().toUpperCase();
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        $(this).val().toUpperCase();
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Kota/Kabupaten Kelahiran',
                                    'rel' => 'tooltip',
                                    'title' => 'Ketik tempat lahir pasien',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'required form-control span3 all-caps hurufs-only',
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Lahir <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                        <?php $modPendonor->tgllahir = $format->formatDateTimeForUser($modPendonor->tgllahir); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPendonor,
                                'attribute' => 'tgllahir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => '-17y',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker2 datemask required', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->radioButtonListInlineRow($modPendonor, 'jenis_kelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control skip')); ?>
                    <div class="control-group" id="pekerjaanpendonor" style="display: block">
                        <?php echo CHtml::label("Pekerjaan <span class='required'>*</span>", 'pekerjaan_id', array('class' => 'control-label')) ?>
                        <div class = "controls">
                            <?php
                            echo $form->hiddenField($modPendonor, 'pekerjaan_id',array('class' => 'reset required'));
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPendonor,
                                'attribute' => 'pekerjaan_nama',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutocompletePekerjaan') . '",
                                            dataType: "json",
                                            data: {
                                            pekerjaan_nama: request.term,
                                       },
                                       success: function (data) {
                                            response(data);
                                       }
                                   })
                                }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $("#' . Chtml::activeId($modPendonor, 'pekerjaan_id') . '").val(ui.item.value);                                         
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Ketikan Pekerjaan Pendonor',
                                    'rel' => 'tooltip',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'form-control span3 hurufs-only required',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPekerjaan'),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($modPendonor, 'agama', LookupM::getItems('agama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'empty' => '-- Pilih --')); ?>

                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Alamat Lengkap <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPendonor, 'alamat_lengkap', array('placeholder' => '', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Propinsi', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPendonor, 'propinsi_id', CHtml::listData($modPendonor->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span3',
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'model_nama' => '' . $modPendonor->getNamaModel() . '')),
                                    'update' => '#BDPendonorM_kabupaten_id')));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kabupaten', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPendonor, 'kabupaten_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span3',
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'model_nama' => '' . $modPendonor->getNamaModel() . '')),
                                    'update' => '#BDPendonorM_kecamatan_id')));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kecamatan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPendonor, 'kecamatan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span3',
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'model_nama' => '' . $modPendonor->getNamaModel() . '')),
                                    'update' => '#BDPendonorM_kelurahan_id')));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kelurahan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPendonor, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span3',)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Berat Badan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'beratbadan_kg', array('class' => 'span3 integer required', 'readonly' => false, 'maxlength' => 3)); ?> <label>kg</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tinggi Badan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'tinggibadan_cm', array('class' => 'span3 integer', 'readonly' => false, 'maxlength' => 3)); ?> <label>cm</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No telp aktif', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'notelp_pendonor', array('class' => 'span3 numbers-only', 'readonly' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No mobile aktif <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'nomobile_pendonor', array('class' => 'span3 numbers-only required', 'readonly' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Status Perkawinan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPendonor, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control span1')); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($modPendonor, 'gol_darah', LookupM::getItemsUrutan('golongandarah'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'empty' => '-- Pilih --')); ?>
                    <?php echo $form->radioButtonListInlineRow($modPendonor, 'rhesus', array("Positif" => "Positif", "Negatif" => "Negatif"), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>

        </div>
        <?php echo $this->renderPartial("form/_formAmbilPhoto", array('model' => $modPendonor), true); ?>
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">											
                    Riwayat Donor Darah																	
                </div>
            </div>
            <div class="row-fluid"><br><br>
                <div class="col-sm-6"> 
                    <?php echo $form->radioButtonListInlineRow($modPendonor, 'is_pernah_donor', array("1" => "Ya", "0" => "Tidak"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'cekPernahDonor(this);')); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modPendonor, 'is_pernahdonor1', array('readonly' => true,'class'=>'reset')) ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Donasi Terakhir di Luar ke-', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'donasi_ke', array('placeholder' => 'Donasi Terakhir Ke', 'class' => 'span3 numbers-only', 'readonly' => false)); ?>   
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Donasi Terakhir di ITD ke-', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'donor_itd_ke', array('placeholder' => 'Donasi Terakhir di ITD ke-', 'class' => 'span3', 'readonly' => true)); ?>   
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Donasi Terakhir', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div id="tgl_terkahir">
                                <?php $modPendonor->tgl_donor_terakhir = $format->formatDateTimeForUser($modPendonor->tgl_donor_terakhir); ?>
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPendonor,
                                    'attribute' => 'tgl_donor_terakhir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    //
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:204px;'
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tempat Donasi Terakhir', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'tempat_donor_terakhir', array('class' => 'span3', 'readonly' => false)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            <div class="panel-title">											

            </div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo CHtml::label('Waktu Pendaftaran', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modDaftarDonasi,
                                'attribute' => 'waktu_pendaftaran',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                //
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:204px;'
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Petugas', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modDaftarDonasi, 'nama_petugas_id', array('class' => 'span3 reset', 'readonly' => true)); ?>
                            <?php
                            $nama_petugas = '';
                            if (isset($modDaftarDonasi->nama_petugas_id)) {
                                $nama_petugas = PegawaiM::model()->findByPk($modDaftarDonasi->nama_petugas_id)->nama_pegawai;
                            }
                            ?>
                            <?php echo CHtml::textField('nama_petugas', $nama_petugas, array('class' => 'span3', 'readonly' => true)); ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Nama DPJP <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modDaftarDonasi, 'dpjp_id', array('class' => 'required')) ?>
                            <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modDaftarDonasi,
                                    'attribute' => 'dpjp_nama',
                                    'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                        url: "' . $this->createUrl('AutocompleteDpjp') . '",
                                                        dataType: "json",
                                                        data: {
                                                            term: request.term,
                                                            ruangan_id:' . Yii::app()->user->getState('ruangan_id') . '
                                                        },
                                                        success: function (data) {
                                                            response(data);
                                                        }
                                                    })
                                                }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'focus' => 'js:function( event, ui ) {
                                                                $(this).val("");
                                                                return false;
                                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.label);
                                                        $("#' . CHtml::activeId($modDaftarDonasi, 'dpjp_id') . '").val(ui.item.pegawai_id);
                                                        return false;
                                                }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3 required',
                                        'onblur' => 'if(this.value == "") $("#' . CHtml::activeId($modDaftarDonasi, 'dpjp_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogDPJP'),
                                ));?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">                    
                    <div class="control-group">
                        <?php echo CHtml::label('Lokasi Rekrutmen', '', array('class' => 'control-label')) ?> <br>
                        
                    </div>
                    <div class="control-group">
                        <?php 
                             echo $form->hiddenField($modDaftarDonasi, 'ruangan_rekruitmen_id', [
                                'class' => 'span3', 'id' => 'ruangan_rekruitmen_id'
                            ]);
                        ?>
                        <label for="" class="control-label"> <?php echo CHtml::checkBox('utdrs', false, [
                                'onclick' => 'setRuanganRekrutmen(this)'
                            ]);  ?> UTDRS</label>
                        
                        <div class="controls">
                            <?php 
                                echo $form->textField($modDaftarDonasi, 'lokasi_rekruitmen', [
                                    'class' => 'span3', 'id' => 'lokasi_rekruitmen'
                                ]);
                            ?>				 
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Pembuat Event', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modDaftarDonasi, 'pembuatevent',  array('class' => 'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>				 
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modDaftarDonasi, 'keterangan_donasi', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($modPendonor->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'cekForm();', 'disabled' => (isset($_GET['sukses'])) ? true : false));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
    ?>
    <?php
    $content = $this->renderPartial('tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php
    if (!empty($_GET['sukses'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-succes', 'onclick' => 'print();'));
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-primary', 'disabled' => true)) . "&nbsp";
    }
    ?>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('modPendonor' => $modPendonor, 'modDaftarDonasi' => $modDaftarDonasi)); ?>
<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $modPendonor->pendonor_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');

    }
</script>
<?php
//========= Dialog buat cari data Pendonor =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPendonor',
    'options' => array(
        'title' => 'Pencarian Pendonor',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPendonor = new BDPendonorM('searchDialog');
$modPendonor->unsetAttributes();
if (isset($_GET['BDPendonorM'])) {
    $modPendonor->attributes = $_GET['BDPendonorM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPendonor->searchDialog(),
    'filter' => $modPendonor,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;

                $photo = $data->photopendonor;
                $path_file = $path_file = Params::urlPendonorDirectory() . 'no_photo.jpeg';
                if (!empty($photo)) {
                    if (file_exists(Params::pathPendonorDirectory() . $photo)) {
                        $path_file = Params::urlPendonorDirectory() . $photo;
                    }
                }
                $id = $data->pendonor_id;
                $res['photopendonor'] = $photo;
                $res['path_file'] = $path_file;
                $res['temp_file'] = $photo;
                $res['pegawai'] = '';
                $res['sudahadapegawai'] = '';
                if (!empty($data->pegawai_id)){
                    $peg = PegawaiM::model()->findByPK($data->pegawai_id);
                    $res['sudahadapegawai'] = 'ada';
                    $res['pegawai'] = $peg->attributes;
                }

                $res = json_encode($res);

                return CHtml::Link("<i class='icon-form-check'></i>", "javascript:;", array("class" => "btn-small",
                            "href" => "",
                            "id" => "selectObat",
                            "onClick" => 'cekData("pegawai",'.$id.');'));
            },
        ),
        'no_pendonor',
        'no_identitas',
        'nama_lengkap',
        'tempat_lahir',
        array(
            'header' => 'Tanggal Lahir',
            'name' => 'tgllahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgllahir)',
            'filter' => $this->widget('MyDateTimePicker', array(
                'model' => $modPendonor,
                'attribute' => 'tgllahir',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT
                ),
                'htmlOptions' => array('readonly' => false, 'id' => 'tgllahir', 'class' => 'dtPicker3'),
                    ), true
            ),
        ),
        'jenis_kelamin',
        'gol_darah',
        'rhesus',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});

            jQuery(\'#tgllahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
            jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
            jQuery(\'#tgllahir_date\').on(\'click\', function(){jQuery(\'#tgllahir\').datepicker(\'show\');}); 
    }',
));
$this->endWidget();
//========= end Pendonor dialog =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDialogPetugas = new PegawaiM('search');
$modDialogPetugas->unsetAttributes();

if (isset($_GET['PegawaiM'])) {
    $modDialogPetugas->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogPetugas->search(),
    'filter' => $modDialogPetugas,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {                
                $res = $data->attributes;                                                
                $id=$data->pegawai_id;                               
                $res = json_encode($res);
                

                return CHtml::Link("<i class='icon-form-check'></i>", "javascript:;", array("class" => "btn-small",
                            "href" => "",
                            "id" => "selectObat",
                            "onClick" => 'cekData("pendonor",'.$id.');'));
            },
        ),
        'nomorindukpegawai',
        'nama_pegawai'
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
));
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPekerjaan',
    'options' => array(
        'title' => 'Daftar Pekerjaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDialogPekerjaan = new PekerjaanpendonorM('search');
$modDialogPekerjaan->unsetAttributes();

if (isset($_GET['PekerjaanpendonorM'])) {
    $modDialogPekerjaan->attributes = $_GET['PekerjaanpendonorM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pekerjaanpendonor-m-grid',
    'dataProvider' => $modDialogPekerjaan->search(),
    'filter' => $modDialogPekerjaan,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPekerjaan",
                    "onClick" => "
                        $(\"#' . CHtml::activeId($modPendonor, 'pekerjaan_id') . '\").val($data->pekerjaanpendonor_id);
                        $(\"#' . CHtml::activeId($modPendonor, 'pekerjaan_nama') . '\").val(\"$data->pekerjaanpendonor_nama\");
                        $(\"#dialogPekerjaan\").dialog(\"close\");
                "))',
        ),
        'pekerjaanpendonor_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
));
$this->endWidget();
?>
<?php
//========= Dialog buat cari data Keperawatan =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDPJP',
    'options' => array(
        'title' => 'Pencarian Data DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$pegawai = new PegawairuanganV();
$pegawai->unsetAttributes();
$pegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
$pegawai->kelompokpegawai_id = 1;
if (isset($_GET['PegawairuanganV'])) {
    $pegawai->attributes = $_GET['PegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'donor-t-grid',
    'dataProvider' => $pegawai->search(),
    'filter' => $pegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectPendaftaran",
                        "onClick" => "
                            $(\"#BDDaftardonasiT_dpjp_id\").val(\"$data->pegawai_id\"); 
                            $(\"#BDDaftardonasiT_dpjp_nama\").val(\"$data->nama_pegawai\");
                            $(\"#dialogDPJP\").dialog(\"close\");
                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($pegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama DPJP',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($pegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRuangan',
    'options' => array(
        'title' => 'Pencarian Ruangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modRuangan = new RuanganM('search');
$modRuangan->unsetAttributes();

if (isset($_GET['RuanganM'])) {
    $modRuangan->attributes = $_GET['RuanganM'];
    $modRuangan->instalasi_nama = isset($_GET['RuanganM']['instalasi_nama'])?$_GET['RuanganM']['instalasi_nama']:null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ruangan-grid',
    'dataProvider' => $modRuangan->searchDialog(),
    'filter' => $modRuangan,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {                
                $res = $data->attributes;                                                                                          
                $res = json_encode($res);
                

                return CHtml::Link("<i class='icon-form-check'></i>", "javascript:;", array("class" => "btn-small",
                            "href" => "",
                            "id" => "selectObat",
                            "onClick" => 'setRuangan('.$res.');'));
            },
        ),
        'instalasi_nama',
        'ruangan_nama'
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
));
$this->endWidget();
?>
<script>
    function valNIK(obj){
        var jenisidentitas = $("#<?php echo CHtml::activeId($modPendonor, "jenisidentitas"); ?>").val();                                   
        var no_identitas_pasien = $("#<?php echo CHtml::activeId($modPendonor, "no_identitas"); ?>").val();                                     
        
        
            if (jenisidentitas == '<?php echo Params::JENIS_IDENTITAS_KTP ?>'){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionAjax/cekNIK'); ?>',
                    data: {nik:no_identitas_pasien},
                    dataType: "json",
                    success: function (data) {                
                        $("#<?php echo CHtml::activeId($modPendonor, "tgllahir"); ?>").val(data.tanggal_lahir);      

                        setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                        setJenisKelamin(data.jeniskelamin);                        

                    },
                    error: function (jqXHR, textStatus, errorThrown) {                                    
                    }
                });
            }else{
                return false;
            }
        
    }
    
    function setPendonor(data,tipe) {
        if (data.status_seleksi == 'DITERIMA') {
            // Jika selisih_hari < 56
            if (data.selisih_hari <= 56) {
                toastr.error('Tidak dapat melakukan donor darah. Donasi terakhir kurang dari 56 hari.', "Perhatian!");
                $("#dialogPegawai").dialog('close');
                resetForm();
                return false;
            // Jika hasil_skriing = 'Reaktif'
            } else if(data.hasil_skrining == '<?php echo strtoupper(Params::HASIL_SKRINING_REAKTIF)?>'){
                toastr.error('Tidak dapat melakukan donor darah karena pendonor reaktif.', "Perhatian!");
                $("#dialogPegawai").dialog('close');
                resetForm();
                return false;
            }
        }                              
        $("#BDPendonorM_pegawai_id").val('');     
        $("#BDPendonorM_pegawai_nama").val('');     
        $("#BDPendonorM_pendonor_id").val(data.pendonor_id);        
        $("#BDPendonorM_jenisidentitas").val(data.jenisidentitas);
        $("#BDPendonorM_no_identitas").val(data.no_identitas);
        $("#BDPendonorM_nama_lengkap").val(data.nama_lengkap);
        $("#BDPendonorM_tempat_lahir").val(data.tempat_lahir);
        setJenisKelamin(data.jenis_kelamin);
        $("#BDPendonorM_pekerjaan_id").val(data.pekerjaan_id);  
        if (typeof data.pekerjaan_nama !== 'undefined'){
            $("#BDPendonorM_pekerjaan_nama").val(data.pekerjaan_nama);        
        }
        $("#no_lengkap").val(data.no_pendonor);
        $("#BDPendonorM_alamat_lengkap").val(data.alamat_lengkap);
        $("#BDPendonorM_beratbadan_kg").val(data.beratbadan_kg);
        $("#BDPendonorM_tinggibadan_cm").val(data.tinggibadan_cm);
        $("#BDPendonorM_notelp_pendonor").val(data.notelp_pendonor);
        $("#BDPendonorM_nomobile_pendonor").val(data.nomobile_pendonor);
        $("#BDPendonorM_statusperkawinan").val(data.statusperkawinan);
        $("#BDPendonorM_temp_file").val(data.temp_file);
        $("#BDPendonorM_gol_darah").val(data.gol_darah);
        $("#photo-preview").attr('src', data.path_file);
        $("#BDPendonorM_agama").val(data.agama);
        if (data.donasi_ke !== 0) {
            $("#BDPendonorM_donasi_ke").val(data.donasi_ke);
        } else {
            $("#BDPendonorM_donasi_ke").val('');
        }  
    
        if (data.donor_itd_ke !== null && data.donor_itd_ke > 0) {
            $("#BDPendonorM_donor_itd_ke").val(data.donor_itd_ke);
        } else {
            $("#BDPendonorM_donor_itd_ke").val('');
        }
        if (data.tgl_donor_terakhir !== null) {
            setTgl(data.tgl_donor_terakhir);
        }
        
        setTglLahir(data.tgllahir);
        setRhesus(data.rhesus);
        setPernah_donor(data.is_pernah_donor);                        
        $("#dialogPendonor").dialog('close');
        return false;
    }
    
    function setPasien(data,tipe) {
        if (data.status_seleksi == 'DITERIMA') {
            // Jika selisih hari < 56 
            if (data.selisih_hari <= 56) {
                toastr.error('Tidak dapat melakukan donor darah. Donasi terakhir kurang dari 56 hari.', "Perhatian!");
                $("#dialogPegawai").dialog('close');
                resetForm();
                return false;
            // Jika hasil skrining = reaktif 
            } else if(data.hasil_skrining == '<?php echo strtoupper(Params::HASIL_SKRINING_REAKTIF)?>'){
                toastr.error('Tidak dapat melakukan donor darah karena pendonor reaktif.', "Perhatian!");
                $("#dialogPegawai").dialog('close');
                resetForm();
                return false;
            }
        }
        $("#BDPendonorM_pegawai_id").val('');     
        $("#BDPendonorM_pegawai_nama").val('');     
        $("#BDPendonorM_pendonor_id").val(data.pendonor_id);        
        $("#BDPendonorM_jenisidentitas").val(data.jenisidentitas);
        $("#BDPendonorM_no_identitas").val(data.no_identitas_pasien);
        $("#BDPendonorM_nama_lengkap").val(data.nama_pasien);
        $("#BDPendonorM_tempat_lahir").val(data.tempat_lahir);
        $("#BDPendonorM_pekerjaan_id").val(data.pekerjaan_id);  
        if (typeof data.pekerjaan_nama !== 'undefined'){
            $("#BDPendonorM_pekerjaan_nama").val(data.pekerjaan_nama);        
        }

        $("#BDPendonorM_alamat_lengkap").val(data.alamat_pasien);
        $("#BDPendonorM_notelp_pendonor").val(data.no_telepon_pasien);
        $("#BDPendonorM_nomobile_pendonor").val(data.no_mobile_pasien);
        $("#BDPendonorM_statusperkawinan").val(data.statusperkawinan);
        $("#BDPendonorM_gol_darah").val(data.golongandarah);
        $("#photo-preview").attr('src', data.photopasien);
        $("#BDPendonorM_agama").val(data.agama);
        if (data.donasi_ke !== 0) {
            $("#BDPendonorM_donasi_ke").val(data.donasi_ke);
        } else {
            $("#BDPendonorM_donasi_ke").val('');
        }   
        if (data.donor_itd_ke !== null && data.donor_itd_ke > 0) {
            $("#BDPendonorM_donor_itd_ke").val(data.donor_itd_ke);
        } else {
            $("#BDPendonorM_donor_itd_ke").val('');
        }
        setJenisKelamin(data.jeniskelamin);
        setTglLahir(data.tanggal_lahir);
        setRhesus(data.rhesus);                       
        
        return false;
    }
    
    function resetForm(){       
        $("#form-data-pendonor").find('input:text,select,textarea').each(function(){
            if ($(this).hasClass('skip') == false){                                
                $(this).val('');                                 
            }
        });
        
        $("#form-data-pendonor").find('.reset').each(function(){            
            $(this).val('');                                             
        });
    }        
    
    function setPegawai(data,tipe) { 
        if (data.status_seleksi == 'DITERIMA') {
            // Jika selisih_hari < 56
            if (data.selisih_hari <= 56) {
                toastr.error('Tidak dapat melakukan donor darah. Donasi terakhir kurang dari 56 hari.', "Perhatian!");
                $("#dialogPegawai").dialog('close');
                resetForm();
                return false;
            // Jika hasil_skrining = 'reaktif'
            } else if(data.hasil_skrining == '<?php echo strtoupper(Params::HASIL_SKRINING_REAKTIF)?>'){
                toastr.error('Tidak dapat melakukan donor darah karena pendonor reaktif.', "Perhatian!");
                $("#dialogPegawai").dialog('close');
                resetForm();
                return false;
            }
        }
        $("#BDPendonorM_pendonor_id").val('');   
        $("#BDPendonorM_pegawai_id").val(data.pegawai_id);
        $("#BDPendonorM_pegawai_nama").val(data.nama_pegawai);
        $("#BDPendonorM_jenisidentitas").val(data.jenisidentitas);
        $("#BDPendonorM_no_identitas").val(data.noidentitas);
        $("#BDPendonorM_nama_lengkap").val(data.nama_pegawai);
        $("#BDPendonorM_tempat_lahir").val(data.tempatlahir_pegawai);
        setJenisKelamin(data.jenis_kelamin);
        $("#BDPendonorM_pekerjaan_id").val(data.pekerjaan_id);
        if (typeof data.pekerjaan_nama !== 'undefined'){
            $("#BDPendonorM_pekerjaan_nama").val(data.pekerjaan_nama);        
        }    
        $("#no_lengkap").val('');
        $("#BDPendonorM_alamat_lengkap").val(data.alamat_pegawai);
        $("#BDPendonorM_beratbadan_kg").val(data.beratbadan);
        $("#BDPendonorM_tinggibadan_cm").val(data.tinggibadan);
        $("#BDPendonorM_notelp_pendonor").val(data.notelp_pegawai);
        $("#BDPendonorM_nomobile_pendonor").val(data.nomobile_pegawai);
        $("#BDPendonorM_statusperkawinan").val(data.statusperkawinan);
        $("#BDPendonorM_gol_darah").val(data.golongandarah);
        $("#BDPendonorM_agama").val(data.agama);
        if (data.donasi_ke !== 0) {
            $("#BDPendonorM_donasi_ke").val(data.donasi_ke);
        } else {
            $("#BDPendonorM_donasi_ke").val('');
        }  
  
        if (data.donor_itd_ke !== null && data.donor_itd_ke > 0) {
            $("#BDPendonorM_donor_itd_ke").val(data.donor_itd_ke);
        } else {
            $("#BDPendonorM_donor_itd_ke").val('');
        }
        setTglLahir(data.tgl_lahirpegawai);
        setRhesus(data.rhesus);
        $("#dialogPegawai").dialog('close');
        
        return false;
    }
    
    function cekData(tipe, id){       
        var pegawai_id = $("#<?php echo CHtml::activeId($modPendonor, 'pegawai_id') ?>").val();
        var pendonor_id = $("#<?php echo CHtml::activeId($modPendonor, 'pendonor_id') ?>").val();
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('cekData'); ?>',
            data: {tipe:tipe,pegawai_id:pegawai_id,pendonor_id:pendonor_id, id},
            dataType: "json",
            success:function(data){
                if (data.reset == 'ya'){
                    resetForm();
                }
                                
                if (data.tipe == 'pegawai'){  
                    if (data.pegawai != ''){
                        setPegawai(data.pegawai); 
                    }
                    setPendonor(data);
                }else if (data.tipe == 'pasien'){ 
                    if (data.pasien != ''){
                        setPasien(data.pasien); 
                    }
                    setPasien(data);
                }else{
                    setPegawai(data); 
                    if (data.pendonor != ''){
                        setPendonor(data.pendonor); 
                    } 
                } 
                
                setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                
                setTimeout(function(){
                    $("#<?php echo CHtml::activeId($modPendonor, 'nama_lengkap') ?>").blur();
                },100);
                
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        }); 
    }
        $(document).ready(function () {
//        dropMulti('<?php echo CHtml::activeId($modDaftarDonasi, 'ruangan_rekruitmen_id') ?>', {
//            buttonWidth: '180px',
//        });
    });
</script>
