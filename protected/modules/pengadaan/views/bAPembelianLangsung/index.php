<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'bapemnelianlangsung-m-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus'=>'#',
)); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <strong>Berita Acara Pembelian Langsung</strong></div>
    </div>
    <div class="panel-body">
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Data Berita Acara Pembelian Langsung</span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPembelianLangsung', array('model' => $model, 'modSPK' => $modSPK, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Data Lampiran</span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formLampiran', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian, 'form' => $form)); ?>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                 if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                }
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl($this->id.'/index', array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)), array('class'=>'btn btn-danger', 'onclick'=>'return refreshForm(this);'));
                echo "&nbsp;";

                if (empty($model->bapembelianlangsung_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    echo "&nbsp;";
                }
                ?>
            </div>
        </div>
        
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    function print(){
        window.open('<?php echo $this->createUrl('print',array('id'=>$model->bapembelianlangsung_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
    $(document).ready(function(){
        $('.integer-decimal').each(function(){
           $(this).val(formatThousandDecimal(parseFloat($(this).val())));
       });
        <?php if(isset($_GET['sukses'])){ ?>
            $('input').attr('readonly', true);
            $('.add-on').hide();
        <?php } ?>
    });

    document.getElementById("ADBapembelianlangsungT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#ADBapembelianlangsungT_dokumen_pendukung").attr("src", "blank");
            $('#ADBapembelianlangsungT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#ADBapembelianlangsungT_dokumen_pendukung').unwrap();
            return false;
        }
    };
</script>