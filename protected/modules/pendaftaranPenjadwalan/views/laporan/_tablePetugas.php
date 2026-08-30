<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$itemCssClass = 'table table-bordered datatable';
if (isset($caraPrint)) {
    $data = $model->searchRJ();
    $template = '{items}';
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchRJ();
    $template = "{summary}{items}{pager}";
}
?>
<?php if (isset($caraPrint)) { ?>

<?php } else { ?>
    <div style='width:100%;'>
    <?php } ?>
    <?php $this->widget($table, array(
        'id' => 'PPInfoKunjungan-v',
        'dataProvider' => $data,
        'template' => $template,
        //        'mergeColumns'=>array('ruangan_nama'),
        'itemsCssClass' => $itemCssClass,
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '$row+1',
                'htmlOptions' => array('style' => 'width:30px;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Tanggal Pendaftaran',
                //  'name'=>'ruangan_nama',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran)))',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'No. Pendaftaran',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->no_pendaftaran',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'No Rekam medik',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->no_rekam_medik',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Nama Pasien',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->nama_pasien',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Tanggal Lahir',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->tanggal_lahir',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Jenis Kelamin',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->jeniskelamin',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Alamat',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->alamat_pasien',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Diagnosa',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->diagnosa_rujukan',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Spesialis',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->jeniskasuspenyakit_nama',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Cara Masuk',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->statusmasuk',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Perujuk',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->nama_perujuk',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Jenis Penjamin',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->carabayar_nama',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Penjamin',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->penjamin_nama',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Poliklinik',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->ruangan_nama',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Nama Dokter',
                //  'name'=>'ruangan_nama',
                'value'=>'$data->nama_pegawai',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Petugas Loket',
                //  'name'=>'ruangan_nama',
                'value' => function ($data) {
                    $lp = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                    return $lp->pegawai->nama_pegawai;
                },
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),
            
            

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
    <?php if (isset($caraPrint)) { ?>

    <?php } else { ?>
    </div>
<?php } ?>