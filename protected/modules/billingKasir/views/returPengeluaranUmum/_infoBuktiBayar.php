<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<fieldset>
    <legend>Data Pembayaran</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'tglbuktibayar',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKTandabuktibayarT[tglbuktibayar]', $modBuktiBayar->tglbuktibayar, array('readonly'=>true)); ?></td>
            
            <td>
                <label class="control-label" for="noRekamMedik">No. Bukti Bayar</label>
            </td>
            <td>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'BKTandabuktibayarT[nobuktibayar]',
                                    'value'=>$modBuktiBayar->nobuktibayar,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/infoBuktiBayar').'",
                                                       dataType: "json",
                                                       data: {
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
                                )); 
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'darinama_bkm',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKTandabuktibayarT[darinama_bkm]', $modBuktiBayar->darinama_bkm, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'carapembayaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKTandabuktibayarT[carapembayaran]', $modBuktiBayar->carapembayaran, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'alamat_bkm',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKTandabuktibayarT[alamat_bkm]', $modBuktiBayar->alamat_bkm, array('readonly'=>true)); ?></td>
                        
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'jmlpembayaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKTandabuktibayarT[jmlpembayaran]', $modBuktiBayar->jmlpembayaran, array('class'=>'currency','readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'biayamaterai',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKTandabuktibayarT[biayamaterai]', $modBuktiBayar->biayamaterai, array('readonly'=>true)); ?></td>
                        
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'biayaadministrasi',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKTandabuktibayarT[biayaadministrasi]', $modBuktiBayar->biayaadministrasi, array('class'=>'currency','readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>

<script type="text/javascript">
function isiInfoBayar(data)
{
    $('#BKTandabuktibayarT_tglbuktibayar').val(data.tglbuktibayar);
    $('#BKTandabuktibayarT_darinama_bkm').val(data.darinama_bkm);
    $('#BKTandabuktibayarT_alamat_bkm').val(data.alamat_bkm);
    $('#BKTandabuktibayarT_biayamaterai').val(data.biayamaterai);
    $('#BKTandabuktibayarT_carapembayaran').val(data.carapembayaran);
    $('#BKTandabuktibayarT_jmlpembayaran').val(data.jmlpembayaran);
    $('#BKTandabuktibayarT_biayaadministrasi').val(data.biayaadministrasi);
    
    $('#BKTandabuktibayarT_tglpenerimaan').val(data.tglpenerimaan);
    $('#BKTandabuktibayarT_kelompoktransaksi').val(data.kelompoktransaksi);
    $('#BKTandabuktibayarT_namapenandatangan').val(data.namapenandatangan);
    $('#BKTandabuktibayarT_nopenerimaan').val(data.nopenerimaan);
    $('#BKTandabuktibayarT_hargasatuan').val(data.hargasatuan);
    $('#BKTandabuktibayarT_totalharga').val(data.totalharga);
    
    $('#BKReturPenerimaanUmumT_penerimaanumum_id').val(data.penerimaanumum_id);
    $('#BKReturPenerimaanUmumT_tandabuktibayar_id').val(data.tandabuktibayar_id);
    
    $('#BKTandabuktikeluarT_biayaadministrasi').val(0);
    $('#BKTandabuktikeluarT_jmlkaskeluar').val(data.totalharga);
    $('#BKTandabuktikeluarT_namapenerima').val(data.darinama_bkm);
    $('#BKTandabuktikeluarT_alamatpenerima').val(data.alamat_bkm);
    $('.currency').each(function(){this.value = formatNumber(this.value)});
}
</script>
