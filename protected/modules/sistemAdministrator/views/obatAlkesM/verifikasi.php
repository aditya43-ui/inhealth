
        <div class="row-fluid form-horizontal">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        'obatalkes.obatalkes_nama',
                        'sumberdana.sumberdana_nama',
                        'loginpemakai_id',
                        'tglperubahan',
                    ),
            )); ?>
            
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        'harganettoasal',
                        'hargajualasal',
                        'harganettoperubahan',
                        'hargajualperubahan',
                    ),
            )); ?>
            </div>
            <div class="clear"></div>
            <div class="col-sm-12">
                <div class="control-group">
                    <label class="control-label required">Alasan Perubahan <span class="required">*</span></label>                               
                    <div class="controls">
                        <?php echo CHtml::textArea('alasanperubahan','',array('onblur'=>'setAlasan()')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required">Disetujui Oleh <span class="required">*</span></label>                               
                    <div class="controls">
                        <?php 
                        
                        $pengguna = Yii::app()->user->nama_pemakai;
                        if (!empty(Yii::app()->user->getState('pegawai_id'))) {
                            $pengguna = Yii::app()->user->getState('nama_pegawai');
                        }
                        
                        
                        echo CHtml::textField('disetujuioleh', $pengguna, array('onblur'=>'setAlasan()')); ?>
                    </div>
                </div>
            </div>
        </div>
    
   
