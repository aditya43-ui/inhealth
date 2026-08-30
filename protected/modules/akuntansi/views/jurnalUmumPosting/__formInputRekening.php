<?php
    $i = 99;
?>
<tr>
    <td width="5%">
        <span name="AKJurnaldetailT[99][nourut_ex]">1</span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[$i]jurnaldetail_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
            echo $form->hiddenField(
                $modelJurDetail,
                "[$i]nourut",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );            
        ?>
    </td>
    <td width="15%">
        <?php
            echo $form->textField(
                $modelJurDetail,
                "[$i]uraiantransaksi",
                array(
                    'class'=>'span3',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[99][kdstruktur]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[$i]rekening1_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>                
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[99][kdkelompok]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[$i]rekening2_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[99][kdjenis]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[$i]rekening3_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>                
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[99][kdobyek]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[$i]rekening4_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[99][kdrincianobyek]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[$i]rekening5_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td>
        <span name="AKJurnaldetailT[99][nmrincianobyek]"></span>
    </td>
    <td>
        <?php
            echo $form->textField(
                $modelJurDetail,
                "[$i]saldodebit",
                array(
                    'value'=>0,
                    'class'=>'span2 currency',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'onkeyup'=>"hitungTotalUang()",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td>
        <?php
            echo $form->textField(
                $modelJurDetail,
                "[$i]saldokredit",
                array(
                    'value'=>0,
                    'class'=>'span2 currency',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'onkeyup'=>"hitungTotalUang()",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td>
        <?php 
            echo $form->textArea(
                    $modelJurDetail,
                    "[$i]catatan",
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