# 🎓 Language Learning Platform

منصة تعليمية متكاملة لتعلم اللغات، تدعم اللغة العربية والإنجليزية، مع نظام تحديد مستوى، كورسات مسجلة ومباشرة، وشهادات إتمام.

---

## 🏗️ Architecture (الهيكلة)

- **Laravel 12**
- **Service-Repository Pattern**
- **MySQL**
- **PayPal Integration** (قيد التطوير)
- **Queue & Jobs** for daily emails

---

## ✨ Features (الميزات)

| الميزة | الحالة |
|--------|--------|
| نظام تسجيل دخول متكامل | ✅ تم |
| مستويات (A1, A2, B1, B2, C1) | ✅ تم |
| كورسات مسجلة مع فيديو وملفات | ✅ تم |
| درس مجاني لكل كورس | ✅ تم |
| **دروس مباشرة (Live)** | ✅ تم |
| اختبار تحديد المستوى | ✅ تم |
| شهادات PDF | ✅ تم |
| كلمة تحفيزية يومية (Email Scheduler) | ✅ تم |
| دفع عبر PayPal | ⏳ قيد التطوير |
| دعم اللغة العربية والإنجليزية | ✅ تم |

---

## 📁 Folder Structure

```
app/
├── Services/           # Business logic
├── Http/
│   ├── Controllers/    # Lightweight controllers
│   ├── Requests/       # Validation
│   ├── Middleware/     # Admin middleware
│   └── Resources/
├── Models/             # Eloquent models with relations
├── Mail/               # Email templates
├── Jobs/               # Background jobs
└── Console/            # Custom commands
```

---
## ✨ Features (الميزات)

| الميزة | الحالة |
|--------|--------|
| نظام تسجيل دخول متكامل | ✅ تم |
| مستويات (A1, A2, B1, B2, C1) | ✅ تم |
| كورسات مسجلة مع فيديو وملفات | ✅ تم |
| درس مجاني لكل كورس | ✅ تم |
| دروس مباشرة (Live) | ✅ تم |
| اختبار تحديد المستوى | ✅ تم |
| شهادات PDF | ✅ تم |
| كلمة تحفيزية يومية | ✅ تم |
| دفع عبر PayPal | ⏳ قيد التطوير |
| دعم العربية والإنجليزية | ✅ تم |

---

## 🚀 Installation (تشغيل المشروع)

```bash
# Clone the repository
git clone https://github.com/ALYAMAMA-Z/langueges_platform.git

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# Storage link for images
php artisan storage:link

# Run the application
php artisan serve
```

---

## 🧪 Testing (الاختبارات)

```bash
# Send daily word manually
php artisan daily-words:send

# Run scheduler locally
php artisan schedule:work
```
## 🛠️ Testing with Tinker

```bash
# Open Tinker
php artisan tinker
---

## 👩‍💻 Developer

**ALYAMAMA-Z**  
- GitHub: [@ALYAMAMA-Z](https://github.com/ALYAMAMA-Z)

---

## 📄 License

MIT License