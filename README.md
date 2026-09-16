<div align="center">

# 🌈 CampusHub

### The colorful digital home for campus life

<table>
  <tr>
    <td bgcolor="#ef4444" width="110">&nbsp;</td>
    <td bgcolor="#f97316" width="110">&nbsp;</td>
    <td bgcolor="#eab308" width="110">&nbsp;</td>
    <td bgcolor="#22c55e" width="110">&nbsp;</td>
    <td bgcolor="#06b6d4" width="110">&nbsp;</td>
    <td bgcolor="#3b82f6" width="110">&nbsp;</td>
    <td bgcolor="#8b5cf6" width="110">&nbsp;</td>
  </tr>
</table>

A PHP and MySQL campus community platform for discovering events, joining communities, sharing media, and staying connected.

[Student Portal](student.php) · [Admin Portal](admin.php) · [Home Page](index.php)

</div>

## ✨ What Is CampusHub?

CampusHub brings everyday university activities into one welcoming portal. Students can explore campus life and manage their participation, while administrators can maintain the platform's content and records.

## 🎨 Features

| Area | Highlights |
| --- | --- |
| **Student portal** | Dashboard, profile, notifications, event search, registrations, communities, announcements, forms, and media gallery |
| **Events** | Browse upcoming activities, view event details, register, and export event data |
| **Communities** | Discover and join clubs, departments, and student organizations |
| **Announcements** | Read timely updates from campus administration |
| **Media** | Browse campus images and videos; administrators can upload new media |
| **Forms** | View forms published by administrators |
| **Admin portal** | Dashboard statistics, student records, event management, content management, organizations, and media uploads |
| **Authentication** | Student registration and sign-in plus protected administrator access |

## 🧰 Built With

- **PHP** for server-rendered pages and API endpoints
- **MySQL** with **MySQLi** for persistence
- **Bootstrap 5.3** for responsive layout and components
- **Bootstrap Icons** for interface icons
- **HTML, CSS, and JavaScript** for the interactive portal experience

## 📁 Project Structure

```text
CampusHub/
├── index.php                 # Public landing page
├── student.php               # Student portal
├── admin.php                 # Administrator portal
├── api/                      # JSON/API handlers
│   ├── announcements.php
│   ├── auth.php
│   ├── communities.php
│   ├── events.php
│   ├── export_events.php
│   ├── forms.php
│   ├── media.php
│   └── students.php
├── config/
│   └── db.php                # MySQL connection and session setup
├── script/
│   ├── admin.js
│   └── student.js
├── style/
│   ├── admin.css
│   ├── custom.css
│   └── student.css
└── uploads/                  # Uploaded media files
```

## 🚀 Run Locally

### Requirements

- PHP 7.4+ with the `mysqli` extension
- MySQL or MariaDB
- Apache, XAMPP, WAMP, or PHP's built-in development server
- An internet connection for Bootstrap and Bootstrap Icons CDN assets

### Setup

1. Clone or copy this project into your local web server directory.
2. Create a MySQL database named `campushub`.
3. Import the project's database schema and seed data if available.
4. Open `config/db.php` and set the database host, username, password, and database name for your machine.
5. Ensure the `uploads/` directory is writable by the web server.
6. Start the application from the project directory:

   ```bash
   php -S localhost:8000
   ```

7. Open [http://localhost:8000](http://localhost:8000) in your browser.

For Apache or XAMPP, place the project under the server's document root and open the matching local URL instead.

## 🧭 Using the Portals

### Students

1. Open the **Student Portal**.
2. Register a new account or sign in.
3. Use the navigation tabs to explore events, communities, announcements, media, and forms.
4. Update your profile and manage event registrations from the portal.

### Administrators

1. Open the **Admin Portal**.
2. Sign in with administrator credentials.
3. Use the sidebar to manage students, events, media, announcements, forms, and communities.
4. Review dashboard statistics to monitor campus activity.

## 🔐 Security Notes

- Do not commit real database passwords or production credentials.
- Use environment variables or a server-only configuration file for deployment.
- Replace the development database credentials in `config/db.php` before sharing or deploying the project.
- Validate uploads and restrict file permissions in the `uploads/` directory.

## 🌟 Project Vision

CampusHub is designed to make campus information easier to discover, communities easier to join, and student participation more visible. One platform, many ways to belong.

<div align="center">

**Made for a more connected campus** 🌈

</div>
