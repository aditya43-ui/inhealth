<?php $linkHalaman = CustomFunction::getUrlByMenuID(2299); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Penutupan Periode Rekening',
);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
$menu_nama = empty($menu_label[Yii::app()->controller->id]) ? "Penutupan Periode Rekening" : $menu_label[Yii::app()->controller->id];
?>
<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penutupan Periode Rekening</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
    <?php 
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'perioderekening-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event); '),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus'=>'#'.CHtml::activeId($modRekPeriod,'deskripsi'),
        )); 
        ?>	
        <?php 
        if(isset($_GET['sukses'])){
                Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Periode Akuntansi</div>
            </div>
            <div class="panel-body">
                <fieldset id="form-rekening">
                    <div>
                        <?php $this->renderPartial('_periodeRekeningBaru', array('format'=>$format,'modRekPeriod'=>$modRekPeriod)); ?>
                    </div>
                </fieldset>
            </div>
        </div>								
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Tabel <strong>Akun</strong></div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <table class="items table table-bordered table-striped table-condensed" id="table-rekening">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Akun</th>
                                <th>Nama Akun</th>
                                <th>Saldo Debit</th>
                                <th>Saldo Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:right;">TOTAL</td>
                                <td style="text-align: right;"><?php echo CHtml::textField('totalDebit','',array('class'=>'span2 integer4','style'=>'width:120px; text-align: right;','readonly'=>true))?></td>
                                <td style="text-align: right;"><?php echo CHtml::textField('totalKredit','',array('class'=>'span2 integer4','style'=>'width:120px; text-align: right;','readonly'=>true))?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <fieldset>
        <div class="panel panel-primary panel-success panel-periode">
            <div class="panel-heading">
                <div class="panel-title" class="judul">Periode Akuntansi Baru</div>
            </div>
            <div class="panel-body">
                <?php echo $form->hiddenField($modRekPeriod, 'is_rekeningbaru', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'id'=>'is_rekeningbaru')); ?>
                <?php
                echo $this->renderPartial('_formRekeningBaru',array(
                                'form'=>$form,
                                'format'=>$format,
                                'modRekPeriod'=>$modRekPeriod,
                            ),true);
                
                ?>
            </div>
        </div>
        
        </fieldset>
        <div class="form-actions">
            <?php 
                $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                $disableSave = false;
                $disableSave = ((!empty($_GET['rekperiod_id'])) ? true : (($sukses > 0) ? true : false)); 
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'verifikasi();', 'onkeypress'=>'verifikasi();','disabled'=>$disableSave,)); ?>
            <?php 
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl($this->id.'/index'), 
                array('class'=>'btn btn-danger',
                'onclick'=>'return refreshForm(this);'));
            ?>
            <?php $content = $this->renderPartial('/tips/transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', array('modRekPeriod'=>$modRekPeriod)); ?>
