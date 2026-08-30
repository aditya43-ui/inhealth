<?php
$this->breadcrumbs = array(
    'Tindakan Ruangan' => Yii::app()->request->getUrlReferrer(),
    'Ubah'
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Tindakan Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'update') . ' Tindakan Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
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

        <div class="row">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <?php echo $form->errorSummary($model); ?>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Ruangan', array('class' => 'control-label required')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'ruangan_id', array("readonly" => TRUE));
                        echo CHtml::textField('ruangan_nama', $model->ruangan->ruangan_nama, array('readonly' => true, 'class' => 'span3'));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Daftar Tindakan", "daftartindakan_nama", array('class' => 'control-label')); ?>
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
                                'class' => 'span3'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            );
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                '',
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Tindakan Ruangan', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
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