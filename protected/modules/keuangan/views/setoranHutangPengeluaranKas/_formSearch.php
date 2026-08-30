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
                    <?php echo CHtml::label("Tgl. Pengeluaran <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
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
                    <?php echo CHtml::label("Jenis Pengeluaran", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList(
                            $model,
                            'jenispengeluaran_id',
                            CHtml::listData(JenispengeluaranM::model()->findAll('jenispengeluaran_aktif = true ORDER BY jenispengeluaran_nama'), 'jenispengeluaran_id', 'jenispengeluaran_nama'),
                            array('class' => 'span3', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Pajak", 'jenis_pajak', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('jenis_pajak', '', CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND isppnkeluaran = false'), 'pajak_id', 'pajak_nama'), array('empty' => '--Pilih Jenis Pajak--', 'class' => 'span3', 'onchange' => 'changeJenisPajak(this);')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'loadDataFaktur();')
            ); ?>
        </div>
    </div>
</div>