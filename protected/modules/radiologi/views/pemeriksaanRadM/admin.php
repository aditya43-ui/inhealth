<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Pemeriksaan Radiologi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            ' Pemeriksaan Radiologi',
        );

        Yii::app()->clientScript->registerScript('search', "
					$('.search-button').click(function(){
						$('.search-form').toggle();
						return false;
					});
					$('.search-form form').submit(function(){
						$.fn.yiiGridView.update('sapemeriksaan-rad-m-grid', {
							data: $(this).serialize()
						});
						return false;
					});
					");
        ?>
        <?php
        if (isset($_GET['sukses'])) :
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
        endif;
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Radiologi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sapemeriksaan-rad-m-grid',
                    'dataProvider' => $model->searchTabel(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'pemeriksaanrad_id',
                            'value' => '$data->pemeriksaanrad_id',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'daftartindakan_nama',
                            'filter' => CHtml::activeDropDownList($model, 'daftartindakan_id', CHtml::listData(DaftartindakanM::model()->findAll("daftartindakan_aktif = TRUE ORDER BY daftartindakan_nama ASC"), 'daftartindakan_id', 'daftartindakan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')),
                            'value' => '$data->daftartindakan->daftartindakan_nama',
                        ),
                        array(
                            'header' => 'Jenis Pemeriksaan',
                            'name' => 'jenispemeriksaanrad_id',
                            'filter' =>  CHtml::activeDropDownList($model, 'jenispemeriksaanrad_id', CHtml::listData(JenispemeriksaanradM::model()->findAll(array('order' => 'jenispemeriksaanrad_nama', 'condition' => 'jenispemeriksaanrad_aktif = true')), 'jenispemeriksaanrad_id', 'jenispemeriksaanrad_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->jenispemeriksaanrad->jenispemeriksaanrad_nama',
                        ),
                        'pemeriksaanrad_nama',
                        'pemeriksaanrad_namalainnya',
                        array(
                            'header' => 'Sub-Jenis Pemeriksaan',
                            'filter' => CHtml::activeDropDownList($model, 'subjenis_pemeriksaanrad_id', CHtml::listData(SubjenisPemeriksaanradM::model()->findAll("subjenis_aktif = TRUE ORDER BY subjenis_pr_nama ASC"), 'subjenis_pemeriksaanrad_id', 'subjenis_pr_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')),
                            'value' => function ($data) {
                                $subjenis = '-';
                                if(!empty($data->subjenis_pemeriksaanrad_id)) {
                                    $subjenis = SubjenisPemeriksaanradM::model()->findByPk($data->subjenis_pemeriksaanrad_id)->subjenis_pr_nama;
                                }

                                return $subjenis;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        'kode_dicom_modality',
                        array(
                            'header' => 'Status',
                            'value' => '($data->pemeriksaanrad_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat pemeriksaan radiologi'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah pemeriksaan radiologi'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove} {add} {delete}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='" . MyIcon::getIcons("batal") . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->pemeriksaanrad_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    'visible' => '$data->pemeriksaanrad_aktif',
                                ),
                                'add' => array(
                                    'label' => "<i class='icon-form-check'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Active Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->pemeriksaanrad_id))',
                                    'visible' => '($data->pemeriksaanrad_aktif) ? FALSE : TRUE',
                                    'click' => 'function(){active(this,1);return false;}',
                                ),
                                'delete' => array(),
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
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Pemeriksaan Radiologi', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Pemeriksaan Radiologi', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
					function cekForm(obj){
						$("#sapemeriksaan-rad-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#sapemeriksaan-rad-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=1');
					}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    //    function removeTemporary(id){
    //        var url = '<?php echo $url . "/removeTemporary"; ?>';
    //        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
    //            if (r){
    //                 $.post(url, {id: id},
    //                     function(data){
    //                        if(data.status == 'proses_form'){
    //                                $.fn.yiiGridView.update('sapemeriksaan-rad-m-search');
    //                            }else{
    //                                myAlert('Data gagal dinonaktifkan!')
    //                            }
    //                },"json");
    //           }
    //       });
    //    }
    //
    //    function statusDelete(id){
    //        var url = '<?php echo $url . "/removeTemporary"; ?>';
    //        myConfirm("Yakin Akan Menghapus Data ini?","Perhatian!",function(r) {
    //            if (r){
    //                 $.post(url, {id: id},
    //                     function(data){
    //                        if(data.status == 'proses_form'){
    //                                $.fn.yiiGridView.update('sapemeriksaan-rad-m-grid');
    //                            }else{
    //                                myAlert('Data gagal dihapus!')
    //                            }
    //                },"json");
    //           }
    //       });
    //    }
    //
    //    function deleteRecord(id){
    //        var id = id;
    //        var url = '<?php echo $url . "/delete"; ?>';
    //        myConfirm("Yakin Akan Menghapus Data ini?","Perhatian!",function(r) {
    //            if (r){
    //                 $.post(url, {id: id},
    //                     function(data){
    //                        if(data.status == 'proses_form'){
    //                                $.fn.yiiGridView.update('sapemeriksaan-rad-m-grid');
    //                            }else{
    //                                myAlert('Data gagal dihapus!')
    //                            }
    //                },"json");
    //           }
    //        });
    //    }
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
                            $.fn.yiiGridView.update('sapemeriksaan-rad-m-grid');
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

    function active(obj, add) {
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {
                            add: add
                        }, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('sapemeriksaan-rad-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal aktifkan!');
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
    $(document).ready(function() {
        $("input[name$='ROPemeriksaanRadM[daftartindakan_nama]']").focus();
    });
</script>