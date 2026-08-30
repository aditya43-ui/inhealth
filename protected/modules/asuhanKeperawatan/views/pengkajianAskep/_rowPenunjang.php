<?php
if (!empty($modTambahPenunjang->tglmasukpenunjang)) {
	$tgl = date('d M Y H:i:s',strtotime($modTambahPenunjang->tglmasukpenunjang));
        $cekRuangan = RuanganM::model()->findByPk($modTambahPenunjang->ruangan_id);
        $data = (isset($cekRuangan->ruangan_nama) ? 'Ruangan : ' . $cekRuangan->ruangan_nama : "-");

        $modHasilLab    = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$modTambahPenunjang->pasienmasukpenunjang_id));
        $modHasilRad    = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$modTambahPenunjang->pasienmasukpenunjang_id));
        $modHasilPA     = HasilpemeriksaanpaT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$modTambahPenunjang->pasienmasukpenunjang_id), array('order' => 'create_time desc'));
        
        $resultlab  = CHtml::Link("<i class='".MyIcon::getIcons('list')."'></i>",Yii::app()->createUrl("laboratorium/pencatatanHasilPemeriksaan/print",array("pasienmasukpenunjang_id"=>$modTambahPenunjang->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
                        array("class"=>"", 
                                "target"=>"framePK",
                                'onclick'=>'$("#dialogPK").dialog("open")',
                                'rel'=>'tooltip',
                                'title'=>'Klik untuk melihat detail pemeriksaan saya',
                        ));
        $resultrad  = CHtml::Link("<i class='".MyIcon::getIcons('list')."'></i>",Yii::app()->createUrl("radiologi/lihatHasil/HasilPeriksa",array("pasien_id"=>$modTambahPenunjang->pasien_id, "pasienmasukpenunjang_id"=>$modTambahPenunjang->pasienmasukpenunjang_id, "pendaftaran_id"=>$modTambahPenunjang->pendaftaran_id, "frame"=>1,"popup"=>"true")),
                        array("class"=>"", 
                                "target"=>"frameRad",
                                'onclick'=>'$("#dialogRad").dialog("open")',
                                'rel'=>'tooltip',
                                'title'=>'Klik untuk melihat detail pemeriksaan radiologi',
                        ));
        
        $resultlPa  = CHtml::Link("<i class='".MyIcon::getIcons('list')."'></i>",Yii::app()->createUrl("laboratorium/pencatatanHasilPemeriksaan/detailPA",array("pasienmasukpenunjang_id"=>$modTambahPenunjang->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
                        array("class"=>"", 
                                "target"=>"framePA",
                                'onclick'=>'$("#dialogPA").dialog("open")',
                                'rel'=>'tooltip',
                                'title'=>'Klik untuk melihat detail pemeriksaan Anatomi',
                        ));
        
       
} else if(isset($modPenunjang->datapenunjang_tgl)){
	$tgl = date('d/m/Y H:i:s',strtotime($modPenunjang->datapenunjang_tgl));
        $data = '';
        $resultlab      = '';
        $resultrad      = '';
        $resultlPa      = '';
        $resultMk       = '';
        $modHasilLab    = '';
        $modHasilRad    = '';
        $modHasilPA     = '';
        $modHasilMk     = '';
}else {
	$tgl = date('d/m/Y H:i:s');
        $data = '';
        $resultlab      = '';
        $resultrad      = '';
        $resultlPa      = '';
        $resultMk       = '';
        $modHasilLab    = '';
        $modHasilRad    = '';
        $modHasilPA     = '';
        $modHasilMk     = '';
}
?>
<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($modPenunjang, '[ii]datapenunjang_id', array('readonly' => true)); ?>
		<?php echo CHtml::activeHiddenField($modPenunjang, '[ii]pengkajianaskep_id', array('readonly' => true)); ?>
		<?php echo CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_tgl', array('readonly' => true,'class' => 'span3 datetimemask', 'value' => $tgl)); ?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_nama', array('readonly' => true,'class' => 'span4',  'value' => $data)); ?>
	</td>
        <td style="text-align: center;">
            <?php
                if(!empty($modHasilLab)){
                    echo $resultlab; 
                }else if(!empty($modHasilRad)){
                    echo $resultrad; 
                }else if(!empty($modHasilPA)){
                    echo $resultlPa; 
                }else if(!empty($modHasilMk)){
                    echo $resultMk; 
                }else{
                    echo '-';
                }
            ?>
        </td>
<!--	<td style="text-align: center;" class="rowbutton">
		<?php // echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahPenunjang()')); ?>
		<?php // echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'hapusLookup(this)')); ?>
	</td>-->
</tr>