<?php
/**
* @author          Yusuf Putra Anugrah<yusufputra@.com>, M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version         2.0.0
* @documentation   http://kbase..com
* @issue           RSST-1341
* - digunakan inv tab kalibrasi  
*/
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'data-m-grid',
		'dataProvider'=>$model->searchdata(),
	
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-condensed',
		'columns'=>array(
                ////'triase_id',
            array(
                'header'=>'No.',
                'value' => '($this->grid->dataProvider->pagination) ? 
                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                : ($row+1)',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),

            array(
                'header'=>'Tanggal Kalibrasi',
                'name'=>'tglkalibrasi',
                'value'=>function($data){
                    $format = new MyFormatter();
                    return $format->formatDateTimeForUser($data->tglkalibrasi);
                }
            ),
              array(
                'header'=>'Berlaku Sampai',
                'name'=>'berlaku_sdtgl',
                'value'=>function($data){
                    $format = new MyFormatter();
                    return $format->formatDateTimeForUser($data->berlaku_sdtgl);
                }
            ),


             array(

               'name'=>'supplier_id',
                'header'=>'Data Vendor Pemeliharaan',
                'value'=>function($data) {
                $modul = SupplierM::model()->findByPk($data->supplier_id);
                if (!empty($modul)){
                return $modul->supplier_nama;}
                }),

            array(

               'header'=>'Pelaksana',
                'value'=>function($data) {
                        $load_det = MAInvkalibrasidetT::model()->findAll(" invkalibrasi_id = ".$data->invkalibrasi_id." ");

                        if (!empty($load_det)){
                            echo "<ol>";
                            foreach($load_det as $det){
                                echo "<li>".$det->nama_pegawai."</li>";
                            }
                            echo "</ol>";
                        }
                }
            ),

            array(

               'header'=>'Keterangan',
               'name'=>'invkalibrasi_ket',
                'value'=>function($data) {
                      return $data->invkalibrasi_ket;  
                }),

             array(
                 'header'=>'Dokumen',
                 'type'=>'raw',
                 'value'=>function($data){
//                        return (!empty($data->lampiran_berkas."<br>") ? CHtml::link($data->lampiran_berkas,$this->createUrl('Unduh',array('id'=>$data->invkalibrasi_id)),array('title'=>'Download dokumen 1','rel'=>'tooltip'))."<br>" : "");                                          
                    if (!empty($data->lampiran_berkas)){
                        $path = Params::pathKalibrasiPdfDirectory() . $data->lampiran_berkas;

                        if (file_exists($path)) {
                            if (strpos($data->lampiran_berkas,'.pdf') !== false){
                                echo CHtml::link($data->lampiran_berkas, Params::urlKalibrasiPdfDirectory().$data->lampiran_berkas,array('title'=>'Download document','rel'=>'tooltip','target'=>'_BLANK'));
                            }else{
                                echo CHtml::link($data->lampiran_berkas,$this->createUrl('Unduh',array('id'=>$data->invkalibrasi_id)),array('title'=>'Download document','rel'=>'tooltip'));
                            }                                            
                        }else{
                            echo CHtml::link($data->lampiran_berkas,$this->createUrl('Unduh',array('id'=>$data->invkalibrasi_id)),array('title'=>'Download document','rel'=>'tooltip'));
                        }                                        
                    }                                                                        
                 }
             ),
             array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->invkalibrasi_id)?CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->invkalibrasi_id)",array("id"=>"$data->invkalibrasi_id","rel"=>"tooltip","title"=>"Hapus Kalibrasi")):CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->invkalibrasi_id)",array("id"=>"$data->invkalibrasi_id","rel"=>"tooltip","title"=>"Hapus Kalibrasi"));',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
            ),        
),

)); ?>