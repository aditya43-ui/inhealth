<?php
$url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLaporanPembelian&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#search-laporan').submit(function()
    {
    if($(\"#filter_tab\").val() == 'rekap')
        {
            $.fn.yiiGridView.update('rekapLaporanFakturPembelian', {
                    data: $(\"#search-laporan\").serialize()
                }
            );
        }else{
            $.fn.yiiGridView.update('rincianLaporanFakturPembelian', {
                    data: $(\"#search-laporan\").serialize()
                }
            );
        }
        $('#Grafik').attr('src','').css('height','0px');
        return false;
    });
");
?>
<legend class="rim2"> Laporan Faktur Pembelian </legend>

<?php $this->renderPartial('fakturPembelianT/_search', array('model' => $model)); ?>
<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs',
    'stacked' => false,
    'htmlOptions' => array('id' => 'tabmenu'),
    'items' => array(
        array('label' => 'Rekap', 'url' => 'javascript:tab(0);', 'active' => true),
        array('label' => 'Detail', 'url' => 'javascript:tab(1);', 'itemOptions' => array("index" => 1)),
    ),
))
?>

<div>
    <?php $this->renderPartial('fakturPembelianT/_table', array('model' => $model, 'tglAwal' => $model->tglAwal, 'tglAkhir' => $model->tglAkhir)); ?>
</div>

<fieldset>
    <?php $this->renderPartial('_tab'); ?>
    <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
    </iframe>
</fieldset>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPembelian');
$this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
?>
<?php
$js = <<< JS
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
            $.fn.yiiGridView.update('rekapLaporanFakturPembelian', {
                    data: $("#search-laporan").serialize()
                }
            );            
        } else if (index==1){
            $("#filter_tab").val('detail');
            $("#div_rekap").hide();
            $("#div_detail").show();
            $.fn.yiiGridView.update('rincianLaporanFakturPembelian', {
                    data: $("#search-laporan").serialize()
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
                $.fn.yiiGridView.update('rekapLaporanFakturPembelian', {
                        data: $("#search-laporan").serialize()
                    }
                );
            }else{
                $.fn.yiiGridView.update('rincianLaporanFakturPembelian', {
                        data: $("#search-laporan").serialize()
                    }
                );
            }
        }, 500
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('fakturPembelian', $js, CClientScript::POS_HEAD);
?>