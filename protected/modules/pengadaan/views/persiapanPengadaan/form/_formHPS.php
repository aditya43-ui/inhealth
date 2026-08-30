<?php
/** 
 * form HPS
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
?>
<table class="table table-condensed table-bordered table-striped" id="tabel-hps">
    <thead>
        <th>No.</th>        
        <th>Jenis Barang/Jasa</th>
        <th>Satuan</th>
        <th>Volume<span class="required">*</span></th>
        <th>Harga (Rp)<span class="required">*</span></th>
        <th>Pajak (%)<span class="required">*</span></th>
        <th>Jumlah Harga (Rp)<span class="required">*</span></th>
        <th class="hide <?php echo (!empty($model->persiapanpengadaan_id))?'hide':''; ?>">Aksi</th>
    </thead>
    <tbody>
        <?php
            if (!empty($modDet)){
                foreach($modDet as $i => $d){                  
                    $d->persiapanpengadaandet_volume = MyFormatter::formatNumberForPrint($d->persiapanpengadaandet_volume,2);
                    $d->pajak_persen = MyFormatter::formatNumberForPrint($d->pajak_persen,2);
                    echo $this->renderPartial($this->path_view.'form/_rowHPS',array('model'=>$d, 'i'=>$i),true);
                }
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align: right;"><label>Total Harga</label></th>
            <th>
                <?php 
                    echo CHtml::activeHiddenField($model, 'total_harga', array('readonly' => true,'class' => 'required integer-decimal')); 
                    echo CHtml::activeHiddenField($model, 'total_pajak', array('readonly' => true,'class' => 'required integer-decimal')); 
                    echo CHtml::activeTextField($model, 'total_hargaseluruhnya', array('readonly' => true,'class' => 'required integer-decimal harga')); 
                ?>
            </th>
            <th class="hide"></th>
        </tr>
    </tfoot>
</table>
<?php echo CHtml::hiddenField("tampung_id",'',array('readonly' => true)); ?>