# Unlimited Backup (Community Fork for All-in-One WP Migration®)

> ⚠️ **Important Trademark Disclaimer**  
> This is an **independent, community-maintained fork** of the “Unlimited Extension” plugin for WordPress.  
> **ALL-IN-ONE WP MIGRATION®** is a registered trademark of **ServMask, Inc.**  
> This project is **not affiliated with, endorsed by, or sponsored by ServMask, Inc.**  
> Any use of “ALL-IN-ONE WP MIGRATION®” names is **solely for identification and compatibility purposes** and **does not imply any endorsement or affiliation**.  
>
> Some file and folder names remain unchanged **solely for technical compatibility and interoperability purposes**, as altering them would break core functionality. Their presence does not imply endorsement or association.

**This repo is not endorsed or owned by, or affiliated with ServMask, Inc** 

Copyright information is retained as it should be legally retained even under a GPLv3 licence. It gives us the right to fork not pass off code which isn't ours. 

---

## About This Fork  

This project is a community-maintained fork of the "Unlimited Extension" for the  [All-in-One WP
Migration](https://wordpress.org/plugins/all-in-one-wp-migration/) plugin. It aims to provide continued freedom, maintainability, and usability under the [GPL
license](https://www.gnu.org/licenses/gpl-3.0.html).

### 1st August 2025

In August 2025, ServMask Inc. submitted a **DMCA takedown request** against this repository alleging copyright infringement.  
After review, **GitHub determined after some minor changes that the repository was compliant with the GPLv3 licence**, and the takedown was not enforced. 

### 6th October 2025

ServMask Inc. has now submitted a **separate complaint based on trademark**.  
GitHub has reviewed this and, as of now, considers the repository to fall within **nominative fair use** of the “ALL-IN-ONE WP MIGRATION®” mark.  
To make things as clear as possible, please see the trademark disclaimer at the top of this document — this project is **not an official release**, **not endorsed by ServMask**, and remains an **independent GPL-licensed community fork**.

Some folder and file names remain unchanged to preserve functionality and compatibility. Changing them would break core features, and their presence **does not imply endorsement or affiliation**.

✨ Key Changes in This Fork

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

-   [ServMask Inc.](https://servmask.com/) — for the original plugin.  **This repository is not owned, maintained, or endorsed by ServMask, Inc.**  “ALL-IN-ONE WP MIGRATION®” is a registered trademark of ServMask, Inc.

-   [UUPD Project](https://github.com/stingray82/uupd) — for the lightweight
    update system

 

🤝 Contributions Welcome
-----------------------

Pull requests and issue suggestions are welcome. Especially if you want to:

-   Help stub any remaining telemetry

-   Improve update security

-   Refactor patching into optional modules

**License**: GPLv3



> **Trademark Notice:** “ALL-IN-ONE WP MIGRATION®” is a registered trademark of ServMask, Inc. This project is not affiliated with, endorsed by, or sponsored by ServMask, Inc.
