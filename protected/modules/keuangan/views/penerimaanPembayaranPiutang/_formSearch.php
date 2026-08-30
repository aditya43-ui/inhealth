<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penerimaanpembayaranpiutang-src-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
)); ?>
<div class="panel panel-success" id="panelSearchForm">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pembayaran <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
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
                </div>
                <div class="control-group">
                    <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . "<label for='KUPembpiutangbankT_ceklis'>Tgl. Jatuh Tempo</label>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tgljthtempo_awal = date('Y-m-d');
                        $model->tgljthtempo_akhir = date('Y-m-d');
                        ?>
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgljthtempo_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgljthtempo_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgljthtempo_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgljthtempo_akhir)) ?></span>
                            <?php echo CHtml::activeHiddenField($model, 'tgljthtempo_awal', array('class' => 'start')) ?>
                            <?php echo CHtml::activeHiddenField($model, 'tgljthtempo_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("No. Pembayaran", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'nopembayaran_srch', array('placeholder' => 'No. Pembayaran', 'class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Pembayaran <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $criteria = new CDbCriteria();
                        $criteria->select = "t.jnspembayar_id, t.jnspembayar_nama, jnsbank.bank_id";
                        $criteria->join = "LEFT JOIN Jnspembayarbank_m jnsbank ON jnsbank.jnspembayar_id = t.jnspembayar_id";
                        $criteria->addCondition('t.jnspembayar_aktif = TRUE');
                        $criteria->order = "t.jnspembayar_nama ASC";
                        $jnspembayar_data = JnspembayarM::model()->findAll($criteria);
                        $list_jnspembayar = CHtml::listData($jnspembayar_data, 'jnspembayar_id', 'jnspembayar_nama');
                        $option_jnspembayar = array();
                        foreach ($jnspembayar_data as $item) {
                            $option_jnspembayar[$item->jnspembayar_id] = array(
                                'data-bankpenerima' => $item->bank_id,
                            );
                        }
                        ?>
                        <?php echo CHtml::activeDropDownList($model, 'jenispembayaran_id', $list_jnspembayar, array(
                            'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setJnsPembayar()', 'options' => $option_jnspembayar
                        )); ?>
                    </div>
                </div>
                <div class="control-group" id="bankDiv" style="display:none;">
                    <?php echo CHtml::label("Bank  <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($model, 'bank_id', CHtml::listData(BankM::model()->findAll("bank_aktif = TRUE and ispenerimaan = TRUE ORDER BY bank_id ASC "), 'bank_id', 'namabank'), array(
                            'class' => 'span3', 'empty' => '-- Pilih --'
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'loadDataPemabayaran();')
            ); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>