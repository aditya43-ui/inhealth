<div id="faskes">
    <?php $this->renderPartial($this->path_view . '_formPencarian', array('form' => $form)); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Kabupaten / Kota</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <?php $this->renderPartial($this->path_view . '_tabel', array()); ?>
        </div>
    </div>
</div>