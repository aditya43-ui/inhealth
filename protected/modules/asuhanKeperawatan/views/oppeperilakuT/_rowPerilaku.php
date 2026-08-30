<tr>
    <td style="text-align: center;">
        <?php echo CHtml::hiddenField("noUrut", $i, array('readonly' => true, 'class' => 'nourut span1')); ?>	
        <?php echo CHtml::activeTextField($model, '[ii]bulan_pencatatan', array('class' => 'span2 bulan_pencatatan required', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]oppeperilaku_id', array('class' => 'span2', 'readonly' => true)); ?>	        	
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
        <?php echo CHtml::activeTextField($model, '[ii]nilai_sejawat', array('class' => 'span1 float2 nilai_sejawat', 'readonly' => false, 'style' => 'width: 80px;', 'onblur' => 'hitungNilai()')); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nilai_pasien', array('class' => 'span1 float2 nilai_pasien', 'style' => 'width: 80px;', 'onblur' => 'hitungNilai()')); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nilai_keluarga', array('class' => 'span1 float2 nilai_keluarga', 'style' => 'width: 80px;', 'onblur' => 'hitungNilai()')); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nilai_dokter', array('class' => 'span1 float2 nilai_dokter', 'readonly' => false, 'style' => 'width: 80px;', 'onblur' => 'hitungNilai()')); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]nilai_rata', array('class' => 'span1 nilai_rata', 'readonly' => true)); ?>	
    </td>
    <td style="text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="fa fa-minus"></i>', 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => 'hapusTemporaryPerilaku(this)')); ?>
    </td>
</tr>