<?php
/**
 * menampung fungsi - fungsi javascript
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
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
	$(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab);
	$(frameObj).parent().addClass("animation-loading");
	$(frameObj).load(function(){
		 $(frameObj).parent().removeClass("animation-loading");
		 resizeIframe(frameObj);
	});
	return false;
}
function resetIframe(obj) {
	obj.style.height = 128 + 'px';
}
function resizeIframe(obj) {
	obj.style.height = (obj.contentWindow.document.body.scrollHeight+25) + 'px';
}
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
	setTab($("#tab-default"));
	resizeIframe(document.getElementById("frame"));
', CClientScript::POS_READY);
 
?>