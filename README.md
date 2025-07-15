# MailerLite-Etsy Integration

A demo integration syncing Etsy customers to MailerLite subscribers, built with Laravel, Inertia.js, Vue.js, and PostgreSQL.

## Features
- Mocked Etsy OAuth 2.0 authentication (pending API approval).
- Sync Etsy customers to MailerLite subscriber groups.
- Inertia.js/Vue.js dashboard styled like MailerLite’s Shopify integration.
- Unit test for sync endpoint.

## Setup
1. Clone: `git clone https://github.com/yourusername/mailerlite-etsy-integration.git`
2. Install: `composer install && npm install`
3. Configure `.env` with Etsy keystring, shared secret, and MailerLite API key.
4. Migrate: `php artisan migrate`
5. Run: `php artisan serve && npm run dev`

## Demo
[Live Demo](https://mailerlite-etsy.onrender.com) (TBD)
[Loom Video](https://www.loom.com/share/your-video-id) (TBD)

## Notes
- Uses mocked Etsy API responses due to pending app approval.
- Built by Robleh Farah to showcase Laravel, Vue.js, and API skills.

Powered by MailerLite
