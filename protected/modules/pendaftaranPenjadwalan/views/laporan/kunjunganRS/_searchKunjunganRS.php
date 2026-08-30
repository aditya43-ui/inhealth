<div class="panel panel-success search-form">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'searchInfoKunjungan',
            'focus' => '#' . CHtml::activeId($model, 'instalasi_id'),
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
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
                    <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nama Pasien</label>
                    <div class="controls">
                        <?= $form->textField($model,'nama_pasien',[]) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No Rekam Medik</label>
                    <div class="controls">
                        <?= $form->textField($model,'no_rekam_medik',[]) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No Pendaftaran</label>
                    <div class="controls">
                        <?= $form->textField($model,'no_pendaftaran',[]) ?>
                    </div>
                </div>
                <?php echo CHtml::label('Tampilkan Grafik', 'tampil_grafik', array('class' => 'control-label')); ?>
                <?php echo $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $insDrop = new CDbCriteria();
                        $insDrop->addCondition(" instalasi_aktif = TRUE ");
                        $insDrop->addInCondition(" instalasi_id ", Params::getArrayInstalasiPelayanan());
                        $insDrop->order = " instalasi_nama ASC ";

                        echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($insDrop), 'instalasi_id', 'instalasi_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'ruangan_id',
                            array(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kelas Pelayanan', 'ruangan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'kelaspelayanan_id',
                            KelaspelayananM::getDropList(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Kasus Penyakit', 'ruangan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'jeniskasuspenyakit_id',
                            JeniskasuspenyakitM::getDropList(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Penjamin', 'ruangan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'carabayar_id',
                            LaporankunjunganrsV::getDropList(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
                
            </div>

        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
            );
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
        </div>
    </div>
</div>

<?php //$this->widget('UserTips', array('type' => 'create')); 
?>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
<script>
    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchInfoKunjungan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchInfoKunjungan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
    
    $(document).ready(function() {
           
        var kelas = jQuery('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>');	
        var kasuspenyakit = jQuery('#<?php echo CHtml::activeId($model, 'jeniskasuspenyakit_id') ?>');	
        jQuery(kelas).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();
        jQuery(kasuspenyakit).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  //$("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>