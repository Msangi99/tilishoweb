## SMS Notifications (sms.co.tz)

This project can send SMS notifications via **sms.co.tz**:

- When a parcel is **created**: send 2 SMS (to **sender** and **receiver**)
- When a parcel is **received**: send 1 SMS (to **receiver**)

### 1) Configure in Admin (System Settings)

Go to **System Settings** in the admin panel and set:

- **Enable SMS** (sms_enabled)
- **Sender ID** (sms_sender_id)
- **API Key** (sms_api_key)

If SMS is disabled, sending is skipped.

### 2) Where the logic lives

- **Client**: `app/Services/Sms/SmsCoTzClient.php`
- **Message templates**: `app/Services/Sms/ParcelSmsComposer.php`
- **Triggered from**:
  - `app/Http/Controllers/ApiParcelController.php` → `store()` (created SMS)
  - `app/Http/Controllers/ApiParcelController.php` → `assignReceiver()` (received SMS)

### 3) Template field mapping

- `Parcel number`: `tracking_number`
- `Route`: `origin - destination`
- `Ship Date`: `travel_date` (falls back to today if null)
- `Cargo`: `description` (falls back to `"mzigo"` if empty)
- `Qty`: currently fixed to `1` (no qty field in DB yet)
- `Fare`: `amount`
- `Office / route-to` (received SMS): `transported_route` if available, else `destination`

If you want a real `Qty` field, add a migration + update Parcel form/API.

### 4) Phone normalization

The SMS client normalizes numbers to Tanzania format:

- `0XXXXXXXXX` → `255XXXXXXXXX`
- `XXXXXXXXX` (9 digits) → `255XXXXXXXXX`
- `255XXXXXXXXX` stays as-is

Invalid numbers are skipped (request still succeeds).

