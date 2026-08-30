
<tr>
    <td>
        <?php 
        $bahan = BahanmakananM::model()->findByPk($modRencanaDetailKebBarang->bahanmakanan_id);
        $gol_nama = "";
        if (!empty($bahan->golbahanmakanan_id)) {
            $gol = GolbahanmakananM::model()->findByPk($bahan->golbahanmakanan_id);
            if (!empty($gol)) {
                $gol_nama = $gol->golbahanmakanan_nama;
            }
        }
        
        echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]bahanmakanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php //echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]harga_barangdet',array('readonly'=>true,'class'=>'span1')); ?>
        <?php //echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]minstok_bahanmakanan',array('readonly'=>true,'class'=>'span1')); ?>                
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]makstok_bahanmakanan',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        <?php //echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]stokakhir_bahanmakanan',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>		
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang, '[ii]satuanbahan', LookupM::getItems('satuanbarang'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?>
    </td>
    <td>
        <?php echo $gol_nama ?>
    </td>
    <td>
        <?php echo $bahan->jenisbahanmakanan ?>
    </td>
    <td>
        <?php echo $bahan->kelbahanmakanan ?>
    </td>
    <!--<td>
        <span><?php //echo (!empty($modRencanaDetailKebBarang->asal_barang) ? $modRencanaDetailKebBarang->asal_barang : "") ?></span> 
	</td>-->
    <td>
            <span><?php echo (!empty($modRencanaDetailKebBarang->namabahanmakanan) ? $modRencanaDetailKebBarang->namabahanmakanan : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]stokakhir_bahanmakanan',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;')).' '.$bahan->satuanbahan; ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]minstok_bahanmakanan',array('readonly'=>false,'class'=>'span2 integer2','style'=>'width:45px;', 'readonly'=>true)).' '.$bahan->satuanbahan; ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]jmlpermintaandet',array('readonly'=>false,'class'=>'span2 integer-decimal','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")).' '.$modRencanaDetailKebBarang->satuanbahan; ?>
    </td>
   <!--<td>
        <?php //echo CHtml::activeTextField($modRencanaDetailKebBarang, '[ii]satuanbarangdet', LookupM::getItems('satuanbarang'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>     
    </td>-->
    <td>
        <?php echo  CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]harga_barangdet',array('readonly'=>false,'class'=>'span1 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px; text-align:right;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
      <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]persen_ppn',array('class'=>'span2 integer2','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
      <td>
        <?php echo  CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]jml_ppn',array('readonly'=>true,'class'=>'span3 integer-decimal','style'=>'width:90px;','onblur'=>'hitungTotal();','style'=>'width:90px;text-align:right;','onkeyup'=>"return $(this).focusNextInputField(event);"));?>
    </td>
    <td>
        <?php echo  CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;text-align:right;')); ?>
    </td>
	<td>
        <a onclick="batalBarang(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
<?php //$this->renderPartial($this->path_view.'_jsFunctions', array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modRencanaDetailKeb'=>$modRencanaDetailKebBarang)); ?>