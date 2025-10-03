# Event Booking API

<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License"></a>
<a href="#"><img src="https://img.shields.io/badge/PHP-8.0+-%23777BB4" alt="PHP Version"></a>
<a href="#"><img src="https://img.shields.io/badge/Laravel-10.x-%23FF2D20" alt="Laravel Version"></a>
</p>

## Event Booking API

A robust RESTful API for managing events, tickets, bookings, and payments. Built with Laravel, this API provides a complete solution for event management with support for multiple user roles, ticket management, and payment processing.

## Features

- **User Authentication & Authorization**
  - **Sanctum-based authentication**
  - Role-based access control (Admin, Organizer, Customer)
  - User registration and profile management

- **Event Management**
  - Create, read, update, and delete events
  - Filter and search events by date, location, and keywords
  - Event details with available tickets

- **Ticket Management**
  - Create and manage ticket types for events
  - Set pricing, quantity, and sale periods
  - Track ticket availability

- **Booking System**
  - Secure booking process
  - Prevent double booking
  - Booking history and management

- **Payment Processing**
  - Mock payment gateway integration
  - Payment status tracking
  - Receipt generation

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js & NPM (for frontend assets if needed)
- Redis (for caching and queue)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/KatiaVela/Task.git
   
   cd Task/event-booking
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies** (if needed)
   ```bash
   npm install
   ```

4. **Create and configure .env file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Update your `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=event_booking
   DB_USERNAME=your_db_username
   DB_PASSWORD=your_db_password
   ```

6. **Run database migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Generate JWT secret**
   ```bash
   php artisan key:generate
   ```

8. **Storage link**
   ```bash
   php artisan storage:link
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## API Documentation

### Authentication
All endpoints except `/register` and `/login` require authentication. Include the JWT token in the `Authorization` header:
```
Authorization: Bearer your_jwt_token_here
```

### Available Endpoints

#### Auth
- `POST /register` - Register a new user
- `POST /login` - Authenticate user and get JWT token
- `POST /logout` - Invalidate the current token
- `GET /me` - Get authenticated user's profile

#### Events
- `GET /events` - List all events (with pagination and filters)
- `GET /events/{id}` - Get event details
- `POST /events` - Create a new event (Organizer only)
- `PUT /events/{id}` - Update an event (Organizer only)
- `DELETE /events/{id}` - Delete an event (Organizer only)

#### Tickets
- `POST /events/{event_id}/tickets` - Create a ticket type (Organizer only)
- `PUT /tickets/{id}` - Update a ticket (Organizer only)
- `DELETE /tickets/{id}` - Delete a ticket (Organizer only)

#### Bookings
- `POST /tickets/{id}/bookings` - Create a booking (Customer only)
- `GET /bookings` - List user's bookings (Customer only)
- `PUT /bookings/{id}/cancel` - Cancel a booking (Customer only)

#### Payments
- `POST /bookings/{id}/payment` - Process payment for a booking (Customer only)
- `GET /payments/{id}` - Get payment details

## Testing

Run the test suite with:
```bash
php artisan test
```

## Environment Variables

- `APP_ENV` - Application environment
- `APP_DEBUG` - Enable/disable debug mode
- `APP_URL` - Application URL
- `DB_*` - Database configuration
- `JWT_SECRET` - JWT authentication secret
- `MAIL_*` - Email configuration
- `QUEUE_CONNECTION` - Queue driver (redis recommended)

## Security

- All passwords are hashed using bcrypt
- JWT for secure authentication
- CSRF protection
- Rate limiting on authentication endpoints
- Input validation on all endpoints

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support, please open an issue in the GitHub repository.

---

Built with ❤️ using Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.
