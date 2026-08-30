<?php
$profil = ProfilrumahsakitM::model()->find();
?>
<div class="control-group">
    <?php echo $form->labelEx($model, 'terapipulang', array('class' => 'control-label')) ?><br>
    <div class="controls" style="width:100%">
        <?php echo $form->textArea($model, 'terapipulang', array('rows' => 4, 'id' => 'terapipulang')) ?>
    </div>
</div>


<div class="control-group">
    <div class="controls">
        <?= $form->checkBox($model, 'sudahmendapatpenjelasan', ['id' => 'sudahmendapatpenjelasan']) ?> <label for="sudahmendapatpenjelasan">Sudah mendapat penjelasan</label>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <?= $form->checkBox($model, 'akseslink', ['id' => 'akseslink']) ?> <label for="akseslink">Akses link <?= $profil->website ?>/kerohanian.pdf</label>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <?= $form->checkBox($model, 'menerimsalinanformulir', ['id' => 'menerimsalinanformulir']) ?> <label for="menerimsalinanformulir">Menerima salinan formulir</label>
    </div>
</div>