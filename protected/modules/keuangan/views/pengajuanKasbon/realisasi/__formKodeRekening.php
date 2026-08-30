<?php
//RND-13508 coba upload ulang semua file untuk penerimaan umum
    $data = array();
    foreach($model as $key=>$value)
    {
        $classColumn = "";
	
        if(!empty($value->column_name)){
            if($value->column_name == Params::REKENINGCOLUMN_COLUMN_PENERIMAANUMUMID){
              $classColumn = "columnbiayaadm";  
            }else if($value->column_name == Params::REKENINGCOLUMN_COLUMN_NOPENERIMAAN){
              $classColumn = "columnbiayamaterai";  
            }else if($value->column_name == Params::REKENINGCOLUMN_COLUMN_JMLPPH23){
              $classColumn = "columnpph23";  
            }else if($value->column_name == Params::REKENINGCOLUMN_COLUMN_PENUM_JMLPPN){
              $classColumn = "columnppn";  
            }else if($value->column_name == Params::REKENINGCOLUMN_COLUMN_JMLPPH22){
              $classColumn = "columnpph22";  
            }else if($value->column_name == Params::REKENINGCOLUMN_COLUMN_JMLPPH21){
              $classColumn = "columnpph21";  
            }
        }
        
        $key = 99;
        echo('<tr class="'.$rekeningtype.'">');
            echo '<td>';
//                $kode = $value->kdrekening1 . '-' . $value->kdrekening2 . '-' . $value->kdrekening3;
//                if(isset($value->kdrekening4))
//                {
//                    $kode .= '-' . $value->kdrekening4;
//                    if(isset($value->kdrekening5))
//                    {
//                        $kode .= '-' . $value->kdrekening5;
//                    }
//                }
                echo  $value->kdrekening5;
                // echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening1_id]", $value->rekening1_id,array());
                // echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening2_id]", $value->rekening2_id,array());
                // echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening3_id]", $value->rekening3_id,array());
                // echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening4_id]", $value->rekening4_id,array());
                echo CHtml::hiddenField("RekeningakuntansiV[$key][rekening5_id]", $value->rekening5_id,array());
            echo '</td>';
            echo('<td>');
                // $nama = $value->nmrekening3;
                // if(isset($value->rekening4_id))
                // {
                //     $nama = $value->nmrekening4;
                    if(isset($value->rekening5_id))
                    {
                        $nama = $value->nmrekening5;
                    }
                // }
                echo $nama;            
            echo('</td>');
            echo '<td>';
                echo CHtml::hiddenField("RekeningakuntansiV[$key][nama_rekening]", $nama,array());
                echo CHtml::textField("RekeningakuntansiV[$key][saldodebit]", 
                    0,
                    array(
                        'class'=>'inputFormTabel integer2 span2 '.($value->debitkredit == 'D' ? " saldodebit ".$classColumn : ""),
                        'readonly'=>($value->debitkredit == 'D' ? "" : "readonly"),
						'onblur'=>'hitungTotalRekening;'
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[$key][saldokredit]",
                    0,
                    array(
                        'class'=>'inputFormTabel integer2 span2 '.($value->debitkredit == 'K' ? " saldokredit ".$classColumn  : ""),
                        'readonly'=>($value->debitkredit == 'K' ? "" : "readonly"),
						'onblur'=>'hitungTotalRekening();'
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
