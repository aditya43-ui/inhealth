<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Kelas Ruangan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php // $this->renderPartial('_tab'); 
        ?>
        <?php
        $this->breadcrumbs = array(
            'Kelas Ruangan',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelas Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Kelas Ruangan', 'icon' => 'file', 'url' => array('create'))) :  '';
        Yii::app()->clientScript->registerScript('search', "
						$('.search-button').click(function(){
							$('.search-form').toggle();
							$('#" . CHtml::activeId($model, 'instalasi_nama') . "').focus();
							return false;
						});
						$('.search-form form').submit(function(){
							$.fn.yiiGridView.update('ppruangan-m-grid', {
								data: $(this).serialize()
							});
							return false;
						});
					");
        if (isset($_GET['sukses'])) :
            Yii::app()->user->setFlash('success', '<b>Berhasil</b> Data Berhasil disimpan');
        endif;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn'));
        ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kelas Ruangan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ppruangan-m-grid',
                    'dataProvider' => $model->searchTabel(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'header' => 'Instalasi',
                            'value' => '$data->ruangan->instalasi->instalasi_nama',
                            'filter' => (Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) ? CHtml::activeTextField($model, 'instalasi_nama') : false,
                        ),
                        array(
                            'name' => 'ruangan_id',
                            'value' => '$data->ruangan->ruangan_nama',
                            'filter' => (Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) ? CHtml::activeTextField($model, 'ruangan_nama') : false,
                        ),
                        array(
                            'header' => 'Kelas Pelayanan ',
                            'type' => 'raw',
                            'name' => 'kelaspelayanan_nama',
                            'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
                            'filter' => CHtml::activeDropDownList($model, 'kelaspelayanan_id', CHtml::listData(SAKelasPelayananM::model()->getItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/View",array("id"=>"$data->ruangan_id"))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Ruangan Pegawai'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus Kelas Ruangan'),
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ),
                            )
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
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Kelas Ruangan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah kelas ruangan', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $js = <<< JSCRIPT
					function cekForm(obj){
						$("#ppruangan-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}     
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#ppruangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
					}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name="SARuanganM[ruangan_nama]"]').focus();
    })
</script>