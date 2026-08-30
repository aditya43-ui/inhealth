<?php
$profil = ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'));
$konsys = KonfigsystemK::model()->find();
$longitude = !empty($profil->kabupaten->longitude)?$profil->kabupaten->longitude:Params::DEFAULT_PROFIL_LONGITUDE;
$latitude = !empty($profil->kabupaten->latitude)?$profil->kabupaten->latitude:Params::DEFAULT_PROFIL_LATITUDE;
?>
<style>
	.panel-heading{
		background: none repeat scroll 0 0 #428bca !important;
		color : #eee !important;
	}
</style>
<div class="row-fluid" style="overflow:hidden;">
	<div class="row">
		<?php $this->renderPartial('_kolom',array('dataKolom'=>$dataKolom)); ?>
	</div>
	<div class="row">
		<div class="col-sm-12">
		<?php $this->renderPartial('_charts',array('dataKolom'=>$dataKolom,
												'dataAreaChart'=>$dataAreaChart,
												'dataLineChart'=>$dataLineChart,
												'dataDonutChart'=>$dataDonutChart,
		)); ?>
		</div>
		
	</div>
	<div class="row">
                <div class="col-sm-6">
		<?php $this->renderPartial('_chartPie',array('dataPieChart'=>$dataPieChart)); ?>
		</div>
		<div class="col-sm-6">
			<?php $this->renderPartial('_chartBar',array('dataBarChart'=>$dataBarChart)); ?>
		</div>
		
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php  
			$this->renderPartial('_todolist',array(
							'modTodolist'=>$modTodolist,
							'dataProviderTodolist'=>$dataProviderTodolist,
						)); ?>
		</div>
                <div class="col-sm-6">
			<?php $this->renderPartial('_table',array('dataTable'=>$dataTable)); ?>
		</div>
        </div>
		
	</div>

