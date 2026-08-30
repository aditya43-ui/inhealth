
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchByFilterPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchByFilter();
         $template = "{summary}\n{items}\n{pager}";
    }
  ?>  

<?php
$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'grid-saldo-rekening',
        'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-bordered datatable',
        'columns'=>array(
            array(
              'header'=>'No',
              'type'=>'raw',
              'value'=>'$row+1',
              'htmlOptions'=>array('style'=>'width:20px'),
              'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Struktur',
               'type'=>'raw',
               'value'=>'$data->kdstruktur',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px;'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Kelompok',
               'type'=>'raw',
               'value'=>'$data->kdkelompok',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Jenis',
               'type'=>'raw',
               'value'=>'($data->kdjenis == null ? "-" : $data->kdjenis)',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Obyek',
               'type'=>'raw',
               'value'=>'($data->kdobyek == null ? "-" : $data->kdobyek)',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Rincian Obyek',
               'type'=>'raw',
               'value'=>'($data->kdrincianobyek == null ? "-" : $data->kdrincianobyek)',
               'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Nama Rekening',
               'type'=>'raw',
               'value'=>'(isset($data->nmrincianobyek) ? $data->nmrincianobyek : (isset($data->nmobyek) ? $data->nmobyek : (isset($data->nmjenis) ? $data->nmjenis : (isset($data->nmkelompok) ? $data->nmkelompok : (isset($data->nmstruktur) ? $data->nmstruktur : "-")))))',
               'htmlOptions'=>array('style'=>'width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),                        
            /*
            array(
               'name'=>'nmstruktur',
               'type'=>'raw',
               'value'=>'isset($data->nmstruktur) ? $data->nmstruktur : "-"',
               'htmlOptions'=>array('style'=>'width:80px')
            ),
            array(
               'name'=>'nmkelompok',
               'type'=>'raw',
               'value'=>'isset($data->nmkelompok) ? $data->nmkelompok : "-"',
               'htmlOptions'=>array('style'=>'width:80px')
            ),
            array(
               'name'=>'nmjenis',
               'type'=>'raw',
               'value'=>'isset($data->nmjenis) ? $data->nmjenis : "-"',
               'htmlOptions'=>array('style'=>'width:80px')
            ),
            array(
               'name'=>'nmobyek',
               'type'=>'raw',
               'value'=>'isset($data->nmobyek) ? $data->nmobyek : "-"',
            ),
            array(
               'name'=>'nmrincianobyek',
               'type'=>'raw',
               'value'=>'isset($data->nmrincianobyek) ? $data->nmrincianobyek : "-"',
            ),
            array(
               'name'=>'rincianobyek_nb',
               'type'=>'raw',
                'value'=>'($data->rincianobyek_nb == null ? "-" : ($data->rincianobyek_nb == "D" ? "Debit" : "Kredit"))',
            ),
            array(
               'name'=>'kelompokrek',
               'type'=>'raw',
                'value'=>'($data->kelompokrek == null ? "-" : $data->kelompokrek)',
            ),
             * 
             */
            array(
                'header'=>'Mata Uang',
                'type'=>'raw',
                'value'=>'$data->matauang',
                'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'Jml Anggaran',
                'type'=>'raw',
                'value'=>'$data->jmlanggaran',
                'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'Jml Saldo Awal Debit',
                'type'=>'raw',
                'value'=>'$data->jmlsaldoawald',
                'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'Jml Saldo Awal Kredit',
                'type'=>'raw',
                'value'=>'$data->jmlsaldoawalk',
                'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'Jml Mutasi Debit',
                'type'=>'raw',
                'value'=>'$data->jmlmutasid',
                'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'Jml Mutasi Kredit',
                'type'=>'raw',
                'value'=>'$data->jmlmutasik',
                'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'Jml Saldo Akhir Debit',
                'type'=>'raw',
                'value'=>'$data->jmlsaldoakhird',
                'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'Jml Saldo Akhir Kredit',
                'type'=>'raw',
                'value'=>'$data->jmlsaldoakhirk',
                'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
           /* array(
               'header'=>'&nbsp;',
               'type'=>'raw',
               'value'=>'CHtml::Link("<i class=\'icon-pencil-brown\'></i>", Yii::app()->controller->createUrl("SaldoAwal/editSaldoRekening",array("id"=>$data->saldoawal_id)),array("value"=>$data->saldoawal_id, "onclick"=>"editSaldoJenisRek(this);return false;","rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Saldo Rekening",))',
            )*/
         ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);
?>