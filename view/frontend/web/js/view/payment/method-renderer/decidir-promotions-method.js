define([
    'jquery',
    'ko',
    'mage/validation',
    'Prisma_Decidir/js/view/payment/method-renderer/decidir-method',
    'Magento_Checkout/js/model/totals',
    'Magento_Catalog/js/price-utils'
],function (
    $,
    ko,
    $t,
    Component,
    totals,
    priceUtils
) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Prisma_DecidirPromotions/payment/decidir-promotions-payment',
            config: window.checkoutConfig.payment.decidir,
            bankType: '',
            planInfo: ''
        },
        // Used to display exceptions during Decidir API interactions
        messageDispatcher: ko.observable(),

        initObservable: function () {
            this._super()
                .observe([
                    'bankType',
                    'planInfo',

                ]);
            return this;
        },

        getData: function() {
            var data = {
                'method': this.item.method,
                'additional_data': {
                    'cc_cid': this.creditCardVerificationNumber(),
                    'cc_type': this.creditCardType(),
                    'cc_exp_year': this.creditCardExpYear(),
                    'cc_exp_month': this.creditCardExpMonth(),
                    'cc_number': this.creditCardNumber(),
                    'card_holder_name': this.creditCardHolderName(),
                    'card_holder_doc_number': this.creditCardDocumentNumber(),
                    'card_holder_doc_type': this.creditCardDocumentType(),
                    'token': this.token(),
                    'bin': this.bin(),
                    'last_four_digits': this.lastFourDigits(),
                    'installments': undefined != this.installments() ? this.installments().split('-')[2] : '',
                    'bank_type': this.bankType(),
                    'plan_info': this.installments()
                }
            };

            return data;
        },
        getIsActive: function(){
          return this.config.is_active;
        },
        getAvailableBanks: function () {
            return _.map(this.config.available_banks, function (value, key) {
                return {
                    'value': key,
                    'type': value
                }
            });
        },
        getAvailableCards: function () {
            if (undefined != this.bankType()) {
                return _.map(this.config.available_cards[this.bankType()], function (value, key) {
                    return {
                        'value': key,
                        'type': value
                    }
                });
            } else {
                $('#decidir_cc_type').find('option:not([value])').remove();
                $('#decidir_cc_installment').find('option:not([value])').remove();
            }
        },
        getAvailablePlans: function() {
            var self = this;
            if (undefined != this.creditCardType()) {
                var ccType = self.creditCardType();
                var grandTotal = totals.totals().grand_total;
                return _.map(this.config.available_plans[this.bankType()][this.creditCardType()], function (value, key) {
                    var coefficient = parseFloat(value.coefficient);
                    var charge = 0;
                    var optionText = "";
                    var installmentPrice = (grandTotal) / parseInt(value.fee_period);
                    if (coefficient > 1 ) {
                        charge = (grandTotal * coefficient) - grandTotal;
                        installmentPrice = (grandTotal + charge) / parseInt(value.fee_period);
                    }
                    optionText = value.fee_period +
                        ' x ' +
                        priceUtils.formatPrice(installmentPrice.toFixed(2)) +
                        ' (' + priceUtils.formatPrice(grandTotal + charge) + ')'
                    ;
                    return {
                        'value': value.rule_id + '-' + ccType + '-' + value.fee_to_send,
                        'type': optionText
                    }
                });
            } else {
                $('#decidir_cc_installment').find('option:not([value])').remove();
            }
        },
    });
});
