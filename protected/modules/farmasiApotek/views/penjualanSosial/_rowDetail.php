<tr>
    <?php //print_r($modObatAlkesPasien);exit(); ?>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]r',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <span id="isi-r" name="[ii][isi_r]">R/</span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]permohonanoadetail_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][obatalkes_kode]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->obatalkes_kode : "") ?></span>/<br>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->obatalkes_nama : "") ?></span>
        
    </td>
    <td>
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
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;')); ?>
<!--<td>
    </td>-->
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]permintaan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]kekuatan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jmlkemasan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]harganetto_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargasatuan_oa',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer','onblur'=>'hitungSubTotal(this)')); ?>
        
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayaservice'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakonseling'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jasadokterresep'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakemasan'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayaadministrasi'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]tarifcyto'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidiasuransi'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidipemerintah'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]iurbiaya'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]stokobatalkes_id'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]discount',array('style'=>'width:50px;', 'onblur'=>'hitungSubTotal(this)', 'class'=>'integer')); ?>
    </td>
    <td>
    	<?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]signa_oa', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]etiket', LookupM::getItems('etiket'),array('class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]subtotal',array('readonly'=>true,'style'=>'width:110px;','class'=>'integer')); ?>
    </td>
    <td>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]subsidirs',array('readonly'=>false,'style'=>'width:110px;', 'class'=>'integer','onblur'=>'hitungIurBiaya(this)',)); ?>
    </td>
    <td>
    	<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>