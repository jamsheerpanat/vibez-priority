#!/bin/bash

# OctoPass - Stop Script
# This script stops all OctoPass development servers

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo ""
echo "🛑 Stopping OctoPass servers..."
echo ""

# Kill Laravel server
if pkill -f "php artisan serve"; then
    echo -e "${GREEN}✅ Stopped Laravel server${NC}"
else
    echo -e "${BLUE}ℹ️  No Laravel server running${NC}"
fi

# Kill Vite dev server
if pkill -f "vite"; then
    echo -e "${GREEN}✅ Stopped Vite dev server${NC}"
else
    echo -e "${BLUE}ℹ️  No Vite server running${NC}"
fi

echo ""
echo -e "${GREEN}✅ All servers stopped${NC}"
echo ""
