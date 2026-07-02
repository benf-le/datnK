/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 */

CKEDITOR.editorConfig = function( config ) {

    // Giữ nguyên danh sách plugins như mặc định
    config.plugins =
        'about,' +
        'a11yhelp,' +
        'basicstyles,' +
        'bidi,' +
        'blockquote,' +
        'clipboard,' +
        'colorbutton,' +
        'colordialog,' +
        'copyformatting,' +
        'contextmenu,' +
        'dialogadvtab,' +
        'div,' +
        'elementspath,' +
        'enterkey,' +
        'entities,' +
        'filebrowser,' +
        'find,' +
        'floatingspace,' +
        'font,' +
        'format,' +
        'forms,' +
        'horizontalrule,' +
        'htmlwriter,' +
        'image,' +
        'iframe,' +
        'indentlist,' +
        'indentblock,' +
        'justify,' +
        'language,' +
        'link,' +
        'list,' +
        'liststyle,' +
        'magicline,' +
        'maximize,' +
        'newpage,' +
        'pagebreak,' +
        'pastefromgdocs,' +
        'pastefromlibreoffice,' +
        'pastefromword,' +
        'pastetext,' +
        'editorplaceholder,' +
        'preview,' +
        'print,' +
        'removeformat,' +
        'resize,' +
        'save,' +
        'selectall,' +
        'showblocks,' +
        'showborders,' +
        'smiley,' +
        'sourcearea,' +
        'specialchar,' +
        'stylescombo,' +
        'tab,' +
        'table,' +
        'tableselection,' +
        'tabletools,' +
        'templates,' +
        'toolbar,' +
        'undo,' +
        'uploadimage,' +
        'wysiwygarea';

    // ⭐ Toolbar rút gọn còn 15 nút
    config.toolbar = [
        { name: 'document', items: ['Source', 'Preview', 'Print'] },

        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'Undo', 'Redo'] },

        { name: 'editing', items: ['Find', 'Replace', 'SelectAll'] },

        { name: 'basicstyles',
          items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'RemoveFormat'] },

        { name: 'paragraph',
          items: [
              'NumberedList', 'BulletedList', 'Outdent', 'Indent',
              'Blockquote',
              'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'
          ]
        },
    ];
};
