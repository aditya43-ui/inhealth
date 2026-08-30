<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>DTD</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sadtd Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Dtd ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Dtd', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Dtd', 'icon' => 'file', 'url' => array('create'))) :  '';

        //$this->menu=$arrMenu;

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					$('#SADtdM_dtd_noterperinci').focus();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('sadtd-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
			");

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>DTD</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class='rim'>Tabel DTD</legend>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sadtd-m-grid',
                    'dataProvider' => $model->search(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'name' => 'dtd_id',
                            'value' => '$data->dtd_id',
                            'filter' => false,
                        ),
                        'dtd_noterperinci',
                        'dtd_nama',
                        'dtd_namalainnya',
                        array(
                            'name' => 'dtd_menular',
                            'type' => 'raw',
                            'value' => '($data->dtd_menular==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                        ),
                        /*
					array(
						'header'=>'ICD-X',
						'type'=>'raw',
						'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_icdx\',array(\'dtd_id\'=>$data->dtd_id),true)',
					),
					* 
					*/
                        array(
                            'header' => 'Status',
                            'value' => '($data->dtd_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        //                 array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->dtd_aktif',
                        //                ), 					
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat DTD'),
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Update'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah DTD'),
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Delete'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove} {add} {delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('rel' => 'tooltip', 'title' => 'Menonaktifkan DTD'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->dtd_id"))',
                                    'visible' => '($data->dtd_aktif) ? TRUE : FALSE',
                                    'click' => 'function(){ removeTemporary(this); return false;}',
                                ),
                                'add' => array(
                                    'label' => "<i class='entypo-check'></i>",
                                    'options' => array('rel' => 'tooltip', 'title' => 'Mengaktifkan DTD'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->dtd_id", "add"=>1))',
                                    'visible' => '($data->dtd_aktif) ? FALSE : TRUE',
                                    'click' => 'function(){ addTemporary(this, 1); return false;}',
                                ),
                                'delete' => array(
                                    //                              'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus DTD'),
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
					jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
					$("table").find("input[type=text]").each(function(){
						cekForm(this);
					})
				}',
                )); ?>
            </div>
        </div>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah DTD', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
        $js = <<< JSCRIPT
			function cekForm(obj){
				$("#sadtd-m-search :input[name='"+ obj.name +"']").val(obj.value);
			}
			function print(caraPrint){
				window.open("${urlPrint}/"+$('#sadtd-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <script type="text/javascript">
            function removeTemporary(obj) {
                var url = $(obj).attr('href');
                myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: url,
                            data: {},
                            dataType: "json",
                            success: function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('sadtd-m-grid');
                                } else {
                                    myAlert('Data gagal dinonaktifkan!.')
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                });
            }

            function addTemporary(obj, add) {
                var url = $(obj).attr('href') + $(add).attr('href');
                myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: url,
                            data: {},
                            dataType: "json",
                            success: function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('sadtd-m-grid');
                                } else {
                                    myAlert('Data Gagal di Aktifkan.')
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                });
            }

            $(document).ready(function() {
                $('input[name="SADtdM[dtd_noterperinci]"]').focus();
            });
        </script>
    </div>
</div>