<?php 
    $rim = 'width:950px;overflow-x:scroll;';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $data = $model->searchKasHarian();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $data = $model->searchPrintKasHarian(); 
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>

<div id="rekapKas">
    <div style="<?php echo $rim; ?>">
       <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
        <legend class="rim"> Table Rekap Kas Harian </legend>
       <?php } ?>
    <?php 
        $this->widget($table,array(
            'id'=>'laporankasharianlab-grid',
            'dataProvider'=>$data,
            'enableSorting'=>$sort,
            'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
             'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>PENERIMAAN KAS</center>',
                        'start'=>2, //indeks kolom 3
                        'end'=>5, //indeks kolom 4
                    ),
                ),
                'columns'=>array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                      'header'=>'URAIAN',
                      'type'=>'raw',
                      'value'=>'(empty($data->gelardepan) ? "-" : "$data->gelardepan" )',
                    ),
                    array(
                      'header'=>'TUNAI',
                      'type'=>'raw',
                      'value'=>'(empty($data->nama_pegawai) ? "-" : "$data->nama_pegawai" )',
                    ),
                    array(
                      'header'=>'PIUTANG',
                      'type'=>'raw',
                      'value'=>'(empty($data->gelarbelakang_nama) ? "-" : "$data->gelarbelakang_nama" )',
                    ),
                    array(
                      'header'=>'TOTAL',
                      'type'=>'raw',
                      'value'=>'(empty($data->gelarbelakang_nama) ? "-" : "$data->gelarbelakang_nama" )',
                    ),
                    array(
                      'header'=>'BERSYARAT PIUTANG BARU',
                      'type'=>'raw',
                      'value'=>'(empty($data->gelarbelakang_nama) ? "-" : "$data->gelarbelakang_nama" )',
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); 
        ?>
    </div>
</div>

<div id="detailKas">
    <div style="<?php echo $rim; ?>">
        <?php
            if(isset($caraPrint)){
                $dataDetail = $model->searchPrintDetailKas();
            }else{
                $dataDetail = $model->searchDetailKas();
        ?>
        <legend class="rim"> Table Detail Kas Harian</legend>
        <?php } ?>
    <?php 
        $this->widget($table,array(
            'id'=>'laporankasharianlab-grid',
            'dataProvider'=>$dataDetail,
            'enableSorting'=>$sort,
            'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                 'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Dokter</center>',
                        'start'=>7, //indeks kolom 3
                        'end'=>9, //indeks kolom 4
                    ),
                    array(
                        'name'=>'<center>Bedah</center>',
                        'start'=>12, //indeks kolom 3
                        'end'=>15, //indeks kolom 4
                    ),
                ),
                'columns'=>array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                      'header'=>'Tgl. Transaksi',
                      'type'=>'raw',
                      'value'=>'$data->tgl_pendaftaran',
                    ),
                    array(
                      'header'=>'No. Rekam Medik',
                      'type'=>'raw',
                      'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                      'header'=>'Nama Lengkap',
                      'type'=>'raw',
                      'value'=>'$data->nama_pasien',
                    ),
                    array(
                      'header'=>'Unit Pelayanan',
                      'type'=>'raw',
                      'value'=>'$data->instalasi_nama',
                    ),
                    array(
                      'header'=>'Nama Ruangan',
                      'type'=>'raw',
                      'value'=>'$data->ruangan_nama',
                    ),
                    array(
                      'header'=>'Jumlah',
                      'type'=>'raw',
                      'value'=>'$data->qty_tindakan',
                    ),
                    array(
                      'header'=>'Gelar Depan',
                      'type'=>'raw',
                      'value'=>'(empty($data->gelardepan) ? "-" : "$data->gelardepan" )',
                    ),
                    array(
                      'header'=>'Nama Dokter',
                      'type'=>'raw',
                      'value'=>'(empty($data->nama_pegawai) ? "-" : "$data->nama_pegawai" )',
                    ),
                    array(
                      'header'=>'Gelar Belakang',
                      'type'=>'raw',
                      'value'=>'(empty($data->gelarbelakang_nama) ? "-" : "$data->gelarbelakang_nama" )',
                    ),
                   
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>
</div>

<br/>