/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    var d = new Date();
    var n = d.getTime();
    config.height = 500;
    config.language = 'zh';
    config.enterMode = CKEDITOR.ENTER_DIV;
    config.shiftEnterMode = CKEDITOR.ENTER_BR;
    // config.uiColor = '#AADC6E';
    config.extraPlugins = 'autosave,youtube,showborders,quicktable,panelbutton,button,floatpanel,panel,dialogui';

    // autosave
    config.autosave_delay = 5; // 每秒存

    config.ShowTableBorders = true;
    config.youtube_width = '300';
    config.youtube_height = '250';
    config.youtube_related = true;
    config.youtube_older = false;
    config.youtube_privacy = false;
    config.bodyClass = 'contents';
    config.contentsCss = ['/assets/stylesheets/reset.css?'+n, '/assets/stylesheets/default.css?'+n, '/assets/stylesheets/Articles.css?'+n, '/assets/stylesheets/responsive.css?'+n];
    config.smiley_path = 'http://image.playappgame.co/assets/images/ckeditor/plugins/smiley/images/';
    config.toolbar = [{
        name: 'document',
        groups: ['mode', 'document', 'doctools'],
        items: ['Source', '-', 'Preview', '-', 'Templates']
    }, {
        name: 'clipboard',
        groups: ['clipboard', 'undo'],
        items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
    }, {
        name: 'links',
        items: ['Link', 'Unlink', 'Anchor']
    }, {
        name: 'tools',
        items: ['Maximize', 'ShowBlocks']
    }, {
        name: 'basicstyles',
        groups: ['basicstyles', 'cleanup'],
        items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat']
    }, {
        name: 'colors',
        items: ['TextColor', 'BGColor']
    }, {
        name: 'styles',
        items: ['Font', 'FontSize']
    }, {
        name: 'insert',
        items: ['Image', 'Youtube', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
    }, {
        name: 'editing',
        groups: ['find', 'selection', 'spellchecker'],
        items: ['Find', 'Replace', '-', 'SelectAll']
    }, {
        name: 'paragraph',
        groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
    }];
};
