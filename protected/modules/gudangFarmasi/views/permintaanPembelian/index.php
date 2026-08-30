<style type='text/css'>
    .integer-decimal{
        text-align: right;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi <strong>Permintaan Pembelian Obat dan Alkes</strong></div>
            </div>
            <div class="panel-body">
                <?php 
                $this->breadcrumbs=array(
                    'Informasi Rencana Kebutuhan'=>Yii::app()->request->getUrlReferrer(),
                    'Pembelian Obat & Alkes',
                );
                        if(isset($_GET['sukses'])){
                                Yii::app()->user->setFlash('success',"Data Permintaan Pembelian berhasil disimpan !");
                        }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                        'id'=>'permintaanpembelian-form',
                        'enableAjaxValidation'=>false,
                        'type'=>'horizontal',
                        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
                        'focus'=>'#'.CHtml::activeId($modPermintaanPembelian,'keteranganpermintaan'),
                )); 

                ?>
                
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Rencana Kebutuhan</div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class = "col-sm-6">
                                <div class="control-group ">
                                    <?php echo $form->labelEx($modRencanaKebFarmasi,'noperencnaan', array('class'=>'control-label','label'=>'No Rencana')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($modPermintaanPembelian,'rencanakebfarmasi_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                        <?php echo $form->textField($modRencanaKebFarmasi,'noperencnaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <?php echo $form->labelEx($modRencanaKebFarmasi,'tglperencanaan', array('class'=>'control-label','label'=>'Tanggal Rencana')) ?>
                                    <div class="controls">
                                        <?php $modRencanaKebFarmasi->tglperencanaan = (!empty($modRencanaKebFarmasi->tglperencanaan)?MyFormatter::formatDateTimeForUser($modRencanaKebFarmasi->tglperencanaan):null); ?>
                                        <?php echo $form->textField($modRencanaKebFarmasi,'tglperencanaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-sm-6">
                                <div class="control-group ">
                                    <?php echo Chtml::label("Sumber Dana", 'sumberdana_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($modPermintaanPembelian, 'sumberdana_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                        <?php echo $form->textField($modPermintaanPembelian,'sumberdana_nama',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>		
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Permintaan Pembelian Obat & Alkes </div>
                    </div>
                    <div class="panel-body" id="form-permintaanpembelian">
                            <?php $this->renderPartial($this->path_view.'_formPermintaanPembelian', array('form'=>$form,'format'=>$format,'modPermintaanPembelian'=>$modPermintaanPembelian,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modPermintaanPenawaran'=>$modPermintaanPenawaran)); ?>
                    </div>
                </div>	
                
                <?php echo $form->hiddenField($modPermintaanPembelian, 'is_uangmukapembelian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'form-uangmukapembelian',
                    'content'=>array(
                        'content-uangmukapembelian'=>array(
                            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan form Permintaan Uang Muka Pembelian')).'<b> Data Permintaan Uang Muka Pembelian</b>',
                            'isi'=>$this->renderPartial($this->path_view.'_formUangMuka',array(
                                'form'=>$form,
                                'model'=>$modPermintaanPembelian,
                            ),true),
                            'active'=>$modPermintaanPembelian->is_uangmukapembelian,
                        ),   
                    ),
                )); ?>
                
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Permintaan Pembelian Obat dan Alkes</div>
                    </div>
                    <div class="panel-body" id="form-tambahobatalkes">
                        <?php if(!isset($_GET['sukses'])){ ?> 
                            <div class="row-fluid">
                                <?php // $this->renderPartial($this->path_view.'_formObatPermintaanPembelian',array('modPermintaanPembelian'=>$modPermintaanPembelian)); ?>
                            </div>
                        <?php } ?>
                        
                        <div class="panel panel-primary panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Tabel <strong>Permintaan Pembelian Obat dan Alkes</strong></div>
                            </div>
                                <div class="panel-body" style="overflow-x: scroll">
                                    <div class="block-tabel">
                                        <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Supplier</th>
                                                    <th>Kode</th>
                                                    <th>Nama Obat & Alkes</th>
                                                    <th>Zat Aktif</th>
                                                    <th>Bentuk/<br/> Kekuatan</th>
                                                    <th hidden>Satuan</th>
                                                    <th>Jumlah Permintaan</th>    
                                                    <th>Jumlah Kemasan (Satuan)</th>                                            
                                                    <th>Harga Satuan (Rp.)</th>
                                                    <th hidden>Stok Akhir</th>
                                                    <th>Keringanan (%)</th>
                                                    <th>Keringanan (Rp.)</th>
                                                    <th>PPN (%)</th>
                                                    <th>PPN (Rp.)</th>
                                                    <th>PPh (%)</th>
                                                    <th>PPh (Rp.)</th>
                                                    <th hidden>Minimal Stok</th>
                                                    <th>HPP</th>
                                                    <th>Sub Total (Rp.)</th>
                                                    <th>Keterangan</th>
                                                    <th hidden>Batal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(count((array)$modDetails) > 0){
                                                        foreach($modDetails AS $i=>$modPermintaanPembelianDetail){
                                                            $modPermintaanPembelianDetail->jmlpermintaan = number_format($modPermintaanPembelianDetail->jmlpermintaan,2,",",".");
                                                            $modPermintaanPembelianDetail->harganettoper = MyFormatter::formatNumberForPrint($modPermintaanPembelianDetail->harganettoper,2);
                                                                echo $this->renderPartial($this->path_view.'_rowObatPermintaanPembelian',array('modPermintaanPembelian'=>$modPermintaanPembelian,'modPermintaanPembelianDetail'=>$modPermintaanPembelianDetail));
                                                        }
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="16">Total</td>
                                                    <td><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::textField('total','',array('class'=>'span2 integer-decimal','style'=>'width:90px; text-align:right', 'readonly'=>true)):CHtml::passwordField('total','',array('class'=>'span2 integer-decimal','style'=>'width:90px; text-align:right', 'readonly'=>true)) ?></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <?php isset($_GET['ubah'])? $modPermintaanPembelian->permintaanpembelian_id = '' : '' ; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>								
                <div class="row-fluid">
                        <div class="form-actions">
                                <?php 
                                        if(!isset($_GET['sukses'])){
                                                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();')); 
                                                echo "&nbsp;";
                                        }else{
                                                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>true)); 
                                                echo "&nbsp;";
                                        }


                                        if(!isset($_GET['frame'])){
                                                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                        $this->createUrl($this->id.'/index'), 
                                                        array('class'=>'btn btn-danger',
                                                                  'onclick'=>'return refreshForm(this);'));
                                                echo "&nbsp;";
                                        }
                        if(!isset($_GET['sukses'])){
                            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                echo "&nbsp;";
//                            echo CHtml::link(Yii::t('mds', '{icon} Print Obat Tertentu', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
//                echo "&nbsp;";
//                echo CHtml::link(Yii::t('mds', '{icon} Print Obat Prekursor', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
//                echo "&nbsp;";
//                echo CHtml::link(Yii::t('mds', '{icon} Print Obat Psikotropika', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
//                echo "&nbsp;";
        //    //                echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4045*
        //                    echo "&nbsp;";
                        }else{
                            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')", 'disabled'=>in_array($modPermintaanPembelian->golongan_kode, array('OOT', 'PRE', 'PSI'))));
                echo "&nbsp;";
//                echo CHtml::link(Yii::t('mds', '{icon} Print Obat Tertentu', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"printObatTertentu('PRINT')", 'disabled'=>$modPermintaanPembelian->golongan_kode != 'OOT'));
//                echo "&nbsp;";
//                echo CHtml::link(Yii::t('mds', '{icon} Print Obat Prekursor', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"printObatPrekursor('PRINT')", 'disabled'=>$modPermintaanPembelian->golongan_kode != 'PRE'));
//                echo "&nbsp;";
//                echo CHtml::link(Yii::t('mds', '{icon} Print Obat Psikotropika', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"printObatPsikotropika('PRINT')",'disabled'=>$modPermintaanPembelian->golongan_kode != 'PSI'));
//                echo "&nbsp;";
        //    //                echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4045*
        //                    echo "&nbsp;";
                        }


                                        $content = $this->renderPartial($this->path_view.'tips/tipsPermintaanPembelian',array(),true);
                                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                                ?> 
                        </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPermintaanPembelian'=>$modPermintaanPembelian,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modPermintaanPenawaran'=>$modPermintaanPenawaran)); ?>