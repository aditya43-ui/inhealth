<?php
$this->breadcrumbs = array(
    'Tindakan Ruangan' => array('admin'),
    'Tambah'
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Tindakan Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Tindakan Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Tindakan Ruangan', 'icon' => 'folder-open', 'url' => array('Admin'))) : '';

        //$this->menu=$arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'tindakanruangan-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'instalasi_id'),
        ));
        ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Instalasi", "instalasi_id", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        if (Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) {
                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(SAInstalasiM::getItems(), 'instalasi_id', 'instalasi_nama'), array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data); refreshTabel();}',
                                )
                            ));
                        } else {
                            echo CHtml::hiddenField('instalasi_id', Yii::app()->user->getState('instalasi_id'));
                            echo CHtml::textField('instalasi_nama', Yii::app()->user->getState('instalasi_nama'), array('readonly' => true, 'class' => 'span3'));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, "ruangan_id", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        if (Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) {
                            $modRuangans = SARuanganM::getItems($model->instalasi_id);
                            echo $form->dropDownList($model, 'ruangan_id', ((count((array)$modRuangans) > 0) ? CHtml::listData($modRuangans, 'ruangan_id', 'ruangan_nama') : array()), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'refreshTabel();', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        } else {
                            echo CHtml::activeHiddenField($model, 'ruangan_id', array('readonly' => true));
                            echo $form->textField($model, 'ruangan_nama', array('readonly' => true, 'class' => 'span3',));
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, "daftartindakan_id", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'daftartindakan_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'daftartindakan_nama',
                            'source' => 'js: function(request, response) {
									$.ajax({
										url: "' . $this->createUrl('AutocompleteTindakan') . '",
										dataType: "json",
										data: {
											term: request.term,
										},
										success: function (data) {
												response(data);
										}
									})
								 }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
										$(this).val( ui.item.value);
										return false;
									}',
                                'select' => 'js:function( event, ui ) { 
										$("#' . CHtml::activeId($model, 'daftartindakan_id') . '").val(ui.item.daftartindakan_id);
										return false;
									}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Kode / Uraian Tindakan',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                        ));
                        ?>
                    </div>
                    <div class="controls">
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                            'class' => 'btn btn-primary',
                            'onclick' => 'tambahTindakan();return false;',
                            'onkeypress' => "tambahTindakan();return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan tindakan ke ruangan",
                        ));
                        ?>
                        <?php
                        echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array(
                            'class' => 'btn btn-default',
                            'style' => 'float:inline;',
                            'onclick' => 'ulangTindakan();return false;',
                            'rel' => "tooltip",
                            'title' => "Klik untuk mengulang",
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tindakan Ruangan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'tindakanruangan-m-grid',
                    'dataProvider' => $modTindakanRuangan->search(),
                    'filter' => $modTindakanRuangan,
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'header' => 'Kelompok Tindakan',
                            'name' => 'kelompoktindakan_nama',
                            'value' => 'isset($data->daftartindakan->kelompoktindakan->kelompoktindakan_nama)?$data->daftartindakan->kelompoktindakan->kelompoktindakan_nama:" - "',
                            'filter' =>  CHtml::activeTextField($modTindakanRuangan, "kelompoktindakan_nama") . "<br>" .
                                CHtml::activeHiddenField($modTindakanRuangan, "ruangan_id", array('readonly' => true))
                        ),
                        array(
                            'header' => 'Kategori Tindakan',
                            'name' => 'kategoritindakan_nama',
                            'value' => 'isset($data->daftartindakan->kategoritindakan->kategoritindakan_nama)?$data->daftartindakan->kategoritindakan->kategoritindakan_nama:" - "',
                        ),
                        array(
                            'header' => 'Kode Tindakan',
                            'name' => 'daftartindakan_kode',
                            'value' => 'isset($data->daftartindakan->daftartindakan_kode)?$data->daftartindakan->daftartindakan_kode:" - "',
                        ),
                        array(
                            'header' => 'Uraian Tindakan',
                            'name' => 'daftartindakan_nama',
                            'value' => 'isset($data->daftartindakan->daftartindakan_nama)?$data->daftartindakan->daftartindakan_nama:" - "',
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete",array("ruangan_id"=>"$data->ruangan_id","daftartindakan_id"=>"$data->daftartindakan_id"))',
                                ),
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Tindakan Ruangan', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php
            $content = $this->renderPartial('sistemAdministrator.views.tindakanRuangan.tips.tipsaddedit', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php
        //========= Dialog buat cari data Bidang =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogTindakan',
            'options' => array(
                'title' => 'Daftar Tindakan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 800,
                'height' => 500,
                'resizable' => true,
            ),
        ));

        $modDaftarTindakan = new SADaftarTindakanM('search');
        $modDaftarTindakan->unsetAttributes();
        if (isset($_GET['SADaftarTindakanM'])) {
            $modDaftarTindakan->attributes = $_GET['SADaftarTindakanM'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'daftartindakan-m-grid',
            'dataProvider' => $modDaftarTindakan->search(),
            'filter' => $modDaftarTindakan,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
										"#",
										array(
											"class"=>"btn-small", 
											"id" => "selectTindakan",
											"onClick" => "
											$(\"#' . CHtml::activeId($model, 'daftartindakan_id') . '\").val(\'$data->daftartindakan_id\');
											$(\"#' . CHtml::activeId($model, 'daftartindakan_nama') . '\").val(\'$data->daftartindakan_nama\');
											$(\'#dialogTindakan\').dialog(\'close\');
											return false;"))'
                ),
                array(
                    'name' => 'kelompoktindakan.kelompoktindakan_nama',
                    'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'kelompoktindakan_id', CHtml::listData(SAKelompokTindakanM::getItems(), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'name' => 'kategoritindakan.kategoritindakan_nama',
                    'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'kategoritindakan_id', CHtml::listData(SAKategoriTindakanM::getItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'name' => 'komponenunit_id',
                    'value' => '$data->komponenunit->komponenunit_nama',
                    'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'komponenunit_id', CHtml::listData(SAKomponenUnitM::getItems(), 'komponenunit_id', 'komponenunit_nama'), array('empty' => '-- Pilih --')),
                ),
                'daftartindakan_kode',
                'daftartindakan_nama',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));

        $this->endWidget();
        ?>

        <?php $this->renderPartial($this->path_view . "_jsFunctions", array('model' => $model)); ?>

    </div>
</div>