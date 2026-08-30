<?php
    $data = array();
    foreach($model as $key=>$value)
    {
      $trclass="";
  		if(isset($value->tr_class)){
        $trclass=$value->tr_class;
      }

		if($value->rekening5_nb == 'D'){
			$status = 'debit';
		}else if($value->rekening5_nb == 'K'){
			$status = 'kredit';
		}

        $key = 99;
        echo('<tr>');
            echo '<td>';
                $kode = $value->kdrekening5;
                echo $kode;
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening1_id]", '',array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening2_id]", '',array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening3_id]", '',array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening4_id]", '',array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value->rekening5_id,array());
            echo '</td>';
            echo('<td>');
                $nama = $value->nmrekening5;
                echo $nama;
            echo('</td>');

            echo '<td>';
                echo CHtml::hiddenField("RekeningakuntansiV[$key][nama_rekening]", $nama,array());
                echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]",
                    0,
                    array(
                        'class'=>'inputFormTabel integer-decimal span2'.($status == 'debit' ? " saldodebit ".$trclass : ""),
                        'disabled'=>($status == 'debit' ? false : true),
                        'style'=>'width: 110px;'
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]",
                    0,
                    array(
                        'class'=>'inputFormTabel integer-decimal span2'.($status == 'kredit' ? " saldokredit ".$trclass : ""),
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
