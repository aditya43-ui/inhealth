<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><b> Pasal Perjanjian Kerja </b></div>
    </div>
    <div class="panel-body">
        <div class="control-group ">
            <?php 

            $pasal = PasalperjanjianM::model()->findAll('pasalperjanjian_aktif = true order by pasalperjanjian_nama');
            $listPasal = CHtml::listData($pasal, 'pasalperjanjian_id', 'pasalperjanjian_nama');
            $option = array();

            foreach ($pasal as $item) {
                $option[$item->pasalperjanjian_id] = array(
                    'data-uraian'=>$item->pasalperjanjian_uraian,
                    'data-isi'=>$item->pasalperjanjian_isi,
                );
            }

            echo CHtml::label("Nama Pasal Perjanjian","nama_pasal", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('nama_pasal', 'nama_pasal', $listPasal, array(
                'empty'=>'-- Pilih --',
                'readonly'=>false, 
                'class'=>'span3',
                'onchange'=>'setFormPasal()',
                'options'=>$option,
                )); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Uraian Pasal Perjanjian","uraian", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('uraian', '', array(
                'readonly'=>true, 
                'class'=>'span3',
                'onblur'=>'return false;',
                )); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Isi Pasal Perjanjian","isi_pasal", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('ext.redactorjs.Redactor',array(
                    'name'=>'isi_pasal',
                    'toolbar'=>'mini',
                    'height'=>'200px', 
                    'htmlOptions' => array('placeholder' => 'Ketikkan Catatan Atas Laporan Keuangan')
                )) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo CHtml::htmlButton('<i class="glyphicon glyphicon-plus"></i>', array(
                    'class'=>'btn btn-green',
                    'onclick'=>'tambahPasal();',
                )); ?>
                
            </div>
        </div>
        
        
    </div>
    
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pasal Perjanjian</th>
                    <th>Uraian Pasal Perjanjian</th>
                    <th>Isi Pasal Perjanjian</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody id="tab_pasal">
                <?php
                    $pasal = SuratperjanjiankerjadetT::model()->findAllByAttributes(array(
                        'suratperjanjiankerja_id'=>$model->suratperjanjiankerja_id,
                    ));
                    
                    foreach ($pasal as $idx=>$item) {
                        echo $this->renderPartial('_rowPasalSubmit', array(
                            'item'=>$item,
                            'no'=>$idx+1,
                        ), true);
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>