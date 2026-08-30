<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
                        <br>
                <?php  $table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchGudangFarmasiPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
        
        }
        else if($caraPrint == "PDF"){
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }

$this->widget($table,array(
	'id'=>'gfobat-alkes-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table border',
	'columns'=>array(
				array(
					'header' => 'No',
					'value' => '$row+1'
				),
                array(
                    'header'=>'Kode Obat',
                    'name'=>'obatalkes_kode',
                    'value'=>'$data->obatalkes_kode',
                ),
		array(
                    'header'=>'Nama Obat',
                    'name'=>'obatalkes_nama',
                    'value'=>'$data->obatalkes_nama',
                ),
		array(
                    'header'=>'Sumber Dana',
                    'name'=>'sumberdanaNama',
                    'value'=>'$data->sumberdana->sumberdana_nama',
                ),
                array(
                        'header' => 'Jenis Kelompok',
                        'name' => 'jnskelompok',
                        'value' => function($data){
                            return $data->getNameLookup($data->jnskelompok);
                        },
                       // 'filter' => Chtml::activeDropDownList($model, 'jnskelompok', LookupM::getItems('jnskelompok'), array('empty'=>'-- Pilih --'))
                    ),
		array(
                    'header'=>'Jenis Obat',
                    'name'=>'jenisobatalkes_id',
                    'value'=>'(isset($data->jenisobatalkes->jenisobatalkes_nama) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
                ),
		array(
                    'header'=>'Satuan Besar',
                    'name'=>'satuanbesar_id',
                    'value'=>'(isset($data->satuanbesar->satuanbesar_nama) ? $data->satuanbesar->satuanbesar_nama : "")',
                ),                
		array(
                    'header'=>'Satuan Kecil',
                    'name'=>'satuankecil_id',
                    'value'=>'(isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "")',
                ),
                array(
                    'header'=>'Tgl. Kadaluarsa',
                    'name'=>'tglkadaluarsa',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
                ),
		/*array(
                    'header'=>'Isi Kemasan  / <br> Min. Stok',
                    'type'=>'raw',
                    'value'=>'$data->kemasanbesar ."/ <br/>". $data->minimalstok',
                ),*/
                array(
                    'header'=>'Harga Netto',
                    'name'=>'harganetto',
                    'type'=>'raw',
                    'value'=>'"Rp".number_format($data->harganetto,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
				array(
					'header' => 'PPN (%)',
					'value' => '$data->ppn_persen',
					'htmlOptions' => array('style' => 'text-align:right;')
				),
				array(
					'header' => 'HPP',
					'value'=>'"Rp".number_format($data->hpp,0,"",".")',
					'htmlOptions' => array('style' => 'text-align:right;')
				),
				array(
					'header' => 'Margin (%)',
					'value' => '$data->margin',
					'htmlOptions' => array('style' => 'text-align:right;')
				),
				array(
                    'header'=>'Harga Jual',
                    'name'=>'hargajual',
                    'type'=>'raw',
                    'value'=>'"Rp".number_format($data->hargajual,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
               /* array(
                    'header'=>'HJA Resep',
                    'name'=>'hjaresep',
                    'type'=>'raw',
                    'value'=>'"Rp".number_format($data->hjaresep,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'HJA Non-Resep',
                    'name'=>'hjanonresep',
                    'type'=>'raw',
                    'value'=>'"Rp".number_format($data->hjanonresep,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                 array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->obatalkes_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),*/
	),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
));       ?>
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
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
     <br>
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchGudangFarmasiPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
        
        }
        else if($caraPrint == "PDF"){
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }

$this->widget($table,array(
	'id'=>'gfobat-alkes-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table border',
	'columns'=>array(
				array(
					'header' => 'No',
					'value' => '$row+1'
				),
                array(
                    'header'=>'Kode Obat',
                    'name'=>'obatalkes_kode',
                    'value'=>'$data->obatalkes_kode',
                ),
		array(
                    'header'=>'Nama Obat',
                    'name'=>'obatalkes_nama',
                    'value'=>'$data->obatalkes_nama',
                ),
		array(
                    'header'=>'Sumber Dana',
                    'name'=>'sumberdanaNama',
                    'value'=>'$data->sumberdana->sumberdana_nama',
                ),
                array(
                        'header' => 'Jenis Kelompok',
                        'name' => 'jnskelompok',
                        'value' => function($data){
                            return $data->getNameLookup($data->jnskelompok);
                        },
                       // 'filter' => Chtml::activeDropDownList($model, 'jnskelompok', LookupM::getItems('jnskelompok'), array('empty'=>'-- Pilih --'))
                    ),
		array(
                    'header'=>'Jenis Obat',
                    'name'=>'jenisobatalkes_id',
                    'value'=>'(isset($data->jenisobatalkes->jenisobatalkes_nama) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
                ),
		array(
                    'header'=>'Satuan Besar',
                    'name'=>'satuanbesar_id',
                    'value'=>'(isset($data->satuanbesar->satuanbesar_nama) ? $data->satuanbesar->satuanbesar_nama : "")',
                ),                
		array(
                    'header'=>'Satuan Kecil',
                    'name'=>'satuankecil_id',
                    'value'=>'(isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "")',
                ),
                array(
                    'header'=>'Tgl. Kadaluarsa',
                    'name'=>'tglkadaluarsa',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
                ),
		/*array(
                    'header'=>'Isi Kemasan  / <br> Min. Stok',
                    'type'=>'raw',
                    'value'=>'$data->kemasanbesar ."/ <br/>". $data->minimalstok',
                ),*/
                array(
                    'header'=>'Harga Netto',
                    'name'=>'harganetto',
                    'type'=>'raw',
                    'value'=>'"Rp".number_format($data->harganetto,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
				array(
					'header' => 'PPN (%)',
					'value' => '$data->ppn_persen',
					'htmlOptions' => array('style' => 'text-align:right;')
				),
				array(
					'header' => 'HPP',
					'value'=>'"Rp".number_format($data->hpp,0,"",".")',
					'htmlOptions' => array('style' => 'text-align:right;')
				),
				array(
					'header' => 'Margin (%)',
					'value' => '$data->margin',
					'htmlOptions' => array('style' => 'text-align:right;')
				),
				array(
                    'header'=>'Harga Jual',
                    'name'=>'hargajual',
                    'type'=>'raw',
                    'value'=>'"Rp".number_format($data->hargajual,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
               /* array(
                    'header'=>'HJA Resep',
                    'name'=>'hjaresep',
                    'type'=>'raw',
                    'value'=>'"Rp".number_format($data->hjaresep,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'HJA Non-Resep',
                    'name'=>'hjanonresep',
                    'type'=>'raw',
                    'value'=>'"Rp".number_format($data->hjanonresep,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                 array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->obatalkes_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),*/
	),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
)); 
?>
</div>

<?php
}

 ?>