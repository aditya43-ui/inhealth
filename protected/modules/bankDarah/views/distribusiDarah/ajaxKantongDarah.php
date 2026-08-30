<tr data-id="<?php echo $kantong->kantongdarah_id; ?>">
    <td class="html_no" style="text-align: right;"></td>
    <td>
        <?php echo $kantong->no_kantongdarah; ?>
    </td>
    <td>
        <?php echo $komponen->singkatan_komp; ?>
    </td>
    <td>
        <?php echo $jenis->nama_jenis; ?>
    </td>
    <td>
        <?php echo $kantong->gol_darah; ?>
    </td>
    <td>
        <?php echo $kantong->rhesus; ?>
    </td>
    <td>
        <?php
        
        echo CHtml::hiddenField('detail['.$kantong->kantongdarah_id.'][komponendarah_id]', $kantong->komponendarah_id);
        echo CHtml::hiddenField('detail['.$kantong->kantongdarah_id.'][jeniskantongdarah_id]', $kantong->jeniskantongdarah_id);
        echo CHtml::hiddenField('detail['.$kantong->kantongdarah_id.'][golongan_darah]', $kantong->gol_darah);
        echo CHtml::hiddenField('detail['.$kantong->kantongdarah_id.'][rhesus]', $kantong->rhesus);
        echo CHtml::hiddenField('detail['.$kantong->kantongdarah_id.'][nomorbarcode]', $kantong->no_kantongdarah, array('class' => 'nomorbarcode'));
        
        echo CHtml::link('<i class="entypo-cancel"></i>', '#', array(
            'onclick'=>'hapusKantong(this);'
        ));
        ?>
    </td>
</tr>