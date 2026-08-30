<div class="white-container">
	<div class="row">
		<fieldset class="box">
			<legend class="rim">Pola Kebiasaan</legend>
			<?php $this->renderPartial('_formKebiasaan', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
		</fieldset>
	</div>
	<div class="row">
		<fieldset class="box">
			<legend class="rim">Sistem - Sistem Tubuh</legend>
			<?php $this->renderPartial('_formSistemTubuh', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
		</fieldset>
	</div>
</div>
