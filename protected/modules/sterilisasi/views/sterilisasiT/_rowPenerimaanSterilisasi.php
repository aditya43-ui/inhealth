<?php
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    ?>
<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]dekontaminasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]penerimaansterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]ruangan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php //echo CHtml::activeHiddenField($penerimaan,'[ii]barang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]peralatansterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeCheckBox($penerimaan,'[ii]checklist', array('class'=>'checklist','onclick'=>'setNol(this);')); ?>
    </td>
	<td>
        <span>
			<?php 
//			echo (!empty($penerimaan->ruangan_nama) ? $penerimaan->ruangan_nama : "");
			if(!empty($penerimaan->pengajuansterlilisasi_id)){
				$modPengajuan = STPengajuansterlilisasiT::model()->findByPk($penerimaan->pengajuansterlilisasi_id);
				echo isset($modPengajuan->ruangan_id) ? $modPengajuan->ruangan->ruangan_nama : '-';
			}
			?>
		</span>
    </td>
    <td>
        <span><?php echo (!empty($penerimaan->penerimaansterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($penerimaan->penerimaansterilisasi_tgl) : "") ?>/<br><?php echo (!empty($penerimaan->penerimaansterilisasi_no) ? $penerimaan->penerimaansterilisasi_no : "") ?></span>
    </td>    
    <td>
        <?php //echo (!empty($penerimaan->barang_nama) ? $penerimaan->barang_nama : "") ?>
        <span><?php 
            if (!empty($penerimaan->peralatansterilisasi_id)){
                $alat = PeralatansterilisasiM::model()->findByPk($penerimaan->peralatansterilisasi_id);
                echo $alat->peralatansterilisasi_nama;
            }else{
                echo 'SADSAd';
            }
               ?></span>
    </td>
	<td>
        <?php echo CHtml::activeTextField($penerimaan,'[ii]sterilisasidetail_jml',array('readonly'=>false,'class'=>'span2 integer','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo CHtml::activeTextArea($penerimaan,'[ii]sterilisasidetail_ket',array('readonly'=>false,'class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo CHtml::activeDropDownList($penerimaan, '[ii]jenissterilisasi_id', CHtml::listData(STJenissterilisasiM::model()->findAll(),'jenissterilisasi_id','jenissterilisasi_nama'),array('style'=>'width:80px;')); ?>
    </td>
	<td>
        <?php //echo CHtml::activeDropDownList($penerimaan, '[ii]alatmedis_id', CHtml::listData(STAlatmedisM::model()->findAll(),'alatmedis_id','alatmedis_nama'),array('style'=>'width:80px;')); ?>
        <?php echo CHtml::activeDropDownList($penerimaan, '[ii]barang_id', CHtml::listData(BarangM::model()->findAllByAttributes(array('barang_aktif'=>true,'jenisbarang_id'=>44)),'barang_id','barang_nama'),array('style'=>'width:80px;')); ?>
        <?php //echo CHtml::activeDropDownList($penerimaan, '[ii]alatmedis_id', CHtml::listData(STAlatmedisM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id)),'alatmedis_id','alatmedis_nama'),array('style'=>'width:80px;')); ?>
    </td>
	<?php if(!empty($penerimaan->sterilisasidetail_id)){ ?>
	<td>
		<ol type="1">
		<?php 
			$modSterilisasiBahan = STSterilisasibahanT::model()->findAllByAttributes(array('sterilisasidetail_id'=>$penerimaan->sterilisasidetail_id));
			foreach($modSterilisasiBahan as $a=>$bahan){ ?>
			<li><?php echo $bahan->bahansterilisasi->bahansterilisasi_nama; ?></li>
		<?php } ?>
			</ol>
	</td>
	<?php }else{ ?>
		<td>
			<div style="display:block;">
				<?php echo CHtml::activeDropDownList($penerimaan, '[ii]bahansterilisasi_nama', array(),array('class'=>'fcbkcomplete hide')); ?>
			</div>
		</td>
	<?php } ?>
	<td>
        <?php //echo CHtml::activeTextField($penerimaan, '[ii]kemasanygdigunakan',array('class'=>'span2')); ?>
        <?php echo CHtml::activeDropDownList($penerimaan, '[ii]kemasanygdigunakan', LookupM::getItems("kemasansterilisasi"),array('style'=>'width:80px;')); ?>
    </td>
	<td>
		<div class="input-append">
            <?php
            ?>
			<?php echo CHtml::activeTextField($penerimaan, '[ii]waktukadaluarsa', array('readonly'=>true,'class'=>'tanggal dtPicker2 datemask', 'style'=>'float:left;')); ?>
			<span class="add-on"><i class="entypo-calendar"></i></span>
		</div>
	</td>	
</tr>