# Donation/Charity Website

A modern, responsive donation platform built with PHP, MySQL, and Bootstrap. Features secure online donations, campaign management, and a comprehensive admin panel.

## Features

### Frontend
- **Home Page**: Hero banner, impact statistics, featured campaigns, testimonials
- **Campaigns Listing**: Browse all active donation campaigns
- **Campaign Details**: View campaign information and donate
- **Donation Form**: Secure donation submission with optional payment proof upload
- **About Page**: Information about the charity and mission
- **Contact Page**: Contact form with email functionality
- **Thank You Page**: Confirmation after donation

### Admin Panel
- **Dashboard**: Overview of donations, donors, and statistics
- **Campaign Management**: Add, edit, delete campaigns with image uploads
- **Donation Management**: View, filter, approve/reject donations
- **Export Functionality**: Export donations to CSV
- **Settings**: Change admin password

## Security Features

- ✅ SQL Injection Prevention (PDO Prepared Statements)
- ✅ CSRF Protection (Token-based)
- ✅ XSS Sanitization (Input validation and output escaping)
- ✅ Secure File Uploads (Type validation, size limits, secure storage)
- ✅ Password Hashing (bcrypt via password_hash)
- ✅ Session Management (Secure session handling)

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled (for clean URLs)

## Installation

1. **Clone or extract the project** to your web server directory (e.g., `htdocs/donation`)

2. **Create the database**:
   ```sql
   mysql -u root -p < database.sql
   ```
   Or import `database.sql` using phpMyAdmin

3. **Configure database connection**:
   Edit `config/database.php` if your database credentials differ:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'donation');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

4. **Set permissions**:
   ```bash
   chmod 755 uploads/
   chmod 644 config/database.php
   ```

5. **Access the website**:
   - Frontend: `http://localhost/donation/`
   - Admin Panel: `http://localhost/donation/admin/login.php`

## Default Admin Credentials

- **Email**: `admin@donation.com`
- **Password**: `admin123`

**⚠️ Important**: Change the default password immediately after first login!

## Project Structure

```
donation/
├── admin/                 # Admin panel
│   ├── includes/         # Admin header/footer
│   ├── campaigns.php     # Campaign management
│   ├── donations.php     # Donation management
│   ├── dashboard.php     # Admin dashboard
│   └── settings.php      # Admin settings
├── assets/               # Static assets
│   ├── css/             # Stylesheets
│   └── js/              # JavaScript files
├── config/              # Configuration files
│   └── database.php     # Database connection
├── includes/            # Common PHP includes
│   ├── functions.php    # Utility functions
│   ├── header.php       # Site header
│   └── footer.php       # Site footer
├── uploads/             # Uploaded files (create this directory)
├── index.php            # Home page
├── campaigns.php        # Campaigns listing
├── campaign.php         # Single campaign view
├── donate.php           # Donation form
├── about.php            # About page
├── contact.php          # Contact page
├── thank-you.php        # Thank you page
├── process_donation.php # Process donation
├── process_contact.php  # Process contact form
├── database.sql         # Database schema
└── README.md           # This file
```

## Database Schema

### Tables

- **admins**: Admin users
- **campaigns**: Donation campaigns
- **donations**: Donation records

See `database.sql` for complete schema.

## File Uploads

- Upload directory: `uploads/`
- Allowed types: Images (JPG, PNG, GIF, WebP) and PDF
- Max file size: 5MB
- Files are stored with unique names to prevent conflicts

## Customization

### Change Site Name
Edit the brand name in `includes/header.php`:
```php
<a class="navbar-brand">DonateNow</a>
```

### Update Contact Email
Edit `process_contact.php`:
```php
$to = 'your-email@example.com';
```

### Modify Styling
Edit `assets/css/style.css` for frontend styles
Edit `assets/css/admin.css` for admin panel styles

## Security Notes

1. **Change default admin password** immediately
2. **Use HTTPS** in production
3. **Set proper file permissions** (755 for directories, 644 for files)
4. **Keep PHP updated** to latest stable version
5. **Regular backups** of database and files
6. **Configure email** properly for contact form (consider using SMTP)

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

This project is open source and available for use.

## Support

For issues or questions, please check the code comments or create an issue in the repository.

---

**Built with ❤️ for making a difference**

