<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> <b>Riwayat Surat Eligibilitas Peserta (SEP)</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_tab', array('riwayat'=>true), true); ?>
        <?php echo $this->renderPartial('riwayat/_search', array(), true); ?>
        <br/>
        <?php echo $this->renderPartial('riwayat/_detailPanel', array(), true); ?>
    </div>
</div>


