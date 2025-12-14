# Pungutin

**Pungutin** is a web-based waste collection and recycling management system built with Laravel and MySQL.

## Overview

Pungutin enables users to request waste pickups and track their status in real-time, while providing administrators with tools to manage staff assignments, vehicle fleets, collection batches, and transaction records. The system features role-based access control with separate interfaces for end users, staff members, and administrators.

Designed with operational efficiency in mind, it streamlines the coordination of waste collection logistics from request submission through pickup completion and disposal tracking.

## Features

### For Users
- Request waste pickups with scheduling options
- Track pickup status in real-time
- View transaction history and earned points
- Manage personal profile and addresses

### For Staff (Petugas)
- View assigned pickup tasks and batches
- Update pickup status and collection details
- Manage daily pickup routes
- Record waste collection data

### For Administrators
- Manage users, staff, and waste categories
- Assign and monitor pickup teams
- Track vehicle fleet status and availability
- Organize pickups into optimized batches
- View comprehensive dashboard analytics
- Generate transaction and performance reports

## Technology Stack

- **Framework:** Laravel
- **Database:** MySQL
- **Frontend:** Blade Templates, Bootstrap 5
- **JavaScript:** Chart.js for data visualization
- **Authentication:** Laravel Sanctum
- **CSS:** Custom dark theme with CSS variables

## Installation

1. Clone the repository:
```bash
git clone https://github.com/RadenYv/Pungutin.git
cd Pungutin
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pungut_in
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Run migrations and seeders:
```bash
php artisan migrate --seed
```

6. Build assets:
```bash
npm run dev
```

7. Start the development server:
```bash
php artisan serve
```

## User Roles

The system supports three distinct user roles:

- **Admin:** Full system access and management capabilities
- **Petugas (Staff):** Pickup operations and field task management
- **User:** Waste pickup requests and tracking

## License

This project is open-source software.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Contact

For questions or support, please open an issue on GitHub.

