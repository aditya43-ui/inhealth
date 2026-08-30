<tr data-id="<?php echo $kantong->kantongdarah_id; ?>">
    <td class="html_no" >1</td>
    <td>
        <?php echo $jenis->nama_jenis; ?>
    </td>
    <td>
        <?php echo $kantong->nomorbarcode_utama; ?>
    </td>
    <td>
        <?php echo CHtml::textField('detail[ii][no_kantongpabrik]', $kantong->no_kantongpabrik, ['class' => 'no_kantongpabrik', 'onkeyup' => 'clearborder();']) ?>
    </td>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($kantong->tglpencatatan); ?>
    </td>
    <td>
        <?php echo $kantong->petugaspencatat->namaLengkap; ?>
    </td>    
    <td>
        <?php
        
        echo CHtml::hiddenField('detail[ii][komponendarah_id]', $kantong->komponendarah_id);
        echo CHtml::hiddenField('detail[ii][kantongdarah_id]', $kantong->kantongdarah_id,array('class'=>'det_kantongdarah_id'));
        echo CHtml::hiddenField('detail[ii][jeniskantongdarah_id]', $kantong->jeniskantongdarah_id);
        echo CHtml::hiddenField('detail[ii][golongan_darah]', $pendonor->gol_darah);
        echo CHtml::hiddenField('detail[ii][rhesus]', $pendonor->rhesus);
        echo CHtml::hiddenField('detail[ii][nomorbarcode]', $kantong->nomorbarcode_utama, array('class' => 'nomorbarcode'));
        
        echo CHtml::link('<span style="font-size:30px;color:red;"><i class="entypo-cancel"></i></span>', 'javascript:;', array(
            'onclick'=>'hapusKantong(this);'
        ));
        ?>
    </td>
</tr>