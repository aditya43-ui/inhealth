<?php foreach ($modTindakans as $i => $modTindakan) { ?>
<tr>
    <td rowspan="2">&nbsp;</td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]kategoriTindakanNama", array('readonly'=>true,'class'=>'inputFormTabel')) ?></td>
    <td><?php echo CHtml::activeHiddenField($modTindakan, "[$i]daftartindakan_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeTextField($modTindakan, "[$i]daftartindakanNama", array('readonly'=>true)) ?>
        <?php 
//        $this->widget('MyJuiAutoComplete',array(
//                    'name'=>"daftartindakan[$i]",
//                    'value'=>'',
//                    'sourceUrl'=> Yii::app()->createUrl('rawatJalan/tindakan/DaftarTindakan'),
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
    <td hidden>
        <?php echo CHtml::activeTextField($modTindakan, "[$i]tarif_satuan", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]subsidiasuransi_tindakan", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]subsidipemerintah_tindakan", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]subsisidirumahsakit_tindakan", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]iurbiaya_tindakan", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]ruangan_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, "[$i]qty_tindakan", array('readonly'=>true, 'onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel integer span1')) ?></td>
    <td><?php echo CHtml::activeDropDownList($modTindakan, "[$i]satuantindakan", LookupM::getItems('satuantindakan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span2')) ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan, "[$i]persenCyto", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeDropDownList($modTindakan, "[$i]cyto_tindakan", array('0'=>'Tidak','1'=>'Ya'),array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span2')) ?>
    </td>
    <td hidden><?php echo CHtml::activeTextField($modTindakan, "[$i]tarifcyto_tindakan", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?></td>
    <td hidden><?php echo CHtml::activeTextField($modTindakan, "[$i]jumlahTarif", array('readonly'=>true,'class'=>'inputFormTabel integer')) ?></td>
</tr>
<tr>
    <td><div class="input-append"><?php echo CHtml::activeTextField($modTindakan, '['.$i.']tgl_tindakan', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;','value'=>MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')))); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div></td>
    <td style="text-align: right;"><b>Pemeriksa :</b></td>
    <td colspan="6">
        <table style="margin:0;">
          <tr>
            <td width="20px" style="background-color:transparent;border: 0;">
                <?php echo CHtml::hiddenField('row', $i, array('readonly'=>true, 'class'=>'span1')); ?>
                <?php echo CHtml::link("<i class='icon-plus-sign' title='Klik untuk merubah dokter / perawat / bidan'></i>", '#', array('id'=>'btnAddDokter_'.$i, 'onclick'=>'addDokterLengkap(this);return false;')); ?>
            </td>
            <td style="background-color:transparent;border: 0;" width="250px"><div id="tampilanDokterPemeriksa_<?php echo $i; ?>"><?php echo (empty($modTindakan->dokterpemeriksa1_id)) ? "" : "Dokter Pemeriksa : ".$modTindakan->dokterpemeriksa1Nama ?></div></td>
            <td style="background-color:transparent; border: 0;"><?php echo CHtml::activeTextField($modTindakan, '['.$i.']keterangantindakan', array('readonly'=>false,'class'=>'inputFormTabel span3','placeholder'=>'Keterangan Tindakan')) ?></td> 
          </tr>
          <tr>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="tampilanDokterDelegasi_<?php echo $i; ?>"></div></td>
          </tr>
          <tr>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanPerawat_<?php echo $i; ?>"></div></td>
          </tr>
          <tr>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanPerawat2_<?php echo $i; ?>"></div></td>
          </tr>
          <tr>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanBidan_<?php echo $i; ?>"></div></td>
          </tr>
          <tr>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanSuster_<?php echo $i; ?>"></div></td>
          </tr>
        </table>
            <?php // echo CHtml::link("<i class='icon-plus-sign'></i>", '#', array('id'=>"btnAddDokter_$i",'onclick'=>'addDokter(this);return false;')); ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokterpemeriksa1_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokterpemeriksa2_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokterpendamping_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokteranastesi_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]dokterdelegasi_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]bidan_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]suster_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]perawat_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, "[$i]perawat2_id", array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td>
</tr> 
<?php } ?>
