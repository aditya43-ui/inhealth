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
    <div class="col-sm-6">
        <?php $format = new MyFormatter(); ?>
        <?php echo CHtml::hiddenField('type', ''); ?>
        <div class="control-group">
            <?php // echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); 
            ?>
            <?php // echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); 
            ?>
            <?php // echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); 
            ?>
            <?php // echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); 
            ?>
            <?php // echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); 
            ?>
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
</div>
<div class="row">
    <div class="col-sm-6">
        <?php // $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        //                'id'=>'big',							
        ////                                    'disabled'=>true,
        //                'content'=>array(
        //                    'content12'=>array(
        //                        'multi' => 'multi',
        //                        'header'=>'Berdasarkan Jenis Rekonsiliasi Bank',
        //                        'isi'=>
        //                            '<div class="control-group">
        //                                '.Chtml::hiddenField('filter', 'jenisrekonsiliasibank', array('readonly'=>'TRUE')).'
        //                                '.CHtml::label('Jenis','jenisrekonsiliasibank_id', array('class' => 'control-label')).' 
        //                                <div class="controls">
        //                                    '.$form->dropDownList($model,'jenisrekonsiliasibank_id',CHtml::listData(AKJenisrekonsiliasibankM::model()->findAll("jenisrekonsiliasibank_aktif = TRUE ORDER BY jenisrekonsiliasibank_nama ASC"), 'jenisrekonsiliasibank_id', 'jenisrekonsiliasibank_nama'),array(
        //                                    'class'=>'form-control', 'multiple'=>'multiple')).'											
        //                                </div>
        //                            </div>',
        ////                                                       
        //                        'active'=>true,
        //                        ),   ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
        //            )); 
        ?>
    </div>
    <div class="col-sm-6">
        <?php // $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        //            'id'=>'big2',							
        //		//                                    'disabled'=>true,
        //            'content'=>array(
        //                'content1'=>array(
        //                    'multi' => 'multi',
        //                    'header'=>'Berdasarkan Bank',
        //                    'isi'=>
        //                        '<div class="control-group">
        //                            '.Chtml::hiddenField('filter', 'bank', array('readonly'=>'TRUE')).'
        //                            '.CHtml::label('Bank','jenisrekonsiliasibank_id', array('class' => 'control-label')).' 
        //                            <div class="controls">
        //                                '.$form->dropDownList($model,'bank_id',CHtml::listData(AKBankM::model()->findAll("bank_aktif = TRUE ORDER BY namabank ASC"), 'bank_id', 'namabank'),array(
        //                                'class'=>'form-control', 'multiple'=>'multiple')).'											
        //                            </div>
        //                        </div>',
        ////                                                       
        //                    'active'=>true,
        //                ),   
        //            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
        //        )); 
        ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    //	echo $this->renderPartial('akuntansi.views.laporanAkuntansi/_tombolPrinout',true);
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        checkSemua();
        checkSemuaBank()
    });

    function checkSemua() {
        if ($("#checkSemuaid").is(":checked")) {
            $('.penjamin input[name*="AKLaporanrekonsiliasibankV"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('.penjamin input[name*="AKLaporanrekonsiliasibankV"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
        //setAll();
    }

    function checkSemuaBank() {
        if ($("#checkSemuaBankId").is(":checked")) {
            $('.bank input[name*="AKLaporanrekonsiliasibankV"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('.bank input[name*="AKLaporanrekonsiliasibankV"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
        //setAll();
    }
</script>
<?php $this->renderPartial('billingKasir.views.laporan._jsFunctions', array('model' => $model)); ?>