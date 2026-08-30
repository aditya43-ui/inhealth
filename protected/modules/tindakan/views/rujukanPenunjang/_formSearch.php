<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'search-penunjangrujukan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#noPendaftaran',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));

        Yii::app()->clientScript->registerScript('search', "
            $('#search-penunjangrujukan-form').submit(function(){
                $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
                    data: $(this).serialize()
                });
                return false;
            });
        ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
            <?php $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " <label for='PasienkirimkeunitlainV_ceklis'>Tanggal Masuk</label>", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklisJadwal') . "Tgl. Rencana Tindakan", 'tgl_jadwalpemeriksaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_jadwalpemeriksaanawal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_jadwalpemeriksaanakhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_jadwalpemeriksaanawal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_jadwalpemeriksaanakhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_jadwalpemeriksaanawal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_jadwalpemeriksaanakhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', '', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php /* echo $form->dropDownListRow($model,'instalasi_id', $instalasiAsals, 
                    array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                    'ajax'=>array('type'=>'POST',
                    'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                    'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
                ))); */ ?>
                <?php
                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_id in (2, 4, 79, 38, 14, 85, 100, 3) order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control span4', 'empty' => '-- Pilih --',
                    'ajax'=>array(
						'type'=>'POST',
						'url'=>$this->createUrl('SetDropDownRuangan',array('encode'=>false,'model_nama'=>'PasienkirimkeunitlainV')),
						'update'=>'#'.CHtml::activeId($model, 'ruangan_id'),
						)));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('instalasi_id in (2, 4, 79, 38, 14, 85, 100, 3) and ruangan_aktif is true order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array(
                    'class' => 'form-control span4', 'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>


        
     </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label for="noPendaftaran" class="control-label">No. Pendaftaran</label>
                    <div class="controls">
                        <input type="text" placeholder="No. Pendaftaran" value="" maxlength="20" id="noPendaftaran" name="noPendaftaran" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                    </div>
                </div>
                <div class="control-group">
                    <label for="noRekamMedik" class="control-label">No. Rekam Medik</label>
                    <div class="controls">
                        <input type="text" placeholder="No. Rekam Medik" value="" maxlength="10" id="noRekamMedik" name="noRekamMedik" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">Nama Pasien</label>
                    <div class="controls">
                        <input type="text" placeholder="Ketik Nama Pasien" value="" maxlength="50" id="namaPasien" name="namaPasien" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">NIK</label>
                    <div class="controls">
                        <input type="text" placeholder="NIK" value="" maxlength="50" id="pasien_id" name="pasien_id" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                    </div>
                </div>

            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'name' => 'submitSearch')
            ); ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>

        </div>

        <?php $this->endWidget(); ?>
        <script type="text/javascript">
          function cekTanggal() {
        var checklist = $('#PasienkirimkeunitlainV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('PasienkirimkeunitlainV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('PasienkirimkeunitlainV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('PasienkirimkeunitlainV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('PasienkirimkeunitlainV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
        </script>
    </div>
</div>