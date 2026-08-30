<fieldset>
    <legend>Jadwal Imunisasi Ibu Hamil</legend>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'riwayatkehamilan-grid',
                    'dataProvider'=>$modJadwalTTBumil->searchImunisasi(),
                            'template'=>"{summary}\n{items}\n{pager}",

                            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                     'columns'=>array(
                                array(
                                   'header'=>'Pilih',
                                    'type'=>'raw',
                                    'value'=>'(
                                        ($data->jadwalttbumil_id=="'.$modPasienImunisasi->jadwalttbumil_id.'") 
                                            ? CHtml::radioButton("isPilih",true,array("onclick"=>"pilihJadwalTTBumil($data->jadwalttbumil_id,$data->diagnosa_id,this)"))
                                            : CHtml::radioButton("isPilih",false,array("onclick"=>"pilihJadwalTTBumil($data->jadwalttbumil_id,$data->diagnosa_id,this)")))',
                                ),
                                array(
                                    'name'=>'diagnosa_id',
                                    'value'=>'$data->diagnosa->diagnosa_nama',
                                    'filter'=>false,
                                    ),
                                'jadwalttbumil_kode',
                                'jadwalttbumil_id',
                                'jadwalttbumil_nama',
                                'jadwalttbumil_desc',
                                'jadwalttbumil_periode',
                                'jadwalttbumil_pemberian',
                                'jadwalttbumil_dosis',

                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    ));
            ?>
</fieldset>
<fieldset>
    <legend>Data Imunisasi</legend>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($modPasienImunisasi,'pegawai_id',  CHtml::listData($modPasienImunisasi->DokterItems, 'pegawai_id', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($modPasienImunisasi,'paramedis_id',  CHtml::listData($modPasienImunisasi->ParamedisItems, 'pegawai_id', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($modPasienImunisasi,'statusimunisasi_id',  CHtml::listData($modPasienImunisasi->StatusImunisasiItems, 'statusimunisasi_id', 'kodeNama'),array('class'=>'span3 isRequired', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
             <?php echo $form->labelEx($modPasienImunisasi,'diagnosa_id', array('class'=>'control-label')) ?>
                    <div class="controls">  
                       <?php echo CHtml::textField('namaDiagnosa',$modPasienImunisasi->diagnosa->diagnosa_nama,array('style'=>'width: 320px','readonly'=>TRUE));?>
                       <?php echo $form->hiddenField($modPasienImunisasi,'diagnosa_id',array('class'=>'isRequired'));?>

                    </div>
            

        </td>
        <td>
            <?php echo $form->labelEx($modPasienImunisasi,'tglimunisasi', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modPasienImunisasi,
                                             'attribute'=>'tglimunisasi',
                                             'mode'=>'date',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                             'maxDate'=>'d',   
                                                 ),
                                             'htmlOptions'=>array('readonly'=>true,'class'=>'isRequired',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
            <?php echo $form->textAreaRow($modPasienImunisasi,'catatanimunisasi',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>
    
</fieldset>    

<?php
$idJadwalTTBUmil=  CHtml::activeId($modPasienImunisasi,'jadwalttbumil_id');
$idDiagnosa= CHtml::activeId($modPasienImunisasi,'diagnosa_id');
$urlNamaDiagnosa=Yii::app()->createUrl('Imunisasi/getNamaDiagnosa');

$jscript = <<< JS

function pilihJadwalTTBumil(idJadwalTTBumil,idDiagnosa,obj)
{
    $('#${idJadwalTTBUmil}').val(idJadwalTTBumil);
    $('#${idDiagnosa}').val(idDiagnosa);    
    
     $.post("${urlNamaDiagnosa}",{idDiagnosa: idDiagnosa},
        function(data){
                  $('#namaDiagnosa').val(data.namaDiagnosa);
    },"json");
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

JS;
Yii::app()->clientScript->registerScript('_formPasien',$jscript, CClientScript::POS_HEAD);
?>

