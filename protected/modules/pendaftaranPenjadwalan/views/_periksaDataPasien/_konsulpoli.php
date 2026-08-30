<?php
//$modKonsulPoli = KonsulpoliT::model()->with('poliasal','politujuan')->findAllByAttributes(array('pendaftaran_id'=>78239));
//if (isset($modMasukPenunjang)){
//    $jumlah = count((array)$modMasukPenunjang);
//}
//$result = array();
//foreach($modKonsulPoli as $row){
//        $result[] = $row->politujuan->ruangan_nama;    
//}
//echo implode(', ',$result);
?>
<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Detail <b>Konsul</b>
        </div>
    </div>
    <div class="panel-body">-->
<?php
$modKonsulPoli = new KonsulpoliT;
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan));
}
?>
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'konsul-t-grid',
    'dataProvider' => $modKonsulPoli->riwayatKonsul($pendaftaran_id),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Tanggal Konsul',
            'name' => 'No',
            'value' => '$data->tglkonsulpoli',
            'filter' => false,
        ),
        array(
            'header' => 'No. Antrian Konsul',
            'name' => 'No',
            'value' => '$data->no_antriankonsul',
            'filter' => false,
        ),
        array(
            'header' => 'Konsul Ke Poli',
            'name' => 'No',
            'value' => '$data->politujuan->ruangan_nama;',
            'filter' => false,
        ),
        array(
            'header' => 'Asal Ruangan / Poli',
            'name' => 'No',
            'value' => '$data->poliasal->ruangan_nama;',
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<!--</div>
</div>-->