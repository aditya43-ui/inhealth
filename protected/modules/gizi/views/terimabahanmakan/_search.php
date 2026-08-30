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
            'id' => 'gzpengajuanbahanmkn-search',
            'type' => 'horizontal',
        )); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Penerimaan Bahan", 'tglterimabahan', array('class' => 'control-label')) ?>
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
                    <?php echo Chtml::label("No Penerimaan Bahan", 'nopenerimaanbahan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopenerimaanbahan', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'No. Penerimaan Bahan')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("Supplier", 'supplier_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'supplier_id', CHtml::listData(SupplierM::model()->findAll("supplier_aktif = true AND supplier_jenis = '" . Params::SUPPLIER_JENIS_GIZI . "' ORDER BY supplier_nama ASC"), 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label("Sumber Dana Bahan", 'sumberdanabhn', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'sumberdanabhn', CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true'), 'sumberdana_nama', 'sumberdana_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("Ruangan", 'ruangan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
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
            $content = $this->renderPartial('../tips/informasiPenerimaanMakanan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>