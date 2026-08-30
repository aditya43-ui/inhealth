<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pengajuanbonusthr-t-search',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => ' '
    ),
    'type' => 'horizontal',
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Periode', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('type_approve', '', array('class' => 'span4')); ?>
                        <?php
                        $model->periodebonusthr = MyFormatter::formatMonthForUser($model->periodebonusthr);
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'periodebonusthr',
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'yearRange' => "-100y:+0y",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => "span2 ",
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('No. Pengajuan', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopengajuan', array('placeholder' => 'No. Pengajuan', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('NIP', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nip', array('placeholder' => 'NIP', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Transaksi <span style="color:red">*</span>', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenisgaji', LookupM::getItemsUrutan('jenisgaji'), array('empty' => '-- Pilih --', 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownlist($model, 'ruangan_id', CHtml::listData(KPRuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Unit Kerja', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownlist($model, 'unitkerja_id', KPPegawaiM::model()->getDropUnitKerjaItems(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kategori Pegawai', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownlist($model, 'statuspegawai', LookupM::getItems('kategoripegawai'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kelompok Pegawai', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownlist($model, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true order by kelompokpegawai_id'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jabatan', '', array('class' => 'control-label ')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jabatan_id', JabatanM::jabatanList(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/PenggajianpegT/Informasi'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'style' => 'margin-top: 1px !important;',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php //echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('PenggajianpegT/Informasi'), array('class'=>'btn btn-danger')); 
    ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Export THR dan Bonus', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXPORT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

    $urlPrint = $this->createUrl('printInformasi');
    //    $urlPrintPenghasilanBulanan= $this->createUrl('printPenghasilanBulanan');
    //    $urlPrintPenghasilan= $this->createUrl('printPenghasilan');
    //    $urlPrintPemotongan= $this->createUrl('printPemotongan');
    //    $urlPrintPenggajian = $this->createUrl('exportPenggajian');

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $tips = array(
        '0' => 'cari',
        '1' => 'ulang',
        '2' => 'print',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
    </div>
</div>


<?php $this->endWidget(); ?>

<script>
    function print(caraPrint) {
        window.open("<?php echo $urlPrint; ?>&" +
            $("#pengajuanbonusthr-t-search :input").not("input[name='r']").serialize() +
            "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }

    //    function printPenghasilanBulanan(caraPrint)
    //    {
    //        window.open("<?php // echo $urlPrintPenghasilanBulanan; 
                            ?>&"
    //                + $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize()
    //                + "&caraPrint="+caraPrint,"",'location=_new, width=900px');
    //    }
    //
    //     function printPenghasilan(caraPrint)
    //    {
    //        window.open("<?php // echo $urlPrintPenghasilan; 
                            ?>&"
    //                + $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize()
    //                + "&caraPrint="+caraPrint,"",'location=_new, width=900px');
    //    }
    //
    //    function printPemotongan(caraPrint)
    //    {
    //        window.open("<?php // echo $urlPrintPemotongan; 
                            ?>&"
    //                + $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize()
    //                + "&caraPrint="+caraPrint,"",'location=_new, width=900px');
    //    }
    //
    //    function printPenggajian(caraPrint)
    //    {
    //        window.open("<?php // echo $urlPrintPenggajian; 
                            ?>&"
    //                + $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize()
    //                + "&caraPrint="+caraPrint,"",'location=_new, width=900px');
    //    }
</script>