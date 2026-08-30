<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Data Pasien
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">
                    <span class="tombol" style="display:none;"> <?php echo CHtml::htmlButton("<i class='icon-refresh icon-white'></i>",array("class"=>"btn btn-danger btn-mini","id"=>'tombolpasien','onclick'=>'setInfoPasienReset();','onkeyup'=>"return $(this).focusNextInputField(event)","rel"=>"tooltip","title"=>"Klik untuk mengulang data pasien")) ; ?></span> Pencarian Data Pasien
                </label>
                <div class="controls">
                    <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly'=>true));?>
                    <?php 
                    $this->widget('MyJuiAutoComplete',array(
                        'name'=>'noPasienApotek',
                        'value'=>$modPasien->no_rekam_medik,
                        'sourceUrl'=> $this->createUrl('AutocompletePasienApotek'),
                        'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 4,
                        'select'=>'js:function( event, ui ) {
                                $("#noPasienApotek").val( ui.item.value );
                                setInfoPasien(ui.item.no_rekam_medik, ui.item.pasien_id);
                                setJenisKelaminPasien(ui.item.jeniskelamin);
                                var kelurahan = String.trim(\'ui.item.kelurahan_id\');
                                if(kelurahan.length == 0){
                                    kelurahan = 0
                                }
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog','jsFunction'=>'setDialogPasien()'),
                        'htmlOptions'=>array('class'=>'span3','readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)"),
                    )); 

                    echo CHtml::checkBox('is_pasienrs',false,array('rel'=>'tooltip','title'=>'Pilih untuk pasien Rumah Sakit','onkeyup'=>"return $(this).focusNextInputField(event);")).' <label>Pilih untuk pasien Rumah Sakit</label>';
                    ?> 

                </div>
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setInfoPasienReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data pasien')); ?></span>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php 
                        echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                        array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1'
                    )); ?>   
                    <?php echo $form->textField($modPasien,'no_identitas_pasien', array('placeholder'=>'No. Identitas','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
                    <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                <div class="controls inline">
                    <?php echo $form->textField($modPasien,'nama_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>            
                    <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
                </div>
            </div>

            <div class="control-group ">
                <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                    $modPasien->tanggal_lahir = (!empty($modPasien->tanggal_lahir) ? date("d/m/Y",strtotime($modPasien->tanggal_lahir)) : null);
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$modPasien,
                        'attribute'=>'tanggal_lahir',
                        'mode'=>'date',
                        'options'=> array(
        //                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'onkeyup'=>"js:function(){setUmur(this.value);}",
                            'onSelect'=>'js:function(){setUmur(this.value);}',
                            'yearRange'=> "-150:+0",
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'span3 dtPicker2 datemask', 'onblur'=>'setUmur(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)"
                        ),
                    )); ?>
                    <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Umur</label>
                <div class="controls">
                    <?php echo CHtml::textField('umur','',array('placeholder'=>'00 Thn 00 Bln 00 Hr','class'=>'span3 umur', 'onblur'=>'setTglLahir(this);','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                </div>
            </div>

            <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </div>    
        <div class="col-sm-6">
            <?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline')) ?>

                <div class="controls">
                    <?php echo $form->textField($modPasien,'rt', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 ','maxlength'=>3)); ?>   / 
                    <?php echo $form->textField($modPasien,'rw', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 ','maxlength'=>3)); ?>            
                    <?php echo $form->error($modPasien, 'rt'); ?>
                    <?php echo $form->error($modPasien, 'rw'); ?>
                </div>
            </div>
            <div class="control-group ">
            <?php echo $form->labelEx($modPasien,'no_telepon_pasien', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPasien,'no_telepon_pasien', array('class'=>'numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Telepon yang dapat dihubungi')); ?>
                <?php echo $form->error($modPasien, 'no_telepon_pasien'); ?>
            </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPasien,'no_mobile_pasien', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien,'no_mobile_pasien', array('class'=>'numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. HP yang dapat dihubungi')); ?>
                    <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPasien,'alamatemail', arraY('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alamat E-mail')); ?>
        </div>    
    </div>
</div>
<?php 
//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien Apotek',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDataPasien = new BKPasienM('searchPasienApotek');
$modDataPasien->unsetAttributes();
if(isset($_GET['FAPasienM'])) {
    $modDataPasien->attributes = $_GET['FAPasienM'];
    $modDataPasien->propinsiNama = isset($_GET['FAPasienM']['propinsiNama']) ? $_GET['FAPasienM']['propinsiNama'] : null;
    $modDataPasien->kabupatenNama = isset($_GET['FAPasienM']['kabupatenNama']) ? $_GET['FAPasienM']['kabupatenNama'] : null;
    $modDataPasien->kecamatanNama = isset($_GET['FAPasienM']['kecamatanNama']) ? $_GET['FAPasienM']['kecamatanNama'] : null;
    $modDataPasien->kelurahanNama = isset($_GET['FAPasienM']['kelurahanNama']) ? $_GET['FAPasienM']['kelurahanNama'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pasien-m-grid',
    'dataProvider'=>$modDataPasien->searchPasienApotek(),
    'filter'=>$modDataPasien,
    'template'=>"{items}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPasien",
                "onClick" => "
                    $(\"#dialogPasien\").dialog(\"close\");
                    $(\"#noPasienApotek\").val(\"$data->no_rekam_medik\");
                    setInfoPasien(\"$data->no_rekam_medik\",$data->pasien_id);
                    var kelurahan = String.trim(\'$data->kelurahan_id\');
                    if(kelurahan.length == 0){
                        kelurahan = 0
                    }
                    setJenisKelaminPasien(\"$data->jeniskelamin\");
                "))',
        ),
        array(
                'name'=>'no_rekam_medik',
                'header'=>'No. Rekam Medik',
                'value'=>'$data->no_rekam_medik',
        ),
        'nama_pasien',
        array(
                'name'=>'nama_bin',
                'header'=>'Alias',
                'value'=>'$data->nama_bin',
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'name'=>'propinsiNama',
            'value'=>'$data->propinsi->propinsi_nama',
        ),
        array(
            'name'=>'kabupatenNama',
            'value'=>'$data->kabupaten->kabupaten_nama',
        ),
        array(
            'name'=>'kecamatanNama',
            'value'=>'$data->kecamatan->kecamatan_nama',
        ),
        array(
            'name'=>'kelurahanNama',
            'value'=>'isset($data->kelurahan->kelurahan_nama)?($data->kelurahan->kelurahan_nama):""',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end pasien dialog =============================
?>
<script type="text/javascript">
    function setDialogPasien(){
        if($($('#is_pasienrs')).attr('checked')){
           $.fn.yiiGridView.update('pasien-m-grid', {
                data: {
                    "FAPasienM[ispasienluar]":0,
                    "FAPasienM[create_ruangan]":'',
                }
            }); 
       }else{
        $.fn.yiiGridView.update('pasien-m-grid', {
                data: {
                    "FAPasienM[ispasienluar]":1,
                }
            }); 
       }
       $('#dialogPasien').dialog('open');
       return false;
    }
</script>