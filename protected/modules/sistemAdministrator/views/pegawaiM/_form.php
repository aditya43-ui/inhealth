
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fileupload/fileupload.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#SAPegawaiM_nama_pegawai',
        ));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php $random = rand(000000, 999999); ?>

<fieldset class="box">
    <legend class="rim">Data Pegawai</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'unit_perusahaan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'unit_perusahaan', LookupM::getItems('unit_perusahaan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>  
                    </div>
                </div>     
                <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 18, 'class'=>'numbers-only')); ?>
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'gelardepan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'gelardepan', LookupM::getItems('gelardepan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'style' => 'width:70px;'));
                        ?>  
                    </div>
                </div>  
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'nama_pegawai', array('class' => 'control-label required')); ?>
                    <div class="controls inline">
                        <?php echo $form->textField($model, 'nama_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'class' => 'span2 inputRequire', 'style' => 'width:208px;')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'gelarbelakang_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'gelarbelakang_id', CHtml::listData($model->getGelarBelakangItems(), 'gelarbelakang_id', 'gelarbelakang_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'style' => 'width:70px;'));
                        ?> 
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nama_keluarga', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php
                    echo $form->dropDownListRow($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'inputRequire span3'));
                ?> 
                <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tgl_lahirpegawai', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_lahirpegawai',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 dtPicker3',
                            ),
                        ));
                        ?> 
                    </div>      
                </div> 
                <?php
                    echo $form->dropDownListRow($model, 'agama', LookupM::getItems('agama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'inputRequire span3'));
                ?>
                <?php echo $form->dropDownListRow($model, 'warganegara_pegawai', LookupM::getItems('warganegara'), array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
                <?php
                    echo $form->dropDownListRow($model, 'suku_id', CHtml::listData($model->getSukuItems(), 'suku_id', 'suku_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    ));
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'golongandarah', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'golongandarah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'));
                        ?>   
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($model, 'rhesus', LookupM::getItems('rhesus'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>            
                            </div>
                        </div>
                        <?php echo $form->error($model, 'golongandarah'); ?>
                        <?php echo $form->error($model, 'rhesus'); ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputRequire span3')); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'no_kartupegawainegerisipil', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'no_askes', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'no_taspen', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'no_karis_karsu', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>

                <?php
                echo $form->dropDownListRow($model, 'kategoripegawaiasal', LookupM::getItems('kategoriasalpegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>

                <?php
                echo $form->dropDownListRow($model, 'kategoripegawai', LookupM::getItems('kategoripegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>

                <?php
                echo $form->dropDownListRow($model, 'kelompokpegawai_id', CHtml::listData($model->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>

                <?php
                echo $form->dropDownListRow($model, 'kelompokjabatan', LookupM::getItems('kelompokjabatan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>
                <?php
                echo $form->dropDownListRow($model, 'jabatan_id', CHtml::listData($model->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>

                <?php
                echo $form->dropDownListRow($model, 'jeniswaktukerja', LookupM::getItems('jeniswaktukerja'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>  

                <?php
                echo $form->dropDownListRow($model, 'pangkat_id', CHtml::listData($model->getPangkatItems(), 'pangkat_id', 'pangkat_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>

                <?php
                echo $form->dropDownListRow($model, 'pendidikan_id', CHtml::listData($model->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>

                <?php
                echo $form->dropDownListRow($model, 'pendkualifikasi_id', CHtml::listData($model->getPendidikanKualifikasiItems(), 'pendkualifikasi_id', 'pendkualifikasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>
                
                <?php
                echo $form->dropDownListRow($model, 'golonganpegawai_id', CHtml::listData($model->golonganPegawaiitems, 'golonganpegawai_id', 'golonganpegawai_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>
            </td>
            <td rowspan="2">
                <?php echo $form->textAreaRow($model, 'alamat_pegawai', array('rows' => 3, 'cols' => 50, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'propinsi_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
                                'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
                            ),
                            'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",));
                        ?>
                        <?php echo $form->error($model, 'propinsi_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'kabupaten_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
                                'update' => "#" . CHtml::activeId($model, 'kecamatan_id'),
                            ),
                            'onchange' => "setClearDropdownKelurahan();",));
                        ?>
                    <?php echo $form->error($model, 'kabupaten_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kecamatan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'kecamatan_id', CHtml::listData($model->getKecamatanItems($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($model))),
                                'update' => "#" . CHtml::activeId($model, 'kelurahan_id'),
                            ),
                            'onchange' => "",));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kelurahan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'kelurahan_id', CHtml::listData($model->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
                        <?php echo $form->error($model, 'kelurahan_id'); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($model, 'notelp_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

                <?php echo $form->textFieldRow($model, 'nomobile_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

                <?php echo $form->textFieldRow($model, 'alamatemail', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'deskripsi', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'deskripsi', 'toolbar' => 'mini', 'height' => '100px', 'htmlOptions' => array('class' => 'span3',))) ?>
                        <?php echo $form->error($model, 'deskripsi'); ?>
                </div>
            </div>
            <div>
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'caraAmbilPhoto', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    <div class="controls">  
                        <?php echo CHtml::radioButton('caraAmbilPhoto', false, array('value' => 'webCam', 'onclick' => 'caraAmbilPhotoJS(this)')); ?> Web Cam
                        <?php echo CHtml::radioButton('caraAmbilPhoto', true, array('value' => 'file', 'onclick' => 'caraAmbilPhotoJS(this)')); ?> File                               
                    </div>
                </div>

            </div>
            <div id="divCaraAmbilPhotoWebCam"  style="display:none;">
                <div class="controls">
                    <div class="buttonWebcam2">
                        <?php
                        $random = rand(0000000000000000, 9999999999999999);
                        $pathPhotoPegawaiTumbs = Params::pathPegawaiTumbsDirectory();
                        $pathPhotoPegawai = Params::pathPegawaiDirectory();
                        $urlAjaxSessionPhoto = '';
                        ?>
                        <?php echo $form->hiddenField($model, 'tempPhoto', array('readonly' => TRUE, 'value' => $random . '.jpg')); ?>
                        <?php
                        $onBeforeSnap = "document.getElementById('upload_results').innerHTML = '<h1>Proses Penyimpanan...</h1>';";
                        $completionHandler = <<<BLOCK
                          if (msg == 'OK') 
                           {
                                document.getElementById('upload_results').innerHTML = '<h1>OK! ...Photo Sedang Disimpan</h1>';

                                // reset camera for another shot
                                // webcam.reset();
                                setTimeout(function(){
                                document.getElementById('upload_results').innerHTML = '<h1>Photo Berhasil Disimpan</h1>';
                                },3000);
//                              $('#sapegawai-m-form').submit();           
                                $.post("${urlAjaxSessionPhoto}",{},
                                    function(data){
                                    $('#gambar').attr('src',data.photo);

                                },"json");
                            }
                         else
                            {
                                myAlert("PHP Error: " + msg);
                            }
BLOCK;

                        $this->widget('application.extensions.jpegcam.EJpegcam', array(
                            'apiUrl' => 'index.php?r=photoWebCam/jpegcam.saveJpg&random=' . $random . '&pathTumbs=' . $pathPhotoPegawaiTumbs . '&path=' . $pathPhotoPegawai . '',
                            'shutterSound' => false,
                            'stealth' => true,
                            'buttons' => array(
                                'configure' => 'Konfigurasi',
//                'takesnapshot' => 'Ambil Foto',
                                'freeze' => 'Ambil Foto',
                                'reset' => 'Ulang',
                                'takesnapshot' => 'Simpan',
                            ),
                            'onBeforeSnap' => $onBeforeSnap,
                            'completionHandler' => $completionHandler
                        ));
                        ?>
<!--<img src="<?php //echo Params::urlPegawaiDirectory() ?>9680901rizky.jpg " id="gambar">-->

                        <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
                    </div>
                </div>
            </div>
            <div id="divCaraAmbilPhotoFile" style="display: block;">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'photopegawai', array('class' => 'control-label', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?>
                        <div class="controls">  
                            <?php echo Chtml::activeFileField($model, 'photopegawai', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'class' => 'fileupload-new')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 90%;line-height: 20px;margin-left:34.3%"><img src="<?php echo Params::urlPhotoPasienDirectory() . 'no_photo.jpeg'; ?>" /></div>
                        </div>
                    </div>
                </div>
            </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan / Unit kerja', 'ruangan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                                'ruangan_id[]', '', CHtml::listData(SARuanganM::model()->findAll(array('order' => 'ruangan_nama', 'condition'=>'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'), array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px', 'onkeyup' => "return $(this).focusNextInputField(event);")
                        );
                        ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</fieldset>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit',
        'onKeypress' => 'return formSubmit(this,event)',
        // 'onclick'=>'formSubmit(this,event)',
        'id' => 'btn_simpan',
    //                                                    'onclick'=>'do_upload()',
    ));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pegawai', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    $content = $this->renderPartial('../tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JS

function caraAmbilPhotoJS(obj)
{
    caraAmbilPhoto=obj.value;
    
    if(caraAmbilPhoto=='webCam')
        {
          $('#divCaraAmbilPhotoWebCam').slideToggle(500);
          $('#divCaraAmbilPhotoFile').slideToggle(500);
            
        }
    else
        {
         $('#divCaraAmbilPhotoWebCam').slideToggle(500);
          $('#divCaraAmbilPhotoFile').slideToggle(500);
        }
} 

function simpanDataPegawai()
{
    var caraAmbilPhoto = $('#caraAmbilPhoto');
     if(caraAmbilPhoto=='webCam')
        {
          $('#upload').click();  
          do_upload();
          $('#sapegawai-m-form').submit();           
        }
     else
        {
          $('#sapegawai-m-form').submit();           
        }
}    

JS;
Yii::app()->clientScript->registerScript('caraAmbilPhoto212', $js, CClientScript::POS_BEGIN);
?>

<?php echo $this->renderPartial('_jsFunctions', array('model' => $model)); ?>        