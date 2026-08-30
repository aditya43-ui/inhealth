<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
    $tot_gajipokok = 0;
    $tot_tunjangantetap = 0;
    $tot_honorarium = 0;
    $tot_premiasuransi = 0;
    $tot_tunjanganmakan = 0;
    $tot_tunjanganbonus = 0;
    $tot_hasilbruto = 0;
    $tot_biayajabatan = 0;
    $tot_iuaran = 0;
    $tot_netto_masasebelumnya = 0;
    $tot_ptkppertahun = 0;
    $tot_pkp = 0;
    $tot_pph21dipotong = 0;
    $tot_pph21terutang = 0;
    $tot_pph21telahdipotong = 0;
    $tot_pph21perbulan = 0;
    
    $prov = $data->data;
    if(count((array)$prov)>0){
       foreach ($prov  as $dataPajak){
           $tot_gajipokok += $dataPajak->gajipokok;
           $tot_tunjangantetap += $dataPajak->tunjangantetap;
           $tot_honorarium += $dataPajak->honorarium;
           $tot_premiasuransi += $dataPajak->premiasuransi;
           $tot_tunjanganmakan += $dataPajak->tunjanganmakan;
           $tot_tunjanganbonus += $dataPajak->tunjanganbonus;
//           $tot_hasilbruto += ($dataPajak->gajipokok + $dataPajak->tunjangantetap + $dataPajak->honorarium + $dataPajak->tunjanganmakan + $dataPajak->tunjanganbonus);
           $tot_hasilbruto += ($dataPajak->gajipokok + $dataPajak->tunjangantetap + $dataPajak->honorarium + $dataPajak->tunjanganbonus);
           $tot_biayajabatan += $dataPajak->biayajabatan;
           $tot_iuaran += ($dataPajak->potonganpensiun + $dataPajak->jaminanpensiun + $dataPajak->bpjskesehatan);
           $tot_netto_masasebelumnya += $dataPajak->netto_masasebelumnya;
           $tot_ptkppertahun += $dataPajak->ptkppertahun;
           $tot_pkp += $dataPajak->pkp;
           $tot_pph21dipotong += $dataPajak->pph21dipotong;
           $tot_pph21terutang += $dataPajak->pph21terutang;
           $tot_pph21telahdipotong += $dataPajak->pph21telahdipotong;
           $tot_pph21perbulan += $dataPajak->pph21perbulan;
           
       }
    }
    
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'columns'=>array(
        array(
			'header'=>'No.',
			'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
			'type'=>'raw',
        ),
		array(
			'header'=>'Nama Pegawai',
			'value'=>'$data->nama_pegawai',
			'type'=>'raw',
        ),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
			'type'=>'raw',
        ),
		
		array(
			'header'=>'NPWP',
			'value'=>'$data->npwp',
			'type'=>'raw',
        ),
		array(
			'header'=>'Kategori Pegawai',
			'value'=>'$data->kategoripegawai',
			'type'=>'raw',
        ),
		array(
			'header'=>'Jenis Kelamin',
			'value'=>'$data->jeniskelamin',
			'type'=>'raw',
        ),
		array(
			'header'=>'Kode PTKP',
			'value'=>'$data->kodeptkp_pegawai."/".$data->jmltanggunan',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('colspan'=>1,'style'=>'text-align:right;font-style:italic;'),
            'footer'=>'JUMLAH',
        ),
		array(
			'header'=>'Gaji Pokok',
			'value'=>'number_format($data->gajipokok)',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_gajipokok),
        ),
		array(
			'header'=>'Tunjangan Lainnya, Uang Lembur, dan sebagainya',
			'value'=>'number_format($data->tunjangantetap)',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_tunjangantetap),
        ),
		array(
			'header'=>'Honorarium dan Imbalan lain sejenisnya',
			'value'=>'number_format($data->honorarium)',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_honorarium),
        ),
		array(
			'header'=>'Premi Asuransi yang Dibayar Pemberi Kerja',
			'value'=>'number_format($data->premiasuransi)',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_premiasuransi),
        ),
		array(
			'header'=>'Penerimaan dalam Bentuk Natura',
//			'value'=>'number_format($data->tunjanganmakan)',
                    'value'=>'0',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
//            'footer'=> number_format($tot_tunjanganmakan),
                    'footer'=> 0,
        ),
		array(
			'header'=>'Tantiem, Bonus, Gratifikasi, Jasa Produksi dan THR',
			'value'=>'number_format($data->tunjanganbonus)',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_tunjanganbonus),
			
        ),
        array(
			'header'=>'Jumlah Penghasilan Bruto',
			'value'=>'number_format(($data->gajipokok + $data->tunjangantetap + $data->honorarium + $data->premiasuransi  + $data->tunjanganbonus))',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_hasilbruto),
        ),
        array(
			'header'=>'Biaya Jabatan (5%)',
			'value'=>'number_format($data->biayajabatan)',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_biayajabatan),
        ),
        array(
			'header'=>'Iuran Pensiun atau Iuran THT/JHT',
			'value'=>'number_format(($data->potonganpensiun + $data->jaminanpensiun + $data->bpjskesehatan))',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_iuaran),
        ),
        array(
			'header'=>'Jumlah Penghasilan Neto',
			'value'=>'number_format(($data->gajipokok + $data->tunjangantetap + $data->honorarium + $data->premiasuransi + $data->tunjanganbonus + $data->biayajabatan + $data->potonganpensiun + $data->jaminanpensiun + $data->bpjskesehatan))',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format(($tot_hasilbruto + $tot_biayajabatan + $tot_iuaran)),
        ),
        array(
			'header'=>'Jumlah Penghasilan Neto Masa Sebelumnya',
			'value'=>'number_format($data->netto_masasebelumnya)',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format(($tot_netto_masasebelumnya)),
        ),
        array(
			'header'=>'Jumlah Penghasilan Neto Disetahunkan',
			'value'=>'number_format(($data->gajipokok + $data->tunjangantetap + $data->honorarium + $data->premiasuransi + $data->tunjanganbonus + $data->biayajabatan + $data->potonganpensiun + $data->jaminanpensiun + $data->bpjskesehatan))',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format(($tot_hasilbruto + $tot_biayajabatan + $tot_iuaran)),
        ),
		array(
			'header'=>'PTKP',
			'value'=>'number_format($data->ptkppertahun)',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_ptkppertahun),
			
        ),
		array(
			'header'=>'PKP',
			'value'=>'number_format(($data->gajipokok + $data->tunjangantetap + $data->honorarium + $data->premiasuransi + $data->tunjanganbonus + $data->biayajabatan + $data->potonganpensiun + $data->jaminanpensiun + $data->bpjskesehatan)-($data->ptkppertahun))',
			'type'=>'raw',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format(($tot_hasilbruto + $tot_biayajabatan + $tot_iuaran)-$tot_ptkppertahun),
        ),
		array(
			'header'=>'PPh Pasal 21 atas PKP Disetahunkan',
                    'value'=>'number_format($data->pph21perbulan)',
//			'value'=>'number_format(($data->gajipokok + $data->tunjangantetap + $data->honorarium + $data->premiasuransi + $data->tunjanganmakan + $data->tunjanganbonus + $data->biayajabatan + $data->potonganpensiun + $data->jaminanpensiun + $data->bpjskesehatan)-($data->ptkppertahun))',
			'type'=>'raw',
			'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                     'footer'=> number_format($tot_pph21perbulan),
//            'footer'=> number_format(($tot_hasilbruto + $tot_biayajabatan + $tot_iuaran)-$tot_ptkppertahun),
        ),
        array(
			'header'=>'PPh Pasal 21 yang telah Dipotong Masa Sebelumnya',
			'value'=>'number_format($data->pph21dipotong)',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=> number_format($tot_pph21dipotong),
        ),
        array(
			'header'=>'PPh Pasal 21 Terutang',
//			'value'=>'number_format($data->pph21terutang)',
             'value'=>'number_format($data->pph21perbulan)',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
//            'footer'=> number_format($tot_pph21terutang),
            'footer'=> number_format($tot_pph21perbulan),
        ),
        array(
			'header'=>'PPh Pasal 21 dan PPh Pasal 26 yang telah Dipotong dan Dilunas',
//			'value'=>'number_format($data->pph21telahdipotong)',
            'value'=>'number_format($data->pph21perbulan)',
			'type'=>'raw',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
//            'footer'=> number_format($tot_pph21telahdipotong),
            'footer'=> number_format($tot_pph21perbulan),
        ),
//        array(
//			'header'=>'PPh Pasal 21 Perbulan Terutang',
//			'value'=>'number_format($data->pph21)',
//			'type'=>'raw',
//        )
    ),
)); ?> 
