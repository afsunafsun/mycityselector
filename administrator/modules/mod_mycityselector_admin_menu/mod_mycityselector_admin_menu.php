<?php
defined ('_JEXEC') or die ('restricted access');

use Joomla\CMS\Helper\ModuleHelper;

require ModuleHelper::getLayoutPath('mod_mycityselector_admin_menu', $params->get('layout', 'default'));
