Unlimited Backup
================

This is a community-maintained fork of the original **Unlimited Extension** for
the All-in-One WP Migration plugin.

 

⚠️ Why This Fork Exists
----------------------

We created this fork to maintain **freedom, transparency, and update control**
under the terms of the [GNU General Public License
(GPL)](https://www.gnu.org/licenses/gpl-3.0.html).

The original developer, ServMask, uses update mechanics and messaging that: -
**Block or warn about GPL forks** ("You may be a victim of software
counterfeiting...") - **Override forks silently via their own update
infrastructure** - Include non-free terms like forced EULAs (in a GPL
environment)

 

More details on our experience with ServMask and the motivation behind this fork
are in this article:

  
👉 [Software Freedom, the GPL, and Our Experience with
ServMask](https://techarticles.co.uk/software-freedom-the-gpl-and-our-experience-with-servmask/)

 

✅ Changes Made in This Fork
---------------------------

 

### 1. ❌ Removed EULA Controller

-   stubbed the `lib/controller/class-ai1wmue-eula-controller.php`

-   The original plugin forced a EULA pop-up — this contradicts the spirit of
    GPL licensing.

 

### 2. 🛡️ Added `inc/fork.php` to Suppress ServMask’s Branding & Update System

This file: - Removes “Check for Updates” and “Contact Support” links from the
plugin row - Prevents ServMask’s updater from injecting update messages (like
anti-piracy warnings) - Filters the internal `ai1wm_updater` data so it ignores
our fork - Blocks inclusion in `Ai1wm_Extensions::get()` to avoid unwanted
ServMask behavior

 

### 3. 🔄 Added Universal Updater (`inc/updater.php`)

-   Integrated the [UUPD project](https://github.com/stingray82/uupd) to allow
    **custom updates from GitHub** (or another private update server)

-   No additional license keys, no telemetry, no nonsense

-    

🚀 How Updates Work Now
----------------------

The updater is defined in `unlimited-backup-ai1wmue.php`:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
define('RUP_UNLIMITED_BACKUP_AI1WMUE_VERSION', '2.70.3');
require_once __DIR__ . '/inc/fork.php';

add_action( 'plugins_loaded', function() {
    require_once __DIR__ . '/inc/updater.php';

    \UUPD\V1\UUPD_Updater_V1::register([
        'plugin_file' => plugin_basename( __FILE__ ),
        'slug'        => 'unlimited-backup-ai1wmue',
        'name'        => 'Unlimited Backup Plugin',
        'version'     => RUP_UNLIMITED_BACKUP_AI1WMUE_VERSION,
        'key'         => '',
        'server'      => 'https://raw.githubusercontent.com/stingray82/Unlimited-backup/main/uupd/index.json',
    ]);
}, 1);
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This means you can: - Get updates via GitHub or your own JSON-based server -
Stay in full control — no external update hijacks or EULA traps

📦 Plugin Folder Structure
-------------------------

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
unlimited-backup-ai1wmue/
├── inc/
│   ├── fork.php            ← Kills ServMask's update and branding logic
│   └── updater.php         ← UUPD-based GitHub updater
├── unlimited-backup-ai1wmue.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

🧾 License
---------

This fork, like the original plugin, is licensed under the **GNU GPL v3 or
later**.

We are proud to continue that tradition — **free as in freedom**.

 

🙌 Credits
---------

-   [ServMask Inc.](https://servmask.com) — for the original plugin

-   [UUPD Project](https://github.com/stingray82/uupd) — for the lightweight
    update system

 

🔍 Telemetry Notice
------------------

As of the current version, this fork **does not yet remove ServMask’s telemetry
code**.  
However, in future releases, we intend to **stub or fully remove any tracking or
data-reporting features**.

If you're interested in helping, or have insights on safe removal of
telemetry-related hooks, we would love your input.

 

🤝 Contributions Welcome
-----------------------

This project is community-driven. We welcome: - Pull requests - Bug reports -
Suggestions for improvements or enhancements

Feel free to fork, improve, and open an issue or PR on GitHub.

Your help makes this plugin better for everyone.
