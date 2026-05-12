# Menzili — Complete Admin Panel Functions

A comprehensive list of **every function you need** in the admin panel, based on your actual codebase. Each item is marked with its current status.

> [!TIP]
> ✅ = Already coded &nbsp;&nbsp; ❌ = Not coded yet

---

## 1. Dashboard (Home)

| # | Function | Status |
|---|----------|--------|
| 1.1 | Total users count | ❌ |
| 1.2 | Total verified members count | ❌ |
| 1.3 | Total listings count  (active / inactive / pending moderation) | ❌ |
| 1.4 | Total revenue from coin purchases (DZD) | ❌ |
| 1.5 | New registrations today / this week / this month | ❌ |
| 1.6 | New listings today / this week / this month | ❌ |
| 1.7 | Pending coin purchases awaiting approval | ❌ |
| 1.8 | Pending reports count | ❌ |
| 1.9 | Active boosts count | ❌ |
| 1.10 | Active ads count | ❌ |

---

## 2. User Management

| # | Function | Status |
|---|----------|--------|
| 2.1 | List all users (with search, filter by status/wilaya) | ❌ |
| 2.2 | View user details (profile, phone, email, last login, device token) | ❌ |
| 2.3 | Activate / Deactivate a user (`is_active`) | ❌ |
| 2.4 | Delete a user | ❌ |
| 2.5 | View user's member profile | ❌ |
| 2.6 | View user's listings | ❌ |
| 2.7 | View user's wallet balance & transaction history | ❌ |
| 2.8 | View user's coin purchases | ❌ |
| 2.9 | View user's reviews (given) | ❌ |
| 2.10 | View user's reports (filed by this user) | ❌ |
| 2.11 | View reports received against this user (as Member) | ❌ |
| 2.12 | Manually deposit/withdraw coins to/from user wallet | ❌ |
| 2.13 | Send push notification to a specific user | ❌ |

---

## 3. Member Verification

| # | Function | Status |
|---|----------|--------|
| 3.1 | List pending member verification requests | ❌ |
| 3.2 | View member's ID card (front: `card_id_front_path`, back: `card_id_back_path`) | ❌ |
| 3.3 | View member's uploaded document (`document_path`) | ❌ |
| 3.4 | Approve member → set `member_verified_at` | ❌ |
| 3.5 | Approve agent → set `agent_verified_at` | ❌ |
| 3.6 | Reject member verification (with reason) | ❌ |
| 3.7 | Revoke member / agent verification | ❌ |

---

## 4. Listing Management

| # | Function | Status |
|---|----------|--------|
| 4.1 | List all listings (with search, filter by type/wilaya/status/moderation) | ❌ |
| 4.2 | View listing full details (images, features, near places, categories) | ❌ |
| 4.3 | Approve listing moderation (`moderation_status` → approved) | ❌ |
| 4.4 | Reject listing moderation (with reason) | ❌ |
| 4.5 | Activate / Deactivate a listing (`is_active`) | ❌ |
| 4.6 | Verify a listing (`verified_at`) | ❌ |
| 4.7 | Delete a listing (with media cleanup) | ❌ |
| 4.8 | View listing's reviews | ❌ |
| 4.9 | View listing's reports | ❌ |
| 4.10 | View listing's boost history | ❌ |
| 4.11 | View listing's ads | ❌ |

---

## 5. Report Management

