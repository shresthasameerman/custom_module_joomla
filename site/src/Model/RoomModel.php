<?php
namespace HotelBooking\Component\Hotelbooking\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\Factory;

class RoomModel extends ItemModel
{
    protected function populateState()
    {
        $app = Factory::getApplication();
        $pk = $app->input->getInt('id');
        $this->setState('room.id', $pk);

        parent::populateState();
    }

    public function getItem($pk = null)
    {
        $pk = $pk ?: $this->getState('room.id');

        if ($this->_item === null) {
            $this->_item = false;

            $db = $this->getDbo();
            $query = $db->getQuery(true);

            $query->select('r.*, GROUP_CONCAT(ri.image_path) as images')
                  ->from($db->quoteName('#__hotelbooking_rooms', 'r'))
                  ->leftJoin(
                      $db->quoteName('#__hotelbooking_room_images', 'ri')
                      . ' ON ' . $db->quoteName('ri.room_id') . ' = ' . $db->quoteName('r.id')
                  )
                  ->where($db->quoteName('r.id') . ' = ' . (int) $pk)
                  ->group($db->quoteName('r.id'));

            $db->setQuery($query);

            if ($data = $db->loadObject()) {
                $this->_item = $data;
                
                // Convert images string to array
                if (!empty($this->_item->images)) {
                    $this->_item->images = explode(',', $this->_item->images);
                } else {
                    $this->_item->images = array();
                }
            }
        }

        return $this->_item;
    }
}