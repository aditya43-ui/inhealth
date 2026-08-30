<?php
    $data = array();
    foreach($model as $key=>$value)
    {
        $key = 99;
        echo('<tr>');
            echo '<td>';
                $kode = $value->kdstruktur . '-' . $value->kdkelompok . '-' . $value->kdjenis;
                if(isset($value->kdobyek))
                {
                    $kode .= '-' . $value->kdobyek;
                    if(isset($value->kdrincianobyek))
                    {
                        $kode .= '-' . $value->kdrincianobyek;
                    }
                }
                echo $kode;
                echo CHtml::hiddenField("RekeningakuntansiV[$key][struktur_id]", $value->struktur_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][kelompok_id]", $value->kelompok_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][jenis_id]", $value->jenis_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][obyek_id]", $value->obyek_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rincianobyek_id]", $value->rincianobyek_id,array());
            echo '</td>';
            echo('<td>');
                $nama = $value->nmjenis;
                if(isset($value->obyek_id))
                {
                    $nama = $value->nmobyek;
                    if(isset($value->rincianobyek_id))
                    {
                        $nama = $value->nmrincianobyek;
                    }
                }
                echo $nama;            
            echo('</td>');
            
            echo '<td>';
                echo CHtml::hiddenField("RekeningakuntansiV[$key][nama_rekening]", $nama,array());
                echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]", 
                    0,
                    array(
                        'class'=>'inputFormTabel integer',
                        'disabled'=>($status == 'debit' ? "" : "disabled"),
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]",
                    0,
                    array(
                        'class'=>'inputFormTabel integer',
                        'disabled'=>($status == 'kredit' ? "" : "disabled"),
                    )
                );
            echo '</td>';
            echo('<td>');
               echo CHtml::link(
                       '<i class="icon-form-silang"></i>',
                       "#",
                       array(
                           'onclick'=>'removeDataRekening(this); return false;',
                           'rel'=>"tooltip",
                           'data-original-title'=>"Menonaktifkan"
                       )
                );
            echo('</td>');
        echo('</tr>');
    }
?>