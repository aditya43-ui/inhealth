<table class="table table-bordered table-striped table-condensed">
    <thead>
        <th width="60px">Retur <?php echo CHtml::checkBox('is_pilihsemuaoa',true,array('onchange'=>'setPilihOaChecked();','rel'=>'tooltip','title'=>'Centang untuk pilih semua obat dan alkes','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></th>
        <th>No. </th>
        <th width="50%">Deskripsi Obat dan Alkes</th>
        <th width="128px">Harga Satuan (Rp)</th>
        <th>Jumlah Jual</th>
        <th>Jumlah Retur</th>
        <th>Satuan</th>
        <th>Kondisi Obat</th>
        <th width="320px">Subtotal Retur (Rp)</th>
    </thead>
    <tbody>
        <?php
        $format = new MyFormatter();
        $total_oa = 0;
        $tot_biayalain = 0; //dari penjualanresep_t
        $total_retur = 0;
        $subtotaloa = 0;
        $tampilheader = false;
        if(count((array)$dataOas) > 0){
            foreach($dataOas AS $i =>$obatalkes){
                $modDetails = new FAReturresepdetT;
                $modDetails->obatalkespasien_id = $obatalkes->obatalkespasien_id;
                $modDetails->qty_retur = $obatalkes->qty_oa;
                $modDetails->hargasatuan = $obatalkes->hargasatuan_oa;
                $modDetails->satuankecil_id = $obatalkes->satuankecil_id;
                $modDetails->pilihObat = true;
//                $obatalkes->tglpelayanan = $format->formatDateTimeForUser($obatalkes->tglpelayanan);
                $subtotal = ($obatalkes->qty_oa*$obatalkes->hargasatuan_oa);
                $total_oa += round($subtotal,2);
                $total_retur = $total_oa;
                $obatalkes->qty_oa = $format->formatNumberForPrint($obatalkes->qty_oa);
                $modDetails->qty_retur = $format->formatNumberForPrint($modDetails->qty_retur);
                $modDetails->hargasatuan = $format->formatNumberForPrint($modDetails->hargasatuan);
                $subtotal = $format->formatNumberForPrint($subtotal);
                //header group
                if($i == 0){
                    $tampilheader = true;
                }else{
                    if($obatalkes->penjualanresep_id !== $dataOas[$i-1]->penjualanresep_id){
                        $tampilheader = true;
                    }else{
                        $tampilheader = false;
                    }
                }
                if($tampilheader){
                    echo '<tr bgcolor="#DDD">'
                        .'<td>'.CHtml::checkBox('returperresep_'.$i,1,array('penjualanresep_id'=>$obatalkes->penjualanresep_id,'onchange'=>'setPilihResepOaChecked(this);hitungTotalOa();','class'=>'pilihperresep','onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td colspan="8"><b>'.$obatalkes->penjualanresep->noresep.' - '.  MyFormatter::formatDateTimeForUser($obatalkes->penjualanresep->tglresep).' - '.$obatalkes->penjualanresep->carabayar->carabayar_nama.' - '.$obatalkes->penjualanresep->penjamin->penjamin_nama.'</b></td>'
                        .'</tr>';
                }
				//detail
                echo '<tr>'
                        .'<td>'.CHtml::activeCheckBox($modDetails, '['.$i.']pilihObat',array('penjualanresep_id'=>$obatalkes->penjualanresep_id, 'onchange'=>'hitungTotalOa();','onkeyup'=>"return $(this).focusNextInputField(event);"))  
                        .CHtml::activeHiddenField($modDetails, '['.$i.']obatalkespasien_id',array('readonly'=>true, 'class'=>'span1'))  
                        .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkes_id',array('readonly'=>true, 'class'=>'span1'))  
                        .CHtml::activeHiddenField($modDetails, '['.$i.']satuankecil_id',array('readonly'=>true, 'class'=>'span1'))  
                        .'</td>'
                        .'<td>'.($i+1).'</td>'
                        .'<td>'//.$modDetails->obatpasien->obatalkes->obatalkes_kode.' - '
                        .$modDetails->obatpasien->obatalkes->obatalkes_nama.'</td>'
                        .'<td>'.CHtml::activeTextField($modDetails, '['.$i.']hargasatuan',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']qty_oa',array('readonly'=>true,'class'=>'inputFormTabel lebar1 integer2', 'style'=>'width:60px','onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($modDetails, '['.$i.']qty_retur',array('onblur'=>'cekQtyRetur(this);hitungTotalOa();','class'=>'inputFormTabel lebar1 qty', 'style'=>'width:60px', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.$modDetails->obatpasien->satuankecil->satuankecil_nama.'</td>'
                        .'<td>'.CHtml::activeTextField($modDetails, '['.$i.']kondisibrg',array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::textField('subtotal',$subtotal,array('style'=>'width:100px','readonly'=>true,'class'=>'inputFormTabel lebar3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                    .'</tr>';
            }
        }
        ?>
    </tbody>
    <tfoot>
        <?php
        //formatting total
        $tot_biayalain = $format->formatNumberForPrint($tot_biayalain);
        $total_oa = $format->formatNumberForPrint($total_oa);
        $model->totalretur = $format->formatNumberForPrint($total_retur);
        ?>
        <tr>
            <td colspan="8" style="text-align: right; font-weight: bold;"> Total Penjualan</td>
            <td><?php echo CHtml::textField('total_oa',$total_oa,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','style'=>'width:100px','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        </tr>
<!--<tr>
            <td colspan="8" style="text-align: right; font-weight: bold;"> Biaya Administrasi + Tarif Service + Konseling + Jasa Dokter</td>
            <td><?php // echo CHtml::textField('tot_biayalain',$tot_biayalain,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','style'=>'width:100px','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        </tr>-->
        <tr>
            <td colspan="8" style="text-align: right; font-weight: bold;"> Total Retur</td>
            <td><?php echo CHtml::activeTextField($model,'totalretur',array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer2','style'=>'width:100px','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        </tr>
    </tfoot>
</table>

