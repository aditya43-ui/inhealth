<?php

/**
 * digunakan sebagai halaman utama 
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
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

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Faktur Pembelian</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('fakturPembelianT/_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Pembelian</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
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

                <?php $this->renderPartial('fakturPembelianT/_table', array('model' => $model, 'tgl_awal' => $model->tgl_awal, 'tgl_akhir' => $model->tgl_akhir)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPembelian');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
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