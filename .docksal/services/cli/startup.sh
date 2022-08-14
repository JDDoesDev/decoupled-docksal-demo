#! /usr/bin/env bash

# Docker volumes are mounted as root:root by default, so we have to fix permissions on them
echo "Changing permissions on mounted folders."
sudo chown -R $(id -u):$(id -g) /var/www/vendor || true
sudo chown -R $(id -u):$(id -g) /var/www/web/modules || true
sudo chown -R $(id -u):$(id -g) /var/www/gatsby || true
