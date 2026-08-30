<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/fileupload/fileupload.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
/*
 * start tidak tahu untuk apa 
 */
$random = rand(000000, 999999);
/*
 * end tidak tahu untuk apa 
 */

$arrMenu = array();
//array_push($arrMenu,array('label'=>Yii::t('mds','Ubah').' Data Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapegawai-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data',
			'onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class="span8">
        <div class="span5" style = "width:51%;margin-right:5px;">
        <fieldset class = "box">
            <legend class="rim">Data Pribadi</legend>    
            <?php /*
                <div class="control-group">
                  <?php echo $form->labelEx($model,'unit_perusahaan',array('class'=>'control-label')); ?>
                  <div class="controls">
                    <?php echo $form->dropDownList($model,'unit_perusahaan',LookupM::getItems('unit_perusahaan'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>  
                    </div>
              </div> 
               * 
               */?>
            <?php echo $form->hiddenField($model,'unit_perusahaan',array('class'=>'required numbers-only','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nomor Induk Pegawai','maxlength'=>20, 'readonly',true,'value'=> LookupM::getNama('unit_perusahaan'))); ?>
            <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'required','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nomor Induk Pegawai', 'maxlength' => 18, 'class'=>'numbers-only')); ?>

            <div class="control-group">
                    <?php echo CHtml::label('No. Identitas','jenisidentitas',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'jenisidentitas',LookupM::getItems('jenisidentitas'),array('empty'=>'-- Pilih --','id'=>'jenisidentitas','style'=>'width:70px;','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textField($model,'noidentitas',array('empty'=>'-- Pilih --','id'=>'noidentitas','style'=>'width:135px;','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Identitas Pegawai')); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('Nama Pegawai <font style = "color:red;">*</font>','namapegawai',array('class'=>'control-label')); ////$form->labelEx($model,'nama_pegawai',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'gelardepan',CHtml::listData($model->getGelarDepanItems(), 'lookup_name', 'lookup_name'), 
                                 array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                       'style'=>'width:50px;')); ?>
                    <?php echo $form->textField($model,'nama_pegawai',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'class'=>'inputRequire','style'=>'width:135px;','placeholder'=>'Nama Lengkap Pegawai')); ?>
                    <?php echo $form->dropDownList($model,'gelarbelakang_id',  CHtml::listData($model->getGelarBelakangItems(), 'gelarbelakang_id', 'gelarbelakang_nama'), 
                                 array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                       'style'=>'width:70px;')); ?>
                </div>
            </div>

            <?php echo $form->textFieldRow($model,'nama_keluarga',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'Nama Keluarga Pegawai')); ?>           

            <?php echo $form->textFieldRow($model,'tempatlahir_pegawai',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30,'placeholder'=>'Kota/Kabupaten Kelahiran')); ?>

            <div class="control-group">
                <?php echo $form->labelEx($model,'tgl_lahirpegawai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                    $model->tgl_lahirpegawai = (!empty($model->tgl_lahirpegawai) ? date("d/m/Y",strtotime($model->tgl_lahirpegawai)) : null);
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_lahirpegawai',
                                            'mode'=>'date',
                                            'options'=> array(
        //                                            'dateFormat'=>Params::DATE_FORMAT,
                                                'showOn' => false,
                                                'maxDate' => 'd',
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'tgl_lahirpegawai'); ?>
                </div>
            </div>

            <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'inputRequire')); ?>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model,'golongandarah', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'golongandarah', LookupM::getItems('golongandarah'),  
                                                  array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>   
                    <div class="radio inline">
                        <div class="form-inline">
                            <?php echo $form->radioButtonList($model,'rhesus',LookupM::getItems('rhesus'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
                        </div>
                    </div>
                    <?php echo $form->error($model, 'golongandarah'); ?>
                    <?php echo $form->error($model, 'rhesus'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model,'agama',LookupM::getItems('agama'), 
                                 array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                       'class'=>'inputRequire')); ?>                         

            <?php echo $form->dropDownListRow($model,'suku_id',  CHtml::listData($model->getSukuItems(), 'suku_id', 'suku_nama'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            
            <?php echo $form->dropDownListRow($model,'warganegara_pegawai',LookupM::getItems('warganegara'),array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
            
            <?php echo $form->dropDownListRow($model,'statusperkawinan',LookupM::getItems('statusperkawinan'), 
                            array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                  'class'=>'inputRequire')); ?>    
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </fieldset>
        </div>
        <div class="span5" style = "width:48%">
            <fieldset class = "box">
                <legend class="rim">Alamat / Kontak</legend>  
                    <?php echo $form->textAreaRow($model,'alamat_pegawai',array('rows'=>6, 'cols'=>50,  'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Alamat Lengkap Pegawai')); ?>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'propinsi_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST',
                                                            'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'model_nama' => ''.get_class($model).'')),
                                                            'update'=>"#".CHtml::activeId($model, 'kabupaten_id'),
                                                ),
                                                'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
                            <?php echo $form->error($model, 'propinsi_id'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'kabupaten_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST',
                                                            'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false,  'model_nama' => ''.get_class($model).'')),
                                                            'update'=>"#".CHtml::activeId($model, 'kecamatan_id'),
                                                ),
                                                'onchange'=>"setClearDropdownKelurahan();",));?>
                            <?php echo $form->error($model, 'kabupaten_id'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'kecamatan_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'kecamatan_id', CHtml::listData($model->getKecamatanItems($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST',
                                                            'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false,  'model_nama' => ''.get_class($model).'')),
                                                            'update'=>"#".CHtml::activeId($model, 'kelurahan_id'),
                                                ),
                                                'onchange'=>"",));?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'kelurahan_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'kelurahan_id',CHtml::listData($model->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                                              array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                            <?php echo $form->error($model, 'kelurahan_id'); ?>
                        </div>
                    </div>
                    
                    <?php echo $form->textFieldRow($model,'garis_latitude',array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                
                    <?php echo $form->textFieldRow($model,'garis_longitude',array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    
                    <div class="control-group">
                        <?php echo CHtml::label('No. Telp / Hp','nomorcontact',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'notelp_pegawai',array( 'class'=>'span2 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15,'style'=>'width:97px;text-align:right;','id'=>'nomorcontact','placeholder'=>'No. Telepon Pegawai')); ?>
                            <?php echo ' / '; ?>
                            <?php echo $form->textField($model,'nomobile_pegawai',array('class'=>'span2  numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15,'style'=>'width:97px;text-align:right;','id'=>'nomorcontact','placeholder'=>'No. Ponsel Pegawai')); ?>
                        </div>
                    </div>
                
                    <?php echo $form->textFieldRow($model,'alamatemail',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'placeholder'=>'contoh: info@piiinformasi.com')); ?>
            </fieldset>  
            <fieldset class = "box">
                <legend class="rim">Data Lain - Lain</legend> 
                    <?php echo $form->dropDownListRow($model,'statuskepemilikanrumah_id',CHtml::listData($model->getStatuskepemilikanrumahItems(),'statuskepemilikanrumah_id','statuskepemilikanrumah_nama'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

                    <?php echo $form->dropDownListRow($model,'kemampuanbahasa',LookupM::getItems('kemampuanbahasa'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($model,'warnakulit',LookupM::getItems('warnakulit'), array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'contoh : Sawo Matang')); ?>
                    <div class="control-group">                   
                        <?php echo $form->labelEx($model, 'tinggibadan', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'tinggibadan',array('onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>100, 'class'=>'numbers-only span1', 'style'=>'text-align: right')); ?>
                            <?php echo CHtml::label('cm', 'cm'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'beratbadan', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'beratbadan',array('onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>100, 'class'=>'numbers-only span1', 'style'=>'text-align: right')); ?>
                            <?php echo CHtml::label('kg', 'kg'); ?>
                        </div>
                    </div>
            </fieldset>                                                         
        </div>
        <?php /*
        <div class = "span12">
            <fieldset class = "box">
                <legend class="rim">Ruangan</legend>
                    <table width="100%" class="table-condensed">
                        <tr>
                            <td style="width:127px;text-align:right;">
                                <div class="control-group">
                                    <?php echo CHtml::label('Ruangan / Unit kerja','ruangan',array('class'=>'control-label'));  ?>
                                </div>
                            </td>
                            <td>
                                <?php 
                                       $arrRuanganPegawai = array();
                                        foreach($modRuanganPegawai as $tampilRuanganPegawai){
                                           $arrRuanganPegawai[] = isset($tampilRuanganPegawai['ruangan_id']) ? $tampilRuanganPegawai['ruangan_id'] : null;
                                       }                                  
                                      $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                    array('sortable'=>true, 'searchable'=>true)
                                               );
                                       echo CHtml::dropDownList(
                                       'ruangan_id[]',
                                       $arrRuanganPegawai,
                                       CHtml::listData(KPRuanganM::model()->findAll(array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'),
                                       array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                               );
                                ?>
                            </td>
                        </tr>
                    </table>
            </fieldset>
        </div>
         * 
         */?>
         
    </div> 
            
    <div class="span4">    
        <fieldset class = "box">
            <legend class="rim">Data Kepegawaian</legend> 
        <!--Menampilkan Foto Pegawai Jika Ada-->
        <?php
//        if (!empty($model->photopegawai)){
//
//            echo '<div class="control-group">
//                <div class="control-label">Foto Pegawai</div>
//                <div class="controls">';
//            echo '<img src="'.Params::urlPegawaiTumbsDirectory().$model->photopegawai.'" width="200px"/>';
//            echo '</div></div>';
//        }else{
//            echo '<div class="control-group">
//                <div class="control-label">Foto Pegawai</div>
//                <div class="controls">';
//        //    echo '<img src="'.Params::urlPegawaiDirectory().'no_photo.jpeg" width="200px"/>';
//            echo '-- Belum memiliki foto --';
//            echo '</div></div>';
//        }
        ?>
            <?php echo $form->dropDownListRow($model,'golonganpegawai_id',  CHtml::listData($model->getGolonganPegawaiItems(), 'golonganpegawai_id', 'golonganpegawai_nama'), 
                           array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                 )); ?>
        
            <?php echo $form->dropDownListRow($model,'jabatan_id',  CHtml::listData($model->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                              )); ?>

            <?php echo $form->dropDownListRow($model,'pangkat_id',  CHtml::listData($model->getPangkatItems(), 'pangkat_id', 'pangkat_nama'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                              )); ?>           
        
            <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',  CHtml::listData($model->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'), 
                    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        
            <?php echo $form->dropDownListRow($model,'jenistenagamedis_id',  CHtml::listData($model->getJenisTenagaMedisItems(), 'jenistenagamedis_id', 'tenagamedis_nama'), 
                array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        
            <?php echo $form->dropDownListRow($model,'kategoripegawai',LookupM::getItems('kategoripegawai'), 
                    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        
            <?php echo $form->dropDownListRow($model,'kategoripegawaiasal',LookupM::getItems('kategoriasalpegawai'), 
                                array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        
            <?php echo $form->dropDownListRow($model,'kelompokjabatan',LookupM::getItems('kelompokjabatan'), 
                    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

            <?php echo $form->dropDownListRow($model,'jeniswaktukerja',LookupM::getItems('jeniswaktukerja'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>  

            <?php echo $form->dropDownListRow($model,'pendidikan_id',  CHtml::listData($model->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

            <?php echo $form->dropDownListRow($model,'pendkualifikasi_id',  CHtml::listData($model->getPendidikanKualifikasiItems(), 'pendkualifikasi_id', 'pendkualifikasi_nama'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>                 
        
            <div class='control-group'>
                <?php echo $form->labelEx($model,'tglditerima', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                    $model->tglditerima = (!empty($model->tglditerima) ? date("d/m/Y",strtotime($model->tglditerima)) : null);
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglditerima',
                                            'mode'=>'date',
                                            'options'=> array(
        //                                            'dateFormat'=>Params::DATE_FORMAT,
                                                'showOn' => false,
                                                'maxDate' => 'd',
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'tglditerima'); ?>
                </div>
            </div>        
            <?php echo $form->textFieldRow($model,'surattandaregistrasi',array('onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'suratizinpraktek',array('onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'npwp',array('maxlength'=>25,'class'=>'numbers-only','onkeyup'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align:right;')); ?>            
            <?php echo $form->textFieldRow($model,'no_rekening',array('class'=>'numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>100, 'style'=>'text-align:right;')); ?>
            <?php echo $form->textFieldRow($model,'bank_no_rekening',array('onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'gajipokok',array('class'=>'integer2','onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>100, 'style'=>'text-align:right;')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'caraAmbilPhoto', array('class'=>'control-label')) ?>
                <div class="controls">  
                    <?php echo CHtml::radioButton('caraAmbilPhoto',false,array('value'=>'webCam','onclick'=>'caraAmbilPhotoJS(this)','onkeyup'=>"return $(this).focusNextInputField(event)"));?><span style='font-size:11px';>Web Cam</span>
                    <?php echo CHtml::radioButton('caraAmbilPhoto',true,array('value'=>'file','onclick'=>'caraAmbilPhotoJS(this)','onkeyup'=>"return $(this).focusNextInputField(event)"));?><span style='font-size:11px';>File</span>                               
                </div>
            </div>
                    <div id="divCaraAmbilPhotoWebCam"  style="display:none;">
                      <div class="controls">
                        <div class="buttonWebcam2">
                    <?php 
                        $random=rand(0000000000000000, 9999999999999999);                    
                        $pathPhotoPegawaiTumbs=Params::pathPegawaiTumbsDirectory();
                        $pathPhotoPegawai=Params::pathPegawaiDirectory();
                        $urlAjaxSessionPhoto = '';
                    ?>
                    <?php $onBeforeSnap = "document.getElementById('upload_results').innerHTML = '<h1>Proses Penyimpanan...</h1>';";
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
            'apiUrl' => 'index.php?r=photoWebCam/jpegcam.saveJpg&random='.$random.'&pathTumbs='.$pathPhotoPegawaiTumbs.'&path='.$pathPhotoPegawai.'',
            'shutterSound' => false,
            'stealth' => true,
            'buttons' => array(
                'configure' => 'Konfigurasi',
//                'takesnapshot' => 'Ambil Photo',
                'freeze'=>'Ambil Photo',
                'reset'=>'Ulang',
                'takesnapshot' => 'Simpan',
            ),
            'onBeforeSnap' => $onBeforeSnap,
            'completionHandler' => $completionHandler
        ));
?>
<!--<img src="<?php //echo Params::urlPegawaiDirectory()?>9680901rizky.jpg " id="gambar">  -->

                          <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
                        </div>
                      </div>
                    </div>
                    <div id="divCaraAmbilPhotoFile" style="display: block;">
                          <div class="fileupload fileupload-new" data-provides="fileupload">
                          <div class="control-group">
                            <?php echo $form->labelEx($model,'photopegawai', array('class'=>'control-label','onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                              <div class="controls">  
                                <?php 
                                    $url_photopegawai = (!empty($model->photopegawai) ? Params::urlPegawaiTumbsDirectory()."kecil_".$model->photopegawai : Params::urlPegawaiDirectory()."no_photo.jpeg");
                                ?>
                                <?php echo $form->hiddenField($model,'tempPhoto',array('readonly'=>TRUE,'value'=>$random.'.jpg')); ?>
                                <?php echo Chtml::activeFileField($model,'photopegawai',array('maxlength'=>254,'Hint'=>'Isi Jika Akan Menambahkan Logo','class'=>'fileupload-new','value'=>$model->photopegawai)); ?>
                              </div>
                          </div>
                          <div class="control-group" style="padding-left:29.5%;">
                              <div class="controls">
                                  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; line-height: 20px;"><img src="<?php echo $url_photopegawai; ?>" /></div>
                              </div>
                          </div>
                          </div>
                    </div>
            </fieldset>
        </div>
  
        <div class="span12"> 
            <div class="form-actions">
                    <?php 
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onkeypress'=>'formSubmit(this,event);'));
                    ?>
                    <?php 
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            '', 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                    <?php
                        $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit4b',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        $urlPrintKartuPegawai = Yii::app()->createUrl('print/kartuPegawai',array('idPegawai'=>''));
                    ?>  
            </div>
         </div>

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
Yii::app()->clientScript->registerScript('caraAmbilPhoto212',$js,CClientScript::POS_BEGIN);
?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>
<?php echo $this->renderPartial('application.modules.kepegawaian.views.pegawaiM._jsFunctions', array('model'=>$model)); ?>        