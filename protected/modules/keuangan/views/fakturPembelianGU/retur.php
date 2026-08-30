<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfpenerimaanbarang-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); 
$this->widget('bootstrap.widgets.BootAlert'); ?>

    
    <table>
        <tr>
            <td>
                <fieldset>
                    <legend>Data Faktur</legend>
                    <b><?php echo CHtml::encode($modFaktur->getAttributeLabel('supplier_id')); ?>:</b>
                    <?php echo CHtml::encode($modFaktur->supplier->supplier_nama); ?>
                    <br>
                     <b><?php echo CHtml::encode($modFaktur->getAttributeLabel('ruangan_id')); ?>:</b>
                    <?php echo CHtml::encode($modFaktur->ruangan->ruangan_nama); ?>
                    <br>
                    <b><?php echo CHtml::encode($modFaktur->getAttributeLabel('tglfaktur')); ?>:</b>
                    <?php echo CHtml::encode($modFaktur->tglfaktur); ?>
                    <br>
                    <b><?php echo CHtml::encode($modFaktur->getAttributeLabel('tgljatuhtempo')); ?>:</b>
                    <?php echo CHtml::encode($modFaktur->tgljatuhtempo); ?>
                    <br>
                </fieldset>
            </td>
            <td>
                <fieldset>
                    <legend>Data Retur</legend>
                    <table>
                        <tr>
                            <td>
                                <?php echo $form->hiddenField($modRetur,'supplier_id', array('class'=>'span2 isRequired','readonly'=>TRUE)) ?>
                                <?php echo $form->hiddenField($modRetur,'fakturpembelian_id', array('class'=>'span2 isRequired','readonly'=>TRUE)) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($modRetur,'tglretur', array('class'=>'control-label')) ?>
                                        <div class="controls">
                                            <?php $this->widget('MyDateTimePicker',array(
                                                        'model'=>$modRetur,
                                                        'attribute'=>'tglretur',
                                                        'mode'=>'datetime',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_TIME_FORMAT,

                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                        ),
                                            )); ?>
                                        </div>
                                </div>
                                <?php echo $form->textFieldRow($modRetur,'noretur', array('class'=>'span2 isRequired','readonly'=>TRUE)) ?>
                               
                                <?php echo $form->textFieldRow($modRetur,'totalretur', array('class'=>'span2 isRequired','readonly'=>TRUE)) ?>
                            </td>
                            <td>
                                <?php echo $form->textAreaRow($modRetur,'alasanretur', array('class'=>'span2 isRequired','readonly'=>FALSE)) ?>
                                <?php echo $form->textAreaRow($modRetur,'keteranganretur', array('class'=>'span2 isRequired','readonly'=>FALSE)) ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>    
            </td>    
        </tr>
    </table>
</fieldset>
<table class="table table-bordered table-condensed">
  <thead>
    <tr>
        <th><?php echo CHtml::checkBox('checkListUtama',true,array('onclick'=>'checkAll(\'cekList\',this);hitungSemua();'));?></th>
        <th>No.</th>
        <th>Asal Barang</th>
        <th>Kategori/<br>Nama Obat</th>
        <th>Satuan Kecil/<br>Satuan Besar</th>
        <th>Harga Netto</th>
        <th>PPN</th>
        <th>PPh</th>
        <th>Jumlah Keringanan</th>
        <th>Harga Satuan</th>
        <th>Jumlah Diterima</th>
        <th>Jumlah Retur</th>
    </tr>
    <?php 
    $no=1;
    foreach ($modFakturDetail AS $tampilData):
        echo "<tr>
                <td>".CHtml::checkBox('checkList[]',true,array('class'=>'cekList','onclick'=>'hitungSemua()'))."</td>
                <td>".CHtml::activeHiddenField($modReturDetails, 'obatalkes_id[]',array('value'=>$tampilData['obatalkes_id'])).
                      CHtml::activeHiddenField($modReturDetails, 'penerimaandetail_id[]',array('value'=>$tampilData['penerimaandetail_id'])).
                      CHtml::activeHiddenField($modReturDetails, 'satuanbesar_id[]',array('value'=>$tampilData['satuanbesar_id'])).
                      CHtml::activeHiddenField($modReturDetails, 'sumberdana_id[]',array('value'=>$tampilData['sumberdana_id'])).
                      CHtml::activeHiddenField($modReturDetails, 'satuankecil_id[]',array('value'=>$tampilData['satuankecil_id'])).  
                      CHtml::activeHiddenField($modReturDetails, 'fakturdetail_id[]',array('value'=>$tampilData['fakturdetail_id'])).
                      $no.
                "</td>
                <td>".$tampilData->sumberdana['sumberdana_nama']."</td>
                <td>".$tampilData->obatalkes['obatalkes_kategori']."<br>".$tampilData->obatalkes['obatalkes_nama']."</td>
                <td>".$tampilData->satuankecil['satuankecil_nama']."<br>".$tampilData->satuanbesar['satuanbesar_nama']."</td>
                <td>".CHtml::activeTextField($modReturDetails, 'harganettoretur[]',array('value'=>$tampilData['harganettofaktur'],'class'=>'span1 netto','readonly'=>TRUE))."</td>
                <td>".CHtml::activeTextField($modReturDetails, 'hargappnretur[]',array('value'=>$tampilData['hargappnfaktur'],'class'=>'span1 ppn','readonly'=>TRUE))."</td>
                <td>".CHtml::activeTextField($modReturDetails, 'hargapphretur[]',array('value'=>$tampilData['hargapphfaktur'],'class'=>'span1 pph','readonly'=>TRUE))."</td>
                <td>".CHtml::activeTextField($modReturDetails, 'jmldiscount[]',array('value'=>$tampilData['jmldiscount'],'class'=>'span1 jmldiskon','readonly'=>TRUE))."</td>
                <td>".CHtml::activeTextField($modReturDetails, 'hargasatuanretur[]',array('value'=>$tampilData['hargasatuan'],'class'=>'span1 hargasatuan','readonly'=>TRUE))."</td>
                <td>".CHtml::TextField('jumlahTerima',$tampilData['jmlterima'],array('class'=>'span1 jumlahterima','readonly'=>TRUE))."</td>
                <td>".CHtml::activeTextField($modReturDetails, 'jmlretur[]',array('value'=>0,'class'=>'span1','readonly'=>FALSE,'onkeyup'=>'numberOnlyNol(this);hitungSemua();'))."</td>
