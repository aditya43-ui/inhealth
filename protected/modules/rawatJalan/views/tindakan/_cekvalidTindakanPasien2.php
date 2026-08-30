<?php

foreach ($modTindakans as $i => $modTindakan) {
?>
<tr>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]kategoriTindakanNama", array('readonly'=>true,'class'=>'inputFormTabel')) ?></td>
    <td><?php echo CHtml::activeHiddenField($modTindakan, "[$i]daftartindakan_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modTindakan,
                    'attribute'=>'[0]daftartindakanNama',
//                    'name'=>"daftartindakan[$i]",
//                    'value'=>'',
                    'sourceUrl'=> Yii::app()->createUrl('rawatJalan/tindakan/DaftarTindakan'),
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 4,
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
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2'),
        )); ?>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]tarif_satuan", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?></td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]qty_tindakan", array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel integer lebar1')) ?></td>
    <td><?php echo CHtml::activeDropDownList($modTindakan, "[$i]satuantindakan", LookupM::getItems('satuantindakan'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel')) ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]persenCyto", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeDropDownList($modTindakan, "[$i]cyto_tindakan", array('0'=>'Tidak','1'=>'Ya'), array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel lebar2-5')) ?>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]tarifcyto_tindakan", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?></td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]jumlahTarif", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?></td>
    <td rowspan="2">
        <?php /*
            if($removeButton && $i<1){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan')); 
                echo "<br><br>";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
            }*/
        ?>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td style="text-align: right;"><b>Pemeriksa :</b></td>
    <td colspan="6">&nbsp;
            <?php // echo CHtml::link("<i class='icon-plus-sign'></i>", '#', array('id'=>'btnAddDokter_0','onclick'=>'addDokter(this);return false;')); ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokterpemeriksa1_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokterpemeriksa2_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokterpendamping_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokteranastesi_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokterdelegasi_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]bidan_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]suster_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]perawat_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td>
</tr>
<?php } ?>