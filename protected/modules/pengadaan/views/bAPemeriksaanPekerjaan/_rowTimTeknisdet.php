<tr data-row="<?php echo $i ?>">
    <td>
        <?php echo CHtml::textField('no_urut', '1', array('readonly' => true, 'class' => 'span1 integer', 'style' => 'width:20px;')); ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modPegawai, '[0]pegtimteknis_id'); ?>
        <?php echo CHtml::activeHiddenField($modPegawai, '[0]pegawai_id', array('class' => 'pegawai_id')); ?>
        <?php echo CHtml::activeTextField($modPegawai, '[0]nama_pegawai',array('readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPegawai, '[0]nomorindukpegawai', array('readonly' => true, 'class' => 'span3 nip')); ?>
    </td>
    <td><?php echo CHtml::activeTextField($modPegawai, '[0]jabatan_timteknis', array('class' => 'span3 required jabatan', 'placeholder' => 'Ketikkan Jabatan', 'readonly'=>true)); ?> 
        <?php echo CHtml::activeHiddenField($modPegawai, '[0]status', array('class' => 'status', 'readonly' => true)); ?></td>
</tr>