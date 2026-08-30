<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">
                No. Pasien Apotek
          </label>
            <div class="controls">
                <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly'=>true));?>
                <?php echo $form->textField($modPasien,'no_rekam_medik', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'));
//                $this->widget('MyJuiAutoComplete',array(
//                    'name'=>'noPasienApotek',
//                    'value'=>$modPasien->no_rekam_medik,
//                    'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/PasienLamaApotek'),
//                    'options'=>array(
//                       'showAnim'=>'fold',
//                       'minLength' => 4,
//                       'readonly'=>true,
//                       'select'=>'js:function( event, ui ) {
//                           $("#noPasienApotek").val( ui.item.value );
//                            $("#'.CHtml::activeId($modPasien,'pasien_id').'").val(ui.item.pasien_id);
//                            $("#'.CHtml::activeId($modPasien,'jenisidentitas').'").val(ui.item.jenisidentitas);
//                            $("#'.CHtml::activeId($modPasien,'no_identitas_pasien').'").val(ui.item.no_identitas_pasien);
//                            $("#'.CHtml::activeId($modPasien,'namadepan').'").val(ui.item.namadepan);
//                            $("#'.CHtml::activeId($modPasien,'nama_pasien').'").val(ui.item.nama_pasien);
//                            $("#'.CHtml::activeId($modPasien,'nama_bin').'").val(ui.item.nama_bin);
//                            $("#'.CHtml::activeId($modPasien,'tempat_lahir').'").val(ui.item.tempat_lahir);
//                            $("#'.CHtml::activeId($modPasien,'tanggal_lahir').'").val(ui.item.tanggal_lahir);
//                            $("#'.CHtml::activeId($modPasien,'kelompokumur_id').'").val(ui.item.kelompokumur_id);
//                            $("#'.CHtml::activeId($modPasien,'jeniskelamin').'").val(ui.item.jeniskelamin);
//                            setJenisKelaminPasien(ui.item.jeniskelamin);
//                            var kelurahan = String.trim(\'ui.item.kelurahan_id\');
//                            if(kelurahan.length == 0){
//                                kelurahan = 0
//                            }
//                            $("#'.CHtml::activeId($modPasien,'statusperkawinan').'").val(ui.item.statusperkawinan);
//                            $("#'.CHtml::activeId($modPasien,'golongandarah').'").val(ui.item.golongandarah);
//                            $("#'.CHtml::activeId($modPasien,'rhesus').'").val(ui.item.rhesus);
//                            $("#'.CHtml::activeId($modPasien,'alamat_pasien').'").val(ui.item.alamat_pasien);
//                            $("#'.CHtml::activeId($modPasien,'rt').'").val(ui.item.rt);
//                            $("#'.CHtml::activeId($modPasien,'rw').'").val(ui.item.rw);
//                            $("#'.CHtml::activeId($modPasien,'propinsi_id').'").val(ui.item.propinsi_id);
//                            $("#'.CHtml::activeId($modPasien,'kabupaten_id').'").val(ui.item.kabupaten_id);
//                            $("#'.CHtml::activeId($modPasien,'kecamatan_id').'").val(ui.item.kecamatan_id);
//                            $("#'.CHtml::activeId($modPasien,'kelurahan_id').'").val(ui.item.kelurahan_id);
//                            $("#'.CHtml::activeId($modPasien,'no_telepon_pasien').'").val(ui.item.no_telepon_pasien);
//                            $("#'.CHtml::activeId($modPasien,'no_mobile_pasien').'").val(ui.item.no_mobile_pasien);
//                            $("#'.CHtml::activeId($modPasien,'suku_id').'").val(ui.item.suku_id);
//                            $("#'.CHtml::activeId($modPasien,'alamatemail').'").val(ui.item.alamatemail);
//                            $("#'.CHtml::activeId($modPasien,'anakke').'").val(ui.item.anakke);
//                            $("#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'").val(ui.item.jumlah_bersaudara);
//                            $("#'.CHtml::activeId($modPasien,'pendidikan_id').'").val(ui.item.pendidikan_id);
//                            $("#'.CHtml::activeId($modPasien,'pekerjaan_id').'").val(ui.item.pekerjaan_id);
//                            $("#'.CHtml::activeId($modPasien,'agama').'").val(ui.item.agama);
//                            $("#'.CHtml::activeId($modPasien,'warga_negara').'").val(ui.item.warga_negara);
//                            return false;
//                        }',
//
//                    ),
//                    'tombolDialog'=>array('readonly'=>true,'idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog'),
//                    'htmlOptions'=>array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)"),
//                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('readonly'=>true,'class'=>'control-label')) ?>
            <div class="controls">
                <?php 
                echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                                              array('empty'=>'-- Pilih --','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                                    )); ?>   
                <?php echo $form->textField($modPasien,'no_identitas_pasien', array('readonly'=>true,'placeholder'=>'No. Identitas','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
                <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
            <div class="controls inline">
                <?php echo $form->textField($modPasien,'nama_pasien', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>            
                <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
//                        $this->widget('MyDateTimePicker',array(
//                                        'model'=>$modPasien,
//                                        'attribute'=>'tanggal_lahir',
//                                        'mode'=>'date',
//                                        'options'=> array('readonly'=>true,
//                                            'dateFormat'=>Params::DATE_FORMAT,
//                                            'maxDate' => 'd',
//                                            'onkeypress'=>"js:function(){getUmur(this);}",
//                                            'onSelect'=>'js:function(){getUmur(this);}',
//                                            'yearRange'=> "-150:+0",
//                                        ),
//                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
//                                        ),
//                )); ?>
                <?php echo $form->textField($modPasien,'tanggal_lahir', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>
                <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPasien,'jeniskelamin', array('class'=>'control-label inline')) ?>
            <div class="controls">
                <?php // echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textField($modPasien,'jeniskelamin', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>
            </div> 
        </div>
        <?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline')) ?>

            <div class="controls">
                <?php echo $form->textField($modPasien,'rt', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 ','maxlength'=>3)); ?>   / 
                <?php echo $form->textField($modPasien,'rw', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 ','maxlength'=>3)); ?>            
                <?php echo $form->error($modPasien, 'rt'); ?>
                <?php echo $form->error($modPasien, 'rw'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
        <?php echo $form->labelEx($modPasien,'no_telepon_pasien', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien,'no_telepon_pasien', array('readonly'=>true,'class'=>'numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Telepon yang dapat dihubungi')); ?>
            <?php echo $form->error($modPasien, 'no_telepon_pasien'); ?>
        </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien,'no_mobile_pasien', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPasien,'no_mobile_pasien', array('readonly'=>true,'class'=>'numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. HP yang dapat dihubungi')); ?>
                <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPasien,'alamatemail', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alamat E-mail')); ?>
    </div>    
</div>
<?php 
////========= Dialog buat cari data pasien =========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//    'id'=>'dialogPasien',
//    'options'=>array(
//        'title'=>'Pencarian Data Pasien Apotek',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'width'=>900,
//        'height'=>600,
//        'resizable'=>false,
//    ),
//));
//
//$modDataPasien = new FAPasienM('searchPasienApotek');
//$modDataPasien->unsetAttributes();
//if(isset($_GET['FAPasienM'])) {
//    $modDataPasien->attributes = $_GET['FAPasienM'];
//}
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//    'id'=>'pasien-m-grid',
//    'dataProvider'=>$modDataPasien->searchPasienApotek(),
//    'filter'=>$modDataPasien,
//    'template'=>"{summary}\n{items}\n{pager}",
//    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//    'columns'=>array(
//        array(
//            'header'=>'Pilih',
//            'type'=>'raw',
//            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
//                "id" => "selectPasien",
//                "onClick" => "
//                    $(\"#dialogPasien\").dialog(\"close\");
//                    $(\"#noPasienApotek\").val(\"$data->no_rekam_medik\");
//                    $(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
//                    var kelurahan = String.trim(\'$data->kelurahan_id\');
//                    if(kelurahan.length == 0){
//                        kelurahan = 0
//                    }
//                    setJenisKelaminPasien(\"$data->jeniskelamin\");
//                    $(\"#'.CHtml::activeId($modPasien,'pasien_id').'\").val(\"$data->pasien_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'jenisidentitas').'\").val(\"$data->jenisidentitas\");
//                    $(\"#'.CHtml::activeId($modPasien,'no_identitas_pasien').'\").val(\"$data->no_identitas_pasien\");
//                    $(\"#'.CHtml::activeId($modPasien,'namadepan').'\").val(\"$data->namadepan\");
//                    $(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
//                    $(\"#'.CHtml::activeId($modPasien,'nama_bin').'\").val(\"$data->nama_bin\");
//                    $(\"#'.CHtml::activeId($modPasien,'tempat_lahir').'\").val(\"$data->tempat_lahir\");
//                    $(\"#'.CHtml::activeId($modPasien,'tanggal_lahir').'\").val(\"$data->tanggal_lahir\");
//                    $(\"#'.CHtml::activeId($modPasien,'kelompokumur_id').'\").val(\"$data->kelompokumur_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'jeniskelamin').'\").val(\"$data->jeniskelamin\");
//                    $(\"#'.CHtml::activeId($modPasien,'statusperkawinan').'\").val(\"$data->statusperkawinan\");
//                    $(\"#'.CHtml::activeId($modPasien,'golongandarah').'\").val(\"$data->golongandarah\");
//                    $(\"#'.CHtml::activeId($modPasien,'rhesus').'\").val(\"$data->rhesus\");
//                    $(\"#'.CHtml::activeId($modPasien,'alamat_pasien').'\").val(\"$data->alamat_pasien\");
//                    $(\"#'.CHtml::activeId($modPasien,'rt').'\").val(\"$data->rt\");
//                    $(\"#'.CHtml::activeId($modPasien,'rw').'\").val(\"$data->rw\");
//                    $(\"#'.CHtml::activeId($modPasien,'propinsi_id').'\").val(\"$data->propinsi_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'kabupaten_id').'\").val(\"$data->kabupaten_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'kecamatan_id').'\").val(\"$data->kecamatan_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'kelurahan_id').'\").val(\"$data->kelurahan_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'no_telepon_pasien').'\").val(\"$data->no_telepon_pasien\");
//                    $(\"#'.CHtml::activeId($modPasien,'no_mobile_pasien').'\").val(\"$data->no_mobile_pasien\");
//                    $(\"#'.CHtml::activeId($modPasien,'suku_id').'\").val(\"$data->suku_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'alamatemail').'\").val(\"$data->alamatemail\");
//                    $(\"#'.CHtml::activeId($modPasien,'anakke').'\").val(\"$data->anakke\");
//                    $(\"#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'\").val(\"$data->jumlah_bersaudara\");
//                    $(\"#'.CHtml::activeId($modPasien,'pendidikan_id').'\").val(\"$data->pendidikan_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'pekerjaan_id').'\").val(\"$data->pekerjaan_id\");
//                    $(\"#'.CHtml::activeId($modPasien,'agama').'\").val(\"$data->agama\");
//                    $(\"#'.CHtml::activeId($modPasien,'warga_negara').'\").val(\"$data->warga_negara\");
//                "))',
//        ),
//        array(
//                'name'=>'no_rekam_medik',
//                'header'=>'No. Rekam Medik',
//                'value'=>'$data->no_rekam_medik',
//        ),
//        'nama_pasien',
//        array(
//                'name'=>'nama_bin',
//                'header'=>'Alias',
//                'value'=>'$data->nama_bin',
//        ),
//        'alamat_pasien',
//        'rw',
//        'rt',
//        array(
//            'name'=>'propinsiNama',
//            'value'=>'$data->propinsi->propinsi_nama',
//        ),
//        array(
//            'name'=>'kabupatenNama',
//            'value'=>'$data->kabupaten->kabupaten_nama',
//        ),
//        array(
//            'name'=>'kecamatanNama',
//            'value'=>'$data->kecamatan->kecamatan_nama',
//        ),
//        array(
//            'name'=>'kelurahanNama',
//            'value'=>'isset($data->kelurahan->kelurahan_nama)?($data->kelurahan->kelurahan_nama):""',
//        ),
//    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//));
//
//$this->endWidget();
////========= end pasien dialog =============================
?>