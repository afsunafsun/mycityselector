<?php

use joomx\mcs\plugin\helpers\McsData;


class MycityselectorHelper
{

	public static function getSidebar($vName = 'countries')
    {
		// menu items for left sidebar
		foreach (MycityselectorHelper::sidebarMenuItems() as $action => $name) {
		    if (isset($_GET['db_replacement'])) {
                $_isActive = (stripos($action, 'db_replacement') !== false);
            } else {
                $_isActive = ($vName === $action);
            }
			\Joomla\CMS\HTML\Helpers\Sidebar::addEntry($name, 'index.php?option=com_mycityselector&task=default&view=' . $action, $_isActive);
		}
		return \Joomla\CMS\HTML\Helpers\Sidebar::render();
	}


	static function sidebarMenuItems()
	{
		$sidebar = [
			'countries' => \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_COUNTRIES'), //'country'
			'provinces' => \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_PROVINCES'),
			'cities' => \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_CITIES'),
			'fields' => \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_FIELDS')
		];
//        if (McsData::get('experimental_mode', 0)) {
//            $sidebar['fields&db_replacement=1'] = \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_DB_REPLACEMENTS');
//        }
		if (Joomla\CMS\Factory::getConfig()->get('debug') == 1) {
			$sidebar['dev'] = 'DEV TOOLS';
		}
		return $sidebar;
	}

}