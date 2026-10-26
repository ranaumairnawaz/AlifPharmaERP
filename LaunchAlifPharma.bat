@echo off
setlocal
cd /d "%~dp0"
:: Start Alif Pharma directly to bypass npm overhead
IF EXIST "%~dp0node_modules\electron\dist\electron.exe" (
    "%~dp0node_modules\electron\dist\electron.exe" . >nul 2>&1
) ELSE (
    IF EXIST "%~dp0node_modules\.bin\electron.cmd" (
        "%~dp0node_modules\.bin\electron.cmd" . >nul 2>&1
    ) ELSE (
        echo Electron binary not found! Please run npm install.
    )
)
exit /b
