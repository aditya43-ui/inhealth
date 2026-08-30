<?php
/** 
 * form aset pinjam
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
?>
<table class="table table-condensed table-bordered table-striped" id="id-detail">
    <thead>
        <th>No.</th>        
        <th>No. Aset</th>
        <th>Merk</th>
        <th>Ukuran</th>
        <th>Keadaaan</th>
        <th></th>
    </thead>
    <tbody>
        <?php
            if (!empty($modDet)){
                foreach($modDet as $i => $det){
                    $det->invperalatan_namabrg = !empty($det->invperalatan_id)?$det->invperalatan->invperalatan_namabrg:'';
                    $det->invperalatan_merk = !empty($det->invperalatan_id)?$det->invperalatan->invperalatan_merk:'';
                    $det->invperalatan_ukuran = !empty($det->invperalatan_id)?$det->invperalatan->invperalatan_ukuran:'';
                    $det->invperalatan_kode = !empty($det->invperalatan_id)?$det->invperalatan->invperalatan_kode:'';
                    $det->invperalatan_keadaan = !empty($det->invperalatan_id)?$det->invperalatan->invperalatan_keadaan:'';
                    echo $this->renderPartial($this->path_view.'form/_rowDetailPinjam',array('model'=>$det,'i'=>$i));
                }
            }else{
                $det = new GUPeminjamanbrgT;
                echo $this->renderPartial($this->path_view.'form/_rowDetailPinjam',array('model'=>$det,'i'=>0));
            }
        ?>
    </tbody>
</table>
<?php echo CHtml::hiddenField("tampung_id",'',array('readonly' => true)); ?>