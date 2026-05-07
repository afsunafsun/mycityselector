<?php

defined('_JEXEC') or die;

class MycityselectorModelFieldvalue extends Joomla\CMS\MVC\Model\AdminModel
{

    public function getForm($data = [], $loadData = true)
    {
        $form = $this->loadForm('com_mycityselector.fieldvalue', 'fieldvalue', ['control' => 'jform', 'load_data' => $loadData]);
        return $form;
    }


    public function getTable($name = 'Fieldvalue', $prefix = 'Table', $options = [])
    {
        return parent::getTable($name, $prefix, $options);
    }


    protected function loadFormData()
    {
        // Check the session for previously entered form data.
		$data = Joomla\CMS\Factory::getApplication()->getUserState('com_mycityselector.edit.fieldvalue.data', []);
        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }


    public function save($data)
    {
        // Joomla 6: initialize model state before save, so id state is populated correctly after store().
        $this->getState();

        if (!parent::save($data))
        {
            return false;
        }

        $fieldValueId = (int) $this->getState($this->getName() . '.id');

        if ($fieldValueId <= 0)
        {
            $fieldValueId = (int) ($data['id'] ?? 0);
        }

        if ($fieldValueId <= 0)
        {
            $fieldValueId = (int) $this->getDatabase()->insertid();
        }

        if ($fieldValueId <= 0)
        {
            $this->setError('Не удалось определить ID сохраненного значения поля.');
            return false;
        }

        $this->syncLocationLinks('#__mycityselector_value_city', 'city_id', $fieldValueId, $data['cities'] ?? []);
        $this->syncLocationLinks('#__mycityselector_value_province', 'province_id', $fieldValueId, $data['provinces'] ?? []);
        $this->syncLocationLinks('#__mycityselector_value_country', 'country_id', $fieldValueId, $data['countries'] ?? []);

        return true;
    }

    private function syncLocationLinks($tableName, $locationField, $fieldValueId, $values)
    {
        $db = Joomla\CMS\Factory::getDbo();

        $query = $db->getQuery(true)
            ->delete($tableName)
            ->where('field_value_id = ' . (int) $fieldValueId);
        $db->setQuery($query)->execute();

        $ids = $this->normalizeLocationValues($values);

        if (empty($ids))
        {
            return;
        }

        $query = $db->getQuery(true)
            ->insert($tableName)
            ->columns(['field_value_id', $locationField]);

        foreach ($ids as $locationId)
        {
            $query->values((int) $fieldValueId . ',' . (int) $locationId);
        }

        $db->setQuery($query)->execute();
    }

    private function normalizeLocationValues($values)
    {
        if (is_string($values))
        {
            $values = trim($values);
            $values = $values === '' ? [] : explode(',', $values);
        }
        elseif (!is_array($values))
        {
            $values = [$values];
        }

        return array_values(array_unique(array_filter(array_map('intval', $values))));
    }


    public function delete(&$pks)
    {
        if (parent::delete($pks))
        {
            if (!empty($pks))
            {
                $db = Joomla\CMS\Factory::getDbo();
                $query = $db->getQuery(true);
                $query->delete('#__mycityselector_value_city')
                    ->where('field_value_id IN (' . implode(',', $pks) . ')');
                $db->setQuery($query)->execute();

                $query = $db->getQuery(true);
                $query->delete('#__mycityselector_value_province')
                    ->where('field_value_id IN (' . implode(',', $pks) . ')');
                $db->setQuery($query)->execute();

                $query = $db->getQuery(true);
                $query->delete('#__mycityselector_value_country')
                    ->where('field_value_id IN (' . implode(',', $pks) . ')');
                $db->setQuery($query)->execute();

                return true;
            }
            else
            {
                return true;
            }
        }
    }

}