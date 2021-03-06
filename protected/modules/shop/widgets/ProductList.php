<?php
namespace shop\widgets;

use Yii;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

class ProductList extends ListView
{
	public $layout = "{toolbar}\n{items}\n{pager}";

	public $itemOptions = ['class'=>'col-md-4'];

	/**
	 * path to the view file to render product list toolbar
	 * @var string
	 */
	public $toolbarView;

	/**
	 * param name in query for sort
	 * @var string
	 */
	protected $sortVar = 'sort';

	/**
	 * param name in query for page size
	 * @var string
	 */
	protected $limitVar = 'limit';

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$this->getView()->registerJs(sprintf("app.setupProductList('#%s');", $this->id));
		$this->applySort();
		$this->applyLimit();
		return parent::run();
	}

	/**
	 * @inheritdoc
	 */
	public function renderSection($name) {
		switch ($name) {
			case '{toolbar}':
				return $this->renderToolbar();
			default:
				return parent::renderSection($name);
		}
	}

	/**
	 * Renders toolbar (sorter and page size)
	 * @return string the rendering result
	 */
	public function renderToolbar() {
		if (!$this->toolbarView) return;

		if (is_string($this->toolbarView)) {
			$content = $this->getView()->render($this->toolbarView, [
				'widget' => $this,
			]);
		} else {
			$content = call_user_func($this->itemView, $this);
		}
		return $content;
	}

	/**
	 * Renders all data models.
	 * @return string the rendering result
	 */
	public function renderItems() {
		return Html::tag('div', parent::renderItems(), ['class'=>'row']);
	}

	public function getSortOptions() {
		return [
			'new' => Yii::t('shop', 'Newest'),
			'cheap' => Yii::t('shop', 'Price (Low > High)'),
			'expensive' => Yii::t('shop', 'Price (High > Low)'),
			// 'discount' => Yii::t('shop', 'Discount'),
			// 'bestseller' => Yii::t('shop', 'Best Seller'),
		];
	}

	public function getSortDropdownItems() {
		$result = [];
		foreach($this->getSortOptions() as $val => $label) {
			$url = Url::current([$this->sortVar => $val, 'page'=>null]);
			$result[] = [
				'url' => $url,
				'label' => $label,
				'selected' => $val == $this->getSort()
			];
		}
		return $result;
	}

	public function getSort() {
		return Yii::$app->request->getQueryParam($this->sortVar);
	}

	public function applySort() {
		$query = $this->dataProvider->query;
		switch ($this->getSort()) {
			case 'new':
				$query->addOrderBy('available_time DESC');
				break;
			case 'cheap':
				$query->addOrderBy('price ASC');
				break;
			case 'expensive':
				$query->addOrderBy('price DESC');
				break;
			case 'discount':
				// nimp
				break;
			case 'bestseller':
				// nimp
				break;
		}
	}

	public function getLimitOptions() {
		return [
			15 => 15,
			25 => 25,
			50 => 50,
			40 => 75,
			100 => 100,
		];
	}

	public function getLimitDropdownItems() {
		$result = [];
		foreach($this->getLimitOptions() as $val => $label) {
			$url = Url::current([$this->limitVar => $val, 'page'=>null]);
			$result[] = [
				'url' => $url,
				'label' => $label,
				'selected' => $val == $this->getLimit()
			];
		}
		return $result;
	}

	public function getLimit() {
		$default = array_keys($this->getLimitOptions())[0];
		return Yii::$app->request->getQueryParam($this->limitVar, $default);
	}

	public function applyLimit() {
		if ($this->dataProvider->pagination) {
			$this->dataProvider->pagination->defaultPageSize = $this->getLimit();
		}
	}
}
