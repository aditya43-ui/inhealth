<?php 

$model = new OrderbatalalokasiT;

$cnt = 1;
foreach ($arr_alokasi as $idx => $item): 
    $data = $item['row'];
?>

<tr>
    <td><?php echo $cnt++; ?></td>
    <td>
        <?php echo CHtml::activeCheckBox($model, '['.$data->tglpembayaran.']ceklis'); ?>
    </td>
    <td><?php echo MyFormatter::formatDateTimeForUser($data->tglpembayaran); ?></td>
    <td style="text-align: center;">
        <?php
        
        foreach ($item['det'] as $item2) {
            
            $id = $item2->alokasidana_id;
            $penjamin = PenjaminpasienM::model()->findByPk($item2->penjamin_id);

            echo '<div style="display: inline-block; width: 100px; vertical-align: top;">';
            echo CHtml::link('<i class="icon-form-rincianbayar"></i><br/>'.$penjamin->penjamin_nama, $this->createUrl('detailAlokasi', array(
                'id'=>$item2->alokasidana_id
            )), array(
                'target'=>'frameDetailAlokasi',
                'onclick'=>"$('#dialogDetailAlokasi').dialog('open');"
            ));
            echo '</div>';
        }


        
        ?>
    </td>
</tr>

<?php endforeach; ?>