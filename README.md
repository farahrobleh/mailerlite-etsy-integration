# MailerLite-Etsy Integration

A simple demo integration syncing Etsy customers to MailerLite subscriber groups, creating email campaigns, and triggering automations, built with Laravel, Inertia.js, Vue.js, and PostgreSQL for MailerLite’s Integrations Engineer role.

## Features
- Mocked Etsy OAuth 2.0 and MailerLite API integration (pending Etsy API approval).
- Sync Etsy customers to MailerLite groups with automated welcome emails.
- Create and preview MailerLite-style campaigns with Etsy products.
- Display campaign analytics (open/click rates) and automation workflows.
- Polished dashboard with MailerLite’s branding (Inter font, #00A8E8).
- Unit tests for sync, campaign, and automation endpoints.

## Setup
1. Clone: `git clone https://github.com/yourusername/mailerlite-etsy-integration.git`
2. Install: `composer install && npm install`
3. Configure `.env` with Etsy keystring, shared secret, and MailerLite API key (optional).
4. Migrate: `php artisan migrate`
5. Run: `php artisan serve && npm run dev`

## Demo
[Live Demo](https://mailerlite-etsy.onrender.com) (TBD)
[Loom Video](https://www.loom.com/share/your-video-id) (TBD)

## Notes
- Uses mocked APIs to simulate a real MailerLite-Etsy integration.
- Built by Robleh Farah to showcase Laravel, Vue.js, and API skills.
- Empowers Etsy shop owners with MailerLite’s email marketing toolkit.

Powered by MailerLite
