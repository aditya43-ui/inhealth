<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Kelompok Faktor Risiko</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'KelompokFaktorResiko Ms' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('kelompokfaktorrisiko-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array('model' => $model));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kelompok Faktor Risiko</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
                }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kelompokfaktorrisiko-m-grid',
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
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Jenis Faktor Risiko',
                            'name' => 'jenisfaktorrisiko_nama',
                            'value' => function ($data) {
                                if (!empty($data->jenisfaktorrisiko_id)) {
                                    $cekJenisFaktor = JenisfaktorrisikoM::model()->findByPk($data->jenisfaktorrisiko_id);
                                    echo !empty($cekJenisFaktor) ? $cekJenisFaktor->jenisfaktorrisiko_nama : '-';
                                } else {
                                    echo '-';
                                }
                            },
                            'filter' => CHtml::activeDropDownList($model, 'jenisfaktorrisiko_id', CHtml::listData($model->JenisFaktorItems, 'jenisfaktorrisiko_id', 'jenisfaktorrisiko_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Faktor Risiko',
                            'name' => 'faktorrisiko_daftar_nama',
                            'value' => function ($data) {
                                if (!empty($data->faktorrisiko_daftar_id)) {
                                    $cekFaktorResiko = FaktorrisikoDaftarM::model()->findByPk($data->faktorrisiko_daftar_id);
                                    echo !empty($cekFaktorResiko) ? $cekFaktorResiko->faktorrisiko_daftar_nama : '-';
                                } else {
                                    echo '-';
                                }
                            },
                            'filter' => CHtml::activeDropDownList($model, 'faktorrisiko_daftar_id', CHtml::listData($model->FaktorRisikoItems, 'faktorrisiko_daftar_id', 'faktorrisiko_daftar_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->kelompokfaktorrisikodaftar_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'filter' => CHtml::dropDownList('ASKelompokFaktorResikoM[kelompokfaktorrisikodaftar_aktif]', $model->kelompokfaktorrisikodaftar_aktif, array(0 => 'Tidak Aktif', 1 => 'Aktif'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->kelompokfaktorrisikodaftar_id))',
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->kelompokfaktorrisikodaftar_id))',
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->kelompokfaktorrisikodaftar_aktif)?'
                                . 'CHtml::link("<i class=\'glyphicon glyphicon-remove\'></i> ","javascript:removeTemporary($data->kelompokfaktorrisikodaftar_id)",array("id"=>"$data->kelompokfaktorrisikodaftar_id","rel"=>"tooltip","title"=>"Menonaktifkan Tanda dan Gejala"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->kelompokfaktorrisikodaftar_id)",array("id"=>"$data->kelompokfaktorrisikodaftar_id","rel"=>"tooltip","title"=>"Hapus Kelompok Faktor Risiko")):'
                                . 'CHtml::link("<i class=\'glyphicon glyphicon-ok\'></i> ","javascript:addTemporary($data->kelompokfaktorrisikodaftar_id)",array("id"=>"$data->kelompokfaktorrisikodaftar_id","rel"=>"tooltip","title"=>"Mengaktifkan Tanda dan Gejala"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->kelompokfaktorrisikodaftar_id)",array("id"=>"$data->kelompokfaktorrisikodaftar_id","rel"=>"tooltip","title"=>"Hapus Faktor Risiko"));',
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
                Yii::t('mds', '{icon} Tambah Kelompok Faktor Risiko', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Kelompok Faktor Risiko', 'class' => 'btn btn-danger')
            );
            $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#kelompokfaktorrisiko-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#kelompokfaktorrisiko-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                            $.fn.yiiGridView.update('kelompokfaktorrisiko-m-grid');
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
                            $.fn.yiiGridView.update('kelompokfaktorrisiko-m-grid');
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
                            $.fn.yiiGridView.update('kelompokfaktorrisiko-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }

    function cekForm(obj) {
        $("#kelompokfaktorrisiko-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

    $(document).ready(function() {
        $("input[name='SATandagejalaM[tandagejala_indikator]']").focus();
    });
</script>