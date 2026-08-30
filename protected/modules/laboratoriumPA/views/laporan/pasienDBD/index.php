<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
	$url = Yii::app()->createUrl('laboratoriumPA/laporan/frameGrafikPasienDBD&id=1');
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
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan Pasien <strong>Demam Berdarah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body search-form">
						<?php $this->renderPartial('laboratoriumPA.views.laporan.pasienDBD/_search',
						array('model'=>$model,'tgl_awal'=>$model->tgl_awal,'tgl_akhir'=>$model->tgl_akhir)); ?>
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Pasien <strong>DBD - Rekapitulasi</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php $this->renderPartial('laboratoriumPA.views.laporan.pasienDBD/_table', array('model'=>$model)); ?>
						</div>            
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Grafik</div>
                    </div>
                    <div class="panel-body">
						<div class="block-tabel">
							<?php $this->renderPartial('laboratorium.views.laporan._tab'); ?>
							<iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
							</iframe>       
						</div>
                    </div>
                </div>								
				<?php   
					$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
					$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
					$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPasienDBD');
					$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
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
            $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
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

