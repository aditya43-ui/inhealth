<?php

if(count((array)$modRekening) > 0){
    echo('<tr>');
        echo "<td>".
                CHtml::hiddenField("row", 0,array('readonly'=>true, 'class'=>'span1')).
                CHtml::textField("RekeningakuntansiV[0][kdrekening1]", "01",array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                CHtml::hiddenField("RekeningakuntansiV[0][rekening1_id]", "1",array('readonly'=>true, 'class'=>'span1')).
            "</td>";
            echo "<td>".
                    CHtml::textField("RekeningakuntansiV[0][kdrekening2]", "01",array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                    CHtml::hiddenField("RekeningakuntansiV[0][rekening2_id]", "1",array('readonly'=>true, 'class'=>'span1')).
                "</td>";
            echo "<td>".
                    CHtml::textField("RekeningakuntansiV[0][kdrekening3]", "01",array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                    CHtml::hiddenField("RekeningakuntansiV[0][rekening3_id]", "1",array('readonly'=>true, 'class'=>'span1')).
                "</td>";
            echo "<td>".
                    CHtml::textField("RekeningakuntansiV[0][kdrekening4]", "01",array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                    CHtml::hiddenField("RekeningakuntansiV[0][rekening4_id]", "1",array('readonly'=>true, 'class'=>'span1')).
                "</td>";
            echo "<td>".
                    CHtml::textField("RekeningakuntansiV[0][kdrekening5]", "02",array('readonly'=>true, 'class'=>'span1')).
                    CHtml::hiddenField("RekeningakuntansiV[0][rekening5_id]", "357",array('readonly'=>true, 'class'=>'span1')).
                "</td>";
            echo('<td>');
                echo CHtml::hiddenField("RekeningakuntansiV[0][nama_rekening]", "Kas Bendahara",array('readonly'=>true)); 
                $this->widget('MyJuiAutoComplete',
                    array(
                        'value'=>"Kas Bendahara",
                        'name' => "RekeningakuntansiV[0][rekDebitKredit]",
                        'id' => "RekeningakuntansiV_".$ind."_rekDebitKredit",
                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>null)),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ){
                                return false;
                            }',
                            'select' => 'js:function( event, ui ){
                                $(this).val(ui.item.value);
                                var data = {
                                    //DATA DI TAMBAHKAN MELAUI FUNGSI .autocomplete di renameRowRekening()
                                };
                                editDataRekeningFromGrid(data, row);                            
                                return false;
                            }'
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder'=>'Nama Rekening Debit',
                            'class'=>'span2',
                            'style'=>'width:150px;',
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogRekDebitKredit',
                            'jsFunction'=>"setDialogRekening(this);",
                        ),
                    )
                );
            echo('</td>');   
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[0][saldodebit]", 
                    0,
                    array(
                        'class'=>'inputFormTabel currency',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[0][saldokredit]",
                    (isset($modKas) ? $modKas : 0),
                    array(
                        'class'=>'inputFormTabel currency',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
            echo('<td>');
               echo CHtml::link(
                       '<i class="icon-plus"></i>',
                       "#",
                       array(
                           'onclick'=>'addDataRekening(this); return false;',
                           'rel'=>"tooltip",
                           'data-original-title'=>"Menambah Rekening"
                       )
                );
               echo CHtml::link(
                       '<i class="icon-minus"></i>',
                       "#",
                       array(
                           'onclick'=>'removeDataRekening(this); return false;',
                           'rel'=>"tooltip",
                           'data-original-title'=>"Menghapus Rekening"
                       )
                );
            echo('</td>');
    echo('</tr>');            

	$ind = 1;
    foreach($modRekening as $key=>$value)
    {
        echo('<tr>');
	        echo "<td>".
	                CHtml::hiddenField("row", 0,array('readonly'=>true, 'class'=>'span1')).
	                CHtml::textField("RekeningakuntansiV[$ind][kdrekening1]", $value['kdrekening1'],array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
	                CHtml::hiddenField("RekeningakuntansiV[$ind][rekening1_id]", $value['rekening1_id'],array('readonly'=>true, 'class'=>'span1')).
	            "</td>";
                echo "<td>".
                        CHtml::textField("RekeningakuntansiV[$ind][kdrekening2]", $value['kdrekening2'],array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningakuntansiV[$ind][rekening2_id]", $value['rekening2_id'],array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningakuntansiV[$ind][kdrekening3]", $value['kdrekening3'],array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningakuntansiV[$ind][rekening3_id]", $value['rekening3_id'],array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningakuntansiV[$ind][kdrekening4]", $value['kdrekening4'],array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningakuntansiV[$ind][rekening4_id]", $value['rekening4_id'],array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningakuntansiV[$ind][kdrekening5]", $value['kdrekening5'],array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField("RekeningakuntansiV[$ind][rekening5_id]", $value['rekening5_id'],array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo('<td>');
                if(isset($value['nmrekening3'])){
                    $nama = $value['nmrekening3'];
                    if(isset($value['rekening4_id']))
                    {
                        $nama = $value['nmrekening4'];
                        if(isset($value['rekening5_id']))
                        {
                            $nama = $value['nmrekening5'];
                        }
                    }
                }else{
                    $nama = "";
                }
                echo CHtml::hiddenField("RekeningakuntansiV[$ind][nama_rekening]", $value['nama_rekening'],array('readonly'=>true));				
                //echo CHtml::hiddenField("RekeningakuntansiV[$ind][saldonormal]", $value->saldonormal,array('readonly'=>true));
                $this->widget('MyJuiAutoComplete',
                    array(
                        'value'=>$value['nama_rekening'],
                        'name' => "RekeningakuntansiV[$key][rekDebitKredit]",
                        'id' => "RekeningakuntansiV_".$ind."_rekDebitKredit",
//                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>null)),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ){
                                return false;
                            }',
                            'select' => 'js:function( event, ui ){
                                $(this).val(ui.item.value);
                                var data = {
                                    //DATA DI TAMBAHKAN MELAUI FUNGSI .autocomplete di renameRowRekening()
                                };
                                editDataRekeningFromGrid(data, row);                            
                                return false;
                            }'
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder'=>'Nama Rekening Debit',
                            'class'=>'span2',
                            'style'=>'width:150px;',
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogRekDebitKredit',
                            'jsFunction'=>"setDialogRekening(this);",
                        ),
                    )
                );
            echo('</td>');
            
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[$ind][saldodebit]", 
                    $value['saldodebit'],
                    array(
                        'class'=>'inputFormTabel currency',
                        //'disabled'=>($status == 'debit' ? "" : "disabled"),
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField("RekeningakuntansiV[$ind][saldokredit]",
                    $value['saldokredit'],
                    array(
                        'class'=>'inputFormTabel currency',
                        //'disabled'=>($status == 'kredit' ? "" : "disabled"),
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
            echo('<td>');
               echo CHtml::link(
                       '<i class="icon-plus"></i>',
                       "#",
                       array(
                           'onclick'=>'addDataRekening(this); return false;',
                           'rel'=>"tooltip",
                           'data-original-title'=>"Menambah Rekening"
                       )
                );
               echo CHtml::link(
                       '<i class="icon-minus"></i>',
                       "#",
                       array(
                           'onclick'=>'removeDataRekening(this); return false;',
                           'rel'=>"tooltip",
                           'data-original-title'=>"Menghapus Rekening"
                       )
                );
            echo('</td>');
        echo('</tr>');
        $ind++;
    }
}
?>