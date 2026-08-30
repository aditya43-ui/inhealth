<style type="text/css">
    .author span {
        color: #eee;
        display: inline-block;
        padding: 3px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }

    .author span.todo {
        background: #6698D1;
    }

    .author span.done {
        background: #81D166;
    }

    .author span.duration {
        background: #005187;
    }
</style>
<div class="post" style="border-top:1px solid rgba(255, 255, 255, 0.1); padding-bottom:5px;">
    <div class="title">
        <?php //echo CHtml::link($data->judul, $this->createUrl('dialogView',array('id'=>$data->pengumuman_id)), array()); 
        ?>
        <?php //echo $data->judul; 
        ?>
    </div>
    <table>
        <tr>
            <td class="content">
                <?php
                $this->beginWidget('CMarkdown', array('purifyOutput' => true));
                echo $data->todolist_nama;
                $this->endWidget();
                ?>
            </td>
            <td class="author" style="width: 1%; white-space: nowrap; max-width:300px">
                <?php echo '<b><i><span class="duration">' . CustomFunction::hitungHari(date('Y-m-d H:m:s'), $data->tgltodolist) . ' Hari</span></i></b>'; ?>
                <b><i><?php echo ($data->todolist_aktif == true) ? '<span class="todo">Todo</span>' : '<span class="done">Done</span>'; ?></i></b>
            </td>
        </tr>
    </table>
    <div class="nav">
        Posted by : <?php echo '<span class="done">' . $data->userCreate->nama_pemakai . '</span>'; ?> / Due date : <?php echo MyFormatter::formatDateTimeForUser($data->tgltodolist); ?>
        <!--posted by--> <?php //echo $data->userCreate->nama_pemakai . ' on ' . date('F j, Y',strtotime($data->create_time)); 
                            ?>
        <!--Last updated on--> <?php //echo $data->update_time; 
                                ?>
        <!--|--> <span style='float:right'>
            <?php
            if ($data->todolist_aktif == true) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Klik untuk mengubah status', 'rel' => 'tooltip', 'class' => 'btn btn-mini btn-primary', 'onclick' => 'UbahStatusTodolist(' . $data->todolist_id . ');return false;'));
            }
            ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-pencil"></i>')), array('title' => 'Klik untuk mengubah todolist', 'rel' => 'tooltip', 'class' => 'btn btn-mini btn-primary', 'onclick' => '$(\'#dialog-ubah-todolist\').dialog(\'open\');setFormTodolist(' . $data->todolist_id . ');return false;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-remove icon-white"></i>')), array('title' => 'Klik untuk menghapus todolist', 'rel' => 'tooltip', 'class' => 'btn btn-mini btn-primary', 'onclick' => 'HapusTodolist(' . $data->todolist_id . ');')); ?>
        </span>
    </div>
</div>