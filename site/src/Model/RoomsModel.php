<?php
namespace HotelBooking\Component\Hotelbooking\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
class RoomsModel extends ListModel
{
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = [
                'r.id',
                'r.title',
                'r.capacity',
                'r.base_price',
                'r.status'
            ];
        }

        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select required fields
        $query->select('r.*, GROUP_CONCAT(DISTINCT ri.image_path) as images')
              ->from($db->quoteName('#__hotelbooking_rooms', 'r'))
              ->leftJoin(
                  $db->quoteName('#__hotelbooking_room_images', 'ri') 
                  . ' ON ' . $db->quoteName('ri.room_id') . ' = ' . $db->quoteName('r.id')
              )
              ->where($db->quoteName('r.state') . ' = 1')
              ->where($db->quoteName('r.status') . ' = ' . $db->quote('available'))
              ->group($db->quoteName('r.id'));

        // Filter by capacity if set
        $capacity = $this->getState('filter.capacity');
        if (!empty($capacity)) {
            $query->where($db->quoteName('r.capacity') . ' >= ' . (int) $capacity);
        }

        // Add ordering
        $orderCol = $this->state->get('list.ordering', 'r.title');
        $orderDirn = $this->state->get('list.direction', 'ASC');
        $query->order($db->escape($orderCol . ' ' . $orderDirn));

        return $query;
    }

    public function getAvailableRooms($checkIn, $checkOut, $capacity = null)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select('r.*')
              ->from($db->quoteName('#__hotelbooking_rooms', 'r'))
              ->where($db->quoteName('r.state') . ' = 1')
              ->where($db->quoteName('r.status') . ' = ' . $db->quote('available'));

        // Exclude rooms that are already booked for the selected dates
        $query->where('NOT EXISTS (
            SELECT 1 FROM ' . $db->quoteName('#__hotelbooking_bookings', 'b') . '
            WHERE b.room_id = r.id
            AND b.status = ' . $db->quote('confirmed') . '
            AND (
                (b.check_in <= ' . $db->quote($checkIn) . ' AND b.check_out >= ' . $db->quote($checkIn) . ')
                OR
                (b.check_in <= ' . $db->quote($checkOut) . ' AND b.check_out >= ' . $db->quote($checkOut) . ')
                OR
                (b.check_in >= ' . $db->quote($checkIn) . ' AND b.check_out <= ' . $db->quote($checkOut) . ')
            )
        )');

        if ($capacity) {
            $query->where($db->quoteName('r.capacity') . ' >= ' . (int) $capacity);
        }

        $db->setQuery($query);
        return $db->loadObjectList();
    }
}