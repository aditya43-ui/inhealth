<div class ="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Pencarian <i class="<?php echo MyIcon::getIcons('cari'); ?>"></i>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">File</label>
                <div class="controls">
                    <?php echo CHtml::dropDownList('extFile', '', 
                            array('mp3'=>'mp3','ogg'=>'ogg')
                        ,array('class' => 'span3','onchange'=>'refreshFile();')); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Nama File</label>
                <div class="controls">
                    <?php echo CHtml::textField('namaFile', '',array('class'=>'span3' ,'onblur'=>'refreshFile();','onkeypress'=>'return $(this).focusNextInputField(event)')
                        ); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">        
                <div class="controls">
                    <label>Info :</label>
                </div>
            </div>
            <div class="control-group">        
                <div class="controls">
                    <?php echo CHtml::link(Params::JENIS_KELAMIN_LAKI_LAKI, 'javascript:;',array('class'=>'span3 btn btn-primary nohover' ,)
                        ); ?>
                </div>
            </div>
            <div class="control-group">        
                <div class="controls">
                    <?php echo CHtml::link(Params::JENIS_KELAMIN_PEREMPUAN, 'javascript:;',array('class'=>'span3 btn btn-success nohover' ,)
                        ); ?>
                </div>
            </div>
        </div>
    </div>
</div>