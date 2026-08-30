<div class="white-container">
	<legend class="rim2">Peta <b>Penyebaran Pasien</b></legend>
	<?php Yii::app()->clientScript->registerScript('search', "
	$('#penyebearanpasien-peta-search').submit(function(){
		setIframePetaPenyebaranPasien();
		return false;
	});
	"); ?>

	<fieldset class="box search-form">
            <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
            <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                    'format'=>$format
            )); ?>
	</fieldset><!--search-form-->

	<div class="row" id="box-peta">
		<iframe src="" id="iframe_petapenyebaranpasien" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>    
	</div>
	

</div>


<?php echo $this->renderPartial('_jsFunctions'); ?>
