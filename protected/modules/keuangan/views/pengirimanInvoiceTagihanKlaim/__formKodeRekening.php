
<?php

$data = array();

foreach ($model as $key => $value) {
    if($value['debitkredit'] == 'K'){
        $status = "kredit";
    }else{
        $status = "debit";
    }

    $key = 99;
    echo('<tr>');
    echo '<td>';
    
    echo $value['kdrekening5'];
    echo CHtml::hiddenField("RekeningakuntansiV[$key][debitkredit]", $value['debitkredit'], array('class'=>'debitkredit'));
    echo CHtml::hiddenField("RekeningakuntansiV[$key][nourut]", $value['nourut'], array('class'=>'nourut'));
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value['rekening5_id'], array('class'=>'rekening5_id'));
    echo '</td>';
    echo('<td>');
    
    echo $value['nmrekening5'];
    echo('</td>');

    echo '<td>';
    echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]", 0, array(
        'class' => 'integer-decimal span2' . ($status == 'debit' ? " saldodebit" : ""),
        'readonly' => true,
        'style' => 'width: 110px;'
            )
    );
    echo '</td>';
    echo '<td>';
    echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]", 0, array(
        'class' => 'integer-decimal span2' . ($status == 'kredit' ? " saldokredit" : ""),
        'readonly' => true,
        'style' => 'width: 110px;'
            )
    );
    echo '</td>';
    echo('</tr>');
}
?>
