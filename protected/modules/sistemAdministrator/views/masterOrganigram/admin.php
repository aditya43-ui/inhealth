<?php
$this->breadcrumbs = array(
    'Kporganigram Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('kporganigram-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Tabel Organigram</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
            $this->widget('bootstrap.widgets.BootAlert');
        }
        ?>

        <!--<h6 class="rim2">Tabel Organigram</h6>-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Organigram</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kporganigram-m-grid',
                    'dataProvider' => $model->searchTable(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
									($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
									: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        'organigram_kode',
                        array(
                            'name' => 'organigramasal_id',
                            'value' => 'isset($data->organigramasal->pegawai->nama_pegawai) ? $data->organigramasal->pegawai->nama_pegawai : (isset($data->organigramasal->organigram_unitkerja) ? $data->organigramasal->organigram_unitkerja : "-")',
                            'filter' => CHtml::activeTextField($model, 'atasan'),
                        ),
                        array(
                            'header' => 'Unit Kerja',
                            'name' => 'organigram_unitkerja',
                            'value' => '$data->organigram_unitkerja',
                            'filter' => Chtml::activeDropDownList($model, 'organigram_unitkerja', Chtml::listData(UnitkerjaM::model()->findAll(" unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC "), 'namaunitkerja', 'namaunitkerja'), array('empty' => '-- Pilih --'))
                        ),
                        'organigram_formasi',
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'nama_pegawai',
                            'value' => '$data->pegawai->nama_pegawai',
                            'filter' => CHtml::activeTextField($model, 'nama_pegawai'),
                        ),
                        array(
                            // 'name' => 'jabatan_id',
                            'header' => 'Jabatan',
                            'name' => 'jabatan_id',
                            'value' => 'isset($data->jabatan_id)?"$data->Jabatan":"-"',
                            'filter' => CHtml::activeDropDownList($model, 'jabatan_id',  CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
                        ),
                        'organigram_pelaksanakerja',
                        //'organigram_periode',
                        array(
                            'header' => 'Periode',
                            'name' => 'organigram_periode',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_periode)." - ".MyFormatter::formatDateTimeForUser($data->organigram_sampaidengan) '
                        ),
                        //'organigram_sampaidengan',                   
                        array(
                            'name' => 'organigram_urutan',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->organigram_aktif)?"Aktif":"Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        /*
					'organigram_periode',
					'organigram_sampaidengan',
					'organigramasal_id',
					'create_time',
					'update_time',
					'create_loginpemakai_id',
					'update_loginpemakai_id',
					'create_ruangan',
					'organigram_aktif',
					'organigram_urutan',
					'pegawai_id',
					*/
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
                                'update' => array(
                                    //'click'=>'function(){ubahData(this);return false;}',
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        /*array(
							'header'=>Yii::t('zii','Delete'),
							'class'=>'bootstrap.widgets.BootButtonColumn',
							'template'=>'{remove} {delete}',
											'htmlOptions'=>array('style'=>'width:80px;'),
							'buttons'=>array(
								'remove' => array (
										'label'=>"<i class='icon-form-silang'></i>",
										'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
										'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->organigram_id))',
										'click'=>'function(){nonActive(this);return false;}',
										'visible'=>'($data->organigram_aktif)?true:false',
								),
								'delete'=> array(							
										'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>$data->organigram_id))',
										'click'=>'function(){delData(${data->organigram_id},this);return false;}',
										//'visible'=>'($data->organigram_aktif)?true:false',
										'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
								),
							)
						),*/
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->organigram_aktif)?CHtml::link("<i class=\'' . MyIcon::getIcons('batal') . '\'></i> ","javascript:removeTemporary($data->organigram_id)",array("id"=>"$data->organigram_id","rel"=>"tooltip","title"=>"Menonaktifkan Organigram"))." ".CHtml::link("<i class=\'' . MyIcon::getIcons('hapus') . '\'></i> ", "javascript:deleteRecord($data->organigram_id)",array("id"=>"$data->organigram_id","rel"=>"tooltip","title"=>"Hapus Organigram")):CHtml::link("<i class=\'' . MyIcon::getIcons('hapus') . '\'></i> ", "javascript:deleteRecord($data->organigram_id)",array("id"=>"$data->organigram_id","rel"=>"tooltip","title"=>"Hapus Organigram"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $urlPrint = $this->createUrl('print');
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Tabel Organigram', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Tabel Organigram', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            //$this->widget('UserTips',array('content'=>''));

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                            $.fn.yiiGridView.update('kporganigram-m-grid');
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

    function removeTemporary(id) {
        var url = '<?php echo $url . "/nonActive"; ?>';
        myConfirm('Apakah Anda yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.sukses == 1) {

                            $.fn.yiiGridView.update('kporganigram-m-grid');

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
        myConfirm('Apakan Anda yakin akan menghapus data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.sukses == 1) {
                            if (data.pesan != '') {
                                myAlert(data.pesan);
                            } else {
                                $.fn.yiiGridView.update('kporganigram-m-grid');
                            }
                        } else {
                            myAlert('Data gagal dihapus!');
                        }
                    }, "json");
            }
        });
    }

    /**
     * ubah data organigram
     * @param {type} obj
     * @returns {Boolean}
     */
    function ubahData(obj) {
        parent.window.location.href = obj.href;
        return false;
    }
</script>