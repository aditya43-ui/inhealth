<?php
/**
 * untuk menampilkan side menu
 */
Yii::import('zii.widgets.CMenu');
class MySideMenu extends CMenu 
{
        const ASSETS_NAME='/my-side-menu/my-side-menu';
        public $header = array("label"=>"Dashboard", "url"=>"javascript:void(0);", "headerHtmlOptions"=>array());

        /**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
            $this->renderMenu($this->items);
            $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
            Yii::app()->getClientScript()->registerCssFile($assets.self::ASSETS_NAME.'.css');
            Yii::app()->getClientScript()->registerScriptFile($assets.self::ASSETS_NAME.'.js',CClientScript::POS_END);
	}
        /**
	 * Renders the menu items.
	 * @param array $items menu items. Each menu item will be an array with at least two elements: 'label' and 'active'.
	 * It may have three other optional elements: 'items', 'linkOptions' and 'itemOptions'.
	 */
	protected function renderMenu($items)
	{
		if(count($items))
		{
			echo CHtml::openTag('div',$this->htmlOptions)."\n";
			echo CHtml::openTag('ul')."\n";
                            echo CHtml::openTag('li')."\n";
                            echo CHtml::link("<span>".$this->header['label']."</span>",$this->header['url'],isset($this->header['headerHtmlOptions']) ? $this->header['headerHtmlOptions'] : array());
                            echo CHtml::closeTag('li');
			$this->renderMenuRecursive($items);
			echo CHtml::closeTag('ul');
			echo CHtml::closeTag('div');
		}
	}

	/**
	 * Recursively renders the menu items.
	 * @param array $items the menu items to be rendered recursively
	 */
	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
                        $item['linkOptions'] = isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$options=$item['linkOptions'];
			$class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}
                        if(isset($item['items'])){
                            $options = array('class'=>'has-sub');
                        }
			echo CHtml::openTag('li', $options);
                        $item['linkOptions'] = isset($this->linksMenuClass) ? array('class'=>$this->linksMenuClass) : $item['linkOptions'];
			$menu=$this->renderMenuItem($item);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

			if(isset($item['items']) && count($item['items']))
			{
				echo "\n".CHtml::openTag('ul',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
				$this->renderMenuRecursive($item['items']);
				echo CHtml::closeTag('ul')."\n";
			}

			echo CHtml::closeTag('li')."\n";
		}
	}

	/**
	 * Renders the content of a menu item.
	 * Note that the container and the sub-menus are not rendered here.
	 * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
	 * @return string
	 * @since 1.1.6
	 */
	protected function renderMenuItem($item)
	{
		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : '<'.$this->linkLabelWrapper.'>'.$item['label'].'</'.$this->linkLabelWrapper.'>';
			return CHtml::link("<span>".$label."</span>",$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
		}
		else{
                        $label=$this->linkLabelWrapper===null ? $item['label'] : '<'.$this->linkLabelWrapper.'>'.$item['label'].'</'.$this->linkLabelWrapper.'>';
//			$class = "";
//                        if(isset($item[items])){
//                            $class = "class='has-sub'";
//                        }
                        return CHtml::link("<span>".$label."</span>","javascript:void(0);",isset($item['linkOptions']) ? $item['linkOptions'] : array());
//                        $returnhtml .= "\n".CHtml::openTag('li',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
//				$this->renderMenuRecursive($item['items']);
//				echo CHtml::closeTag('li')."\n";
//                        return $returnhtml;
                }
	}
}

?>
