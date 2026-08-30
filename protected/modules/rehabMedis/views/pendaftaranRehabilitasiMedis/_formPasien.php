<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/protected/extensions/jpegcam/assets/webcam.js'); ?>
<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");

$konSys = KonfigsystemK::model()->find();
?>

<?php
//if (!isset($_GET['sukses'])){ //RSPMC-1273
if (Yii::app()->user->getState('is_finger_pasien')) {
?>
    <div class="col-sm-12">
        <div id="loading"></div>
        <?php
        echo CHtml::tag('button', array(
            'id' => 'pendaftaranFP', 'onclick' => 'setPendaftaranFP();', 'class' => 'btn btn-danger',
        ), '<i class="entypo-check"></i> Pendaftaran Sidik Jari');
        echo CHtml::tag('button', array(
            'id' => 'verifikasiFP', 'onclick' => 'setVerifikasiFP();', 'class' => 'btn btn-primary'
        ), '<i class="entypo-check"></i> Verifikasi Sidik Jari');
        ?>
        <?php //echo CHtml::button("Batal",array('id'=>'batalVerifFP','onclick' => 'batalVerifikasiFP();', 'class' => 'btn btn-danger',));  
        ?>
        <div id="pesanVerifikasi">&nbsp;</div>
    </div>
<?php
}
//}
?>

