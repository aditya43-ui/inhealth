<?php
    $i = isset($i)?$i:'ii';
?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',$i,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php echo Chtml::activeHiddenField($modDetail, '['.$i.']paketobatdetail_id',array('class'=>'paketobatdetail_id'));?>
        <?php echo Chtml::activeHiddenField($modDetail, '['.$i.']obatalkes_id',array('class'=>'obatalkes_id'));?>
        <?php echo Chtml::activeTextField($modDetail, '['.$i.']obatalkes_nama',array('class'=>'span3','readonly'=>true));?>
    </td>
    <td>        
        <?php echo Chtml::activeTextField($modDetail, '['.$i.']jumlah',array('readonly'=>false,'class'=>'span2 jumlah float2 required'));?>        
    </td>
    <td>
        <?php echo Chtml::activeDropDownList($modDetail, '['.$i.']satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(" satuankecil_aktif = TRUE ORDER BY satuankecil_nama ASC "), 'satuankecil_id', 'satuankecil_nama'),array('class'=>'span3'));?>
    </td>
    <td>
    	<a onclick="hapusObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus pegawai"><i class="entypo-trash"></i></a>
    </td>
</tr>