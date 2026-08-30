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
        <div class="control-group tanggal">		
            <?php echo CHtml::label(CHtml::radioButton('pilihTanggal', false,['uncheckValue'=>null,'value'=>'penerimaan','onclick'=>'setTanggal()','class'=>"pilihTanggal",'id'=>'pilihtanggal_penerimaan']).'<label for="pilihtanggal_penerimaan">Tanggal Penerimaan</label>','tglterimakantong', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        
        <div class="control-group tanggal">		
            <?php echo CHtml::label(CHtml::radioButton('pilihTanggal', true,['uncheckValue'=>null,'value'=>'pencucian','onclick'=>'setTanggal()','class'=>"pilihTanggal",'id'=>'pilihtanggal_pencucian']).'<label for="pilihtanggal_pencucian">Tanggal Pencucian</label>','tglterimakantong', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?= $form->textFieldRow($model,'nopenerimaan',['class'=>'span3','placeholder'=>'ketik nomor penerimaan']) ?>        
    </div>
    
    <div class="col-sm-6">
        <?= $form->textFieldRow($model,'nopencucian',['class'=>'span3','placeholder'=>'ketik nomor pencucian']) ?>
        <?= $form->textFieldRow($model,'namapengirim',['class'=>'span3','placeholder'=>'ketik nama pengirim']) ?>
        <?= $form->dropDownListRow($model,'mesinpencucian_nama',CHtml::listData(Yii::app()->db->createCommand(" SELECT mesinpencucian_id, mesinpencucian_nama FROM mesinpencucian_m WHERE mesinpencucian_aktif = TRUE ORDER BY mesinpencucian_nama ASC ")->queryAll(),'mesinpencucian_nama','mesinpencucian_nama'),['class'=>'span3','placeholder'=>'ketik mesin pencucian','empty'=>'-- Pilih --']) ?>        
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/indexPribadi'), 
        array('class'=>'btn btn-danger',
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

<script>
    
    const refInfo = () => {
        $.fn.yiiGridView.update('informasi-grid',{
           data: $("#informasisampel-r-search").serialize()
        });
    }
    
    var setTanggal = () => {
        const obj = $(".pilihTanggal:checked");
        
        $(".tanggal").find("input:not(:radio)").attr("disabled", true);
        
        $(obj).parents(".tanggal").find("input").removeAttr("disabled");
    }
    
    var batalPencucian = (id) => {
        myConfirm("Apakah Anda yakin akan mebatalkan data ini ?","Perhatian!", function(r){
            if (r){
                $.ajax({
                    type: 'POST',
                    url: '<?= $this->createUrl('batal') ?>',
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {                                    
                        if (data.sukses == 1){
                            toastr.success("Data berhasil dihapus","Perhatian!");
                            refInfo();
                        }else{
                            toastr.error("Data gagal dihapus","Perhatian!");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {                                    
                    }
                });
            }
        })
    }
    
    $(document).ready(function(){
        setTanggal();
    });
</script>