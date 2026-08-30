<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 float', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]pendaftaran_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]pasien_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]pegawai_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]penjamin_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]carabayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]kelaspelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]obatalkespasien_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]satuankecil_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]stokobatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modObatAlkesPasien->obatalkes_id) ? $modObatAlkesPasien->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][satuankecil_nama]"><?php echo (!empty($modObatAlkesPasien->satuankecil_id) ? $modObatAlkesPasien->satuankecil->satuankecil_nama : "") ?></span>
    </td>
    <!--RND-3097   <td>
        <?php // echo CHtml::activeHiddenField($modObatAlkesPasien,'[ii]harganetto_oa',array('readonly'=>true,'class'=>'span2 float')); ?>
        <?php // echo CHtml::activeTextField($modObatAlkesPasien,'[ii]hargajual_oa',array('readonly'=>true,'class'=>'span2 float','style'=>'width:90px;')); ?>
    </td>-->
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien,'[ii]qty_stok',array('readonly'=>true,'class'=>'span1 float', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien,'[ii]qty_oa',array('class'=>'span1 float', 'onblur'=>'hitungSubTotal(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
    </td>
<!--RND-3097  <td>
        <?php // echo CHtml::activeTextField($modObatAlkesPasien,'[ii]iurbiaya',array('readonly'=>true,'class'=>'span2 float','style'=>'width:90px;')); ?>
    </td>-->
    <td>
        <a onclick="batalOaPasien(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Obat / Alat Kesehatan"><i class="icon-form-silang"></i></a>
    </td>
</tr>
</tr>