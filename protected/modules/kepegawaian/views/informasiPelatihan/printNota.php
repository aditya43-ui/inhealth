<style>
	body {
		color: black;
	}
	
	hr {
		border: none;
		border-bottom: 1px solid black;
	}
	
	.tab_header td {
		color: black;
		padding: 2px;
	}
	
	.tab_detail th, .tab_detail td {
		border: 1px solid black;
		padding: 2px;
	}
	
	.tab_detail th, .tab_detail tfoot td {
		font-weight: bold;
	}
	
	.num {
		text-align: right;
	}
	
	.signature {
		margin-top: 20px;
	}
	
	.signature td {
		text-align: center;
	}
	.bolds td {
		font-weight: bold;
	}
</style>

<?php
$tipe = JenisdiklatM::model()->findByPk($model->jenisdiklat_id);
$modPembuat = empty($model->pemberitugas_id) ? new PegawaiM : PegawaiM::model()->findByPk($model->pemberitugas_id);
$modMengetahui = empty($model->mengetahui_id) ? new PegawaiM : PegawaiM::model()->findByPk($model->mengetahui_id);
$modMenyetujui = empty($model->menyetujui_id) ? new PegawaiM : PegawaiM::model()->findByPk($model->menyetujui_id);

// var_dump($modBiaya->attributes); die;

echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>'<h3>NOTA DINAS</h3>', 'deskripsi'=>'Test', 'colspan'=>10));
?>

