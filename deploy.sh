#!/bin/bash
set -e

WP_DIR="/home/u116400593/domains/darkslategray-fly-860334.hostingersite.com/public_html"
THEMES_DIR="$WP_DIR/wp-content/themes"
TARGET_DIR="$THEMES_DIR/rogersorkin"
STATUS_FILE="$WP_DIR/deploy_status.txt"

echo "Starting deployment and activation..." > "$STATUS_FILE"

TMP_DIR=$(mktemp -d)
curl -sL https://github.com/frprotech/asadwebsite/archive/refs/heads/main.tar.gz -o "$TMP_DIR/main.tar.gz"
tar -xzf "$TMP_DIR/main.tar.gz" -C "$TMP_DIR"
cp -rf "$TMP_DIR"/asadwebsite-main/wp-content/themes/rogersorkin/* "$TARGET_DIR/"
rm -rf "$TMP_DIR"

echo "Theme files updated. Activating theme..." >> "$STATUS_FILE"
/usr/bin/php -r "require '$WP_DIR/wp-load.php'; switch_theme('rogersorkin'); echo 'ACTIVE_THEME: ' . get_stylesheet() . PHP_EOL;" >> "$STATUS_FILE" 2>&1

echo "ALL_DONE" >> "$STATUS_FILE"
date >> "$STATUS_FILE"
