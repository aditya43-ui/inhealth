<tr>
    <td style="text-align: center;">
        <?php echo CHtml::hiddenField("noUrut", $i, array('readonly' => true, 'class' => 'nourut span1')); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]bulan_bimbingan', array('class' => 'span2 bulan_bimbingan required', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]oppebimbingan_id', array('class' => 'span2', 'readonly' => true)); ?>	        	
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[ii]pegawai_id', array('class' => 'span2 pegawai_id', 'readonly' => true)); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]nama_perawat', array('class' => 'span3', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nip_perawat', array('class' => 'span3', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[ii]perawat_unitkerja_id', array('class' => 'span2', 'readonly' => true)); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]namaunitkerja', array('class' => 'span3', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]institusi', array('class' => 'span2', 'readonly' => false)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]jml_bimbingan', array('class' => 'span1 jml_bimbingan', 'readonly' => false, 'onblur' => 'hitungBimbingan()')); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]skor', array('class' => 'span1 skor', 'readonly' => true)); ?>	
    </td>
    <td style="text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="fa fa-minus"></i>', 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => 'hapusTemporaryBimbingan(this)')); ?>
    </td>
</tr>