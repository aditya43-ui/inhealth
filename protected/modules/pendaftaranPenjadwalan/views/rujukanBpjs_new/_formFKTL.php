<!--<div class="row-fluid well" id="fktl">-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_formPencarianFktl', array('form' => $form)); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data Rujukan Fasilitas Rumah Sakit
        </div>
    </div>
    <div class="panel-body" id="data-fktl">
        <?php $this->renderPartial($this->path_view . '_formRujukanTL', array('form' => $form)); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true, 'onclick' => 'printRujukanFktl(\'PRINT\')')); ?>
</div>
<!--</div>-->