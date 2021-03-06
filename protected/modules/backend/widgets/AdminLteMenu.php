<?php
namespace backend\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Menu
 */
class AdminLteMenu extends AuthMenu
{
	public $options = ['class'=>'sidebar-menu'];

	public $labelTemplate = '<a href="#">{icon} {label} {right}</a>';

	public $linkTemplate ='<a href="{url}">{icon} {label} {right}</a>';

	public $submenuTemplate = '<ul class="treeview-menu">{items}</ul>';
	
	public $activateParents = true;
	
	/**
	 * @var string
	 */
	public $parentRightIcon = 'fa fa-angle-left pull-right';

	/**
	 * @inheritdoc
	 */
	protected function renderItem($item)
	{
		$template = ArrayHelper::getValue( $item, 'template', 
			isset($item['url']) ? $this->linkTemplate : $this->labelTemplate );
		
		$url = isset($item['url']) ? Url::to($item['url']) : '';
		
		$icon = Html::tag('i', '', ['class'=>isset($item['icon']) ? $item['icon'] : 'fa fa-angle-double-right']);

		$rightHtml = '';
		if (isset($item['items'])) {
			$rightHtml = Html::tag('i', '', ['class'=>$this->parentRightIcon]);
		}

		if (isset($item['badge'])) {
			$rightHtml = $item['badge'];
		}

		$rightHtml = $rightHtml ? 
			sprintf('<span class="pull-right-container">%s</span>', $rightHtml)
			: '';
		
		$label = Html::tag('span', $item['label']);
		return strtr($template, [
			'{icon}'=> $icon,
			'{right}'=> $rightHtml,
			'{url}' => $url,
			'{label}' => $label,
		]);
	}
}
