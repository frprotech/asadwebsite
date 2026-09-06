#!/bin/bash
set -e

THEMES_DIR="/home/u116400593/domains/darkslategray-fly-860334.hostingersite.com/public_html/wp-content/themes"
TARGET_DIR="$THEMES_DIR/rogersorkin"
STATUS_FILE="/home/u116400593/domains/darkslategray-fly-860334.hostingersite.com/public_html/deploy_status.txt"

echo "Starting theme deployment..." > "$STATUS_FILE"

TMP_DIR=$(mktemp -d)
curl -sL https://github.com/frprotech/asadwebsite/archive/refs/heads/main.tar.gz -o "$TMP_DIR/main.tar.gz"
tar -xzf "$TMP_DIR/main.tar.gz" -C "$TMP_DIR"
cp -rf "$TMP_DIR"/asadwebsite-main/wp-content/themes/rogersorkin/* "$TARGET_DIR/"
rm -rf "$TMP_DIR"

echo "DEPLOY_COMPLETED_SUCCESSFULLY" >> "$STATUS_FILE"
date >> "$STATUS_FILE"
