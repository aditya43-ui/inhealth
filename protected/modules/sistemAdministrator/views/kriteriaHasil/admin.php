<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>SLKI</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Bataskarakteristik Ms' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bataskarakteristik-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>SLKI</b>
                </div>
            </div>
            <div class="panel-body">

                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
                }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'bataskarakteristik-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Luaran Keperawatan',
                            'name' => 'luarankeperawatan_id',
                            'value' => 'isset($data->kriteriahasil->luarankeperawatan->luarankeperawatan_nama) ? $data->kriteriahasil->luarankeperawatan->luarankeperawatan_nama : " - "',
                            'filter' => Chtml::activeDropDownList($model, 'luarankeperawatan_id',  Chtml::listData(LuarankeperawatanM::model()->findAll("luarankeperawatan_aktif = TRUE ORDER BY luarankeperawatan_nama ASC"), 'luarankeperawatan_id', 'luarankeperawatan_nama'), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Kriteria Hasil',
                            'name' => 'kriteriahasil_nama',
                            'value' => 'isset($data->kriteriahasil->kriteriahasil_nama) ? $data->kriteriahasil->kriteriahasil_nama : " - "',
                            'filter' => Chtml::activeDropDownList($model, 'kriteriahasil_nama', LookupM::getItems('tingkatkriteriahasil'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)"))
                        ),
                        array(
                            'header' => 'Indikator',
                            'name' => 'kriteriahasildet_indikator',
                            'value' => 'isset($data->kriteriahasildet_indikator) ? $data->kriteriahasildet_indikator : " - "',
                        ),
                        array(
                            'header' => 'Status',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'value' => '($data->kriteriahasildet_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                            /*'filter' => CHtml::dropDownList(
							'aktif', $model->aktif, array('1' => 'Aktif',
						'0' => 'Tidak Aktif',), array('empty' => '-- Pilih --'))*/
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->kriteriahasil_id))',
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
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->kriteriahasil_id))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->kriteriahasildet_aktif) ? '
                                . 'CHtml::link("<i class=\'glyphicon glyphicon-remove\'></i> ","javascript:removeTemporary($data->kriteriahasildet_id)",array("id"=>"$data->kriteriahasildet_id","rel"=>"tooltip","title"=>"Menonaktifkan SLKI"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->kriteriahasildet_id)",array("id"=>"$data->kriteriahasildet_id","rel"=>"tooltip","title"=>"Hapus SLKI")):'
                                . 'CHtml::link("<i class=\'glyphicon glyphicon-ok\'></i> ","javascript:addTemporary($data->kriteriahasildet_id)",array("id"=>"$data->kriteriahasildet_id","rel"=>"tooltip","title"=>"Mengaktifkan SLKI"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->kriteriahasildet_id)",array("id"=>"$data->kriteriahasildet_id","rel"=>"tooltip","title"=>"Hapus SLKI"));',
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
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah SLKI', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah SLKI', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#bataskarakteristik-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#bataskarakteristik-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script>
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function addTemporary(id) {
        var url = '<?php echo $url . "/addTemporary"; ?>';
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                        } else {
                            myAlert('Data Gagal di Aktifkan')
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
                            $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $("input[name='SAKriteriahasildetM[kriteriahasil_nama]']").focus();
    });
</script>