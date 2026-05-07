<?php
/**
 * @package     MyCitySelector
 * @subpackage  com_mycityselector
 *
 */

defined('_JEXEC') or die;

JLoader::register('MycityselectorViewDefault', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'view.php');

/**
 * MyCitySelector Countries View
 *
 * @since  1.5
 */
class MycityselectorViewCountry extends MycityselectorViewDefault
{
	public function display($tpl = null)
	{
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');

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
		\Joomla\CMS\Toolbar\ToolbarHelper::title(\Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_NAME') . ' - ' . \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ITEM_ADDING'), 'big-ico');
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('country.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('country.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2new('country.save2new');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('country.cancel');

		//$state = $this->get('State');
		$canDo = \Joomla\CMS\Helper\ContentHelper::getActions('com_mycityselector');
		//$user  = \Joomla\CMS\Factory::getUser();

		// Get the toolbar object instance
		//$bar = JToolbar::getInstance('toolbar');

		\Joomla\CMS\Toolbar\ToolbarHelper::title(\Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_NAME'), 'big-ico');

		if ($canDo->get('core.admin'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::preferences('com_mycityselector');
		}


		$this->sidebar = MycityselectorHelper::getSidebar($this->_name);

	}


}
