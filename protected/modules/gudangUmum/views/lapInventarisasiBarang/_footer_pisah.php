<div class="form-actions">
<table width="100%" border="0">
  <tr>
   <td> 
       <?php 
//       $this->widget('bootstrap.widgets.BootButtonGroup', array(
//        'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//        'buttons'=>array(
//
//                array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>$urlPrint, 'htmlOptions'=>array('onclick'=>'print(\'PRINT\');return false;')),
//                array('label'=>'', 'items'=>array(
//                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'PDF\');return false;')),
//                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'EXCEL\');return false;')),
//                array('label'=>'Grafik','icon'=>'entypo-print', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\');return false;')),
//            )),       
//        ),
////        'htmlOptions'=>array('class'=>'btn')
//        )); 
       ?>

<?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 

$content = $this->renderPartial('gudangUmum.views.tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
?></td>

  </tr>
</table>
</div>
<?php 

$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporan-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 
<?php 
Yii::app()->clientScript->registerScript('test','
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj, index){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("laporan-grid", {
            data: $(this).serialize()
    });
    if (index==1) {
        index="batang";
    } else if (index==2) {
        index="pie";
    } else if (index==3) {
        index="garis";
    }
    $("#Grafik").attr("src","'.$url.'"+$("#laporan-search").serialize()+"&type="+index);
    return false;
}
', CClientScript::POS_HEAD);

?>

