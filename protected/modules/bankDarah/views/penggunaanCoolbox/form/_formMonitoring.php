<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Monitoring Suhu Coolbox</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Jam Monitoring', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jam_monitoring',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kosong Tanpa Listrik', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'suhu_kosongtanpalistrik', array('class' => 'span3 angkacoma-only setkosong')); ?> ℃
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kosong Dengan Listrik', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'suhu_kosongdenganlistrik', array('class' => 'span3 angkacoma-only setkosong')); ?> ℃
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Listrik dan Ice Pack', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'suhu_listrikdanicepack', array('class' => 'span3 angkacoma-only setkosong')); ?> ℃
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'keterangan', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Petugas', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
                        $cekPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                        if (!empty($cekPegawai)) {
                            $model->pegawai_nama = $cekPegawai->namaLengkap;
                        } else {
                            $model->pegawai_nama = '';
                        }
                        ?>
                        <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->textField($model, 'pegawai_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')) :
                                    Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'cekForm(); return false;'));
    echo '&nbsp;' . CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;')) . "&nbsp;";
    echo "&nbsp;";

    $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    echo '&nbsp;';
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>
</div>
<script>
    function cekSimpan() {
        var a = unformatNumber($("#PenggunaanCoolboxT_suhu_kosongtanpalistrik").val());
        var b = unformatNumber($("#PenggunaanCoolboxT_suhu_kosongdenganlistrik").val());
        var c = unformatNumber($("#PenggunaanCoolboxT_suhu_listrikdanicepack").val());
        
        $("#PenggunaanCoolboxT_suhu_kosongtanpalistrik").val(a);
        $("#PenggunaanCoolboxT_suhu_kosongdenganlistrik").val(b);
        $("#PenggunaanCoolboxT_suhu_listrikdanicepack").val(c);
        
        $("#penggunaancoolbox-t-form").submit();
    }
</script>