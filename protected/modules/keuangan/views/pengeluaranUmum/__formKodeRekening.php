<?php

$data = array();

foreach ($model as $key => $value) {
    $debitKredit = "";
    $status_pph = "";

    if (!empty($dariDialog)) {
        $debitKredit = (isset($value->debitkredit)?$value->debitkredit:"");
        
        if (!empty($value->jnspengeluaranrek_id)) {
            $jns = JnspengeluaranrekM::model()->findByPk($value->jnspengeluaranrek_id);
            $debitKredit = $jns->debitkredit;
        } else {
            if(isset($value->rek_column)){
                $debitKredit = $value->rek_column->debitkredit;
            }
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
    if (!empty($value->rek_column)) {
        $row_name = 'rek_pph '.$value->rek_column->column_name;
    }else{
        if(isset($rekeningtype)){
            $row_name = $rekeningtype;
        }
    }

    $key = 99;
    echo('<tr class="'.$row_name.'">');
    echo '<td>';
    // $kode = ''; //$value->kdrekening1 . '-' . $value->kdrekening2 . '-' . $value->kdrekening3;
    // if (isset($value->kdrekening4)) {
    //     $kode = $value->kdrekening4;
    //     if (isset($value->kdrekening5)) {
            $kode = $value->kdrekening5;
    //     }
    // }
    echo $kode;
    // echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening1_id]", $value->rekening1_id, array());
    // echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening2_id]", $value->rekening2_id, array());
    // echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening3_id]", $value->rekening3_id, array());
    // echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening4_id]", $value->rekening4_id, array());
    echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value->rekening5_id, array());
    echo '</td>';
    echo('<td>');
    // $nama = $value->nmrekening3;
    // if (isset($value->rekening4_id)) {
    //     $nama = $value->nmrekening4;
        if (isset($value->rekening5_id)) {
            $nama = $value->nmrekening5;
        }
    // }
    echo $nama;
    echo('</td>');

    echo '<td>';
    echo CHtml::hiddenField("RekeningakuntansiV[$key][nama_rekening]", $nama, array());
    echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]", 0, array(
        'class' => 'inputFormTabel integer2 span2' . ($status == 'debit' ? " saldodebit ".$status_pph : ""),
        'disabled' => ($status == 'debit' ? false : true),
        'style' => 'width: 110px;'
            )
    );
    echo '</td>';
    echo '<td>';
    echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]", 0, array(
        'class' => 'inputFormTabel integer2 span2' . ($status == 'kredit' ? " saldokredit ".$status_pph : ""),
        'disabled' => ($status == 'kredit' ? false : true),
        'style' => 'width: 110px;'
            )
    );
    echo '</td>';
    echo('<td style="text-align: center;">');
    echo CHtml::link(
            '<i class="icon-form-silang"></i>', "#", array(
        'onclick' => 'removeDataRekening(this); return false;',
        'rel' => "tooltip",
        'data-original-title' => "Menonaktifkan"
            )
    );
    echo('</td>');
    echo('</tr>');
}
?>
