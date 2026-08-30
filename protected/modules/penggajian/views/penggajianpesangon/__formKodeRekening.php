<?php
    $data = array();
    foreach($model as $key=>$value)
    {
		if (!empty($dariDialog)) {
			$jns = JnspengeluaranrekM::model()->findByPk($value->jnspengeluaranrek_id);
			if ($jns->debitkredit == 'D') {
				$status = 'debit';
			} else if ($jns->debitkredit == 'K') {
				$status = 'kredit';
			}
		}
		
        $key = 99;
        echo('<tr>');
            echo '<td>';
                
                echo $value->kdrekening5;;
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening1_id]", null,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening2_id]", null,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening3_id]", null,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening4_id]", null,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value->rekening5_id,array());
            echo '</td>';
            echo('<td>');
                echo  $value->nmrekening5;            
            echo('</td>');
            
            echo '<td>';
                echo CHtml::hiddenField("RekeningakuntansiV[$key][nama_rekening]", $value->nmrekening5,array());
                echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]", 
                    0,
                    array(
                        'class'=>'inputFormTabel integer2 span2'.($status == 'debit' ? " saldodebit" : ""),
                        'disabled'=>($status == 'debit' ? false : true),
                        'style'=>'width: 110px;'
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]",
                    0,
                    array(
                        'class'=>'inputFormTabel integer2 span2'.($status == 'kredit' ? " saldokredit" : ""),
                        'disabled'=>($status == 'kredit' ? false : true),
                        'style'=>'width: 110px;'
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
