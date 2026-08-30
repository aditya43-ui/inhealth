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
                        <th style="text-align:center;">Nilai Poin <span class="required">*</span></th>
                        <th style="text-align:center;width:15%;">Poin <span class="required">*</span></th>						
                        <th style="text-align:center;">Keterangan</th>                            						                        
                        <th style="text-align:center;color:#FFF;"><?php echo CHtml::link('<i class="'.MyIcon::getIcons('tambah-baris').'"></i>', 'javascript:;', array('class'=>'btn btn-primary white','onclick'=>'cekTglHukum();', "data-toggle"=>"tooltip", "data-placement"=>"bottom", "title"=>"", "data-original-title"=>"Klik Icon ini, untuk menambahkan data <b>poin pegawai</b>", "data-html" => true)); ?></th>
                </thead>
                <tbody>
                    <?php 
                        if (isset($det)){
                                $i = 0;
                                foreach($det as $key => $postDetail){
                                    $dt = new KPPoinpegdetR;
                                    $dt->attributes = $det[$key];                                    
                                    if (isset($det[$key])){
                                        echo $this->renderPartial($this->path_view.'form._formItems',array('model'=>$dt, 'i'=>$i));
                                        $i++;
                                    }
                                 
                                }
                        }                        
                    ?>                    
                </tbody>
                <tfoot>
                    <th colspan="1"style="text-align: right;">Total Poin <span class="required">*</span></th>
                    <th>
                        <div class="control-group">
                        <?php echo $form->textField($model,'poinpegawai_totpoin', array('class'=>'form-control totPoin required','readonly'=>true, 'style'=>'text-align:right;')) ?>
                        </div>
                    </th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tfoot>
</table>																	
