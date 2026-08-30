<div class="white-container">
    <legend class="rim2">Laporan Pasien <b>Demam Berdarah</b></legend>
    <?php
        
        $url = Yii::app()->createUrl('bankDarah/laporan/frameGrafikPasienDBD&id=1');
    //    Yii::app()->clientScript->registerScript('search', "
    //    $('#searchLaporan').submit(function()
    //    {
    //        if($(\"#filter_tab\").val() == 'rekap')
    //        {
    //            $.fn.yiiGridView.update('tableRekapPasienDBD', {
    //                    data: $(\"#searchLaporan\").serialize()
    //                }
    //            );
    //        }else{
    //            $.fn.yiiGridView.update('rincianPasienDBD', {
    //                    data: $(\"#searchLaporan\").serialize()
    //                }
    //            );
    //        }
    //        $('#Grafik').attr('src','').css('height','0px');
    //        return false;
    //    });
    //    ");
            Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $('#tableRekapPasienDBD').addClass('animation-loading');
            $.fn.yiiGridView.update('tableRekapPasienDBD', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('bankDarah.views.laporan.pasienDBD/_search',
                array('model'=>$model,'tgl_awal'=>$model->tgl_awal,'tgl_akhir'=>$model->tgl_akhir)); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>DBD - Rekapitulasi</b></h6>
        <?php $this->renderPartial('bankDarah.views.laporan.pasienDBD/_table', array('model'=>$model)); ?>
    </div>            
    <div class="block-tabel">
        <?php $this->renderPartial('bankDarah.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>       
    </div>
    <?php   
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPasienDBD');
		$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>
<?php
$js= <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_rekap").show();
        $("#div_detail").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('rekap');
            $("#div_rekap").show();
            $("#div_detail").hide();
            $.fn.yiiGridView.update('tableRekapPasienDBD', {
                    data: $("#searchLaporan").serialize()
                }
            );            
        } else if (index==1){
            $("#filter_tab").val('detail');
            $("#div_rekap").hide();
            $("#div_detail").show();
            $.fn.yiiGridView.update('rincianPasienDBD', {
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
            if($("#filter_tab").val() == 'rekap')
            {
                $.fn.yiiGridView.update('tableRekapPasienDBD', {
                        data: $("#searchLaporan").serialize()
                    }
                );
            }else{
                $.fn.yiiGridView.update('rincianPasienDBD', {
                        data: $("#searchLaporan").serialize()
                    }
                );
            }
        }, 500
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pasienDBD',$js,CClientScript::POS_HEAD);
$this->renderPartial('_jsFunctions', array('model'=>$model));
?>

