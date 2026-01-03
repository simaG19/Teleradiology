# Teleradiology Platform

A lightweight teleradiology web app for receiving DICOM ZIPs, assigning them to radiologists, and delivering diagnostic reports. Built with **Laravel**, **Blade**, and **Tailwind CSS**.

## Quick summary
- Upload DICOM ZIPs (customers & hospital uploaders) as batches.
- Admin sets prices (based on file type), confirms batches and assigns them to readers.
- Readers download batches, create text/pdf reports.
- File types CRUD (name, anatomy, price_per_file).
- Hospital billing and per-upload quoting.
- Roles & permissions via **spatie/laravel-permission**.

---

## Features
- Batch uploads (ZIP), stored as `Batch` / `HospitalUpload`.
- Admin quoting & confirmation.
- Assignment workflow (admin → reader).
- Report creation (notes + optional PDF) per assignment.
- File types management (type name, anatomy, price per file).
- Hospital billing aggregation.
- Tailwind + Blade UI; minimal frontend animations optional.

---

## Prerequisites
- PHP >= 8.1 (match your project)
- MySQL (or other configured DB)
- Composer
- Node.js + npm/yarn (if you build frontend assets)
- `zip` PHP extension (for `\ZipArchive`) — enable `extension=zip` in `php.ini`
- Run `php artisan storage:link` to expose public storage (reports)

---

## Install & run (local)
```bash
# clone & cd
git clone https://github.com/simaG19/Teleradiology.git
cd Teleradiology
# install php deps
composer install

# install js deps (optional, for Tailwind)
npm install
# build assets (optional)
npm run dev

# copy env and set DB + app key
cp .env.example .env
# edit .env to configure DB, mail, etc.
php artisan key:generate

# run migrations
php artisan migrate

# make storage link so reports are accessible via /storage/...
php artisan storage:link

# run local server
php artisan serve
