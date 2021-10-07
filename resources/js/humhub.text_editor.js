humhub.module('text_editor', function (module, require, $) {
    var client = require('client');
    var modal = require('ui.modal');
    var object = require('util').object;
    var Widget = require('ui.widget').Widget;

    var Editor = function (node, options) {
        Widget.call(this, node, options);
    };

    object.inherits(Editor, Widget);

    Editor.prototype.init = function () {
        this.modal = modal.get('#texteditor-modal');

        var that = this;
        this.modal.$.on('hidden.bs.modal', function (evt) {
            that.modal.clear();
        });

    };

    Editor.prototype.save = function (evt) {
        var that = this;

        client.submit(evt).then(function (response) {
            if (response.result) {
                that.modal.clear();
                that.modal.close();
                module.log.success(response.result);
                // Update all links of the updated File to new file version url
                $('a[href$="guid=' + response.previousGuid + '"]').each(function () {
                    var urlToNewFileVersion = $(this).attr('href').replace(new RegExp('(\\?|&)guid=' + response.previousGuid + '$'), '$1guid=' + response.newGuid);
                    $(this).attr('href', urlToNewFileVersion);
                });
            } else if (response.error) {
                module.log.error(response, true);
            }
        }).catch(function (e) {
            module.log.error(e, true);
        });

        evt.finish();
    }

    module.export({
        Editor: Editor,
    });

});