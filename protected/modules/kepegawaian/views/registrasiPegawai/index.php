<fieldset>    
    <legend class="rim2">Registrasi Pegawai</legend>
<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
?>
<?php
    echo CHtml::link(
        Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),
        '#',
        array(
            'class'=>'search-button btn',
            'rel'=>'tooltip', 'data-original-title'=>'Click untuk melakukan pencarian lebih lanjut',
        )
    );
?>
<div class="cari-lanjut search-form">
    <?php
        $this->renderPartial('_search',array(
            'model'=>$model,
        ));
    ?>
</div>    
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'kpregistrasipegawai-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)'
            ),
            'focus'=>'#',
        )
    );
    $urlSimpan = Yii::app()->createUrl($this->module->id.'/'.$this->id . '/simpanRegistrasi');
    Yii::app()->clientScript->registerScript('simpan_reg', "
        $('.search-button').click(function(){
            $('.search-form').slideToggle();
            return false;
        });
            
        $('#sapegawai-m-search').submit(function(){
            $.fn.yiiGridView.update('sapegawai-m-grid', {
                    data: $(this).serialize()
            });
            return false;
        });
            
        $('#kpregistrasipegawai-t-form').submit(function()
        {
            var idx = 0;
            $('#alatfinger_id').find('input[name$=\"alatfinger_id[]\"]').each(
                function(){
                    if($(this).is(':checked', true))
                    {
                        idx++;
                    }
                }
            );
            
            if(idx > 0)
            {
                $.post('${urlSimpan}',{data:$('#kpregistrasipegawai-t-form').serialize()}, function(data){
                    if(data.is_success == 1)
                    {
                        myAlert(data.pesan);
                        $.fn.yiiGridView.update('sapegawai-m-grid',{});
                    }
                }, 'json');
            }else{
                myAlert('Perangkat Finger belum dipilih');
            }
            return false;
        });
    ");
?>
    
<?php
    echo $this->renderPartial('_infoKoneksi',
        array()
    );
?>
<?php
    echo $this->renderPartial('_gridPegawai',
        array('model'=>$model)
    );
?>
<div class="form-actions">
    <?php 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('rel'=>'tooltip', 'data-original-title'=>'Click untuk menyimpan Registrasi','class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
    ?>
    <?php
        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id.'/'.$this->id), array('rel'=>'tooltip', 'data-original-title'=>'Click untuk membatalkan Registrasi', 'class' => 'btn btn-default','onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
    ?>
</div>
<?php $this->endWidget(); ?>
</fieldset>