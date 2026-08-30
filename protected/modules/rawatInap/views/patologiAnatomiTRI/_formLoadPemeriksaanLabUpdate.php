<?php
/**
 * menegenerate data perbaris pada tabel tarif
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
$periksa = PemeriksaanlabM::model()->findByPk($item->pemeriksaanlab_id);
$jenis = JenispemeriksaanlabM::model()->findByPk(($periksa->jenispemeriksaanlab_id));
$modul = Yii::app()->user->getState('modul_id');

// var_dump($jenis->attributes); die;

// var_dump($item->attributes); die;

$tarif = (!empty($item->tarif_pelayananan)) ? $item->tarif_pelayananan : 0;

if($tarif>0){
?>
<tr id="periksalab_<?php echo $item->pemeriksaanlab_id; ?>">
    <?php if($jenis->jenispemeriksaanlab_kelompok == Params::PATOLOGI_KLINIK){ ?>
    <td>
        <?php echo $jenis->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $item->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[tindakanpelayanan_id][]", $id_tindakan); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[ruanganID][]", $item->ruangan_id, array('class' => 'idruangan')); ?>
    </td>
    <td>
        <?php echo $periksa->pemeriksaanlab_nama; ?>
        <?php echo CHtml::HiddenField("permintaanPenunjang[inputpemeriksaanlab][]", $item->pemeriksaanlab_id,array('class'=>'inputFormTabel  idpemeriksaanlab','readonly'=>true)); ?>
    </td>

    <?php
        if(in_array($modul, array(Params::MODUL_ID_RJ, Params::MODUL_ID_RD))) {
            echo '<td>';
            echo CHtml::hiddenField("permintaanPenunjang[samplelab_id][]", $sample->samplelab_id, array('class'=>'inputFormTabel samplelab_id','readonly'=>true));
            echo $sample->samplelab_nama;
            echo '</td>';
        }
    ?>
    
    <td><?php 
    echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('style'=>'text-align:right','class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal();',)); 
    echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('style'=>'text-align:right','class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true));
    ?></td>
    <!-- <td >
        <?php //echo $tarif; ?>
        <?php //echo CHtml::textField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('style'=>'text-align:right','class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td> -->
    <?php }else{ 
        
        // var_dump($item->attributes); die;
        ?>
    
    <td>
        <?php echo $jenis->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[idDaftarTindakan][]", $item->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $periksa->pemeriksaanlab_nama; ?>
        <?php echo CHtml::HiddenField("permintaanPenunjangAnatomi[inputpemeriksaanlab][]", $item->pemeriksaanlab_id,array('class'=>'inputFormTabel idpemeriksaanlab','readonly'=>true)); ?>
    </td>

    <?php
        if(in_array($modul, array(Params::MODUL_ID_RJ, Params::MODUL_ID_RD))) {
            echo '<td>';
            echo CHtml::hiddenField("permintaanPenunjangAnatomi[samplelab_id][]", $sample->samplelab_id, array('class'=>'inputFormTabel samplelab_id','readonly'=>true));
            echo $sample->samplelab_nama;
            echo '</td>';
        }
    ?>
    
    <td><?php 
    echo CHtml::textField("permintaanPenunjangAnatomi[inputqty][]", '1',array('style'=>'text-align:right','class'=>'inputFormTabel lebar1 integer gty  span1', 'onkeyup'=>'hitungTotal();',)); 
    echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('style'=>'text-align:right','class'=>'inputFormTabel lebar3 integer tarif_satuan span1','readonly'=>true));
    ?></td>
    <!-- <td>
        <?php //echo $tarif; ?>
        <?php //echo CHtml::textField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('style'=>'text-align:right','class'=>'inputFormTabel lebar3 integer tarif_satuan span1','readonly'=>true)); ?>
    </td> -->
    <?php } ?>

</tr>
<?php } ?>
