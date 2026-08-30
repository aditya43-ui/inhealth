<?php
    $data = array();
    foreach($model as $key=>$value)
    {
		if($value->saldonormal == 'D'){
			$status = 'debit';
		}else if($value->saldonormal == 'K'){
			$status = 'kredit';
		}
		
        $key = 99;
        echo('<tr>');
            echo '<td>';
                $kode = $value->kdrekening1 . '-' . $value->kdrekening2 . '-' . $value->kdrekening3;
                if(isset($value->kdrekening4))
                {
                    $kode .= '-' . $value->kdrekening4;
                    if(isset($value->kdrekening5))
                    {
                        $kode .= '-' . $value->kdrekening5;
                    }
                }
                echo $kode;
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening1_id]", $value->rekening1_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening2_id]", $value->rekening2_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening3_id]", $value->rekening3_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening4_id]", $value->rekening4_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value->rekening5_id,array());
            echo '</td>';
            echo('<td>');
                $nama = $value->nmrekening3;
                if(isset($value->rekening4_id))
                {
                    $nama = $value->nmrekening4;
                    if(isset($value->rekening5_id))
                    {
                        $nama = $value->nmrekening5;
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
                       '<i class="icon-remove"></i>',
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