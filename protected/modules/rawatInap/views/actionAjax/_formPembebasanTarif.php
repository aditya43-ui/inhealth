<table id="tblTindakanPasien" class="table table-condensed table-bordered">
    <thead>
        <tr>
            <th colspan="3">Pembebasan Tarif Pasien</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $tindPelId=>$tindakan){
            echo '<tr><td><b>'.$tindakan['daftartindakan_nama'].'</b></td>';
            echo '<td><table>';
            foreach($tindakan as $tindKompId=>$tindKomp){
                if(is_array($tindKomp) && $tindKomp['komponentarif_id']!=Params::KOMPONENTARIF_ID_TOTAL){
                    $tarif = number_format($tindKomp['tarif_tindakankomp']);
                    echo '<tr>';
                    echo '<td>';
                    echo CHtml::checkBox("pembebasan[$tindKompId][tindkomponen_id]", '', array('value'=>$tindKompId));
                    echo CHtml::hiddenField("pembebasan[$tindKompId][tindakanpelayanan_id]", $tindPelId, array('readonly'=>true));
                    echo CHtml::hiddenField("pembebasan[$tindKompId][komponentarif_id]", $tindKomp['komponentarif_id'], array('readonly'=>true));
                    //echo CHtml::hiddenField("pembebasan[$tindKompId][tarif_tindakankomp]", $tindKomp['tarif_tindakankomp'], array('readonly'=>true));
                    //echo $tindPelId.' - '.$tindKompId.' - '.$tindKomp['komponentarif_id'];
                    echo '</td>';
                    echo '<td>'.$tindKomp['komponentarif_nama'].'</td>';
                    echo '<td style="text-align:right;">'.$tarif.'</td>';
                    echo '<td style="text-align:right;">'.CHtml::textField("pembebasan[$tindKompId][tarif_tindakankomp]", $tindKomp['tarif_tindakankomp'], 
                                    array('readonly'=>false,
                                          'class'=>'inputFormTabel integer lebar2')).
                         '</td>';
                    echo '</tr>';
                }
            }
            echo '</table></td>';
            echo '</tr>';
        } ?>
    </tbody>
</table>

