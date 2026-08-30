<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#searchLaporan').submit(function(){
	$('#Grafik').attr('src','').css('height','0px');
	if($('#filter_tab').val() == 'rs')
	{
		$.fn.yiiGridView.update('tablePendapatanRS', {
				data: $('#searchLaporan').serialize()
			}
		);
	}else{
		$.fn.yiiGridView.update('tablePendapatanLuar', {
				data: $('#searchLaporan').serialize()
			}
		);
	}
	return false;
});
");
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan <strong>Pendapatan Ruangan</strong></div>
            </div>
            <div class="panel-body">
				<div class="tab">
				   <?php
		   //            $this->widget('bootstrap.widgets.BootMenu',array(
		   //                'type'=>'tabs',
		   //                'stacked'=>false,
		   //                'htmlOptions'=>array('id'=>'tabmenu'),
		   //                'items'=>array(
		   //                    array('label'=>'Pendapatan dari RS','url'=>'javascript:tab(0);','active'=>true),
		   //                    array('label'=>'Pendapatan dari Luar RS','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
		   //                ),
		   //            ))
				   ?>
					<?php $this->renderPartial('laboratoriumPA.views.laporan.pendapatan/_tabMenu',array()); ?>
					<?php $this->renderPartial('laboratoriumPA.views.laporan.pendapatan/_jsFunctions',array()); ?>
				   <div>
					   <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
					   <?php // $this->renderPartial('laboratorium.views.laporan.pendapatan/_table', array('model'=>$model,)); ?>
				   </div>            
			   </div>
            </div>
        </div>
    </div>
</div>
<!--iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
</iframe-->                        								
<?php
$js= <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_rs").show();
        $("#div_luar").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('rs');
            $("#div_rs").show();
            $("#div_luar").hide();
            $.fn.yiiGridView.update('tablePendapatanRS', {
                    data: $("#searchLaporan").serialize()
                }
            );            
        } else if (index==1){
            $("#filter_tab").val('luar');
            $("#div_rs").hide();
            $("#div_luar").show();
            $.fn.yiiGridView.update('tablePendapatanLuar', {
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
            if($("#filter_tab").val() == 'rs')
            {
                $.fn.yiiGridView.update('tablePendapatanRS', {
                        data: $("#searchLaporan").serialize()
                    }
                );
            }else{
                $.fn.yiiGridView.update('tablePendapatanLuar', {
                        data: $("#searchLaporan").serialize()
                    }
                );
            }
        }, 500
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pendapatanRS',$js,CClientScript::POS_HEAD);
?>

