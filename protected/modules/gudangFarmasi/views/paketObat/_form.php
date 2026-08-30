<style>
    .qty_jual, .qty_stok {
        text-align: right;
    }

    .yellow td {
        background-color: yellow !important;
    }
    .integer-decimal{
      text-align: right;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel-body">
            <?php
                $this->breadcrumbs=array(
                    'Penjualan Resep Umum',
                );
            ?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

            <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'penjualanresep-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#FAPendaftaranT_instalasi_id',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            ));?>
            <?php
            if(isset($_GET['sukses'])){
                if($_GET['sukses'] == 1){
                    Yii::app()->user->setFlash("success","Paket Obat!");
                }
            }
            ?>

            <div class="row-fluid">
                <div class="col-sm-6">
                    <div id="form-dataresep">
                        <?php $this->renderPartial($this->path_view.'_formDataPaketObat', array('form'=>$form,'model'=>$model,'model'=>$model)); ?>
                    </div>
                </div>
                <div class="col-sm-6">

                    <?php
                        if(!isset($_GET['sukses'])){
                            $this->renderPartial($this->path_view.'_formInputObat', array('form'=>$form,'racikan'=>$racikan, 'racikanDetail'=>$racikanDetail,'nonRacikan'=>$nonRacikan));
                        }
                    ?>

                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title">Tabel <strong>Obat Alkes</strong></div>
                </div>
                <div class="panel-body table-responsive">
                    <div class="block-tabel">
                        <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                            <thead>
                                <tr>
                                    <th>Resep</th>
                                    <th>R ke</th>
                                    <th>Nama Obat</th>
                                    <th>Obat Lain</th>
                                    <th>Permintaan Dosis</th>
                                    <th>Jumlah</th>
                                    <th>Frekuensi</th>
                                    <th>Cara Penggunaan</th>
                                    <th>Jumlah Permintaan</th>
                                    <th>Satuan Sediaan</th>
                                    <th>Keterangan</th>
                                    <th >Edit</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                
                                    if(!empty($loadDetail)){                    
                                        if(!empty($loadDetail)){
                                            $i=1;
                                            foreach($loadDetail as $detail){
                                                $obatalkes = ObatalkesM::model()->findByPk($detail->obatalkes_id);
                                                if (!empty($obatalkes)){

                                                    $detail->obatalkes_kode = $obatalkes->obatalkes_kode;
                                                    $detail->obatalkes_nama = $obatalkes->obatalkes_nama;
                                                    $detail->satuankecil_nama = !empty($detail->satuankecil_id)?$detail->satuankecil->satuankecil_nama:null;
                                                    $detail->jumlah = number_format((float)$detail->jumlah,2,",","");
                                                    // $detail->permintaan_dosis = number_format((float)$detail->permintaan_dosis,2,",","");
                                                    $detail->permintaan_dosis = $detail->permintaan_dosis;
                                                    if($detail->is_permintaandosispecahan){
                                                        $detail->temp_permintaan_dosis = $detail->permintaandosis_pembilang .' / '. $detail->permintaandosis_penyebut;
                                                    }else{
                                                        $detail->temp_permintaan_dosis = $detail->permintaan_dosis;
                                                    }

                                                }
                                                echo $this->renderPartial($this->path_view.'_rowDetail',array('modDetail'=>$detail,'i'=>$i), true);
                                                $i++;
                                            }
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat()')); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
                        $this->createUrl('create'),
                        array(
                            'class' => 'btn btn-danger',
                            'onclick' => 'return refreshForm(this);'
                        )
                    ); ?>
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Master Paket Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                    <?php
                    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
                    $this->widget('UserTips', array('type' => 'master', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model)); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions2', array('model'=>$model)); ?>
<?php $this->renderPartial($this->path_view . '_dialog', array()); ?>