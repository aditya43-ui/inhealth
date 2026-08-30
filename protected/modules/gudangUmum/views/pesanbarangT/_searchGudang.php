<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'focus' => '#' . CHtml::activeId($model, 'nopemesanan'),
            'id' => 'gupesanbarang-t-search',
            'type' => 'horizontal',
        )); ?>
        <div class="row">
            <div class="col-sm-12">
                <?php /*//echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Pesan Barang','tglPesanBarang', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); 
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                        </div></div>
						<div class="control-group">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                    </label>
                    <div class="controls">
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div>
                    </div>
					 * 
					 */ ?>
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pesan Barang", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">
                        <?php echo CHtml::activeLabel($model, 'nopemesanan', array('class' => 'control-label')); ?>
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopemesanan', array('placeholder' => 'No. Pemesanan', 'class' => 'span4 angkahuruf-only', 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        <?php echo CHtml::activeLabel($model, 'pegpemesan_id', array('class' => 'control-label')); ?>
                    </label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'pegpemesan_id', CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = true AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::Label('Ruangan Pemesan', 'ruanganpemesan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array(
                            'empty' => '-- Pilih --', 'autofocus' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                'update' => '#' . CHtml::activeId($model, 'ruanganpemesan_id') . ''
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ruanganpemesan_id', array(), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); 
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
                $this->createUrl('informasiGudang'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'refreshForm(this); return false;'
                )
            ); ?>
            <?php
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
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="entypo-newspaper"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'CSV\')')
            );
            ?>
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printInformasi');
            $urlEksportCsv =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/eksportCSV');
            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gupesanbarang-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function exportTemplateCsv()
{
    window.open("${urlEksportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
            <?php
            $content = $this->renderPartial('gudangUmum.views.pesanbarangT.tips.informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>