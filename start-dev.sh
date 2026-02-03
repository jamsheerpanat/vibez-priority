#!/bin/bash

echo "🚀 Starting OctoPass Development Server..."
echo ""

# Start npm dev in background
echo "📦 Starting Vite dev server..."
npm run dev &
NPM_PID=$!

# Wait a moment for Vite to start
sleep 3

# Start Laravel server
echo "🎯 Starting Laravel server..."
php artisan serve

# Cleanup on exit
trap "kill $NPM_PID" EXIT
