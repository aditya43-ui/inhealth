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
            'id' => 'informasipemakaianbhnmkn-v-search',
            'type' => 'horizontal',
            //	'focus'=>'#'.CHtml::activeId($model,'nopemakaianbrg'),
        )); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pemakaian", '', array('class' => 'control-label')) ?>
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
                    <?php echo CHtml::label('No Pemakaian Bahan Makanan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_pemakaianbhnmkn', array('placeholder' => 'No. Pemakaian Bahan Makanan', 'class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ruanganpemakaibhnmkn', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Untuk Keperluan', 'untukkeperluan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'untukkeperluan', array('placeholder' => 'Untuk Keperluan', 'class' => 'span4 custom-only', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model, 'ketpemakaian', array('placeholder' => 'Keterangan Pemakaian', 'rows' => 4, 'cols' => 200, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
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
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printInformasi(\'PRINT\')')
            );
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printInformasi(\'PDF\')')
            );
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printInformasi(\'EXCEL\')')
            );
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="entypo-newspaper"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printInformasi(\'CSV\')')
            ); ?>
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printInformasi');
            $js = <<< JSCRIPT
function printInformasi(caraPrint)
{
    window.open("${urlPrint}/"+$('#informasipemakaianbhnmkn-v-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print_informasi', $js, CClientScript::POS_HEAD);
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>