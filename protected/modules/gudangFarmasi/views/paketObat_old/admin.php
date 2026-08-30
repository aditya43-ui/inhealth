<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <strong>Master Paket Obat</strong></div>
    </div>
    <div class="panel-body">				
        <?php
        $this->breadcrumbs = array(
            'Paket Obat' => array('admin'),
            'pengaturan',
        );

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
						$('.search-form').toggle();
						return false;
				});
				$('.search-form form').submit(function(){
						$.fn.yiiGridView.update('gftemplateobat-m-grid', {
								data: $(this).serialize()
						});
						return false;
				});
				");
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
        <p></p>
        <div class="cari-lanjut search-form" style="display:none;padding: 10px;border: 1px solid">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div><!-- search-form --><hr>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <strong>Paket Obat</strong></div>
            </div>
            <div class="panel-body overflow-x">
                <div class="block-tabel">
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'gftemplateobat-m-grid',
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
                            array(
                                'header' => 'Dokter',
                                'type' => 'raw',
                                'name' => 'nama_pegawai',                                
                                'value' => function($data) {                                    
                                    return !empty($data->dokter_id) ? $data->pegawai->namaLengkap : '-';
                                }
                            ),
                            'nama_paket',                            
                            'harga_paket',                            
                            array(
                                'header' => 'Status',
                                'type' => 'raw',
                                'value' => '(($data->is_aktif) ? "Aktif" : "Tidak Aktif")',
                            ),
                            array(
                                'header' => Yii::t('zii', 'View'),
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{view}',
                                'buttons' => array(
                                    'view' => array(),
                                ),
                            ),
                            array(
                                'header' => Yii::t('zii', 'Update'),
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{update}',
                                'buttons' => array(
                                    'update' => array(),
                                ),
                            ),
                            array(
                                'header' => Yii::t('zii', 'Non Aktif'),
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{remove}{add}',
                                'buttons' => array(
                                    'remove' => array(
                                        'label' => "<span style='font-size:20px'><i class='glyphicon glyphicon-remove'></i></span>",
                                        'options' => array('title' => Yii::t('mds', 'Nonaktif Sementara')),
                                        'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->paketobat_id))',
                                        'click' => 'function(){nonActive(this);return false;}',
                                        'visible' => '(($data->is_aktif) ? TRUE : FALSE)',
                                    ),
                                    'add' => array(
                                        'label' => "<span style='font-size:20px'><i class='glyphicon glyphicon-check'></i></span>",
                                        'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                                        'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->paketobat_id))',
                                        'click' => 'function(){active(this);return false;}',
                                        'visible' => '(($data->is_aktif) ? FALSE : TRUE)',
                                    ),
                                    'delete' => array(),
                                )
                            ),
                            array(
                                'header' => 'Hapus',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<span style=\'font-size:20px;\'><i class=\'glyphicon glyphicon-trash\'></i></span> ", "javascript:deleteRecord($data->paketobat_id)",array("id"=>"$data->paketobat_id","rel"=>"tooltip","title"=>"Hapus Paket Obat"));',
                                'htmlOptions' => array('style' => 'width:80px'),
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
        </div>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Master Paket Obat', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
        $content = $this->renderPartial('sistemAdministrator.views.tips.master', array(), true);
        $this->widget('UserTips', array('type' => 'master', 'content' => $content));
        $urlPrint = $this->createUrl('print');
        $js = <<< JSCRIPT
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#gftemplateobat-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>'
    </div>
</div>

<script type="text/javascript">
    function cekForm(obj)
    {
        $("#gftemplateobat-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

    function nonActive(obj) {
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: obj.href,
                            data: {}, //
                            dataType: "json",
                            success: function (data) {
                                $.fn.yiiGridView.update('gftemplateobat-m-grid');
                                if (data.sukses > 0) {
                                } else {
                                    myAlert('Data gagal dinonaktifkan!');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
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
        myConfirm("Yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: obj.href,
                            data: {}, //
                            dataType: "json",
                            success: function (data) {
                                $.fn.yiiGridView.update('gftemplateobat-m-grid');
                                if (data.sukses > 0) {
                                    myAlert('Data berhasil diaktifkan!');
                                } else {
                                    myAlert('Data gagal diaktifkan!');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
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
        myConfirm("Yakin Akan Menghapus Data ini ?", 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('gftemplateobat-m-grid');
                            } else {
                                myAlert(data.konfirmasi);
                            }
                        }, "json");
            }
        });
    }
</script>