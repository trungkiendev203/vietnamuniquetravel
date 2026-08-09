# Vietnam Unique Travel - Official Web Application

Complete, high-performance, multi-language (EN/VI) web application for **Vietnam Unique Travel** (CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG).

---

## 🌟 Key Features
- **Design System**: Dark Forest Green (`#022F13`), Brand Green (`#005825`), Warm Gold (`#F2C94C`) palette inspired by nature & Sovaba Travel presentation style.
- **Signature Tours**: Custom numbered cards (`01`, `02`, `03`) with subtle 2-3° rotated image cards and two-column alternating layout.
- **Pu Luong Signature Tours**: Pre-loaded with all 7 signature tours from official Word documents (`PLHDT-01` to `PLHDT-04`, `PLFDT-01` to `PLFDT-03`).
- **Multi-Language Architecture**: Native dual-language support (English default, Vietnamese switcher) with `/en/` and `/vi/` routing, canonical links, and hreflang meta tags.
- **Booking Flow**: Complete inquiry form with browser/server validation, unique booking reference generation (`VNU-YYYYMMDD-XXXX`), database persistence, and automatic SMTP email notifications to sales (`sales.vietnamuniquetravel@gmail.com`) and customer.
- **Admin Panel**: Lightweight management portal for dashboard statistics, booking statuses (`New`, `Contacted`, `Confirmed`, `Completed`, `Cancelled`), internal operation notes, tour status toggles, and system settings.
- **Shared Hosting Compatible**: Works out-of-the-box on cPanel, DirectAdmin, Apache, or LiteSpeed without root access, SSH, Node.js, Docker, or Redis.

---

## 🛠️ Technology Stack
- **Backend**: PHP 8.1+ / PHP 8.2 (MVC Architecture, PSR-4 Autoloading).
- **Database**: MySQL 5.7+ / 8.0+ (PDO prepared statements, InnoDB).
- **Frontend**: Vanilla HTML5, Vanilla CSS3 (CSS Variables, Flexbox/Grid), Vanilla JavaScript (No jQuery/Bootstrap/React).
- **Security**: CSRF tokens, Honeypot anti-spam, PDO binding, output escaping, Bcrypt password hashing.

---

## 🚀 cPanel / phpMyAdmin Installation Guide

### Step 1: Create Database & User in cPanel
1. Log into your **cPanel** control panel.
2. Open **MySQL® Databases**.
3. Create a new database (e.g. `vnutravel_db`).
4. Create a new MySQL user (e.g. `vnutravel_user`) with a strong password.
5. Add the user to the database and grant **ALL PRIVILEGES**.

### Step 2: Import Database SQL via phpMyAdmin
1. Open **phpMyAdmin** in cPanel.
2. Select your newly created database (`vnutravel_db`).
3. Click **Import** tab.
4. Upload `database/schema.sql` and click **Go**.
5. Click **Import** tab again, upload `database/seed.sql` and click **Go**.

### Step 3: Upload & Extract Source Files
1. Open **File Manager** in cPanel.
2. Navigate to your website root directory (`public_html` or domain subdirectory).
3. Upload `deploy-hosting.zip`.
4. Right-click `deploy-hosting.zip` and select **Extract**.

### Step 4: Configure `.env` File
1. In cPanel File Manager, enable "Show Hidden Files (dotfiles)".
2. Edit `.env` file and set your database and email credentials:

```ini
APP_NAME="Vietnam Unique Travel"
APP_ENV=production
APP_DEBUG=false
APP_URL="https://vietnamuniquetravel.com"

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vnutravel_db
DB_USERNAME=vnutravel_user
DB_PASSWORD=YourPasswordHere

SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USERNAME=sales.vietnamuniquetravel@gmail.com
SMTP_PASSWORD=YourAppPasswordHere
SMTP_ENCRYPTION=tls
MAIL_FROM_ADDRESS=sales.vietnamuniquetravel@gmail.com
MAIL_FROM_NAME="Vietnam Unique Travel"
```

### Step 5: Verify Permissions
Ensure the following directories have write permissions (`0755` or `0775`):
- `storage/`
- `storage/cache/`
- `storage/logs/`
- `public/uploads/`

---

## 🔐 Default Admin Account
- **Admin Login URL**: `https://yourdomain.com/admin/login`
- **Username**: `admin`
- **Password**: `Admin@2026!VNU`

---

## 📞 Support & Business Info
- **Brand**: Vietnam Unique Travel
- **Company**: CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG (Tax ID: 0102126315)
- **Hotline**: +84 362 191 568
- **Email**: sales.vietnamuniquetravel@gmail.com
