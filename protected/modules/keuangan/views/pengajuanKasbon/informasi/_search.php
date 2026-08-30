<?php
/**
* - digunakan sebagai informasi sampel darah
* @author Aida Rahmawati <aidarahmawati@.com>
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
//    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'informasi-pengajuankasbon-r-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Sterilisasi",'tglterimakantong', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Pengajuan",'sterilisasibj_nomor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_pengajuan',array('placeholder'=>'Ketik Nomor Pengajuan')) ?>
            </div>
        </div>        
    </div>
    <div class="col-sm-6">                
        <div class = "control-group">
            <?php echo Chtml::label("Unit Kerja",'unitkerja_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'),array('empty' => '-- Pilih --')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Status",'status_persetujuan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'status_persetujuan', Params::getListKasbon(),array('empty' => '-- Pilih --')) ?>
            </div>
        </div>       
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/informasi'), 
        array('class'=>'btn btn-danger',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) ;        
    ?>
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
