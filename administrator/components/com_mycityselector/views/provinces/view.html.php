<?php
/**
 * @package     MyCitySelector
 * @subpackage  com_mycityselector
 *
 */

defined('_JEXEC') or die;

JLoader::register('MycityselectorViewDefault', dirname(__DIR__) . '/default/view.php');

/**
 * MyCitySelector Provinces View
 *
 * @since  1.5
 */
class MycityselectorViewProvinces extends MycityselectorViewDefault
{
	public function display($tpl = null)
	{
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
			\Joomla\CMS\Toolbar\ToolbarHelper::addNew('province.add');
		}

		if ($canDo->get('core.edit'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::editList('province.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::publish('provinces.publish', 'JTOOLBAR_PUBLISH', true);
			\Joomla\CMS\Toolbar\ToolbarHelper::unpublish('provinces.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}

		if ($canDo->get('core.delete'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'provinces.delete', 'JTOOLBAR_REMOVE');
		}

		if ($canDo->get('core.admin'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::preferences('com_mycityselector');
		}


//		$this->sidebar = MycityselectorHelper::getSidebar($this->_name);
		$this->sidebar = null;

	}


}
