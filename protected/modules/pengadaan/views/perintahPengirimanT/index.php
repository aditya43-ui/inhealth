<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.BootAlert');
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'perintahpengiriman-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),
	'focus'=>'#',
)); ?>
<div class="panel-group joined" id="accordion-uji">
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse" data-parent="#accordion-uji" href="#riwayat" aria-expanded="true" class="">
                    Riwayat Surat Perintah Pengiriman
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff; overflow: auto; max-height: 300px;">
                <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'form' => $form), true); ?>
            </div> 
        </div> 
    </div>
</div>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Surat Perintah Pengiriman </b> </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_form', array('model' => $model, 'form' => $form)); ?>
        <div class="row-fluid">
            <?php 
                $this->renderPartial('_formRincian', array('model' => $model, 'modRincianSPK' => $modRincianSPK, 'modelDetail' => $modelDetail, 'form' => $form));

                if (!empty($model->terminke)) {
                    if (!empty($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary',
                        'type' => 'button', 'disabled' => true));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('id' => 'btn_submit', 'class' => 'btn btn-primary', 'onclick' => 'cekForm(); return false;',
                        'type' => 'button'));
                }
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                }
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl('index&id='.$_GET['id']), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'return refreshForm(this);')); ?>
            <?php 
                $content = $this->renderPartial('pengadaan.views.tips/transaksi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
            <?php
                if (isset($_GET['perintahpengiriman_id'])) {
                    echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl($this->id . '/index', array('id' => $_GET['id'])), array('class' => 'btn btn-success'));
                }
                
            ?>
        </div>
    </div>
</div>

<?php 
$this->endWidget();
$urlGetRiwayat = $this->createUrl('GetRiwayat');
$persiapanpengadaan_id = $_GET['id'];
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
<script>
    function cekRiwayat(obj) {
            var persiapanpengadaan_id = <?php echo $persiapanpengadaan_id ?>;
            if (persiapanpengadaan_id !== "") {
                $.post("<?php echo $urlGetRiwayat ?>", {persiapanpengadaan_id: persiapanpengadaan_id, },
                        function (data) {
                            $("#tableRiwayat").children("tbody").append(data.tr);
                        }, "json");
            } else {
                myAlert("Silahkan pilih data Persiapan Pengadaan!");
            }
            return false;

        }
    $(document).ready(function () {
            cekRiwayat();
        });
    function print(){
        window.open('<?php echo $this->createUrl('print',array('id'=>$model->perintahpengiriman_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
</script>    

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog2',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Surat Perintah Pengiriman',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame2" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>