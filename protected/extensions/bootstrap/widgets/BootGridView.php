<?php
/**
 * BootGridView class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('zii.widgets.grid.CGridView');

/**
 * Bootstrap grid view widget.
 * Used for setting default HTML classes, disabling the default CSS and enable the bootstrap pager.
 */
class BootGridView extends CGridView
{
	/**
	 * @var string the CSS class name for the container table. Defaults to 'table'.
	 */
	public $itemsCssClass = 'table table-bordered table-striped table-condensed';
	/**
	 * @var string the CSS class name for the pager container.
	 * Defaults to 'pagination'.
	 */
	public $pagerCssClass = 'pagination';
	/**
	 * @var array the configuration for the pager.
	 * Defaults to <code>array('class'=>'ext.bootstrap.widgets.BootPager')</code>.
	 */
	public $pager = array('class'=>'bootstrap.widgets.BootPager');
	/**
	 * @var string the URL of the CSS file used by this detail view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;
    
    /**
     * @var string Batas maksimal dari berapa jumlah item yang ditampilkan
     * dalam suatu halaman tabel.
     * Batas default maksimal pada dropdown item muncul disetiap halaman 
     * adalah 1000 item perhalaman
     * 
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     */
    public $itemsPerPageLimit = 1000;
        
	/**
	 * @var string the CSS class name for the table row element containing all filter input fields. Defaults to 'filters'.
	 * @see filter
	 * @since 1.1.1
	 */
	public $filterCssClass='filters';
        
        public $pageSizeInput = true;
    
	/**
	 * Initializes the grid view.
	 * modified RND-5395
	 */
	public $items_perpage=10;
        public $dropdownItemKelipatan = 10;
        
	public function init()
	{
		if(isset($_GET[$this->dataProvider->modelClass."_items"])){
			$this->items_perpage = $_GET[$this->dataProvider->modelClass."_items"];
			$this->dataProvider->setPagination(array('pageSize' => $this->items_perpage));
		}
		parent::init();
	}
    /**
	 * Renders the summary text.
	 * RND-5395
	 */
	public function renderSummary()
	{
		if(($count=$this->dataProvider->getItemCount())<=0)
			return;

		echo '<div class="'.$this->summaryCssClass.'">';
		
		if($this->enablePagination)
		{
			if(($summaryText=$this->summaryText)===null){
//				$summaryText=Yii::t('zii','Displaying {start}-{end} of {count} result(s). {items_dropdown} rows per page.');
				$summaryText=Yii::t('zii','Menampilkan {start}-{end} dari {count} hasil. {items_dropdown}');
			}
			$pagination=$this->dataProvider->getPagination();
			$total=$this->dataProvider->getTotalItemCount();
			$start=$pagination->currentPage*$pagination->pageSize+1;
			$end=$start+$count-1;
			if($end>$total)
			{
				$end=$total;
				$start=$end-$count+1;
			}
                        
            $dropdown_count = $total;
            if ($dropdown_count > $this->itemsPerPageLimit) {
                $dropdown_count = $this->itemsPerPageLimit;
            }
            
			$items_dropdown = $this->pageSizeInput?CHtml::dropDownList($this->dataProvider->modelClass.'_items', $this->items_perpage, $this->getItemsPerPage($dropdown_count),array('onchange'=>'ubahSummaryEnd(this);','style'=>'width:70px', 'class'=>'page-item-size'))." baris per halaman.":"";
			echo strtr($summaryText,array(
				'{start}'=>$start,
				'{end}'=>$end,
				'{items_dropdown}'=>$items_dropdown,
				'{count}'=>$total,
				'{page}'=>$pagination->currentPage+1,
				'{pages}'=>$pagination->pageCount,
			));
		}
		else
		{
			if(($summaryText=$this->summaryText)===null)
				$summaryText=Yii::t('zii','Total {count} result(s).');
			echo strtr($summaryText,array(
				'{count}'=>$count,
				'{start}'=>1,
				'{end}'=>$count,
				'{page}'=>1,
				'{pages}'=>1,
			));
		}
		echo '</div>';
	}
	/**
	 * menampilkan summary end untuk dropdown
	 * RND-5395
	 * @param type $count
	 */
	public function getItemsPerPage($total){
		$data = array();
		if($total > 0){
			$total_round = ceil($total / $this->dropdownItemKelipatan);
			for($i=1;$i<=($total_round);$i++){
                            if ($i <= $this->dropdownItemKelipatan){
				$data[$i * $this->dropdownItemKelipatan] = $i * $this->dropdownItemKelipatan;
                            }
			}
		}else{
			$data[$total] = $total;
		}
		return $data;
	}
	
	/**
	 * Registers necessary client scripts.
	 * This method is invoked by {@link run}.
	 * Child classes may override this method to register customized client scripts.
	 * RND-5395
	 */
	public function registerClientScript()
	{
		parent::registerClientScript();
		Yii::app()->clientScript->registerScript("ubahSummaryEnd", 
<<<JAVASCRIPT
                var ubahSummaryEnd = function(obj) {
		//function ubahSummaryEnd(obj){
				var grid_id = $(obj).parent().parent().attr("id");
				$.fn.yiiGridView.update(grid_id, {
					data : $('#'+grid_id).find('.page-item-size, table > thead > tr > th input, table > thead > tr > th textarea, table > thead > tr > th select').serialize()
				});
				return false;
		}
JAVASCRIPT
		, CClientScript::POS_HEAD);
	}
        
        public function renderSummaryNonPage()
	{
		if(($count=$this->dataProvider->getItemCount())<=0)
			return;

		echo '<div class="'.$this->summaryCssClass.'">';
		
		if($this->enablePagination)
		{
			if(($summaryText=$this->summaryText)===null){
//				$summaryText=Yii::t('zii','Displaying {start}-{end} of {count} result(s). {items_dropdown} rows per page.');
				$summaryText=Yii::t('zii','Menampilkan {start}-{end} dari {count} hasil.');
			}
			$pagination=$this->dataProvider->getPagination();
			$total=$this->dataProvider->getTotalItemCount();
			$start=$pagination->currentPage*$pagination->pageSize+1;
			$end=$start+$count-1;
			if($end>$total)
			{
				$end=$total;
				$start=$end-$count+1;
			}
			echo strtr($summaryText,array(
				'{start}'=>$start,
				'{end}'=>$end,
				'{count}'=>$total,
				'{page}'=>$pagination->currentPage+1,
				'{pages}'=>$pagination->pageCount,
			));
		}
		else
		{
			if(($summaryText=$this->summaryText)===null)
				$summaryText=Yii::t('zii','Total {count} result(s).');
			echo strtr($summaryText,array(
				'{count}'=>$count,
				'{start}'=>1,
				'{end}'=>$count,
				'{page}'=>1,
				'{pages}'=>1,
			));
		}
		echo '</div>';
	}
	
}
