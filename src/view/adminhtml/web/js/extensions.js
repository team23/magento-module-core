define([
    'uiComponent',
], Component => {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Team23_Core/extensions/extensions',
            templates: {
                table: 'Team23_Core/extensions/table',
            },
            modulesData: [],
        },

        initialize: function() {
            this._super();
        },
    });
});
