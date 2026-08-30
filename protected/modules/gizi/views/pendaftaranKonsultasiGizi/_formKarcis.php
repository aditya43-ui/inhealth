<?php 
if(count((array)$modKarcis) > 0){ 
        $format = new MyFormatter();
        echo "<table>";
        echo "<thead>";
        echo "<th>Karcis</th>";
        echo "<th>Harga</th>";
        echo "<th>Pilih</th>";
        echo "</thead>";
        foreach($modKarcis AS $ii =>$karcis){
            if ($ii == 0){
                $karcis->is_pilihkarcis = 1;
            $karcis->harga_tariftindakan = $format->formatNumberForUser($karcis->harga_tariftindakan);
            $karcis->satuantindakan = (empty($karcis->satuantindakan) ? Params::SATUAN_TINDAKAN_LABORATORIUM : $karcis->satuantindakan);
            echo '<tr class="checked">
                    <td>'.CHtml::label($karcis->karcis_nama,$karcis->karcis_nama).'</td>
                    <td style="text-align:right;">'.CHtml::activeTextField($karcis, '['.$ii.']harga_tariftindakan',array('readonly'=>true, 'class'=>'span1 integer', 'style'=>'width:96px;text-align:right;')).'</td>
                    <td><a data-karcis="'.$karcis->karcis_id.' class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this);return false;">
                        <i class="icon-form-check"></i>
                        </a>'
                    .CHtml::activeHiddenField($karcis, '['.$ii.']karcis_nama',array('readonly'=>true, 'class'=>'span1'))  
                    .CHtml::activeHiddenField($karcis, '['.$ii.']is_pilihkarcis',array('readonly'=>true, 'class'=>'span1'))  
                    .CHtml::activeHiddenField($karcis, '['.$ii.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))  
                    .CHtml::activeHiddenField($karcis, '['.$ii.']karcis_id',array('readonly'=>true, 'class'=>'span1'))  
                    .CHtml::activeHiddenField($karcis, '['.$ii.']jenistarif_id',array('readonly'=>true, 'class'=>'span1'))  
                    .CHtml::activeHiddenField($karcis, '['.$ii.']satuantindakan',array('readonly'=>true, 'class'=>'span1'))  
                .'</td>'
                .'</tr>';
            }
        }
        echo "</table>";
} ?>

