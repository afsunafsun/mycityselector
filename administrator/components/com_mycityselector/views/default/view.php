<?php
/**
 * @package     MyCitySelector
 * @subpackage  com_mycityselector
 *
 */

defined('_JEXEC') or die;

JLoader::register('MycityselectorHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers'  . DIRECTORY_SEPARATOR . 'mycityselector.php');

/**
 * Mycityselector Default View
 *
 * @since
 */
class MycityselectorViewDefault extends Joomla\CMS\MVC\View\HtmlView
{

	/**
	 * Display the view.
	 *
	 * @param   string  $tpl  Template
	 *
	 * @return  void
	 *
	 * @since   1.5
	 */
	public function display($tpl = null)
	{
		// Get data from the model.
		$state = $this->get('State');

		// Are there messages to display?
		$showMessage = false;

		if (is_object($state))
		{
			$message1    = $state->get('message');
			$message2    = $state->get('extension_message');
			$showMessage = ($message1 || $message2);
		}

		$this->showMessage = $showMessage;
		$this->state       = &$state;

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		$canDo = Joomla\CMS\Helper\ContentHelper::getActions('com_mycityselector');
		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::preferences('com_mycityselector');
			\Joomla\CMS\Toolbar\ToolbarHelper::divider();
		}

		// Render side bar.
		$this->sidebar = \Joomla\CMS\HTML\Helpers\Sidebar::render();
	}

}
