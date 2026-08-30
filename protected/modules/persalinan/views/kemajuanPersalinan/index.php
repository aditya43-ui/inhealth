<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pemeriksaan Kemajuan Persalinan</div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'kemajuan-persalinan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        ));
        $this->widget('bootstrap.widgets.BootAlert');
        
        ?>
        
        <?php echo $this->renderPartial($this->path_view."form._serviks", array(
            'form'=>$form, 'pertograf'=>$partograf, 'jalanlahir'=>$jalanlahir
        )); ?>
        
        <?php echo $this->renderPartial($this->path_view."form._kontraksi", array(
            'form'=>$form, 'pertograf'=>$partograf, 'kontraksi'=>$kontraksi
        )); ?>
        
        
        
        <div class="row-fluid">
        <div class="form-actions">
                <?php
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); //RND-8620
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                            $this->createUrl($this->id.'/index&pendaftaran_id='.$_GET['pendaftaran_id']),
                            array('class'=>'btn btn-danger',
                                'onclick'=>'return refreshForm(this);'));
                        $content = $this->renderPartial('../tips/informasi',array(),true);

                ?>
                <?php // $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));?>
        </div>
        </div>
        
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php echo $this->renderPartial($this->path_view."_grafik", array(
    'partograf'=>$partograf, 'kontraksi'=>$kontraksi, 'jalanlahir'=>$jalanlahir
)); ?>
<?php echo $this->renderPartial($this->path_view."table._serviks", array(
    'partograf'=>$partograf
), true); ?>
<?php echo $this->renderPartial($this->path_view."table._kontraksi", array(
    'partograf'=>$partograf
), true); ?>

<script>
    
    function cekPanelAktif() {
        $(".panel_monitor").each(function() {
            var ceklis = $(this).find(".cb_monitor").is(":checked");
            
            if (ceklis) {
                $(this).find(".panel-body").show().find(":input").attr("disabled", false);
            } else {
                $(this).find(".panel-body").hide().find(":input").attr("disabled", true);
            }
        });
    }
    
    function hapusServiks(id) {
        myConfirm('Anda yakin untuk menghapus data ini ?', 'Peringatan', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('deleteServiks'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('jalan-lahir-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    function hapusKontraksi(id) {
        myConfirm('Anda yakin untuk menghapus data ini ?', 'Peringatan', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('deleteKontraksi'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('kontraksi-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    $(document).ready(function() {
        $(".cb_monitor").on("click", cekPanelAktif);
        cekPanelAktif();
    });
    
</script>