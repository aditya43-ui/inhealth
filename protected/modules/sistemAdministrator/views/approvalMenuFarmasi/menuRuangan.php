<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'form-approvalMenuFarmasi',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#',
    ));

    
    $dataRuangan = RuanganM::model()->findAll('ruangan_aktif is true');

    $cs = Yii::app()->clientScript;
    $cs->scriptMap = array(
        'bootstrap-multiselect.js' => false,
    ); 
    $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Approval Menu Farmasi
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label"> Nama Menu</label>
                <div class="controls">
                    <div class="panel-title">
                        <b><?= isset($_GET['menu_nama']) ? $_GET['menu_nama'] : '' ?></b>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Ruangan</label>
                <div class="controls">
                    <?php
                    echo CHtml::hiddenField('menuRuangan');
                    $this->widget(
                        'application.extensions.emultiselect.EMultiSelect',
                        array('sortable' => true, 'searchable' => true)
                    );
                    echo CHtml::dropDownList(
                        'ruangan_id[]',
                        $dataRuanganDipilih,
                        CHtml::listData($dataRuangan, 'ruangan_id', 'ruangan_nama'),
                        array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                    );
                    ?>
                </div>
            </div>

            <div class="form-action">
                <?php 
                    echo CHtml::htmlButton(
                       Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
                    );
                    echo CHtml::link('<i class="fas fa-arrow-left" style="font-size: 14pt"></i> Kembali', $this->createUrl('index'), array('class' => 'btn btn-secondary'));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>