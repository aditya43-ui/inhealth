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
            <div class="col-sm-6">
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
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'nopemesanan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopemesanan', array('placeholder' => 'No. Pemesanan', 'class' => 'span4 angkahuruf-only', 'maxlength' => 20)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'pegpemesan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'pegpemesan_id', CHtml::listData($model->getPegawaiRuangan(), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'ruanganpemesan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <!--RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$model->ruanganpemesan->instalasi_id,'ruangan_aktif'=>true-->
                        <?php echo $form->dropDownList($model, 'ruanganpemesan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = TRUE ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20, 'disabled' => true)); ?>
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
                $this->createUrl('informasi'),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    // 'onclick' => 'refreshForm(this); return false;',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            ?>
            <?php
            $content = $this->renderPartial('gudangUmum.views.pesanbarangT.tips.informasiPemesananBarang', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>