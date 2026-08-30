<style>
img{
    height:90px!important;
    width:90px!important;
}
</style>
<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    $dataProvider = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
      header('Cache-Control: max-age=0');   
    } 
        $table = 'ext.bootstrap.widgets.BootExcelGridView';

    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDFNew',
        array(
            'judulLaporan'=>$data['judulLaporan'],
            'periode'=>$data['periode']
        )
    );
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableLaporanCaraBayar',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            // 'extraRowColumns' => array('penjamin_nama'),
            'columns'=>array(
                array(
                    'header'=>'Tanggal Pengisian Saldo Awal',
                    'value'=>'$data->tglpengisiansaldo',
                    'type'=>'raw',
                    'filter'=>false,
                ),
                array(
                    'header'=>'Cabang',
                    'value'=>'$data->nama_rumahsakit',
                    // 'value'=>'(isset($data->daftartindakan_nama) ? $data->daftartindakan_nama : "")."<br/>".$data->getNamaLengkap()',
                    'type'=>'raw',
                    'filter'=>false,
                ),
                array(
                    'header'=>'Ruangan',
                    'value'=>'$data->ruangan_nama',
                    'type'=>'raw',
                    // 'htmlOptions'=>array('style'=>'text-align:right;'),
                    'filter'=>false,
                ),
                array(
                    'header'=>'Shift',
                    'value'=>'$data->shift->shift_nama',
                    'type'=>'raw',
                    // 'htmlOptions'=>array('style'=>'text-align:right;'),
                    'filter'=>false,
                ),
                array(
                    'header'=>'Pegawai',
                    'value'=>'$data->pegawai->nama_pegawai',
                    'type'=>'raw',
                    // 'htmlOptions'=>array('style'=>'text-align:right;'),
                    'filter'=>false,
                ),
                array(
                    'header'=>'Nilai Saldo',
                    'value'=>'MyFormatter::formatNumberForUser($data->nilaisaldoawal)',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'filter'=>false,
                ),
                array(
                    'header'=>'Keterangan',
                    'value'=>'$data->keterangan',
                    'type'=>'raw',
                    'filter'=>false,
                ),          
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
  ?>
    <div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>