<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data <b>Pribadi</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group" hidden>
                <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::radioButton('rb_rm', false, array(
                        'value' => 1,
                        'name' => 'otomatis',
                        'uncheckValue' => null,
                        'onchange' => 'switchOtomatis(this)',
                        'class' => 'rb_rm rmbaru',
                    )) . "<label>Pasien</label> ";
                    echo CHtml::radioButton('rb_rm', false, array(
                        'value' => 0,
                        'name' => 'otomatis',
                        'uncheckValue' => null,
                        'onchange' => 'switchOtomatis(this)',
                        'class' => 'rb_rm rmlama',
                    )) . "<label>Pasien</label> ";
                    ?>
                </div>
            </div>
            <!--</div>-->
            <div class="control-group">
                <label class="control-label" style="padding-top: 0px;">
                    <?php echo CHtml::dropDownList('cari_pasien', null, array(
                        'nomor_peserta' => 'No. Peserta',
                        'no_rujukan' => 'No. Rujukan',
                        'nik' => 'NIK Pasien',
                        //'no_kk'=>'No.KK Pasien',
                        'nip' => 'NIP Pasien',
                    ), array(
                        'class' => 'span2', 'onchange' => 'setPlaceHolderNomor();', 'id' => 'tipe_nomor_pasien',
                    )); ?>
                </label>
                <div class="controls">
                    <?php echo CHtml::textField('nomor_cari', '', array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => "cariNomorPasien();",
                        'id' => 'cari_nomor_pasien',
                        'class' => 'span3',
                    )); ?>
                </div>

            </div>
            <div class="control-group rm_baru rm_state" hidden>
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
                            'class' => 'numbers-only form-control delapan span3'
                        ),
                    ));
                    ?>
                    <?php // echo $form->error($modPasien,'no_rekam_medik'); 
                    ?>
                    <?php // echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); 
                    ?>
                </div>
            </div>
            <?php /*
    <div class="control-group rm_nip_baru">
        <?php echo CHtml::label("NIP", 'nomorindukpegawai', array('class'=>'control-label'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modPasien,
                    'attribute'=>'nomorindukpegawai',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('autocompletePegawaiUntukPasienBaru').'",
                                       dataType: "json",
                                       data: {
                                           nip: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                     'options'=>array(
                           'minLength' => 3,
                            'focus'=> 'js:function( event, ui ) {
                                 return false;
                             }',
                           'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.nip);
                                setPegawai(ui.item.pegawai_id, ui.item.nip);
                                return false;
                            }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogPasienBadak'),
                    'htmlOptions'=>array('placeholder'=>'NIP','rel'=>'tooltip','title'=>'Ketik NIP untuk mencari Pegawai',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        // 'onblur'=>"setPegawai(null, this.value); return false;",
                        'class'=>'numbers-only span3'),
                )); 
            ?>                     
            <?php echo $form->hiddenField($modPasien,'pegawai_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
     * 
     */ ?>
            <div class="control-group rm_baru" id="no_rm_lama" hidden>
                <?php echo CHtml::label($modPasien->getAttributeLabel('no_rekam_medik') . " <span class=\"required\">*</span>", 'no_rekam_medik', array("id" => "lb_rm_lama", 'class' => 'control-label required')) ?>
                <div class="controls">
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPasien,
                        'attribute' => 'no_rekam_medik',
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
                                            console.log("A1");
                                            $(this).val( ui.item.value);
                                            setPasienLama(ui.item.pasien_id);
                                            return false;
                                        }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPasien'),
                        'htmlOptions' => array(
                            'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => "cekNoRM();if($(this).val()==''){setPasienBaru();}else{setPasienLama('',this.value, true)}",
                            'class' => 'numbers-only f_rm form-control delapan span3', 'maxlength' => 8, 'id' => 'no_rekam_medik_baru'
                        ),
                    )); ?>
                    <?php /* echo $form->textField($modPasien, 'no_rekam_medik', array(
                'id'=>'no_rekam_medik_baru', 
                'class'=>'numbers-only span3',
                'rel'=>'tooltip',
                'title'=>'No. RM pasien yang ada sebelumnya',
                'maxlength'=>6,
            )); */ ?>
                </div>
            </div>
            <div class="control-group rm_lama rm_state" hidden>
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
                            'class' => 'numbers-only f_rm', 'maxlength' => 6,
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
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'jenisidentitas',
                        LookupM::getItems('jenisidentitas'),
                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'onchange' => 'cekLength(this);')
                    ); ?>
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
                            'minLength' => 3,
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
                        'htmlOptions' => array('placeholder' => 'No. Identitas Pasien', 'rel' => 'tooltip', 'title' => 'No. Identitas untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 angkahuruf-only all-caps', 'onblur'=>'setInputBerdasarkanNoKTP();'),
                    ));
                    ?>

                    <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
                    <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'namadepan',
                        LookupM::getItems('namadepan'),
                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',)
                    ); ?>
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
                            'minLength' => 3,
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
                    )); ?>
                    <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                </div>
            </div>

            <?php echo $form->textFieldRow($model, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'span3 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

            <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => '')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'golongandarah',
                        LookupM::getItems('golongandarah'),
                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
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
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
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
            <?php echo  $form->hiddenField($modPasien, 'is_ambilfoto', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo  $form->hiddenField($modPasien, 'photopasien', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

            <?php if (Yii::app()->user->getState('is_mips')) :  ?>
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Kenali Wajah Pasien', array('{icon}' => '<i class="entypo-camera"></i>')),
                    array(
                        'class' => 'btn btn-dark', 'onclick' => "ambilFoto();",
                        'id' => 'btn-addphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk mengenali wajah pasien dari alat'
                    )
                ) ?>
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-remove"></i>')),
                    array(
                        'class' => 'btn btn-default', 'onclick' => "hapusFoto();",
                        'id' => 'btn-hapusphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk Mengenali Ulang Wajah Pasien'
                    )
                ) ?>
                <br>
                <div id="con_foto_scan">
                    <?php
                    if (!empty($model->pendaftaran_id)) {
                        $scan = ScanpasiendarialatT::model()->findByAttributes(array(
                            'pendaftaran_id' => $model->pendaftaran_id,
                        ));

                        if (!empty($scan)) {
                            $res = array(
                                'tempratrue' => $scan->suhu_tubuh,
                                'currentTime' => $scan->waktuscan,
                                'mask' => $scan->pake_masker ? 1 : 0,
                            );

                            $res_img = array(
                                'data' => $scan->data_gambar,
                            );

                            echo $this->renderPartial($this->path_view . "_fotoScan", array(
                                'res' => $res,
                                'res_img' => $res_img
                            ), true);
                        }
                    }

                    ?>
                </div>
                <br>
            <?php else : ?>

                <div style="text-align: center;">
                    <?php
                    $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
                    ?>
                    <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;">
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-map-marker"></i> Alamat dan Kontak
            </div>
        </div>
        <div class="panel-body">
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
                    <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                </div>
            </div>
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
                    <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No. Handphone <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'span3 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
                    <?php //echo CHtml::checkBox('is_whatsapp', true, array('rel'=>'tooltip', 'title'=>'Klik untuk mengirim pesan Whatsapp')); ?>
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
<div class="clear"></div>
<div class="col-sm-6">

    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
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
    )); ?>

</div>

