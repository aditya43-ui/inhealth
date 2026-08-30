<style>
    #laporanprint-grid th, #laporanprint-grid td{text-align:center;vertical-align:center;}
    #headercolumn {border-bottom:1px solid #DDDDDD;}
    #childcolumn {border-left:1px solid #DDDDDD;}
</style>
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));  
?>
<table class="table table-bordered table-striped table-condensed" id="laporanprint-grid">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Tgl. Penggajian</th>
            <th rowspan="2">NIP</th>
            <th rowspan="2">Nama Pegawai</th>
            <th rowspan="2">Gaji Pokok</th>
            <th colspan="<?php echo $model->getTotalColumnKomponen('gaji'); ?>" id="headercolumn">Tunjangan</th>
            <th colspan="<?php echo $model->getTotalColumnKomponen('potongan'); ?>" id="headercolumn">Potongan</th>
        </tr>
        <tr>
            <?php echo $model->getColumnKomponen('gaji'); ?>
            <?php echo $model->getColumnKomponen('potongan'); ?>
        </tr>
    </thead>
    <tbody>
        <?php
            $modPenggajianpeg = PenggajianpegT::model()->findAll($model->criteriaLaporan());
            $no=1;
            foreach ($modPenggajianpeg as $data)
            {
                $tr = "<tr>";
                $tr .="<td>$no</td>";
                $tr .= "<td>$data->tglpenggajian</td>";
                $tr .= "<td>".$data->pegawai->nomorindukpegawai."</td>";
                $tr .= "<td>".$data->pegawai->nama_pegawai."</td>";
                $tr .= "<td>".number_format($data->totalterima,0,'','.')."</td>";
                $tr .= $model->getValueKomponen('gaji',$data->penggajianpeg_id);
                $tr .= $model->getValueKomponen('potongan',$data->penggajianpeg_id);
                $tr .= "</tr>";
                echo $tr;
                $no++;
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align:left;">Total</td>
            <td><?php echo $model->getTotalgaji(); ?></td>
            <?php echo $model->getFooterKomponen('gaji'); ?>
            <?php echo $model->getFooterKomponen('potongan'); ?>
        </tr>
    </tfoot>
</table>
<?php
//    $table = 'ext.bootstrap.widgets.BootGridView';
//    $templates = "{summary}\n{items}\n{pager}";
//    $data = $model->searchLaporan();
//    if (isset($caraPrint))
//    {
//        $data = $model->searchLaporanprint();
//        $templates = "\n{items}";
//        if ($caraPrint=='EXCEL') {
//            $table = 'ext.bootstrap.widgets.BootExcelGridView';
//        }
//    }
//$this->widget($table,array(
//	'id'=>'laporan-grid',
//	'dataProvider'=>$data,
////	'filter'=>$model,
//        'template'=>$templates,
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//                    'pegawai.nomorindukpegawai',
//                    'pegawai.nama_pegawai',
//                    'pegawai.jabatan.jabatan_nama',
//                    'pegawai.no_rekening',
//                    'tglpenggajian',
//                    'keterangan',
//                    'mengetahui',
//                    'penerimaanbersih',
//                    'totalpotongan',
//                    'totalterima',
//                ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//));
?>