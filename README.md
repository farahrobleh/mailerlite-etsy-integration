![MailerLite-Etsy Integration Logo](https://cdn.imgchest.com/files/y8xcnqxq2z4.png)

# MailerLite-Etsy Integration

A simple demo integration to sync Etsy customers to MailerLite subscriber groups, create email campaigns (w/ drag-and-drop product photo functionality), and trigger automations, built with Laravel, Inertia.js, Vue.js, and PostgreSQL as a portfolio piece for the MailerLite Integrations Engineer role.

## Features
- Mocked Etsy OAuth 2.0 and MailerLite API integration (Etsy API approval still pending, so I mocked both services for now).
- Sync Etsy customers to MailerLite groups with automated welcome emails.
- Create and preview MailerLite-style email campaigns, with draggable Etsy products.
- Display campaign analytics (open/click rates) and automation workflows.
- Polished dashboard with MailerLite’s branding (Inter font, Bold black title text, exact MailerLite green hues (#58BE72, #D6F2E3), etc.).
- Unit test(s) for sync, campaign, and automation endpoints (single test for now, more to come).

## Setup (local)
1. Clone: `git clone https://github.com/farahrobleh/mailerlite-etsy-integration.git`
2. Install: `composer install && npm install`
3. Configure `.env` with Etsy keystring, shared secret, and PostgreSQL credentials.
4. Migrate: `php artisan migrate`
5. Run: `php artisan serve && npm run dev`

## Demo
[Live Demo](https://mailerlite-etsy-integration.onrender.com/)


[Brief Documentation/Statement of Purpose](https://www.notion.so/MailerLite-Etsy-Integration-Documentation-and-Statement-of-Purpose-23205210a3bd80b393b7da7904a874ad?source=copy_link)

## Notes
- Uses mocked APIs to simulate a real MailerLite-Etsy integration.
- Hosted PostgreSQL on Neon for scalable, managed database access.
- Built by Robleh Farah to showcase Laravel, Vue.js, and API skills.
- Empowers Etsy shop owners with MailerLite’s email marketing toolkit.
