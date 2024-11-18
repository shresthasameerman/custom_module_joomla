<?php
namespace HotelBooking\Component\Hotelbooking\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Factory;

class RoomModel extends AdminModel
{
    public function getTable($name = 'Room', $prefix = 'Table', $options = [])
    {
        return parent::getTable($name, $prefix, $options);
    }

    public function getForm($data = [], $loadData = true)
    {
        $form = $this->loadForm(
            'com_hotelbooking.room',
            'room',
            [
                'control' => 'jform',
                'load_data' => $loadData
            ]
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        $app = Factory::getApplication();
        $data = $app->getUserState('com_hotelbooking.edit.room.data', []);

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }
}