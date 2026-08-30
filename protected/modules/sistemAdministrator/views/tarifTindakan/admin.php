<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">
			Pengaturan Nominal Tarif
		</div>
	</div>
		<div class="panel-body">
			<?php
    $this->breadcrumbs=array(
            'Nominal Tarif'=>array('admin'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Nominal Tarif ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Nominal Tarif', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Nominal Tarif', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('satarif-tindakan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <!--<h3>Perda Tarif : <?php //echo PerdatarifM::model()->findByAttributes(array('perda_aktif'=>true))->perdanama_sk ?></h3>-->
    <?php 
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    }
    ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
	<hr/>
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Tabel Nominal Tarif</div>
		</div>
		<div class="panel-body">
			<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'satarif-tindakan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                     array(
                            'name'=>'jenistarif_id',
                            'filter'=> CHtml::dropDownList('TariftindakanperdaV[jenistarif_id]',$model->jenistarif_id,CHtml::listData(SATarifTindakanM ::model()->getJenisTarifItems(), 'jenistarif_id', 'jenistarif_nama'),array('empty'=>'-- Pilih --')),
    //                         'value'=>array($this,'gridJenisTarif'),
                             'value'=>'$data->jenistarif_nama',
                    ),
					array(
						'header' => 'Penjamin',
						'value' => '$data->penjamin_nama',
						'filter' => CHtml::activeDropDownList($model, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAll(" penjamin_aktif = TRUE ORDER BY penjamin_nama ASC "), 'penjamin_id', 'penjamin_nama'),array('empty' => '-- Pilih --'))
					),
                     array(
                            'name'=>'kelaspelayanan_id',
                            'filter'=> CHtml::dropDownList('TariftindakanperdaV[kelaspelayanan_id]',$model->kelaspelayanan_id,CHtml::listData(SATarifTindakanM ::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('empty'=> '-- Pilih --')),
    //                         'value'=>array($this,'gridKelasPelayanan'),
                             'value'=>'$data->kelaspelayanan_nama',
                    ),
                    array(
                            'header'=>'Kategori Tindakan',
                            'name'=>'kategoritindakan_id',
                            'filter'=>  CHtml::dropDownList('TariftindakanperdaV[kategoritindakan_id]',$model->kategoritindakan_id,CHtml::listData(SATarifTindakanM ::model()->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),array('empty'=>'-- Pilih --')),
    //                        'value'=>array($this,'gridKategoriTindakan'),
                            'value'=>'$data->kategoritindakan_nama',
                    ),
                    array(
                        'header'=>'Jenis Waktu Kerja',
                        'type'=>'raw',
                        'name'=>'jeniswaktukerja',
                        'filter'=>  CHtml::dropDownList('TariftindakanperdaV[jeniswaktukerja]',$model->jeniswaktukerja,LookupM::getItems('jeniswaktukerja'),array('empty'=>'-- Pilih --')),
                        'value'=>function($data) {
                            return $data->jeniswaktukerja;
                        }
                    ),
					array(
						'header'=>'Kode Tindakan',
						'name'=>'daftartindakan_kode',						
					),
                    //'name'=>'daftartindakan_kode',
                    array(
							'header' => 'Uraian Tindakan',
                            'name'=>'daftartindakan_nama',
                            //'filter'=>  CHtml::listData(SATarifTindakanM ::model()->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
    //                         'value'=>array($this,'gridDaftarTindakan'),
                             'value'=>'$data->daftartindakan_nama',
                    ),
                   /* array(
                            'name'=>'komponentarif_id',
                            'filter'=>  CHtml::dropDownList('TariftindakanperdaV[komponentarif_id]',$model->komponentarif_id,CHtml::listData(SATarifTindakanM ::model()->KomponenTarifItems, 'komponentarif_id', 'komponentarif_nama'),array('empty'=>'-- Pilih --')),
    //                        'value'=>'$data->komponentarif_nama',
    //                        'value'=>array($this,'gridKomponenTarif'),
                            'value'=>'$data->komponentarif_nama',
                    ),*/
                    array(
                        'header'=>'Tarif (Rp.)',
                        'name'=>'harga_tariftindakan',
                        'type'=>'raw',
                        'value'=>'"Rp ".MyFormatter::formatNumberForPrint($data->harga_tariftindakan,2)',
						// 'filter'=>  CHtml::activeTextField($model, 'harga_tariftindakan', array('class' => 'numbers-only')),
                        'filter'=>  false,
                        'htmlOptions' => array('style'=>'text-align:right')
                    ),
					array(
                        'header'=>'Tarif Cyto (Rp.)',
                        'name'=>'totaltarifakhir_cyto',
                        'type'=>'raw',
                        'value'=>'"Rp ".MyFormatter::formatNumberForPrint($data->totaltarifakhir_cyto,2)',
                        'filter'=>  false,
                        'htmlOptions' => array('style'=>'text-align:right')
                    ),
    //		'harga_tariftindakan',
                    /*
                    'persendiskon_tind',
                    'hargadiskon_tind',
                    'persencyto_tind',
                    */
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array
                                    (
                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->tariftindakan_id"))',
                                    ),

                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'), //10 = LIMIT * 10.//".CHtml::htmlButton("<i class='icon-form-ubah'></i>",array('onclick'=>'cariPerbaikanTarif(this);','class'=>'','rel'=>'tooltip','title'=>'Klik untuk mencari dan ubah tarif komponen yang salah hingga 10 halaman berikutnya'))
                                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array
                                    (
                                        //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/index",array("perdatarif_id"=>"$data->perdatarif_id","jenistarif_id"=>"$data->jenistarif_id","kelaspelayanan_id"=>"$data->kelaspelayanan_id","daftartindakan_id"=>"$data->daftartindakan_id","jeniswaktukerja"=>"$data->jeniswaktukerja"))',
                                    ),

                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                            'delete'=> array(
                                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->tariftindakan_id"))',
                                            ),
                            )
                    ),
            ),
             'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                });
                 $("table").find("select").each(function(){
                    cekForm(this);
                });
				$(".numbers-only").keyup(function() {
					setNumbersOnly(this);
				});
            }',
        )); ?>
		</div>
	</div>         
    <br/>   
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Nominal Tarif', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/index',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('sistemAdministrator.views.tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>

		</div>



<script type="text/javascript">
	/**
	 * untuk mencari tariftindakan yang perlu perbaikan
	 * @returns {undefined}
	 */
	function cariPerbaikanTarif(obj){
		var linkupdate = "<?php echo $this->createUrl("admin"); //SETELAH RND-7868 SELESAI ?>";
		myConfirm("Proses ini memerlukan waktu yang cukup lama. Apakah anda tetap akan melanjutkan ?","Perhatian!", function(r){
			if(r){
				$(obj).hide();
				$(obj).parents("th").addClass('animation-loading-1');
				var pageaktif = $("#satarif-tindakan-m-grid .pagination .active a").html();
				$.ajax({
					type:'POST',
					url:'<?php echo $this->createUrl('CariPerbaikanTarif'); ?>',
					data: {pageaktif:pageaktif},//
					dataType: "json",
					success:function(data){
						if(data.sukses == 1){
							myConfirm(data.pesan+" Apakah anda ingin update tarif untuk tindakan "+data.daftartindakan_nama+"?","Perhatian!", function(r){
							if(r){
								window.location.href = linkupdate+"&id="+data.tariftindakan_id;
							}
							});
						}else{
							myAlert(data.pesan);
						}
						$(obj).show();
						$(obj).parents("th").removeClass('animation-loading-1');
					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
			}
		});
	}
</script>

    