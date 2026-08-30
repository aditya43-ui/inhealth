<?php
$i = !empty($i)?$i:0;
?>
<tr class="baris">
    <td>
        <?= CHtml::activeHiddenField($model, "[".$i."]riwayatobatsebelumnya_id", array('class'=>'det_id')); ?>	
        <?= CHtml::activeTextField($model, "[".$i."]nama_obat", array('class'=>'span3')); ?>	
    </td>
    <td>    
        <?= CHtml::activeTextField($model, "[".$i."]dosis_obat", array('class'=>'span2')); ?>	
    </td>
    <td>    
        <?= CHtml::activeTextField($model, "[".$i."]carapemberian", array('class'=>'span4')); ?>	
    </td>
    <td>
         <?php
           
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => "[".$i."]tglpemberian",
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true,
                    'class' => 'span3 tanggal',
                    'style' => 'float:left',)
            ));
        ?>  
	
    </td>
    <td>        
        <a onclick="hapus_data_baris(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat"><i class="icon-remove"></i></a>
    </td>
</tr>