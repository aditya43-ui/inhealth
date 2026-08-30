<?php
$this->breadcrumbs = array(
    'Informasi Stok Barang',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasistokbarang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Stok Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                        'disabled' => $disabled,
                    )); ?>
                </div>
                <!--search-form-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stok Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                //        $criteria = new CDbCriteria();
                //        $criteria->select = 'sum(case when inventarisasi_keadaan = :p1 then (inventarisasi_qty_in-inventarisasi_qty_out) else 0 end) as inventarisasi_qty_skrg';
                ////        $criteria->select = 'sum(case when inventarisasi_keadaan = :p1 then inventarisasi_qty_skrg else 0 end) as inventarisasi_qty_skrg';
                //        $criteria->addCondition('barang_id = :p2 and ruangan_id = :p3 and inventarisasiruangan_aktif = TRUE');
                //        $keadaan = LookupM::getItems("inventariskeadaan");
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'informasistokbarang-grid',
                    'dataProvider' => $model->search(),
                    //	'filter'=>$model,
                    'mergeHeaders' => array(
                        //                    array(
                        //                        'name'=>'<p style="margin: 0; text-align: center;">Jumlah Barang</p>',
                        //                        'start'=>8, 
                        //                        'end'=>9, 
                        //                    ),
                    ),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        /* 'instalasi_nama',
                    'ruangan_nama', */
                        array(
                            'header' => 'Kode Barang',
                            'type' => 'raw',
                            'value' => '$data->barang_kode',
                        ),
                        //                array (
                        //                        'header'=>'Jenis Barang',
                        //                        'type'=>'raw',
                        //                        'value'=>'$data->jenisbarang_nama',
                        //                    ),
                        array(
                            'header' => 'Nama Barang',
                            'type' => 'raw',
                            'value' => '$data->barang_nama',
                        ),
                        array(
                            'header' => 'Merk',
                            'type' => 'raw',
                            'value' => '$data->barang_merk',
                        ),
                        array(
                            'header' => 'No. Seri',
                            'type' => 'raw',
                            'value' => '$data->barang_noseri',
                        ),
                        array(
                            'header' => 'Tahun Beli',
                            'type' => 'raw',
                            'value' => '$data->barang_thnbeli',
                        ),
                        array(
                            'header' => 'Harga Beli (Rp)',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->inventarisasi_hargabeli_avg)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        //                 array (
                        //                        'header'=>'Baik',
                        //                        'type'=>'raw',
                        //                'value'=>'$data->qtykeadaan_baik." ".$data->barang_satuan',
                        //                        'htmlOptions'=>array('style'=>'text-align: right;'),
                        //                    ),
                        //                 array (
                        //                        'header'=>'Dalam Perbaikan',
                        //                        'type'=>'raw',
                        //                'value'=>'$data->qtykeadaan_dalamperbaikan." ".$data->barang_satuan',
                        //                        'htmlOptions'=>array('style'=>'text-align: right;'),
                        //                    ),
                        //                 array (
                        //                        'header'=>'Rusak',
                        //                        'type'=>'raw',
                        //                'value'=>'$data->qtykeadaan_rusak." ".$data->barang_satuan',
                        //                        'htmlOptions'=>array('style'=>'text-align: right;'),
                        //                    ),
                        array(
                            'header' => 'Jumlah Barang',
                            'type' => 'raw',
                            'value' => '$data->inventarisasi_stok." ".$data->barang_satuan',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("rincian",array("id"=>$data->barang_id,"ruangan_id"=>$data->ruangan_id,"frame"=>true)),array("id"=>"$data->barang_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Rincian Stok Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//	$this->widget('UserTips',array('type'=>'admin'));
$urlPrint = $this->createUrl('print');
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#informasistokbarang-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<!--<script type="text/javascript">	
	function nonActive(obj){
		myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('informasistokbarang-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dinonaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>-->
<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Stok Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>