<?php
if(!empty($modKarcisAll) && count((array)$modKarcisAll) > 0){
        $format = new MyFormatter();
        echo '<table class="table table-bordered table-condensed">';
        echo "<thead>";
        echo "<th>Karcis</th>";
        echo "<th>Tarif</th>";
        echo "<th>Pilih</th>";
        echo "</thead>";
        foreach($modKarcisAll AS $ii =>$karcis){

            $is_ada = false;
            foreach ($modKarcis as $ada) {
                if ($ada->daftartindakan_id == $karcis->daftartindakan_id) {
                    $is_ada = true;
                }
            }

            if ($is_ada){
                $karcis->is_pilihkarcis = 1;
                echo	'<tr class="checked">';
                $icon = 'icon-form-check';
            }else{
                $karcis->is_pilihkarcis = 0;
                echo	'<tr class="">';
                $icon = 'icon-form-silang';
            }

            //if ($ii == 0){
            // $karcis->harga_tariftindakan = $format->formatNumberForUser($karcis->harga_tariftindakan);
            $karcis->harga_tariftindakan = $karcis->harga_tariftindakan;
            $karcis->satuantindakan = (empty($karcis->satuantindakan) ? Params::SATUAN_TINDAKAN_LABORATORIUM : $karcis->satuantindakan);
            echo '
                    <td>'.CHtml::label($karcis->karcis_nama,$karcis->karcis_nama).'</td>
                    <td style="text-align:right;">'.CHtml::activeTextField($karcis, '['.$ii.']harga_tariftindakan',array('readonly'=>true, 'class'=>'span1 integer-decimal', 'style'=>'width:96px;text-align:right;')).'</td>
                    <td><a data-karcis="'.$karcis->karcis_id.' class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this);return false;">
                        <i class="'.$icon.'"></i>
                        </a>'
                    .CHtml::activeHiddenField($karcis, '['.$ii.']karcis_nama',array('readonly'=>true, 'class'=>'span1'))
                    .CHtml::activeHiddenField($karcis, '['.$ii.']is_pilihkarcis',array('readonly'=>true, 'class'=>'span1'))
                    .CHtml::activeHiddenField($karcis, '['.$ii.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))
                    .CHtml::activeHiddenField($karcis, '['.$ii.']karcis_id',array('readonly'=>true, 'class'=>'span1'))
                    .CHtml::activeHiddenField($karcis, '['.$ii.']jenistarif_id',array('readonly'=>true, 'class'=>'span1'))
                    .CHtml::activeHiddenField($karcis, '['.$ii.']satuantindakan',array('readonly'=>true, 'class'=>'span1'))
                .'</td>'
                .'</tr>';
            //}
        }
        echo "</table>";
} ?>
