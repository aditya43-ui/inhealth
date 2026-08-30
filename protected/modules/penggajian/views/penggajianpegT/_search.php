<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gjpenggajianpeg-t-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nomorindukpegawai'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo $form->label($model, 'Periode Gaji', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('type_approve', '', array('class' => 'span4')); ?>
                        <?php
                        // var_dump($model->attributes); die;
                        $model->periodegaji = MyFormatter::formatMonthForUser($model->periodegaji);
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'periodegaji',
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'yearRange' => "-100y:+0y",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => "span2 periode_gaji",
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'nopenggajian', array('class' => 'control-label inline', 'label' => 'No. Pengajuan')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopenggajian', array('placeholder' => 'No. Pengajuan', 'class' => 'span4')); ?>
                    </div>
                </div>
                <?php echo $form->hiddenField($model, 'kategoripegawaiasal', array('class' => 'span4')); ?>
                <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('placeholder' => 'NIP', 'class' => 'span4')); ?>
                <?php // echo $form->dropDownListRow($model,'kategoripegawaiasal',LookupM::getItems('kategoriasalpegawai'), 
                //                        array(	'empty'=>'-- Pilih --','class'=>'span4', 
                //								'onkeyup'=>"return $(this).focusNextInputField(event)")); 
                ?>
                <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4')); ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'kelompokpegawai_id', array('class' => 'control-label inline', 'label' => 'Kelompok Pegawai')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownlist($model, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true order by kelompokpegawai_id'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model, 'jabatan_id', JabatanM::jabatanList(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                <?php echo $form->dropDownListRow($model, 'status', array(1 => 'BELUM DIBAYAR', 2 => 'SUDAH DIBAYAR'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                <?php //echo $form->textFieldRow($model,'penggajianpeg_id',array('class'=>'span5')); 
                ?>
            </div>
        </div>

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
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel - Pegawai', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel - Penghasilan Bulanan', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPenghasilanBulanan(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel - Data Penghasilan', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPenghasilan(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel - Penggajian', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPenggajian(\'EXCEL\')'));
            //    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel - Pemotongan PPh 21/Final',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'printPemotongan(\'EXCEL\')')); 

            $urlPrint = $this->createUrl('printApproveAll');
            $urlPrintPenghasilanBulanan = $this->createUrl('printPenghasilanBulanan');
            $urlPrintPenghasilan = $this->createUrl('printPenghasilan');
            $urlPrintPemotongan = $this->createUrl('printPemotongan');
            $urlPrintPenggajian = $this->createUrl('exportPenggajian');

            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $tips = array(
                '0' => 'simpan',
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
            $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize() +
            "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }

    function printPenghasilanBulanan(caraPrint) {
        window.open("<?php echo $urlPrintPenghasilanBulanan; ?>&" +
            $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize() +
            "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }

    function printPenghasilan(caraPrint) {
        window.open("<?php echo $urlPrintPenghasilan; ?>&" +
            $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize() +
            "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }

    function printPemotongan(caraPrint) {
        window.open("<?php echo $urlPrintPemotongan; ?>&" +
            $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize() +
            "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }

    function printPenggajian(caraPrint) {
        window.open("<?php echo $urlPrintPenggajian; ?>&" +
            $("#gjpenggajianpeg-t-search :input").not("input[name='r']").serialize() +
            "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }
</script>