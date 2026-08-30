<?php
    $this->breadcrumbs=array(
        'Laporan Rekap Piutang',
    );
    $url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporanKU/frameGrafikLaporanRekapPiutang&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#searchLaporan').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $('#laporanrekapiutangpenjamin-grid').addClass('animation-loading');
        $('#laporanrekapiutangumum-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('laporanrekapiutangpenjamin-grid', {
                data: $(this).serialize()
        });
        $.fn.yiiGridView.update('laporanrekapiutangumum-grid', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                <i class="entypo-newspaper"></i> Laporan <b>Rekap Piutang</b></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="search-form">
                            <?php 
                                $this->renderPartial($this->path_view_ku.'piutangPenjamin/_search',array(
                                    'model'=>$model,
                                )); 
                            ?>
                        </fieldset>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Rekap Piutang</b></div>
                    </div>
                    <div class="panel-body table-responsive">
                        
                            <?php /*
                                $this->widget('bootstrap.widgets.BootMenu',array(
                                    'type'=>'tabs',
                                    'stacked'=>false,
                                    'htmlOptions'=>array('id'=>'tabmenu'),
                                    'items'=>array(
                                        array('label'=>'P3 / Penjamin','url'=>'javascript:tab(0);','active'=>true),
                                        array('label'=>'Umum','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                                    ),
                                ))
                             * 
                             */
                            ?>
                        
                        <!--fieldset--> 
                            <?php $this->renderPartial($this->path_view_ku.'piutangPenjamin/_table', array('model'=>$model)); ?>
                            <!--iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
                            </iframe-->        
                        <!--</fieldset>-->
                    </div>
                </div>	
                <?php   
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanRekapPiutang');
                $this->renderPartial($this->path_view_ku.'_footer2', array('urlPrint'=>$urlPrint, 'url'=>$url));  
                // $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));  
                ?>
            </div>
        </div>
    </div>
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
        
        $("#div_penjamin").show();
        $("#div_umum").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('penjamin');
            $("#div_penjamin").show();
            $("#div_umum").hide();       
        } else if (index==1){
            $("#filter_tab").val('umum');
            $("#div_penjamin").hide();
            $("#div_umum").show();
        } 
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('laporanrekapiutangpenjamin-grid', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('laporanrekapiutangumum-grid', {
                data: $("#searchLaporan").serialize()
            });      
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>