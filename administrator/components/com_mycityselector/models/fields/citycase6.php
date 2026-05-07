<?php

defined('_JEXEC') or die;

\JLoader::import('citycase', dirname(__FILE__));
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('text');

class JFormFieldCityCase6 extends JFormFieldCityCase
{
	protected $type = "CityCase6";
	protected $caseId = 6;

	// Предложный падеж
	protected $case = \morphos\Cases::PREPOSITIONAL;

}