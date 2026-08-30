<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>     
<?php $i = 1; ?>
<br>
        <?php foreach($menitke as $row){ ?>
            
Menit Ke-<?php echo $row->menitke; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kriteria</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        
        <?php $score = PSApgarscoreT::model()->findAllByAttributes(array('kelahiranbayi_id'=>$noid, 'menitke'=>$row->menitke)); ?>
        <?php $i = 1; ?>
        <?php foreach($score as $row2){ ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo PSMetodeapgarM::model()->findByAttributes(array('metodeapgar_id'=>$row2->metodeapgar_id))->kriteria; ?></td>
                <?php $nilai = 'nilai_'.$row2->nilai_apgar;?>
                <td><?php echo PSMetodeapgarM::model()->findByAttributes(array('metodeapgar_id'=>$row2->metodeapgar_id))->$nilai; ?></td>
                
  
                <?php $i++; ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<br>
<?php } ?>