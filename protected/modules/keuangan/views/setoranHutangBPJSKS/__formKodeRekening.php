
<?php

$data = array();

foreach ($model as $key => $value) {
//    $tr = "";
    
    if($debitkredit == 'K'){
        $status = "kredit";
//        $tr = "trkredit";
    }else{
        $status = "debit";
//        $tr = "trdebit";
    }

    $key = 99;
    echo('<tr class="rekening_setoran '.$tr.'">');
    echo '<td>';
    
    echo $value->kdrekening5;
    echo CHtml::hiddenField("RekeningakuntansiV[$key][nourut]", $nourut, array('class'=>'nourut'));
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening1_id]", $value->rekening1_id, array('class'=>'rekening1_id'));
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening2_id]", $value->rekening2_id, array('class'=>'rekening2_id'));
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening3_id]", $value->rekening3_id, array('class'=>'rekening3_id'));
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening4_id]", $value->rekening4_id, array('class'=>'rekening4_id'));
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value->rekening5_id, array('class'=>'rekening5_id'));
    echo '</td>';
    echo('<td>');
    
    echo $value->nmrekening5;
    echo('</td>');

    echo '<td>';
    echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]", 0, array(
        'class' => 'inputFormTabel integer-decimal span2' . ($status == 'debit' ? " saldodebit" : ""),
        'readonly' => true,
        'style' => 'width: 110px;'
            )
    );
    echo '</td>';
    echo '<td>';
    echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]", 0, array(
        'class' => 'inputFormTabel integer-decimal span2' . ($status == 'kredit' ? " saldokredit" : ""),
        'readonly' => true,
        'style' => 'width: 110px;'
            )
    );
    echo '</td>';
    echo('</tr>');
}
?>
