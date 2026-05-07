<?php
/**
 * MyCitySelector
 * @author Konstantin Kutsevalov
 * @version 2.0.0
 */

defined('_JEXEC') or die(header('HTTP/1.0 403 Forbidden') . 'Restricted access');


class MycityselectorControllerCountry extends Joomla\CMS\MVC\Controller\FormController
{
    public function save($key = null, $urlVar = null)
    {
        $jform = $this->input->post->get('jform', [], 'array');
        $task = $this->input->getCmd('task', 'country.save');
        $id = isset($jform['id']) ? (int) $jform['id'] : 0;
        $context = $this->option . '.edit.' . $this->context;
        $model = $this->getModel();

        if (!\Joomla\CMS\Session\Session::checkToken('post')) {
            $this->setMessage('Invalid token', 'error');
            $this->setRedirect(\Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=country&layout=edit&id=' . $id, false));
            return false;
        }

        if (!$this->allowSave($jform, $key) || !$this->checkEditId($context, $id)) {
            $this->setMessage('JERROR_ALERTNOAUTHOR', 'error');
            $this->setRedirect(\Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=country&layout=edit&id=' . $id, false));
            return false;
        }

        $result = $model->save($jform);
        $savedId = (int) ($model->getState('country.id') ?: $id);

        if (!$result) {
            $this->setMessage($model->getError() ?: 'Не удалось сохранить страну', 'error');
            $this->setRedirect(\Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=country&layout=edit&id=' . $id, false));
            return false;
        }

        $this->setMessage('Страна сохранена');

        if ($task === 'country.apply') {
            $this->setRedirect(\Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=country&layout=edit&id=' . $savedId, false));
            return true;
        }

        if ($task === 'country.save2new') {
            $this->setRedirect(\Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=country&layout=edit&id=0', false));
            return true;
        }

        $this->setRedirect(\Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=countries', false));

        return true;
    }

    public function apply($key = null, $urlVar = null)
    {
        if ($this->input->getCmd('task') !== 'country.apply') {
            $this->input->set('task', 'country.apply');
        }

        return $this->save($key, $urlVar);
    }

	/**
	 * Add new item
	 */
	public function add()
	{
		$document = Joomla\CMS\Factory::getDocument();
		$viewName   = $this->input->get('view', 'country');
		$viewFormat = $document->getType();
		$lName   = $this->input->get('layout', 'default', 'string');
		if ($view = $this->getView($viewName, $viewFormat))
		{
			$model = $this->getModel($viewName);
			$view->setModel($model, true);
			$view->setLayout($lName);
			$view->document = $document;
			$view->display();
		}
		return $this;
	}

}