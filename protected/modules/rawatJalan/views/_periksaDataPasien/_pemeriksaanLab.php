<style type="text/css">
    table.paddingtext2 tr th{
        text-align: center;
    }    
</style>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
echo $this->renderPartial('application.views.headerReport.headerDefaultLabV2',array('judulLaporan'=>$judulLaporan, 'colspan'=>3)); 
?>
<table>
    <tr>
        <td>No. Rekam Medik</td>
        <td>: <?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?php echo $modPasien->namadepan." ".$modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>: <?php echo $modPasien->tanggal_lahir; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>: <?php echo CustomFunction::getUmur(MyFormatter::formatDateTimeForDb($modPasien->tanggal_lahir)); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: <?php echo $modPasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $modPasien->alamat_pasien; ?></td>
    </tr>
</table>

<?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$modHasilPemeriksaan->searchRiwayatPasien($pasien_id),
//        'template'=>"{summary}\n{items}\n{pager}",
        'template'=>"{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeColumns'=>array('pemeriksaanlab_nama'),
	'columns'=>array(
            array(
              'header'=>'Pemeriksaan',
              'name'=>'pemeriksaanlab_nama', 
              'value'=>'$data->pemeriksaanlab_nama',
            ),
            array(
              'header'=>'Tanggal Pemeriksaan',
              'value'=>'MyFormatter::formatDateTimeForUser($data->tglhasilpemeriksaanlab)',
            ),
            array(
              'header'=>'Hasil Pemeriksaan',
              'value'=>'$data->hasilpemeriksaan',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>

<!--<table width="100%" class="table border paddingtext2">
    <tr>
        <th width="1%" rowspan="2">No</th>
        <th rowspan="2">Pemeriksaan</th>
        <th colspan="<?php // echo count((array)$tglPeriksa); ?>">Tanggal</th>
    </tr>
    <?php
//    echo "<tr>";
//        foreach($tglPeriksa as $key2 => $val2){
//            echo "<td>".$format->formatDateTimeForUser($val2->tglhasilpemeriksaanlab)."</td>";
//        }
//    echo "</tr>";
//    
//    $no = 1;
//    foreach ($hasilPemeriksanLab as $key => $val) {
//        echo "<tr>";
//            echo "<td>".$no."</td>";
//            echo "<td>".$val->pemeriksaanlab_nama."</td>";
//            
//            $criteria = new CDbCriteria();
//            $criteria->addCondition('t.pasien_id = '.$val->pasien_id);
//            $criteria->select = 't.pasien_id, p.pemeriksaanlab_id, p.pemeriksaanlab_nama, DATE(t.tglhasilpemeriksaanlab) AS tglhasilpemeriksaanlab';
//            $criteria->group = 't.pasien_id, p.pemeriksaanlab_id, p.pemeriksaanlab_nama, DATE(tglhasilpemeriksaanlab)';
//            $criteria->join = " JOIN detailhasilpemeriksaanlab_t AS d ON t.hasilpemeriksaanlab_id = d.hasilpemeriksaanlab_id "
//                    . " JOIN pemeriksaanlab_m AS p ON d.pemeriksaanlab_id = p.pemeriksaanlab_id";
//            $hasilPemeriksanLab = HasilpemeriksaanlabT::model()->findAll($criteria);
//            
//            
//        echo "</tr>";
//        $no++;
//    }
    ?>
    
</table>-->