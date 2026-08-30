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

 <table style="width: 100%; border: none;">
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
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
                        <br>
                <?php  $grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

$prov = $model->searchPrint();

$this->widget($grid_view, array(
    'id' => 'informasipemakaianbahanmakananprint-v-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
       array(
                                'header'=>'No.',
                                'value' => '($this->grid->dataProvider->pagination) ? 
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    : ($row+1)',
                                'type'=>'raw',
                                'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            array(
                                'header'=>'Instalasi Nama',
                                'type'=>'raw',
                                'value'=>'$data->instalasi_nama',
                            ),
                            array(
                                'header'=>'Ruangan Nama',
                                'type'=>'raw',
                                'value'=>'$data->ruangan_nama',
                            ),
                            array(
                                'header'=>'Tanggal Pemakaian Bahan Makanan',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemakaianbhnmkn)',
                            ),
                            array(
                                'name'=>'No Pemakaian Bahan Makanan',
                                'type'=>'raw',
                                'value'=>'$data->no_pemakaianbhnmkn',
                            ),
                            array(
                                'header'=>'Untuk Keperluan',
                                'type'=>'raw',
                                'value'=>'$data->untukkeperluan',
                            ),
                            array(
                                'header'=>'Keterangan Pemakaian',
                                'type'=>'raw',
                                'value'=>'$data->ketpemakaian',
                            )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
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
<?php $grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

$prov = $model->searchPrint();

$this->widget($grid_view, array(
    'id' => 'informasipemakaianbahanmakananprint-v-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
       array(
                                'header'=>'No.',
                                'value' => '($this->grid->dataProvider->pagination) ? 
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    : ($row+1)',
                                'type'=>'raw',
                                'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            array(
                                'header'=>'Instalasi Nama',
                                'type'=>'raw',
                                'value'=>'$data->instalasi_nama',
                            ),
                            array(
                                'header'=>'Ruangan Nama',
                                'type'=>'raw',
                                'value'=>'$data->ruangan_nama',
                            ),
                            array(
                                'header'=>'Tanggal Pemakaian Bahan Makanan',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemakaianbhnmkn)',
                            ),
                            array(
                                'name'=>'No Pemakaian Bahan Makanan',
                                'type'=>'raw',
                                'value'=>'$data->no_pemakaianbhnmkn',
                            ),
                            array(
                                'header'=>'Untuk Keperluan',
                                'type'=>'raw',
                                'value'=>'$data->untukkeperluan',
                            ),
                            array(
                                'header'=>'Keterangan Pemakaian',
                                'type'=>'raw',
                                'value'=>'$data->ketpemakaian',
                            )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
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
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?> </div>
                        <br>
                        <?php $grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

$prov = $model->searchPrint();

$this->widget($grid_view, array(
    'id' => 'informasipemakaianbahanmakananprint-v-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
       array(
                                'header'=>'No.',
                                'value' => '($this->grid->dataProvider->pagination) ? 
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    : ($row+1)',
                                'type'=>'raw',
                                'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            array(
                                'header'=>'Instalasi Nama',
                                'type'=>'raw',
                                'value'=>'$data->instalasi_nama',
                            ),
                            array(
                                'header'=>'Ruangan Nama',
                                'type'=>'raw',
                                'value'=>'$data->ruangan_nama',
                            ),
                            array(
                                'header'=>'Tanggal Pemakaian Bahan Makanan',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemakaianbhnmkn)',
                            ),
                            array(
                                'name'=>'No Pemakaian Bahan Makanan',
                                'type'=>'raw',
                                'value'=>'$data->no_pemakaianbhnmkn',
                            ),
                            array(
                                'header'=>'Untuk Keperluan',
                                'type'=>'raw',
                                'value'=>'$data->untukkeperluan',
                            ),
                            array(
                                'header'=>'Keterangan Pemakaian',
                                'type'=>'raw',
                                'value'=>'$data->ketpemakaian',
                            )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
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