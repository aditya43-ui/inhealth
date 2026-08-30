<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pemeriksaan Kesejahteraan Janin</div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'kesejahteraan-janin-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        ));
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        
        <?php echo $this->renderPartial($this->path_view."form._denyutJantung", array(
            'form'=>$form, 'partograf'=>$partograf, 'jantung'=>$jantung
        ), true); ?>
        
        <?php echo $this->renderPartial($this->path_view."form._ketuban", array(
            'form'=>$form, 'partograf'=>$partograf, 'ketuban'=>$ketuban
        ), true); ?>
        
        
        
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

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Grafik Kesehatan Janin</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view."_grafik", array(
            'partograf'=>$partograf
        )); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat Pemeriksaan Denyut Jantung Janun (DJJ)</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view."_riwayatDenyut", array(
            'partograf'=>$partograf
        ), true); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat Ait Ketuban & Kenyusupan</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view."_riwayatAirKetuban", array(
            'partograf'=>$partograf
        ), true); ?>
    </div>
</div>


<script>
    
    
    function hapusDenyut(id) {
        myConfirm('Anda yakin untuk menghapus data ini ?', 'Peringatan', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('deleteDenyut'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('denyut-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    function hapusKetuban(id) {
        myConfirm('Anda yakin untuk menghapus data ini ?', 'Peringatan', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('deleteKetuban'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('ketuban-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    function cekPanelAktif() {
        $(".panel_monitor").each(function() {
            var ceklis = $(this).find(".cb_str").is(":checked");
            
            if (ceklis) {
                $(this).find(".panel-body").show().find(":input").attr("disabled", false);
            } else {
                $(this).find(".panel-body").hide().find(":input").attr("disabled", true);
            }
        });
    }
    
    
    $(document).ready(function() {
        $(".cb_str").on("click", cekPanelAktif);
        cekPanelAktif();
    });
    
</script>