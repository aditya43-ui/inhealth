<?php
/** 
 * view ini digunakan untuk menampilkan semua form pada menu transaksi persiapan pengadaan
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); 

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'persiapanpengadaan-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
        
	'htmlOptions' => array(
            'enctype'=>'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)'
            ),
	//'focus' => '#'.CHtml::activeId($model, 'persiapanpengadaan_tanggal').'',
    ));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <b>Persiapan Pengadaan</b></div>
    </div>
    <div class="panel-body">        
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Persiapan Pengadaan</div>
                    </div>
                    <div class="panel-body">                
                        <?php echo $this->renderPartial($this->path_view_detail.'_formPersiapan',array(
                            'form'=>$form, 
                            'model'=>$model,
                            'modRencana'=>$modRencana
                            ),true); ?>
                        <div class="clear"></div>
                        <hr/>                
                        <?php echo $this->renderPartial($this->path_view_detail.'_formLanjutan',array(
                            'form'=>$form, 
                            'model'=>$model , 
                            'modRencana'=>$modRencana,
                            'modPersiapan'=>$modPersiapan,
                                ),true); ?>                
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">HPS</div>
                    </div>
                    <div class="panel-body overflow-x">
                        <?php echo $this->renderPartial($this->path_view_detail.'_formHPS',array(
                            'form'=>$form, 
                            'model'=>$model, 
                            'modDetail'=>$modDetail
                                ),true); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Dokumen RUP</div>
                    </div>
                    <div class="panel-body" >
                        <i><label ><span class="required">Maksimal Ukuran file adalah 2000kb/2mb</span></label></i>

                        <table class="table table-bordered table-striped table-condensed" id="form-dokrup">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Jenis Dokumen</th>
                                    <th style="text-align: center;">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($modDokRUP)): ?>
                                    <?php foreach ($modDokRUP as $dokumen): ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $dokumen->dokumenpendukungpengadaan_nama; ?></td>
                                            <td style="text-align: center;"><?php echo CHtml::link($dokumen->dokumenpendukungpengadaan_file, $this->createUrl('UnduhDokRUP', array('dokumenpendukungpengadaan_id' => $dokumen->dokumenpendukungpengadaan_id)), array('title' => 'Unduh Dokumen', 'rel' => 'tooltip')); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>                
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Dokumen Persiapan Pengadaan</div>
                    </div>
                    <div class="panel-body" >
                        <i><label ><span class="required">Maksimal Ukuran file adalah 2000kb/2mb</span></label></i>

                        <table class="table table-bordered table-striped table-condensed" id="form-dokpendukung">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Jenis Dokumen</th>
                                    <th style="text-align: center;">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($modDokumen)) {
                                    foreach ($modDokumen as $dokumen) {?>                                        
                                            <td style="text-align: center;"><?php echo $dokumen['nama']; ?></td>
                                            <td style="text-align: center;">
                                                <?php         
                                                    $a = 1;
                                                    foreach($dokumen['det'] as $dok){
                                                        $pisah = explode('.', $dok['file']);
                                                        $nama_file = '';
                                                        if (!empty($dok['file'])){
                                                            $nama_file = $pisah[0].'-'.($a).'.'.$pisah[1];
                                                        }
                                                        
                                                        echo CHtml::link($nama_file, $this->createUrl('UnduhDok', array('dokumenpendukungpengadaan_id' => $dok['id'])), array('title' => 'Unduh Dokumen', 'rel' => 'tooltip'))."<br/>"; 
                                                        $a++;
                                                    }                                                    
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>                
                    </div>
                </div>
            </div>
        </div>
        <?php 
        $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'data-riwayat',
            'content'=>array(
                'content-datariwayat'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini',
                        'onclick'=>'Pengorganisasidata()',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'rel'=>'tooltip',
                        'title'=>'Klik untuk tampilkan Riwayat')).'<b> Riwayat</b>',
                    'isi'=>$this->renderPartial($this->path_view_detail.'_riwayat',array('modRiwayat'=>$modRiwayat),true),
                    'active'=>true,
                    ),   
                ),
        )); 
        ?>
        <div>
            <?php 
            echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')).'&nbsp;';
            echo CHtml::link('<i class="entypo-print" style="color: white;"></i> Cetak', '#', array(
                        'class' => 'btn btn-info',
                        "rel" => "tooltip",
                        "data-placement" => "left",
                        "title" => "Klik untuk Cetak Mencetak HPS",
                        'onclick' => "window.open('" . $this->createUrl('printHps', array('id' => $model->persiapanpengadaan_id)) . "', 'printwin', 'left=100,top=100,width=1120,height=790')"
            ));
            ?>	
        </div>
        
    </div>
</div>
    
<?php $this->endWidget(); ?>
