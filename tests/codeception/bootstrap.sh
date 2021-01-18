#!/bin/bash

export WPDESK_PLUGIN_SLUG=wp-desk-woocommerce-exporter
export WPDESK_PLUGIN_TITLE="WP Desk WooCommerce Exporter"

export WOOTESTS_IP=${WOOTESTS_IP:wootests}

sh ./vendor/wpdesk/wp-codeception/scripts/common_bootstrap.sh
