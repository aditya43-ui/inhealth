<?php
echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp"; 
?>
<!--
RND-8637
	<style>
    #instruction_button{
        margin-left: 5px;
        margin-bottom: 10px;
        position: relative;
        margin-top:-11px;
        display:inline-block;
    }
</style>
<div class="form-actions">
<table border="0" >
  <tr>
   <td width="90" style="padding-top:10px;">  <?php // $this->widget('bootstrap.widgets.BootButtonGroup', array(
//        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//        'buttons'=>array(
//            array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
//            array('label'=>'', 'items'=>array(
//                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
//                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
//                array('label'=>'Grafik','icon'=>'icon-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
//            )),       
//        ),
//        'htmlOptions'=>array('class'=>'btn')
//    )); ?>	</td >-->
    <td style="padding-top:20px;">
        <?php
        $content = $this->renderPartial('pengadaan.views/tips/tips',array(),true); 
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </td>

  </tr>
</table>


</div>
<?php 

$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
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
    $("#Grafik").attr("src","'.$url.'"+$("#search-laporan").serialize()+"&type="+index);
    return false;
}
', CClientScript::POS_HEAD);

?>
