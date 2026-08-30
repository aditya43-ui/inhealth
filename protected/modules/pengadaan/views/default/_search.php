<?php
/**
 * Filtering by date
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @category New Feature RSST-8627
 * 
 */
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'beranda-r-search',
        'type' => 'horizontal',
    ));
    $format = new MyFormatter();
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Periode</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="control-group">
                    <label class="col-sm-4">Periode</label>
                    <div class="col-sm-7">
                        <?= $form->dropDownList($model,'periodeanggaran_id',  $periode, ['empty'=>'-- Pilih --', 'onChange' => 'setIndikator(this);', 'class' => 'span4', ]) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="col-sm-4">Sumber Biaya</label>
                    <div class="col-sm-7">
                        <?php echo $form->dropDownList($model, 'sumberbiaya', LookupM::getItems('sumberbiaya'), array('empty'=>'-- Pilih --', 'onchange' => 'setIndikator(this);', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>									
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <label class="col-sm-4">Kuasa Pengguna Anggaran</label>
                    <div class="col-sm-6">
                        <?= $form->dropDownList($model,'pegawaikpa_id',  $pejabat['kpa'], ['empty'=>'-- Pilih --', 'onChange' => 'setIndikator(this);', 'class' => 'span4', ]) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="col-sm-4">Pejabat Pembuat Komitmen</label>
                    <div class="col-sm-6">
                        <?= $form->dropDownList($model,'pejabatpengadaan_id',  $pejabat['ppk'], ['empty'=>'-- Pilih --', 'onChange' => 'setIndikator(this);', 'class' => 'span4', ]) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="col-sm-4">Pejabat Pelaksana Teknis Kegiatan</label>
                    <div class="col-sm-6">
                        <?= $form->dropDownList($model,'pptk_id',  $pejabat['pptk'], ['empty'=>'-- Pilih --', 'onChange' => 'setIndikator(this);', 'class' => 'span4', ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>