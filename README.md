# Unlimited Backup (Community Fork for All-in-One WP Migration®)

Unlimited Backup is a GPLv3-licensed community fork of the original Unlimited Extension for All-in-One WP Migration®, created to preserve software freedom and ensure continued compatibility without restrictive licensing.

> ⚠️ **Important Trademark Disclaimer**  
>
> This is an **independent, community-maintained fork** of the “Unlimited Extension” plugin for WordPress.  
>
> **ALL-IN-ONE WP MIGRATION®** is a registered trademark of **ServMask, Inc.**  
>
> This project is **not affiliated with, endorsed by, or sponsored by ServMask, Inc.**  
>
> Any use of “ALL-IN-ONE WP MIGRATION®” names is **solely for identification and compatibility purposes** and **does not imply any endorsement or affiliation**.  
>
> Some file and folder names remain unchanged **solely for technical compatibility and interoperability purposes**, as altering them would break core functionality. Their presence does not imply endorsement or association.
>
> Copyright information is retained as it should be legally retained even under a GPLv3 licence. It gives us the right to fork not pass off code which isn't ours. 

---

## About This Fork  

This project is a community-maintained fork of the "Unlimited Extension" for the  [All-in-One WP
Migration](https://wordpress.org/plugins/all-in-one-wp-migration/) plugin. It aims to provide continued freedom, maintainability, and usability under the [GPL
license](https://www.gnu.org/licenses/gpl-3.0.html).

###  Key Changes in This Fork

### ✅ EULA Prompt Remove

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

 

### Telemetry

As of the current version Google Tag Manager has been disabled, there could be
other calls home in the plugin and tracking but we will continue to slowly
remove them

 

## Disclaimer Policy & User Control 

This project includes clear, visible **trademark disclaimers** to help ensure there is no confusion between this community-maintained fork and the original commercial product by **ServMask, Inc.** The disclaimers appear:

- In the plugin list (below the plugin name), as a **“Disclaimer”** link and a short note stating that the plugin is not affiliated with ServMask, Inc.
- In the plugin **“View Details”** modal (the popup shown when you click the plugin name), with a clear statement that this is an independent fork.

These notices are included **by default** to help protect users, ServMask, and this project from any confusion or mistaken association — while still exercising our rights under the [GPLv3](https://www.gnu.org/licenses/gpl-3.0.html).

### Optional: Disabling the Disclaimer (Advanced Users Only)

Because software freedom also means the freedom to modify how your copy behaves, you can **disable these disclaimer messages** if you wish. This does **not** remove any functional code — it only hides the extra UI text and disclaimer tab.

To disable them, add the following line to your `wp-config.php` or your site’s `functions.php`:

```
define( 'RUP_UB_DISABLE_DISCLAIMER', true );
```

Or use a WordPress filter:

```
add_filter( 'rup_ub_disclaimer_enabled', '__return_false' );
```

We recommend leaving the disclaimers enabled to help prevent user confusion. However, the choice is yours — as guaranteed by the GPL.

### Disclaimer Disabling examples

![Example Gif](https://github.com/stingray82/repo-images/raw/main/unlimited-backup/Unlimited-backup-disable-disclaimer-example.gif)

Files to Edit in Future Updates
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

**License:** [GPLv3](https://www.gnu.org/licenses/gpl-3.0.html)



### Legal Timeline & History

### 1st August 2025

In August 2025, ServMask Inc. submitted a **DMCA takedown request** against this repository alleging copyright infringement.  
After review, **GitHub determined after some minor changes that the repository was compliant with the GPLv3 licence**, and the takedown was not enforced. 

### 6th October 2025

ServMask Inc. has now submitted a **separate complaint based on trademark**.  
GitHub has reviewed this and, as of now, considers the repository to fall within **nominative fair use** of the “ALL-IN-ONE WP MIGRATION®” mark.  
To make things as clear as possible, please see the trademark disclaimer at the top of this document — this project is **not an official release**, **not endorsed by ServMask**, and remains an **independent GPL-licensed community fork**.

Some folder and file names remain unchanged to preserve functionality and compatibility. Changing them would break core features, and their presence **does not imply endorsement or affiliation**.



## Legal Notes

**Trademark Notice:** “ALL-IN-ONE WP MIGRATION®” is a registered trademark of **ServMask, Inc.**

This project is an **independent, community-maintained fork** of the original Unlimited Extension. It is **not affiliated with, endorsed by, or sponsored by ServMask, Inc.**.

Any reference to the “ALL-IN-ONE WP MIGRATION®” name or related terms is made **solely for identification, compatibility, and descriptive purposes** in accordance with the principles of **nominative fair use**.

Some file names, folder names, or constants from the original project remain unchanged **purely for technical compatibility and interoperability reasons** — altering them would break essential functionality. Their presence **does not imply any endorsement or association** with ServMask, Inc.

This project is distributed under the terms of the [GNU General Public License, version 3 (GPLv3)](https://www.gnu.org/licenses/gpl-3.0.html). That license guarantees your freedom to use, study, share, and modify the software — including the right to fork it — provided you respect the same license conditions. This fork exists to uphold those freedoms.
