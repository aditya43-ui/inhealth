<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i>
            <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                echo 'Pengaturan <b>Master E-tiket</b>';
            } else {
                echo 'Pengaturan <b>Master Lookup</b>';
            }
            ?>
        </div>
    </div>
    <div class="panel-body">
        <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                $this->breadcrumbs = array(
                    'Etiket' => array('index'),
                    'Manage',
                );
            } else {
                $this->breadcrumbs = array(
                    'Lookup Ms' => array('index'),
                    'Manage',
                );
            }

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('lookup-m-grid', {
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
                    <i class="entypo-credit-card"></i>
                    <?php
                    if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                        echo 'Tabel <b>E-tiket</b>';
                    } else {
                        echo 'Tabel <b>Lookup</b>';
                    }
                    ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', ' Data berhasil disimpan.');
                }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'lookup-m-grid',
                        'dataProvider' => $model->searchFarmasi(),
                        'filter' => $model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'ID',
                                'value' => '$data->lookup_id',
                            ),
                            array(
                                'name' => 'lookup_type',
                                'filter' => Chtml::dropDownList('SALookupM[lookup_type]', $model->lookup_type, CHtml::listData(LookupM::getLookupTypeFarmasi(), 'lookup_type', 'lookup_type'), array('empty' => '-- Pilih --')),
                            ),
                            'lookup_name',
                            'lookup_value',
                            'lookup_kode',
                            'lookup_urutan',
                            array(
                                'header' => 'Status',
                                'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            ),
                            array(
                                'header' => 'Lihat/Edit/Delete',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'htmlOptions' => array('style' => 'text-align: center; width: 140px;'),
                                'template' => '{view} {update} {remove}',
                                'buttons' => array(
                                    'remove' => array(
                                        'label' => "<i class='icon-form-silang'></i>",
                                        'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                        'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->lookup_id))',
                                        'click' => 'function(){nonActive(this);return false;}',
                                        'visible' => '($data->lookup_aktif)?TRUE:FALSE',
                                    ),
                                ),
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
                } else {
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'lookup-m-grid',
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'columns' => array(
                            ////'lookup_id',
                            array(
                                'header' => 'ID',
                                'value' => '$data->lookup_id',
                            ),
                            //'lookup_type',
                            array(
                                'name' => 'lookup_type',
                                'filter' => Chtml::dropDownList('SALookupM[lookup_type]', $model->lookup_type, CHtml::listData(LookupM::getAllLookupType(), 'lookup_type', 'lookup_type'), array('empty' => '-- Pilih --')),
                            ),
                            'lookup_name',
                            'lookup_value',
                            'lookup_kode',
                            'lookup_urutan',
                            array(
                                'header' => 'Status',
                                'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            ),
                            //'lookup_aktif',
                            //                array(
                            //                        'header'=>'Aktif',
                            //                        'class'=>'CCheckBoxColumn',     
                            //                        'selectableRows'=>0,
                            //                        'id'=>'rows',
                            //                        'checked'=>'$data->lookup_aktif',
                            //                ),
                            array(
                                'header' => 'Lihat',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'template' => '{view}',
                            ),
                            array(
                                'header' => 'Ubah',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'template' => '{update}',
                            ),
                            array(
                                'header' => 'Hapus',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                'template' => '{remove}{delete}',
                                'buttons' => array(
                                    'remove' => array(
                                        'label' => "<i class='icon-form-silang'></i>",
                                        'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                        'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->lookup_id))',
                                        'click' => 'function(){nonActive(this);return false;}',
                                        'visible' => '($data->lookup_aktif)?TRUE:FALSE',
                                    ),
                                    'delete' => array(
                                        'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                    ),
                                ),
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
                }
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Tambah Etiket', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('title' => 'Tambah Etiket', 'class' => 'btn btn-danger',)
                );
            } else {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Tambah Lookup', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('title' => 'Tambah lookup', 'class' => 'btn btn-danger',)
                );
            }
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sakonfigfarmasi-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sakonfigfarmasi-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("input[name='SALookupM[lookup_name]']").focus();
    });
</script>
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
                            $.fn.yiiGridView.update('lookup-m-grid');
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
</script>