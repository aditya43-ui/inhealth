<?php

Yii::import('bootstrap.widgets.BootGridView');
/**
* A Header Group Grid View that groups header columns
*
* @category       User Interface
* @package        extensions
* @author         Muhammad Farid Fadhlan <farid.fadhlan@gmail.com>
* @version        1.0
*/
class HeaderGroupGridView extends BootGridView {
	
	public $mergeHeaders = array();
	private $_mergeindeks = array();
	private $_nonmergeindeks = array();
	
	public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			echo "<table class=\"{$this->itemsCssClass}\">\n";
			if(!empty($this->mergeHeaders)){
				echo "<thead>\n";
				$this->renderGroupHeaders();
				echo "</thead>\n";
			}
			else {
				$this->renderTableHeader();
			}
			$this->renderTableBody();
			$this->renderTableFooter();
			echo "</table>";
		}
		else
			$this->renderEmptyText();
	}
	
	public function renderGroupHeaders()
	{
		$this->setMergeIndeks();
		$this->setNonMergeIndeks();
		echo "<tr>\n";
		
		ob_start();
		echo "<tr>\n";
		$i=0;
		foreach($this->columns as $column){
			if(in_array($i, $this->_mergeindeks)):
				$column->headerHtmlOptions['colspan']='1';
				$column->renderHeaderCell();
			endif;
			$i++;
		}
		echo "</tr>\n";
		$header_bottom = ob_get_clean();
		
		$i=0;
		foreach($this->columns as $column){			
			for($m=0;$m<count($this->mergeHeaders);$m++){
				if($i==$this->mergeHeaders[$m]["start"]):
					$column->headerHtmlOptions['colspan']=$this->mergeHeaders[$m]["end"]-$this->mergeHeaders[$m]["start"]+1;
					$column->header = $this->mergeHeaders[$m]["name"];
					$column->id = NULL;
					$column->renderHeaderCell();
				endif;
			}
			if(in_array($i, $this->_nonmergeindeks)){
				$column->headerHtmlOptions['rowspan']='2';
				$column->renderHeaderCell();
			}
			$i++;
		}
		echo "</tr>\n";
		
		echo $header_bottom;
	}
	
	protected function setMergeIndeks()
	{
		for($i=0;$i<count($this->mergeHeaders);$i++)
			for($j=$this->mergeHeaders[$i]["start"];$j<= $this->mergeHeaders[$i]["end"];$j++)
				$this->_mergeindeks[] = $j;
	}
	
	protected function setNonMergeIndeks()
	{
		foreach($this->columns as $key=>$val) $h[] = $key;
		$this->_nonmergeindeks = array_diff($h, $this->_mergeindeks);
	}
        
        public function renderTableFooter()
	{
		$hasFilter=$this->filter!==null && $this->filterPosition===self::FILTER_POS_FOOTER;
		$hasFooter=$this->getHasFooter();
                $data=$this->dataProvider->getData();
		$n=count($data)*200;
		if($hasFilter || $hasFooter)
		{
                    if($n > 0){
			echo "<tbody>\n";
			if($hasFooter)
			{
				echo "<tr>\n";
				foreach($this->columns as $column){
                                    if(($column->footer != null) || ($column->footer)){
                                        $jumlah = 0;
                                        $value = false;
                                        foreach ($data as $i=>$x){
                                            if ($column->footer == 'sum('.$column->name.')'){
                                                $jumlah += $x[$column->name];
                                                $value = true;
                                            }
                                        }
                                        if (($value == true)){
                                            $column->footer = "Rp".number_format($jumlah,0,"",".");
                                        }
					$column->renderFooterCell();
                                    }
                                }
				echo "</tr>\n";
			}
			if($hasFilter)
				$this->renderFilter();
			echo "</tbody>\n";
                    }
		}
	}
        
        /**
    * hidden tag
    */
//    public function renderKeys()
//    {
//            echo CHtml::openTag('div',array(
//                    'class'=>'keys',
//                    'style'=>'display:none',
//                    'title'=>Yii::app()->getRequest()->getUrl(),
//            ));
//            foreach($this->dataProvider->getKeys() as $key)
//                //    echo "<span>".CHtml::encode($key)."</span>";
//            echo "</div>\n";
//    }
}