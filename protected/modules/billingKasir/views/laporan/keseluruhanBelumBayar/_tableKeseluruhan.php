<?php
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
if (isset($caraPrint)) {
  $data = $model->searchPasienBelumBayar();
  $data->pagination = false;
  $template = "{items}";
  $sort = false;
  if ($caraPrint == "EXCEL")
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
  $data = $model->searchPasienBelumBayar();
  $template = "{summary}\n{items}\n{pager}";
}
?>
<?php
$this->widget(
  $table,
  array(
    'id' => 'tableLaporanKeseluruhan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'mergeColumns' => array('instalasi_nama', 'ruangan_nama'),
    'columns' => array(
      array(
        'name' => 'tgl_pendaftaran',
        'type' => 'raw',
        'value' => 'date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran))',
      ),
      'no_pendaftaran',
      'no_rekam_medik',
      'nama_pasien',
      'statuspasien',
      'statusmasuk',
      'instalasi_nama',
      'ruangan_nama',
      'kelaspelayanan_nama',
      array(
        'header' => 'Tanggal Pulang',
        'type' => 'raw',
        'value' => '$data->getTglKeluar()',
      ),
      array(
        'header' => 'Perujuk',
        'type' => 'raw',
        'value' => '$data->getNamaPerujuk()',
      ),
      'jeniskelamin',
      'penjamin_nama',
      array(
        'header' => 'Diagnosa',
        'type' => 'raw',
        'value' => '$data->getDiagnosa()',
      ),
      array(
        'header' => 'Nama Dokter',
        'type' => 'raw',
        'value' => '$data->getNamaDokter()',
      ),
      array(
        'header' => 'Rincian Tagihan',
        'type' => 'raw',
        'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
        'value' => '
                        CHtml::Link("<i class=\"icon-list-alt\"></i>",
                            Yii::app()->controller->createUrl("laporan/rincianTagihanBelumBayar",array("id"=>$data->pendaftaran_id,"frame"=>true)
                        ),
                            array(
                                "class"=>"", 
                                "target"=>"iframeRincianTagihan",
                                "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk melihat Rincian Tagihan",
                            )
                        )',
        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
      ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
  )
);
/*
    $this->widget($table,
        array(
            'id'=>'tableLaporanKeseluruhan',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                  'header'=>'Tgl. Daftar',
                  'type'=>'raw',
                  'value'=>'$data->pendaftaran->tgl_pendaftaran',
                ),
                array(
                  'header'=>'No. Pendaftaran',
                  'type'=>'raw',
                  'value'=>'$data->pendaftaran->no_pendaftaran',
                ),
                array(
                  'header'=>'No. RM',
                  'type'=>'raw',
                  'value'=>'$data->pasien->no_rekam_medik',
                ),
                array(
                  'header'=>'Nama Pasien',
                  'type'=>'raw',
                  'value'=>'$data->pasien->nama_pasien',
                ),                
                array(
                  'header'=>'Baru',
                  'type'=>'raw',
                  'value'=>'$data->pendaftaran->kunjungan',
                ),
                array(
                  'header'=>'Cara Masuk',
                  'type'=>'raw',
                  'value'=>'$data->pendaftaran->statusmasuk',
                ),
                array(
                  'header'=>'Unit',
                  'type'=>'raw',
                  'value'=>'$data->getInstalasiPasien()',
                ),
                array(
                  'header'=>'Ruangan',
                  'type'=>'raw',
                  'value'=>'$data->getRuanganPasien()',
                ),
                array(
                  'header'=>'Kelas',
                  'type'=>'raw',
                  'value'=>'$data->getKelasPasien()',
                ),
                array(
                  'header'=>'Tgl. Pulang',
                  'type'=>'raw',
                  'value'=>'$data->getTglKeluar()',
                ),
                array(
                  'header'=>'Tgl. Pulang',
                  'type'=>'raw',
                  'value'=>'$data->getNamaPenjamin()',
                ),
                array(
                  'header'=>'Perujuk',
                  'type'=>'raw',
                  'value'=>'$data->getNamaPerujuk()',
                ),
                array(
                  'header'=>'Sex',
                  'type'=>'raw',
                  'value'=>'$data->pasien->jeniskelamin',
                ),
                array(
                  'header'=>'Diagnosa',
                  'type'=>'raw',
                  'value'=>'$data->getDiagnosa()',
                ),
                array(
                  'header'=>'Nama Dokter',
                  'type'=>'raw',
                  'value'=>'$data->getNamaDokter()',
                ),
                array(
                    'header'=>'Rincian Tagihan',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value'=>'
                        CHtml::Link("<i class=\"icon-list-alt\"></i>",
                            Yii::app()->controller->createUrl("RinciantagihanpasienV/rincian",array("id"=>$data->pendaftaran_id,"frame"=>true)
                        ),
                            array(
                                "class"=>"", 
                                "target"=>"iframeRincianTagihan",
                                "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk melihat Rincian Tagihan",
                            )
                        )',
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
 * 
 */
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
  'id' => 'dialogRincianTagihan',
  'options' => array(
    'title' => 'Rincian Tagihan',
    'autoOpen' => false,
    'modal' => true,
    'minWidth' => 700,
    'height' => 400,
    'resizable' => true,
  ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>