</tr>";
    $no++;
    endforeach; 
    ?>
  </thead>
</table>
<div class="form-actions">
                <?php
                    if($tersimpan==false){
                       echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'cekValidasi()'));
                    }
                ?>
                    <div style="display: none">     
                         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan')); ?>
                    </div>
        <?php 
             $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
             $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
             $action=$this->getAction()->getId();
             $currentAction=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/'.$action);
//             echo CHtml::button(Yii::t('mds','{icon} Cancel',array('{icon}'=>'')),array('class' => 'btn btn-default','onclick'=>'$(\'#dialogRetur\').dialog("close")'));
//                   echo CHtml::link(, 
//                   "javascript:$('#dialogRetur').dialog('close')", 
//                   array('class' => 'btn btn-default',));
        ?> 
</div>
<?php $this->endWidget(); ?>

<?php

$totalRetur=  CHtml::activeId($modRetur,'totalretur');
$noRetur= CHtml::activeId($modRetur,'noretur');
$alasanRetur= CHtml::activeId($modRetur,'alasanretur');
$jscript = <<< JS

function cekValidasi()
{ 
  if($('#${noRetur}').val()==''){ //Jika NO retur Kosong
    alert('No. Retur Tidak Boleh Kosong');
  }else if($('#${alasanRetur}').val()==''){//Jika Alasan Retur Kosong
    alert('Alasan Retur Tidak Boleh Kosong');
//  }else if(parseFloat($('#${totalRetur}').val())<1){//JIka Total YAng Ditetur NOL
//      alert('Anda Belum Memilih Barang Yang Akan Diretur');
  }else{
        $('#btn_simpan').click();
//    alert('simpan');
  }    
  
}

function hitungSemua()
{
    totalSemua=0;
    $('.netto').each(function(){
            
      if($(this).parent().prev().prev().prev().prev().prev().find('input').is(':checked'))
        {//Jika Di ceklist
            totalPerObat=0;
            hargaSatuan = parseFloat($(this).parent().next().next().next().next().find('input').val());
            jumlahRetur = parseFloat($(this).parent().next().next().next().next().next().next().find('input').val());
            jumlahTerima = parseFloat($(this).parent().next().next().next().next().next().find('input').val());
           
          
            
            if(jumlahTerima<jumlahRetur){//Jika jumlah Retur Lebih Besar Dari Jumlah Yang Diterma
                $(this).parent().next().next().next().next().next().next().find('input').val(jumlahTerima);
                jumlahRetur=jumlahTerima;
            
            }

            totalPerObat = hargaSatuan * jumlahRetur;
            
            totalSemua=totalSemua+totalPerObat;
            
        }
   });
   $('#${totalRetur}').val(totalSemua);
}

function numberOnlyNol(obj)
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
    $(obj).val(0);
    }
}
JS;
Yii::app()->clientScript->registerScript('jascriptRetir',$jscript, CClientScript::POS_HEAD);
?>
        
