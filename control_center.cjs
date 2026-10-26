const { app, BrowserWindow, ipcMain, shell } = require('electron');
const path = require('path');
const { spawn, exec } = require('child_process');
const http = require('http');
const os = require('os');

let mainWindow;
let splashWindow;
let phpServer = null;
const hostname = os.hostname().toLowerCase();

function createWindow() {
    // 1. Show Splash Screen immediately
    splashWindow = new BrowserWindow({
        width: 300,
        height: 350,
        frame: false,
        transparent: true,
        alwaysOnTop: true,
        backgroundColor: '#0f172a',
        icon: path.join(__dirname, 'public/alif-logo.png'),
        webPreferences: { nodeIntegration: false }
    });
    splashWindow.loadFile(path.join(__dirname, 'public/cc_splash.html'));
    splashWindow.center();

    // 2. Prepare Main Window
    mainWindow = new BrowserWindow({
        width: 450,
        height: 550,
        frame: false,
        resizable: false,
        backgroundColor: '#0f172a',
        show: false,
        icon: path.join(__dirname, 'public/alif-logo.png'),
        webPreferences: {
            nodeIntegration: true,
            contextIsolation: false
        }
    });

    mainWindow.loadFile('control_center.html');

    mainWindow.once('ready-to-show', () => {
        // Hide splash and show main
        if (splashWindow) {
            splashWindow.destroy();
            splashWindow = null;
        }
        mainWindow.show();
    });

    mainWindow.on('closed', () => {
        if (phpServer) {
            exec('taskkill /IM php.exe /F');
        }
        mainWindow = null;
    });
}

// Kill existing PHP processes on startup to avoid port conflicts
async function cleanup() {
    return new Promise((resolve) => {
        exec('taskkill /IM php.exe /F', () => resolve());
    });
}

// ... (your existing requires)

// UPDATED: Start server listener
ipcMain.on('start-server', async (event) => {
    try {
        await cleanup();


        phpServer = spawn('php', ['artisan', 'serve', '--host=0.0.0.0', '--port=8000'], {
            cwd: process.cwd(),
            detached: false,
            stdio: 'ignore'
        });

        phpServer.on('error', (err) => {
            console.error('Failed to start PHP server:', err);
            event.reply('server-status', {
                running: false,
                error: 'PHP not found. Please ensure PHP is in your system PATH.'
            });
        });

        const targetUrl = `http://${hostname}.local:8000`;
        const poll = () => {
            http.get('http://127.0.0.1:8000', (res) => {
                event.reply('server-status', { running: true, url: targetUrl });
                shell.openExternal(targetUrl);
            }).on('error', () => {
                setTimeout(poll, 500);
            });
        };
        poll();
    } catch (err) {
        event.reply('server-status', { running: false, error: err.message });
    }
});

// ... (rest of your file)

ipcMain.on('start-server', async (event) => {
    try {
        await cleanup();

        phpServer = spawn('php', ['artisan', 'serve', '--host=0.0.0.0', '--port=8000'], {
            cwd: process.cwd(),
            detached: false,
            stdio: 'ignore'
        });

        phpServer.on('error', (err) => {
            console.error('Failed to start PHP server:', err);
            event.reply('server-status', {
                running: false,
                error: 'PHP not found. Please ensure PHP is in your system PATH.'
            });
        });

        // Poll server then open browser
        const targetUrl = `http://${hostname}.local:8000`;
        const poll = () => {
            http.get('http://127.0.0.1:8000', (res) => {
                event.reply('server-status', { running: true, url: targetUrl });
                shell.openExternal(targetUrl);
            }).on('error', () => {
                setTimeout(poll, 500);
            });
        };
        poll();
    } catch (err) {
        event.reply('server-status', { running: false, error: err.message });
    }
});

ipcMain.on('stop-server', async (event) => {
    await cleanup();
    phpServer = null;
    event.reply('server-status', { running: false });
});

ipcMain.on('close-window', () => {
    app.quit();
});

ipcMain.on('minimize-window', () => {
    mainWindow.minimize();
});

ipcMain.on('open-project', () => {
    shell.openPath(process.cwd());
});

ipcMain.handle('get-hostname', () => {
    return `${hostname}.local`;
});

app.whenReady().then(async () => {
    await cleanup();
    createWindow();
});

app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
        app.quit();
    }
});
