<?php
if(count((array)$modRekenings) > 0){
    foreach($modRekenings as $key=>$value)
    {
        echo('<tr>');
                echo "<td>".
                        CHtml::hiddenField("row", 0,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::textField("RekeningsupplierV[$key][kdstruktur]", $value->kdstruktur,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningsupplierV[$key][struktur_id]", $value->struktur_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField("RekeningsupplierV[$key][supplier_id]", $value->supplier_id,array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningsupplierV[$key][kdkelompok]", $value->kdkelompok,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningsupplierV[$key][kelompok_id]", $value->kelompok_id,array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningsupplierV[$key][kdjenis]", $value->kdjenis,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningsupplierV[$key][jenis_id]", $value->jenis_id,array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningsupplierV[$key][kdobyek]", $value->kdobyek,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningsupplierV[$key][obyek_id]", $value->obyek_id,array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningsupplierV[$key][kdrincianobyek]", $value->kdrincianobyek,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField("RekeningsupplierV[$key][rincianobyek_id]", $value->rincianobyek_id,array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo('<td>');
                if(isset($value->nmjenis)){
                    $nama = $value->nmjenis;
                    if(isset($value->obyek_id))
                    {
                        $nama = $value->nmobyek;
                        if(isset($value->rincianobyek_id))
                        {
                            $nama = $value->nmrincianobyek;
                        }
                    }
                }else{
                    $nama = "";
                }
                echo CHtml::hiddenField("RekeningsupplierV[$key][nama_rekening]", $nama,array('readonly'=>true));
                echo CHtml::hiddenField("RekeningsupplierV[$key][saldonormal]", $value->saldonormal,array('readonly'=>true));
                $this->widget('MyJuiAutoComplete',
                    array(
                        'value'=>$nama,
                        'name' => "RekeningsupplierV[$key][rekDebitKredit]",
                        'id' => "RekeningsupplierV".$key."_rekDebitKredit",
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
                echo CHtml::textField("RekeningsupplierV[$key][saldodebit]", 
                    $value->saldodebit,
                    array(
                        'class'=>'inputFormTabel uncurrency',
                        //'disabled'=>($status == 'debit' ? "" : "disabled"),
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField("RekeningsupplierV[$key][saldokredit]",
                    $value->saldokredit,
                    array(
                        'class'=>'inputFormTabel uncurrency',
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
    }
}
?>