<?php
if (Yii::app()->user->getState('is_finger_pasien')) {
    echo $this->renderPartial('pendaftaranPenjadwalan.views.daftarSidikJariPasien._jsFunctionsFinger', array('modPasien' => $modPasien, 'modul_akses' => 'pendaftaran'));
}
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien Rehabilitasi Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDataPasien = new RMPasienM('searchDialog');
$modDataPasien->unsetAttributes();
if (isset($_GET['RMPasienM'])) {
    $modDataPasien->attributes = $_GET['RMPasienM'];
    $modDataPasien->cari_kelurahan_nama = $_GET['RMPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['RMPasienM']['cari_kecamatan_nama'];
}
$modDataPasien->ispasienluar = false;
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
        'alamat_pasien',
        array(
            'header' => 'RT',
            'name' => 'rt',
            'type' => 'raw',
            'value' => '$data->rt'
        ),
        array(
            'header' => 'RW',
            'name' => 'rw',
            'type' => 'raw',
            'value' => '$data->rw'
        ),
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
        // 'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => LookupM::getItems('statusrekammedis'),
            'value' => '$data->statusrekammedis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php

Yii::import('application.modules.pendaftaranPenjadwalan.models.PPPasienM');

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienBadak',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 500,
        'resizable' => false,
    ),
));

