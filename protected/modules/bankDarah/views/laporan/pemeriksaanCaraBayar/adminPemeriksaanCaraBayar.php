<div class="white-container">
    <legend class="rim2">Laporan Pemeriksaan <b>Jenis Penjamin</b></legend>
    <?php

    $url = Yii::app()->createUrl('bankDarah/laporan/frameGrafikPemeriksaanCaraBayar&id=1');
    Yii::app()->clientScript->registerScript('search', "
        $('#searchLaporan').submit(function()
        {
            $('#tableGroupPemeriksaanCaraBayar').addClass('animation-loading');
            $('#rincianPmeriksaanLab').addClass('animation-loading');
            if($(\"#filter_tab\").val() == 'pemeriksaan')
            {
                $.fn.yiiGridView.update('tableGroupPemeriksaanCaraBayar', {
                        data: $(\"#searchLaporan\").serialize()
                    }
                );
            }else{
                $.fn.yiiGridView.update('rincianPmeriksaanLab', {
                        data: $(\"#searchLaporan\").serialize()
                    }
                );
            }
            $('#Grafik').attr('src','').css('height','0px');

            return false;
        });
        ");
    ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial(
            'bankDarah.views.laporan.pemeriksaanCaraBayar/_searchPemeriksaanCaraBayar',
            array('model' => $model, 'modelPerusahaan' => $modelPerusahaan)
        ); ?>
    </fieldset>

    <?php
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type' => 'tabs',
        'stacked' => false,
        'htmlOptions' => array('id' => 'tabmenu'),
        'items' => array(
            array('label' => 'Pemeriksaan', 'url' => 'javascript:tab(0);', 'active' => true),
            array('label' => 'Rincian', 'url' => 'javascript:tab(1);', 'itemOptions' => array("index" => 1)),
        ),
    ))
    ?>

    <div>
        <div class="block-tabel" id="div_group">
            <h6>Pemeriksaan <b>Jenis Penjamin</b></h6>
            <?php $this->renderPartial('bankDarah.views.laporan.pemeriksaanCaraBayar/_tablePemeriksaanCaraBayar', array('model' => $model, 'modelPerusahaan' => $modelPerusahaan)); ?>
        </div>
        <div class="block-tabel" id="div_perusahaan">
            <h6>Rincian <b>Tindakan</b></h6>
            <?php $this->renderPartial('bankDarah.views.laporan.pemeriksaanCaraBayar/_tableRincianCaraBayar', array('model' => $model, 'modelPerusahaan' => $modelPerusahaan)); ?>
        </div>
    </div>

    <div class="block-tabel">
        <?php $this->renderPartial('bankDarah.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
    </div>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPemeriksaanCaraBayar');
    $this->renderPartial('bankDarah.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url));
    ?>
</div>
<?php
$js = <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_group").show();
        $("#div_perusahaan").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('pemeriksaan');
            $("#div_group").show();
            $("#div_perusahaan").hide();
            $.fn.yiiGridView.update('tableGroupPemeriksaanCaraBayar', {
                    data: $("#searchLaporan").serialize()
                }
            );            
        } else if (index==1){
            $("#filter_tab").val('rincian');
            $("#div_group").hide();
            $("#div_perusahaan").show();
            $.fn.yiiGridView.update('rincianPmeriksaanLab', {
                    data: $("#searchLaporan").serialize()
                }
            );
        }
   }
function onReset()
{
    setTimeout(
        function()
        {
            if($("#filter_tab").val() == 'pemeriksaan')
            {
                $.fn.yiiGridView.update('tableGroupPemeriksaanCaraBayar', {
                        data: $("#searchLaporan").serialize()
                    }
                );
            }else{
                $.fn.yiiGridView.update('rincianPmeriksaanLab', {
                        data: $("#searchLaporan").serialize()
                    }
                );
            }
        }, 500
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pemeriksaanCaraBayar', $js, CClientScript::POS_HEAD);
?>