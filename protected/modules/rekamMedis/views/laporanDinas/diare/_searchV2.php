<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>

    <div class="row">
        <div class="col-sm-6">
            <?php
            $tahun = date('Y');
            $arrTahun = array();
            while ($tahun > 2016) {
                $arrTahun[$tahun] = $tahun;
                $tahun--;
            }
            ?>
            <?php
            echo $form->dropDownListRow($model, 'tahun', $arrTahun, array('class' => 'form-control span3'));
            echo $form->dropDownListRow($model, 'bulan', Params::getBulan2(), array('class' => 'form-control span3'));
            ?>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $criIns = new CDbCriteria();
                    $criIns->addInCondition("instalasi_id", Params::getArrayInstalasiPelayanan());
                    $criIns->addCondition(" instalasi_aktif = TRUE ");
                    $criIns->order = " instalasi_nama ASC ";
                    echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($criIns), 'instalasi_id', 'instalasi_nama'), array(
                        'class' => 'form-control span3', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $model,
                        'ruangan_id',
                        array(),
                        array('class' => 'form-control span3', 'multiple' => 'multiple')
                    ); ?>
                </div>
            </div>
        </div>
    </div>

    <div clas="form-actions">
        <?php echo CHtml::htmlButton('<i class="entypo-search"></i> Cari', array(
            'type' => 'submit', 'class' => 'btn btn-danger',
        )); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>