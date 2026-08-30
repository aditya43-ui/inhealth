<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                    <label for="namaPasien" class="control-label">Tanggal Penjualan</label>
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
                    <label for="BKPenjualanresepT_noresep" class="control-label">No. Resep / Struk</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'noresep', array('placeholder' => 'No. Resep / Struk', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="BKPenjualanresepT_noresep" class="control-label">NIK</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'no_identitas_pasien', array('placeholder' => 'No. Identitas Pasien', 'class' => 'span4')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php //echo $form->textFieldRow($model,'noresep',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                ?>
                <div class="control-group">
                    <label for="BKPenjualanresepT_noresep" class="control-label">Nama Pasien</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4')); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'), array(
                    'empty' => '-- Pilih --', 'class' => 'span4',
                )); ?>
                <div class="control-group">
            <?php $model->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " <label for='RIInfopasienmasukkamarV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awall',
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
            <?php $model->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhirl',
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
            </div>
        </div>