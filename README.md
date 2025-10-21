A lightweight teleradiology web app for receiving DICOM batches, assigning them to readers, and delivering diagnostic reports. Built with Laravel + Blade + Tailwind; designed for hospitals, clients and radiologists.

Key features

Upload DICOM ZIPs (hospital uploaders & customers) and store as batches.

Admin quoting: set price per batch (based on file type) and confirm before payment.

Simple payment form (local + card UI placeholder) — no payment gateway logic included.

Assignment workflow: admin assigns batches to readers; readers download ZIPs, create PDF/text reports.

Reports saved and downloadable (PDF or notes).

File types CRUD: admin manages study types (e.g. X-ray, CT) with price_per_file and anatomy.

Hospital billing: aggregates uploads and totals for hospital profiles.

Roles & access control powered by Spatie permissions.

User roles

Admin / Super-admin — manage users, hospitals, file types, batches, assignments, view reports and billing.

Reader — assigned batches, download ZIPs, create and submit reports.

Customer — upload DICOM ZIPs, view quotes and reports, pay (via form).

Hospital uploader — upload on behalf of a hospital; hospital billing updated when uploads occur.

Data model (high level)

Batch / HospitalUpload — represents an uploaded ZIP (batch id, uploader, urgency, file type, quoted_price, archive_path, status, confirmed).

MedicalImage — legacy/per-file records (optional, depending on flow).

Assignment — connects images / batches / hospital_uploads to a reader, with status and deadline.

Report — notes + optional PDF, linked to an assignment.

FileType — study type name, anatomy, price_per_file.

Security & notes

Authentication: Laravel auth guards (separate guard for hospital uploaders).

Authorization: Spatie roles & permissions.

File storage: uses Laravel disks (local/public); run php artisan storage:link for public report access.

DICOM handling: uploads stored as ZIPs; no DICOM parsing included.

Payment: form-only; integrate your preferred gateway (Stripe, M-Pesa, local) as needed.

Quick start

Clone repo, copy .env, set DB and storage.

composer install && php artisan migrate && php artisan storage:link

Seed roles/users or create via tinker.

Run: php artisan serve.
