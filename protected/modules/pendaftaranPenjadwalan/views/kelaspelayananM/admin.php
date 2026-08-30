<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Kelas Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Ppkelaspelayanan Ms' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#PPKelaspelayananM_jeniskelas_id').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppkelaspelayanan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php

        echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="search-form cari-lanjut" style="display:none;background: none;">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--<legend class="rim">Tabel Kelas Pelayanan</legend>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'ppkelaspelayanan-m-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'template' => "{summary}\n{items}{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'name' => 'kelaspelayanan_id',
                    'value' => '$data->kelaspelayanan_id',
                    'filter' => false,
                ),
                array(
                    'name' => 'jeniskelas_id',
                    //'type'=>'raw',
                    'filter' => CHtml::dropDownList('PPKelaspelayananM[jeniskelas_id]', $model->jeniskelas_id, CHtml::listData($model->getJeniskelasItems(), 'jeniskelas_id', 'jeniskelas_nama'), array('empty' => '-- Pilih --')),
                    'value' => '$data->jeniskelas->jeniskelas_nama',
                ),
                'kelaspelayanan_nama',
                'kelaspelayanan_namalainnya',
                // dicomment karena RND-7229
                //		array(
                //			 'header'=>'Ruangan ',
                //			 'type'=>'raw',
                //			 'value'=>'$this->grid->getOwner()->renderPartial(\'_ruangan\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id),true)',
                //		 ), 
                array(
                    'header' => 'Status',
                    'value' => '($data->kelaspelayanan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                ),
                array(
                    'header' => Yii::t('zii', 'View'),
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=entypo-eye></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->kelaspelayanan_id)),
						 array("class"=>"view",
							   "rel"=>"tooltip",
							   "title"=>"Lihat Kelas Pelayanan",
				 ))',
                ),
                array(
                    'header' => Yii::t('zii', 'Update'),
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=entypo-pencil></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->kelaspelayanan_id)),
						 array("class"=>"update",
							   "rel"=>"tooltip",
							   "title"=>"Ubah Kelas Pelayanan",
				 ))',
                ),
                array(
                    'header' => 'Hapus',
                    'type' => 'raw',
                    //'value'=>'($data->kelaspelayanan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Menonaktifkan Pelayanan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Hapus Pelayanan")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Hapus Pelayanan"));',
                    'value' => '($data->kelaspelayanan_aktif)?CHtml::link("<i class=\'entypo-cancel\'></i> ","javascript:removeTemporary($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Menonaktifkan Pelayanan"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Hapus Pelayanan")):CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Hapus Pelayanan"));',
                    'htmlOptions' => array('style' => 'width:80px'),
                ),
                //		RND-7229
                //		array(
                //			'header'=>Yii::t('zii','Delete'),
                //			'class'=>'bootstrap.widgets.BootButtonColumn',
                //			'template'=>'{delete}',
                //			'buttons'=>array(
                //				'delete'=> array(
                //					'options'=>array('rel'=>'tooltip','title'=>'Hapus Kelas Pelayanan')
                //				),
                //			),                        
                //		),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
        )); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Kelas Pelayanan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/kelaspelayananM/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        $content = $this->renderPartial('../tips/master2', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

        $js = <<< JSCRIPT
          function cekForm(obj)
{
    $("#ppkelaspelayanan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
        
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppkelaspelayanan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <script>
            function removeTemporary(id) {
                var url = '<?php echo $url . "/removeTemporary"; ?>';
                myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                    if (r) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('ppkelaspelayanan-m-grid');
                                } else {
                                    myAlert('Data gagal dinonaktifkan!')
                                }
                            }, "json");
                    }
                });
            }

            function deleteRecord(id) {
                var id = id;
                var url = '<?php echo $this->createUrl("delete"); ?>';
                myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
                    if (r) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('ppkelaspelayanan-m-grid');
                                    myAlert(data.keterangan);
                                } else {
                                    myAlert("Data gagal dihapus");
                                }
                            }, "json");
                    }
                });
            }
        </script>
    </div>
</div>