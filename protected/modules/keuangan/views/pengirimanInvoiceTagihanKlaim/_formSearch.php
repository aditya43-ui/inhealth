<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kiriminvoiceklaim-src-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
)); ?>
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
                    <?php echo CHtml::label("Tgl. Pengajuan Klaim <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tgl_awal = date('Y-m-d');
                        $model->tgl_akhir = date('Y-m-d');
                        ?>
                        <div class="daterange daterange-inline input-inline" style="width: 300px !important;" data-format="D MMMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo CHtml::activeHiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo CHtml::activeHiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("No. Invoice", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'noinvoice', array('placeholder' => 'No. Pembayaran', 'class' => 'span3')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Penjamin <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        
                    <?php 
                    echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true order by carabayar_nama ASC'), 'carabayar_id', 'carabayar_nama'), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                        ),
                    ));
					?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Penjamin <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList(
                            $model,
                            'penjamin_id',
                            CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true order by penjamin_nama asc'), 'penjamin_id', 'penjamin_nama'),
                            array('class' => 'span3','empty' => '-- Pilih --')
                        ); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'loadDataPencarian();')
            ); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>