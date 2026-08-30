<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<fieldset>
    <legend>Data Pembayaran</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'tglbuktibayar',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUTandabuktibayarT[tglbuktibayar]', $modBuktiBayar->tglbuktibayar, array('readonly'=>true)); ?></td>
            
            <td>
                <label class="control-label" for="noRekamMedik">No. Bukti Bayar</label>
            </td>
            <td>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'KUTandabuktibayarT[nobuktibayar]',
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
            <td><?php echo CHtml::textField('KUTandabuktibayarT[darinama_bkm]', $modBuktiBayar->darinama_bkm, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'carapembayaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUTandabuktibayarT[carapembayaran]', $modBuktiBayar->carapembayaran, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'alamat_bkm',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUTandabuktibayarT[alamat_bkm]', $modBuktiBayar->alamat_bkm, array('readonly'=>true)); ?></td>
                        
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'jmlpembayaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUTandabuktibayarT[jmlpembayaran]', $modBuktiBayar->jmlpembayaran, array('class'=>'currency','readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'biayamaterai',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUTandabuktibayarT[biayamaterai]', $modBuktiBayar->biayamaterai, array('readonly'=>true)); ?></td>
                        
            <td><?php echo CHtml::activeLabel($modBuktiBayar, 'biayaadministrasi',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('KUTandabuktibayarT[biayaadministrasi]', $modBuktiBayar->biayaadministrasi, array('class'=>'currency','readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>

<script type="text/javascript">
function isiInfoBayar(data)
{
    $('#KUTandabuktibayarT_tglbuktibayar').val(data.tglbuktibayar);
    $('#KUTandabuktibayarT_darinama_bkm').val(data.darinama_bkm);
    $('#KUTandabuktibayarT_alamat_bkm').val(data.alamat_bkm);
    $('#KUTandabuktibayarT_biayamaterai').val(data.biayamaterai);
    $('#KUTandabuktibayarT_carapembayaran').val(data.carapembayaran);
    $('#KUTandabuktibayarT_jmlpembayaran').val(data.jmlpembayaran);
    $('#KUTandabuktibayarT_biayaadministrasi').val(data.biayaadministrasi);
    
    $('#KUTandabuktibayarT_tglpenerimaan').val(data.tglpenerimaan);
    $('#KUTandabuktibayarT_kelompoktransaksi').val(data.kelompoktransaksi);
    $('#KUTandabuktibayarT_namapenandatangan').val(data.namapenandatangan);
    $('#KUTandabuktibayarT_nopenerimaan').val(data.nopenerimaan);
    $('#KUTandabuktibayarT_hargasatuan').val(data.hargasatuan);
    $('#KUTandabuktibayarT_totalharga').val(data.totalharga);
    
    $('#KUReturPenerimaanUmumT_penerimaanumum_id').val(data.penerimaanumum_id);
    $('#KUReturPenerimaanUmumT_tandabuktibayar_id').val(data.tandabuktibayar_id);
    
    $('#KUTandabuktikeluarT_biayaadministrasi').val(0);
    $('#KUTandabuktikeluarT_jmlkaskeluar').val(data.totalharga);
    $('#KUTandabuktikeluarT_namapenerima').val(data.darinama_bkm);
    $('#KUTandabuktikeluarT_alamatpenerima').val(data.alamat_bkm);
    $('.currency').each(function(){this.value = formatNumber(this.value)});
}
</script>
