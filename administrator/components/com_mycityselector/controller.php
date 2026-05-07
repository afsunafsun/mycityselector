<?php
/**
 * @package     MyCitySelector
 * @subpackage  com_mycityselector
 *
 */

defined('_JEXEC') or die;

/**
 * MyCitySelector Controller
 *
 * @since  2.0.38
 */
class MycityselectorController extends Joomla\CMS\MVC\Controller\BaseController
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setDispatcher(\Joomla\CMS\Factory::getApplication()->getDispatcher());
    }

	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController  This object to support chaining.
	 *
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$document = Joomla\CMS\Factory::getDocument();
        $viewName   = $this->input->get('view', 'countries');
        $viewFormat = $document->getType();
		$layoutName   = $this->input->get('layout', 'default', 'string');

		if ($view = $this->getView($viewName, $viewFormat))
		{
			$model = $this->getModel($viewName);
			$view->setModel($model, true);
			$view->setLayout($layoutName);
			$view->document = $document;
			$view->display();
		}
		return $this;
	}
}
