# OctoPass - Server Management Scripts

## 🚀 Quick Start

### Start All Servers
```bash
./start.sh
```

This will:
- ✅ Kill any existing Laravel and Vite processes
- ✅ Automatically find available ports
- ✅ Start Vite dev server in background
- ✅ Start Laravel server
- ✅ Display all access URLs and credentials
- ✅ Show process IDs and log locations
- ✅ Handle graceful shutdown with Ctrl+C

### Stop All Servers
```bash
./stop.sh
```

This will kill all running OctoPass servers (Laravel and Vite).

## 📋 What the Start Script Does

1. **Process Cleanup**: Kills any existing `php artisan serve` and `vite` processes
2. **Port Detection**: Automatically finds available ports (starts with 8000 for Laravel, 5173 for Vite)
3. **Server Startup**: Starts both servers with proper error handling
4. **Status Display**: Shows all URLs, credentials, and process information
5. **Log Management**: Redirects output to `/tmp/octopass-*.log` files

## 🌐 Access Points (After Starting)

The script will display URLs like:

```
📱 Public Registration:
   http://127.0.0.1:8000/register?src=lobby

🔐 Admin Panel:
   http://127.0.0.1:8000/admin
   Email: admin@octopass.local
   Password: Admin@12345

🎨 Vite Dev Server:
   http://localhost:5173
```

**Note:** Port numbers may vary if default ports are in use.

## 📝 Log Files

Server logs are stored in:
- Laravel: `/tmp/octopass-laravel.log`
- Vite: `/tmp/octopass-vite.log`

View logs in real-time:
```bash
# Laravel logs
tail -f /tmp/octopass-laravel.log

# Vite logs
tail -f /tmp/octopass-vite.log
```

## 🔄 Restart Servers

To restart all servers:
```bash
./stop.sh && ./start.sh
```

Or simply run `./start.sh` - it automatically kills existing processes first.

## 🛠️ Manual Server Management

If you prefer to run servers manually:

### Start Vite (Terminal 1)
```bash
npm run dev
```

### Start Laravel (Terminal 2)
```bash
php artisan serve
```

### Stop Manually
Press `Ctrl+C` in each terminal, or:
```bash
pkill -f "php artisan serve"
pkill -f "vite"
```

## 🎯 Features

### Automatic Port Detection
If the default port is in use, the script automatically finds the next available port:
- Laravel: Tries 8000, 8001, 8002, etc.
- Vite: Tries 5173, 5174, 5175, etc.

### Colored Output
- 🔵 Blue: Information messages
- ✅ Green: Success messages
- ⚠️ Yellow: Warning messages
- ❌ Red: Error messages

### Graceful Shutdown
Press `Ctrl+C` to stop all servers gracefully. The script will:
1. Catch the interrupt signal
2. Kill both Laravel and Vite processes
3. Display shutdown confirmation
4. Exit cleanly

## 🐛 Troubleshooting

### Port Already in Use
The script automatically handles this - it will find the next available port.

### Servers Won't Start
Check the log files:
```bash
cat /tmp/octopass-laravel.log
cat /tmp/octopass-vite.log
```

### Permission Denied
Make sure scripts are executable:
```bash
chmod +x start.sh stop.sh
```

### Processes Won't Die
Force kill all processes:
```bash
pkill -9 -f "php artisan serve"
pkill -9 -f "vite"
```

## 💡 Tips

1. **Always use `./start.sh`** for development - it handles everything automatically
2. **Check logs** if something doesn't work as expected
3. **Use `./stop.sh`** before shutting down your computer to clean up processes
4. **Bookmark the URLs** shown by the start script for quick access

## 📚 Related Documentation

- `README.md` - Complete setup and deployment guide
- `QUICK_START.md` - System overview and credentials
- `API_TESTING_GUIDE.md` - API endpoint examples
- `DEPLOYMENT_CHECKLIST.md` - Production deployment steps

---

**Happy coding! 🚀**
