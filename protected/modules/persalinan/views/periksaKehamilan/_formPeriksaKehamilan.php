<fieldset>
    <legend>Data Pemeriksaan Kehamilan</legend>
    <table>
        <tr>
            <td><?php echo $form->labelEx($modPeriksaKehamilan,'pegawai_id', array('class'=>'control-label')) ?></td>
            <td><?php echo $form->dropDownList($modPeriksaKehamilan,'pegawai_id',  CHtml::listData($modPeriksaKehamilan->DokterItems, 'pegawai_id', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?></td>
        
            <td>
                 <?php echo $form->LabelEx($modPeriksaKehamilan,'tb_cm_',array('class'=>'control-label','style'=>'width:75px'));?>
                 <?php echo $form->LabelEx($modPeriksaKehamilan,'bb_gram',array('class'=>'control-label','style'=>'width:80px'));?>
            </td>
            <td>
                  <?php echo $form->textField($modPeriksaKehamilan,'tb_cm_',array('onkeyup'=>'numberOnly(this,\'\');','class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                  <?php echo $form->textField($modPeriksaKehamilan,'bb_gram',array('onkeyup'=>'numberOnly(this,\'\');','class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                       Cm / Gram  
            </td>
        </tr>
        
        <tr>
            <td><?php echo $form->labelEx($modPeriksaKehamilan,'bidan_id', array('class'=>'control-label')) ?></td>
            <td>
                    <?php echo $form->dropDownList($modPeriksaKehamilan,'bidan_id',  CHtml::listData($modPeriksaKehamilan->BidanItems, 'pegawai_id', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </td>
            <td>
                        <?php echo $form->LabelEx($modPeriksaKehamilan,'masagestasike',array('class'=>'control-label'));?>
            </td>
            <td>
                    <?php echo $form->textField($modPeriksaKehamilan,'masagestasike',array('onkeyup'=>'numberOnly(this,1);','class'=>'span2 isRequired', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                                Minggu
            </td>
        </tr>
        
        <tr>
            
            <td>
                <?php echo $form->labelEx($modPeriksaKehamilan,'tglpemeriksaaan', array('class'=>'control-label')) ?>
            </td>
            <td>
                        <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modPeriksaKehamilan,
                                             'attribute'=>'tglpemeriksaaan',
                                             'mode'=>'datetime',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                             'maxDate'=>'d',   
                                                 ),
                                             'htmlOptions'=>array('readonly'=>true,'class'=>'isRequired',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
            </td>
            <td rowspan="3">
                    <?php echo $form->labelEx($modPeriksaKehamilan,'keadaanibuhamil', array('class'=>'control-label')) ?>            </td>
            </td>
            <td rowspan="3">
                <?php echo $form->textArea($modPeriksaKehamilan,'keadaanibuhamil',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            
           
        </tr>
        <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'tglkehamilan', array('class'=>'control-label')) ?>            </td>
            <td>
                    <?php $this->widget('MyDateTimePicker',array(
                                                                 'model'=>$modPeriksaKehamilan,
                                                                 'attribute'=>'tglkehamilan',
                                                                 'mode'=>'datetime',
                                                                 'options'=> array(
                                                                 'dateFormat'=>Params::DATE_FORMAT,
                                                                 'maxDate'=>'d',   
                                                                     ),
                                                                 'htmlOptions'=>array('readonly'=>true,'class'=>'isRequired',
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                     )); ?>
            </td>
            
            
        </tr>
        <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'tglakhirmenstruasi', array('class'=>'control-label')) ?>
            <td>
                    <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modPeriksaKehamilan,
                                             'attribute'=>'tglakhirmenstruasi',
                                             'mode'=>'date',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                             'maxDate'=>'d',   
                                                 ),
                                             'htmlOptions'=>array('readonly'=>true,'class'=>'isRequired',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                    )); ?>
            </td>
            
            
        </tr>
         <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'tglperkiraankelahiran', array('class'=>'control-label')) ?>
            <td>
                    <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modPeriksaKehamilan,
                                             'attribute'=>'tglperkiraankelahiran',
                                             'mode'=>'date',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                             'minDate'=>'d',   
                                                 ),
                                             'htmlOptions'=>array('readonly'=>true,
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
            </td>
            <td rowspan="3">
                    <?php echo $form->labelEx($modPeriksaKehamilan,'keadaanjanin', array('class'=>'control-label')) ?>            </td>
            </td>
            <td rowspan="3">
                    <?php echo $form->textArea($modPeriksaKehamilan,'keadaanjanin',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
        
        <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'gravida', array('class'=>'control-label')) ?>
            <td>
                    <?php echo $form->dropDownList($modPeriksaKehamilan,'gravida', LookupM::getItems('gravida'),  
                              array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3'
                                    )); ?>
            </td>
        </tr>
        
         <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'posisijanin', array('class'=>'control-label')) ?>
            <td>
                    <?php echo $form->dropDownList($modPeriksaKehamilan,'posisijanin', LookupM::getItems('posisijanin'),  
                                  array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                        )); ?>   
            </td>
        </tr>
        
        <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'jmlpartusimaturus', array('class'=>'control-label')) ?>
             </td>
             <td>
                    <?php echo $form->textField($modPeriksaKehamilan,'jmlpartusimaturus',array('onkeyup'=>'numberOnly(this,0);','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td rowspan="3">
                    <?php echo $form->labelEx($modPeriksaKehamilan,'catatankehamilan', array('class'=>'control-label')) ?>            </td>
            </td>
            <td rowspan="3">
                    <?php echo $form->textArea($modPeriksaKehamilan,'catatankehamilan',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
         <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'jmlpartusmaturus', array('class'=>'control-label')) ?>
             </td>
             <td>
                    <?php echo $form->textField($modPeriksaKehamilan,'jmlpartusmaturus',array('onkeyup'=>'numberOnly(this,0);','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
        
        <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'jmlpartuspostmaturus', array('class'=>'control-label')) ?>
             </td>
             <td>
                    <?php echo $form->textField($modPeriksaKehamilan,'jmlpartuspostmaturus',array('onkeyup'=>'numberOnly(this,0);','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
        
        <tr>
             <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'jmlabortus', array('class'=>'control-label')) ?>
             </td>
             <td>
                    <?php echo $form->textField($modPeriksaKehamilan,'jmlabortus',array('onkeyup'=>'numberOnly(this,0);','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                    <?php echo $form->labelEx($modPeriksaKehamilan,'filefotousg', array('class'=>'control-label','onkeypress'=>"return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
            </td>
            <td>
                    <?php echo Chtml::activeFileField($modPeriksaKehamilan,'filefotousg',array('onchange'=>'readURL(this);','hint'=>'Isi Jika Akan Menambahkan Logo')); ?>
                    <div id="divTombolLihat" align="right">
                        <?php echo CHtml::htmlButton(Yii::t('mds','Lihat Foto',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'lihatFoto()')); ?>
                    </div>
                    <div id="divTombolTutup" style="display: none;" align="right">
                        <?php echo CHtml::htmlButton(Yii::t('mds','Tutup Foto',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'lihatFoto()')); ?>
                    </div> 
            </td>
        </tr>
    </table>
    
    
                <div id="divFoto" style="display: none;" align="right">
                    <fieldset>
                        <legend>Foto USG</legend>
                             <?php
                                if(!empty($modPeriksaKehamilan->filefotousg)){
                                    echo "<img id=\"img_prev\" src=\"".Params::urlUSGTumbsDirectory().'kecil_'.$modPeriksaKehamilan->filefotousg."\" title=\"Klik untuk Memperbesar Gambar\" onclick=\"$('#dialogFoto').dialog('open');\">";
                                }else{
                                    echo "<img id=\"img_prev\" src=\"".Params::urlUSGDirectory()."no_photo.jpeg\">";
                                }
                             ?>
                     </fieldset>   
                 </div>   
           
</fieldset>
<?php
// ===========================Dialog Foto=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogFoto',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Foto USG',
                        'autoOpen'=>false,
                        'minWidth'=>1100,
                        'minHeight'=>100,
                        'resizable'=>true,
                         ),
                    ));
echo "<div align=\"center\">
        <img src=\"".Params::urlUSGDirectory().$modPeriksaKehamilan->filefotousg."\">
      </div>";
  
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Foto================================

$jscript = <<< JS

function lihatFoto()
{
    $('#divFoto').slideToggle(500);
    $('#divTombolLihat').slideToggle(500);
    $('#divTombolTutup').slideToggle(500);
}
   
function numberOnly(obj,nilaiKosong)
{
    var d = $(obj).attr('numeric');
    var value = $(obj).val();
    var orignalValue = value;

    if (d == 'decimal') {
    value = value.replace(/\./, "");
    msg = "Only Numeric Values allowed.";
    }

    if (value != '') {
    orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
    $(obj).val(orignalValue);
    }else{
    $(obj).val(nilaiKosong);
    }
    
}

function validasi()
{
    kosong = 'Tidak';
    $('.isRequired').each(function() {
           if($(this).val()==''){
             kosong='Ya';
             $(this).focus();
           }
        });
    
    if(kosong=='Tidak'){
        $('#btn_simpan').click();
    }else{
        myAlert('Harap isi semua field yang bertanda *');
    }    
}

    function readURL(input) 
    {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
    $('#img_prev')
    .attr('src', e.target.result)
    };

    reader.readAsDataURL(input.files[0]);
    }
}

JS;
Yii::app()->clientScript->registerScript('faktur',$jscript, CClientScript::POS_HEAD);
?>