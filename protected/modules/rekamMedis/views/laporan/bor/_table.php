<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
         $row = '$row+1';
        $data = $model->searchTablePrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        

        $itemCssClass='table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php 
    $kelas = KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif' => true),array('order' => 'kelaspelayanan_nama ASC'));
    $tgl_awal = $model->tgl_awal;
    $tgl_akhir = $model->tgl_akhir;
    
    $gridColumn[] = array(
        'header'=>'No.',
        'value' => $row,
        'headerHtmlOptions' => array(
            'style' => 'text-align:center;'
        ),
        'htmlOptions' => array(
            'style' => 'text-align:center;'
        ),
    );
    
    foreach($kelas as $kls){
        $kelaspelayanan_id = $kls->kelaspelayanan_id;
        $gridColumn[] = array(
            'header' => $kls->kelaspelayanan_nama,
            'value' => function($model) use ($kls, $tgl_awal, $tgl_akhir){
                return $model->getBorKelas($kls->kelaspelayanan_id, $tgl_awal, $tgl_akhir);
            },
            'headerHtmlOptions' => array(
                'style' => 'text-align:center;'
            ),
            'htmlOptions' => array(
                'style' => 'text-align:center;'
            ),
        );
    }

    $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
         'mergeHeaders'=>array(
                array(
                    'name'=>'<p style="margin: 0; text-align: center;">Kelas Pelayanan</p>',
                    'start'=>'1',
                    'end'=>count((array)$kelas),
                ),
            ),
	'columns'=> $gridColumn,
           	
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>