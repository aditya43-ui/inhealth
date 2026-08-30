<?php 
if(!empty($modTindakans)) {
    $this->renderPartial('_cekvalidTindakanPasien',array('modTindakans'=>$modTindakans,'removeButton'=>true));
} else {
?>
<tr>
    <td><?php echo CHtml::activeTextField($modTindakan, '[0]kategoriTindakanNama', array('readonly'=>true,'class'=>'inputFormTabel')) ?></td>
    <td><?php echo CHtml::activeHiddenField($modTindakan, '[0]daftartindakan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modTindakan,
                    'attribute'=>'[0]daftartindakanNama',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('DaftarTindakan').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           tipepaket_id: $("#GZTindakanpelayananT_0_tipepaket_id").val(),
                                           kelaspelayanan_id: $("#GZPendaftaranT_kelaspelayanan_id").val(),
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            setTindakan($(this), ui.item);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span4','jsFunction'=>"setDialog(this);"),
        )); ?>
        <?php //echo CHtml::link('<i class="icon-plus icon-white"></i>', 'javascript:void(0)', array('onclick'=>"$('#dialogDaftarTindakan').dialog('open');return false;",'class' => 'btn btn-danger',)); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>

        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]iurbiaya_tindakan', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
    </td> 
    <td><?php echo CHtml::activeTextField($modTindakan, '[0]qty_tindakan', array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel lebar1 number numbersOnly')) ?></td>
    <!--<td><?php echo CHtml::activeTextField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?></td>-->
    <!--<td><?php echo CHtml::activeTextField($modTindakan, '[0]qty_tindakan', array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel lebar1 number numbersOnly')) ?></td>-->
    <td><?php echo CHtml::activeDropDownList($modTindakan, '[0]satuantindakan', LookupM::getItems('satuantindakan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel')) ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]persenCyto', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeDropDownList($modTindakan, '[0]cyto_tindakan', array('0'=>'Tidak','1'=>'Ya'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel lebar2-5')) ?>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, '[0]tarifcyto_tindakan', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
      <?php echo CHtml::activeHiddenField($modTindakan, '[0]jumlahTarif', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
    </td>
   <td> 
      <?php echo CHtml::activeTextField($modTindakan, '[0]jumlahTarif', array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
   </td>    <td rowspan="2">
        <?php 
            if(!isset($removeButton)){
                $removeButton = false;
            }
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan')); 
                echo "<br><br>";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
            }
        ?>
    </td>
</tr>
<tr>
    <td><div class="input-append"><?php echo CHtml::activeTextField($modTindakan, '[0]tgl_tindakan', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;','value'=>date('Y-m-d H:i:s'))); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div></td>
    <td style="text-align: right;"><b>Pemeriksa :</b></td>
    <td colspan="6">
        <table style="margin:0;">
          <tr>
            <td width="20px" style="background-color:transparent;border: 0;">
              <?php echo CHtml::hiddenField('row', 0, array('readonly'=>true, 'class'=>'span1')); ?>
              <?php echo CHtml::link("<i class='icon-plus-sign' title='Klik untuk mengganti dokter pemeriksa'></i>", '#', array('id'=>'btnAddDokter_0','onclick'=>'addDokter(this);return false;')); ?></td>
            <!--<td style="background-color:transparent;border: 0;"><div id="tampilanDokterPemeriksa"></div></td>-->
            <td style="background-color:transparent;border: 0;"><div id="tampilanDokterPemeriksa"><?php echo (empty($modTindakan->dokterpemeriksa1Nama)) ? "" : "Dokter Pemeriksa : ".$modTindakan->dokterpemeriksa1Nama; ?></div></td>
            <!--<td style="background-color:transparent;border: 0;"><div id="tampilanDokterDelegasi_0"></div></td>-->             
            <td style="background-color:transparent;border: 0;"><?php echo CHtml::activeTextField($modTindakan, '[0]keterangantindakan', array('readonly'=>false,'class'=>'inputFormTabel span3','placeholder'=>'Keterangan Tindakan')) ?></td> 
          </tr>
        </table>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpemeriksa1_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpemeriksa2_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpendamping_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokteranastesi_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterdelegasi_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]bidan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]suster_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]perawat_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>            
    </td>    
</tr>
<?php } 

//$js = <<< JS
//$('.numbersOnly').keyup(function() {
//var d = $(this).attr('numeric');
//var value = $(this).val();
//var orignalValue = value;
//value = value.replace(/[0-9]*/g, "");
//var msg = "Only Integer Values allowed.";
//
//if (d == 'decimal') {
//value = value.replace(/\./, "");
//msg = "Only Numeric Values allowed.";
//}
//
//if (value != '') {
//orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
//$(this).val(orignalValue);
//}
//});
//JS;
//Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>
