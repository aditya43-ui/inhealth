<?php
$tglpesanmenu = $model->tglpesanmenu;
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$itemsCssClass = 'table table-striped table-condensed';
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchTable();
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
            .checkPDF{
                display: none;
            }
            
        
        </style>";
        if($caraPrint == 'PDF') {
            echo "
                <style>
                    .checkPDF{
                        display: block;
                    }
                </style>";
            
        }
    $itemsCssClass = 'table border';
    $template = "{items}";
    $sort = false;
    $data->pagination= false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
    echo "
        <style>
           

            .checkPDF{
                display: none;
            }
        
        </style>";
}
?>
<?php

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemsCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
        ),
        array(
            'header' => 'No. Bed',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' =>function($data) use (&$tglpesanmenu, &$modPesan){
                if($tglpesanmenu != date('Y-m-d')) {
                    $criteria = new CDbCriteria();
                    $criteria->join = 'LEFT JOIN pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id '
                                        . 'LEFT JOIN pasienadmisi_t pa on pa.pasienadmisi_id = p.pasienadmisi_id';
                    $criteria->addCondition('t.ruangan_id=' . $data->ruangan_id);
                    $criteria->addCondition('pa.kelaspelayanan_id=' . $data->kelaspelayanan_id);
                    $criteria->addCondition('pa.kamarruangan_id=' . $data->kamarruangan_id);
                    $criteria->addCondition("date(t.tglpesanmenu) = '" . $tglpesanmenu . "'");
                    // var_dump($criteria);
                    $modPesan = PesanmenudietT::model()->find($criteria);
                    // echo '<pre>';var_dump($modPesan->pendaftaran);
                    if(!empty($modPesan->pendaftaran->admisi)) {
                        echo $modPesan->pendaftaran->admisi->kamarruangan->kamarruangan_nobed;
                    }
                } else {
                    $modPesan = null;
                    echo $data->kamarruangan_nobed;
                }

            },
        ),
        array(
            'header' => 'Nama',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' =>  function($data) use (&$tglpesanmenu, &$modPesan){
                if($tglpesanmenu != date('Y-m-d')) {
                    if(!empty($modPesan->pendaftaran->pasien)) {
                        echo $modPesan->pendaftaran->pasien->nama_pasien;
                    }
                } else {
                    echo $data->nama_pasien;
                }

            },
        ),
        array(
            'header' => 'NOMR',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) use (&$tglpesanmenu, &$modPesan){
                if($tglpesanmenu != date('Y-m-d')) {
                    if(!empty($modPesan->pendaftaran)) {
                        echo $modPesan->pendaftaran->pasien->no_rekam_medik;
                    }
                } else {
                    echo $data->no_rekam_medik;
                }

            },
        ),
        array(
            'header' => 'No. Billing',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) use (&$tglpesanmenu, &$modPesan){
                if($tglpesanmenu != date('Y-m-d')) {
                    if(!empty($modPesan->pendaftaran)) {
                        echo $modPesan->pendaftaran->no_pendaftaran;
                    }
                } else {
                    echo $data->no_pendaftaran;
                }

            },
        ),
        array(
            'header' => 'Tanggal Lahir',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) use (&$tglpesanmenu, &$modPesan){
                if($tglpesanmenu != date('Y-m-d')) {
                    if(!empty($modPesan->pendaftaran)) {
                        echo $modPesan->pendaftaran->pasien->tanggal_lahir;
                    }
                } else {
                    echo $data->tanggal_lahir;
                }

            },
        ),
        array(
            'header' => 'Kelas',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) use (&$tglpesanmenu, &$modPesan){
                if($tglpesanmenu != date('Y-m-d')) {
                    if(!empty($modPesan->pendaftaran->admisi)) {
                        echo $modPesan->pendaftaran->admisi->kelaspelayanan->kelaspelayanan_nama;
                    }
                } else {
                    echo $data->kelaspelayanan_nama;
                }

            },
            
        ),
        array(
            'header' => 'DIIT',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) use (&$tglpesanmenu, &$modPesan){
                if($tglpesanmenu != date('Y-m-d')) {
                    if(!empty($modPesan->jenisdiet)) {
                        echo $modPesan->jenisdiet->jenisdiet_nama;
                    }
                } else {
                    echo $data->jenisdiet_nama;
                }

            }
        ),
        array(
            'header' => 'Status',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => ''
        ),
        array(
            'header' => 'Sore',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) {
                // if($data->jenis_waktu_combined) {
                //     $ex = explode(',', $data->jenis_waktu_combined);

                //     if(in_array(15, $ex)) {
                //         echo '<i class="entypo-check"><i>';
                //         echo '<i class="checkPDF">V<i>';    
                //     }
                // }
                // if($data->jeniswaktu_id == 15) {
                //     echo '<i class="entypo-check"><i>';
                //     echo '<i class="checkPDF">V<i>';
                // } 
            }
        ),
        array(
            'header' => 'Pagi',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) {
                // if($data->jenis_waktu_combined) {
                //     $ex = explode(',', $data->jenis_waktu_combined);

                //     if(in_array(2, $ex)) {
                //         echo '<i class="entypo-check"><i>';
                //         echo '<i class="checkPDF">V<i>';    
                //     }
                // }
                // if($data->jeniswaktu_id == 2) {
                //     echo '<i class="entypo-check"><i>';
                //     echo '<i class="checkPDF">V<i>';
                // } 
            }
        ),
        array(
            'header' => 'Siang',
            'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
            'value' => function($data) {
                // if($data->jenis_waktu_combined) {
                //     $ex = explode(',', $data->jenis_waktu_combined);

                //     if(in_array(13, $ex)) {
                //         echo '<i class="entypo-check"><i>';
                //         echo '<i class="checkPDF">V<i>';    
                //     }
                // }
                // if($data->jeniswaktu_id == 13) {
                //     echo '<i class="entypo-check"><i>';
                //     echo '<i class="checkPDF">V<i>';
                // } 
            }
        ),
        
        
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>