<?php 
    $url = Yii::app()->createUrl('laboratoriumPA/laporan/frameGrafikPemeriksaanRujukan&id=1');
    $rim = 'width:600px;overflow-x:none;';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $dataRS = $modelRS->searchTableLaporan();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $dataRS = $modelRS->searchPrintLaporan();
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>
<?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('tableRujukanLuar', {
                    data: $(this).serialize()
            });
            $.fn.yiiGridView.update('tableRujukanRS', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
<div class="search-form">
        <?php $this->renderPartial('laboratoriumPA.views.laporan.pemeriksaanRujukan/_searchPemeriksaanRujukanRS',
                array('modelRS'=>$modelRS)); ?>
</div>
<div class="block-tabel">
    <h6>Tabel Pemeriksaan <b>Rujukan - Dari RS</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'tableRujukanRS',
            'dataProvider'=>$dataRS,
                'template'=>$template,
                'enableSorting'=>$sort,
                'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header' => '<center>No</center>',
                    'type'=>'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                ),
                array(
                    'header' => '<center>Tanggal Masuk Penunjang</center>',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)'
                ),
                array(
                    'header' => '<center>No. Pendaftaran Lab</center>',
                    'type'=>'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => '<center>No Rekam Medik</center>',
                    'value' => '$data->no_rekam_medik'
                ),
                array(
                    'header' => '<center>Nama Pasien</center>',
                    'type'=>'raw',
                    'value' => '$data->namadepan." ".$data->nama_pasien'
                ),
                array(
                    'header' => '<center>Pelayanan</center>',
                    'type'=>'raw',
                    'value' => '$data->daftartindakan_nama'
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
<div class="block-tabel"> 
    <?php $this->renderPartial('laboratoriumPA.views.laporan._tab'); ?>
   
    <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
    </iframe>       
</div>
<?php   
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPemeriksaanRujukanRS');
    $this->renderPartial('laboratoriumPA.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
    $this->renderPartial('_jsFunctions', array('model'=>$modelRS));
?>
<?php
$js= <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_rujukanLuar").show();
        $("#div_rujukanRS").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('luar');
            $("#div_rujukanLuar").show();
            $("#div_rujukanRS").hide();  
        } else if (index==1){
            $("#filter_tab").val('rs');
            $("#div_rujukanLuar").hide();
            $("#div_rujukanRS").show();
        }
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('tableRujukanLuar', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('tableRujukanRS', {
                data: $("#searchLaporan").serialize()
            });       
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pemeriksaanRujukan',$js,CClientScript::POS_HEAD);
?>