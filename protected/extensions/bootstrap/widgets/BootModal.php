<?php
/**
 * BootModal class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.3
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap modal widget.
 */
class BootModal extends BootWidget
{
	public $autoOpen = false;
	public $config = array();
	/**
	 * @var boolean indicates whether the modal should use transitions. Defaults to 'true'.
	 */
	public $fade = true;
	/**
	 * @var array the options for the Bootstrap Javascript plugin.
	 */
	public $options = array();
	/**
	 * @var string[] the Javascript event handlers.
	 */
	public $events = array();
	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();
	/**
	 * Initializes the widget.
	 */
	 
	public function init()
	{
            Yii::app()->bootstrap->registerModal();
            Yii::app()->bootstrap->enableTransitions();
            
            if (!isset($this->htmlOptions['id']))
                    $this->htmlOptions['id'] = $this->getId();

            if ($this->autoOpen === false && !isset($this->options['show']))
                    $this->options['show'] = false;

            $classes = array('modal');

		if ($this->fade === true)
			$classes[] = 'fade';

		if (!empty($classes))
		{
			$classes = implode(' ', $classes);
			if (isset($this->htmlOptions['class']))
				$this->htmlOptions['class'] .= ' '.$classes;
			else
				$this->htmlOptions['class'] = $classes;
		}

		echo CHtml::openTag('div', $this->htmlOptions);
                if(isset($this->config['header']))
                {
                    echo '<div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3>'. $this->config['header'] .'</h3></div>';
                    echo '<div class="modal-body">';
                }
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$id = $this->htmlOptions['id'];
                echo '</div>';
                if(isset($this->config['footer']))
                {
                    echo '<div class="modal-footer">';
                        echo '<a class="btn btn-info" data-dismiss="modal" href="#">Tutup</a>';
                    echo '</div>';                    
                }
                
		echo '</div>';

		/** @var CClientScript $cs */
		$cs = Yii::app()->getClientScript();

		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
		$cs->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').modal({$options});");

		foreach ($this->events as $name => $handler)
		{
			$handler = CJavaScript::encode($handler);
			$cs->registerScript(__CLASS__.'#'.$id.'_'.$name, "jQuery('#{$id}').on('{$name}', {$handler});");
		}
                Yii::app()->clientScript->registerScript('set_margin_' . $id,"
                    $(document).ready(function(){
                        function set_margin(){
                            var width_screen = $(window).width();
                            var width_modal = $('#$id').width();
                            var margin = (width_screen - width_modal);
                            $('#{$id}').attr('style', 'left:'+margin+'px;width:'+width_modal+'px');
                        }
                        set_margin();
                    });
                ");
	}
	/*
	public function init()
	{
		parent::init();

		Yii::app()->bootstrap->registerModal();

		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' modal';
		else
			$this->htmlOptions['class'] = 'modal';

		if (Yii::app()->bootstrap->isPluginRegistered(Bootstrap::PLUGIN_TRANSITION))
			$this->htmlOptions['class'] .= ' fade';

		echo CHtml::openTag('div', $this->htmlOptions).PHP_EOL;
	}

	/**
	 * Runs the widget.
	 */
	 /*
	public function run()
	{
		echo '</div>';

		// Register the "show" event-handler.
		if (isset($this->events['show']))
		{
			$fn = CJavaScript::encode($this->events['show']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.show',
					"jQuery('#{$this->id}').on('show', {$fn});");
		}

		// Register the "shown" event-handler.
		if (isset($this->events['shown']))
		{
			$fn = CJavaScript::encode($this->events['shown']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.shown',
					"jQuery('#{$this->id}').on('shown', {$fn});");
		}

		// Register the "hide" event-handler.
		if (isset($this->events['hide']))
		{
			$fn = CJavaScript::encode($this->events['hide']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.hide',
					"jQuery('#{$this->id}').on('hide', {$fn});");
		}

		// Register the "hidden" event-handler.
		if (isset($this->events['hidden']))
		{
			$fn = CJavaScript::encode($this->events['hidden']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.hidden',
					"jQuery('#{$this->id}').on('hidden', {$fn});");
		}
	}*/
}
