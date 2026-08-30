<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Unit Kerja</b>
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
            'Agunitkerja Ms' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('agunitkerja-m-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Unit Kerja</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Unit Kerja</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'agunitkerja-m-grid',
                    'dataProvider' => $model->searchUnit(),
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
                            'header' => 'Kode',
                            'name' => 'kodeunitkerja',
                            'value' => '$data->kodeunitkerja',
                            'filter' => Chtml::activeTextField($model, 'kodeunitkerja', array('class' => 'angkahurufs-only'))
                        ),
                        array(
                            'header' => 'Divisi',
                            'name' => 'divisi',
                            'value' => '$data->divisi',
                            'filter' => Chtml::activeDropDownList($model, 'divisi',LookupM::getItems('divisiunitkerja'), array('empty' => 'Pilih'))
                        ),
                        array(
                            'header' => 'Nama',
                            'name' => 'namaunitkerja',
                            'value' => '$data->namaunitkerja',
                            'filter' => Chtml::activeTextField($model, 'namaunitkerja', array('class' => 'hurufs-only'))
                        ),
                        array(
                            'header' => 'Nama Lain',
                            'name' => 'namalain',
                            'value' => '$data->namalain',
                            'filter' => Chtml::activeTextField($model, 'namalain', array('class' => 'hurufs-only'))
                        ),
                        //		array(
                        //			'header'=>'Ruangan Unit',
                        //			'name'=>'ruangan_nama',
                        //			'type'=>'raw',
                        //			'value'=>'$data->ruanganMs->ruangan_nama'
                        //		),

                        array(
                            'header' => 'Ruangan Unit',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_ruanganUnit\',array(\'unitkerja_id\'=>$data->unitkerja_id),true)',
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => '(($data->unitkerja_aktif) ? "Aktif" : "Tidak Aktif")',
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
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove}{add}{delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='" . MyIcon::getIcons('batal') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Nonaktif Sementara')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->unitkerja_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    'visible' => '(($data->unitkerja_aktif) ? TRUE : FALSE)',
                                ),
                                'add' => array(
                                    'label' => "<i class='" . MyIcon::getIcons('tambah') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->unitkerja_id))',
                                    'click' => 'function(){active(this);return false;}',
                                    'visible' => '(($data->unitkerja_aktif) ? FALSE : TRUE)',
                                ),
                                'delete' => array(
                                    'label' => "<i class='icon-form-check'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/delete",array("id"=>$data->unitkerja_id))',
                                    'click' => 'function(){hapus(this);return false;}',
                                    //'visible'=>'(($data->unitkerja_aktif) ? FALSE : TRUE)',

                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    $(".angkahuruf-only").keyup(function() {
                        setAngkaHurufOnly(this);
                    });    
                    $(".hurufs-only").keyup(function() {
                        setHurufsOnly(this);
                    });    
                    $("table").find("input[type=text]").each(function(){
                        cekForm(this);
                    });

                }',
                )); ?>
                <!--</div>-->
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Unit Kerja', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah unit kerja', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $tips = array(
                '0' => 'lihat',
                '1' => 'ubah',
                '2' => 'nonaktif',
                '3' => 'hapus',
                '4' => 'masterPRINT',
                '5' => 'masterEXCEL',
                '6' => 'masterPDF',
                '7' => 'pencarianlanjut',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'master', 'content' => $content));
            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#agunitkerja-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function cekForm(obj) {
        $("#agunitkerja-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

    function nonActive(obj) {
        myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('agunitkerja-m-grid');
                            if (data.sukses > 0) {
                                myAlert('Data berhasil dinonaktifkan!');
                            } else {
                                myAlert(data.pesan);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            c
                            onsole.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }

    function active(obj) {
        myConfirm("Apakah Anda yakin ingin mengaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('agunitkerja-m-grid');
                            if (data.sukses > 0) {
                                myAlert('Data berhasil diaktifkan!');
                            } else {
                                myAlert(data.pesan);
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

    function hapus(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus data ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('agunitkerja-m-grid');
                            if (data.sukses > 0) {
                                myAlert('Data berhasil dihapus!');
                            } else {
                                myAlert(data.pesan);
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
</script>