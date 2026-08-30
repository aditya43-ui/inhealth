<div class="row-fluid" id="dokter">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Pencarian</div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial($this->path_view . '_formPencarian', array('form' => $form)); ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel Suplesi Jasa Raharja</div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial($this->path_view . '_tabelSuplesi', array()); ?>
        </div>
    </div>
</div>