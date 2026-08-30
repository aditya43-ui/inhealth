<?php
$namaModel = "AKRincianfakturhutangsupplierV";
$noUrut = 1;
if(count((array)$modRekenings) > 0){
    foreach($modRekenings as $key=>$value)
    {
        
        $link_label = MyFormatter::formatDateTimeForUser($value->tglfaktur).'/<br>'.$value->nofaktur;
        
        echo('<tr>');
                echo "<td>".
                        CHtml::checkBox($namaModel."[$key][pilihRekening]",true).
                    "</td>";
                echo "<td>".
                        CHtml::textField("noUrut", ($noUrut),array('readonly'=>true, 'style'=>'width:20px; text-align:right;')).
                    "</td>"; $noUrut++;
                echo "<td>".
                        $link_label.
                        CHtml::hiddenField($namaModel."[$key][fakturpembelian_id]", $value->fakturpembelian_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        $value->supplier_nama.
                        CHtml::hiddenField($namaModel."[$key][supplier_id]", $value->supplier_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        CHtml::hiddenField("row", $key,array('readonly'=>true, 'class'=>'span1')).
                        //CHtml::textField($namaModel."[$key][kdrekening1]", $value->kdrekening1,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][rekening1_id]", $value->rekening1_id,array('readonly'=>true, 'class'=>'span1')).
                        //CHtml::textField($namaModel."[$key][kdrekening2]", $value->kdrekening2,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][rekening2_id]", $value->rekening2_id,array('readonly'=>true, 'class'=>'span1')).
                        //CHtml::textField($namaModel."[$key][kdrekening3]", $value->kdrekening3,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][rekening3_id]", $value->rekening3_id,array('readonly'=>true, 'class'=>'span1')).
                        //CHtml::textField($namaModel."[$key][kdrekening4]", $value->kdrekening4,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][rekening4_id]", $value->rekening4_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::textField($namaModel."[$key][kdrekening5]", $value->kdrekening5,array('readonly'=>true, 'class'=>'span2')).
                        CHtml::hiddenField($namaModel."[$key][rekening5_id]", $value->rekening5_id,array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo('<td>');
                echo CHtml::hiddenField($namaModel."[$key][nama_rekening]", $value->nmrekening5,array('readonly'=>true));
                $this->widget('MyJuiAutoComplete',
                    array(
                        'value'=>$value->nmrekening5,
                        'name' => $namaModel."[$key][rekDebitKredit]",
                        'id' => $namaModel."_".$key."_rekDebitKredit",
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
                            'placeholder'=>'Nama Rekening',
                            'style'=>'width:200px;',
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogRekDebitKredit',
                            'jsFunction'=>"setDialogRekening(this);",
                        ),
                    )
                );
            echo('</td>');
            
            echo '<td>';
                echo CHtml::textField($namaModel."[$key][saldodebit]", 
                MyFormatter::formatNumberForPrint($value->saldodebit),
                    array(
                        'class'=>'inputFormTabel integer2 span2',
                        //'disabled'=>($status == 'debit' ? "" : "disabled"),
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onkeyup'=>'hitungSaldo(this)',
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField($namaModel."[$key][saldokredit]",
                    MyFormatter::formatNumberForPrint($value->saldokredit),
                    array(
                        'class'=>'inputFormTabel integer2 span2',
                        //'disabled'=>($status == 'kredit' ? "" : "disabled"),
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onkeyup'=>'hitungSaldo(this)',
                    )
                );
            echo '</td>';
        echo('</tr>');
    }
}
?>