<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jadwalpegawai-info-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Jadwal", 'jadwaldokter_mulai', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="input-append">
                    <input value="<?php echo MyFormatter::formatMonthForUser($model->tgl_awal) ?>" type="text" name="KPInformasijadwalpegawaiV[tgl_awal]" id="KPInformasijadwalpegawaiV_tgl_awal" onkeypress="return $(this).focusNextInputField(event);" readonly="readonly" class="span2 hasDatepicker">
                    <span class="add-on" onclick="$('#KPInformasijadwalpegawaiV_tgl_awal').focus()"><i class="entypo-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'nama_pegawai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow(
            $model,
            'instalasi_id',
            CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'),
            array(
                'disabled' => $dis, 'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                    'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                )
            )
        );
        ?>

    </div>
    <div class="col-sm-6">

        <?php echo $form->dropDownListRow($model, 'ruangan_id', $dropRuang, array('disabled' => $dis, 'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kelompokpegawai_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true order by kelompokpegawai_nama'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'shift_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'shift_id', CHtml::listData(ShiftM::model()->findAll('shift_aktif = true order by shift_nama'), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>

</div>
<div class="form-actions">
    <?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); 
    ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'generateJadwal();')
    ); ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintMaterialHabis');

    ?>
    <?php
    // $this->widget('bootstrap.widgets.BootButtonGroup', array(
    //     'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    //     'buttons' => array(

    //         array('label' => 'Print', 'icon' => 'entypo-print', 'url' => $urlPrint, 'htmlOptions' => array('onclick' => 'print(\'PRINT\');return false;')),
    //         array('label' => '', 'items' => array(
    //             array('label' => 'PDF', 'icon' => 'icon-book', 'url' => $urlPrint, 'itemOptions' => array('onclick' => 'print(\'PDF\');return false;')),
    //             array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => $urlPrint, 'itemOptions' => array('onclick' => 'print(\'EXCEL\');return false;')),

    //         )),
    //     ),
    // ));

    echo CHtml::htmlButton(
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
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>