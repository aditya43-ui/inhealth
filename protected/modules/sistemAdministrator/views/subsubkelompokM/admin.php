<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Pengaturan <b>Sub-Sub Kelompok</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Sasubsubkelompok Ms' => array('index'),
                    'Manage',
                );

                $arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Sub Sub Kelompok ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASubkelompokM', 'icon'=>'list', 'url'=>array('index'))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Sub Kelompok', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

                $this->menu = $arrMenu;

                Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('sasubsubkelompok-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");

                $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <div class="cari-lanjut search-form" style="display:none; padding: 10px;border: 1px solid">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Sub-Sub Kelompok</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'sasubsubkelompok-m-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                ////'subkelompok_id',
                                array(
                                    'name' => 'subsubkelompok_id',
                                    'value' => '$data->subsubkelompok_id',
                                    'filter' => false,
                                ),
                                array(
                                    'header' => 'Golongan',
                                    'filter' => CHtml::activeDropDownList($model, 'golongan_id', CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'), array('empty' => '-- Pilih --')),
                                    'value' => '$data->subkelompok->kelompok->bidang->golongan->golongan_nama',
                                ),
                                array(
                                    'header' => 'Bidang',
                                    'filter' => CHtml::activeDropDownList($model, 'bidang_id', CHtml::listData($model->getBidang(), 'bidang_id', 'bidang_nama'), array('empty' => '-- Pilih --')),
                                    'value' => '$data->subkelompok->kelompok->bidang->bidang_nama',
                                ),
                                array(
                                    'header' => 'Kelompok',
                                    'filter' => CHtml::activeDropDownList($model, 'kelompok_id', CHtml::listData($model->getKelompok(), 'kelompok_id', 'kelompok_nama'), array('empty' => '-- Pilih --')),
                                    'value' => '$data->subkelompok->kelompok->kelompok_nama',
                                ),
                                array(
                                    'name' => 'subkelompok_id',
                                    'filter' => CHtml::activeDropDownList($model, 'subkelompok_id', CHtml::listData($model->getSubKelompok(), 'subkelompok_id', 'subkelompok_nama'), array('empty' => '-- Pilih --')),
                                    'value' => '$data->subkelompok->subkelompok_nama',
                                ),
                                array(
                                    'name' => 'subsubkelompok_kode',
                                    'filter' => Chtml::activeTextField($model, 'subsubkelompok_kode', array('class' => 'angkadot-only'))
                                ),
                                array(
                                    'name' => 'subsubkelompok_nama',
                                    'filter' => Chtml::activeTextField($model, 'subsubkelompok_nama', array('class' => 'custom-only'))
                                ),
                                array(
                                    'name' => 'subsubkelompok_namalainnya',
                                    'filter' => Chtml::activeTextField($model, 'subsubkelompok_namalainnya', array('class' => 'custom-only'))
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->subsubkelompok_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                ),
                                //		array(
                                //                        'header'=>'Aktif',
                                //                        'class'=>'CCheckBoxColumn',     
                                //                        'selectableRows'=>0,
                                //                        'id'=>'rows',
                                //                        'checked'=>'$data->subkelompok_aktif',
                                //                ),
                                array(
                                    'header' => Yii::t('zii', 'View'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{view}',
                                ),
                                array(
                                    'header' => Yii::t('zii', 'Update'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{update}',
                                    //'buttons'=>array(
                                    //   'update' => array (
                                    //                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    //             ),
                                    //  ),
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'type' => 'raw',
                                    'value' => '($data->subsubkelompok_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->subsubkelompok_id)",array("id"=>"$data->subsubkelompok_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->subsubkelompok_id)",array("id"=>"$data->subsubkelompok_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->subsubkelompok_id)",array("id"=>"$data->subsubkelompok_id","rel"=>"tooltip","title"=>"Hapus"));',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){
								 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
								 $("table").find("input[type=text]").each(function(){
									 cekForm(this);
								 });
								  $("table").find("select").each(function(){
									 cekForm(this);
								 });
								 $(".angkadot-only").keyup(function(){
									 setAngkaDotOnly(this);
								 });
								 $(".custom-only").keyup(function(){
									 setCustomOnly(this);
								 });
							 }',
                        )); ?>
                    </div>
                </div>

                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Tambah Sub Sub Kelompok', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('title' => 'Tambah Sub Sub Kelompok', 'class' => 'btn btn-danger',)
                );
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                $js = <<< JSCRIPT
					function cekForm(obj){
						$("#sasubsubkelompok-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#sasubsubkelompok-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
					}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('sasubsubkelompok-m-grid');
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
        myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('sasubsubkelompok-m-grid');
                        } else if (data.status == 'gagal_form') {
                            myAlert('Maaf data ini tidak bisa dihapus dikarenakan digunakan pada table lain.')
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
    $(document).ready(function() {
        $('input[name="SASubsubkelompokM[subkelompok_kode]"]').focus();
    })
</script>
</div>