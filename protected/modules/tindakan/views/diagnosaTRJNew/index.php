<style>
    .sorot {
        background-color: yellow !important;
    }
    body {
        overflow-x: visible; 
        min-height: 650px;
    }
</style>

<script type="text/javascript">
    var id_diagnosax = new Array();
</script>
<div class="row">
    <div class="col-sm-12">
        <?php
        // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-penjualanresep',
            'content' => array(
                'content-list-penjualanresep' => array(
                    'header' => '<b>Riwayat Diagnosa</b>',
                    'isi' => $this->renderPartial($this->path_view . "_gridRiwayatDiagnosa", array(
                        'modDiagnosa'=>$modDiagnosa,
                        'model'=>$model,
                        'modPendaftaran'=>$modPendaftaran, 
                        'modUraian'=>$modUraian,
                        'path_view'=>$path_view,
                        'modAdmisi' =>$modAdmisi,
                        'modRiwayat' => $modRiwayat
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        // }
        ?>
    </div>
</div>
<?php
$this->breadcrumbs=array(
	'Verifikasi Diagnosis',
);
//$this->renderPartial($path_view . '_formDataPasien',array('modPendaftaran'=>$modPendaftaran));

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'id'=>'uraian-diagnosax-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
        'focus'=>'#',
    )
);
$this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial($path_view . '_gridDiagnosaICDX',
    array(
        'form' => $form, 
        'modDiagnosa'=>$modDiagnosa,
        'model'=>$model,
        'modPendaftaran'=>$modPendaftaran, 
        'modUraian'=>$modUraian,
        'path_view'=>$path_view,
        'modAdmisi' =>$modAdmisi,
    )
);
?>
<br>
<?php
$this->renderPartial($path_view . '_gridDiagnosaICDIX',
    array(
        'form' => $form, 
        'modDiagnosaix'=>$modDiagnosaix,
        'model'=>$model_ix,
        'modPendaftaran'=>$modPendaftaran, 
        'modUraian'=>$modUraianIx,
        'path_view'=>$path_view,
        'modAdmisi' =>$modAdmisi,
    )
);
?>

<div class="form-actions">
    <?php
        if($instalasi == Params::INSTALASI_ID_RJ)
        {
            $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRJ" : "InfoKunjunganRJ");
            $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
        }else if($instalasi == Params::INSTALASI_ID_RD)
        {
            $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRD" : "InfoKunjunganRJ");
            $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
        }else if($instalasi == Params::INSTALASI_ID_RI)
        {
            $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRI" : "InfoKunjunganRJ");
            $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
        }
        echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')).' &nbsp; ';
        if(@$_GET['frame']!=1){
            
            $modDaftar = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id, array('select'=>'pasienadmisi_id'));
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modDaftar->pasienadmisi_id)), array('class'=>'btn btn-default'));
//            echo CHtml::htmlButton(Yii::t('mds','{icon} Back',array('{icon}'=>'<i class="entypo-cancel"></i>')),
//                array('class'=>'btn btn-primary-blue','onKeypress'=>'return formSubmit(this,event)',
//                    'onclick'=>'$("#iframeVerifikasiDiagnosa").attr("src",$(this).attr("href")); window.parent.$("#dialogVerifikasiDiagnosa").dialog("close");return false;'));
        }
        
    ?>
</div>

<?php
    $this->endWidget();
?>
<script>
    function print(caraPrint, idReseptur) {
        var pendaftaran_id = '<?php echo isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id=' + pendaftaran_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>