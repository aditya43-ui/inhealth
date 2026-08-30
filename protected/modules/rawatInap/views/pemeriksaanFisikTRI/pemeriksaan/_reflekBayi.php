<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
<i class="far fa-file-alt"></i> Reflek Bayi</div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <label class="control-label">Moro</label>
            <div class="controls">
                <?php echo $form->RadioButtonList($modPemeriksaanFisik, 'reflekbayi[Moro]', array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array(
                    'template'=>'<div class="radio-inline">{input}{label}</div>',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Darwinian</label>
            <div class="controls">
                <?php echo $form->RadioButtonList($modPemeriksaanFisik, 'reflekbayi[Darwinian]', array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array(
                    'template'=>'<div class="radio-inline">{input}{label}</div>',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tonic Neck</label>
            <div class="controls">
                <?php echo $form->RadioButtonList($modPemeriksaanFisik, 'reflekbayi[Tonic Neck]', array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array(
                    'template'=>'<div class="radio-inline">{input}{label}</div>',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Babkin</label>
            <div class="controls">
                <?php echo $form->RadioButtonList($modPemeriksaanFisik, 'reflekbayi[Babkin]', array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array(
                    'template'=>'<div class="radio-inline">{input}{label}</div>',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Babinski</label>
            <div class="controls">
                <?php echo $form->RadioButtonList($modPemeriksaanFisik, 'reflekbayi[Babinski]', array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array(
                    'template'=>'<div class="radio-inline">{input}{label}</div>',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Walking</label>
            <div class="controls">
                <?php echo $form->RadioButtonList($modPemeriksaanFisik, 'reflekbayi[Walking]', array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array(
                    'template'=>'<div class="radio-inline">{input}{label}</div>',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Rooting</label>
            <div class="controls">
                <?php echo $form->RadioButtonList($modPemeriksaanFisik, 'reflekbayi[Rooting]', array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array(
                    'template'=>'<div class="radio-inline">{input}{label}</div>',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Swimming</label>
            <div class="controls">
                <?php echo $form->RadioButtonList($modPemeriksaanFisik, 'reflekbayi[Swimming]', array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array(
                    'template'=>'<div class="radio-inline">{input}{label}</div>',
                )); ?>
            </div>
        </div>
    </div>
</div>