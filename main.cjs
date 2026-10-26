const { app, BrowserWindow, dialog, nativeImage, Menu } = require('electron');
const path = require('path');
const { exec, spawn } = require('child_process');
const fs = require('fs');
const http = require('http');

function buildAppMenu() {
    const template = [
        {
            label: 'Alif Pharma',
            accelerator: 'Ctrl+Home',
            click: () => { if (mainWindow) mainWindow.loadURL('http://127.0.0.1:8000/dashboard'); }
        },
        {
            label: 'Reload',
            accelerator: 'F5',
            click: () => { if (mainWindow) mainWindow.webContents.reload(); }
        },
        {
            label: 'Navigation',
            submenu: [

                {
                    label: '↩  Go Back',
                    accelerator: 'Alt+Left',
                    click: () => { if (mainWindow && mainWindow.webContents.canGoBack()) mainWindow.webContents.goBack(); }
                },
                {
                    label: '↪  Go Forward',
                    accelerator: 'Alt+Right',
                    click: () => { if (mainWindow && mainWindow.webContents.canGoForward()) mainWindow.webContents.goForward(); }
                }
            ]
        },
        {
            label: 'View',
            submenu: [
                { label: 'Toggle Fullscreen', accelerator: 'F11', role: 'togglefullscreen' },
                { label: 'Zoom In', accelerator: 'Ctrl+=', role: 'zoomIn' },
                { label: 'Zoom Out', accelerator: 'Ctrl+-', role: 'zoomOut' },
                { label: 'Reset Zoom', accelerator: 'Ctrl+0', role: 'resetZoom' }
            ]
        }
    ];
    return Menu.buildFromTemplate(template);
}

let mainWindow;
let splashWindow;
let phpServer;

const iconPath = path.join(__dirname, 'public/alif-logo.png');

function killExistingPhp() {
    // Kill existing php artisan serve processes on Windows
    return new Promise((resolve) => {
        exec('taskkill /IM php.exe /F', (err) => {
            // Error is expected if no processes are found
            resolve();
        });
    });
}

function pollServer(url, callback, maxAttempts = 100) {
    let attempts = 0;
    const interval = setInterval(() => {
        attempts++;
        http.get(url, (res) => {
            clearInterval(interval);
            callback();
        }).on('error', () => {
            if (attempts >= maxAttempts) {
                // Keep polling forever but console warning
                if (attempts % 20 === 0) {
                    console.log(`Still waiting for server at ${url}... attempt ${attempts}`);
                }
            }
        });
    }, 50); // High-frequency polling (50ms)
}

async function createWindow() {
    // Hard Cleanup before starting a new instance
    await killExistingPhp();

    const icon = nativeImage.createFromPath(iconPath);

    // 1. Initialize Native Splash Screen
    splashWindow = new BrowserWindow({
        width: 400,
        height: 500,
        transparent: true,
        frame: false,
        alwaysOnTop: true,
        backgroundColor: '#ffffff',
        icon: icon,
        webPreferences: { nodeIntegration: false }
    });

    splashWindow.loadFile(path.join(__dirname, 'public/splash.html'));
    splashWindow.center();

    // 2. Prepare Main Application Window (Hidden)
    mainWindow = new BrowserWindow({
        width: 1280,
        height: 800,
        show: false,
        backgroundColor: '#f8fafc',
        title: 'Alif Pharma - Inventory Hub',
        icon: icon,
        webPreferences: {
            nodeIntegration: true,
            contextIsolation: false
        }
    });

    // Start Fast PHP Server (Universal Binding for LAN Access)
    console.log('Starting PHP Fast Server (0.0.0.0)...');
    const routerPath = path.join(__dirname, 'server.php');
    phpServer = spawn('php', ['-S', '0.0.0.0:8000', '-t', 'public', routerPath], {
        cwd: process.cwd(),
        detached: false,
        stdio: 'ignore'
    });

    // 3. High-Velocity Handover: Poll until server is ready
    pollServer('http://127.0.0.1:8000', () => {
        mainWindow.loadURL('http://127.0.0.1:8000'); // Local window still uses loopback

        mainWindow.once('ready-to-show', () => {
            // Instant Handover: Splash -> Main
            if (splashWindow) {
                splashWindow.destroy();
                splashWindow = null;
            }

            // Apply custom app menu with Reload button
            const menu = buildAppMenu();
            Menu.setApplicationMenu(menu);

            mainWindow.show();
        });
    });

    mainWindow.on('closed', function () {
        mainWindow = null;
    });

    // Instant Closure Hook (Manual Redundancy Preferred)
    mainWindow.on('close', async (e) => {
        console.log('App closing... instant termination sequence.');

        // Kill server and exit immediately
        if (phpServer) {
            console.log('Terminating PHP Server...');
            phpServer.kill();
        }

        // Final Exit
        app.exit();
    });
}

app.on('ready', createWindow);

app.on('window-all-closed', function () {
    if (process.platform !== 'darwin') {
        if (phpServer) phpServer.kill();
        app.quit();
    }
});

app.on('activate', function () {
    if (mainWindow === null) createWindow();
});
