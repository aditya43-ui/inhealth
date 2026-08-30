<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppinformasiprintkartupasien-grid', {
		data: $(this).serialize()
	});
	return false;
});
"); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Print Kartu Pasien',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Print Kartu Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <fieldset class="search-form box">
            <?php $this->renderPartial('_search', array('model' => $model, 'format' => $format)); ?>
            <!--search-form-->
            <!--search-form-->
            <?php
            $controller = Yii::app()->controller->id;
            $module = Yii::app()->controller->module->id;
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            $urlPrintKartuPasien = $this->createUrl('PrintKartuPasien', array('pasien_id' => ''));
            ?>
            <script type="text/javascript">
                function statusawal() {
                    var status = "";
                    $('#ppinfokartupasien-grid').find('tbody > tr').each(
                        function() {
                            status = $(this).find('td[name="status_print"]').text();
                            if (status == 'Belum') {
                                $(this).find('td').attr('style', 'background-color:#f69696');
                            }
                        }
                    );
                }
                statusawal();

                function cetak(kartupasien_id, pasien_id) {
                    var url = '<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printKartuPasien'); ?>&pasien_id=' + pasien_id;
                    //var urlPrintKartuPasien = '<?php echo $urlPrintKartuPasien; ?>';
                    //$.post(url, {kartupasien_id: kartupasien_id ,pasien_id: pasien_id},
                    //    function(data){
                    //        $.fn.yiiGridView.update('ppinformasiprintkartupasien-grid', {
                    //                 data: $('#ppinformasiprintkartupasien-search').serialize()
                    //        });
                    //     },"json");
                    window.open(url, 'printwi', 'left=100,top=100,width=310,height=230');
                }
            </script>
        </fieldset>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Print Kartu Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ppinformasiprintkartupasien-grid',
                    'dataProvider' => $model->searchTable(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tglprintkartu',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglprintkartu)',
                        ),
                        array(
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->pasien->no_rekam_medik . "<br>" . CHtml::link("<i class=\"entypo-print\"></i>", "javascript:cetak(\'$data->kartupasien_id\',\'$data->pasien_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint kartu pasien"))',
                            'htmlOptions' => array(
                                'style' => 'width:80px;text-align:center'
                            )
                        ),
                        array(
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => '$data->pasien->nama_pasien',
                        ),
                        array(
                            'name' => 'Jenis Kelamin',
                            'type' => 'raw',
                            'value' => '$data->pasien->jeniskelamin',
                        ),
                        array(
                            'name' => 'Alamat Pasien',
                            'type' => 'raw',
                            'value' => '$data->pasien->alamat_pasien',
                        ),
                        /*
                        array(
                            'name'=>'Print Kartu Pasien',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<i class=\"entypo-print\"></i>", "javascript:cetak(\'$data->kartupasien_id\',\'$data->pasien_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint kartu pasien"))',
                        ),
                         * 
                        array(
                            'header'=>'Status Print',
                            'type'=>'raw',
                            'htmlOptions'=>array(
                                    'name'=>'status_print',
                            ),
                            'value'=>'$data->statusprintkartu?"Sudah":"Belum"',
                        ), */
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                            var xxx = "";
                            $(\'#ppinformasiprintkartupasien-grid\').find(\'tbody > tr\').each(
                                    function()
                                    {
                                            xxx = $(this).find(\'td[name="status_print"]\').text();
                                            if(xxx == \'Belum\')
                                            {
                                                            $(this).addClass(\'rowFalse\');
                                            }
                                    }
                            );
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    }',
                )); ?>
            </div>
        </div>
    </div>
</div>