<?php

$this->breadcrumbs=array(
	'Jenismakanan Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('jenismakanan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <b>Jenis Makanan</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
    <hr/>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel Jenis Makanan</div>
        </div>
        <div class="panel-body">
            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'jenismakanan-m-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '($this->grid->dataProvider->pagination) ? 
                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                : ($row+1)',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'jeniswaktu_id',
                        'filter'=>CHtml::activeDropDownList($model, 'jeniswaktu_id', CHtml::listData(JeniswaktuM::model()->findAll('jeniswaktu_aktif = true order by urutan'), 'jeniswaktu_id', 'jeniswaktu_nama'), array('empty'=>'-- Pilih --')),
                        'type'=>'raw',
                        'value'=>function($data) {
                            return empty($data->jeniswaktu) ? "-" : $data->jeniswaktu->jeniswaktu_nama;
                        }
                    ),
                    'jenismakanan_nama',
                    'jenismakanan_namalainnya',
                    'urutan',
                    array(
                        'name'=>'jenismakanan_aktif',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return $data->jenismakanan_aktif ? "Aktif" : "Tidak Aktif";
                        }
                    ),
                /*
                'create_time',
                'update_time',
                'create_loginpemakai_id',
                'update_loginpemakai_id',
                'create_ruangan',
                */
                    array(
                        'header'=>Yii::t('mds','View'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view' => array(
                                          'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat jenis waktu' ),
                            ),
                        ),
                    ),
                    array(
                        'header'=>Yii::t('zii','Update'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array(
                                          'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah jenis waktu' ),
                            ),
                        ),
                    ),
                    array(
                        'header'=>'<center>Hapus</center>',
                        'type'=>'raw',
                        'value'=>'($data->jenismakanan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jenismakanan_aktif)",array("id"=>"$data->jenismakanan_aktif","rel"=>"tooltip","title"=>"Menonaktifkan jenis waktu"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenismakanan_id)",array("id"=>"$data->jenismakanan_aktif","rel"=>"tooltip","title"=>"Hapus jenis waktu")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenismakanan_id)",array("id"=>"$data->jenismakanan_aktif","rel"=>"tooltip","title"=>"Hapus jenis waktu"));',
                        'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>
        </div>
    </div>

<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Jenis Makanan',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$urlPrint= $this->createUrl('print');
        $tips = array(
            '0' => 'ubah',
            '1' => 'lihat',
            '2' => 'nonaktif',
            '3' => 'hapus',
            '4' => 'pencarianlanjut',
            '5' => 'cari',
            '6' => 'ulang2',
            '7' => 'masterPDF',
            '8' => 'masterPRINT',
            '9' => 'masterEXCEL',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
        

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenismakanan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
    
</div>
    
</div>
<script type="text/javascript">	
	function nonActive(obj){
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('jenismakanan-m-grid');
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
</script>

        <script type="text/javascript">
            function removeTemporary(id) {
                var url = '<?php echo $url . "/removeTemporary"; ?>';

                myConfirm('Apakah Anda yakin ingin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
                    function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('jenismakanan-m-grid');
                                    } else {
                                        myAlert('Data gagal dinonaktifkan!')
                                    }
                                }, "json");
                        }
                    });
            }

            function deleteRecord(id) {
                var id = id;
                var url = '<?php echo $url . "/delete"; ?>';
                myConfirm('Apakah Anda yakin ingin menghapus data ini?', 'Perhatian!',
                    function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('jenismakanan-m-grid');
                                    } else {
                                        myAlert('Data gagal dihapus karena data digunakan oleh Master Bahan Menu Diet atau Master Zat Bahan Makanan atau Menu Anamesa Diet.');
                                    }
                                }, "json");
                        }
                    });
            }
            $(document).ready(function() {
                $("input[name='BahanmakananM[namabahanmakanan]']").focus();
            });
        </script>