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
        $data = $model->searchInformasiPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else {
        $data = $model->searchInformasiPrint();
        $template = "{summary}\n{items}\n{pager}";
    }

$this->widget($table,array(
	'id'=>'pengajuanbonusthr-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'type'=>'raw',
                'value'=>'$row+1',
            ),
             array(
                'header'=>'No. Pengajuan / Tgl. Pengajuan',
                'type'=>'raw',
                'value'=>function($data) {
                    return $data->nopengajuan.'/'.MyFormatter::formatDateTimeForUser($data->tglpengajuan);
                }
            ),
            array(
                    'header'=>'Nama Pegawai',
                    'type'=>'raw',
                    'value'=>'$data->nama_pegawai',
            ),
             array(
                    'header'=>'Status Pegawai',
                    'type'=>'raw',
                    'value'=>'$data->statuspegawai',
            ),
                    array(
                    'header'=>'Tanggal Masuk',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglditerima)',
            ),
                    array(
                    'header'=>'Jenis Transaksi',
                    'type'=>'raw',
                    'value'=>'$data->jenisgajipegawai',
            ),
                array(
                     'header'=>'Mengetahui (RS)',
                 'type'=>'raw',
                    'value'=>'$data->pegawai_mengetahuirs',
             ),
             array(
                 'header'=>'Mengetahui (PT)',
                     'type'=>'raw',
                     'value'=>'$data->pegawai_mengetahuipt',
             ),
             array(
                 'header'=>'Menyetujui',
                 'type'=>'raw',
                    'value'=>'$data->pegawai_menyetujui',
             ),
            array(
                    'header'=>'Keterangan',
                    'type'=>'raw',
                    'value'=>'$data->keteranganpengajuan',
            ),
            array(
                    'header'=>'Status',
                    'type'=>'raw',
                    'value'=>'"Belum Bayar"',
            ),
        ),
    ));
?>
