Hotel Room Booking System for Joomla

This is a hotel room reservation/booking system built for Joomla 5. It allows hotel managers to manage rooms and bookings through the admin interface and provides a booking form for users on the frontend. It includes essential features such as room listing, availability checking, and booking management.
Features

    Room Management: Admins can add, edit, and delete room details.
    Booking Management: Admins can view and manage bookings.
    Room Availability Check: Users can check the availability of rooms.
    Booking Form: Users can book rooms by providing their details.
    Email Notifications: Confirmation emails are sent to both users and admins upon booking.
    Customizable: Easy to customize and extend the system as per your needs.

Files Included

    Backend (Admin):
        hotelbooking.xml: Installation configuration file.
        provider.php: Provides the booking provider logic.
        room.xml: Room configuration file.
        install.mysql.utf8.sql: SQL script for creating required tables in the database.
        RoomModel.php, RoomsModel.php: Models for managing room data.
        RoomTable.php: Table management for room data.
        RoomController.php: Controller for managing room-related actions.
        HtmlView.php, default.php: View files for rendering admin views.

    Frontend (Site):
        RoomsModel.php, RoomModel.php: Models for displaying rooms and booking data on the site.
        BookingModel.php: Handles the booking form submission logic.
        HtmlView.php, default.php: Frontend views for displaying rooms and managing bookings.

