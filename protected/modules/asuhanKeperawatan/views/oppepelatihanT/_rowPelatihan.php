<tr>
    <td style="text-align: center;">
        <?php echo CHtml::hiddenField("noUrut", $i, array('readonly' => true, 'class' => 'nourut span1')); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]bulan_pelatihan', array('class' => 'span1 bulan_pencatatan required', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]oppepelatihan_id', array('class' => 'span2', 'readonly' => true)); ?>	        	
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[ii]pegawai_id', array('class' => 'span2 pegawai_id', 'readonly' => true)); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]nama_perawat', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nip_perawat', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[ii]perawat_unitkerja_id', array('class' => 'span2', 'readonly' => true)); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]namaunitkerja', array('class' => 'span3', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nama_pelatihan', array('class' => 'span2', 'readonly' => false)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]no_sertifikat', array('class' => 'span2', 'readonly' => false)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]penyelenggara', array('class' => 'span2', 'readonly' => false)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]jml_skp', array('class' => 'span1 jumlah_skp', 'onblur' => 'hitungSKP()' ,'readonly' => false)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]skor', array('class' => 'span1 skor', 'readonly' => true)); ?>	
    </td>
    <td style="text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="fa fa-minus"></i>', 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => 'hapusTemporaryPelatihan(this)')); ?>
    </td>
</tr>