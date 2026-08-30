<div class="row-fluid well" id="fktl">
    <fieldset class="box" id="pencarian-fktl">
        <legend class="rim">Data Pencarian</legend>
        <?php $this->renderPartial($this->path_view . '_formPencarianFktl', array('form' => $form)); ?>
    </fieldset>

    <fieldset class="box" id="data-fktl">
        <legend class="rim">Data Rujukan Fasilitas Tingkat Lanjut</legend>
        <?php $this->renderPartial($this->path_view . '_formRujukanTL', array('form' => $form)); ?>
    </fieldset>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true, 'onclick' => 'printRujukanFktl(\'PRINT\')')); ?>
    </div>
</div>