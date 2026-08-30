<?php 
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = false;
$itemCssClass='table table-bordered table-striped table-condensed';

if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL") {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';     
  }
  
  if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        
      
        $itemCssClass='table border';
}
?>
<?php 
$this->widget($table,array(
    'id'=>'laporan-grid',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
//                'mergeColumns'=>array('noresep','tglresep','totalhargajual','jumalhresep'),
	'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'value' => '$data->no_pendaftaran'
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'value' => '$data->no_rekam_medik'
                ),
                array(
                    'header' => 'Nama Pasien',
                    'value' => '$data->namadepan." ".$data->nama_pasien'
                ),
                array(
                    'header'=>'Tanggal Surat',                        
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglsurat)',                      
                ),                    
                array(
                    'header'=>'Jenis Surat',
                    'value' => '$data->jenissurat_nama'
                ),
                array(
                    'header'=>'Judul Surat',
                    'value' => '$data->judulsurat'
                ),
                array(
                    'header'=>'No Surat',
                    'value' => '$data->nomorsurat'
                ),
                array(
                    'header' => 'Dibuat Oleh',
                    'value' => '(!empty($data->nama_pegawai)?$data->nama_pegawai:$data->nama_pemakai)'
                ),
                array(
                    'header' => 'Print',
                    'value' => function ($data) {
                        if($data->jenissurat_id == 10){
                            echo CHtml::link("<i class=icon-form-print></i>", "javascript:printSuratSehat(" . $data->pendaftaran_id . ", " . $data->suratketerangan_id . ");", array("rel" => "tooltip"));
                        } else if($data->jenissurat_id == 59){
                            echo CHtml::link("<i class=icon-form-print></i>", "javascript:printSuratBebas(" . $data->suratketerangan_id . ");", array("rel" => "tooltip"));
                        }else if($data->jenissurat_id == 57){
                            echo CHtml::link("<i class=icon-form-print></i>", "javascript:printKelayakanCovid(" . $data->suratketerangan_id . ");", array("rel" => "tooltip"));
                        }else if($data->jenissurat_id == 18){
                            echo CHtml::link("<i class=icon-form-print></i>", "javascript:printLahir(" . $data->suratketerangan_id . ");", array("rel" => "tooltip"));
                        }else if($data->jenissurat_id == 20){
                            echo CHtml::link("<i class=icon-form-print></i>", "javascript:printSakit(" . $data->pendaftaran_id . ", " . $data->suratketerangan_id . ");", array("rel" => "tooltip"));
                        }else if($data->jenissurat_id == 21){
                            echo CHtml::link("<i class=icon-form-print></i>", "javascript:printRujukan(" . $data->pendaftaran_id . ", " . $data->suratketerangan_id . ");", array("rel" => "tooltip"));
                        }else{
                            echo "-";
                        }
                    }
                )
                    
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>
<script type="text/javascript">
    function printSuratSehat(pendaftaran_id, suratketerangan_id) {
        window.open('<?php echo Yii::app()->createUrl('rekamMedis/suratKeterangan/PrintSuratBadanSehat&caraPrint=PRINT', array()); ?>&pendaftaran_id=' + pendaftaran_id + '&suratketerangan_id=' + suratketerangan_id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
    }
    function printSuratBebas(suratketerangan_id) {
        window.open('<?php echo Yii::app()->createUrl('rekamMedis/suratKeterangan/print&caraPrint=PRINT', array()); ?>&suratketerangan_id=' + suratketerangan_id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
    }
    function printKelayakanCovid(suratketerangan_id) {
        window.open('<?php echo Yii::app()->createUrl('rekamMedis/suratKeterangan/PrintSuratKelayakanCovid19&caraPrint=PRINT', array()); ?>&suratketerangan_id=' + suratketerangan_id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
    }
    function printLahir(suratketerangan_id) {
        window.open('<?php echo Yii::app()->createUrl('rekamMedis/suratKeterangan/PrintSuratLahir&caraPrint=PRINT', array()); ?>&suratketerangan_id=' + suratketerangan_id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
    }
    function printSakit(pendaftaran_id, suratketerangan_id) {
        window.open('<?php echo Yii::app()->createUrl('rekamMedis/suratKeterangan/PrintIstirahatv2&caraPrint=PRINT', array()); ?>&pendaftaran_id=' + pendaftaran_id + '&suratketerangan_id=' + suratketerangan_id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
    }
    function printRujukan(pendaftaran_id, suratketerangan_id) {
        window.open('<?php echo Yii::app()->createUrl('rekamMedis/suratKeterangan/PrintSuratRujukan&caraPrint=PRINT', array()); ?>&pendaftaran_id=' + pendaftaran_id + '&suratketerangan_id=' + suratketerangan_id, 'printwin', 'left=100,top=100,width=500, toolbar=no');
    }
</script>