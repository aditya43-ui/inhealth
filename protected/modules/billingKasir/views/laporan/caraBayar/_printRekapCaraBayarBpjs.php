<?php
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $dataProvider = $model->printRekapPenjaminBpjs();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
      header('Cache-Control: max-age=0');
    }

    echo $this->renderPartial('application.views.headerReport.headerLaporan',
        array(
            'judulLaporan'=>$data['judulLaporan'],
            'periode'=>$data['periode']
        )
    );
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tbl_printrekapbpjs',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-responsive table-bordered table-striped table-condensed',
            'mergeHeaders'=>array(
                array(
                    'name'=>'<p style="margin: 0; text-align: center;">Instalasi</p>',
                    'start'=>2,
                    'end'=>12,
                ),
            ),
            'columns'=>array(
                array(
                  'header' => 'No.',
                  'type'=>'raw',
                  'value'=>'$row+1',
                ),
                array(
                  'header'=>'Nama Penjamin',
                  'type'=>'raw',
                  'value'=>'$data->penjamin_nama',
                ),
                array(
                  'header'=>'R. Jalan',
                  'type'=>'raw',
                  'value'=>'(($data->jml_rj > 0)? $data->jml_rj :"-")',
                ),
                array(
                  'header'=>'R. Darurat',
                  'type'=>'raw',
                  'value'=>'(($data->jml_rd > 0)? $data->jml_rd :"-")',
                ),
                array(
                  'header'=>'R. Inap',
                  'type'=>'raw',
                  'value'=>'(($data->jml_ri > 0)? $data->jml_ri :"-")',
                ),
                array(
                  'header'=>'P. Intensif',
                  'type'=>'raw',
                  'value'=>'(($data->jml_pi > 0)? $data->jml_pi :"-")',
                ),
                array(
                  'header'=>'Hemodialisa',
                  'type'=>'raw',
                  'value'=>'(($data->jml_hd > 0)? $data->jml_hd :"-")',
                ),
                array(
                  'header'=>'Fisioterapi',
                  'type'=>'raw',
                  'value'=>'(($data->jml_fisio > 0)? $data->jml_fisio :"-")',
                ),
                array(
                  'header'=>'Laboratorium',
                  'type'=>'raw',
                  'value'=>'(($data->jml_lab > 0)? $data->jml_lab :"-")',
                ),
                array(
                  'header'=>'Radiologi',
                  'type'=>'raw',
                  'value'=>'(($data->jml_rad > 0)? $data->jml_rad :"-")',
                ),
                array(
                  'header'=>'Ambulans',
                  'type'=>'raw',
                  'value'=>'(($data->jml_ambulans > 0)? $data->jml_ambulans :"-")',
                ),
                array(
                  'header'=>'P. Jenazah',
                  'type'=>'raw',
                  'value'=>'(($data->jml_pjenazah > 0)? $data->jml_pjenazah :"-")',
                ),
                array(
                  'header'=>'Apotek',
                  'type'=>'raw',
                  'value'=>'(($data->jml_apotek > 0)? $data->jml_apotek :"-")',
                ),
                array(
                  'header'=>'Jumlah',
                  'type'=>'raw',
                  'value'=>'($data->jml_rj + $data->jml_rd + $data->jml_ri + $data->jml_pi + $data->jml_hd + $data->jml_fisio + $data->jml_lab + $data->jml_rad + $data->jml_ambulans + $data->jml_pjenazah + $data->jml_apotek)',
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
?>
