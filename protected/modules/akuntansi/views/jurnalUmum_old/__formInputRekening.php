<tr>
    <td width="5%">
        <span name="AKJurnaldetailT[ii][nourut_ex]">1</span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[ii]jurnaldetail_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
            echo $form->hiddenField(
                $modelJurDetail,
                "[ii]nourut",
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
                "[ii]uraiantransaksi",
                array(
                    'class'=>'span3 reqForm',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[ii][kdstruktur]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[ii]rekening1_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>                
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[ii][kdkelompok]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[ii]rekening2_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[ii][kdjenis]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[ii]rekening3_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>                
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[ii][kdobyek]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
                "[ii]rekening4_id",
                array(
                    'class'=>'span1',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'readonly'=>false
                )
            );
        ?>
    </td>
    <td width="3%">
        <span name="AKJurnaldetailT[ii][kdrincianobyek]"></span>
        <?php
            echo $form->hiddenField(
                $modelJurDetail,
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
        <span name="AKJurnaldetailT[ii][nmrincianobyek]"></span>
    </td>
    <td>
        <?php
            echo $form->textField(
                $modelJurDetail,
                "[ii]saldodebit",
                array(
                    'value'=>0,
                    'class'=>'span2 integer',
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
                "[ii]saldokredit",
                array(
                    'value'=>0,
                    'class'=>'span2 integer',
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