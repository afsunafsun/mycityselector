<?php

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormHelper;

\JLoader::import('citycase', dirname(__FILE__));
FormHelper::loadFieldClass('text');

class JFormFieldCityCase2 extends JFormFieldCityCase
{
	protected $type = "CityCase2";
	protected $caseId = 2;

	// Родительный падеж
	protected $case = \morphos\Cases::GENETIVE;

}