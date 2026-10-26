@echo off
setlocal
cd /d "%~dp0"
echo Launching Alif Pharma Control Center...

set "ELECTRON_EXE=%~dp0node_modules\electron\dist\electron.exe"

if exist "%ELECTRON_EXE%" (
    start "" "%ELECTRON_EXE%" control_center.cjs
) else (
    echo.
    echo [ERROR] Electron binary not found!
    echo Please ensure you have run 'npm install'.
    echo Expected path: %ELECTRON_EXE%
    pause
)
exit
