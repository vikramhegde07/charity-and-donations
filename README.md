# 🌍 Charity & Donation Platform

This is a complete charity and donation web application built with **PHP** and **MySQL**, featuring both a user-facing site and a custom-built admin panel. The frontend was adapted from an open-source template, and I developed the backend to make the system fully functional — from campaign creation to donation tracking.

🔧 The project is fully functional up to payment integration, and can be made production-ready by connecting a real payment gateway like Razorpay, Stripe, or PayPal.

---

## 🚀 Features

### 👥 User Side
- Browse and view donation campaigns
- View details, goals, and amount raised
- Submit donation (mock/demo flow)
- Contact/support page

### 🛠️ Admin Panel
- Create, edit, or remove donation campaigns
- Track all donations and contributors
- Manage campaign progress
- Control user messages and contact requests

---

## 🧱 Tech Stack

- **Frontend**: HTML, CSS (open-source template), JS
- **Backend**: PHP (Core PHP, not framework-based)
- **Database**: MySQL
- **Deployment**: Designed for Apache/PHP 7.x environments (e.g., XAMPP, LAMP)

---

## 📦 Folder Structure

/admin → Admin dashboard
/ → User-facing site
/includes → CSS,JS,images, DB connection, helper files
/DATABASE → SQL dump file (import into MySQL)


---

## ⚙️ Setup Instructions

1. Clone the repo or download the ZIP
2. Import `charity_db.sql` into your local MySQL server
3. Update DB credentials in `/includes/config.php`
4. Run the project using a local server like **XAMPP**
5. Admin login available via `/admin` route (default credentials in DB)

---

## 💳 Payment Integration

- Payment gateway logic is designed but not yet wired to a live processor
- Ready for integration with:
  - Razorpay (India)
  - Stripe
  - PayPal

---

## 📌 Status

✅ Feature-complete  
⚙️ Awaiting payment integration  
🛠️ No longer actively developed, but usable for learning or extension

---

## 👨‍💻 Author

Developed by [Vikram Hegde](https://github.com/vikramhegde07) as a fullstack web app for learning and showcasing backend integration with real-world workflows.

---

## 🤝 Contributions

Feel free to fork, reuse, or extend this project — especially if you want to plug in a payment gateway or migrate to a PHP framework (Laravel, CodeIgniter).

