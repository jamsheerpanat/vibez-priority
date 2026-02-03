#!/bin/bash

# OctoPass - Start/Restart Script
# This script manages the Laravel backend and Vite frontend servers
# Optimized for local network access

set -e  # Exit on error

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Function to print colored messages
print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Get local IP address
LOCAL_IP=$(ipconfig getifaddr en0 || ipconfig getifaddr en1 || hostname -I | awk '{print $1}')
if [ -z "$LOCAL_IP" ]; then
    LOCAL_IP="127.0.0.1"
    print_warning "Could not detect local IP, falling back to 127.0.0.1"
fi

# Update vite.config.js with the correct IP for HMR
sed -i '' "s/host: '[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}'/host: '$LOCAL_IP'/" vite.config.js

# Function to kill existing processes
kill_processes() {
    print_info "Stopping existing processes..."
    
    # Kill Laravel server
    if pkill -f "php artisan serve" 2>/dev/null; then
        print_success "Stopped Laravel server"
    else
        print_info "No Laravel server running"
    fi
    
    # Kill Vite dev server
    if pkill -f "vite" 2>/dev/null; then
        print_success "Stopped Vite dev server"
    else
        print_info "No Vite server running"
    fi
    
    # Wait a moment for processes to fully terminate
    sleep 1
}

# Function to check if port is available
check_port() {
    local port=$1
    if lsof -Pi :$port -sTCP:LISTEN -t >/dev/null 2>&1; then
        return 1  # Port is in use
    else
        return 0  # Port is available
    fi
}

# Function to find available port
find_available_port() {
    local start_port=$1
    local port=$start_port
    
    while ! check_port $port; do
        port=$((port + 1))
    done
    
    echo $port
}

# Main script
echo ""
echo "╔════════════════════════════════════════╗"
echo "║     OctoPass Development Server        ║"
echo "╚════════════════════════════════════════╝"
echo ""

# Kill existing processes
kill_processes

echo ""
print_info "Starting development servers..."
echo ""

# Find available port for Laravel
LARAVEL_PORT=$(find_available_port 8000)
if [ "$LARAVEL_PORT" != "8000" ]; then
    print_warning "Port 8000 in use, using port $LARAVEL_PORT instead"
fi

# Update .env with new URL if needed
CURRENT_URL="http://$LOCAL_IP:$LARAVEL_PORT"
if grep -q "APP_URL=" .env; then
    sed -i '' "s|APP_URL=.*|APP_URL=$CURRENT_URL|" .env
    print_info "Updated APP_URL in .env to $CURRENT_URL"
fi

# Start Vite dev server in background
print_info "Starting Vite dev server..."
npm run dev > /tmp/octopass-vite.log 2>&1 &
VITE_PID=$!

# Wait a moment for Vite to start
sleep 3

# Check if Vite started successfully
if ps -p $VITE_PID > /dev/null; then
    # Extract Vite port from log
    VITE_PORT=$(grep -o "Network: http://.*:[0-9]*" /tmp/octopass-vite.log | awk -F: '{print $NF}' | head -n 1)
    if [ -z "$VITE_PORT" ]; then
        VITE_PORT="5173"
    fi
    print_success "Vite dev server started on port $VITE_PORT"
else
    print_error "Failed to start Vite dev server"
    print_info "Check /tmp/octopass-vite.log for details"
    exit 1
fi

echo ""

# Start Laravel server (listening on 0.0.0.0 for network access)
print_info "Starting Laravel server on $LOCAL_IP:$LARAVEL_PORT..."
php -c php-dev.ini artisan serve --host=0.0.0.0 --port=$LARAVEL_PORT > /tmp/octopass-laravel.log 2>&1 &
LARAVEL_PID=$!

# Wait a moment for Laravel to start
sleep 2

# Check if Laravel started successfully
if ps -p $LARAVEL_PID > /dev/null; then
    print_success "Laravel server started!"
else
    print_error "Failed to start Laravel server"
    print_info "Check /tmp/octopass-laravel.log for details"
    kill $VITE_PID 2>/dev/null
    exit 1
fi

echo ""
echo "╔════════════════════════════════════════╗"
echo "║          🚀 Servers Running!           ║"
echo "╚════════════════════════════════════════╝"
echo ""
print_success "OctoPass is ready for network access!"
echo ""
echo -e "📱 ${YELLOW}Public Registration (Mobile/Network):${NC}"
echo "   http://$LOCAL_IP:$LARAVEL_PORT/register?src=lobby"
echo ""
echo "💻 Local Access:"
echo "   http://127.0.0.1:$LARAVEL_PORT/register?src=lobby"
echo ""
echo "🔐 Admin Panel:"
echo "   http://$LOCAL_IP:$LARAVEL_PORT/admin"
echo "   Email: admin@octopass.local"
echo "   Password: Admin@12345"
echo ""
echo "🎨 Vite Dev Server:"
echo "   http://$LOCAL_IP:$VITE_PORT"
echo ""
echo "📊 Process IDs:"
echo "   Laravel: $LARAVEL_PID"
echo "   Vite: $VITE_PID"
echo ""
echo "📝 Logs:"
echo "   Laravel: /tmp/octopass-laravel.log"
echo "   Vite: /tmp/octopass-vite.log"
echo ""
print_info "Press Ctrl+C to stop all servers"
echo ""

# Function to cleanup on exit
cleanup() {
    echo ""
    print_info "Shutting down servers..."
    kill $LARAVEL_PID 2>/dev/null || true
    kill $VITE_PID 2>/dev/null || true
    print_success "Servers stopped"
    exit 0
}

# Trap Ctrl+C and cleanup
trap cleanup INT TERM

# Wait for Laravel process (keeps script running)
wait $LARAVEL_PID
