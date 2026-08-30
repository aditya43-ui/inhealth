<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cog"></i> Pengaturan <b>SMS Gateway</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'SMS Gateaway' => array('admin'),
            'Pengaturan',
        );

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sasmsgateway-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
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
                    <i class="entypo-credit-card"></i> Tabel <b>SMS Gateway</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sasmsgateway-m-grid',
                    'dataProvider' => $model->search(),
                    // 'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        ////'smsgateway_id',
                        /*
                          array(
                          'name'=>'smsgateway_id',
                          'value'=>'$data->smsgateway_id',
                          'filter'=>false,
                          ), */
                        array(
                            'name' => 'modul_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $model = ModulK::model()->findByPk($data->modul_id);

                                if (!empty($model)) {
                                    return $model->modul_nama;
                                }

                                return "-";
                            },
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Tujuan SMS',
                            'value' => '$data->tujuansms',
                        ),
                        array(
                            'header' => 'Jenis SMS',
                            'value' => '$data->jenissms',
                        ),
                        array(
                            'header' => 'Nama Controller',
                            'value' => '$data->modcontroller',
                        ),
                        array(
                            'header' => 'Nama Action',
                            'value' => '$data->modaction',
                        ),
                        array(
                            'header' => 'Template SMS',
                            'value' => '$data->templatesms',
                        ),
                        /* 'jenissms',
                          'modcontroller',
                          'modaction',
                          'templatesms',
                          'jmlkaraktersms',
                          'formatsms',
                          'katawalsms',
                          'kataakhirsms',
                          'ishurufkapital',
                          'modcontroller', */
                        //                    array(
                        //                        'name'=>'statussms',
                        //                        'value'=>'$data->statussms?"Aktif":"Tidak Aktif"',
                        //                        'htmlOptions'=>array(
                        //                            'style'=>'text-align: center',
                        //                        )
                        //                    ),
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
                            'template' => '{remove} {delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->smsgateway_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                ),
                                'delete' => array(),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah SMS Gateway', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah SMS gateway', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $this->widget('UserTips', array('type' => 'admin'));
            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sasmsgateway-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
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
                                $.fn.yiiGridView.update('sasmsgateway-m-grid');
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
</div>