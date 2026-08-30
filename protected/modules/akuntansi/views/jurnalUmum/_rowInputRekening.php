<tr>
    <td width="5%">
        <?php
            echo CHtml::activeHiddenField(
                $modJurnaldetail,
                "[ii]jurnaldetail_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
            echo CHtml::activeTextField(
                $modJurnaldetail,
                "[ii]nourut",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>true
                )
            );            
        ?>
    </td>
    <?php /*
    <td width="15%">
        <?php
            echo CHtml::activeTextField(
                $modJurnaldetail,
                "[ii]uraiantransaksi",
                array(
                    'class'=>'span3 required',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
     * 
     */ ?>
    <td width="3%" hidden>
        <span name="AKJurnaldetailT[ii][kdrekening1]"><?php echo $modJurnaldetail->kdrekening1; ?></span>
        <?php
            echo CHtml::activeHiddenField(
                $modJurnaldetail,
                "[ii]rekening1_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>                
    </td>
    <td width="3%" hidden>
        <span name="AKJurnaldetailT[ii][kdrekening2]"><?php echo $modJurnaldetail->kdrekening2; ?></span>
        <?php
            echo CHtml::activeHiddenField(
                $modJurnaldetail,	
                "[ii]rekening2_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td width="3%" hidden>
        <span name="AKJurnaldetailT[ii][kdrekening3]"><?php echo $modJurnaldetail->kdrekening3; ?></span>
        <?php
            echo CHtml::activeHiddenField(
                $modJurnaldetail,
                "[ii]rekening3_id",
                array(
                    'class'=>'kdrekening3',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>                
    </td>
    <td width="3%" hidden>
        <span name="AKJurnaldetailT[ii][kdrekening4]"><?php echo $modJurnaldetail->kdrekening4; ?></span>
        <?php
            echo CHtml::activeHiddenField(
                $modJurnaldetail,
                "[ii]kdrekening4",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[ii][kdrekening5]"><?php echo $modJurnaldetail->kdrekening5; ?></span>
        <?php
            echo CHtml::activeHiddenField(
                $modJurnaldetail,
                "[ii]rekening5_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td>
        <span name="AKJurnaldetailT[ii][nmrekening5]"><?php echo $modJurnaldetail->nmrekening5; ?></span>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField(
                $modJurnaldetail,
                "[ii]saldodebit",
                array(
                    'value'=>'0,00',
                    'class'=>'span2 integerFloat',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'onkeyup'=>"hitungTotalUang()",
                    'readonly'=>($status == 'Debit') ? false : true,
                )
            );
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField(
                $modJurnaldetail,
                "[ii]saldokredit",
                array(
                    'value'=>'0,00',
                    'class'=>'span2 integerFloat',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'onkeyup'=>"hitungTotalUang()",
                    'readonly'=>($status == 'Kredit') ? false : true,
                )
            );
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextArea(
                    $modJurnaldetail,
                    "[ii]catatan",
                    array(
                        'class'=>'span2',
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'maxlength'=>32,
                        'readonly'=>false)
            );
        ?>
    </td>
    <td>
        <?php
            echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'batalInputJurnal(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
        ?>
    </td>
</tr>