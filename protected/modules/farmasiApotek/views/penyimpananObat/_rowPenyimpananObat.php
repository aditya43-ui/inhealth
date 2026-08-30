<tr>

						<td> 
                            <?php  // echo CHtml::TextField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE))  ?>
                            <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>

                        </td>
						<td> 
                            <!-- <span name="[ii][ruangan_nama]"><?php // echo (!empty($modPenyimpanan->ruangan_id) ? $modPenyimpanan->ruangan->ruangan_nama : "") ?></span> -->
                            <span ><?php echo $modPenyimpanan->ruangan_nama ?? "-"; ?></span>
                            <?php  //echo $modPenyimpanan->ruangan_nama;  ?>
                            <?php echo CHtml::activeHiddenField($modPenyimpanan,'[ii]ruangan_id',array('readonly'=>true,'class'=>'span1 ruangan_id')); ?>
                        </td>
						<td>
                            <!-- <span name="[ii][rakobat_nama]"><?php // echo (!empty($modPenyimpanan->rakobat_id) ? $modPenyimpanan->rakobat_nama : "") ?></span> -->
                            <span ><?php echo $modPenyimpanan->rakobat_nama ?? "-"; ?></span>

                            <?php // echo $modPenyimpanan->rakobat_nama  ?>
                            <?php echo CHtml::activeHiddenField($modPenyimpanan,'[ii]rakobat_id',array('readonly'=>true,'class'=>'span1 rakobat_id')); ?>
                        </td>
						<td>
                            <!-- <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPenyimpanan->obatalkes_id) ? $modPenyimpanan->obatalkes_kode : "") ?></span> -->

                            <span><?php echo  $modPenyimpanan->obatalkes_kode ?? "-";?></span>

                            <?php // echo $modPenyimpanan->obatalkes_kode  ?>
                        </td>
						<td>
                        <!-- <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPenyimpanan->obatalkes_id) ? $modPenyimpanan->obatalkes_nama : "") ?></span> -->

                        <span><?php echo $modPenyimpanan->obatalkes_nama ?? "-"; ?></span>

                            <?php  // echo $modPenyimpanan->obatalkes_nama  ?>
                            <?php echo CHtml::activeHiddenField($modPenyimpanan,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1 obatalkes_id')); ?>
                        </td>
						<td> 
                            <?php echo  CHtml::link("<span class='icon-remove'>&nbsp;</span>", '', array('href' => '#', 'onclick' => 'remove(this);return false;', 'style' => 'text-decoration:none;', 'class' => 'cancel')) ?>
                        </td> 
					  </tr>