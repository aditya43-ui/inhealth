<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'searchLaporan',
    'type' => 'horizontal',
)); ?>
<style>
    #penjamin label.checkbox {
        width: 350px;
        display: inline-block;
    }

    label.checkbox {
        width: 200px;
        display: inline-block;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <?php $format = new MyFormatter(); ?>
        <?php echo CHtml::hiddenField('type', ''); ?>
        <?php echo $form->hiddenField($model, 'filter', array('readonly' => 'TRUE')); ?>
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
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Supplier', 'instalasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'supplier_id', CHtml::listData(SupplierM::model()->findAll("supplier_aktif = TRUE AND supplier_jenis IN ('" . Params::SUPPLIER_JENIS_GIZI . "','" . Params::SUPPLIER_JENIS_UMUM . "') ORDER BY supplier_nama ASC"), 'supplier_id', 'supplier_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )); ?>
            </div>
        </div>
        <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'big',							
	//                                    'disabled'=>true,
								'content'=>array(
									'content12'=>array(
										'multi' => 'multi',
										'header'=>'Berdasarkan Supplier',
										'isi'=>'',
	//                                                       
										'active'=>true,
										),   ),
	//                                    'htmlOptions'=>array('class'=>'aw',)
						));*/ ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Status Bayar', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statusBayar', array(1 => 'Lunas', 2 => 'Belum Lunas'), array('empty' => '-- Pilih --', 'style' => 'width:130px;')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array(
            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    //                $content = $this->renderPartial('../tips/informasi',array(),true);
    //                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        checkSemua();
        $("#kunjungan").on("hide.bs.collapse", function() {
            $("#KUInformasifakturumumV_filter").val("");
        });
        $("#kunjungan").on("show.bs.collapse", function() {
            $("#KUInformasifakturumumV_filter").val("supplier");
        });
    });

    function checkSemua() {
        if ($("#checkSemuaid").is(":checked")) {
            $('.penjamin input[name*="KUInformasifakturumumV"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('.penjamin input[name*="KUInformasifakturumumV"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
        //setAll();
    }
</script>
<?php $this->renderPartial('billingKasir.views.laporan._jsFunctions', array('model' => $model)); ?>