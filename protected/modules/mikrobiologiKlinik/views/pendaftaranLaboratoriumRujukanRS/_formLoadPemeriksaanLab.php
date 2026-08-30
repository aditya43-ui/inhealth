<?php
/**
 * untuk mengenerate data perbari apda tabel tarif
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
    <td>
        <?php echo CHtml::textField('no_urut', isset($key)? $key : 0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:30px;')); ?>
    </td>
    <td>
        <?php echo $modTarif->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[permintaankepenunjang_id][]", $permintaankepenunjang_id,array('class'=>'inputFormTabel permintaankepenunjang_id','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modTarif->daftartindakan_id,array('class'=>'inputFormTabel idDaftarTindakan','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[tindakanpelayanan_id][]", $id_tindakan); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[ruanganID][]", $modTarif->ruangan_id, array('class' => 'idruangan')); ?>
    </td>
    <td>
        <?php 
        echo $modTarif->pemeriksaanlab_nama; 
        if (!empty($paket)) {
            echo '</br>('.$paket->tipepaket_nama.')';
        }
        ?>
        <?php echo CHtml::HiddenField("permintaanPenunjang[inputpemeriksaanlab][]", $modTarif->pemeriksaanlab_id,array('class'=>'inputFormTabel idpemeriksaanlab','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('readonly'=>!empty($permintaankepenunjang_id),'class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal();',)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td>
        Kali
    </td>
<?php } ?>
