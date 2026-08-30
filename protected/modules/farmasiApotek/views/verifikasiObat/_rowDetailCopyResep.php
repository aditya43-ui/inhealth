<tr>
    <?php //print_r($modObatAlkesPasien);exit(); ?>
    
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>        
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]r',array('readonly'=>true,'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]obatalkespasien_id',array('onkeyup'=>"return $(this).focusNextInputField(event);")) ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][obatalkes_kode]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->obatalkes_kode : "") ?></span> /<br>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->obatalkes_nama : "") ?></span>
        
    </td>
    <td hidden>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][satuankecil_nama]"><?php echo (!empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]qty_oa',array('readonly'=>true,'style'=>'width:50px;','onblur'=>'hitungSubTotal(this)')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;','class'=>'integer2')); ?>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]signa_oa',array('readonly'=>false,'style'=>'width:110px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]etiket', LookupM::getItems('etiket'),array('class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]permintaan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]kekuatan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jmlkemasan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]harganetto_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargasatuan_oa',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer2','onblur'=>'hitungSubTotal(this)')); ?>
        
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayaservice'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakonseling'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jasadokterresep'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakemasan'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayaadministrasi'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]tarifcyto'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidiasuransi'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidipemerintah'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidirs'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]iurbiaya'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]stokobatalkes_id'); ?>
    </td>       
    <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]discount',array('style'=>'width:50px;', 'onblur'=>'hitungSubTotal(this)', 'class'=>'integer2')); ?>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargajual_oa',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer2')); ?>
    </td>
    
    
    	<?php if(!empty($modObatAlkesPasien->obatalkespasien_id)){
    echo
    '<td>'.'<a onclick="hapusObatAlkesPasienDetail('.$modObatAlkesPasien->obatalkespasien_id.');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus penjualan obat alkes ini"><i class="icon-trash"></i></a></td>'.''; 
    }else{
       echo
    '<td>'.'<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-remove"></i></a></td>'.'';  
    }
    
    
    ?>
    
</tr>