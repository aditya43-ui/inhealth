<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fileupload/fileupload.js'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kppengangkatantphl-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form->errorSummary($model); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<div class="row">
    <fieldset class="box">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataPegawai', array('model' => $modPegawai, 'form' => $form)); ?>
            </div>
        </div>
    </fieldset>
    <fieldset class="box">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengangkatan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataPengangkatan', array('model' => $model, 'form' => $form)); ?>
            </div>
        </div>
    </fieldset>
    <div class="form-actions">
        <?php if ($model->isNewRecord) { ?>
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
        <?php } else { ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-info', 'onKeypress' => 'print("PRINT");', 'onclick' => 'print("PRINT");')); ?>
        <?php } ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/create'),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('../tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'create', 'content' => $content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$urlPrint = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/print&id=' . $model->pengangkatantphl_id);
$js = <<< JS

function caraAmbilPhotoJS(obj)
{
    caraAmbilPhoto=obj.value;
    
    if(caraAmbilPhoto=='webCam')
        {
          $('#divCaraAmbilPhotoWebCam').slideToggle(500);
          $('#divCaraAmbilPhotoFile').slideToggle(500);
            
        }
    else
        {
         $('#divCaraAmbilPhotoWebCam').slideToggle(500);
          $('#divCaraAmbilPhotoFile').slideToggle(500);
        }
} 

function simpanDataPegawai()
{
    var caraAmbilPhoto = $('#caraAmbilPhoto');
     if(caraAmbilPhoto=='webCam')
        {
          $('#upload').click();  
          do_upload();
          $('#sapegawai-m-form').submit();           
        }
     else
        {
          $('#sapegawai-m-form').submit();           
        }
}    
function print(string){
    window.open("${urlPrint}&caraPrint=PRINT","",'location=_new, width=900px');
}
JS;
Yii::app()->clientScript->registerScript('caraAmbilPhoto212', $js, CClientScript::POS_BEGIN);
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new KPPegawaiM('search');
$modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['KPPegawaiM']))
    $modPegawai->attributes = $_GET['KPPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',

        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' =>  LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                        $(\'#' . Chtml::activeId($model, 'pimpinannama') . '\').val(\'$data->nama_pegawai\');
                                        $(\'#dialogPegawaiMengetahui\').dialog(\'close\');
                                        return false;"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>
    function konfirmasi() {
        location.reload();
    }
</script>