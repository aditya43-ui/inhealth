<tr>
    <td style="text-align: center;">
        <?php echo CHtml::hiddenField("noUrut", $i, array('readonly' => true, 'class' => 'nourut span1')); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]bulan_caring', array('style' => 'width:80px;', 'class' => 'bulan_caring required', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]oppecaring_id', array('class' => 'span2', 'readonly' => true)); ?>	        	
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[ii]pegawai_id', array('class' => 'span2 pegawai_id', 'readonly' => true)); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]nama_perawat', array('class' => 'span3', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nip_perawat', array('style' => 'width:100px;', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[ii]perawat_unitkerja_id', array('class' => 'span2', 'readonly' => true)); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]namaunitkerja', array('class' => 'span3', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]tgl_kuisioner', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nilai_pasien', array('style' => 'width: 80px;','class' => 'span1 float2 nilai_pasien', 'onblur' => 'hitungNilaiRow();', 'readonly' => false)); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nilai_keluarga', array('style' => 'width: 80px;', 'class' => 'span1 float2 nilai_keluarga', 'onblur' => 'hitungNilaiRow();', 'readonly' => false)); ?> 
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nilai_rata', array('class' => 'span1 float2 nilai_rata', 'readonly' => true, 'style' => 'width: 80px;')); ?> 
    </td>
    <td style="text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="fa fa-minus"></i>', 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => 'hapusBaris(this)')); ?>
    </td>
</tr>