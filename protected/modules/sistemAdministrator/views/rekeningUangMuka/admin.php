<!--div class="white-container"-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Pengaturan <b>Rekening Uang Muka</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Rekening Uang Muka',
                );

                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id;

                $this->widget('bootstrap.widgets.BootAlert'); ?>

                <div class="cari-lanjut search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Rekening Uang Muka</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'saruangan-m-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'template' => "{summary}\n{items}{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'Instalasi',
                                    'name' => 'instalasi_nama',
                                    'value' => 'isset($data->instalasi->instalasi_nama)?$data->instalasi->instalasi_nama:" - "',
                                    'filter' => CHtml::activeDropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_id'), 'instalasi_id', 'instalasi_nama'), array(
                                        'empty' => '-- Pilih --',
                                    )),
                                    //				'filter'=>true,
                                ),
                                array(
                                    'header' => 'Kode Rekening',
                                    'name' => 'kdrekening5',
                                    'value' => 'isset($data->rekening5->kdrekening5)?$data->rekening5->kdrekening5:" - "',
                                ),
                                array(
                                    'header' => 'Nama Rekening',
                                    'name' => 'nmrekening5',
                                    'value' => 'isset($data->rekening5->nmrekening5)?$data->rekening5->nmrekening5:" - "',
                                ),
                                array(
                                    'name' => 'debitkredit',
                                    'value' => '$data->debitkredit == "D" ? "Debit" : "Kredit"',
                                    'filter' => CHtml::activeDropDownList($model, 'debitkredit', array('D' => 'Debit', 'K' => 'Kredit'), array(
                                        'empty' => '-- Pilih --',
                                    )),
                                ),
                                array(
                                    'header' => 'Pembatalan',
                                    'name' => 'ispembatalan',
                                    'type' => 'raw',
                                    'value' => '$data->ispembatalan ? "<i class=\"entypo-check\"></i>" : "-"',
                                    'filter' => CHtml::activeDropDownList($model, 'ispembatalan', array(1 => 'Ya', 2 => 'Tidak'), array(
                                        'empty' => '-- Pilih --',
                                    )),
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'Lihat',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(
                                            'label' => "<i class='icon-view'></i>",
                                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("idRuangan"=>"$data->instalasi_id","idTindakan"=>"$data->rekening5_id"))',
                                            'options' => array('rel' => 'tooltip', 'title' => 'Lihat Rekening Uang Muka'),
                                        ),
                                    )
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    'template' => '{delete}',
                                    'buttons' => array(
                                        'delete' => array(
                                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete",array("instalasi_id"=>"$data->instalasi_id","rekening5_id"=>"$data->rekening5_id"))',
                                        ),
                                    ),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        )); ?>
                    </div>
                </div>
                <?php

                echo CHtml::link(
                    Yii::t('mds', '{icon} Tambah Rekening Uang Muka', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('title' => 'Tambah rekening uang muka', 'class' => 'btn btn-danger',)
                );
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) :  '';
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) :  '';
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) :  '';
                $content = $this->renderPartial($this->path_view . 'tips.tipsAdmin', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                $js = <<< JSCRIPT
                function print(caraPrint)
                {
                    window.open("${urlPrint}/"+$('#saruangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
            </div>
        </div>
    </div>
</div>
<!--search-form-->
<!--<legend class='rim'>Tabel Tindakan Ruangan</legend>-->
<script type="text/javascript">
    $(document).ready(function() {
        $('input[name="SARekeninguangmukaM[nmrekening5]"]').focus();
    });
</script>
<!--/div-->