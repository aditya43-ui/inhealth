<div class="post">
    <div class="title">
        <?php echo CHtml::link($data->judul, $this->createUrl('dialogView', array('id' => $data->pengumuman_id)), array()); ?>
        <?php //echo $data->judul; 
        ?>
    </div>
    <div class="author">
        Posted by <?php echo $data->userCreate->nama_pemakai . ' on ' . $data->create_time; ?>
    </div>
    <div class="content">
        <?php
        $this->beginWidget('CMarkdown', array('purifyOutput' => true));
        echo $data->isi;
        $this->endWidget();
        ?>
    </div>
    <div class="nav">
        Last updated on <?php echo $data->update_time; ?> /
        <?php
        if (Yii::app()->user->checkAccess('Atur Pengumuman'))
            echo CHtml::link('Update', $this->createUrl('update', array('id' => $data->pengumuman_id, 'inFrame' => $inFrame)), array());
        ?>
    </div>
</div>