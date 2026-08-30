<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'lookup-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'lookup_type'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <label for="LookupM_lookup_type" class="control-label required">Type <span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::textField('lookup_type', $model->lookup_type, array('placeholder' => 'Type', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onblur' => 'setLookup(this.value);', 'maxlength' => 100, 'readonly' => (!empty($model->lookup_id) ? true : false),)); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i>
            <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                echo 'Tabel <b>Etiket</b>';
            } else {
                echo 'Tabel <b>Lookup</b>';
            }
            ?>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="table-lookup" class="table table-striped table-bordered table-condensed">
            <thead>
                <th>Nama</th>
                <th>Value</th>
                <th>Kode</th>
                <th>Urutan</th>
                <th>Aktif</th>
                <th></th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        "#",
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
        )
    );
    ?>
    <?php
        if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
            echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Etiket', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)); 
        } else {
            echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Lookup', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)); 
        }
        ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit2d', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDetail' => $modDetail)); ?>