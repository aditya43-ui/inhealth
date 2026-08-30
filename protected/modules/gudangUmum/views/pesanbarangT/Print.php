
  
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
   echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan'=>$judulLaporan,'periode'=>'','colspan'=>6));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                if($caraPrint != 'EXCEL'){
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array('judulLaporan'=>$judulLaporan,'periode'=>''));
                } ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
     <?php 
    
    $itemCssClass='table table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
				
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
  <?php 
$this->widget($table,array(
	'id'=>'gupesanbarang-t-grid',
    'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
    'template'=>$template,
    'itemsCssClass' => $itemCssClass,
	'columns'=>array(
        array(
            'header'=>'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                : ($row+1)',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
            'header' => 'Tgl. Pemesan',
            'name' => 'tglpesanbarang',
            'value' => '$data->tglpesanbarang',
        ),
        array(
            'header' => 'No. Pemesan',
            'type' => 'raw',
            'name' => 'nopemesanan',
            'value' => function($data) {
                return CHtml::link('<u>' . $data->nopemesanan . '</u>', Yii::app()->controller->createUrl("/gudangUmum/PesanbarangT/detailPesanBarang", array('id' => $data->pesanbarang_id)), array(
                            "id" => $data->pesanbarang_id, "target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pemesanan Barang", "onclick" => "window.parent.$('#dialogDetail').dialog('open');"
                ));
            },
        ),
        array(
            'header' => 'Ruangan/<br>Pegawai Pemesan',
            'value' => '$data->ruanganpemesan->ruangan_nama." \ ".$data->pegawaipemesan->nama_pegawai'
        ),
        'keterangan_pesan',
        array(
            'header' => 'Tgl. Kirim',
            'value' => '$data->tglmintadikirim',
        ),
        array(
            'header' => 'Pegawai Pengirim',
            'value' => function($data) use (&$mutasi) {

                $mutasi = MutasibrgT::model()->findAllByAttributes(array(
                    'pesanbarang_id' => $data->pesanbarang_id
                ));

                if (empty($data->mutasibrg_id)) {
                    return '-';
                } else {
                    $p = GUMutasibrgT::model()->findByPk($data->mutasibrg_id);

                    return $p->pegawaipengirim->nama_pegawai;
                }
            }
        ),

    ),
)); 
 ?>

		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php   echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array('judulLaporan'=>$judulLaporan,'periode'=>'')); ?>
</div>
<div class="content">
   
 <?php 
 
    $itemCssClass='table table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
				
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
 
$this->widget($table,array(
	'id'=>'gupesanbarang-t-grid',
    'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
    'template'=>$template,
    'itemsCssClass' => $itemCssClass,
	'columns'=>array(
        array(
            'header'=>'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                : ($row+1)',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
            'header' => 'Tgl. Pemesan',
            'name' => 'tglpesanbarang',
            'value' => '$data->tglpesanbarang',
        ),
        array(
            'header' => 'No. Pemesan',
            'type' => 'raw',
         
            'value' => function($data) {
                return $data->nopemesanan;
            },
        ),
        array(
            'header' => 'Ruangan/<br>Pegawai Pemesan',
            'value' => '$data->ruanganpemesan->ruangan_nama." \ ".$data->pegawaipemesan->nama_pegawai'
        ),
        'keterangan_pesan',
        array(
            'header' => 'Tgl. Kirim',
            'value' => '$data->tglmintadikirim',
        ),
        array(
            'header' => 'Pegawai Pengirim',
            'value' => function($data) use (&$mutasi) {

                $mutasi = MutasibrgT::model()->findAllByAttributes(array(
                    'pesanbarang_id' => $data->pesanbarang_id
                ));

                if (empty($data->mutasibrg_id)) {
                    return '-';
                } else {
                    $p = GUMutasibrgT::model()->findByPk($data->mutasibrg_id);

                    return $p->pegawaipengirim->nama_pegawai;
                }
            }
        ),

    ),
)); 
?>
</div>

<?php
}
if ($caraPrint == 'GRAFIK'){
 ?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
  echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                     
  
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
  
<?php
}
?>