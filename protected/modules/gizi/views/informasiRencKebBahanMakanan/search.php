<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'rencana-t-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'noperencnaan'),
    )); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Rencana", 'tglRencanaKebutuhan', array('class' => 'control-label')) ?>
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
            <?php echo $form->textFieldRow($model, 'renkebbahanmakanan_no', array('placeholder' => 'No. Rencana Barang', 'class' => 'angkahuruf-only span4')); ?>
            <div class="control-group">
                <?php echo CHtml::label('Sumber Dana', 'sumberdana_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'sumberdana_id', Chtml::ListData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE"), 'sumberdana_id', 'sumberdana_nama'), array('class' => 'span4', 'empty' => '-- Pilih --',)) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Pegawai Mengetahui', 'pegmengetahui_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'pegmengetahui_id', Chtml::ListData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ORDER BY nama_pegawai ASC "), 'pegawai_id', 'namaLengkap'), array('class' => 'span4', 'empty' => '-- Pilih --',)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Pegawai Menyetujui', 'pegmenyetujui_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'pegmenyetujui_id', Chtml::ListData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ORDER BY nama_pegawai ASC "), 'pegawai_id', 'namaLengkap'), array('class' => 'span4', 'empty' => '-- Pilih --',)) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
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
        ); ?>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printInformasi');
        $urlEksportCsv =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/eksportCSV');
        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rencana-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function exportTemplateCsv()
{
    window.open("${urlEksportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <?php
        $content = $this->renderPartial($this->path_view . 'tips/informasirenkebbarang', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>