<?php
  $table = 'ext.bootstrap.widgets.BootGridView';
  $itemCssClass='table table-bordered datatable';
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = '{items}';
  if ($caraPrint=='EXCEL') {
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
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
$itemCssClass='table border';
} else{
  $data = $model->searchTableLaporan();
  $template = "{summary}{items}{pager}";
}
?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
<div style='max-width:1000px;overflow-y: scroll;'>
<?php } ?>
<?php $this->widget($table,array(
	'id'=>'PPInfoKunjungan-v',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
             array(
              'header' => 'No.',
              'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
              'type'=>'raw',
            ),
            array(
                  'header'=>'Tgl. Pendaftaran/<br>No. Pendaftaran ',
                  'type'=>'raw',
                  'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran)))."/<br>".$data->no_pendaftaran',
                ),                
                array(
                  'header'=>'No. Rekam Medik',
                  'type'=>'raw',
                  'value'=>'$data->no_rekam_medik',
                ),
    //            'no_rekam_medik',    
                array(
                  'header'=>'Nama Pasien / Alias',
                  'type'=>'raw',
                  'value'=>'$data->NamaNamaBIN',
                ),
    //            'NamaNamaBIN',
                array(
                  'header'=>'Jenis Kelamin',
                  'type'=>'raw',
                  'value'=>'$data->jeniskelamin',
                ),
                array(
                  'header'=>'Golongan Umur',
                  'type'=>'raw',
                  'value'=>'$data->golonganumur_nama',
                ),
                array(
                  'header'=>'Agama',
                  'type'=>'raw',
                  'value'=>'$data->agama',
                ),
                array(
                  'header'=>'Status Perkawinan',
                  'type'=>'raw',
                  'value'=>'$data->statusperkawinan',
                ),
                array(
                  'header'=>'Pekerjaan',
                  'type'=>'raw',
                  'value'=>'$data->pekerjaan_nama',
                ),
                array(
                  'header'=>'Alamat Lengkap',
                  'type'=>'raw',
                  'value'=>'$data->alamat_pasien',
                ),
    //            'alamat_pasien',
                array(
                  'header'=>'Kecamatan',
                  'type'=>'raw',
                  'value'=>'$data->kecamatan_nama',
                ),
                array(
                  'header'=>'Kab. / Kota. ',
                  'type'=>'raw',
                  'value'=>'$data->kabupaten_nama',
                ),

                array(
                  'header'=>'Cara Masuk',
                  'type'=>'raw',
                  'value'=>'$data->statusmasuk',
                ),
                array(
                  'header'=>'Kunjungan',
                  'type'=>'raw',
                  'value'=>'$data->kunjungan',
                ),

                array(
                  'header'=>'Penanggung Jawab / Pihak Ke-3',
                  'type'=>'raw',
                  'value'=>'$data->nama_pj',
                ),
                array(
                  'header'=>'Nama Perujuk',
                  'type'=>'raw',
                  'value'=>'$data->nama_perujuk',
                ),
                array(
                  'header'=>'Jenis Kasus Penyakit',
                  'type'=>'raw',
                  'value'=>'$data->jeniskasuspenyakit_nama',
                ),
    //            'Jenis_kasus_nama_penyakit',
                array(
                   'name'=>'CaraBayar/Penjamin',
                   'type'=>'raw',
                   'value'=>'$data->CaraBayarPenjamin',
                   'htmlOptions'=>array('style'=>'text-align: center')
                ),            
                array(
                   'header'=>'Instalasi/<br>Ruangan Poliklinik',
                  // 'name'=>'ruangan_nama',
                   'type'=>'raw',
                   'value'=>'$data->instalasi_nama."/<br>".$data->ruangan_nama',
                   'htmlOptions'=>array('style'=>'text-align: center')
                ),
                array(
                   'name'=>'Nama Dokter Poli',
                   'type'=>'raw',
                   'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                   'htmlOptions'=>array('style'=>'text-align: center')
                ),
            array(
                   'header'=>'Ket. Pulang',
                   'type'=>'raw',
                   //'value'=>'$data->nama_pegawai',
                    'value' => function ($data){
                        $cek = PasienpulangT::model()->find(" pendaftaran_id  = '".$data->pendaftaran_id."' ");
                        if (!empty($cek)){
                            echo $cek->keterangankeluar;
                        }else{
                            echo "-";
                        }
                    },
                   'htmlOptions'=>array('style'=>'text-align: center')
                ),
                array(
                   'header'=>'Status Periksa',
                   'type'=>'raw',
                   'value'=>'$data->statusperiksa',
                   'htmlOptions'=>array('style'=>'text-align: center')
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
</div>
<?php } ?>