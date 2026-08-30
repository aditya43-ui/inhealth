<?php
/**
* - digunakan sebagai informasi sampel darah
* @author Aida Rahmawati <aidarahmawati@example.com>
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
//    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'informasisampel-r-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>

<div class="row-fluid">
    <div class="col-sm-6">                
        <div class="control-group">            
            <?php echo CHtml::label("Tanggal Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        
        <?= $form->dropDownListRow($model, 'caramasuk_id', CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true order by caramasuk_nama ASC'), 'caramasuk_id', 'caramasuk_nama'), array(
                    'class' => 'form-control caramasuk_id', 'multiple' => 'multiple'
        )); ?>
    </div>
    
    <div class="col-sm-6">
        <?= 
            $form->dropDownListRow($model, 'kondisikeluar_id', CHtml::listData(KondisiKeluarM::model()->findAll(" kondisikeluar_aktif = TRUE AND carakeluar_id = '" . Params::CARAKELUAR_ID_MENINGGAL . "' ORDER BY kondisikeluar_nama ASC"), 'kondisikeluar_id', 'kondisikeluar_nama'), array(
                'class' => 'form-control kondisikeluar_id', 'multiple' => 'multiple'
            )); 
        ?>
        <?= $form->textFieldRow($model, 'no_rekam_medik') ?>
        <?= $form->textFieldRow($model, 'nama_pasien') ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/indexPribadi'), 
        array('class'=>'btn btn-default',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>   
    <?php
        $tips = array(
            '0' => 'tanggal',
            '1' => 'cari',
            '2' => 'ulang'
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">   
    $(document).ready(function(){
        $(".caramasuk_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        $(".kondisikeluar_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide(); 
    });    
</script>
