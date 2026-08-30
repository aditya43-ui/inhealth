<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Pengaturan <b>Warna Dokumen</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Warnadokrm Ms' => array('index'),
                    'Manage',
                );

                Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
                });
                $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('warnadokrm-m-grid', {
                        data: $(this).serialize()
                    });
                    return false;
                });
                ");
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <div class="cari-lanjut search-form">
                    <?php $this->renderPartial('_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Warna Dokumen</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'warnadokrm-m-grid',
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
                                    'htmlOptions' => array('style' => 'text-align:right;'),
                                ),
                                // 'warnadokrm_id',
                                'warnadokrm_namawarna',

                                array(
                                    'name' => 'warnadokrm_kodewarna',
                                    'type' => 'raw',
                                    'header' => 'Warna',
                                    'value' => function ($data) {
                                        return '<div style="width:100px; border: 1px solid black; background-color:#' . $data->warnadokrm_kodewarna . ';">&nbsp;</div>';
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                    'filter' => false,
                                ),
                                'warnadokrm_fungsi',
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->warnadokrm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                ),
                                array(
                                    'header' => Yii::t('zii', 'View'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(),
                                        'options' => array('rel' => 'tooltip', 'title' => 'Lihat warna dokumen'),
                                    ),
                                ),
                                array(
                                    'header' => Yii::t('zii', 'Update'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{update}',
                                    'buttons' => array(
                                        'update' => array(
                                            'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                                        'options' => array('rel' => 'tooltip', 'title' => 'Ubah warna dokumen'),
                                    ),
                                ),
                                array(
                                    'header' => Yii::t('zii', 'Delete'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{remove} {delete}',
                                    'buttons' => array(
                                        'remove' => array(
                                            'label' => "<i class='icon-form-silang'></i>",
                                            'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->warnadokrm_id))',
                                            'click' => 'function(){nonActive(this);return false;}',
                                            'visible' => '($data->warnadokrm_aktif==TRUE)?TRUE:FALSE',
                                        ),
                                        'delete' => array(
                                            'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                            'options' => array('rel' => 'tooltip', 'title' => 'Hapus warna dokumen'),
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
                        )); ?>
                    </div>
                </div>

                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Tambah Warna Dokumen', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('title' => 'Tambah Warna Dokumen', 'class' => 'btn btn-danger',)
                );
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                $content = $this->renderPartial('../tips/master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $urlPrint = $this->createUrl('print');

                $js = <<< JSCRIPT
                function cekForm(obj) {
                    $("#warnadokrm-m-search :input[name='"+ obj.name +"']").val(obj.value);
                }
                function print(caraPrint) {
                    window.open("${urlPrint}/"+$('#warnadokrm-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
            </div>
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
                            $.fn.yiiGridView.update('warnadokrm-m-grid');
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