
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]barang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]harga_barangdet',array('readonly'=>true,'class'=>'span1')); ?>
        <?php // echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]minstok_barangdet',array('readonly'=>true,'class'=>'span1')); ?>                
        <?php // echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]makstok_barangdet',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        <?php // echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]stokakhir_barangdet',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang,'[ii]hpp',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKebBarang, '[ii]satuanbarangdet', LookupM::getItems('satuanbarang'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?>
    </td>
    <td>
        <?php echo $modRencanaDetailKebBarang->barang->barang_type ?>
    </td>
    <td>
        <?php echo $modRencanaDetailKebBarang->barang->barang_kode ?>
    </td>
    <!--<td>
        <span><?php //echo (!empty($modRencanaDetailKebBarang->asal_barang) ? $modRencanaDetailKebBarang->asal_barang : "") ?></span> 
	</td>-->
    <td>
            <span><?php echo (!empty($modRencanaDetailKebBarang->barang->barang_nama) ? $modRencanaDetailKebBarang->barang->barang_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]stokakhir_barangdet',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')).' '.$modRencanaDetailKebBarang->barang->barang_satuan; ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]minstok_barangdet',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')).' '.$modRencanaDetailKebBarang->barang->barang_satuan; ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]makstok_barangdet',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')).' '.$modRencanaDetailKebBarang->barang->barang_satuan; ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]jmlpermintaanbarangdet',array('readonly'=>false,'class'=>'span1 integer-decimal','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")).' '.$modRencanaDetailKebBarang->barang->barang_satuan; ?>
    </td>
   <!-- <td>
        <?php //echo CHtml::activeTextField($modRencanaDetailKebBarang, '[ii]satuanbarangdet', LookupM::getItems('satuanbarang'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>     
    </td>-->
    
    <td>
        <?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]harga_barang',array('readonly'=>false,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modRencanaDetailKebBarang,'[ii]harga_barang',array('readonly'=>false,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]persen_ppn',array('readonly'=>false,'class'=>'span1 integer2','onblur'=>'hitungTotal();','style'=>'width:50px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modRencanaDetailKebBarang,'[ii]persen_ppn',array('readonly'=>false,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:50px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]ppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modRencanaDetailKebBarang,'[ii]ppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
<!--    <td>
        <?php // echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]hpp',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modRencanaDetailKebBarang,'[ii]hpp',array('readonly'=>true,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>-->
    
    
    <td>
        <?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modRencanaDetailKebBarang,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;')):CHtml::activePasswordField($modRencanaDetailKebBarang,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;')); ?>
    </td>
	<td>
        <a onclick="batalBarang(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
<?php //$this->renderPartial($this->path_view.'_jsFunctions', array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modRencanaDetailKeb'=>$modRencanaDetailKebBarang)); ?>