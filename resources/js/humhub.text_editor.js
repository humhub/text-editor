humhub.module('text_editor', function (module, require, $) {
    var client = require('client');

    var updateContent = function (evt) {
        client.submit(evt).then(function (response) {
            if (response.result) {
                var modal = action.Component.instance(evt.$trigger.closest('.modal'));
                if (modal) {
                    modal.clear();
                    modal.close();
                }
                module.log.success(response.result);
            } else if (response.error) {
                module.log.error(response, true);
            }
        }).catch(function (e) {
            module.log.error(e, true);
        });
    };

    module.export({
        updateContent: updateContent,
    });

});