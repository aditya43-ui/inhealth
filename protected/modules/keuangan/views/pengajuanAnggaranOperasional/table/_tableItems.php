<?php
/**
*
*
* - digunakan untuk menampilkan tabel detail items
*
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>

<table id="table-lookup" class="table table-bordered dataTable">
                <thead>
                        <th style="text-align:center;">Nama Pengajuan Anggaran <span class="required">*</span></th>
                        <th style="text-align:center; width:10%;">Jumlah <span class="required">*</span></th>
                        <th style="text-align:center; width:15%;">Harga Satuan <span class="required">*</span></th>
                        <th style="text-align:center;">Keterangan  </th>
                        <th style="text-align:center; width:15%;">Subtotal <span class="required">*</span></th>
                        <th style="text-align:center;color:#FFF;"><?php echo CHtml::link('<i class="'.MyIcon::getIcons('tambah-baris').'"></i>', 'javascript:;', array('class'=>'btn btn-primary white','onclick'=>'tambahLookup();', "data-toggle"=>"tooltip", "data-placement"=>"bottom", "title"=>"", "data-original-title"=>"Klik Icon ini, untuk menambahkan data <b>detail</b>", "data-html" => true)); ?></th>
                </thead>
                <tbody>
                    <?php
						$det = KUPengajuanpettydetT::model()->findAllByAttributes(array('pengajuanpetty_id'=>$model->pengajuanpetty_id));
                        if (!empty($det)){
                                $i = 0;
                                foreach($det as $postDetail){
                                    $dt = new KUPengajuanpettydetT;

									echo $this->renderPartial($this->path_view.'form._formItems',array('model'=>$dt, 'i'=>$i));
									$i++;
                                }
                        }
                    ?>
                </tbody>
                <tfoot>
                    <th colspan="4"style="text-align: right;">Total <span class="required">*</span></th>
                    <th>
                        <div class="control-group">
                        Rp <?php echo $form->textField($model,'pengajuanpetty_total', array('class'=>'form-control span2 totPoin required integer2','readonly'=>true, 'style'=>'text-align:right;')) ?>
                        </div>
                    </th>
					<th>&nbsp;</th>
                </tfoot>
</table>
