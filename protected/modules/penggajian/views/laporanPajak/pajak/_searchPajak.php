<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporanPajak',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <style>
        table {
            margin-bottom: 0;
        }

        .form-actions {
            padding: 4px;
            margin-top: 5px;
        }

        #ruangan label {
            width: 120px;
            display: inline-block;
        }

        .nav-tabs>li>a {
            display: block;
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Tgl. Penggajian", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <!--					<div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php // echo date('d F Y', strtotime($model->tgl_awal)) 
                                                                                                                                                                ?>" data-end-date="<?php // echo date('d F Y', strtotime($model->tgl_akhir)) 
                                                                                                                                                                                    ?>">
						<i class="entypo-calendar"></i>
						<span ><?php // echo date('d F Y', strtotime($model->tgl_awal)) 
                                ?> - <?php // echo date('d F Y', strtotime($model->tgl_akhir)) 
                                        ?></span>
						<?php // echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) 
                        ?>
						<?php // echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) 
                        ?>
					</div>-->
                    <?php
                    $model->tglpenggajian = (isset($model->tglpenggajian) ? MyFormatter::formatDateTimeForUser($model->tglpenggajian) : date('Y m d'));
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglpenggajian',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            //                                                        'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'class' => 'span2 dtPicker2-5 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    $model->tglpenggajian = $format->formatDateTimeForDb($model->tglpenggajian);
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('placeholder' => 'No. Induk Pegawai', 'class' => 'span3', 'maxlength' => 100)); ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'kategoripegawai', array('disabled' => 'disabled')) .
                '<div class="control-group">
                ' . CHtml::label('Kategori Pegawai', 'kategoripegawai', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'kategoripegawai', LookupM::getItems('kategoripegawai'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                </div>
            </div>';

            echo CHtml::hiddenField('filter', 'unit_perusahaan', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Unit Perusahaan', 'unit_perusahaan', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'unit_perusahaan', LookupM::getItems('unit_perusahaan'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>';
            ?>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'katpeg',
                'slide' => true,
                'content' => array(
                    'content2' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Kategori Pegawai',
                        'isi' => CHtml::hiddenField('filter', 'kategoripegawai', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                                    ' . CHtml::label('Kategori Pegawai', 'kategoripegawai', array('class' => 'control-label')) . ' 
                                    <div class="controls">
                                        ' . $form->dropDownList($model, 'kategoripegawai', LookupM::getItems('kategoripegawai'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                                    </div>
                                </div>',
                        'active' => true,
                    ),
                ),
            ));
            ?>
            <?php //echo $form->dropdownListRow($model,'kategoripegawai', LookupM::getItems('kategoripegawai'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); 
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'unitper',
                'slide' => true,
                'content' => array(
                    'content2' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Unit Perusahaan',
                        'isi' => CHtml::hiddenField('filter', 'unit_perusahaan', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                                    ' . CHtml::label('Unit Perusahaan', 'unit_perusahaan', array('class' => 'control-label')) . ' 
                                    <div class="controls">
                                        ' . $form->dropDownList($model, 'unit_perusahaan', LookupM::getItems('unit_perusahaan'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                                    </div>
                                </div>',
                        'active' => true,
                    ),
                ),
            ));
            ?>
            <?php //echo $form->dropdownListRow($model,'unit_perusahaan', LookupM::getItems('unit_perusahaan'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); 
            ?>
        </div>
    </div>-->
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        ); ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>