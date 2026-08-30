<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gupemakaianbarang-t-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglpemakaianbrg', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                Sampai dengan
          </label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                ));
                ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'noreturterima', array('class' => 'span3', 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'nopenerimaan', array('class' => 'span3', 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData(SupplierM::model()->getSupplierUmumItems(), 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 20)); ?>

        <?php echo $form->dropDownListRow($model, 'pegretur_id', PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 20)); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>

    <?php
    echo " / " . CHtml::htmlButton(
        Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')
    );

    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')
    );

    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')
    );

    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="entypo-newspaper"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'CSV\')')
    ) . " / ";
    ?>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printInformasi');
    $urlEksportCsv =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/eksportCSV');


    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gupemakaianbarang-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function exportTemplateCsv()
{
    window.open("${urlEksportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>

    <?php
    $content = $this->renderPartial('billingKasir.views.tips.informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>