$kec_id = null;
$modDataPasien2 = new PPPasienM('searchDialog');
$modDataPasien2->unsetAttributes();
$format = new MyFormatter();
$modDataPasien2->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $modDataPasien2->attributes = $_GET['PPPasienM'];
    $modDataPasien2->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien2->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modDataPasien2->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }

    $kec = KecamatanM::model()->findByAttributes(array(
        'kecamatan_nama' => $modDataPasien2->cari_kecamatan_nama
    ));

    if (empty($kec))
        $kec_id = null;
    else
        $kec_id = $kec->kecamatan_id;
}


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienbadak-m-grid',
    'dataProvider' => $modDataPasien2->searchDialogBadak(),
    'filter' => $modDataPasien2,
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
            'filter' => Chtml::dropDownList('PPPasienM[jeniskelamin]', $modDataPasien2->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
        ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modDataPasien2,
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
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama',
            'filter' => CHtml::activeDropDownList($modDataPasien2, 'cari_kecamatan_nama', CHtml::listData(KecamatanM::model()->findAll(array(
                'condition' => 'kecamatan_aktif = true',
                'order' => 'kecamatan_nama asc',
            )), 'kecamatan_nama', 'kecamatan_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""',
            'filter' => CHtml::activeDropDownList($modDataPasien2, 'cari_kelurahan_nama', CHtml::listData(KelurahanM::model()->findAllByAttributes(array(
                'kecamatan_id' => $kec_id,
            ), array(
                'condition' => 'kelurahan_aktif = true',
                'order' => 'kelurahan_nama asc',
            )), 'kelurahan_nama', 'kelurahan_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => Chtml::dropDownList('PPPasienM[statusrekammedis]', $modDataPasien->statusrekammedis, LookupM::model()->getItems('statusrekammedis'), array('empty' => '-- Pilih --')),
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



//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addphoto',
    'options' => array(
        'title' => 'Ambil Foto',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 360,
        'minHeight' => 250,
        'resizable' => false,
    ),
));
?>

<div id="dialog-content" style="text-align: center;">
    <div id="container_webcam" style="overflow: hidden; width: 320px; display: inline-block; margin-top: 10px;">
        <video id="cam-preview" style="margin-left: -160px;"></video>
    </div>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil', array('{icon}' => '<i class="icon-camera icon-white"></i>')), array('id' => 'btn_ambil_gambar', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'ambilGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-download-alt icon-white"></i>')), array('id' => 'btn_simpan_gambar', 'disabled' => true, 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'simpanGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_ulang_gambar', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'ulangGambar();', 'style' => 'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    <?php
    $random = rand(000000000, 999999999);
    ?>

    var video_pasien = null;
    var video_canvas = null;
    var temp_img = null;

    function putarWebcam() {
        ulangGambar();
    }

    /**
     * ambil gambar pada webcam
     * @returns {Boolean}
     */
    function ambilGambar() {
        video_pasien.pause();

        var img = document.createElement('img_webcam');
        var context;
        var width = container_webcam.offsetWidth;
        var height = container_webcam.offsetHeight;

        video_canvas = document.createElement("canvas");
        video_canvas.width = width;
        video_canvas.height = height;

        context = video_canvas.getContext('2d');
        context.drawImage(video_pasien, -157, 0);

        temp_img = video_canvas.toDataURL('image/png');

        $("#btn_ambil_gambar").prop("disabled", true);
        $("#btn_simpan_gambar").prop("disabled", false);
        $("#btn_ulang_gambar").prop("disabled", false);
    }
    /**
     * menyimpan / meng-upload gambar
     * @returns {undefined}
     */
    function simpanGambar() {
        $("#btn_simpan_gambar").attr("disabled", true);
        $("#RMPasienM_photopasien").val(temp_img);
        $("#RMPasienM_is_ambilfoto").val(1);
        $("#photo-preview").prop("src", temp_img);

        temp_img = null;
        $("#dialog-addphoto").dialog("close");

    }
    /**
     * mengulang pengambilan gambar
     * @returns {undefined}
     */
    function ulangGambar() {
        temp_img = null;
        video_pasien.play();
        $("#btn_ambil_gambar").prop("disabled", false);
        $("#btn_simpan_gambar").prop("disabled", true);
        $("#btn_ulang_gambar").prop("disabled", true);

    }

    function handleVideo(stream) {
        video_pasien.srcObject = stream;
    }

    function videoError(e) {
        // alert("Fungsi Foto pasien di-nonaktifkan.");
    }

    function ambilFoto() {
        $("#con_foto_scan").empty();
        $("#btn-addphoto").addClass("animation-loading");
        $.post('<?php echo $this->createUrl('ajaxLoadPhotoScan'); ?>', {}, function(data) {
            if (data.ok == 1) {
                $("#con_foto_scan").html(data.html);
                $("#btn-hapusphoto").show();

                if (data.pasien_id != "") {
                    $(".rmlama").click();
                    setPasienLama(data.pasien_id, data.no_rm, false);
                }

            } else {
                myAlert(data.msg);
            }
            $("#btn-addphoto").removeClass("animation-loading");
        }, 'json');
    }

    function hapusFoto() {
        $("#con_foto_scan").empty();
    }


    function cariNomorPasien() {
        var jenis = $("#tipe_nomor_pasien").val();
        var nomor = $("#cari_nomor_pasien").val();

        if (nomor.trim() == "") {
            return false;
        }

        $("#cari_nomor_pasien").addClass("animation-loading");

        if (jenis == "nomor_peserta") {
            loadNoPesertaBPJS(nomor);
        } else if (jenis == "nik") {
            loadNIKBPJS(nomor);
        } else if (jenis == "no_rujukan") {
            loadNoRujukanBPJS(nomor);
        } else if (jenis == "nip") {
            loadPasienDariNIPKK(jenis, nomor);
        } else if (jenis == "no_kk") {
            loadPasienDariNIPKK(jenis, nomor);
        }
    }

    function loadPasienDariNIPKK(jenis, nomor) {
        $.post('<?php echo $this->createUrl('cekPasienDariJenisNomor'); ?>', {
            jenis: jenis,
            nomor: nomor
        }, function(data) {
            if (data.ok == 1) {

                $(".pasien_pegawai_id").val(data.pegawai_id);

                if (data.ok_pasien == 1) {
                    setPasienLama(data.pasien_id, data.no_rekam_medik);
                } else {
                    $(".rb_rm.rmbaru").click();

                    var pegawai = data.pegawai_data;

                    var d_lahir = new Date(pegawai.tgl_lahirpegawai);

                    $("#RMPasienM_jenisidentitas").val(pegawai.jenisidentitas);
                    $("#RMPasienM_no_identitas_pasien").val(pegawai.noidentitas);
                    $("#RMPasienM_nama_pasien").val(pegawai.nama_pegawai);
                    $("#RMPasienM_tempat_lahir").val(pegawai.tempatlahir_pegawai);
                    $("#RMPasienM_golongandarah").val(pegawai.golongandarah);
                    $("#RMPasienM_statusperkawinan").val(pegawai.statusperkawinan);
                    $("#RMPasienM_alamat_pasien").val(pegawai.alamat_pegawai);
                    $("#RMPasienM_agama").val(pegawai.agama);
                    $("#RMPasienM_alamatemail").val(pegawai.alamatemail);
                    $("#RMPasienM_no_telepon_pasien").val(pegawai.notelp_pegawai);
                    $("#RMPasienM_no_mobile_pasien").val(pegawai.nomobile_pegawai);
                    $("#RMPasienM_warga_negara").val(pegawai.warganegara_pegawai);
                    $("#RMPasienM_tanggal_lahir").val(d_lahir.getDate().toString().padStart(2, "0") + "/" + d_lahir.getMonth().toString().padStart(2, "0") + "/" + d_lahir.getFullYear().toString().padStart(4, "0"));

                    setDaerahPasien(pegawai.propinsi_id, pegawai.kabupaten_id, pegawai.kecamatan_id, pegawai.kelurahan_id);

                    if (pegawai.jeniskelamin.trim() == "Laki-Laki") {
                        $("#RMPasienM_jeniskelamin_0").click();
                    } else {
                        $("#RMPasienM_jeniskelamin_1").click();
                    }

                    setUmur($("#RMPasienM_tanggal_lahir").val());
                }
            } else {
                myAlert("Data pegawai Tidak ditemukan");
                $("#cari_nomor_pasien").addClass("animation-loading").val("");
            }
            $("#cari_nomor_pasien").removeClass("animation-loading");
        }, 'json');
    }

    function loadNoPesertaBPJS(nomor) {
        $.ajax({
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=1&query=' + nomor,
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    console.log(obj);

                    var peserta = obj.response.peserta;

                    $.post('<?php echo $this->createUrl('cekPasienBerdasarkanNoAsuransi'); ?>', {
                        nomor: peserta.noKartu
                    }, function(data) {
                        if (data.ok == 1) {
                            setPasienLama(data.pasien_id, data.no_rekam_medik);
                        } else {
                            $(".rb_rm.rmbaru").click();

                            var d_lahir = new Date(peserta.tglLahir);

                            $("#RMPasienM_jenisidentitas").val("KTP");
                            $("#RMPasienM_no_identitas_pasien").val(peserta.nik);
                            $("#RMPasienM_nama_pasien").val(peserta.nama);
                            $("#RMPasienM_tanggal_lahir").val(d_lahir.getDate().toString().padStart(2, "0") + "/" + d_lahir.getMonth().toString().padStart(2, "0") + "/" + d_lahir.getFullYear().toString().padStart(4, "0"));

                            if (peserta.sex == "L") {
                                $("#RMPasienM_jeniskelamin_0").click();
                            } else {
                                $("#RMPasienM_jeniskelamin_1").click();
                            }

                            setUmur($("#RMPasienM_tanggal_lahir").val());

                        }
                        $("#cari_nomor_pasien").removeClass("animation-loading");
                    }, 'json');

                    $("#RMPendaftaranT_carabayar_id").val(2).change();
                    $("#RMSepT_jenisfaskes_0").click();
                    <?php if (strtolower($this->id) == "pendaftaranrawatdarurat"): ?>
                        $("#RMAsuransipasienM_nopeserta").val(peserta.noKartu);
                        $("#RMAsuransipasienM_nokartuasuransi").val(peserta.noKartu);
                        $("#RMAsuransipasienM_namapemilikasuransi").val(peserta.nama);
                    <?php else: ?>
                        getAsuransiNoKartu(peserta.noKartu);
                    <?php endif; ?>


                } else {
                    myAlert(obj.metaData.message);
                    $("#cari_nomor_pasien").removeClass("animation-loading").val("");
                }
            },
            error: function(data) {
                $("#cari_nomor_pasien").removeClass("animation-loading");
            }
        });
    }

    function loadNIKBPJS(nomor) {
        $.ajax({
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=2&query=' + nomor,
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    console.log(obj);

                    var peserta = obj.response.peserta;

                    $.post('<?php echo $this->createUrl('cekPasienBerdasarkanNoAsuransi'); ?>', {
                        nomor: peserta.noKartu
                    }, function(data) {
                        if (data.ok == 1) {
                            setPasienLama(data.pasien_id, data.no_rekam_medik);
                        } else {
                            $(".rb_rm.rmbaru").click();

                            var d_lahir = new Date(peserta.tglLahir);

                            $("#RMPasienM_jenisidentitas").val("KTP");
                            $("#RMPasienM_no_identitas_pasien").val(peserta.nik);
                            $("#RMPasienM_nama_pasien").val(peserta.nama);
                            $("#RMPasienM_tanggal_lahir").val(d_lahir.getDate().toString().padStart(2, "0") + "/" + d_lahir.getMonth().toString().padStart(2, "0") + "/" + d_lahir.getFullYear().toString().padStart(4, "0"));

                            if (peserta.sex == "L") {
                                $("#RMPasienM_jeniskelamin_0").click();
                            } else {
                                $("#RMPasienM_jeniskelamin_1").click();
                            }

                            setUmur($("#RMPasienM_tanggal_lahir").val());

                        }
                        $("#cari_nomor_pasien").removeClass("animation-loading");
                    }, 'json');

                    $("#RMPendaftaranT_carabayar_id").val(2).change();
                    $("#RMSepT_jenisfaskes_0").click();

                    <?php if (strtolower($this->id) == "pendaftaranrawatdarurat"): ?>
                        $("#RMAsuransipasienM_nopeserta").val(peserta.noKartu);
                        $("#RMAsuransipasienM_nokartuasuransi").val(peserta.noKartu);
                        $("#RMAsuransipasienM_namapemilikasuransi").val(peserta.nama);
                    <?php else: ?>
                        getAsuransiNoPeserta(peserta.noKartu);
                    <?php endif; ?>


                } else {
                    myAlert(obj.metaData.message);
                    $("#cari_nomor_pasien").removeClass("animation-loading").val("");;
                }
            },
            error: function(data) {
                $("#cari_nomor_pasien").removeClass("animation-loading");
            }
        });
    }

    function loadNoRujukanBPJS(nomor) {
        $.ajax({
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=3&query=' + nomor,
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    console.log(obj);

                    var rujukan = obj.response.rujukan;
                    var peserta = obj.response.rujukan.peserta;

                    $.post('<?php echo $this->createUrl('cekPasienBerdasarkanNoAsuransi'); ?>', {
                        nomor: peserta.noKartu
                    }, function(data) {
                        if (data.ok == 1) {
                            setPasienLama(data.pasien_id, data.no_rekam_medik);
                        } else {
                            $(".rb_rm.rmbaru").click();

                            var d_lahir = new Date(peserta.tglLahir);

                            $("#RMPasienM_jenisidentitas").val("KTP");
                            $("#RMPasienM_no_identitas_pasien").val(peserta.nik);
                            $("#RMPasienM_nama_pasien").val(peserta.nama);
                            $("#RMPasienM_tanggal_lahir").val(d_lahir.getDate().toString().padStart(2, "0") + "/" + d_lahir.getMonth().toString().padStart(2, "0") + "/" + d_lahir.getFullYear().toString().padStart(4, "0"));

                            if (peserta.sex == "L") {
                                $("#RMPasienM_jeniskelamin_0").click();
                            } else {
                                $("#RMPasienM_jeniskelamin_1").click();
                            }

                            setUmur($("#RMPasienM_tanggal_lahir").val());

                        }
                        $("#cari_nomor_pasien").removeClass("animation-loading");
                    }, 'json');

                    $.post('<?php echo $this->createUrl('cekRuanganBerdasarkanPoliBPJS') ?>', {
                        kode_ruangan: rujukan.poliRujukan.kode
                    }, function(data) {
                        if (data.ok == 1) {
                            $("#RMPendaftaranT_ruangan_id").val(data.ruangan_id).change();
                        }
                    }, 'json');

                    $("#RMPendaftaranT_carabayar_id").val(2).change();
                    $("#RMSepT_jenisfaskes_0").click();
                    <?php if (strtolower($this->id) == "pendaftaranrawatdarurat"): ?>
                        $("#RMAsuransipasienM_nopeserta").val(peserta.noKartu);
                        $("#RMAsuransipasienM_nokartuasuransi").val(peserta.noKartu);
                        $("#RMAsuransipasienM_namapemilikasuransi").val(peserta.nama);
                    <?php else: ?>
                        getRujukanNoRujukan(rujukan.noKunjungan);
                    <?php endif; ?>



                } else {
                    myAlert(obj.metaData.message);
                    $("#cari_nomor_pasien").removeClass("animation-loading").val("");;
                }
            },
            error: function(data) {
                $("#cari_nomor_pasien").removeClass("animation-loading");
            }
        });
    }


    $(document).ready(function() {
        $("#btn-hapusphoto").hide();
        /**
         * set webcam
         * @returns {Boolean}
         */
        <?php if (!isset($_GET['sukses'])) { ?>

            video_pasien = document.querySelector("#cam-preview");
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

            if (navigator.getUserMedia) {
                // jalankan fungsi handleVideo, dan videoError jika izin ditolak
                navigator.getUserMedia({
                    video: true
                }, handleVideo, videoError);
            }
        <?php } ?>
    });
</script>

<?php //================= end dialog webcam ===================== 
?>