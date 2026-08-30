<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<div>
<?php 
$prov = $modTindakanSearch->searchAnamesaDiet($modPendaftaran->pendaftaran_id);
$prov->sort->defaultOrder = 'jeniswaktu_id';
$this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjtindakan-pelayanan-t-grid', 
    'dataProvider'=>$prov, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header'=>'Ruangan Asal',
            'value'=>'$data->pendaftaran->ruangan->ruangan_nama',
        ),
        array(
            'header'=>'Tanggal Anamnesa Diet',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglanamesadiet)',
        ),
		array(
			'header'=>'Waktu Diet',
			'value'=>'$data->jeniswaktu->jeniswaktu_nama'
		),
        array(
            'header'=>'Menu Diet',
            'value'=>'$data->menudiet->menudiet_namalain',
        ),
        array(
            'header'=>'Jenis Bahan Makanan',
            'value'=>'$data->bahanmakanan->jenisbahanmakanan',
        ),
        array(
            'header'=>'Nama Bahan Makanan',
            'value'=>'$data->bahanmakanan->namabahanmakanan',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
</div>