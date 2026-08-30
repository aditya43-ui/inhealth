<?php
    $this->breadcrumbs=array(
        'Informasi Rencana Kebutuhan',
    ); 
    Yii::app()->clientScript->registerScript('search', "
    $('#rencana-t-search').submit(function(){
    	$.fn.yiiGridView.update('rencana-m-grid', {
    		data: $(this).serialize()
    	});
    	return false;
    });
    ");
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana Kebutuhan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Rencana Kebutuhan</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <div class="block-tabel">
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                                'id'=>'rencana-m-grid',
                                'dataProvider'=>$model->searchInformasi(),
                                'template'=>"{summary}\n{items}\n{pager}",
                                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                                'columns'=>array(
                                    array(
                                        'name'=>'tglperencanaan',
                                        'type'=>'raw',
                                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglperencanaan)',
                                    ),
                                    'noperencnaan',
                                    array(
                                        'header'=>'Sumber Dana',
                                        'type'=>'raw',
                                        'value'=>'$data->sumberdana_nama',
                                    ),
                                    array(
                                        'name'=>'ruangan_id',
                                        'type'=>'raw',
                                        'value'=>'$data->ruangan_nama',
                                    ),
                                    array(
                                        'header'=>'Dibuat Oleh',
                                        'type'=>'raw',
                                        'value'=>'$data->pegawai_gelardepan." ".$data->pegawai_nama.", ".$data->pegawai_gelarbelakang',
                                    ),
                                    array(
                                        'header'=>'Keterangan Rencana',
                                        'type'=>'raw',
                                        'value'=>function($data) {
                                                $r = RencanakebfarmasiT::model()->findByPk($data->rencanakebfarmasi_id);
                                                return $r->keterangan_rencana;
                                        }
                                    ),
                                    array(
                                        'header'=>'Pegawai Menyetujui',
                                        'type'=>'raw',
                                        'value' => function($data){
                                            $dataDialog = 'myAlert("Hanya '.(isset($data->pegawaimenyetujui_id)? $data->PegawaimenyetujuiLengkap : "-").' yang bisa mengakses");';
                                            if($data->pegawaimenyetujui_id==Yii::app()->user->getState('pegawai_id')){
                                               $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                            }
                                                $html = (isset($data->pegawaimenyetujui_id)? $data->PegawaimenyetujuiLengkap : "-").(isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmenyetujui) : (!isset($data->pegawaimenyetujui_id)? "" : (!isset($data->pegawaimenyetujui_id) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui', array("rencanakebfarmasi_id"=>$data->rencanakebfarmasi_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve Menyetujui", "id"=>"btnrencanadlg", "onclick"=>$dataDialog)))));
                                                return $html;
                                        }
                                    ),
                                    array(
                                        'name'=>'statusrencana',
                                        'type'=>'raw',
                                        'value'=>'$data->statusrencana',
                                    ),
                                    array(
                                        'header'=>'Ubah Rencana',
                                        'type'=>'raw',
                                        'value'=>'(isset($data->tglmenyetujui))?
                                                        "<a rel=\'tooltip\' title=\'Tidak dapat diubah karena sudah disetujui oleh pegawai menyetujui\'><icon class=\'icon-form-ubah\' style=\'opacity: 0.3\'></icon></a> "
                                                :
                                                        (($data->statusrencana != "DITOLAK")?(($data->pegawai_id=='.Yii::app()->user->getState('pegawai_id').')? CHtml::link("<icon class=\'icon-form-ubah\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.$this->path_rencana.'/index", array("rencanakebfarmasi_id"=>$data->rencanakebfarmasi_id,"ubah"=>true)), array("target"=>"BLANK","rel"=>"tooltip", "title"=>"Klik untuk mengubah data")) :
                                                            "<a rel=\'tooltip\' title=\'Tidak dapat diubah karena hanya bisa diakses oleh $data->pegawai_gelardepan $data->pegawai_nama, $data->pegawai_gelarbelakang \'><icon class=\'icon-form-ubah\' style=\'opacity: 0.3\'></icon></a> ")
                                                                
                                                        :
                                                                "<a rel=\'tooltip\' title=\'Tidak dapat diubah karena sudah ditolak\'><icon class=\'icon-form-ubah\' style=\'opacity: 0.3\'></icon></a> "
                                                        )
                                                ',

                                        'htmlOptions'=>array('style'=>'text-align:center;'),
                                    ),
                                    array(
                                        'header'=>'Permintaan Pembelian',
                                        'type'=>'raw',
                                        'value'=>function($data){
                                            $p = PermintaanpembelianT::model()->findAllByAttributes(array(
                                                    'rencanakebfarmasi_id'=>$data->rencanakebfarmasi_id                                                        
                                            ));

                                            $renDet = ADRencDetailkebT::model()->findAllByAttributes(array(
                                                    'rencanakebfarmasi_id'=>$data->rencanakebfarmasi_id                                                        
                                            ));
                                              
                                            $permintaanP = PermintaanpembelianT::model()->findByAttributes(array(
                                                    'rencanakebfarmasi_id'=>$data->rencanakebfarmasi_id                                                        
                                            ));
                                            
                                            $pegawaiPem = "";
                                                $tglCreateTime = "";
                                                
                                                if(isset($permintaanP)){
                                                    $loginCreate = LoginpemakaiK::model()->findByPk($permintaanP->create_loginpemakai_id);
                                                    if(isset($loginCreate)){
                                                        $peg = PegawaiM::model()->findByPk($loginCreate->pegawai_id);
                                                        if(isset($peg)){
                                                            $pegawaiPem = $peg->namaLengkap;
                                                        }
                                                    }
                                                    
                                                    $tglCreateTime = MyFormatter::formatDateTimeForUser($permintaanP->create_time);
                                                }
                                            
                                            $jum = 0;
                                            $jumRen = 0;
                                            $getDetR = array();
                                            $getTerima = array();
                                            $ok = true;

                                            if (count((array)$renDet)>0){                                                                                                        
                                                foreach ($renDet as $det){                                                        
                                                    $getDetR[] = array(
                                                        'obatalkes_id' => $det->obatalkes_id,
                                                        'stok' => $det->jmlpermintaan * $det->rencanakebfarmasi->jmlwaktupemakaian,
                                                    );
                                                }                                                    
                                            }         

                                            if (count((array)$p)>0){                                                                                                        
                                                foreach ($p as $brg){ 
                                                     if ( (!empty($brg->penerimaanbarang_id)) && ($brg->penerimaanbarang->statuspenerimaan == Params::STATUS_TERIMAOA_DISETUJUI)){

                                                        $det = PenerimaandetailT::model()->findAll(" penerimaanbarang_id = '".$brg->penerimaanbarang_id."' AND returdetail_id IS NULL ORDER BY obatalkes_id");                                                            
                                                        foreach($det as $dt){

                                                            if (isset($jumDt[$dt->obatalkes_id])){
                                                                $jumDt[$dt->obatalkes_id] = $jumDt[$dt->obatalkes_id] + $dt->jmlterima;    
                                                            }else{
                                                                $jumDt[$dt->obatalkes_id]  = $dt->jmlterima;
                                                            }

                                                            $getTerima[$dt->obatalkes_id] = array(
                                                                'obatalkes_id' => $dt->obatalkes_id,
                                                                'stok' => $jumDt[$dt->obatalkes_id],
                                                            );

                                                        }
                                                        $jum = 0;
                                                     }
                                                }
                                            }
                                            
                                            if (is_array($getDetR)){
                                                if (is_array($getTerima)){
                                                    foreach ($getDetR as $cekR){ 
                                                        if(isset($getTerima[$cekR['obatalkes_id']]) &&
                                                                !empty($getTerima[$cekR['obatalkes_id']]) && 
                                                                $cekR['obatalkes_id'] == $getTerima[$cekR['obatalkes_id']]['obatalkes_id']){
                                                            if ($cekR['stok'] > $getTerima[$cekR['obatalkes_id']]['stok']){                                                                    
                                                                $ok = $ok && false;
                                                            }else{
                                                                $ok = $ok && true;
                                                            }                                                                
                                                        }
                                                    }
                                                }
                                            }

                                            if (empty($getTerima)){
                                                $ok = false;                                                    
                                            }

                                            if ($ok){
                                                return 'Permintaan Sudah Terpenuhi';                                            
                                            }else{
                                                
                                                $hasilPP = ((isset($data->tglmenyetujui)) ?
                                                    CHtml::Link("<i class='icon-form-mintabeli'></i>",$this->createUrl($this->path_permintaan."/Index").'&rencana_id='.$data->rencanakebfarmasi_id,
                                                        array("class"=>"", "rel"=>"tooltip","title"=>"Klik Mendaftarkan Ke Permintaan Pembelian",)) :
                                                "<a rel='tooltip' title='Tombol akan aktif jika rencana sudah disetujui dan diketahui'><icon class='icon-form-mintabeli' style='opacity: 0.3'></icon></a> "
                                                );
                                                
                                                if(isset($permintaanP)){
                                                    if(!empty($permintaanP->batalpermintaanpembelian_id)){
                                                        $modBatalPembelian = BatalpermintaanpembelianT::model()->findByPk($permintaanP->batalpermintaanpembelian_id);
                                                        
                                                        if(isset($modBatalPembelian)){
                                                            return "Telah Dibatalkan Oleh ".$modBatalPembelian->userotorisasi->namaLengkap." dengan tanggal dan waktu ". MyFormatter::formatDateTimeForUser($modBatalPembelian->tglbatalpermintaan);
                                                        }
                                                    }else{
                                                        return "Permintaan oleh ".$pegawaiPem." dengan tanggal dan waktu ".$tglCreateTime;
                                                    }
                                                }else{
                                                    return $hasilPP;
                                                }
                                                
                                            }
                                        },										
                                        'htmlOptions'=>array('style'=>'text-align:center;'),
                                    ),
                                    array(
                                        'header'=>'Rincian',
                                        'type'=>'raw',
                                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Rincian", array("rencanakebfarmasi_id"=>$data->rencanakebfarmasi_id)),
                                                array("class"=>"", 
                                                        "target"=>"rencana",
                                                        "onclick"=>"$(\"#dialogRencana\").dialog(\"open\");",
                                                        "rel"=>"tooltip",
                                                        "title"=>"Klik untuk melihat details Rencana",
                                                ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i> ", "javascript:deleteRecord($data->rencanakebfarmasi_id)",array("id"=>"$data->rencanakebfarmasi_id","rel"=>"tooltip","title"=>"Batalkan Rencana Kebutuhan"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php 
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogRencana',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Details Rencana',
                        'autoOpen'=>false,
                        'minWidth'=>900,
                        'maxHeight'=>600,
                        'resizable'=>false,
                        'position'=>array('my'=>'bottom','at'=>'bottom'),
                        ),
                    ));
?>
<iframe src="" name="rencana" width="100%" height="500px">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

?>
<script type="text/javascript">
     function deleteRecord(id){
        var id = id;
        var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id)."/delete"; ?>';
        myConfirm('Yakin Akan Membatalkan Rencana Kebutuhan ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rencana-m-grid');
                            }else{
                                myAlert('Rencana Kebutuhan Gagal di Dibatalkan')
                            }
                },"json");
            }
        }); 

    }
    
</script>

<!-- Dialog untuk mengetahui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMengetahui',
        'options' => array(
            'title' => 'Approvement Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'height' => 600,
            'resizable' => false,
            'position'=>array('my'=>'bottom','at'=>'bottom'),
			'close'=>"js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMengetahui' width="100%" height="600"></iframe>
<?php $this->endWidget(); ?>
<!-- Dialog untuk menyetujui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenyetujui',
        'options' => array(
            'title' => 'Approvement Rencana',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'maxHeight'=>600,
            'resizable' => false,
            'position'=>array('my'=>'bottom','at'=>'bottom'),
			'close'=>"js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMenyetujui' width="100%" height="500px"></iframe>
<?php $this->endWidget(); ?>