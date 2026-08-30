<tr>
    <td class="nomor"><?php echo $cnt; ?></td>
    <td><?php 
    echo CHtml::hiddenField('detail[i][jeniskomponendarah_id]', $item->jeniskomponendarah_id, array(
        'class'=>'jeniskomponendarah_id'
    ));
    echo CHtml::hiddenField('detail[i][penerimaandarahpmidet_id]', $item->penerimaandarahpmidet_id, array(
        'class'=>'penerimaandarahpmidet_id'
    ));
    echo CHtml::hiddenField('detail[i][golongandarah]', $item->golongandarah, array(
        'class'=>'golongandarah'
    ));
    echo CHtml::hiddenField('detail[i][rhesus]', CustomFunction::cekNamaRhesus($item->rhesus), array(
        'class'=>'rhesus'
    ));
    echo CHtml::hiddenField('detail[i][jumlah_permintaan]', $item->jumlah, array(
        'class'=>'jumlah_permintaan'
    ));
    
    echo '<span class="jeniskantongdarah_singkatan">'.$jenis->jeniskantongdarah_singkatan.'</span>'; ?></td>
    <td class="golongandarah_label"><?php echo $item->golongandarah; ?></td>
    <td class="rhesus_label"><?php echo CustomFunction::cekNamaRhesus($item->rhesus); ?></td>
    <td style="text-align: right;"  class="jumlah_permintaan_label"><?php echo $item->jumlah; ?></td>
    <td style="text-align: right;" ><?php echo CHtml::textField('detail[i][jumlah_terima]', $item->jumlah, array(
        'class'=>'jumlah_terima integer2 span1',
        'onblur'=>'$("#PenerimaandarahpmiT_keterangan_penerimaan").blur();hitungTotal();',
    )); ?></td>
    <td><?php echo CHtml::textArea('detail[i][keterangan_det]', $item->keterangan_det, array(
        'class'=>'keterangan_det span3',
        'rows'=>2,
    )); ?></td>
    <td style="text-align: center">
        <?php echo CHtml::link('<span style="font-size:25px;color:red;"><i class="entypo entypo-cancel"></i></span>', 'javascript:;', array(
            'width'=>'25px',
            'height'=>'25px',
            'onclick'=>'$(this).parents("tr").remove();'
        )); ?>
    </td>
</tr>
