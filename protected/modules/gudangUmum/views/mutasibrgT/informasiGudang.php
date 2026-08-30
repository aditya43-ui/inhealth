<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Mutasi Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gumutasibrg-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $action = $this->getAction()->getId();
        $currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
        ?>
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Mutasi Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gumutasibrg-t-grid',
                    'dataProvider' => $model->searchInformasiGudang(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        'nomutasibrg',
                        'tglmutasibrg',
                        'pegawaipengirim.nama_pegawai',
                        'pegawaimengetahui.nama_pegawai',
                        'totalhargamutasi',
                        'ruangantujuan.ruangan_nama',
                        'keterangan_mutasi',
                        'pesanbarang.nopemesanan',
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-list-alt\'></i> ",  Yii::app()->controller->createUrl("' . $controller . '/detailMutasiBarang",array("id"=>$data->mutasibrg_id)),array("id"=>"$data->mutasibrg_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Mutasi Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
                        ),
                        array(
                            'header' => 'Batal Mutasi',
                            'type' => 'raw',
                            'value' => '($data->testingData == false) ? "Telah Dimutasi" : "Batal Mutasi"',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <!--search-form-->
        <?php
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        //        $this->widget('UserTips',array('type'=>'admin'));
        //        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        //        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        //        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gumutasibrg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <?php
        //========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetail',
            'options' => array(
                'title' => 'Detail Mutasi Barang',
                'autoOpen' => false,
                'modal' => true,
                'width' => 750,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget();
        ?>
    </div>
</div>