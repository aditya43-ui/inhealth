<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    if (isset($caraPrint)){
        $prov = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $prov = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php 

//$prov = $model->searchLaporan();

//$prov->pagination = false;
$totalHasil = 0;
$komponengajis = KomponengajiM::model()->findAllByAttributes(array('komponengaji_aktif'=>true));

foreach ($prov->data as $item) {
    $totalHasil += ($item->pph21perbulan + $item->sumjumlah_gp + $item->sumjumlah_tf + $item->sumjumlah_tj + $item->sumjumlah_tm + $item->sumjumlah_tt + $item->sumjumlah_jd + $item->sumjumlah_gjd + $item->sumjumlah_tbn + $item->sumjumlah_tbk + $item->sumjumlah_tp + $item->sumjumlah_jht + $item->sumjumlah_jkk + $item->sumjumlah_jkm + $item->sumjumlah_jp + $item->sumjumlah_thr + $item->sumjumlah_lmbr + $item->sumjumlah_bns + $item->sumjumlah_rg + $item->sumjumlah_pm + $item->sumjumlah_tntm + $item->sumjumlah_gtf + $item->sumjumlah_jsp + $item->sumjumlah_ps + $item->sumjumlah_tbksht + $item->sumjumlah_tjht + $item->sumjumlah_tjp + $item->sumjumlah_ptjp + $item->sumjumlah_ptjht + $item->sumjumlah_ptbk + $item->sumjumlah_hnr + $item->sumjumlah_pjkk + $item->sumjumlah_pjkm + $item->sumjumlah_tk);
}

$artab = array(
    array(
        'header' => 'No.',
        'type'=>'raw',
        'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
    ),
    array(
        'header'=>'Tahun',
        'type'=>'raw',
        'value'=>'$data->periodegaji',
        'footer'=>"Total Keseluruhan",
        'footerHtmlOptions'=>array(
            'style'=>'text-align: right; font-weight: bold;',
            'colspan'=>10,
        ),
        
    ),
    array(
        'header'=>'NIK',
        'type'=>'raw',
        'value'=>'$data->nomorindukpegawai',
        'footer'=>false,
        'footerHtmlOptions'=>array('hidden'=>true),
    ),
    array(
        'header'=>'Nama Pegawai',
        'type'=>'raw',
        'value'=>'$data->nama_pegawai',
        'footer'=>false,
        'footerHtmlOptions'=>array('hidden'=>true),
    ),
    array(
        'header'=>'Katagori Pegawai',
        'type'=>'raw',
        'value'=>'$data->kategoripegawai',
        'footer'=>false,
        'footerHtmlOptions'=>array('hidden'=>true),
    ),
    array(
        'header'=>'Katagori Pegawai Asal',
        'type'=>'raw',
        'value'=>'$data->kategoripegawaiasal',
        'footer'=>false,
        'footerHtmlOptions'=>array('hidden'=>true),
    ),
    array(
        'header'=>'Unit Kerja',
        'type'=>'raw',
        'value'=>'$data->namaunitkerja',
        'footer'=>false,
        'footerHtmlOptions'=>array('hidden'=>true),
    ),
    array(
        'header'=>'Pendidikan',
        'type'=>'raw',
        'value'=>'$data->pendidikan_nama',
        'footer'=>false,
        'footerHtmlOptions'=>array('hidden'=>true),
    ),
    array(
        'header'=>'Jabatan',
        'type'=>'raw',
        'value'=>'$data->jabatan_nama',
        'footer'=>false,
        'footerHtmlOptions'=>array('hidden'=>true),
    ),
    array(
        'header'=>'Masa Kerja',
        'type'=>'raw',
        'value'=>'MyFormatter::formatDateTimeForUser($data->tglditerima)',
        'footer'=>false,
        'footerHtmlOptions'=>array('hidden'=>true),
    ),
    
);

 foreach ($komponengajis as $row) {
     if($row->komponengaji_kode == 'GP'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_gp',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_gp':'number_format($data->sumjumlah_gp,0,"",".")'),
                        'footer'=>'sum(sumjumlah_gp)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TF'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tf',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_tf':'number_format($data->sumjumlah_tf,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tf)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TJ'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tj',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_tj':'number_format($data->sumjumlah_tj,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tj)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TM'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tm',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_tm':'number_format($data->sumjumlah_tm,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tm)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TT'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tt',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_tt':'number_format($data->sumjumlah_tt,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tt)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'JD'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_jd',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_jd':'number_format($data->sumjumlah_jd,0,"",".")'),
                        'footer'=>'sum(sumjumlah_jd)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'GJD'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_gjd',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_gjd':'number_format($data->sumjumlah_gjd,0,"",".")'),
                        'footer'=>'sum(sumjumlah_gjd)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TBN'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tbn',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_tbn':'number_format($data->sumjumlah_tbn,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tbn)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TBK'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tbk',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_tbk':'number_format($data->sumjumlah_tbk,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tbk)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TP'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tp',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_tp':'number_format($data->sumjumlah_tp,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tp)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'JHT'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_jht',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_jht':'number_format($data->sumjumlah_jht,0,"",".")'),
                        'footer'=>'sum(sumjumlah_jht)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'JKK'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_jkk',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_jkk':'number_format($data->sumjumlah_jkk,0,"",".")'),
                        'footer'=>'sum(sumjumlah_jkk)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'JKM'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_jkm',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_jkm':'number_format($data->sumjumlah_jkm,0,"",".")'),
                        'footer'=>'sum(sumjumlah_jkm)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'JP'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_jp',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_jp':'number_format($data->sumjumlah_jp,0,"",".")'),
                        'footer'=>'sum(sumjumlah_jp)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'THR'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_thr',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_thr':'number_format($data->sumjumlah_thr,0,"",".")'),
                        'footer'=>'sum(sumjumlah_thr)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'LMBR'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_lmbr',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_lmbr':'number_format($data->sumjumlah_lmbr,0,"",".")'),
                        'footer'=>'sum(sumjumlah_lmbr)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'BNS'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_bns',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_bns':'number_format($data->sumjumlah_bns,0,"",".")'),
                        'footer'=>'sum(sumjumlah_bns)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'RG'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_rg',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_rg':'number_format($data->sumjumlah_rg,0,"",".")'),
                        'footer'=>'sum(sumjumlah_rg)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'PM'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_pm',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_pm':'number_format($data->sumjumlah_pm,0,"",".")'),
                        'footer'=>'sum(sumjumlah_pm)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TNTM'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tntm',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_tntm':'number_format($data->sumjumlah_tntm,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tntm)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'GTF'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_gtf',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_gtf':'number_format($data->sumjumlah_gtf,0,"",".")'),
                        'footer'=>'sum(sumjumlah_gtf)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'JSP'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_jsp',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_jsp':'number_format($data->sumjumlah_jsp,0,"",".")'),
                        'footer'=>'sum(sumjumlah_jsp)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'PS'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_ps',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_ps':'number_format($data->sumjumlah_ps,0,"",".")'),
                        'footer'=>'sum(sumjumlah_ps)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TBKSHT'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tbksht',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_tbksht':'number_format($data->sumjumlah_tbksht,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tbksht)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TJHT'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tjht',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_tjht':'number_format($data->sumjumlah_tjht,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tjht)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TJP'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tjp',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_tjp':'number_format($data->sumjumlah_tjp,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tjp)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'PTJP'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_ptjp',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_ptjp':'number_format($data->sumjumlah_ptjp,0,"",".")'),
                        'footer'=>'sum(sumjumlah_ptjp)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'PTJHT'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_ptjht',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ?'$data->sumjumlah_ptjht':'number_format($data->sumjumlah_ptjht,0,"",".")'),
                        'footer'=>'sum(sumjumlah_ptjht)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'PTBK'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_ptbk',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_ptbk':'number_format($data->sumjumlah_ptbk,0,"",".")'),
                        'footer'=>'sum(sumjumlah_ptbk)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'HNR'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_hnr',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_hnr':'number_format($data->sumjumlah_hnr,0,"",".")'),
                        'footer'=>'sum(sumjumlah_hnr)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'PJKK'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_pjkk',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_pjkk': 'number_format($data->sumjumlah_pjkk,0,"",".")'),
                        'footer'=>'sum(sumjumlah_pjkk)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'PJKM'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_pjkm',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_pjkm':'number_format($data->sumjumlah_pjkm,0,"",".")'),
                        'footer'=>'sum(sumjumlah_pjkm)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }else if($row->komponengaji_kode == 'TK'){
         array_push($artab, array(
                        'header' => $row->komponengaji_nama,
                        'name'=>'sumjumlah_tk',
                        'type'=>'raw',
                        'value'=>(isset($caraPrint) ? '$data->sumjumlah_tk':'number_format($data->sumjumlah_tk,0,"",".")'),
                        'footer'=>'sum(sumjumlah_tk)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    ));
     }
                    
}
            array_push($artab, 
                                array(
                            'header'=>'PPh 21 Seluruh Penghasilan',
                            'type'=>'raw',
                             'name'=>'pph21perbulan',
                            'value'=>(isset($caraPrint) ? '$data->pph21perbulan':'number_format($data->pph21perbulan,0,"",".")'),
                            'footer'=>'sum(pph21perbulan)',
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                        ),
                    array(
                            'header'=>'Total',
                            'type'=>'raw',
                            'value'=>(isset($caraPrint) ?'($data->pph21perbulan + $data->sumjumlah_gp + $data->sumjumlah_tf + $data->sumjumlah_tj + $data->sumjumlah_tm + $data->sumjumlah_tt + $data->sumjumlah_jd + $data->sumjumlah_gjd + $data->sumjumlah_tbn + $data->sumjumlah_tbk + $data->sumjumlah_tp + $data->sumjumlah_jht + $data->sumjumlah_jkk + $data->sumjumlah_jkm + $data->sumjumlah_jp + $data->sumjumlah_thr + $data->sumjumlah_lmbr + $data->sumjumlah_bns + $data->sumjumlah_rg + $data->sumjumlah_pm + $data->sumjumlah_tntm + $data->sumjumlah_gtf + $data->sumjumlah_jsp + $data->sumjumlah_ps + $data->sumjumlah_tbksht + $data->sumjumlah_tjht + $data->sumjumlah_tjp + $data->sumjumlah_ptjp + $data->sumjumlah_ptjht + $data->sumjumlah_ptbk + $data->sumjumlah_hnr + $data->sumjumlah_pjkk + $data->sumjumlah_pjkm + $data->sumjumlah_tk)':'number_format(($data->pph21perbulan + $data->sumjumlah_gp + $data->sumjumlah_tf + $data->sumjumlah_tj + $data->sumjumlah_tm + $data->sumjumlah_tt + $data->sumjumlah_jd + $data->sumjumlah_gjd + $data->sumjumlah_tbn + $data->sumjumlah_tbk + $data->sumjumlah_tp + $data->sumjumlah_jht + $data->sumjumlah_jkk + $data->sumjumlah_jkm + $data->sumjumlah_jp + $data->sumjumlah_thr + $data->sumjumlah_lmbr + $data->sumjumlah_bns + $data->sumjumlah_rg + $data->sumjumlah_pm + $data->sumjumlah_tntm + $data->sumjumlah_gtf + $data->sumjumlah_jsp + $data->sumjumlah_ps + $data->sumjumlah_tbksht + $data->sumjumlah_tjht + $data->sumjumlah_tjp + $data->sumjumlah_ptjp + $data->sumjumlah_ptjht + $data->sumjumlah_ptbk + $data->sumjumlah_hnr + $data->sumjumlah_pjkk + $data->sumjumlah_pjkm + $data->sumjumlah_tk),0,"",".")'),
                    'footer'=> (isset($caraPrint) ?$totalHasil:number_format($totalHasil,0,"",".")),
                        'footerHtmlOptions'=>array(
                            'style'=>'text-align: right; font-weight: bold;'
                        ),
                    )
                );
               if (!isset($caraPrint)){
                   array_push($artab, 
                                array(
                                'header' => 'Detail',
                               'type'=>'raw',						
                               'value' => function ($data){
                                    return CHtml::link("<i class=icon-form-detail></i>", Yii::app()->createUrl(Yii::app()->controller->module->id.'/Laporan/DetailRekapPenghasilan',array("pegawai_id"=>$data->pegawai_id,'periodegaji'=>$data->periodegaji)), array("target"=>"frame_detail", "onclick"=>"$('#detailSlipGaji').dialog('open');", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Detail Slip Gaji"));
                               },
                               'htmlOptions'=>array('style'=>'text-align: center')
                        )
                    ); 
                }                 
                               
$this->widget($table,array(
	'id'=>'laporan-grid',
	'dataProvider'=>$model->searchLaporan(),
    'dataProvider'=>$prov,
	'template'=>$template,
	'enableSorting'=>$sort,
////	'filter'=>$model,
//        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed table-bordered',
	'columns'=>$artab,
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>

<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog',
		array(
			'id'=>'detailSlipGaji',
			'options'=>array(
				'title'=>'Detail Penghasilan',
				'autoOpen'=>false,
				'minWidth'=>900,
				'width'=>900,
				'modal'=>true,
			),
		)
	);
?>
<iframe src="" height="500" width="100%"  name="frame_detail"></iframe>
<?php
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>