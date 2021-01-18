#!/bin/bash

export WPDESK_PLUGIN_SLUG=wp-desk-plugin-template
export WPDESK_PLUGIN_TITLE="WP Desk Plugin Template"

export WOOTESTS_IP=${WOOTESTS_IP:wootests}

sh ./vendor/wpdesk/wp-codeception/scripts/common_bootstrap.sh
