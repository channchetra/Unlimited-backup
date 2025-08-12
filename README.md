Unlimited Backup Plugin – Fork of ServMask Unlimited Extension
==============================================================

This project is a community-maintained fork of the "Unlimited Extension" for the
[All-in-One WP
Migration](https://wordpress.org/plugins/all-in-one-wp-migration/) plugin. It
aims to provide continued freedom, maintainability, and usability under the [GPL
license](https://www.gnu.org/licenses/gpl-3.0.html).

### Please Note 1st August 2025:

I have recevied a DMCA takedown request for this repo, it is inaccurate and
poorly worded and this repository is totally legal under the GPL licence as such
I have defended it but ultimately github will make there own decision on this.

✨ Key Changes in This Fork
--------------------------

### ✅ EULA Prompt Removed

-   The forced EULA modal introduced by ServMask was removed.

-   File modified: `lib/controller/class-ai1wmue-eula-controller.php`

-   Replacement logic added to bypass `should_display_eula()`

### ✅ Independent Update Mechanism

-   The fork includes its own secure update server using
    [UUPD](https://github.com/stingray82/uupd).

-   File added: `inc/updater.php`

-   Configuration defined in: `unlimited-backup-ai1wmue.php`

### ✅ ServMask Update Checks and Branding Removed

-   File added: `inc/fork.php`

-   Prevents ServMask’s updater from injecting misleading update messages.

-   Removes "Check for Updates" and "Contact Support" links pointing to
    ServMask.

-   Cleans up plugin row meta data.

### ✅ Google Tag Manager (GTM) Disabled

-   File manually cleaned: `lib/view/common/google-tag-manager.php`

-   The GTM snippet was removed to prevent unwanted telemetry.

 

### 🔐 Telemetry

As of the current version Google Tag Manager has been disabled, there could be
other calls home in the plugin and tracking but we will continue to slowly
remove them

 

📁 Files to Edit in Future Updates
---------------------------------

Use this list to reapply customizations if you merge changes from upstream:

1.  **GTM Tracking**

    -   File: `lib/view/common/google-tag-manager.php`

    -   Remove the `<script>` Google Tag block entirely.

2.  **EULA Enforcement**

    -   File: `lib/controller/class-ai1wmue-eula-controller.php`

    -   Replace:

        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        public static function should_display_eula() {
            return false;
        }
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

3.  **Main Plugin File Changes**

    -   File: `unlimited-backup-ai1wmue.php`

    -   Ensure it:

        -   Loads `inc/fork.php` early.

        -   Defines version constant: `RUP_UNLIMITED_BACKUP_AI1WMUE_VERSION`

        -   Registers updater via `inc/updater.php` with `UUPD_Updater_V1`.

 

🙌 Credits
---------

-   [ServMask Inc.](https://servmask.com/) — for the original plugin

-   [UUPD Project](https://github.com/stingray82/uupd) — for the lightweight
    update system

 

🤝 Contributions Welcome
-----------------------

Pull requests and issue suggestions are welcome. Especially if you want to:

-   Help stub any remaining telemetry

-   Improve update security

-   Refactor patching into optional modules

**License**: GPLv3
