<fieldset>
    <legend>Data Pembayaran</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'tglbuktibayar',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('AKTandabuktibayarT[tglbuktibayar]', $modBuktiBayar->tglbuktibayar, array('readonly'=>true)); ?></td>
            
            <td>
                <label class="control-label" for="noRekamMedik">No. Bukti Bayar</label>
            </td>
            <td>
                <?php 
                    $this->widget('MyJuiAutoComplete',
                        array(
                            'name'=>'AKTandabuktibayarT[nobuktibayar]',
                            'value'=>$modBuktiBayar->nobuktibayar,
                            'source'=>'js: function(request, response){
                               $.ajax({
                                   url: "'. Yii::app()->createUrl('billingKasir/ActionAutoComplete/infoBuktiBayar') .'",
                                   dataType: "json",
                                   data:{
                                    term: request.term,
                                   },
                                   success: function (data) {
                                    response(data);
                                   }
                               })
                            }',
                            'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        return false;
                                    }',
                                   'select'=>'js:function( event, ui ) {
                                       isiInfoBayar(ui.item);
                                        return false;
                                    }',
                            ),
                        )
                    ); 
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'darinama_bkm',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('AKTandabuktibayarT[darinama_bkm]', $modBuktiBayar->darinama_bkm, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'carapembayaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('AKTandabuktibayarT[carapembayaran]', $modBuktiBayar->carapembayaran, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'alamat_bkm',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('AKTandabuktibayarT[alamat_bkm]', $modBuktiBayar->alamat_bkm, array('readonly'=>true)); ?></td>
                        
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'jmlpembayaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('AKTandabuktibayarT[jmlpembayaran]', $modBuktiBayar->jmlpembayaran, array('class'=>'currency','readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'biayamaterai',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('AKTandabuktibayarT[biayamaterai]', $modBuktiBayar->biayamaterai, array('readonly'=>true)); ?></td>
                        
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'biayaadministrasi',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('AKTandabuktibayarT[biayaadministrasi]', $modBuktiBayar->biayaadministrasi, array('class'=>'currency','readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>
<script type="text/javascript">
function isiInfoBayar(data)
{
    $('#AKTandabuktibayarT_tglbuktibayar').val(data.tglbuktibayar);
    $('#AKTandabuktibayarT_darinama_bkm').val(data.darinama_bkm);
    $('#AKTandabuktibayarT_alamat_bkm').val(data.alamat_bkm);
    $('#AKTandabuktibayarT_biayamaterai').val(data.biayamaterai);
    $('#AKTandabuktibayarT_carapembayaran').val(data.carapembayaran);
    $('#AKTandabuktibayarT_jmlpembayaran').val(data.jmlpembayaran);
    $('#AKTandabuktibayarT_biayaadministrasi').val(data.biayaadministrasi);
    
    $('#AKTandabuktibayarT_tglpenerimaan').val(data.tglpenerimaan);
    $('#AKTandabuktibayarT_kelompoktransaksi').val(data.kelompoktransaksi);
    $('#AKTandabuktibayarT_namapenandatangan').val(data.namapenandatangan);
    $('#AKTandabuktibayarT_nopenerimaan').val(data.nopenerimaan);
    $('#AKTandabuktibayarT_hargasatuan').val(data.hargasatuan);
    $('#AKTandabuktibayarT_totalharga').val(data.totalharga);
    
    $('#AKReturPenerimaanUmumT_penerimaanumum_id').val(data.penerimaanumum_id);
    $('#AKReturPenerimaanUmumT_tandabuktibayar_id').val(data.tandabuktibayar_id);
    
    $('#AKTandabuktikeluarT_biayaadministrasi').val(0);
    $('#AKTandabuktikeluarT_jmlkaskeluar').val(data.totalharga);
    $('#AKTandabuktikeluarT_namapenerima').val(data.darinama_bkm);
    $('#AKTandabuktikeluarT_alamatpenerima').val(data.alamat_bkm);
    $('.currency').each(function(){this.value = formatNumber(this.value)});
}
</script>
