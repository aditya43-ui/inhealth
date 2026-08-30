<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<header data-role="header">
	        <legend class="rim2">Buat Janji Poli</legend>
	</header>

	<div data-role="content">	
		<?php 
                echo $this->renderPartial('_form', array('modPasien'=>$modPasien,'modPPBuatJanjiPoli'=>$modPPBuatJanjiPoli)); ?>
	</div>