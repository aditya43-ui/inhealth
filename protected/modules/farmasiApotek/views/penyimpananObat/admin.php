
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Penyimpanan Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Penyimpanan Obat ' => array('admin'),
            'Manage',
        );

        //$arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Lokasi Obat', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' FALookupM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Lokasi Obat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('falokasiobat-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");
        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penyimpanan Obat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'falokasiobat-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
										($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
										: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'ruangan_id',
                        array(
                            'name' => 'ruangan_nama',
                        //    'value' => '($data->lokasiobat_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
                        'value' => '$data->ruangan->ruangan_nama',
                        'filter' => CHtml::activeDropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::getRuanganItemsStatic(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
                        ),    
                        // 'rakobat_id',
                    
                        array(
                            'name'=>'rakobat_nama',
                            'value'=>'$data->rakobat->rakobat_nama',
                            'filter' => CHtml::activeDropDownList($model, 'rakobat_id', CHtml::listData(RakobatM::getRakObatItems(), 'rakobat_id', 'rakobat_nama'), array('empty' => '-- Pilih --')),

                        ),
                        array(
                            'name' => 'obatalkes_nama',
                            'filter' => CHtml::activeDropDownList($model, 'obatalkes_id', CHtml::listData(ObatalkesM::getObatalkesItems(), 'obatalkes_id', 'obatalkes_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->obatalkes->obatalkes_nama ?? "-"',

                    ),
                    array(
                        'header' => 'Status',
                        'value' => '($data->penyimpananobat_aktif == true ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                    ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove} {delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->penyimpananobat_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                ),
                                'delete' =>  array(
                                    'header' => 'Hapus',
                                    'type' => 'raw',
                                    'value' => '($data->jenisdiklat_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jenisdiklat_id)",array("id"=>"$data->jenisdiklat_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenisdiklat_id)",array("id"=>"$data->jenisdiklat_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenisdiklat_id)",array("id"=>"$data->jenisdiklat_id","rel"=>"tooltip","title"=>"Hapus"));',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                )
                            )
                        ),
                    ),
                    //'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    'afterAjaxUpdate' => 'function(id, data){
									jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
									$("table").find("input[type=text]").each(function(){
										cekForm(this);
									})
								}',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Tambah Penyimpanan Obat', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            //$this->widget('UserTips',array('content'=>''));
            $urlPrint = $this->createUrl('print');
            $url = $this->createUrl('/farmasiApotek/penyimpananObat');
            $js = <<< JSCRIPT
					function cekForm(obj){
						$("#penyimpananobat-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#penyimpananobat-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
					}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function nonActive(obj) {
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('falokasiobat-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dinonaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('falokasiobat-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
    }
</script>

