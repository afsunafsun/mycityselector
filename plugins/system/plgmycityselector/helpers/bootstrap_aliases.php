<?php

/**
 * Class aliases for templates / legacy snippets that reference short class names.
 *
 * @package  MyCitySelector
 * @license  GPL-2.0-or-later
 */

defined('_JEXEC') or exit(header('HTTP/1.0 404 Not Found') . '404 Not Found');

JLoader::registerAlias('McsData', '\\joomx\\mcs\\plugin\\helpers\\McsData', '6.0');
JLoader::registerAlias('McsContentHelper', '\\joomx\\mcs\\plugin\\helpers\\McsContentHelper', '6.0');
JLoader::registerAlias('McsLog', '\\joomx\\mcs\\plugin\\helpers\\McsLog', '6.0');
