<?php
$gets = "";
if(isset($_GET)){
    foreach($_GET AS $name => $get){
        if($name != "r")
            $gets .= "&".$name."=".$get;
    }
}
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<script type='text/javascript'>
function setTab(obj){
	$(obj).parents("ul").find("li").each(function(){
		$(this).removeClass("active");
		$(this).attr("onclick","setTab(this);");
	});
	$(obj).addClass("active");
	$(obj).removeAttr("onclick","setTab(this);");
	var tab = $(obj).attr("tab");
	var frameObj = document.getElementById("frame");
	resetIframe(frameObj);
	$(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"<?php echo $gets;?>"+"&tab=frame");
	$(frameObj).parent().addClass("animation-loading");
	$(frameObj).load(function(){
		 $(frameObj).parent().removeClass("animation-loading");
		 resizeIframe(frameObj);
	});
	return false;
}
function resetIframe(obj) {
	// obj.style.height = 128 + 'px';
}
function resizeIframe(obj) {
	obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
	setTab($("#tab-default"));
	resizeIframe(document.getElementById("frame"));
', CClientScript::POS_READY);
 
?>

<?php if (isset ($caraPrint)){ ?>
    <tr class="footie">
        <td style="color: black;">Created at  :</td>
        <td style="color: black;"> 
             <?php 
                echo MyFormatter::formatDateTimeId(date('Y-m-d H:i:s'));
             ?>
        </td>
    </tr><br>
    <tr class="footie">
    <td style="color: black;">Created by  :</td>
    <td style="color: black;"> 
         <?php 
//                echo $this->user_id=Yii::app()->user->id;
            echo $this->pageTitle=Yii::app()->name;
         ?>
    </td>
</tr>
<?php }?>