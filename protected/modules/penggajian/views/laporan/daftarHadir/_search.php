<script type="text/javascript">
    function reseting()
    {
        setTimeout(function(){
            $.fn.yiiGridView.update('lapegawai-m-grid', {
                    data: $('#lapegawai-m-search').serialize()
            });
        },1000);

    }   
</script>
<br>
<fieldset class="box">
    
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'lapegawai-m-search',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($model,'nomorindukpegawai'),
        )
    );
    ?>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3','maxlength'=>30)); ?>
                <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>50)); ?>
                <?php
                    echo $form->dropDownListRow(
                        $model,'unit_perusahaan',LookupM::getItems('unit_perusahaan'),
                        array('class'=>'span3', 'empty'=>'-- Pilih --')
                    );
                ?>
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'jabatan_id',CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'),array('class'=>'span3','maxlength'=>50, 'empty'=>'-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('Laporan/LaporanPegawai'), array('class'=>'btn btn-danger'));
                 
         ?>
    </div>
    <?php $this->endWidget(); ?>
</fieldset>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#lapegawai-m-search').submit(function(){
    $.fn.yiiGridView.update('lapegawai-m-grid', {
            data: $(this).serialize()
    });
    return false;
});
");
?>