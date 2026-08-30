<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Pemilik Barang</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Pemilik Barang'=>array('admin'),
            'Pengaturan',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pemilik Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAPemilikbarangM', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pemilik Barang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sapemilikbarang-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!--search-form-->
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Pemilik Barang</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
        <!--<h6>Tabel <b>Pemilik Barang</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sapemilikbarang-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'pemilikbarang_id',
                    array(
                            'name'=>'pemilikbarang_id',
                            'value'=>'$data->pemilikbarang_id',
                            'filter'=>false,
                    ),
                    'pemilikbarang_kode',
                    'pemilikbarang_nama',
                    'pemilikbarang_namalainnya',

                    array(
                        'header' => 'Status',
                        'value'=>'($data->pemilikbarang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //		array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->pemilikbarang_aktif',
    //                ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array (
                                              'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                            ),
                             ),
                    ),
	                   array(
//                        'header'=>'Hapus',
//                        'type'=>'raw',
//                        'value'=>'($data->pemilikbarang_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->pemilikbarang_id)",array("id"=>"$data->pemilikbarang_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pemilikbarang_id)",array("id"=>"$data->pemilikbarang_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pemilikbarang_id)",array("id"=>"$data->pemilikbarang_id","rel"=>"tooltip","title"=>"Hapus"));',
//                        'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
								
                            'header'=>Yii::t('zii','Delete'),
							'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{remove} {delete}',
                            'buttons'=>array(
                                    'remove' => array (
													'label'=>"<i class='icon-form-silang'></i>",
													'options'=>array('title'=>Yii::t('mds','Nonaktif Sementara')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->pemilikbarang_id))',
                                                    'click'=>'function(){nonActive(this);return false;}',
                                                    'visible'=>'(($data->pemilikbarang_aktif) ? TRUE : FALSE)',
												),
									'delete'=> array(),
								
								),
					),				
                    ),
             'afterAjaxUpdate'=>'function(id, data){
				jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
				$("table").find("input[type=text]").each(function(){
					cekForm(this);
				})
			}',
        )); ?>
    </div>
    </div>

    <div class="form-actions">
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Pemilik Barang', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $content = $this->renderPartial($this->path_tips.'master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#sapemilikbarang-m-search :input[name='"+ obj.name +"']").val(obj.value);
}      
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapemilikbarang-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
    </div>
</div>
<script type="text/javascript">
	  function cekForm(obj)
	{		
			$("#sapemilikbarang-m-search :input[name='"+ obj.name +"']").val(obj.value);
	}
   function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sapemilikbarang-m-grid');
                            }else{
                                myAlert('Data gagal dihapus!')
                            }
                },"json");
            }
        }); 
    }
	
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
							$.fn.yiiGridView.update('sapemilikbarang-m-grid');
							if(data.sukses > 0){
								myAlert('Data berhasil dinonaktifkan!');
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
    $(document).ready(function(){
        $('input[name="SAPemilikbarangM[pemilikbarang_kode]"]').focus();
    })
</script>