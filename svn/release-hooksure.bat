@echo off
setlocal enabledelayedexpansion

REM === Configuration ===
set "WORKING_COPY_PATH=C:\Users\Nathan\svn\Hooksure"
set "TRUNK_PATH=%WORKING_COPY_PATH%\trunk"
set "PLUGIN_FILE=%TRUNK_PATH%\hooksure.php"
set "README_FILE=%TRUNK_PATH%\readme.txt"
set "REPO_URL=https://plugins.svn.wordpress.org/hooksure"

REM === Extract plugin slug from REPO_URL ===
for %%A in ("%REPO_URL%") do (
    set "PLUGIN_SLUG=%%~nxA"
)

REM === Prompt for version number ===
set /p VERSION="Enter the new version number (e.g. 1.4.2): "

if "%VERSION%"=="" (
    echo Version number is required. Aborting.
    goto end
)

echo === Updating version numbers with PowerShell ===

REM --- Update PHP version line ---
powershell -Command "(Get-Content '%PLUGIN_FILE%') -replace '^(Version:\s*).+$', '${1}%VERSION%' | Set-Content '%PLUGIN_FILE%'" || (
    echo Failed to update version in PHP file. Aborting.
    goto end
)

REM --- Update Stable tag in readme.txt ---
powershell -Command "(Get-Content '%README_FILE%') -replace '^(Stable tag:\s*).+$', '${1}%VERSION%' | Set-Content '%README_FILE%'" || (
    echo Failed to update version in readme.txt. Aborting.
    goto end
)

echo === Committing changes in trunk ===
cd /d "%TRUNK_PATH%"
svn add --force . >nul
svn commit -m "Preparing for version %VERSION% release"
if %ERRORLEVEL% NEQ 0 (
    echo Commit failed. Aborting.
    goto end
)

echo === Tagging version %VERSION% ===
cd /d "%WORKING_COPY_PATH%"
svn copy "%TRUNK_PATH%" "%REPO_URL%/tags/%VERSION%" -m "Tagging version %VERSION% for release"
if %ERRORLEVEL% NEQ 0 (
    echo Tagging failed. Aborting.
    goto end
)

echo === Refreshing plugin page for %PLUGIN_SLUG% ===
start https://wordpress.org/plugins/%PLUGIN_SLUG%/?refresh

echo === Release %VERSION% completed successfully! 🚀 ===

:end
pause
endlocal
