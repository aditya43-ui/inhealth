<tr>
    <td style="text-align: center;">
        <?php echo CHtml::textField("noUrut", $i, array('readonly' => true, 'class' => 'nourut span1')); ?>		
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::activeTextField($model, '[ii]nomorbarcode_utama', array('class' => 'span3 nomorbarcode_utama required', 'readonly' => true)); ?>
        <?php echo CHtml::activeTextField($model, '[ii]daftardonasi_id', array('class' => 'span3 daftardonasi_id required', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]penggunaan_coolbox_id', array('class' => 'span3', 'readonly' => true)); ?>	
        <?php echo CHtml::activeHiddenField($model, '[ii]nomorbarcod_sample', array('class' => 'span2', 'readonly' => true)); ?>	        
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]jeniskantong', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]no_kantongpabrik', ['class' => 'span2', 'readonly' => true]) ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]volume_kantong', array('class' => 'span1', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]gol_darah', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]rhesus', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]ada_samplekonfirmasi', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]ada_sampleitd', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]ada_kantongdarah', array('class' => 'span2', 'readonly' => true)); ?>	
    </td>
    <td style="text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="' . MyIcon::getIcons('batal') . '"></i>', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => 'hapusTemporaryKantong(this)')); ?>
    </td>
</tr>