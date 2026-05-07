<?php
/**
 * @package     MyCitySelector
 * @subpackage  com_mycityselector
 *
 */

defined('_JEXEC') or die;

JLoader::register('MycityselectorViewDefault', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'view.php');

/**
 * MyCitySelector City View
 *
 * @since  1.5
 */
class MycityselectorViewField extends MycityselectorViewDefault
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
		$canDo = \Joomla\CMS\Helper\ContentHelper::getActions('com_mycityselector');

		\Joomla\CMS\Toolbar\ToolbarHelper::title(\Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_NAME') . ' - ' . \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ITEM_ADDING'), 'big-ico');
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('field.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('field.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2new('field.save2new');
		if ($canDo->get('core.delete'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'fieldvalue.delete', 'COM_MYCITYSELECTOR_REMOVE_FIELDS');
		}
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('field.cancel');

		$canDo = \Joomla\CMS\Helper\ContentHelper::getActions('com_mycityselector');

		\Joomla\CMS\Toolbar\ToolbarHelper::title(\Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_NAME'), 'big-ico');

		if ($canDo->get('core.admin'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::preferences('com_mycityselector');
		}

		$this->sidebar = MycityselectorHelper::getSidebar($this->_name);

	}


}
