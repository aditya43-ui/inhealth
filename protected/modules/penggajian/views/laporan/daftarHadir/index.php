<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('PPInfoKunjungan-v', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Laporan <b>Detail Presensi</b></legend>
    <div class="search-form">
        <?php
            $this->renderPartial('daftarHadir/_search',
                array(
                    'model'=>$model,
                )
            );
        ?>
    </div>
    <div class="block-tabel">
        <h6>Tabel Laporan <b>Detail Presensi</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView',
            array(
                'id'=>'lapegawai-m-grid',
                'dataProvider'=>$model->searchByNofinger(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                    array(
                        'header' => 'No.',
                        'value' => '$row+1'
                    ),
                    'nomorindukpegawai',
                    'nama_pegawai',
                    'unit_perusahaan',
                    'jeniskelamin',
                    'kelompokpegawai.kelompokpegawai_nama',
                    'jabatan.jabatan_nama',
                    array(
                       'type'=>'raw',
                       'value'=>'CHtml::link("<i class=icon-form-detail></i><br>Daftar Hadir", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/laporan/detailLaporanAbsen",array("id"=>"$data->pegawai_id")), array("target"=>"frame_detail", "onclick"=>"$(\'#detailAbsen\').dialog(\'open\');", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Detail Daftar Hadir"))',
                       'htmlOptions'=>array('style'=>'text-align: center')
                    ),
                ),
                'afterAjaxUpdate'=>'
                    function(id, data){
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                }',
            )
        );
        ?>
    </div>
    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog',
            array(
                'id'=>'detailAbsen',
                'options'=>array(
                    'title'=>'Detail Absen Pegawai',
                    'autoOpen'=>false,
                    'minWidth'=>500,
                    'width'=>900,
                    'modal'=>true,
                ),
            )
        );
    ?>
    <iframe src="" height="500" width="100%"  name="frame_detail"></iframe>
    <?php
        $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintDetailPresensi');
        $this->renderPartial('daftarHadir/_footer', array('urlPrint'=>$urlPrint));
    ?>
</div>