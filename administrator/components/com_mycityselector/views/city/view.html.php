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
class MycityselectorViewCity extends MycityselectorViewDefault
{
	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->state = $this->get('State');
        $errors = $this->get('Errors');
		if (count($errors)) {
			throw new Exception(implode("\n", $errors), 500);
		}
		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		\Joomla\CMS\Toolbar\ToolbarHelper::title(\Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_NAME') . ' - ' . \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ITEM_ADDING'), 'big-ico');
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('city.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('city.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2new('city.save2new');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('city.cancel');
		$canDo = \Joomla\CMS\Helper\ContentHelper::getActions('com_mycityselector');
		\Joomla\CMS\Toolbar\ToolbarHelper::title(\Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_NAME'), 'big-ico');
		if ($canDo->get('core.admin')) {
			\Joomla\CMS\Toolbar\ToolbarHelper::preferences('com_mycityselector');
		}
		$this->sidebar = MycityselectorHelper::getSidebar($this->_name);
	}

}
