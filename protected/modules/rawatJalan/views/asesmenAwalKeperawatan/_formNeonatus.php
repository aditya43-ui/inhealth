<style type="text/css">
    .form-wizard {
  margin-top: 45px;
}
.form-wizard .steps-progress {
  display: block;
  background: #ebebeb;
  width: auto;
  height: 10px;
  margin: 0 70px;
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
.form-wizard .steps-progress .progress-indicator {
  background: #00a651;
  width: 0%;
  height: 10px;
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  -moz-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.form-wizard.no-margin .tab-content {
  margin-left: 0 !important;
  margin-right: 0 !important;
}
.form-wizard > ul {
  display: table;
  margin: 0;
  padding: 0;
  list-style: none;
}
.form-wizard > ul > li {
  display: table-cell;
  width: 1%;
  text-align: center;
  position: relative;
}
.form-wizard > ul > li a {
  position: relative;
  display: block;
  padding-top: 35px;
  font-weight: bold;
  color: #ababab;
  -moz-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.form-wizard > ul > li a span {
  position: absolute;
  display: block;
  background: #ebebeb;
  color: #8e9094;
  line-height: 35px;
  text-align: center;
  margin-top: -57.5px;
  left: 50%;
  margin-left: -17.5px;
  width: 35px;
  height: 35px;
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
  -moz-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.form-wizard > ul > li.completed a {
  color: #00a651;
}
.form-wizard > ul > li.completed a span {
  background: #00a651;
  color: #fff;
  -moz-box-shadow: 0px 0px 0px 5px #00a651;
  -webkit-box-shadow: 0px 0px 0px 5px #00a651;
  box-shadow: 0px 0px 0px 5px #00a651;
}
.form-wizard > ul > li.disabled a {
  color: rgba(142, 144, 148, 0.5);
}
.form-wizard > ul > li.disabled a span {
  background: #f5f5f6;
  color: rgba(142, 144, 148, 0.5);
  -moz-box-shadow: 0px 0px 0px 5px #f5f5f6;
  -webkit-box-shadow: 0px 0px 0px 5px #f5f5f6;
  box-shadow: 0px 0px 0px 5px #f5f5f6;
}
.form-wizard > ul > li.active a,
.form-wizard > ul > li.current a {
  color: #c5c5c5;
  font-weight: bold;
  color: #303641;
}
.form-wizard > ul > li.active a span,
.form-wizard > ul > li.current a span {
  background: #c5c5c5;
  background: #fff;
  color: #525252;
  -moz-box-shadow: 0px 0px 0px 5px #ebebeb;
  -webkit-box-shadow: 0px 0px 0px 5px #ebebeb;
  box-shadow: 0px 0px 0px 5px #ebebeb;
}
.form-wizard .tab-content {
  margin: 0 52.5px;
  margin-top: 35px;
}
.form-wizard .tab-content .pager {
  margin-top: 35px;
}
.form-wizard .tab-content .pager .first a {
  margin-right: 10px;
}
.form-wizard .tab-content .pager .last a {
  margin-left: 10px;
}

.groupUkurans{
        display:inline;
}

.fontColor{
    color: black !important;
}
.disabledstatusspan{
  color: #ababab;
}
.enabledstatusspan{
  color: black;
}
.textstrikethrough{
  text-decoration: line-through;
}
input[disabled]{
    cursor: not-allowed !important;
}

</style>
<?php
    // $this->breadcrumbs = array(
    //     'Asesmen Awal Keperawatan',
    // );
    // if(isset($_GET['sukses'])){
    //     Yii::app()->user->setFlash('success',"Data Asesmen Awal berhasil disimpan");
    // }
    // $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="divAlert"></div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'riaskepneonatus-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
?>
<!--div class="white-container"-->
        <?php // echo $form->errorSummary($model); ?>
        <div class="row-fluid">
            <div class="col-sm-12">
                <div class="form-wizard form-required-wizard" id="rootwizardAskepNeonatus">
                    <div class="steps-progress">
                    <div class="progress-indicator"></div>
                </div>

                <ul>
                    <li class="active">
                            <a href="#wizard_tabneonatus1" data-toggle="tab"><span>1</span>Riwayat Kesehatan</a>
                    </li>
                    <li>
                            <a href="#wizard_tabneonatus2" data-toggle="tab"><span>2</span>Kebutuhan Psikologi, Sosial, Ekonomi</a>
                    </li>
                    <li>
                            <a href="#wizard_tabneonatus3" data-toggle="tab"><span>3</span>Kebutuhan Komunikasi & Edukasi</a>
                    </li>
                    <li>
                            <a href="#wizard_tabneonatus4" data-toggle="tab"><span>4</span>Skrinning Nyeri</a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="wizard_tabneonatus1">
		                       <?php $this->renderPartial($this->path_view.'neonatus/_formRiwayatKesehatan',array(
                                           'dropPerawat'=>$dropPerawat,
                                           'dropDokter'=>$dropDokter,
                                           'form'=>$form,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'model'=>$model)) ?>
                    </div>
                   <div class="tab-pane" id="wizard_tabneonatus2">
                      <?php $this->renderPartial($this->path_view.'neonatus/_formKebutuhanPsikologi',array('form'=>$form,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'model'=>$model)) ?>
                    </div>
                    <div class="tab-pane" id="wizard_tabneonatus3">
                        <?php $this->renderPartial($this->path_view.'neonatus/_formKebutuhanKomunikasi',array('form'=>$form,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'model'=>$model,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT)) ?>
                    </div>
                    <div class="tab-pane" id="wizard_tabneonatus4">
                      <?php $this->renderPartial($this->path_view.'neonatus/_formSkrinningNyeri',array('form'=>$form,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'model'=>$model)) ?>
                    </div>


                    <ul class="pager wizard">
                			<li class="previous" style="background-color: green">
                				<a href="javascript::void(0)" style="background-color: #00a651; color: white;"><i class="entypo-left-open"></i> Previous</a>
                			</li>

                      <li class="next" style="background-color: green">
                          <a href="javascript:void(0)" style="background-color: #00a651; color: white">Next <i class="entypo-right-open"></i></a>
                			</li>
                    </ul>
                </div>
                </div>
            </div>
        </div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'neonatus/_jsFunctionsNeonatus',array('model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT)); ?>
