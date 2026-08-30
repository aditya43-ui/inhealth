<div class="form-actions">
<!--	RND-8747
<table style="width: 100%; border: none;">
  <tr>
   <td width="100"> <?php // $this->widget('bootstrap.widgets.BootButtonGroup', array(
//        
//        'buttons'=>array(
//            array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
//            array('label'=>'', 'items'=>array(
//                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
//                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
//                array('label'=>'Grafik','icon'=>'entypo-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
//            )),       
//        ),
//    )); ?>	</td >
    <td>
<?php
//    $content = $this->renderPartial('tips/tips',array(),true); 
//    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?></td>
  </tr>
</table>-->
<?php
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'));     
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'));   
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'));     
	
    if (isset($tips)):
        if ($tips == 'pembebasan'):
            $content = $this->renderPartial('rawatJalan.views.laporan.tips/PembebasanTarif',array(),true);
        elseif($tips == '10besarpenyakit'):
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporan10BesarPenyakit',array(),true);
        endif;
    else:                
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanBukuRegister',array(),true);
    endif; 
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>
<?php 
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 
<?php 
Yii::app()->clientScript->registerScript('test','
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj){
	$("#Grafik").addClass("animation-loading");	
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("tableLaporan", {
            data: $(this).serialize()
    });
    $("#Grafik").attr("src","'.$url.'"+$(".search-form form").serialize()+"&type="+$(obj).attr("type"));
    return false;
}
', CClientScript::POS_HEAD);

?>

