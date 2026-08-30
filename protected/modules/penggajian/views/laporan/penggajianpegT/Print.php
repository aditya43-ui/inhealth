<style>
    #laporanprint-grid th, #laporanprint-grid td{text-align:center;vertical-align:center;}
    #headercolumn {border-bottom:1px solid #DDDDDD;}
    #childcolumn {border-left:1px solid #DDDDDD;}
    
    .table {
        border: none !important;
        box-shadow: none;
    }
    
    .table th, .table td {
        border: 1px solid black !important;
        padding: 2px;
    }
    
    .table tfoot td {
        font-weight: bold;
    }
</style>
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
$total_col = 24 + $model->getTotalColumnKomponen('gaji') + $model->getTotalColumnKomponen('potongan');
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>$total_col));  
?>
<table class="table" id="laporanprint-grid">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Tgl. Penggajian</th>
            <th rowspan="2">NIP</th>
            <th rowspan="2">Unit Kerja</th>
            <th rowspan="2">Pendidikan</th>
            <th rowspan="2">Jabatan</th>
            <th rowspan="2">Nama Pegawai</th>
            <th rowspan="2">Alamat</th>
            <th rowspan="2">Tempat/Tanggal Lahir</th>
            <th rowspan="2">No. Rekening</th>
            <th rowspan="2">No. NPWP</th>
            <th rowspan="2">Bank</th>
            <th rowspan="2">PTKP</th>
            <th rowspan="2">No. BPJS Kesehatan</th>
            <th rowspan="2">No. BPJS Ketenagakerjaan</th>
            <th rowspan="2">Tgl. Terima</th>
            <th rowspan="2">Tgl. Resign</th>
            <th rowspan="2">Status Pegawai</th>
            <th rowspan="2">Kehadiran</th>
            
            <th colspan="<?php echo $model->getTotalColumnKomponen('gaji'); ?>" id="headercolumn">Penerimaan</th>
            <th colspan="<?php echo $model->getTotalColumnKomponen('potongan'); ?>" id="headercolumn">Potongan</th>
            <th rowspan="2">Total Pajak</th>
            <th rowspan="2">Potongan Lain-Lain</th>
            <th rowspan="2">Penambahan</th>
            <th rowspan="2">Pengurangan</th>
            <th rowspan="2">Total Penerimaan</th>
            <th rowspan="2">Keterangan</th>
        </tr>
        <tr>
            <?php echo $model->getColumnKomponen('gaji'); ?>
            <?php echo $model->getColumnKomponen('potongan'); ?>
        </tr>
    </thead>
    <tbody>
        <?php
            $cr = $model->criteriaLaporan();
            $cr->order = 't.tglpenggajian asc';
            $modPenggajianpeg = PenggajianpegT::model()->findAll($cr);
            $no=1;
            
            $terima = 0;
            $pajak = 0;
            $lain2 = 0;
            $penambahan = 0;
            $pengurangan = 0;
            foreach ($modPenggajianpeg as $data)
            {
                $bersih = $data->totalterima - $data->totalpotongan;
                $pajak += $data->totalpajak;
                $lain2 += $data->potongan_lainlain;
                $penambahan += $data->penambahan;
                $pengurangan += $data->pengurangan;
                $terima += $bersih;
                // $pokok = $data->totalterima;
                if ($caraPrint != 'EXCEL') {
                    $pokok = number_format($data->totalterima,0,'','.');
                }
                
                $peg = $data->pegawai;
                $txt_ptkp = "";
                if (empty($peg->ptkp_id)) {
                    $txt_ptkp = "-";
                } else {
                    $ptkp = PtkpM::model()->findByPk($peg->ptkp_id);

                    if (empty($ptkp)) {
                        $txt_ptkp = "-";
                    } else {
                        $txt_ptkp = $ptkp->kodeptkp."/".$ptkp->jmltanggunan;
                    }
                }
                
                $resign = ResignT::model()->findByAttributes(array(
                    'pegawai_id'=>$data->pegawai_id,
                ), array(
                    'order'=>'resign_id desc',
                ));
                
                $tgl_resign = "";
                $tgl_terima = empty($data->pegawai->tglditerima) ? "" : MyFormatter::formatDateTimeForUser($data->pegawai->tglditerima);
                if (!empty($resign)) {
                    $tgl_resign = MyFormatter::formatDateTimeForUser($resign->tglresign);
                    $tgl_terima = MyFormatter::formatDateTimeForUser($resign->tglditerima);
                }
                
                
                
                $tr = "<tr>";
                $tr .="<td>".$no.".</td>";
                $tr .= "<td>".MyFormatter::formatDateTimeForUser($data->tglpenggajian)."</td>";
                $tr .= "<td>".$data->pegawai->nomorindukpegawai."</td>";
                $tr .= "<td>".(empty($data->pegawai->unitkerja) ? "-" : $data->pegawai->unitkerja->namaunitkerja)."</td>";
                $tr .= "<td>".(empty($data->pegawai->pendidikan) ? "-" : $data->pegawai->pendidikan->pendidikan_nama)."</td>";
                $tr .= "<td>".(empty($data->pegawai->jabatan) ? "-" : $data->pegawai->jabatan->jabatan_nama)."</td>";
                $tr .= "<td>".$data->pegawai->nama_pegawai."</td>";
                $tr .= "<td>".$data->pegawai->alamat_pegawai."</td>";
                $tr .= "<td>".$data->pegawai->tempatlahir_pegawai.'<br>'.MyFormatter::formatDateTimeForUser($data->pegawai->tgl_lahirpegawai)."</td>";
                $tr .= "<td>".$data->pegawai->no_rekening."</td>";
                $tr .= "<td>".$data->pegawai->npwp."</td>";
                $tr .= "<td>".$data->pegawai->bank_no_rekening."</td>";
                $tr .= "<td>".$txt_ptkp."</td>";
                $tr .= "<td>".$data->pegawai->no_bpjs_kesehatan."</td>";
                $tr .= "<td>".$data->pegawai->no_bpjs_ketenagakerjaan."</td>";
                $tr .= "<td>".$tgl_terima."</td>";
                $tr .= "<td>".$tgl_resign."</td>";
                $tr .= "<td>".$data->pegawai->kategoripegawai."</td>";
                $tr .= "<td>".$data->harihadir."</td>";
                //$tr .= "<td>".$data->pegawai->no_rekening."</td>";
                //$tr .= "<td>".$pokok."</td>";
                $tr .= $model->getValueKomponen('gaji',$data->penggajianpeg_id);
                $tr .= $model->getValueKomponen('potongan',$data->penggajianpeg_id);
                $tr .= '<td>'.MyFormatter::formatNumberForPrint($data->totalpajak).'</td>';
                $tr .= '<td>'.MyFormatter::formatNumberForPrint($data->potongan_lainlain).'</td>';
                $tr .= '<td>'.MyFormatter::formatNumberForPrint($data->penambahan).'</td>';
                $tr .= '<td>'.MyFormatter::formatNumberForPrint($data->pengurangan).'</td>';
                $tr .= '<td>'.MyFormatter::formatNumberForPrint($data->penerimaanbersih).'</td>';
                $tr .= "<td>".$data->keterangan."</td>";
                $tr .= "</tr>";
                echo $tr;
                $no++;
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="19" style="text-align:left;">Total</td>
            <?php /*<td><?php echo $model->getTotalgaji(); ?></td> */ ?>
            <?php echo $model->getFooterKomponen('gaji'); ?>
            <?php echo $model->getFooterKomponen('potongan'); ?>
            <td><?php echo MyFormatter::formatNumberForPrint($pajak); ?></td>
            <td><?php echo MyFormatter::formatNumberForPrint($lain2); ?></td>
            <td><?php echo MyFormatter::formatNumberForPrint($penambahan); ?></td>
            <td><?php echo MyFormatter::formatNumberForPrint($pengurangan); ?></td>
            <td><?php echo MyFormatter::formatNumberForPrint($terima); ?></td>
            <td>&nbsp;</td>
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