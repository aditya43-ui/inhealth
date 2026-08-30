<?php
/**
 * menegenerate data perbaris pada tabel tarif
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;

if($tarif>0){
?>
<tr id="periksalab_<?php echo $modTarif->pemeriksaanlab_id; ?>">
    <?php if($modTarif->jenispemeriksaanlab_kelompok == Params::PATOLOGI_KLINIK){ ?>
    <td>
        <?php echo $modTarif->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modTarif->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[tindakanpelayanan_id][]", $id_tindakan); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[ruanganID][]", $modTarif->ruangan_id, array('class' => 'idruangan')); ?>
    </td>
    <td>
        <?php echo $modTarif->pemeriksaanlab_nama; ?>
        <?php echo CHtml::HiddenField("permintaanPenunjang[inputpemeriksaanlab][]", $modTarif->pemeriksaanlab_id,array('class'=>'inputFormTabel  idpemeriksaanlab','readonly'=>true)); ?>
    </td>
    
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('style'=>'text-align:right','class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal();',)); ?></td>
    <td >
        <?php //echo $tarif; ?>
        <?php echo CHtml::textField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('style'=>'text-align:right','class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <?php }else{ ?>
    
    <td>
        <?php echo $modTarif->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[idDaftarTindakan][]", $modTarif->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $modTarif->pemeriksaanlab_nama; ?>
        <?php echo CHtml::HiddenField("permintaanPenunjangAnatomi[inputpemeriksaanlab][]", $modTarif->pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    
    <td><?php echo CHtml::textField("permintaanPenunjangAnatomi[inputqty][]", '1',array('style'=>'text-align:right','class'=>'inputFormTabel lebar1 integer gty  span1', 'onkeyup'=>'hitungTotal();',)); ?></td>
    <td>
        <?php //echo $tarif; ?>
        <?php echo CHtml::textField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('style'=>'text-align:right','class'=>'inputFormTabel lebar3 integer tarif_satuan span1','readonly'=>true)); ?>
    </td>
    <?php } ?>

</tr>
<?php } ?>
