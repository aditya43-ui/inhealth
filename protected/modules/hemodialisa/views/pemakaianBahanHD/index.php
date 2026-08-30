<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Pemakaian <b>Bahan</b></div>				
	</div>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data pemakaian Bahan berhasil disimpan !");
        }
    ?> 
    <div class="panel-body">   
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemakaianbahp-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title" id="form-datakunjungan">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                    </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?>
                </div>
            </div>
            <br>
            <div class="panel-body" id="form-datakunjungan">
                <div class="clear"></div>
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>
        </div>    
    </div>
        
        
    <div class="row-fluid">
        <div class="span12">
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'riwayat-obatalkespasien-t',
                    'content'=>array(
                        'content-riwayat-obatalkespasien-t'=>array(
                            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk menampilkan obat alkes pasien')).'<b> Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                            'isi'=>'
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <th>No.</th>
                                        <th>Tgl. Pelayanan</th>
                                        <th>Obat / Alat Kesehatan</th>
                                        <th>Satuan Kecil</th>
                                        <th>Jumlah</th>
                                        <th>Hapus</th>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan=7>Data tidak ditemukan</td></tr>
                                    </tbody>
                                </table>',
                    'active' => true,
                ),
            ),
        )); ?>

        <!-- <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Obat dan Alkes
                </div>
            </div>
            <div class="panel-body" id="form-tambahobatalkes">
                <?php // s$this->renderPartial($this->path_view . '_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
            </div>
        </div>
    </div>  -->
 
        <div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Obat dan Alat Kesehatan</div>
			</div>
			<div  class="panel-body" id="form-tambahobatalkes">				
				<div class="row-fluid">
					<?php $this->renderPartial($this->path_view.'_formObatAlkesPasien',array('modKunjungan'=>$modKunjungan)); ?>
				</div>
			</div>
	
    <div class="block-tabel">
        <h6>Tabel <b>Bahan</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Obat / Alat Kesehatan</th>
                    <th>Satuan Kecil</th>
                    <th>Stok</th>
                    <th>Jumlah</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($dataOas) > 0){
                    foreach($dataOas AS $i=>$modObatAlkesPasien){
                        echo $this->renderPartial($this->path_view.'_rowObatAlkesPasien',array('modObatAlkesPasien'=>$modObatAlkesPasien));
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    </div>
        
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);'));
                    echo '&nbsp;';

                    if(!isset($_GET['frame'])){
                        echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                $this->createUrl($this->module->id.'/index'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
                        echo '&nbsp;';
                    }
                    if($modKunjungan->isNewRecord){
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                        echo '&nbsp;';
                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print(".$modKunjungan->pendaftaran_id.");return false"));
                        echo '&nbsp;';
                    }


                    $content = $this->renderPartial($this->path_view.'tips/tipsPemakaianBahan',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
<?php $this->endWidget(); ?>
    </div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
</div>