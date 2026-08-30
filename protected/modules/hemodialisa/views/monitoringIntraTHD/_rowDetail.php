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
        <?php echo CHtml::activeTextField($modDetail, '[ii]penyulit_hd_id', array('readonly' => true, 'style' => 'width:80px;')); ?>
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
