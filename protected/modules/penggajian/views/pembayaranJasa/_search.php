<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gjpembayaranjasa-t-search',
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
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pengajuan", 'tgl_rekam', array('class' => 'control-label')) ?>
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
                        <?php echo $form->checkBox($model, 'cekPeriode', array('uncheckValue' => null)) ?>
                        Periode Jasa
                    </label>
                    <div class="controls">
                        <?php
                        // var_dump($model->attributes); die;
                        $model->cari_period = MyFormatter::formatMonthForUser($model->cari_period);
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'cari_period',
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
                <?php echo $form->textFieldRow($model, 'nobayarjasa', array('placeholder' => 'No. Pengajuan Jasa', 'autofocus' => true, 'class' => 'span4 all-caps', 'maxlength' => 15)); ?>
                <?php echo $form->textFieldRow($model, 'namaDokter', array('placeholder' => 'Nama Pegawai', 'class' => 'span4')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'jenisjasa', Params::getJenisJasa(), array('empty' => '-- Pilih --')) ?>
                <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id',  CHtml::listData(KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif = TRUE ORDER BY kelompokpegawai_nama ASC"), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --')) ?>
                <?php echo $form->dropDownListRow($model, 'jabatan_id',  CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')); ?>
                <?php
                //					echo $form->dropDownListRow($model,'create_loginpemakai_id', PegawairuanganV::getDropPegawaiByUser(Yii::app()->user->getState('ruangan_id')), array('empty'=>'-- Pilih --')); 
                ?>
                <?php // echo $form->textFieldRow($model,'noKasKeluar',array('class'=>'span4')); 
                ?>
                <?php // echo $form->dropDownListRow($model,'jabatan_id',  CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --')); 
                ?>
                <?php // echo $form->dropDownListRow($model,'status_gaji', array('SUDAH'=>'SUDAH','BELUM'=>'BELUM'), array('empty'=>'-- Pilih --')); 
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
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Excel - Bukti Potong', array('{icon}' => '<i class="entypo-doc-text                "></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printBuktiPotong(\'EXCEL\')')
            );
            ?>
            <?php
            $tips = array(
                '0' => 'cari',
                '1' => 'ulang',
                '2' => 'masterEXCEL',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $urlPrintBuktiPotong = $this->createUrl('printBuktiPotong');
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function printBuktiPotong(caraPrint) {
        window.open("<?php echo $urlPrintBuktiPotong; ?>&" +
            $("#gjpembayaranjasa-t-search :input").not("input[name='r']").serialize() +
            "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }
</script>