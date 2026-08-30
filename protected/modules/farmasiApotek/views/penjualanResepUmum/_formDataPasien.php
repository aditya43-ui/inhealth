<style>
    .ui-dialog {
        top: 100px !important;
    }
</style>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">
                <span class="tombol" style="display:none;"> <?php echo CHtml::htmlButton("<i class='icon-refresh icon-white'></i>",array("class"=>"btn btn-danger btn-mini","id"=>'tombolpasien','onclick'=>'setInfoPasienReset();','onkeyup'=>"return $(this).focusNextInputField(event)","rel"=>"tooltip","title"=>"Klik untuk mengulang data pasien")) ; ?></span> No. Pasien Apotek
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
<?php 
    $this->renderPartial($this->path_view_umum . '_dialogPasien');
?>

<script type="text/javascript">
    function setDialogPasien(){
        if($('#is_pasienrs').is(':checked')){
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