| # | Function | Status |
|---|----------|--------|
| 5.1 | List all reports | ✅ [allReports()](file:///home/mensour/workflow/laravel/backend_menzili/app/Http/Controllers/Api/Admin/ReportController.php#45-56) |
| 5.2 | List listing reports only | ✅ [listingReports()](file:///home/mensour/workflow/laravel/backend_menzili/app/Http/Controllers/Api/Admin/ReportController.php#15-30) |
| 5.3 | List member reports only | ✅ [memberReports()](file:///home/mensour/workflow/laravel/backend_menzili/app/Http/Controllers/Api/Admin/ReportController.php#31-44) |
| 5.4 | View report details (reporter, reported entity) | ❌ |
| 5.5 | Update report status (pending → reviewed / resolved / dismissed) | ❌ |
| 5.6 | Take action on reported entity (deactivate listing / ban user) | ❌ |
| 5.7 | Delete a report | ❌ |

---

## 6. Coin Purchase Management

| # | Function | Status |
|---|----------|--------|
| 6.1 | List coin purchases (filtered by status) | ✅ [index()](file:///home/mensour/workflow/laravel/backend_menzili/app/Http/Controllers/Api/Admin/CoinPurchaseController.php#11-29) |
| 6.2 | Approve a pending purchase (credits coins to wallet) | ✅ [approve()](file:///home/mensour/workflow/laravel/backend_menzili/app/Http/Controllers/Api/Admin/CoinPurchaseController.php#30-71) |
| 6.3 | Reject a coin purchase (with reason) | ❌ |
| 6.4 | View Baridimob receipt image (`receipt_path`) | ❌ |
| 6.5 | View purchase details (member, package, method, ref code) | ❌ |
| 6.6 | Filter by payment method (chargily / baridimob / cash) | ❌ |
| 6.7 | Total revenue stats (per method, per period) | ❌ |

---

## 7. Coin Packages Management

| # | Function | Status |
|---|----------|--------|
| 7.1 | List all coin packages | ❌ |
| 7.2 | Create a new coin package (coins, price, offer end date) | ❌ |
| 7.3 | Update a coin package | ❌ |
| 7.4 | Activate / Deactivate a package (`is_active`) | ❌ |
| 7.5 | Delete a coin package | ❌ |

---

## 8. Review Management

| # | Function | Status |
|---|----------|--------|
| 8.1 | List all reviews (with filter by rating, listing, member) | ❌ |
| 8.2 | View review details | ❌ |
| 8.3 | Delete an inappropriate review | ❌ |
| 8.4 | Recalculate listing rating after deletion | ❌ |

---

## 9. Boost Management

| # | Function | Status |
|---|----------|--------|
| 9.1 | List all boosts (active / expired) | ❌ |
| 9.2 | View boost details (listing, member, coins spent, dates) | ❌ |
| 9.3 | Force-expire a boost | ❌ |
| 9.4 | View boost revenue stats | ❌ |

---

## 10. Ads Management

| # | Function | Status |
|---|----------|--------|
| 10.1 | List all ads (active / inactive / expired) | ❌ |
| 10.2 | View ad details (target type, linked listing/member, external URL) | ❌ |
| 10.3 | Approve / Reject an ad | ❌ |
| 10.4 | Activate / Deactivate an ad | ❌ |
| 10.5 | Delete an ad | ❌ |
| 10.6 | View ad revenue stats | ❌ |

---

## 11. Notification Management

| # | Function | Status |
|---|----------|--------|
| 11.1 | Send push notification to all users (broadcast) | ❌ |
| 11.2 | Send push notification to a specific user | ❌ |
| 11.3 | Send push notification to users in a specific wilaya | ❌ |
| 11.4 | View notification history log | ❌ |
| 11.5 | Delete a notification | ❌ |

---

## 12. Lookup Tables Management (CRUD for each)

These are the configuration tables that power dropdowns in the app:

| # | Table | Fields | Status |
|---|-------|--------|--------|
| 12.1 | **Categories** | name_ar, name_en, name_fr, icon, icon_path, description, active | ❌ |
| 12.2 | **Types** | name_ar, name_en, name_fr, icon, icon_path, description, active | ❌ |
| 12.3 | **Features** | name_ar, name_en, name_fr, icon, icon_path, description, active | ❌ |
| 12.4 | **Near Places** | name_ar, name_en, name_fr, icon, icon_path, description, active | ❌ |
| 12.5 | **Rent Durations** | name_ar, name_en, name_fr | ❌ |
| 12.6 | **Countries** | name, code | ❌ |
| 12.7 | **Wilayas** | name_ar, name_en, code, country_id | ❌ |
| 12.8 | **Cities** | name, wilaya_id | ❌ |

> [!NOTE]
> Each lookup table needs: **List all**, **Create**, **Update**, **Activate/Deactivate**, **Delete**.

---

## 13. AI Chatbot Management

| # | Function | Status |
|---|----------|--------|
| 13.1 | View agent conversations list | ❌ |
| 13.2 | View conversation messages | ❌ |
| 13.3 | View listing embeddings stats | ❌ |
| 13.4 | Re-trigger embeddings generation | ❌ |

---

## 14. Wallet & Financial Overview

| # | Function | Status |
|---|----------|--------|
| 14.1 | View all wallets with balances | ❌ |
| 14.2 | View all transactions (deposits, withdrawals) | ❌ |
| 14.3 | View all transfers between wallets | ❌ |
| 14.4 | Revenue reports (total coins sold, total DZD, per period) | ❌ |
| 14.5 | Coins spent breakdown (boosts, ads, etc.) | ❌ |

---

## 15. Settings & System

| # | Function | Status |
|---|----------|--------|
| 15.1 | Admin login / authentication | ❌ |
| 15.2 | Admin profile management | ❌ |
| 15.3 | App settings (Chargily API keys, FCM config, etc.) | ❌ |
| 15.4 | Manage admin users / roles | ❌ |
| 15.5 | Activity log (who did what) | ❌ |

---

## Summary

| Section | Total Functions | ✅ Done | ❌ Remaining |
|---------|:-:|:-:|:-:|
| Dashboard | 10 | 0 | 10 |
| User Management | 13 | 0 | 13 |
| Member Verification | 7 | 0 | 7 |
| Listing Management | 11 | 0 | 11 |
| Report Management | 7 | 3 | 4 |
| Coin Purchases | 7 | 2 | 5 |
| Coin Packages | 5 | 0 | 5 |
| Review Management | 4 | 0 | 4 |
| Boost Management | 4 | 0 | 4 |
| Ads Management | 6 | 0 | 6 |
| Notifications | 5 | 0 | 5 |
| Lookup Tables | 8 × 5 = 40 | 0 | 40 |
| AI Chatbot | 4 | 0 | 4 |
| Wallet & Financial | 5 | 0 | 5 |
| Settings & System | 5 | 0 | 5 |
| **TOTAL** | **~143** | **5** | **~138** |
