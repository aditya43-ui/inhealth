<?php

$data = array();

foreach ($model as $key => $value) {
    $debitKredit = "";
    $status_pph = "";

    if (!empty($dariDialog)) {

        if (!empty($value->jnspengeluaranrek_id)) {
            $jns = JnspengeluaranrekM::model()->findByPk($value->jnspengeluaranrek_id);
            $debitKredit = $jns->debitkredit;
        } else {
            $debitKredit = $value->rek_column->debitkredit;
        }

        if ($debitKredit == 'D') {
            $status = 'debit';
        } else if ($debitKredit == 'K') {
            $status = 'kredit';
        }

        if (!empty($value->rek_column)) {
            $status_pph = "input_pph";
        }
    }

    $row_name = "";
    /*
    if (!empty($value->rek_column)) {
        $row_name = 'rek_pph '.$value->rek_column->column_name;
    }
     *
     */

    $key = 99;
    echo('<tr class="'.$row_name.'">');
    echo '<td>';
    $kode = $value->kdrekening5;
    echo $kode;
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening1_id]", null, array());
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening2_id]", null, array());
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening3_id]", null, array());
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening4_id]", null, array());
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value->rekening5_id, array());
    echo '</td>';
    echo('<td>');
    $nama = $value->nmrekening5;
    echo $nama;
    echo('</td>');

    echo '<td>';
    echo CHtml::hiddenField("RekeningakuntansiV[$key][nama_rekening]", $nama, array());
    echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]", 0, array(
        'class' => 'inputFormTabel integer-decimal span2' . ($status == 'debit' ? " saldodebit ".$status_pph : ""),
        'readonly' => true,
        'style' => 'width: 110px;'
            )
    );
    echo '</td>';
    echo '<td>';
    echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]", 0, array(
        'class' => 'inputFormTabel integer-decimal span2' . ($status == 'kredit' ? " saldokredit ".$status_pph : ""),
        'readonly' => true,
        'style' => 'width: 110px;'
            )
    );
    echo '</td>';
    // echo('<td>');
    // echo CHtml::link(
    //         '<i class="icon-remove"></i>', "#", array(
    //     'onclick' => 'removeDataRekening(this); return false;',
    //     'rel' => "tooltip",
    //     'data-original-title' => "Menonaktifkan"
    //         )
    // );
    // echo('</td>');
    echo('</tr>');
}
?>
