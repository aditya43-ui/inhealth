<div id="content-karcis-html">
<?php 
if(count((array)$modKarcis) > 0){
        $format = new MyFormatter();
        echo "<table>";
        echo "<thead>";
        echo "<th>Karcis</th>";
        echo "<th>Harga</th>";
        echo "<th>Pilih</th>";
        echo "</thead>";
        foreach($modKarcis AS $i =>$data){
            if ($i == 0){
                $data->is_pilihtindakan = 1; 
            $data->tarif_satuan = $format->formatNumberForUser($data->tarif_satuan);
            echo '<tr class="checked">
                    <td>'.CHtml::label($data->daftartindakan->daftartindakan_nama,$data->daftartindakan->daftartindakan_nama).'</td>
                    <td style="text-align:right;">'.CHtml::activeTextField($data, '['.$i.']tarif_satuan',array('readonly'=>true, 'class'=>'span1 integer', 'style'=>'width:96px;text-align:right;')).'</td>
                    <td><a data-karcis="'.$data['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this);return false;">
                        <i class="icon-form-check"></i>
                        </a>'
                    .CHtml::activeHiddenField($data, '['.$i.']is_pilihtindakan',array('readonly'=>true, 'class'=>'span1'))  
                    .CHtml::activeHiddenField($data, '['.$i.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))  
                    .CHtml::activeHiddenField($data, '['.$i.']karcis_id',array('readonly'=>true, 'class'=>'span1'))  
                .'</td>'
                .'</tr>';
            }
        }
        echo "</table>";
} ?>
</div>

