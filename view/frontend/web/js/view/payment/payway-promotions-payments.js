/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
/**
 * Makes Payway Payment method available into the Checkout Payment step
 */
define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';

    rendererList.push({
        type: 'payway',
        component: 'Prisma_PaywayPromotions/js/view/payment/method-renderer/payway-promotions-method'
    });

    return Component.extend({});
});
