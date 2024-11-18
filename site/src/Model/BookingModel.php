<?php
namespace HotelBooking\Component\Hotelbooking\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Date\Date;

class BookingModel extends BaseDatabaseModel
{
    public function saveBooking($data)
    {
        $db = $this->getDbo();
        $user = Factory::getUser();
        
        // Calculate total price
        $checkIn = new Date($data['check_in']);
        $checkOut = new Date($data['check_out']);
        $nights = floor(($checkOut->toUnix() - $checkIn->toUnix()) / (60 * 60 * 24));
        
        $room = $this->getRoom($data['room_id']);
        $totalPrice = $nights * $room->base_price;

        $booking = (object) [
            'room_id' => $data['room_id'],
            'user_id' => $user->id,
            'guest_name' => $data['guest_name'],
            'guest_email' => $data['guest_email'],
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'created' => Factory::getDate()->toSql(),
            'payment_status' => 'pending'
        ];

        if (!$db->insertObject('#__hotelbooking_bookings', $booking)) {
            throw new \Exception('Could not save booking');
        }

        return $db->insertid();
    }

    protected function getRoom($roomId)
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__hotelbooking_rooms'))
            ->where($db->quoteName('id') . ' = ' . (int) $roomId);
        
        $db->setQuery($query);
        return $db->loadObject();
    }
}