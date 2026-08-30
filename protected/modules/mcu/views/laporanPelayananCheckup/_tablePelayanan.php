<?php 
/**
 * digunakan untuk format laporan pada mcu kunjungan pasien 
 * RSST-3210
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */
?>

<?php

    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
         if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
            
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass='table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                ),
                                array(
                                    'header' => 'Tanggal Pendaftaran/No. Pendaftaran',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "</br>" . $data->no_pendaftaran;
                                    },
                                ),
                                
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        echo $data->no_rekam_medik;
                                    },
                                ),
                                array(
                                    'header' => 'Nama Pasien',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        echo $data->nama_pasien;
                                    },
                                ),
                                array(
                                    'header' => 'Alamat Pasien',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        echo $data->alamat_pasien;
                                    },
                                ),
                                array(
                                    'header' => 'Umur',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                         if(!empty($data->pasien_id)){
                            
                                                $pasien=PasienM::model()->findByPk($data->pasien_id);

                                                $tgl =$pasien->tanggal_lahir;
                                                $umur=CustomFunction::getUmur($tgl);
                                                $data=explode(" ",$umur);
                                                return $data[0]." Thn";
                                            }else{
                                                return "0 Thn";
                                            }
                                    },
                                ),
                               
                                array(
                                    'header' => 'Keperluan Checkup',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        echo $data->keterangan;
                                    },
                                ),   
           
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>