<div class="panel panel-success panel-shadow panel-spesimen">
    <div class="panel-heading">
        <?php
        $tambah = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick'=>'tambahSpesimen(this);return false;'));
        $hapus = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-minus icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick'=>'batalSpesimen(this);return false;'));
        ?>
        <div class="panel-title"><span class='judul'><b>Data Spesimen</b>&nbsp;&nbsp;&nbsp;&nbsp;<?= $tambah ?>&nbsp;&nbsp;<?= $hapus ?></span></div>
    </div>
    <div class="panel-body" id="form-spesimen">
        <div class="row-fluid">
            <?php
            $modSpesimen = new MKSpesimenT;
            $this->renderPartial($this->path_view_spesimen.'_formLoadSpesimenDetail', array(
                'modSpesimen' => $modSpesimen, 'i' => 0
            ));
            ?>
        </div>
    </div>
</div>