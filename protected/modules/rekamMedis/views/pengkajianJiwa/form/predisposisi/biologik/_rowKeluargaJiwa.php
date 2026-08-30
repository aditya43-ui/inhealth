<tr>
    <td>
        <span class="nomor"><?php echo $no; ?></span>
        <?php echo CHtml::activeHiddenField($mod, '['.$i.']hubungankeluarga', array('class'=>'hubungankeluarga')); ?>
        <?php echo CHtml::activeHiddenField($mod, '['.$i.']gejala', array('class'=>'gejala')); ?>
        <?php echo CHtml::activeHiddenField($mod, '['.$i.']riwayatpengobatan', array('class'=>'riwayatpengobatan')); ?>
    </td>
    <td>
        <?php echo $mod->hubungankeluarga; ?>
    </td>
    <td>
        <?php echo $mod->gejala; ?>
        
    </td>
    <td>
        <?php echo $mod->riwayatpengobatan; ?>
        
    </td>
    <td><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'hapusKeluargaJiwa(this); return false;')); ?></td>
    
    
</tr>