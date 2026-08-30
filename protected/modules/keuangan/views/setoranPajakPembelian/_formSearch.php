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
                    <?php echo CHtml::label("Tgl. Faktur <span class='required'>*</span>", 'tglfaktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tgl_awal = date('Y-m-d');
                        $model->tgl_akhir = date('Y-m-d');
                        ?>
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo CHtml::activeHiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo CHtml::activeHiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                    <!--<div class="controls">
                        <?php // echo CHtml::textField('tglfaktur','', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                        ?><i class="entypo-calendar"></i>
                    </div>-->
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("No Faktur", 'nofaktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('nofaktur', '', array('placeholder' => 'No Faktur', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Pajak <span class='required'>*</span>", 'jenis_pajak', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('jenis_pajak', '', CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = false'), 'pajak_id', 'pajak_nama'), array('empty' => '--Pilih Jenis Pajak--', 'class' => 'span4', 'onchange' => 'changeJenisPajak(this);')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'loadDataFaktur();')
            ); ?>
        </div>
    </div>
</div>