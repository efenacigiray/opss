"use strict";

$(document).ready(function() {

    /* Call Function: circloidRFMisc() */
    // Miscellaneous - Always load first
    circloidRFMisc();

    /* Call Function: circloidRFResponsiveness() */
    // Load immediately after "circloidRFMisc Function" for proper responsive behaviour
    circloidRFResponsiveness();

    /* Call Function: circloidMenuNav() */
    // Let Menu
    circloidMenuNav({
        container: ".menu",
        eventtype: "click"
    });

    /* Call Function: circloidMenuNav() */
    // Horizontal
    circloidMenuNav({
        container: ".mainnav-horizontal",
        eventtype: "click",
        menuposition: "top"
    });

    /* Call Function: circloidLanguageMenu() */
    circloidLanguageMenu();

    /* Call Function: circloidSearchBar() */
    circloidSearchBar();

    /* Call Function: circloidNotificationAlert() */
    circloidNotificationAlert({
        eventtype: "click"
    });

    /* Call Function: circloidProfileMenu() */
    circloidProfileMenu({
        eventtype: "click"
    });

    /* Call Function: circloidBlocks() */
    circloidBlocks({
        colorcollapsed: "red"
    });

    /* Call Function: circloidQuickWidgets() */
    circloidQuickWidgets();

    /* Call Function: circloidMap() */
    circloidMap();

    /* Call Function: circloidTopChart() which handles the top charts */
    // circloidTopChart();
    circloidDateRangeChart("#sales-analytics-large", "#sales-analytics-large-canvas", "line");
    circloidDateRangeChart("#chart-top-product-medium", "#top-products-graph", "donut");
    circloidDateRangeChart("#chart-top-customer-medium", "#top-customers-graph", "donut");
    circloidDateRangeChart("#chart-most-viewed-products-medium", "#most-viewed-products-graph", "donut");

    /* Call Function: circloidRevealBugFix() */
    /* IMPORTANT: Always place this at the bottom of Circloid main functions if you wish to use animated menus */
    circloidRevealBugFix();

    /* Settings Page Functions */
    circloid_switchery_color_presets();
    circloid_switchery_extension_control();
    circloid_switchery_white_label_control();

    /* Call OpenCart Default Function Functions */
    b5b_qore_engine_default_oc_functions();


});