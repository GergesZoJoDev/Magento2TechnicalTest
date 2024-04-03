/*global define*/
define([
    'Magento_Ui/js/form/form'
], function(Component) {
    'use strict';
    return Component.extend({
        initialize: function () {
            this._super();

            return this;
        },

        onSubmit: function() {
            this.source.set('params.invalid', false);
            this.source.trigger('customCheckoutForm.data.validate');

            if (!this.source.get('params.invalid')) {
                var formData = this.source.get('customCheckoutForm');
                console.dir(formData);
            }
        }
    });
});
