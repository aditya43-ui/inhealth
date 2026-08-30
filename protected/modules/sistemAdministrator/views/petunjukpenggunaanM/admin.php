<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Petunjuk Penggunaan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $arrMenu = array();
        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('petunjuk-penggunaan-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Petunjuk Penggunaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'petunjuk-penggunaan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        // ''
                        // array(
                        //     'header'=>'Modul',
                        //     'type' =>'raw',
                        //     'value' => '$data->modul->modul_nama'
                        // ),
                        array(
                            'header' => 'Menu',
                            'type' => 'raw',
                            'value' => '$data->menu->menu_nama'
                        ),
                        'petunjukpenggunaan_versi',
                        array(
                            'name' => 'petunjukpenggunaan_deskripsi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                echo $data->petunjukpenggunaan_deskripsi;
                            }
                        ),
                        //'petunjukpenggunaan_deskripsi',
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Sumber Dana'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Sumber Dana'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->petunjukpenggunaan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->petunjukpenggunaan_id)",array("id"=>"$data->petunjukpenggunaan_id","rel"=>"tooltip","title"=>"Menonaktifkan Sumber Dana"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->petunjukpenggunaan_id)",array("id"=>"$data->petunjukpenggunaan_id","rel"=>"tooltip","title"=>"Hapus Sumber Dana")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->petunjukpenggunaan_id)",array("id"=>"$data->petunjukpenggunaan_id","rel"=>"tooltip","title"=>"Hapus Sumber Dana"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
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

        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Petunjuk Penggunaan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah petunjuk penggunaan', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $urlPrint =  $this->createUrl('print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            $js = <<< JSCRIPT
				function cekForm(obj){
					$("#petunjuk-penggunaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#petunjuk-penggunaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<!--<div class="white-container">
    <legend class="rim2">Pengaturan <b>Petunjuk Penggunaan</b></legend>
    <div class="biru">
        <div class="white">-->
<!--<h6>Tabel <b>Petunjuk Penggunaan</b></h6>-->
<!--</div>-->
<!--</div>
    </div>-->
<!--</div>-->
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('petunjuk-penggunaan-m-grid');
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
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('petunjuk-penggunaan-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
    }
</script>