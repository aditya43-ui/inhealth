<?php
// detail
// key
// saldo_debit
// saldo_kredit

    //$data = array();
    //$key = 99;
    //foreach($model as $key=>$detail)
    //{

		$value = RekeningakuntansiV::model()->findByAttributes(array(
            'rekeninglast_id'=>$detail->rekening5_id,
        ));





        echo('<tr>');
            echo '<td>';
                $kode = ''; //$value->kdrekening1 . '-' . $value->kdrekening2 . '-' . $value->kdrekening3;
                if(isset($value->kdrekening4))
                {
                    $kode = $value->kdrekening4;
                    if(isset($value->kdrekening5))
                    {
                        $kode = $value->kdrekeninglast;
                    }
                }
                echo $kode;
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening1_id]", $value->rekening1_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening2_id]", $value->rekening2_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening3_id]", $value->rekening3_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening4_id]", $value->rekening4_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value->rekeninglast_id,array());
            echo '</td>';
            echo('<td>');
                $nama = $value->nmrekening3;
                if(isset($value->rekening4_id))
                {
                    $nama = $value->nmrekening4;
                    if(isset($value->rekeninglast_id))
                    {
                        $nama = $value->nmrekeninglast;
                    }
                }
                echo $nama;
            echo('</td>');

            echo '<td>';
                echo CHtml::hiddenField("RekeningakuntansiV[$key][nama_rekening]", $nama,array());
                echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]",
                    $saldo_debit,
                    array(
                        'class'=>'inputFormTabel integer2 span2',
                        'readonly'=>true,
                        'style'=>'width: 110px;'
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]",
                    $saldo_kredit,
                    array(
                        'class'=>'inputFormTabel integer2 span2',
                        'readonly'=>true,
                        'style'=>'width: 110px;'
                    )
                );
            echo '</td>';
//            echo('<td>');
//               echo CHtml::link(
//                       '<i class="icon-form-silang"></i>',
//                       "#",
//                       array(
//                           'onclick'=>'removeDataRekening(this); return false;',
//                           'rel'=>"tooltip",
//                           'data-original-title'=>"Menonaktifkan"
//                       )
//                );
//            echo('</td>');
        echo('</tr>');
        //$key++;
    //}
?>
