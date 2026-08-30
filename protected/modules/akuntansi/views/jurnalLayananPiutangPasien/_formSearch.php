<div class="form-horizontal">
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
                        <?php echo CHtml::label("Tgl. Pelayanan <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $model->tgl_awal = date('Y-m-d');
                            $model->tgl_akhir = date('Y-m-d');
                            ?>
                            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo CHtml::hiddenField('tgl_awal', $model->tgl_awal, array('class' => 'start')) ?>
                                <?php echo CHtml::hiddenField('tgl_akhir', $model->tgl_akhir, array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Instalasi", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::dropDownList('instalasi_id', '', CHtml::listData(InstalasiM::model()->findAll(array('condition' => 'instalasi_aktif = true and (ispelayanan = true or ispenunjangmedis = true)', 'order' => 'instalasi_nama ASC')), 'instalasi_id', 'instalasi_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Ruangan", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::dropDownList('ruangan_id', '', array(), array('class' => 'form-control', 'multiple' => 'multiple')) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("No. Pendaftaran", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::textField('nopendaftaran', '', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("No. Rekam Medik", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::textField('norekam_medik', '', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4')); ?>
                        </div>
                    </div>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'id' => 'tglhidden',
                        'name' => 'tglhidden',
                        'mode' => 'datetime',
                        'options' => array(
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'style' => 'width:140px; display: none;', 'placeholder' => '00/00/0000 00:00:00', 'class' => 'span2 dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'loadDataJurnal();')
                ); ?>
            </div>
        </div>
    </div>
</div>