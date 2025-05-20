# 🌄 BukTour

BukTour is an online booking system designed to streamline and simplify the process of reserving tours and travel experiences within Bukidnon. It offers users a convenient, user-friendly platform to explore destinations, book trips, and access travel information with ease.

---

## 🧑‍💼 Admin Role

Controls the BukTour website  
Has full access to manage content, bookings, and users

---

## 📊 Admin Dashboard

Overview of website activity  
Widgets for:

- Total Bookings  
- Total Packages  
- Total Destinations  
- Total Inquiries  
- Recent Bookings & Inquiries  
- Optional: Charts and analytics  

---

## 📍 Manage Destinations

- Add New Destination  
- Edit Destination Info  
- Update Existing Destination  
- Delete Destination  
- Search by Destination Name  
- Filter by Associated Package  

---

## 🧳 Manage Tour Packages

- Add New Tour Package  
- Edit Package Details  
- Save Changes  
- Delete Package  
- Search by Package Title  

---

## 📅 View and Manage Bookings

- Update Booking Status (✅ Confirmed, 🕒 Pending, ❌ Cancelled)  
- Delete Bookings  
- Filter by Booking Date  
- Filter by Client Name  
- Filter by Status  
- Export Bookings to PDF  

---

## 👥 View and Manage Clients

- Filter by Name  
- Filter by Email  
- Filter by Phone Number  
- Add New Client  
- Edit Client Information  
- Save Changes  
- Delete Client  

---

## 📩 View Inquiries

- Search by Name  
- Search by Email  
- Sort by Newest to Oldest  
- Delete Inquiries  

---

## 🚪 Admin Logout

Ends the current admin session securely

---

## 🌐 Landing Page

- Popular Destinations  
- Tour Packages  
- Footer  

---

## 📦 Package

- Search Tour Packages  
- Filter by Price  
- Card Packages  

---

## 📍 Destinations

- Picture Destination  
- Destination Description  
- Google Map Embedded  

---

## 📬 Send Inquiry

- Name  
- Email  
- Message  

---

## 🔗 Navigation Bar User Account

- Profile  
- Booking History  
- Log Out  

---

## 🔐 Log In

- Username and Password  
- reCAPTCHA  
- Sign Up with Google  
- Forgot Password  

---

## 📝 Sign Up

- Full Name  
- Email  
- Phone Number  
- Password  
- Re-enter Password  

---

## 🪟 Modal Booking

- Select Package  
- Full Name  
- Email  
- Preferred Tour Date  
- Preferred Tour Time  


## 🛠️ Requirements

- PHP 7.4 or higher  
- MySQL 5.7 or higher  
- Composer  
- XAMPP (or similar local development environment)  

## 📦 Installation

1.Clone the repository by running the following command in your terminal:

2.git clone https://github.com/jerichoayunar/BukTour

3.Then navigate into the project directory:

4.Create a .env file in the root directory with the following variables: DB_HOST=localhost DB_NAME=construct 
DB_USER=your_database_users DB_USER=your_database_task DB_USER=your_database_clients 
EMAIL_PASS=your_gmail_app_password GOOGLE_CLIENT_ID=your_google_client_secret 
GOOGLE_CLIENT_SECRET=https://localhost/ConstrucStore/google-callback.php


6.import the database schema: mysql -u your_database_user -p your_database_name < import.sql

Configure Google OAuth:

Go to the Google Cloud Console

Create a new project or select an existing one

Enable the Google+ API

Create OAuth 2.0 credentials

Add the redirect URL:

bash
Copy
Edit
http://localhost/tour/googleAuth/google-callback.php

## Usage

1. Start your local server (XAMPP, etc.)
2. Navigate to http://localhost/tour/
3. Register a new account or log in with Google

## Project Structur
📁 Upload/ – Destination and package images

🎨 styles/ – CSS stylesheets

🛠️ admin/ – Admin dashboard and management tools

🧭 tour/ – Public-facing website for bookings

🗂️ include/ – Database connection and server-side logic

🔐 google-auth/ – Google OAuth integration

📦 vendor/ – Composer dependencies


## Contact
For questions or support, please contact:
📧 cocoayunar@gmail.com
