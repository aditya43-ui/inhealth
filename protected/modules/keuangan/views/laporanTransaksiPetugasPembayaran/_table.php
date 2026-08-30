<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
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
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }


$col = array(
    array(
        'header'=>'NO.',
        'value' => $row,
        'headerHtmlOptions' => array('style' => 'text-align: center;'),
        'footerHtmlOptions' => array('colspan' => $this->is_umum ? 4 : 5, 'style' => 'text-align:left;'),
        'footer' => '<b>JUMLAH TOTAL</b>',
    ),
    array(
        'name' => 'no_pendaftaran',
        'header'=>'NO. BILLING',
        'headerHtmlOptions' => array('style' => 'text-align: center;'),
        'footerHtmlOptions' => ['class' => 'hide'],

    )
);

if ($this->is_umum) {
    array_push($col,
        array(
            'name' => 'nobuktibayar',
            'header'=>'NO. BUKTI',
            'headerHtmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => ['class' => 'hide'],
        )
    );
}

array_push($col,
    array(
        'name' => 'nama_pasien',
        'header'=>'NAMA PASIEN',
        'headerHtmlOptions' => array('style' => 'text-align: center;'),
        'footerHtmlOptions' => ['class' => 'hide'],

    )
);

if (!$this->is_umum) {
    array_push($col, array(
        'name' => 'carabayar_nama',
        'header'=>'JENIS PENJAMIN',
        'footerHtmlOptions' => ['class' => 'hide'],
    ), array(
        'name' => 'penjamin_nama',
        'header'=>'PENJAMIN',
        'footerHtmlOptions' => ['class' => 'hide'],
    ));
}

array_push($col,array(
    'name' => 'jmlpembayaran',
    'type'=>'raw',
    'header'=>'JUMLAH',
    'value' => function ($data){
        return MyFormatter::formatNumberForPrint($data->jmlpembayaran, 2);
    },
    'htmlOptions' => array('style' => 'text-align: right;'),
    'headerHtmlOptions' => array('style' => 'text-align: center;'),
    'footerHtmlOptions' => array('colspan' => 1, 'style' => 'text-align:right; font-weight: bold;'),
    'footer' => $model->getTotal()
));

$this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	    'columns'=>$col,
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php

if (isset($caraPrint)){

    $pg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

    ?>


<table style="width: 92%; margin-left: 0px; margin-right: 0px;">
    <tr>
        <td style="width: 70%;">Dengan Huruf :</td>
        <td>Malang, <?php echo MyFormatter::formatDateTimeId(date('Y-m-d')) ?></td>
    </tr>
    <tr>
        <td><?php echo ucwords(MyFormatter::formatNumberTerbilang($model->getTotal())) . " Rupiah" ?></td>
        <td>Nama Petugas</td>
    </tr>
    <tr>
        <td style="line-height: 75px;"><br><br><br></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo $pg->namaLengkap ?></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo $pg->nomorindukpegawai ?></td>
    </tr>
</table>
    
    
    <?php
}

?>