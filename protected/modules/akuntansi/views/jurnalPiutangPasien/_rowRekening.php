<?php
$namaModel = "AKRincianpiutangrekeningpasienV";
$noUrut = 1;
if(count((array)$modRekenings) > 0){
    foreach($modRekenings as $key=>$value)
    {
        echo('<tr>');
                echo "<td>".
                        CHtml::checkBox($namaModel."[$key][pilihRekening]",true).
                    "</td>";
                echo "<td>".
                        CHtml::textField("noUrut", ($noUrut),array('readonly'=>true, 'style'=>'width:20px; text-align:right;')).
                    "</td>"; $noUrut++;
                echo "<td>".
                        $value->no_rekam_medik."/<br> ".$value->nama_pasien.
                        CHtml::hiddenField($namaModel."[$key][pasien_id]", $value->pasien_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
						MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($value->tgl_pendaftaran)))." ".$value->no_pendaftaran.
                        CHtml::hiddenField($namaModel."[$key][pendaftaran_id]", $value->pendaftaran_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        $value->instalasi_nama."/<br> ".$value->ruangan_nama.
                        CHtml::hiddenField($namaModel."[$key][instalasi_id]", $value->instalasi_id,array('readonly'=>true, 'class'=>'span2')).
                        CHtml::hiddenField($namaModel."[$key][ruangan_id]", $value->ruangan_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";
                echo "<td>".
                        $value->carabayar_nama."/<br> ".$value->penjamin_nama.
                        CHtml::hiddenField($namaModel."[$key][carabayar_id]", $value->carabayar_id,array('readonly'=>true, 'class'=>'span2')).
                        CHtml::hiddenField($namaModel."[$key][penjamin_id]", $value->penjamin_id,array('readonly'=>true, 'class'=>'span2')).
                    "</td>";               
                echo "<td>".
                        CHtml::hiddenField("row", $key,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField($namaModel."[$key][kdrekening1]", $value->kdrekening1,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][rekening1_id]", $value->rekening1_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField($namaModel."[$key][kdrekening2]", $value->kdrekening2,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][rekening2_id]", $value->rekening2_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField($namaModel."[$key][kdrekening3]", $value->kdrekening3,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][rekening3_id]", $value->rekening3_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::hiddenField($namaModel."[$key][kdrekening4]", $value->kdrekening4,array('readonly'=>true, 'class'=>'span1', 'style'=>'width:20px')).
                        CHtml::hiddenField($namaModel."[$key][rekening4_id]", $value->rekening4_id,array('readonly'=>true, 'class'=>'span1')).
                        CHtml::textField($namaModel."[$key][kdrekening5]", $value->kdrekening5,array('readonly'=>true, 'class'=>'span2')).
                        CHtml::hiddenField($namaModel."[$key][rekening5_id]", $value->rekening5_id,array('readonly'=>true, 'class'=>'span1')).
                    "</td>";
                echo('<td>');
//                echo CHtml::hiddenField($namaModel."[$key][nama_rekening]", $value->nmrincianobyek,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][nama_rekening]", $value->daftartindakan_nama,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][jnspelayanan]", $value->jnspelayanan,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][tm]", $value->tm,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][daftartindakan_id]", $value->daftartindakan_id,array('readonly'=>true));
                echo CHtml::hiddenField($namaModel."[$key][tindakanpelayanan_id]", $value->tindakanpelayanan_id,array('readonly'=>true));
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
             echo "<td>".//uraian transaksi belum ada kolom nya
                        (isset($value->daftartindakan_kode) ? $value->daftartindakan_kode." - " : "").
                        $value->daftartindakan_nama.
                    "</td>";
            echo '<td>';
                echo CHtml::textField($namaModel."[$key][saldodebit]", 
                    MyFormatter::formatNumberForPrint($value->saldodebit),
                    array(
                        'class'=>'inputFormTabel span2 integer2',
                        //'disabled'=>($status == 'debit' ? "" : "disabled"),
                        'onkeyup' => "hitungSemua();",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
            echo '<td>';
                echo CHtml::textField($namaModel."[$key][saldokredit]",
                    MyFormatter::formatNumberForPrint($value->saldokredit),
                    array(
                        'class'=>'inputFormTabel span2 integer2',
                        //'disabled'=>($status == 'kredit' ? "" : "disabled"),
                        'onkeyup' => "hitungSemua();",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    )
                );
            echo '</td>';
        echo('</tr>');
    }
}
?>