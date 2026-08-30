<?php foreach ($modTindakans as $i => $modTindakan) { ?>
<tr>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]kategoriTindakanNama", array('readonly'=>true,'class'=>'inputFormTabel')) ?></td>
    <td><?php echo CHtml::activeHiddenField($modTindakan, "[$i]daftartindakan_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeTextField($modTindakan, "[$i]daftartindakanNama", array('readonly'=>true)) ?>
        <?php 
//        $this->widget('MyJuiAutoComplete',array(
//                    'name'=>"daftartindakan[$i]",
//                    'value'=>'',
//                    'sourceUrl'=> Yii::app()->createUrl('pemulasaranJenazah/TindakanPelayanan/DaftarTindakan'),
//                    'options'=>array(
//                       'showAnim'=>'fold',
//                       'minLength' => 2,
//                       'focus'=> 'js:function( event, ui ) {
//                            $(this).val( ui.item.label);
//                            return false;
//                        }',
//                       'select'=>'js:function( event, ui ) {
//                            setTindakan($(this), ui.item);
//                            return false;
//                        }',
//
//                    ),
//                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel','style'=>'width:120px;'),
//        )); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan, "[$i]tarif_satuan", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]subsidiasuransi_tindakan", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]subsidipemerintah_tindakan", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]subsisidirumahsakit_tindakan", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]iurbiaya_tindakan", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]qty_tindakan", array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel number lebar1')) ?></td>
    <td><?php echo CHtml::activeDropDownList($modTindakan, "[$i]satuantindakan", LookupM::getItems('satuantindakan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel')) ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]persenCyto", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeDropDownList($modTindakan, "[$i]cyto_tindakan", array('0'=>'Tidak','1'=>'Ya'),array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel number lebar2-5')) ?>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]tarifcyto_tindakan", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?></td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]jumlahTarif", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?></td>
    <td rowspan="2">
        &nbsp;
    </td>
</tr>
<tr>
    <td><div class="input-append"><?php echo CHtml::activeTextField($modTindakan, '[0]tgl_tindakan', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;','value'=>date('Y-m-d H:i:s'))); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div></td>
    <td style="text-align: right;"><b>Pemeriksa :</b></td>
    <td colspan="6">&nbsp;
            <?php echo CHtml::link("<i class='icon-plus-sign'></i>", '#', array('id'=>"btnAddDokter_$i",'onclick'=>'addDokter(this);return false;')); ?>
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
