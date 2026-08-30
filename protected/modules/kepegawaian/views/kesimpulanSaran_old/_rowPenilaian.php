<?php foreach ($penilaianpegawai as $i=>$detail):?>
<tr>
    <td>
        <?//php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activehiddenField($detail,'['.$i.']pegawai_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($detail,'['.$i.']penilainip',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($detail,'['.$i.']penilainama',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($detail,'['.$i.']keterangan_score',array('readonly'=>true,'class'=>'span1')); ?>
        <?php  echo CHtml::activehiddenField($detail,'['.$i.']jumlahpenilaian',array('readonly'=>true,'class'=>'span1','value'=>  empty($detail->jumlahpenilaian) ? 0 :$detail->jumlahpenilaian)); ?>
        <span><?php echo (!empty($detail->penilainip) ? $detail->penilainip : "") ?></span>
    </td>  
	<td>
        <span><?php echo (!empty($detail->penilainama) ? $detail->penilainama : "") ?></span>
    </td>
	<td>
        <span><?php echo (!empty($detail->tglpenilaian) ? $detail->tglpenilaian : "") ?></span>
    </td>      
    <td>
        <span><?php echo (!empty($detail->keterangan_score) ? $detail->keterangan_score : "") ?></span>
    </td>
    <td>
        <span><?php echo (!empty($detail->jumlahpenilaian) ? $detail->jumlahpenilaian : "") ?></span>
    </td>	
</tr>
<?php endforeach;?>
