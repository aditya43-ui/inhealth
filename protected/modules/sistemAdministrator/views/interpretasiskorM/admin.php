<!--div class="white-container"-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Pengaturan <b>Interpretasi Skor</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Psinterpretasiskor Ms' => array('index'),
                    'Manage',
                );

                $arrMenu = array();
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Interpretasi Skor ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAInterpretasiskorM', 'icon'=>'list', 'url'=>array('index'))) ;
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Interpretasi Skor', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

                $this->menu = $arrMenu;

                Yii::app()->clientScript->registerScript('search', "
					$('.search-button').click(function(){
						$('.search-form').toggle();
						$('#SAInterpretasiskorM_intepretasi_nama').focus();
						return false;
					});
					$('.search-form form').submit(function(){
						$.fn.yiiGridView.update('psinterpretasiskor-m-grid', {
							data: $(this).serialize()
						});
						return false;
					});
					");
                if (isset($_GET['sukses'])) :
                    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
                endif;
                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <div class="cari-lanjut search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Interpretasi Skor</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'psinterpretasiskor-m-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                ////'interpretasiskor_id',
                                array(
                                    'name' => 'interpretasiskor_id',
                                    'value' => '$data->interpretasiskor_id',
                                    'filter' => false,
                                ),
                                'intepretasi_nama',
                                'interpretasijmlskor',
                                'interpretasimin',
                                'interpretasimax',
                                'catatan',
                                //'interpretasiskor_aktif',
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->interpretasiskor_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                ),
                                array(
                                    'header' => Yii::t('zii', 'View'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{view}',
                                ),
                                array(
                                    'header' => Yii::t('zii', 'Update'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{update}',
                                    'buttons' => array(
                                        'update' => array(
                                            'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                                    ),
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'type' => 'raw',
                                    'value' => '($data->interpretasiskor_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->interpretasiskor_id)",array("id"=>"$data->interpretasiskor_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->interpretasiskor_id)",array("id"=>"$data->interpretasiskor_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->interpretasiskor_id)",array("id"=>"$data->interpretasiskor_id","rel"=>"tooltip","title"=>"Hapus"));',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){
								jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
								$("table").find("input[type=text]").each(function(){
									cekForm(this);
								})
								 $("table").find("select").each(function(){
									cekForm(this);
								})
							}',
                        )); ?>
                    </div>
                </div>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Interpretasi Skor', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                $content = $this->renderPartial($this->path_view . 'tips/master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                $js = <<< JSCRIPT
					function cekForm(obj){
						$("#psinterpretasiskor-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#psinterpretasiskor-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
					}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
            </div>
        </div>
    </div>
</div>

<!--<h6>Tabel <b>Interpretasi Skor</b></h6>-->
<!--</div>-->
<!--/div-->
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('psinterpretasiskor-m-grid');
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
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('psinterpretasiskor-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
    $(document).ready(function() {
        $("input[name='SAInterpretasiskorM[intepretasi_nama]']").focus();
    });
</script>