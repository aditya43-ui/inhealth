<table class="table table-bordered table-striped table-condensed" id="tabel-detail">
	<thead>
		<tr>
			<th rowspan="2">No.</th>
			<th colspan="1" rowspan="2">Kode Rekening</th>
			<th rowspan="2">Nama Rekening</th>
			<th colspan="2" style="text-align:center;">Saldo</th>
			<!--<th rowspan="2">Catatan</th>-->
		</tr>
		<tr>
			<th style="text-align:center;">Debit</th>
			<th style="text-align:center;">Kredit</th>
		</tr>
	</thead>
        <tbody>
            <?php 
            $totalDebit = 0;
            $totalKredit = 0;
                if(count((array)$modelDetail)>0){
                    foreach ($modelDetail as $i => $detail){
                        $rekeningKd = "";
                        $rekeningNm = "";
                        
                        $modRek5 = Rekening5M::model()->findByPk($detail->rekening5_id);
                        if(isset($modRek5)){
                            $rekeningKd = $modRek5->kdrekening5;
                            $rekeningNm = $modRek5->nmrekening5;
                        }
                        $totalDebit += $detail->saldodebit;
                        $totalKredit += $detail->saldokredit;
            ?>
            <tr>
                <td width="5%">
                    <?php 
                        echo CHtml::activeHiddenField($detail, "[".$i."]jurnaldetail_id", array( 'class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>false ) );
                        echo CHtml::activeTextField($detail, "[".$i."]nourut", array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true)  );            
                    ?>
                </td>
                <td width="3%">
                    <?php echo $rekeningKd; ?>
                    <?php
                        echo CHtml::activeHiddenField($detail, "[".$i."]rekening5_id", array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>false) );
                    ?>
                </td>
                <td>
                    <?php echo $rekeningNm; ?>
                </td>
                <td>
                    <?php
                        echo CHtml::activeTextField($detail, "[".$i."]saldodebit", array('class'=>'span2 float', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=> true) );
                    ?>
                </td>
                <td>
                    <?php
                        echo CHtml::activeTextField($detail, "[".$i."]saldokredit", array('class'=>'span2 float', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true) );
                    ?>
                </td>
<!--<td>
                    <?php 
//                        echo CHtml::activeTextArea($detail, "[".$i."]catatan", array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>true) );
                    ?>
                </td>-->
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
	<tfoot>
            <tr class="trfooter">
                <td colspan="3"><b>Total</b></td>
                <td>
                    <?php
                        echo CHtml::textField("totalSaldoDebit",$totalDebit,array('readonly'=>true,'class'=>'span2 float'));
                    ?>
                </td>
                <td>
                    <?php
                        echo CHtml::textField("totalSaldoKredit", $totalKredit, array('readonly'=>true,'class'=>'span2 float') );
                    ?>
                </td>
            </tr>
	</tfoot>        
</table>