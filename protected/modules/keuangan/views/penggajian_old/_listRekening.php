<?php

if(count((array)$modRekening) > 0){
    echo('<tr>');
        echo "<td>".
                CHtml::hiddenField("row", 0,array('readonly'=>true, 'class'=>'span1')).
                CHtml::textField("RekeningakuntansiV[0][kdstruktur]", "01",array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                CHtml::hiddenField("RekeningakuntansiV[0][struktur_id]", "1",array('readonly'=>true, 'class'=>'span1')).
            "</td>";
            echo "<td>".
                    CHtml::textField("RekeningakuntansiV[0][kdkelompok]", "01",array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                    CHtml::hiddenField("RekeningakuntansiV[0][kelompok_id]", "1",array('readonly'=>true, 'class'=>'span1')).
                "</td>";
            echo "<td>".
                    CHtml::textField("RekeningakuntansiV[0][kdjenis]", "01",array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                    CHtml::hiddenField("RekeningakuntansiV[0][jenis_id]", "1",array('readonly'=>true, 'class'=>'span1')).
                "</td>";
            echo "<td>".
                    CHtml::textField("RekeningakuntansiV[0][kdobyek]", "01",array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                    CHtml::hiddenField("RekeningakuntansiV[0][obyek_id]", "1",array('readonly'=>true, 'class'=>'span1')).
                "</td>";
            echo "<td>".
                    CHtml::textField("RekeningakuntansiV[0][kdrincianobyek]", "02",array('readonly'=>true, 'class'=>'span1')).
                    CHtml::hiddenField("RekeningakuntansiV[0][rincianobyek_id]", "357",array('readonly'=>true, 'class'=>'span1')).
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
	                CHtml::textField("RekeningakuntansiV[$ind][kdstruktur]", $value['kdstruktur'],array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
	                CHtml::hiddenField("RekeningakuntansiV[$ind][struktur_id]", $value['struktur_id'],array('readonly'=>true, 'class'=>'span1')).
	            "</td>";
                echo "<td>".
                        CHtml::textField("RekeningakuntansiV[$ind][kdkelompok]", $value['kdkelompok'],array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningakuntansiV[$ind][kelompok_id]", $value['kelompok_id'],array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningakuntansiV[$ind][kdjenis]", $value['kdjenis'],array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningakuntansiV[$ind][jenis_id]", $value['jenis_id'],array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningakuntansiV[$ind][kdobyek]", $value['kdobyek'],array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField("RekeningakuntansiV[$ind][obyek_id]", $value['obyek_id'],array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo "<td>".
                        CHtml::textField("RekeningakuntansiV[$ind][kdrincianobyek]", $value['kdrincianobyek'],array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField("RekeningakuntansiV[$ind][rincianobyek_id]", $value['rincianobyek_id'],array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo('<td>');
                if(isset($value['nmjenis'])){
                    $nama = $value['nmjenis'];
                    if(isset($value['obyek_id']))
                    {
                        $nama = $value['nmobyek'];
                        if(isset($value['rincianobyek_id']))
                        {
                            $nama = $value['nmrincianobyek'];
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