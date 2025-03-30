# StreamPlus - Multi-step Registration System

StreamPlus is a modern web application that implements a multi-step registration system with user information, address details, and payment processing capabilities. Built with Symfony 6 and Bootstrap 5, it provides a seamless and secure user registration experience.

## Features

### User Registration
- Multi-step registration process
- User information collection
- Address information management
- Payment processing for premium subscriptions
- Form validation and data persistence

### Payment Processing
- Credit card validation using Luhn algorithm
- Real-time card type detection
- Dynamic CVV validation based on card type
- Secure payment information handling
- Automatic formatting for card numbers and expiration dates

### Security Features
- Input validation and sanitization
- Secure payment data handling
- Session-based data persistence
- Form validation at multiple levels

## Technical Stack

- **Framework**: Symfony 6
- **Frontend**: Bootstrap 5
- **Database**: MySQL/PostgreSQL
- **JavaScript**: Vanilla JS with modern features
- **Form Handling**: Symfony Forms
- **Validation**: Symfony Validator

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/stream_app.git
cd stream_app
```

2. Install dependencies:
```bash
composer install
```

3. Configure your database in `.env`:
```env
DATABASE_URL="mysql://user:password@127.0.0.1:3306/stream_app"
```

4. Create the database:
```bash
php bin/console doctrine:database:create
```

5. Run migrations:
```bash
php bin/console doctrine:migrations:migrate
```

6. Start the development server:
```bash
symfony server:start
```

## Project Structure

```
stream_app/
├── assets/
│   ├── css/
│   │   └── payment-form.css
│   └── js/
│       └── payment-form.js
├── src/
│   ├── Controller/
│   │   └── RegistrationController.php
│   ├── Entity/
│   │   ├── User.php
│   │   ├── Address.php
│   │   └── Payment.php
│   ├── Form/
│   │   ├── UserInformationType.php
│   │   ├── AddressInformationType.php
│   │   └── PaymentInformationType.php
│   └── Repository/
│       ├── UserRepository.php
│       ├── AddressRepository.php
│       └── PaymentRepository.php
└── templates/
    └── registration/
        ├── step1.html.twig
        ├── step2.html.twig
        ├── step3.html.twig
        ├── confirmation.html.twig
        └── success.html.twig
```

## Registration Flow

1. **Step 1: User Information**
   - Name
   - Email
   - Phone Number
   - Subscription Type (Free/Premium)

2. **Step 2: Address Information**
   - Address Line 1
   - Address Line 2 (Optional)
   - City
   - Postal Code
   - State/Province
   - Country

3. **Step 3: Payment Information** (Premium only)
   - Credit Card Number
   - Expiration Date
   - CVV
   - Card Holder Name

4. **Confirmation**
   - Review of all entered information
   - Final submission

## Development

### Code Style
The project follows PSR-12 coding standards. To check code style:
```bash
php vendor/bin/php-cs-fixer fix --dry-run
```

### Database Migrations
To create a new migration:
```bash
php bin/console doctrine:migrations:generate
```

To run migrations:
```bash
php bin/console doctrine:migrations:migrate
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- Symfony Framework
- Bootstrap Team
- All contributors and maintainers 