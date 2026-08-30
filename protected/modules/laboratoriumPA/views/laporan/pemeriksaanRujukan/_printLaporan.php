<?php 
    $rim = 'width:600px;overflow-x:none;';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $data = $model->searchTableLaporan();
    $dataRS = $modelRS->searchTableLaporan();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $data = $model->searchPrintLaporan();
      $dataRS = $modelRS->searchPrintLaporan();
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>

<?php if($tab == "luar"){ ?>
<div id="div_rujukanLuar">
    <?php 
        $models = LBLaporanpemeriksaanrujukanV::model()->findAll();
        $perujuk_temp = "";
        foreach($models as $i=>$data){
            if($data->rujukan_id){
                $perujuk = $data->nama_perujuk;
            } else{
                $perujuk = '';
            }           
            if($perujuk_temp != $perujuk)
            {
                if($data->asalrujukan_id){
                    $kedatangan = $data->asalrujukan_nama;
                }
                else{
                    $kedatangan = '';
                }
            echo "<table >
                    <tr>
                        <td>Perujuk</td>
                        <td>:</td>
                        <td>".$perujuk."</td>
                    </tr>
                    <tr>
                        <td>Kedatangan</td>
                        <td>:</td>
                        <td>".$kedatangan."</td>
                    </tr>";
            echo "</table>";
            
            echo "<table width='100%' border='1'>
                            <tr>
                                <td align='center'>No</td>
                                <td align='center'>No. Pendaftaran Lab</td>
                                <td align='center'>Tanggal</td>
                                <td align='center'>Kode</td>
                                <td align='center'>Nama Jenis Periksa</td>
                                <td align='center'>Tarif</td>
                            </tr>";
               
            $criteria = new CDbCriteria;
            $term = $perujuk;
            $termKode = $kedatangan;
            $condition  = "nama_perujuk ILIKE '%".$term."%' OR nama_perujuk ILIKE '%".$perujuk."%'";
            $conditionKode  = "asalrujukan_nama ILIKE '%".$termKode."%' OR asalrujukan_nama ILIKE '%".$kedatangan."%'";
            $criteria->addCondition($condition);
            $criteria->addCondition($conditionKode);
            $criteria->limit = -1;
            
            $totHarga = 0;
            $detail = LBLaporanpemeriksaanrujukanV::model()->findAll($criteria);
            foreach($detail as $key=>$details){
                    $harga = $details->tarif_satuan * $details->qty_tindakan;
                    $totHarga += $harga;
                    
                    echo "<tr>
                              <td width='20px;' style='text-align:center'>".($key+1)."</td>
                              <td width='100px;'>".$details->no_pendaftaran."</td>
                              <td width='180px;'>".$details->tglmasukpenunjang."</td>
                              <td width='40px;'>".$details->daftartindakan_kode."</td>
                              <td>".$details->daftartindakan_nama."</td>
                              <td width='120px;' style='text-align:right'>".number_format($harga,0,"",".")."</td>
                          </tr>";
            }
            
                    echo "<tfoot>
                              <td colspan=5 style='text-align:right'>Total : </td>
                              <td width='150px;' style='text-align:right'>".number_format($totHarga,0,"",".")."</td>
                          </tfoot>";
            echo "</table><br/><br/>";
            
            }
            $perujuk_temp = $perujuk;
        }
    ?> 
</div>

<?php }else if($tab == "rs"){ ?>
<div id="div_rujukanRS">
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'tableRujukanRS',
            'dataProvider'=>$dataRS,
                'template'=>$template,
                'enableSorting'=>$sort,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header' => '<center>No</center>',
                    'type'=>'raw',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    'footerHtmlOptions'=>array('colspan'=>4,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                ),
                array(
                    'header' => '<center>No. Pendaftaran Lab</center>',
                    'type'=>'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => '<center>Nama Pasien</center>',
                    'type'=>'raw',
                    'value' => '$data->nama_pasien'
                ),
                array(
                    'header' => '<center>No. RM / Pelayanan</center>',
                    'type'=>'raw',
                    'value' => '$data->no_rekam_medik." / ".$data->daftartindakan_nama'
                ),
                array(
                    'header' => '<center>Total</center>',
                    'name'=>'total',
                    'type'=>'raw',
                    'value' => 'number_format($data->total,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(total)',
                ),
                array(
                    'header' => '<center>Bayar</center>',
                    'name'=>'jmlbayar_tindakan',
                    'type'=>'raw',
                    'value' => 'number_format($data->jmlbayar_tindakan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(jmlbayar_tindakan)',
                ),
                array(
                    'header' => '<center>Sisa</center>',
                    'name'=>'jmlsisabayar_tindakan',
                    'type'=>'raw',
                    'value' => 'number_format($data->jmlsisabayar_tindakan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(jmlsisabayar_tindakan)',
                ),
            ),
        )); ?> 
</div>
<?php } ?>