<?php

$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$data_mod = $model->search();
if (isset($caraPrint)) {
    $data_mod = $model->search();
    $data_mod->pagination = false;
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
//        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
    }

    echo "
    <style>
        table {
            overflow:wrap;            
        } 
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
            border-spacing:0px;
            padding:0px;            
        }

        .table tbody tr:hover td, .table tbody tr:hover th {
            background-color: none;
        }
        
    </style>";
    $itemCssClass = 'table border';
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
}
$this->widget($table, array(
    'id' => 'tingkatrisiko-m-grid',
    'enableSorting' => false,
    'dataProvider' => $data_mod,
    'template' => $template,
    'itemsCssClass' => $itemCssClass,    
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        [
            'header' => 'Periode',
            'name' => 'periodeanggaran_id',
            'value' => function($data){
                return $data->anggaran_nama;
            },            
        ],
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_pengadaan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'value' => function ($data) {
                echo $data->pegawai->namaLengkap;
            },
        ),        
        array(
            'header' => 'Bidang',   
            'type' => 'raw',
            'value' => function ($data) {
                $cri = new CDbCriteria();
                $cri->select = "ins.instalasi_nama";
                $cri->join = " LEFT JOIN instalasi_m ins ON ins.instalasi_id = t.instalasi_id ";
                $cri->addCondition(" pejabatpengadaan_id = '".$data->pejabatpengadaan_id."' ");
                $cekinstalasi = PejabatpengadaandetM::model()->findAll($cri);
                $li = [];
                if (!empty($cekinstalasi)){
                    foreach($cekinstalasi as $det){
                        $li [$det->instalasi_nama] = $det->instalasi_nama;
                    }
                }
                                                
                $ol = "<ul>";
                foreach($li as $det){
                    $ol .= '<li>'.$det.'</li>';
                }
                $ol .= "</ul>";
                
                echo $ol;
                 
            }
        ),
        array(
            'header' => 'No. SK',
            'name' => 'no_sk',
            'value'=>function($data){
                return $data->no_sk;
            }
        ),
        array(
            'header' => 'Tanggal SK',
            'name' => 'tgl_sk',
            'value'=>function($data){
                return MyFormatter::formatDateTimeForUser($data->tgl_sk);
            }
        ),
        array(
            'header' => '<center>Status</center>',
            'value' => '($data->pejabatpengadaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        
    ),
));
?>