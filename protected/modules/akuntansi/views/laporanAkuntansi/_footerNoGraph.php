<div class="form-actions">
	<?php 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 	

        $tips = array(
            '0' => 'cari',
            '1' => 'ulang2',
            '2' => 'autocomplete',
            '3' => 'masterPDF',
            '4' => 'masterEXCEL',
            '5' => 'masterPRINT',
        );
	$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
	$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
<!--<table style="width: 100%; border: none;">
  <tr>
   <td width="100"> <?php // $this->widget('bootstrap.widgets.BootButtonGroup', array(
//        'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//        'buttons'=>array(
//            array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
//            array('label'=>'', 'items'=>array(
//                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
//                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
//            )),       
//        ),
//        'htmlOptions'=>array('class'=>'btn')
//    )); ?>	</td >
    <td>

        
	</td>

  </tr>
</table>-->
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
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("tableLaporan", {
            data: $(this).serialize()
    });
    $("#Grafik").attr("src","'.$url.'"+$(".search-form form").serialize());
    return false;
}
', CClientScript::POS_HEAD);

?>

