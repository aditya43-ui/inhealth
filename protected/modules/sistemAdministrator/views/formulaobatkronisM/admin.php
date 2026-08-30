<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Formula Obat Kronis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $sukses = null;
        if (isset($_GET['id'])) {
            $sukses = $_GET['id'];
        }

        ?>
        <?php
        $this->breadcrumbs = array(
            'Formula Obat Kronis',
        );

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
						$('.search-form').toggle();
						return false;
				});
				$('.search-form form').submit(function(){
						$.fn.yiiGridView.update('gfpabrik-m-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Formula Obat Kronis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Pabrik</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gfpabrik-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
											($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
											: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:center; width:10px;'),
                        ),
                        'jumlahobat', 
                        'jumlahobat_minimal', 
                        'jumlahobat_maksimal',
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => '(($data->is_aktif) ? "Aktif" : "Tidak Aktif")',
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
                            'header' => Yii::t('zii', 'Non Aktif'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{remove}{add}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Nonaktif Sementara')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->formulaobatkronis_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    'visible' => '(($data->is_aktif) ? TRUE : FALSE)',
                                ),
                                'add' => array(
                                    'label' => "<i class='icon-form-check'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->formulaobatkronis_id))',
                                    'click' => 'function(){active(this);return false;}',
                                    'visible' => '(($data->is_aktif) ? FALSE : TRUE)',
                                ),
                                'delete' => array(),
                            )
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->formulaobatkronis_id)",array("id"=>"$data->formulaobatkronis_id","rel"=>"tooltip","title"=>"Hapus Formula"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
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

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Formula Obat Kronis', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Formula Obat Kronis', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'master', array(), true);
            $this->widget('UserTips', array('type' => 'master', 'content' => $content));
            $urlPrint = $this->createUrl('print');
            $js = <<< JSCRIPT
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#gfpabrik-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>'
        </div>
    </div>
</div>

<script type="text/javascript">
    function cekForm(obj) {
        $("#gfpabrik-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

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
                            $.fn.yiiGridView.update('gfpabrik-m-grid');
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

    function active(obj) {
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('gfpabrik-m-grid');
                            if (data.sukses > 0) {
                                myAlert('Data berhasil diaktifkan!');
                            } else {
                                myAlert('Data gagal diaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal diaktifkan!');
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
        var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id) . "/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('gfpabrik-m-grid');
                        } else {
                            myAlert(data.konfirmasi);
                        }
                    }, "json");
            }
        });
    }
</script>