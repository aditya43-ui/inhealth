<div class="row">
    <div class="col-md-12">
    	<div class="panel panel-gradient">
        	<div class="panel-heading">
        		<div class="panel-title">Pengaturan Master Dietetics & Nutrition Terminology (IDNT) </div>
        	</div>
        	<div class="panel-body">
                <?php 
                    $this->breadcrumbs=array(
                            'Master Gizi',
                        );
                ?>
                <?php 
                    $this->renderPartial($this->path_view.'_tabMenu',array());
                    $this->renderPartial($this->path_view.'_jsFunctions',array());
                ?>
                <div>
                <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;">
                </iframe>
                </div>
        	</div>
    	</div>
    </div>
</div>