<?php
/**
* - digunakan untuk menampilkan tabel detail items
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>

<table id="table-lookup" class="table table-bordered dataTable">
                <thead>
				<th style="text-align:center;"><?php echo CHtml::checkBox('pilihsemua',true, array('onchange'=>'pilihSemua(this);')); ?>Pilih</th>
                        <th style="text-align:center;">Nama Perusahaan/ Barang <span class="required">*</span></th>
						<th style="text-align:center;">Qty <span class="required">*</span></th>                            						                        
                        <th style="text-align:center;width:15%;">Harga Satuan <span class="required">*</span></th>						                        						
						<th style="text-align:center;">Keterangan  </th>                            						                        
						<th style="text-align:center;">Subtotal <span class="required">*</span></th>                            						                                                
                </thead>
                <tbody>
                    <?php 			
						$det = KUPengajuanpettydetT::model()->findAllByAttributes(array('pengajuanpetty_id' => $model->pengajuanpetty_id));			
                        if (!empty($det)){
							$i = 0;
							
							foreach($det as $postDetail){
								$dt = new KUPengpettydetR();
								$dt->pengajuanpetty_id = $postDetail->pengajuanpetty_id;
								$dt->pengajuanpettydet_id = $postDetail->pengajuanpettydet_id;
								$dt->pengajuanpettydet_item = $postDetail->pengajuanpettydet_item;
								$dt->pengajuanpettydet_qty = $postDetail->pengajuanpettydet_qty;
								$dt->pengajuanpettydet_hargasatuan = $postDetail->pengajuanpettydet_hargasatuan;
								$dt->pengajuanpettydet_subtotal = $postDetail->pengajuanpettydet_subtotal;
								$dt->pengajuanpettydet_keterangan = $postDetail->pengajuanpettydet_keterangan;
								
								echo $this->renderPartial($this->path_view.'form._formItemsApp',array('model'=>$dt, 'i'=>$i));
								$i++;                                    
							}
                        }                        
                    ?>                    
                </tbody>
                <tfoot>
                    <th colspan="5"style="text-align: right;">Jumlah <span class="required">*</span></th>
                    <th>
                        <div class="control-group">
                        <?php echo $form->textField($model,'pengajuanpetty_total', array('class'=>'form-control totPoin required integer2','readonly'=>true, 'style'=>'text-align:right;')) ?>
                        </div>
                    </th>   
					<th>&nbsp;</th>
                </tfoot>
</table>																	
