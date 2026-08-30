<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]maksimalstok',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span1')); ?>                
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]persenpph',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]on_order',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]x_ratapemakaian',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]stokonhand',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]kategori_abc',array('readonly'=>true,'class'=>'span2','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]persen_abc',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
		<?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span2','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]supplier_id',array('readonly'=>true,'class'=>'span2','style'=>'width:90px;')); ?>
    </td>
    <td>
        <?php 
        $modSupplier = SupplierM::model()->findByPk($modRencanaDetailKeb->supplier_id);
        if (!empty($modSupplier)){
            echo $modSupplier->supplier_nama;
        } else{
            echo "-";
        }
         ?>
    </td>
    <td>
        <?php echo empty($modRencanaDetailKeb->obatalkes->jenisobatalkes_id)?"-":$modRencanaDetailKeb->obatalkes->jenisobatalkes->jenisobatalkes_nama; ?>
    </td>
    
    <td hidden>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modRencanaDetailKeb->sumberdana_id) ? $modRencanaDetailKeb->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modRencanaDetailKeb->obatalkes_id) ? $modRencanaDetailKeb->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($modRencanaDetailKeb->obatalkes->tglkadaluarsa); ?>
    </td>
    <td>
        <?php 
		echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]jmlharusorder',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')); 
		echo " ".$modRencanaDetailKeb->obatalkes->satuankecil->satuankecil_nama;
		?>
    </td>
    <td hidden>
        <?php 
		echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]maksimalstok',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')); 
		echo " ".$modRencanaDetailKeb->obatalkes->satuankecil->satuankecil_nama;
		?>
    </td>
    <td>
        <?php 
                echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]stok_awal',array('value'=>$modRencanaDetailKeb->stokakhir,'readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')); 
		echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]stokakhir',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')); 
		echo " ".$modRencanaDetailKeb->obatalkes->satuankecil->satuankecil_nama;
		?>
    </td>
    <td>
        <?php 
		echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]jmlpermintaan',array('readonly'=>false,'class'=>'span1 integer-decimal','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); 
		?>
    </td>
    <!-- Form yang lamar -->
    <!-- <td>
        <?php 
                //echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]stok_akhirtot',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')); 
		//echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]stokakhir',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')); 
		//echo " ".$modRencanaDetailKeb->obatalkes->satuankecil->satuankecil_nama;
		?>
    </td>
    <td>
        <?php //echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]jmlpermintaanlama',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        <?php //echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]satuanobat',array()); ?>
        <?php //echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuanobat_nama', LookupM::getItems('satuanobat'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;', 'disabled'=>true, 'class'=>'satuanobat')); ?><br>
        <div class="satuankecil">
        <?php// echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]satuankecil_id',array()); ?>
            <?php// echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuankecil_nama', CHtml::listData(SatuankecilM::model()->findAll('satuankecil_aktif = true'),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;', 'disabled'=>true)); ?>
        </div>
        <div class="satuanbesar" style="display:none;">
        <?php// echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]satuanbesar_id',array()); ?>
            <?php// echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuanbesar_nama', CHtml::listData(SatuanbesarM::model()->findAll('satuanbesar_aktif = true'),'satuanbesar_id','satuanbesar_nama'),array('style'=>'width:80px;', 'disabled'=>true)); ?>
            <?php// echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span1 integer2','style'=>'width:90px;')); ?>
        </div>
    </td>
    <td>
		<?php// echo CHtml::activeHiddenField($modRencanaDetailKeb, '[ii]satuankecil_id'); ?>
        <?php //echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modRencanaDetailKeb,'[ii]harganettorenc',array('readonly'=>false,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modRencanaDetailKeb,'[ii]harganettorenc',array('readonly'=>false,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td> -->
    <td>
        <?php 
            echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]stok_akhirtot',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')); 
            echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]stokakhir',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:45px;')); 
		    echo " ".$modRencanaDetailKeb->obatalkes->satuankecil->satuankecil_nama;
		?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]jmlpermintaanlama',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]satuanobat',array()); ?>
        <?php echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuanobat', LookupM::getItems('satuanobat'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>
        <div class="satuankecil">
            <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]satuankecil_id',array()); ?>
            <?php echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll('satuankecil_aktif = true'),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;', 'disabled'=>true)); ?>
        </div>
        <div class="satuanbesar" style="display:none;">
            <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]satuanbesar_id',array()); ?>
            <?php echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll('satuanbesar_aktif = true'),'satuanbesar_id','satuanbesar_nama'),array('style'=>'width:80px;', 'disabled'=>true)); ?>
            <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:90px;')); ?>
        </div>
    </td>
    <td>
		<?php echo CHtml::activeHiddenField($modRencanaDetailKeb, '[ii]satuankecil_id'); ?>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modRencanaDetailKeb,'[ii]harganettorenc',array('readonly'=>false,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modRencanaDetailKeb,'[ii]harganettorenc',array('readonly'=>false,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]buffer_stok',array('readonly'=>false,'class'=>'span2 integer2','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]persenppn',array('readonly'=>false,'class'=>'span1 integer2','onblur'=>'hitungTotal();','style'=>'width:50px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modRencanaDetailKeb,'[ii]ppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modRencanaDetailKeb,'[ii]ppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modRencanaDetailKeb,'[ii]hpp',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modRencanaDetailKeb,'[ii]hpp',array('readonly'=>true,'class'=>'span2  integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modRencanaDetailKeb,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;')):CHtml::activePasswordField($modRencanaDetailKeb,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;')); ?>
    </td>
	<td><?php echo isset($modRencanaDetailKeb->jenis_material) ? $modRencanaDetailKeb->jenis_material : "-"; ?></td>
	<td><?php echo isset($modRencanaDetailKeb->kategori_abc) ? $modRencanaDetailKeb->kategori_abc : "-"; ?></td>
    <td>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>