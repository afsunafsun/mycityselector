<?php

defined('_JEXEC') or die;

\JLoader::import('citycase', dirname(__FILE__));
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('text');

class JFormFieldCityCase5 extends JFormFieldCityCase
{
	protected $type = "CityCase5";
	protected $caseId = 5;

	// Творительный падеж
	protected $case = \morphos\Cases::ABLATIVE;

}