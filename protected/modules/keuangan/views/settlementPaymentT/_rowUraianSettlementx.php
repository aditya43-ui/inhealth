<?php 
$removeButton = '';
foreach ($modSettlementPaymentDetail as $i => $uraian) { ?>
<tr class="<?php echo ($removeButton == true ? "child" : "") ?>">
    
    <td>
    <div class="input-append">
        <?php 
            $uraian->tgltransaksi = MyFormatter::formatDateTimeForUser($uraian->tgltransaksi);
            echo CHtml::activeTextField($uraian, "[$i]tgltransaksi", array('readonly'=>true,'class'=>'tanggal dtPicker2 realtime', 'style'=>'float:left;','value'=>  MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')),'onchange'=>'setDate(this)')); 
        ?>
        <span class="add-on"><i class="icon-calendar"></i><i class="icon-time"></i></span></div>
    </td>
    <td>
    <?php echo CHtml::activeHiddenField($uraian, "[$i]jenispengeluaran_id", array('readonly'=>true,'class'=>'inputFormTabel daftartindakan_id')) ?>
  <?php
        // echo $form->hiddenField($model,'jenispengeluaran_id',array('readonly'=>true, 'class'=>'required'));
        $this->widget('MyJuiAutoComplete', array(
                'model' => $uraian,
                'attribute' => "[$i]jenispengeluaran_nama",
                'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/JenisPengeluaran'),
                'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.jenispenerimaan);
                                        return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                          setPengeluaran($(this), ui.item);
                                        return false;
                            }'
                ),
                'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder'=>'Ketikan Jenis Pengeluaran',
                        'class'=>'span3 required',
                        // 'style'=>'width:150px;',
                ),
                'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran','idTombol'=>'tombolPenjaminPasien'),
        ));
    ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[$i]volume",array('onkeyup'=>'hitungTotalUraian(this)','class'=>'inputFormTabel span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[$i]hargasatuan",array('onkeyup'=>'hitungTotalUraian(this)','class'=>'inputFormTabel span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[$i]totalharga",array('readonly'=>true,'class'=>'inputFormTabel span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 
            if($removeButton || $i>0){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian')); 
                echo "&nbsp;&nbsp;";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalUraian(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian'));
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalUraian(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian'));
                
            }
        ?>
    </td>
</tr>
<?php } ?>

