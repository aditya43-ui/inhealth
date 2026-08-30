<table id="tblReturResepDetail" class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th><?php echo CHtml::checkBox('retur_semua', false, array('onchange'=>'cekReturSemua();')); ?>Retur</th>
            <th>No.</th>
            <th>Obat</th>
            <th>Harga Satuan</th>
            <th>Jumlah Jual</th>
            <th>Jumlah Retur</th>
            <?php echo !empty($modReturDetail[0]->returresepdet_id) ?  "<th>Jumlah Setelah Retur</th>" : "";?>
            <th>Satuan</th>
            <th>Kondisi Obat</th>
            <th>Sub Total Retur</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $subTotal = 0;
        $totalSubTotal = 0;
        if (empty($modReturDetail[0]->returresepdet_id)){
            foreach ($modObatAlkesPasien as $i => $mod) {?>
                <tr>
                    <td><?php echo CHtml::checkBox('FAReturresepdetT['.$i.'][isRetur]', true, array('class'=>'isRetur','onclick'=>'setNullQty(this);hitungTabel();','onKeypress'=>'return formSubmit(this,event)')) ?></td>
                    <td>
                        <?php echo ($i+1);?>
                        <?php echo CHtml::hiddenField('FAReturresepdetT['.$i.'][obatalkespasien_id]', $mod->obatalkespasien_id);?>
                        <?php echo CHtml::hiddenField('FAReturresepdetT['.$i.'][obatalkes_id]', $mod->obatalkes_id);?>
                        <?php echo CHtml::hiddenField('FAReturresepdetT['.$i.'][satuankecil_id]', $mod->satuankecil_id);?>
                    </td>
                    <td><?php echo $mod->obatalkes->obatalkes_kode." - ".$mod->obatalkes->obatalkes_nama; ?>
                    </td>
                    <td><?php echo CHtml::textField('FAReturresepdetT['.$i.'][hargasatuan]', MyFormatter::formatNumberForPrint($mod->hargasatuan_oa), array('class'=>'span2 integer2 harga', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
                    <td><?php echo CHtml::textField('qty_oa', $mod->qty_oa, array('class'=>'span1 integer2', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
                    <td><?php echo CHtml::textField('FAReturresepdetT['.$i.'][qty_retur]', $mod->qty_oa, array('class'=>'span1 integer2 qty', 'style'=>'text-align:right;', 'onkeyup'=>'validasiQty(this); hitungTabel();', 'onKeypress'=>'return formSubmit(this,event)'));?></td>
                    <td><?php echo $mod->satuankecil->satuankecil_nama;?></td>
                    <td><?php echo CHtml::textField('FAReturresepdetT['.$i.'][kondisibrg]', '', array('class'=>'span2'));?></td>
                    <td>
                        <?php
                            $subTotal = $mod->qty_oa * $mod->hargasatuan_oa;
                            $totalSubTotal += $subTotal;
                            echo CHtml::textField('subtotal', MyFormatter::formatNumberForPrint($subTotal), array('class'=>'span2 integer2 subtotal', 'style'=>'text-align:right;', 'readonly'=>true));
                        ?>
                    </td>
                </tr>
        <?php } ?> 
        <tr>
            <td colspan="8" style="text-align: right;"><b>Total</b></td>
            <td><?php echo CHtml::textField('total', MyFormatter::formatNumberForPrint($totalSubTotal), array('class'=>'span2 integer2 total', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
        </tr>
        <tr hidden>
            <td colspan="8" style="text-align: right;"><b>Biaya Administrasi + Tarif Service + Konseling + Jasa Dokter</b></td>
            <td><?php 
                $biayaAdmin = $modPenjualanResep->totaltarifservice + $modPenjualanResep->biayaadministrasi + $modPenjualanResep->biayakonseling ;//+ $modPenjualanResep->jasadokterresep <<< SDH TERMASUK DLM HARGA OBAT
                echo CHtml::textField('biayaAdministrasi', MyFormatter::formatNumberForPrint($biayaAdmin), array('class'=>'span2 integer2 totalAdmin', 'style'=>'text-align:right;', 'readonly'=>true));
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: right;"><b>Total Retur</b></td>
            <td><?php 
                $totalRetur = $totalSubTotal + $biayaAdmin;
                echo CHtml::textField('FAReturresepT[totalretur]', MyFormatter::formatNumberForPrint($totalRetur), array('class'=>'span2 integer2 totalRetur', 'style'=>'text-align:right;', 'readonly'=>true));
                ?>
            </td>
        </tr>
        <?php }
        else if(!empty($modReturDetail[0]->returresepdet_id)){
            foreach ($modReturDetail as $i => $mod) {
            ?>
            <tr>
                <td><?php echo CHtml::checkBox('FAReturresepdetT['.$i.'][isRetur]', true, array('readonly'=>true)) ?></td>
                <td><?php echo ($i+1);?></td>
                <td><?php echo $mod->obatpasien->obatalkes->obatalkes_kode." - ".$mod->obatpasien->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo MyFormatter::formatNumberForPrint($mod->hargasatuan);?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($mod->obatpasien->qty_oa + $mod->qty_retur); //Ditambah karena kuantiti di obatalkespasie berkurang saat proses retur?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($mod->qty_retur); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($mod->obatpasien->qty_oa); ?></td>
                <td><?php echo $mod->obatpasien->satuankecil->satuankecil_nama;?></td>
                <td><?php echo $mod->kondisibrg;?></td>
                <td>
                    <?php
                        $subTotal = MyFormatter::formatNumberForPrint($mod->qty_retur,0,'','') * MyFormatter::formatNumberForPrint($mod->hargasatuan,0,'','');
                        $totalSubTotal += $subTotal;
                        echo MyFormatter::formatNumberForPrint($subTotal,0,'','.');
                    ?>
                </td>
            </tr>
            
        <?php
            } ?>
            <tr>
                <td colspan="9" style="text-align: right;"><b>Biaya Administrasi, dll</b></td>
                <td><?php 
                    echo MyFormatter::formatNumberForPrint($modRetur->totalretur - $totalSubTotal); 
                ?></td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: right;"><b>Total Retur</b></td>
                <td><?php echo MyFormatter::formatNumberForPrint($modRetur->totalretur,0,'','.'); ?></td>
            </tr>
        <?php }
        else{
            echo '<tr><td colspan=9><i>Data Obat Alkes tidak ditemukan</></td></tr>';
        }
        ?>
    </tbody>
</table>
<script>
    function hitungTabel(){
        var total = 0;
        var totalRetur = 0;
        var harga = 0;
        var qty = 0;
        $('#tblReturResepDetail tbody').find('tr').each(
            function(){
                if($(this).find('.isRetur').is(':checked') == true){
                    var harga = unformatNumber($(this).find('.harga').val());
                    var qty = unformatNumber($(this).find('.qty').val());
                }
                var subtotal = harga * qty;
                total += unformatNumber(subtotal);
                $(this).find('.subtotal').val(formatNumber(subtotal));
                $(this).find('.total').val(formatNumber(total));
            }
        );
        hitungTotalRetur();
    }
    function hitungTotalRetur(){
        var totalRetur = unformatNumber($('#biayaAdministrasi').val()) + unformatNumber($('#total').val());
        $('#FAReturresepT_totalretur').val(formatNumber(totalRetur));
    }
    function validasiQty(obj){
        var qty_oa = 0;
        qty_oa = unformatNumber($(obj).parent().parent().find('#qty_oa').val());
        if($(obj).val() > qty_oa){
            myAlert("Jumlah Retur Tidak boleh lebih besar dari qty "+qty_oa+"!");
            $(obj).val(qty_oa);
        } else if ($(obj).val() == 0) {
            myAlert("Jumlah Retur Tidak boleh 0!");
            $(obj).val(qty_oa);
        }
    }
    function setNullQty(obj){
        if($(obj).is(':checked') == false){
            $(obj).parent().parent().find('.qty').val(0);
        }else{
            var qty_oa = $(obj).parent().parent().find('#qty_oa').val();
            $(obj).parent().parent().find('.qty').val(qty_oa);
        }
    }
    
    function cekReturSemua() {
        $(".isRetur").each(function(data) {
            $(this).prop("checked", $("#retur_semua").is(":checked"));
            setNullQty(this);hitungTabel();
        });
    }
    
    
    $(document).ready(function() {
        cekReturSemua();
    });
</script>