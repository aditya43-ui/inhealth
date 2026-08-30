<div class="search-form">
    <?php
    $form = $this->beginWidget(
        'ext.bootstrap.widgets.BootActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'search-jurnal-umum',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
                'onKeyPress' => 'return disableKeyPress(event)'
            ),
        )
    );
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.numbersOnly',
        'config' => array(
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => '.',
            'thousands' => '',
            'precision' => 0
        )
    ));
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.currency',
        'currency' => 'PHP',
        'config' => array(
            'symbol' => 'Rp',
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => ',',
            'thousands' => '.',
            'precision' => 0,
        )
    ));
    ?>
    <fieldset class="">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Jurnal", 'AKJurnaldetailT_tgl_akhir', array('class' => 'control-label')) ?>
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
                    <label for="AKJurnaldetailT_nobuktijurnal" class="control-label">No. Bukti Jurnal</label>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'nobuktijurnal', array('placeholder' => 'No. Bukti Jurnal', 'class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="AKJurnaldetailT_kodejurnal" class="control-label">Kode Jurnal</label>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'kodejurnal', array('placeholder' => 'Kode Jurnal', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="AKJurnaldetailT_noreferensi" class="control-label">Uraian Jurnal</label>
                    <div class="controls">
                        <?php
                        echo $form->textArea($model, 'urianjurnal', array('placeholder' => 'Uraian Jurnal', 'class' => 'span4 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="AKJurnaldetailT_jenisjurnal_id" class="control-label">Jenis Jurnal</label>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList(
                            $model,
                            'jenisjurnal_id',
                            JenisjurnalM::items(),
                            array(
                                'empty' => '-- Pilih --',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span4'
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label for="AKJurnaldetailT_is_posting" class="control-label">Status Posting</label>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList(
                            $model,
                            'is_posting',
                            array("1" => "SUDAH POSTING", "0" => "BELUM POSTING"),
                            array(
                                'class' => 'span4',
                                'inline' => true,
                                'empty' => '-- Pilih --',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            )
                        );
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="AKJurnaldetailT_pegawai_id" class="control-label">Operator</label>
                    <div class="controls">
                        <?php
                        $drop = PegawairuanganV::model()->getDropPegawaiTambah(Yii::app()->user->getState('ruangan_id'), array('OTOMATIS' => 'OTOMATIS'));
                        echo $form->dropDownList(
                            $model,
                            'pegawai_id',
                            $drop,
                            array(
                                'class' => 'span4',
                                'inline' => true,
                                'empty' => '-- Pilih --',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            )
                        );
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="AKJurnaldetailT_kdrekening5" class="control-label">Kode Akun</label>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'kdrekening5', array('placeholder' => 'Kode Akun', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="AKJurnaldetailT_nmrekening5" class="control-label">Nama Akun</label>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'nmrekening5', array('placeholder' => 'Nama Akun', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="AKJurnaldetailT_noreferensi" class="control-label">No. Referensi</label>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'noreferensi', array('placeholder' => 'No. Referensi', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeCheckBox($model, 'ceklisAktif'); ?> <label for="AKInformasijurnaltransaksiV_ceklisAktif">Kode Akun Kosong</label>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
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
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php
$this->endWidget();
?>