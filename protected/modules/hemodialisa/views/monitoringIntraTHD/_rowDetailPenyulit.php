<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut', 0, array('readonly' => true, 'class' => 'span1 integer2', 'style' => 'width:20px;')); ?>
        <?php echo CHtml::activeTextField($modDetail, '[ii]jenis_observasi', array('readonly' => true, 'style' => 'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]jam_observasi', array('readonly' => true, 'style' => 'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]blood_flow', array('readonly' => true, 'style' => 'width:80px;')); ?>
    </td>    
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]tensi_sistolik', array('readonly' => true, 'style' => 'width:30px;')); ?> / 
        <?php echo CHtml::activeTextField($modDetail, '[ii]tensi_diastolik', array('readonly' => true, 'style' => 'width:30px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]nadi', array('readonly' => true, 'style' => 'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]suhu', array('readonly' => true, 'style' => 'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]respirasi', array('readonly' => true, 'style' => 'width:80px;')); ?>
    </td>    
    <td>
        <?php           
            if ($penyulit_nama == 'Transfusi Darah'){
                echo CHtml::Link("$penyulit_nama",Yii::app()->controller->createUrl("transfusiDarahHD/index",array("pendaftaran_id"=>$pendaftaran_id,"pasienadmisi_id"=>'',"pasienmasukpenunjang_id"=>'','frame'=>1, 'transfusi'=>1,'konsulpoli_id'=>$data['konsulpoli_id'])),array("class"=>"btn btn-success", "target"=>"iframeObs","onclick"=>"$(\"#dialogObs\").dialog(\"open\");","rel"=>"tooltip",));
            }else if ($penyulit_nama == 'Clothing'){
                echo CHtml::Link("$penyulit_nama",Yii::app()->controller->createUrl("perkembanganTerintegrasiPasienTHD/createIntegrasi",array("pendaftaran_id"=>$pendaftaran_id,"pasienadmisi_id"=>'',"pasienmasukpenunjang_id"=>'', 'data'=>$data, 'dialog'=>1, 'transfusi'=>1,'konsulpoli_id'=>$data['konsulpoli_id'], 'detail'=>isset($_GET['detail'])?$_GET['detail']:null)),array("class"=>"btn btn-success", "target"=>"iframeDetPengeluaran","onclick"=>"$(\"#dialogTransfusi\").dialog(\"open\");","rel"=>"tooltip",));
            }else{
                echo CHtml::Link("$penyulit_nama",'javscript:;',array("class"=>"btn btn-success","onclick"=>"stopTindakanDialisis(this);","rel"=>"tooltip",'data-konsul'=>$data['konsulpoli_id'],'data-id'=>$pendaftaran_id));
            }
        ?>
        <?php 
            //echo CHtml::link("<span style='font-size:15px;'>Transfusi</span>","javascript:;",array('onclick'=>'generateForm(this,'.$pendaftaran_id.');', 'class'=>'btn btn-success'));
        ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]penyulit_hd_id', array('readonly' => true, 'style' => 'width:80px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]intake_nacl', array('readonly' => true, 'style' => 'width:50px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]intake_lainnya', array('readonly' => true, 'style' => 'width:50px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]output_uf_goal', array('readonly' => true, 'style' => 'width:50px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]output_lainnya', array('readonly' => true, 'style' => 'width:50px;')); ?>
    </td>
   <td>
        <?php 
        if (empty($modDetail->create_login)){
            $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));           
        }else{
            $log = LoginpemakaiK::model()->findByPk($modeDetail->create_login);
            $peg = !empty($log->pegawai)?$log->pegawai:'-';            
        }
        
        echo !empty($peg)?$peg->namaLengkap:'-'
        ?>
    </td>
    <td>
        <a onclick="batalTindakanKeperawatan(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan tindakan keperawatan ini"><i class="icon-remove"></i></a>
    </td>
</tr>

