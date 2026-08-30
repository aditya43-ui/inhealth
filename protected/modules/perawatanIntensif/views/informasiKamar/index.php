<?php /*
<div class="white-container">
    <legend class="rim2">Informasi <b>Kamar</legend>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'informasiKamar-t-form',
            'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                'focus'=>'#',
        )); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td width="30%">
                     <?php echo $form->dropDownListRow($modKamarRuangan,'kelaspelayanan_id',  CHtml::listData($modKamarRuangan->KelasPelayananRuanganItems, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',
                                                        'ajax'=>array('type'=>'POST',
                                                                  'url'=>$this->createUrl('GetRuanganNoKamarRuangan',array('encode'=>false,'namaModel'=>'RIKamarRuanganM')),
                                                                  'update'=>'#RIKamarRuanganM_kamarruangan_nokamar',),
                                                    )); ?>
                    <?php echo $form->dropDownListRow($modKamarRuangan,'kamarruangan_nokamar', array(),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </td>
                <td width="25%">
                    <fieldset class="box2">
                        <legend class="rim">Foto Ruangan <?php echo $modRuangan->ruangan_nama;?></legend>
                          <img src="<?php echo Params::urlRuanganTumbsDirectory().'kecil_'.$modRuangan->ruangan_image ?>" />
                    </fieldset>
                </td>
                <td>
                    <fieldset class="box2">
                        <legend class="rim">Fasilitas</legend>
                        <?php echo $modRuangan->ruangan_fasilitas ?>
                    </fieldset>
                </td> 
            </tr>
        </table>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-check"></i>')),
                                               array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan'));?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                array('class' => 'btn btn-default',
                                      'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
        <?php
        $content = $this->renderPartial('../tips/informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
        <?php echo $formKasur ?>
        <?php $this->endWidget(); ?>
    </fieldset>
</div>
<?php
$idKelasPelayanan=  CHtml::activeId($modKamarRuangan,'kelaspelayanan_id');
$idNoKamar=  CHtml::activeId($modKamarRuangan,'kamarruangan_nokamar');
$jscript = <<< JS
function cekValidasi()
{
    idKelas=$('#${idKelasPelayanan}').val();
    idKamar=$('#${idNoKamar}').val();
    if(idKelas==''){
        myAlert('Anda Belum Memilih Kelas Pelayanan');
    }else if(idKamar==''){
        myAlert('Anda Belum Memilih Kamar');
    }else{
        $('#btn_simpan').click();
    }
}
JS;
Yii::app()->clientScript->registerScript('faktur',$jscript, CClientScript::POS_HEAD);
*/
$this->breadcrumbs = array(
    'Informasi Kamar Perawatan Intensif'
);
?>
<style>
    .contentKamar,
    .bed {
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -o-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
    }

    .contentKamar {
        border: 1px solid black;
        margin: 10px;
    }

    .bed {
        display: inline-block;
        width: 13%;
        border-color: #ccc;
        margin: 10px;
    }

    .popover-inner {
        width: 100%;
    }

    .image_ruangan {
        height: 100px;
        width: 100px;
    }

    .pintu {
        background-image: url(images/pintu.png);
        width: 16px;
        height: 75px;
        margin-top: 80px;
        float: right;
        margin-right: -2px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kamar Perawatan Intensif</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', 'ruangan_nama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList(
                            'ruangan',
                            '',
                            CHtml::listData(
                                RuanganM::model()->findAllByAttributes(
                                    array(
                                        'instalasi_id' => Params::INSTALASI_ID_ICU,
                                        'ruangan_aktif' => true
                                    ),
                                    array('order' => 'ruangan_nama')
                                ),
                                'ruangan_id',
                                'ruangan_nama'
                            ),
                            array('empty' => '-- Pilih --', 'onchange' => 'getListRuangan();')
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="isi">
                    <?php echo $row; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$url = Yii::app()->createUrl($this->route);
Yii::app()->clientScript->registerScript('list', '
    function getListRuangan(){
        ruangan = $("#ruangan").val();
        $(".contentKamar").addClass("animation-loading");
        $.post("' . $url . '", {ajax:true,ruangan:ruangan},function(data){
            $(".isi").html(data);
            $(".contentKamar").removeClass("animation-loading");
            jQuery(\'a[rel="popover"]\').popover();
            jQuery(\'.poping\').popover({placement:"bottom"});
        },"json");
    }
',  CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScript('readyFunction', '
    jQuery(\'.poping\').popover({placement:"bottom"});
//    $(".bed").mousemove(function(e){
//        $(".popover").show();
//        tinggi = $(".popover").height()/2;
//        $(".popover").css("left",e.clientX);        
//        $(".popover").css("top",($(document).scrollTop())+e.clientY-tinggi);   
//    });
//    
   $(".bed").click(function(e){
        $(".popover").slideToggle();
    });
    ',  CClientScript::POS_READY); ?>