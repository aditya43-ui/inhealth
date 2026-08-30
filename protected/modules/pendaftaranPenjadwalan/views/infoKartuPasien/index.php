<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppinfokartupasien-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<style type="text/css">
input[readonly]{
    background-color: #F5F5F5;
    border-color: #DDDDDD;
    cursor: auto;
}
</style>
<fieldset>
    <legend class="rim2">Informasi Print Kartu Pasien</legend>
</fieldset>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ppinfokartupasien-grid',
	'dataProvider'=>$model->searchTable(),
//	'filter'=>$model,
    //'rowCssClass'=>array('even'),
    //'rowCssClassExpression' => '$data->statusprintkartu?"rowFalse":"rowFalse"',
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			'tglprintkartu',
            array(
                'name'=>'no_rekam_medik',
                'type'=>'raw',
                'value'=>'$data->pasien->no_rekam_medik',
            ),
            array(
                'name'=>'nama_pasien',
                'type'=>'raw',
                'value'=>'$data->pasien->nama_pasien',
            ),
            array(
                'name'=>'Jenis Kelamin',
                'type'=>'raw',
                'value'=>'$data->pasien->jeniskelamin',
            ),
            array(
                'name'=>'Alamat Pasien',
                'type'=>'raw',
                'value'=>'$data->pasien->alamat_pasien." Rt. ".$data->pasien->rt." / ".$data->pasien->rw ',
            ),
            array(
                'name'=>'Print Kartu Pasien',
                'type'=>'raw',
                'value'=>'CHtml::link("<i class=\"entypo-print\"></i>", "javascript:cetak(\'$data->kartupasien_id\',\'$data->pendaftaran_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint kartu pasien"))',
            ),
            array(
                'header'=>'Status Print',
                'type'=>'raw',
                'htmlOptions'=>array(
                	'name'=>'status_print',
                ),
                'value'=>'$data->statusprintkartu?"Sudah":"Belum"',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){
        	var status = "";
        	$(\'#ppinfokartupasien-grid\').find(\'tbody > tr\').each(
        		function()
        		{
        			status = $(this).find(\'td[name="status_print"]\').text();
        			if(status == \'Belum\')
        			{
                        $(this).find(\'td\').attr(\'style\', \'background-color:#f69696\');
        			}
        		}
        	);
    		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
    	}',
)); ?>

<div class="search-form">
<?php $this->renderPartial('_search',array(
		'model'=>$model,
)); ?> 
<!--search-form-->
<?php
$controller = Yii::app()->controller->id;
$module = Yii::app()->controller->module->id;
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$urlPrintKartuPasien = Yii::app()->createUrl('print/kartuPasien',array('pendaftaran_id'=>''));
?>
<script type="text/javascript">
    function statusawal()
    {
        var status = "";
        $('#ppinfokartupasien-grid').find('tbody > tr').each(
            function()
            {
                status = $(this).find('td[name="status_print"]').text();
                if(status == 'Belum')
                {
                    $(this).find('td').attr('style', 'background-color:#f69696');
                }
            }
        );
    }
    statusawal();

    function cetak(idKartuPasien,pendaftaran_id)
    {
        var url = '<?php echo $url."/update"; ?>';
        var urlPrintKartuPasien = '<?php echo $urlPrintKartuPasien; ?>';
        $.post(url, {kartupasien_id: idKartuPasien ,pendaftaran_id: pendaftaran_id},
            function(data){
                $.fn.yiiGridView.update('ppinfokartupasien-grid', {
                        data: $('#ppinfokartupasien-search').serialize()
                });
            },"json");
        window.open(urlPrintKartuPasien+pendaftaran_id,'printwi','left=100,top=100,width=310,height=230');
    }
</script>

</div>