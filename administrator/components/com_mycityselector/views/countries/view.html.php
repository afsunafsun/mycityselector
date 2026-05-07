<?php
/**
 * @package     MyCitySelector
 * @subpackage  com_mycityselector
 *
 */

defined('_JEXEC') or die;

JLoader::register('MycityselectorViewDefault', dirname(__DIR__) . '/default/view.php');

/**
 * MyCitySelector Countries View
 *
 * @since  1.5
 */
class MycityselectorViewCountries extends MycityselectorViewDefault
{
	public function display($tpl = null)
	{
//		// Run discover from the model.
//		if (!$this->checkExtensions())
//		{
//			$this->getModel('discover')->discover();
//		}

		// Get data from the model.
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->total         = $this->get('Total');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}
		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		//$state = $this->get('State');
		$canDo = \Joomla\CMS\Helper\ContentHelper::getActions('com_mycityselector');
		//$user  = \Joomla\CMS\Factory::getUser();

		// Get the toolbar object instance
		//$bar = JToolbar::getInstance('toolbar');

		\Joomla\CMS\Toolbar\ToolbarHelper::title(\Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_NAME'), 'big-ico');

		if ($canDo->get('core.create'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::addNew('country.add');
		}

		if ($canDo->get('core.edit'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::editList('country.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::publish('countries.publish', 'JTOOLBAR_PUBLISH', true);
			\Joomla\CMS\Toolbar\ToolbarHelper::unpublish('countries.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}

		if ($canDo->get('core.delete'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'countries.delete', 'JTOOLBAR_REMOVE');
		}

		if ($canDo->get('core.admin'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::preferences('com_mycityselector');
		}


//		$this->sidebar = MycityselectorHelper::getSidebar($this->_name);
        $this->sidebar = null; // TODO больше не нужно в j4
	}


}
