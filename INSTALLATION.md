# Quick Installation Guide

## Step 1: Database Setup

1. Open phpMyAdmin or MySQL command line
2. Import the `database.sql` file:
   ```sql
   mysql -u root -p donation < database.sql
   ```
   Or use phpMyAdmin's Import feature

3. Verify the database was created with these tables:
   - `admins`
   - `campaigns`
   - `donations`

## Step 2: Configure Database Connection

Edit `config/database.php` if your credentials differ:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'donation');
define('DB_USER', 'root');
define('DB_PASS', '');
```

## Step 3: Set File Permissions

On Linux/Mac:
```bash
chmod 755 uploads/
chmod 644 config/database.php
```

On Windows, ensure the `uploads/` folder has write permissions.

## Step 4: Access the Website

- **Frontend**: `http://localhost/donation/`
- **Admin Panel**: `http://localhost/donation/admin/login.php`

## Step 5: Login to Admin Panel

Default credentials:
- **Email**: `admin@donation.com`
- **Password**: `admin123`

**⚠️ IMPORTANT**: Change the password immediately after first login!

## Step 6: Create Your First Campaign

1. Login to admin panel
2. Go to "Campaigns" → "Add New Campaign"
3. Fill in the details and upload an image
4. Save the campaign

## Troubleshooting

### Database Connection Error
- Check database credentials in `config/database.php`
- Ensure MySQL service is running
- Verify database `donation` exists

### File Upload Not Working
- Check `uploads/` folder permissions (should be writable)
- Verify PHP `upload_max_filesize` and `post_max_size` settings
- Check server error logs

### Admin Login Not Working
- Clear browser cookies/session
- Verify admin exists in database:
  ```sql
  SELECT * FROM admins;
  ```
- Reset password if needed (use password_hash in PHP)

### Path Issues
If you're not using `/donation/` as the base path:
- Update all paths in `includes/header.php` and `includes/footer.php`
- Update paths in admin files
- Or configure your web server to use `/donation/` as document root

## Next Steps

1. Customize the site name and branding
2. Update contact email in `process_contact.php`
3. Configure email settings (consider SMTP for production)
4. Add your own campaigns and content
5. Test the donation flow end-to-end

## Production Deployment

Before going live:
- ✅ Change default admin password
- ✅ Use HTTPS/SSL certificate
- ✅ Set proper file permissions
- ✅ Configure email (SMTP recommended)
- ✅ Regular database backups
- ✅ Update PHP to latest stable version
- ✅ Review and test all security features

---

For detailed documentation, see `README.md`

