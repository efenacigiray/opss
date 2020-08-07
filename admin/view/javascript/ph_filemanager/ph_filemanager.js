/* PH File Manager
 *
 * @copyright (C) 2020 PrimeHover (Gustavo Fernandes)
 * @desc This extension enhances the current OpenCart 3.x file manager and adds a crop section to edit images.
 * @version 2.0.0
 *
 * To view the full documentation for this extension, visit:
 * http://gufernandes.com.br/post/ph-file-manager
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see [http://www.gnu.org/licenses/].
 */
function PHFileManager(target, thumb) {
    this.thumb      = (typeof thumb != 'undefined' && thumb != '' ? thumb : '');
    this.target     = (typeof target != 'undefined' && target != '' ? target : '');
    this.range      = null;
    this.searchTerm = '';
    this.directory  = [];
    this.page       = 1;

    var tempToken   = getURLVar('user_token');
    tempToken       = tempToken.split('#');
    this.token      = tempToken[0];

    this.url        = {
        load:         'index.php?route=extension/module/ph_filemanager/phLoad&user_token='   + this.token,
        move:         'index.php?route=extension/module/ph_filemanager/phMove&user_token='   + this.token,
        crop:         'index.php?route=extension/module/ph_filemanager/phCrop&user_token='   + this.token,
        remove:       'index.php?route=extension/module/ph_filemanager/phDelete&user_token=' + this.token,
        rename:       'index.php?route=extension/module/ph_filemanager/phRename&user_token=' + this.token,
        folder:       'index.php?route=extension/module/ph_filemanager/phFolder&user_token=' + this.token,
        localUpload:  'index.php?route=extension/module/ph_filemanager/phUpload&user_token=' + this.token,
        remoteUpload: 'index.php?route=extension/module/ph_filemanager/phRemote&user_token=' + this.token
    };

    this.$modal         = $('#modal-image');
    this.$breadcrumb    = $("#phfm-breadcrumb");
    this.$status        = $("#phfm-status");
    this.$library       = $("#phfm-library");
    this.$details       = $("#phfm-details");
    this.$pagination    = $("#phfm-pagination");
    this.helpers        = JSON.parse($("#phfm-helpers").val());

    this.selectedItems = [];
    this.croppingDirectory = '';
    this.hasDropped = false;

    /* Gets the window selection */
    var sel = window.getSelection();
    if (sel.rangeCount) {
        this.range = sel.getRangeAt(0);
    }

    this.staticEventHandlers();
    this.sendLoad();
}
PHFileManager.prototype.constructor = PHFileManager;

/**
 * Loads static handlers
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.staticEventHandlers = function() {
    var obj = this;

    var $image = $("#editorImage");

    this.$modal.on('hidden.bs.modal', function () {
        obj.selectedItems = [];
    });

    this.$modal.on('shown.bs.modal', function() {

        /* It has to be initialized after the modal is shown */
        $image.cropper({
            viewMode: 0,
            zoomOnWheel: false,
            crop: function (e) {
                $("#editorStatus").html('<b>' + obj.helpers.editor_width + '</b>: ' + e.width.toFixed(0) + 'px<br /><b>' + obj.helpers.editor_height + '</b>: ' + e.height.toFixed(0) + 'px');
            }
        });

    });

    /* Refreshes the directory */
    $('#button-refresh').on('click', function(e) {
        e.preventDefault();
        obj.selectedItems = [];
        obj.formatSelectItems();
        obj.sendLoad();
    });

    /* Uploads the files to the corresponding folder */
    $("#inputImage").change(function() {
        obj.handlerUpload();
    });

    /* Accomplishes a remote upload of an image */
    $("#button-remote").click(function() {
        obj.handlerRemote();
    });

    /* Deletes the selected image(s) */
    $("#button-delete").click(function() {
        obj.handlerDelete();
    });

    /* Renames the selected file/directory */
    $('#button-rename').click(function() {
        obj.handlerRename();
    });

    /* Deletes the selected item(s) on delete press */
    $('body').keydown(function(event) {
        var code = event.keyCode || event.which;
        if (code == 46 && obj.selectedItems.length > 0) {
            obj.handlerDelete();
        }
    });

    /* Creates a new folder */
    $("#button-folder").click(function() {
        obj.handlerCreateFolder();
    });

    /* Searches inside the current folder */
    $('#button-search').click(function() {
        obj.handlerSearch();
    });

    /* Searches inside the current folder */
    $('input[name="search"]').keypress(function(e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            obj.handlerSearch();
        }
    });

    $("#phfm-help").click(function(e) {
        e.preventDefault();
        swal({
            title: 'PH File Manager',
            text: obj.helpers.text_help_desc + '<br /><br /><small>PrimeHover Plugins<br /><a href="http://primehover.gufernandes.com.br/ph-file-manager?utm_source=filemanager&utm_medium=downloaded" target="_blank">' + obj.helpers.text_full_doc + '</a></small>',
            html: true
        });
    });

    /* IMAGE CROPPER HANDLERS */

    /* Uploads an image via Blob URL to be cropped */
    $("#inputImageEditor").change(function() {

        var URL = window.URL || window.webkitURL;
        var blobURL;

        if (URL) {
            var files = this.files;
            var file;

            if (!$image.data('cropper')) {
                return;
            }

            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    blobURL = URL.createObjectURL(file);
                    $image.one('built.cropper', function () {
                        URL.revokeObjectURL(blobURL);
                    }).cropper('reset').cropper('replace', blobURL);
                    $("#editorInitial").hide();
                    $("#editorDivCanvas").show();
                    $(this).val('');
                    obj.croppingDirectory = '';
                } else {
                    swal(obj.helpers.error_filetype);
                }
            }
        } else {
            swal(obj.helpers.error_upload_blob);
        }

    });

    /* Sets the drag mode */
    $("#editorDragMode").click(function() {
        $image.cropper('setDragMode', 'move');
    });

    /* Sets the crop mode */
    $("#editorCropMode").click(function() {
        $image.cropper('setDragMode', 'crop');
    });

    /* Sets the zoom in */
    $("#editorZoomIn").click(function() {
        $image.cropper('zoom', 0.1);
    });

    /* Sets the zoom out */
    $("#editorZoomOut").click(function() {
        $image.cropper('zoom', -0.1);
    });

    /* Sets the rotate left */
    $("#editorRotateLeft").click(function() {
        $image.cropper('rotate', -90);
    });

    /* Sets the rotate left */
    $("#editorRotateRight").click(function() {
        $image.cropper('rotate', 90);
    });

    /* Sets the flip horizontal */
    $("#editorFlipHorizontal").click(function() {
        var data = $(this).attr('data-scale');
        $image.cropper('scaleX', -data);
        $(this).attr('data-scale', -data);
    });

    /* Sets the flip vertical */
    $("#editorFlipVertical").click(function() {
        var data = $(this).attr('data-scale');
        $image.cropper('scaleY', -data);
        $(this).attr('data-scale', -data);
    });

    /* Cancels the crop */
    $("#editorCancelCrop").click(function() {
        $image.cropper('clear');
    });

    /* Resets the crop */
    $("#editorResetCrop").click(function() {
        $image.cropper('reset');
    });

    /* Saves the image that has been cropped */
    $("#editorSaveCrop").click(function() {
        obj.$modal.css('overflow-y', 'hidden');
        swal({
            title: obj.helpers.savecrop_title,
            text: obj.helpers.savecrop_desc,
            type: "input",
            showCancelButton: true,
            animation: "slide-from-top",
            inputPlaceholder: obj.helpers.savecrop_placeholder,
            inputValue: name[0],
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: obj.helpers.button_ok,
            cancelButtonText: obj.helpers.button_cancel
        }, function(inputValue) {
            if (inputValue === false || inputValue.trim() === "" || inputValue.trim().length < 3 || inputValue.trim().length > 128) {
                swal.showInputError(obj.helpers.error_rename);
                return false;
            } else {
                obj.$modal.css('overflow-y', 'auto');
            }

            var newImage = $("#editorImage").cropper('getCroppedCanvas');
            newImage = newImage.toDataURL();

            $.ajax({
                url: obj.url.crop,
                type: 'POST',
                data: {
                    directory: obj.croppingDirectory,
                    name: inputValue.trim(),
                    image: newImage
                },
                success: function (data) {
                    if (typeof data.success != 'undefined') {
                        swal('', data.success, 'success');
                        obj.sendLoad();
                    } else if (typeof data.error != 'undefined') {
                        swal('', data.error, 'error');
                    }
                }
            });

        });

    });
};

/**
 * Loads default event handlers
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.loadEventHandlers = function() {
    var obj = this;

    this.selectedItems = [];

    $(".draggable").draggable({
        revert: function(dropped) {
            if (!dropped) {
                $('.draggable').animate({opacity: 1, left: 0, top: 0}, 500);
            }
        },
        opacity: 0.25,
        start: function(event, ui) {
            if (typeof ui.helper != 'undefined') {
                $('.draggable').each(function() {
                    if (obj.selectedItems.indexOf($(this).data('info')) > -1) {
                        $(this).addClass('top-z');
                    }
                });
                $(this).addClass('top-z');
                obj.pushSelectedItem(ui.helper.data('info'));
            }
        },
        stop: function(event, ui) {
            if (typeof ui.helper != 'undefined') {
                ui.helper.removeClass('top-z');
            }
        },
        drag: function(event, ui) {

            $(this).addClass('top-z');
            var currentLoc = $(this).position();
            var orig = ui.originalPosition;
            var offsetLeft = currentLoc.left-orig.left;
            var offsetTop = currentLoc.top-orig.top;
            var element = 0;
            var l = 0;
            var t = 0;

            $('.draggable').each(function() {
                if (obj.selectedItems.indexOf($(this).data('info')) > -1) {
                    element = $(this);
                    l = element.context.clientLeft;
                    t = element.context.clientTop;
                    element.css('left', l+offsetLeft);
                    element.css('top', t+offsetTop);
                }
            });
        }
    });
    $(".droppable").droppable({
        accept: '.draggable',
        activeClass: "draggable-active",
        hoverClass: "draggable-hover",
        drop: function(event, ui) {
            ui.draggable.draggable('option', 'revert', function(){return false});
            var info = $(this).data('info');
            if (typeof info != 'undefined' && info == 'parent') {
                obj.handlerMove('');
                obj.hasDropped = true;
            } else if (typeof info != 'undefined' && info.hasOwnProperty('path')) {
                obj.handlerMove(info.path);
                obj.hasDropped = true;
            }
        }
    });
    $(".selectable").selectable({
        cancel: '.directory',
        selecting: function( event, ui ) {
            ui = $(ui.selecting);
            if (ui.attr('class').indexOf('item-library') > -1 && obj.selectedItems.indexOf(ui.data('info')) == -1) {
                obj.pushSelectedItem(ui.data('info'));
                obj.formatSelectItems();
            }
        },
        unselecting: function( event, ui ) {
            ui = $(ui.unselecting);
            if (ui.attr('class').indexOf('item-library') > -1) {
                var index = obj.selectedItems.indexOf(ui.data('info'));
                if (index > -1) {
                    obj.selectedItems.splice(index, 1);
                    obj.formatSelectItems();
                }
            }
        },
        selected: function( event, ui ) {
            ui = $(ui.selected).children('.item-library');
            if (ui.length == 1 && obj.selectedItems.indexOf(ui.data('info')) == -1) {
                obj.pushSelectedItem(ui.data('info'));
                obj.formatSelectItems();
            }
        },
        unselected: function( event, ui ) {
            ui = $(ui.unselected).children('.item-library');
            if (ui.length == 1) {
                var index = obj.selectedItems.indexOf(ui.data('info'));
                if (index > -1) {
                    obj.selectedItems.splice(index, 1);
                    obj.formatSelectItems();
                }
            }
        }
    });

    /* Cancels and cleans the selection */
    $("#button-cancel-selection").click(function() {
        var selectable = $(".selectable");
        selectable.children('div').removeClass('ui-selected');
        selectable.children('div').removeClass('ui-selecting');
        selectable.selectable("refresh");
        obj.handlerCancelSelection();
        obj.formatSelectItems();
    });

    /* Opens a directory */
    $('a.directory').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var selectable = $(".selectable");
        var info = $(this).parent().data('info');
        if (e.ctrlKey == false && info !== 'parent') {
            selectable.children('div').removeClass('ui-selected');
            $(this).parent().parent().addClass('ui-selected');
            obj.selectedItems = [];
            obj.loadDetails(info);
            $("#button-cancel-selection").show();
        } else if (e.ctrlKey == true) {
            var index = obj.selectedItems.indexOf(info);
            if (index == -1) {
                $(this).parent().parent().addClass('ui-selected');
                obj.pushSelectedItem(info);
            } else {
                $(this).parent().parent().removeClass('ui-selected');
                obj.selectedItems.splice(index, 1);
            }
            obj.formatSelectItems();
        }
        selectable.selectable("refresh");
    }).on('dblclick', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (!obj.hasDropped) {
            var info = $(this).parent().data('info');
            if (typeof info != 'undefined' && info == 'parent') {
                obj.directory.pop();
                obj.searchTerm = '';
                obj.page = 1;
                obj.sendLoad();
                obj.selectedItems = [];
                obj.formatSelectItems();
            } else if (typeof info != 'undefined' && info.hasOwnProperty('name')) {
                obj.directory.push(info.name);
                obj.searchTerm = '';
                obj.page = 1;
                obj.sendLoad();
                obj.selectedItems = [];
                obj.formatSelectItems();
            }
        }
    });

    /* Selects an image and see its details */
    $('a.image').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var selectable = $(".selectable");
        var info = $(this).parent().data('info');
        if (e.ctrlKey == false) {
            selectable.children('div').removeClass('ui-selected');
            $(this).parent().parent().addClass('ui-selected');
            obj.selectedItems = [];
            obj.loadDetails(info);
            $("#button-cancel-selection").show();
        } else {
            var index = obj.selectedItems.indexOf(info);
            if (index == -1) {
                $(this).parent().parent().addClass('ui-selected');
                obj.pushSelectedItem(info);
            } else {
                $(this).parent().parent().removeClass('ui-selected');
                obj.selectedItems.splice(index, 1);
            }
            obj.formatSelectItems();
        }
        selectable.selectable("refresh");
    });

    /* Goes to another page */
    $('.pagination a').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var page = parseInt($(this).attr('href').replace('#', ''));
        if (page > 0) {
            obj.page = page;
            obj.sendLoad();
        }
    });
};

/**
 * Loads dynamic event handlers
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.loadDynamicEventHandlers = function() {
    var obj = this;

    /* Initializes all the tooltips */
    $('[data-toggle="tooltip"]').tooltip();

    /* Selects the image and places it into the form */
    $("#btnSelect").click(function() {
        if (obj.selectedItems.length > 0) {
            var done = false;

            if (obj.thumb != '') {
                $("#" + obj.thumb).find('img').attr('src', obj.selectedItems[0].thumb);
                done = true;
            }
            if (obj.target != '') {
                $("#" + obj.target).attr('value', obj.selectedItems[0].path);
                done = true;
            }
            if (done != true && obj.range) {
                var img = document.createElement('img');
                img.src = obj.selectedItems[0].href;
                obj.range.insertNode(img);
            }
            obj.$modal.modal('hide');
            obj.selectedItems = [];
        }
    });

    /* Deletes the selected image(s) */
    $("#btnDelete").click(function() {
        obj.handlerDelete();
    });

    /* Renames a file or directory */
    $("#btnRename").click(function() {
        obj.handlerRename();
    });

    /* Sends an image to the image editor to crop */
    $("#btnCrop").click(function() {
        if (obj.selectedItems.length == 1 && obj.selectedItems[0] != 'parent') {
            $("#editorInitial").hide();
            $("#editorDivCanvas").show();
            $("#phfm-navs a:last").on('shown.bs.tab', function() {
                $("#editorImage").cropper('reset').cropper('replace', obj.selectedItems[0].href).cropper('resize');
            }).tab('show');
            obj.croppingDirectory = obj.directory.join('/');
        }
    });
};

/**
 * Send an ajax request to load the requested folder
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.sendLoad = function() {
    var obj = this;

    $.ajax({
        url: obj.url.load,
        type: 'POST',
        data: obj.getData(),
        beforeSend: function() {
            obj.printStatusBeforeSend();
            obj.$library.css({ opacity: 0.4 });
        },
        success: function(data) {
            data = JSON.parse(data);
            obj.formatData(data);
            obj.loadEventHandlers();
            obj.formatBreadcrumb();
            obj.printStatusSuccess();
            obj.$library.css({ opacity: 1 });
        },
        error: function(x) {
            obj.printStatusError();
            obj.$library.css({ opacity: 1 });
        }
    });
};

/**
 * Gets the data the load function will use
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 * @return {{filter_name: string, thumb: string, page: number, directory: string, target: string}}
 */
PHFileManager.prototype.getData = function() {
    return {
        thumb: this.thumb,
        target: this.target,
        filter_name: this.searchTerm,
        directory: this.directory.join('/'),
        page: this.page
    }
};

/**
 * Loads the details of a selected file/directory
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 * @param details
 */
PHFileManager.prototype.loadDetails = function(details) {
    var str = '<p class="text-center">';
    if (details.type === 'directory') {
        str += '<i class="fa fa-folder-open fa-5x img-thumbnail" style="color: #1e91cf; padding: 7px 20px 7px 27px"></i><br />'
    } else {
        str += '<img src="' + details.thumb + '" class="img-responsive img-thumbnail" /><br />';
    }
    str += '<b>' + this.helpers.details_name + '</b>: ' + details.name + '<br />';
    str += '<b>' + this.helpers.details_type + '</b>: ' + details.type + '<br />';
    str += '<b>' + this.helpers.details_size + '</b>: ' + this.formatBytes(details.size) + '<br />';
    str += '<b>' + this.helpers.details_location + '</b>: ' + details.path + '</p>';

    str += '<p class="text-center">';
    if (details.type !== 'directory') {
        str += '<button class="btn btn-success" id="btnSelect" data-toggle="tooltip" data-placement="top" title="' + this.helpers.button_select + '"><i class="fa fa-check"></i></button> ';
        str += '<button class="btn btn-primary" id="btnCrop" data-toggle="tooltip" data-placement="top" title="' + this.helpers.button_crop + '"><i class="fa fa-crop"></i></button> ';
    }
    str += '<button class="btn btn-info" id="btnRename" data-toggle="tooltip" data-placement="top" title="' + this.helpers.button_rename + '"><i class="fa fa-pencil"></i></button> ';
    str += '<button class="btn btn-danger" id="btnDelete" data-toggle="tooltip" data-placement="top" title="' + this.helpers.button_delete + '"><i class="fa fa-trash"></i></button> ';
    str += '</p>';

    this.selectedItems = [];
    this.pushSelectedItem(details);

    this.$details.html(str);
    this.loadDynamicEventHandlers();
};

/**
 * Push a selected item to the list
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 * @param item
 */
PHFileManager.prototype.pushSelectedItem = function(item) {
    if (this.selectedItems.indexOf(item) == -1) {
        this.selectedItems.push(item);
    }
};

/**
 * Formats the JSON data from load to the HTML
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 * @param data
 */
PHFileManager.prototype.formatData = function(data) {
    var str = '';

    if (data.directory != '' && typeof data.parent != 'undefined') {
        str += '<div class="col-md-3 col-sm-4 col-xs-6 text-center padding-item"><div class="item-library thumbnail-out droppable ignore" data-info="parent"><a href="#" class="thumbnail directory"><i class="fa fa-folder fa-5x"></i></a><label>..</label></div></div>';
    }

    if (typeof data.images != 'undefined') {
        for (var i = 0; i < data.images.length; i++) {
            str += '<div class="col-md-3 col-sm-4 col-xs-6 text-center padding-item">';
            if (data.images[i].type == 'directory') {
                str += '<div class="item-library thumbnail-out draggable droppable" data-info=\'' + JSON.stringify(data.images[i]) + '\'><a href="#" class="thumbnail directory"><i class="fa fa-folder fa-5x"></i></a><label>' + data.images[i].name.substr(0, 20) + '</label></div>';
            } else if (data.images[i].type == 'image') {
                str += '<div class="item-library thumbnail-out draggable" data-info=\'' + JSON.stringify(data.images[i]) + '\'><a href="#" class="thumbnail image"><img src="' + data.images[i].thumb + '" alt="' + data.images[i].name + '" title="' + data.images[i].name + '" /></a><label>' + data.images[i].name.substr(0, 20) + '</label></div>'
            }
            str += '</div>';
        }
    }

    if (typeof data.pagination != 'undefined') {
        this.$pagination.html(data.pagination);
    }

    this.$library.html(str);
};

/**
 * Formats a number of bytes into human readable size
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 * @param bytes
 * @param decimals
 * @return {string}
 */
PHFileManager.prototype.formatBytes = function(bytes, decimals) {
    if(bytes == 0) return '0 B';
    var k = 1000;
    var dm = decimals + 1 || 2;
    var sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
};

/**
 * Formats the selected items
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.formatSelectItems = function() {
    var json = {};
    var totalSize = 0;
    var str = (this.selectedItems.length == 1 ? this.helpers.selecting_singular.replace('%s', this.selectedItems.length) : this.helpers.selecting_plural.replace('%s', this.selectedItems.length));
    for (var i = 0; i < this.selectedItems.length; i++) {
        json = this.selectedItems[i];
        if (typeof json.size != 'undefined') {
            totalSize += parseInt(json.size);
        }
    }
    str += ' (' + this.formatBytes(totalSize) + ')';

    this.formatCancelSelection();
    this.$details.html(str);
};

/**
 * Formats the breadcrumb above the list of files/directories
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.formatBreadcrumb = function() {
    var str = '';
    str += '<ol class="breadcrumb breadcrumb-manager">';
    str += '<li><a' + (this.directory.length == 0 ? ' class="active"' : '') + '>' + this.helpers.text_library_folder + '</a></li>';
    for (var i = 0; i < this.directory.length; i++) {
        str += '<li><a' + (i+1 == this.directory.length ? ' class="active"' : '') + '>' + this.directory[i] + '</a></li>';
    }
    str += '</ol>';
    this.$breadcrumb.html(str);
};

/**
 * Toggles the cancel selection button
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.formatCancelSelection = function() {
    if (this.selectedItems.length > 0) {
        $("#button-cancel-selection").show();
    } else {
        $("#button-cancel-selection").hide();
    }
};

/**
 * Formats the before send request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.printStatusBeforeSend = function() {
    this.handlerCancelSelection();
    this.$status.html('<span><i class="fa fa-spin fa-spinner"></i> ' + this.$status.data("text-loading") + '</span>');
};

/**
 * Formats the success message after a request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.printStatusSuccess = function() {
    this.$status.html('<span class="text-success"><i class="fa fa-check"></i> ' + this.$status.data("text-success") + '</span>');
};

/**
 * Formats the error message after a request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.printStatusError = function() {
    this.$status.html('<span class="text-danger"><i class="fa fa-times"></i> ' + this.$status.data("text-error") + '</span>');
};

/**
 * Handles the cancel selection action
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.handlerCancelSelection = function() {
    this.selectedItems = [];
    this.formatCancelSelection();
};

/**
 * Handles the upload request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.handlerUpload = function() {
    var obj = this;
    var count = $("#inputImage")[0].files.length;
    var directory = obj.directory.join('/');
    var formData = new FormData($("#form-upload")[0]);

    $.ajax({
        url: obj.url.localUpload + '&directory=' + directory,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        beforeSend: function() {
            obj.printStatusBeforeSend();
            obj.$details.html('<span>' + (count == 1 ? obj.helpers.uploading_singular : obj.helpers.uploading_plural) + '</span>');
        },
        success: function(data) {
            if (typeof data.success != 'undefined') {
                obj.printStatusSuccess();
                obj.$details.html('<span class="text-success"><i class="fa fa-check"></i> ' + data.success + '</span>');
                obj.sendLoad();
            } else if (typeof data.error != 'undefined') {
                obj.printStatusError();
                obj.$details.html('<span class="text-danger"><i class="fa fa-times"></i> ' + data.error + '</span>');
            }
        },
        error: function(x) {
            obj.printStatusError();
        },
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    obj.$details.html('<span>' + (count == 1 ? obj.helpers.uploading_singular : obj.helpers.uploading_plural) + ' (' + percentComplete + '%)</span>');
                }
            }, false);
            return xhr;
        }
    });
};

/**
 * Handles the remote request function
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.handlerRemote = function() {
    var obj = this;
    swal({
        title: obj.helpers.remote_upload_title,
        text: obj.helpers.remote_upload_desc,
        type: "input",
        showCancelButton: true,
        animation: "slide-from-top",
        inputPlaceholder: obj.helpers.remote_upload_placeholder,
        closeOnConfirm: false,
        confirmButtonText: obj.helpers.button_ok,
        cancelButtonText: obj.helpers.button_cancel
    }, function(inputValue){
        if (inputValue === false || inputValue.trim() === "") {
            swal.showInputError(obj.helpers.error_url);
            return false
        } else {
            swal.close();
        }

        $.ajax({
            url: obj.url.remoteUpload,
            type: 'POST',
            data: { directory: obj.directory.join('/'), url: inputValue.trim() },
            beforeSend: function() {
                obj.printStatusBeforeSend();
                obj.$details.html('<span>' + obj.helpers.uploading_singular + '</span>');
            },
            success: function(data) {
                if (typeof data.success != 'undefined') {
                    obj.printStatusSuccess();
                    obj.$details.html('<span class="text-success"><i class="fa fa-check"></i> ' + data.success + '</span>');
                    obj.sendLoad();
                } else if (typeof data.error != 'undefined') {
                    obj.printStatusError();
                    obj.$details.html('<span class="text-danger"><i class="fa fa-times"></i> ' + data.error + '</span>');
                }
            },
            error: function(x) {
                obj.printStatusError();
            }
        });

    });
};

/**
 * Handles the create folder request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.handlerCreateFolder = function() {
    var obj = this;
    this.$modal.css('overflow-y', 'hidden');
    swal({
        title: obj.helpers.folder_title,
        text: obj.helpers.folder_desc,
        type: "input",
        showCancelButton: true,
        animation: "slide-from-top",
        inputPlaceholder: obj.helpers.folder_placeholder,
        closeOnConfirm: false,
        confirmButtonText: obj.helpers.button_ok,
        cancelButtonText: obj.helpers.button_cancel
    }, function(inputValue){
        if (inputValue === false || inputValue.trim() === "" || inputValue.length < 3 || inputValue.length > 128) {
            swal.showInputError(obj.helpers.error_folder);
            return false;
        } else {
            obj.$modal.css('overflow-y', 'auto');
            swal.close();
        }

        $.ajax({
            url: obj.url.folder,
            type: 'POST',
            data: { directory: obj.directory.join('/'), name: inputValue.trim() },
            beforeSend: function() {
                obj.printStatusBeforeSend();
                obj.$details.html('<span>' + obj.helpers.creating_folder + '</span>');
            },
            success: function(data) {
                if (typeof data.success != 'undefined') {
                    obj.printStatusSuccess();
                    obj.$details.html('<span class="text-success"><i class="fa fa-check"></i> ' + data.success + '</span>');
                    obj.sendLoad();
                } else if (typeof data.error != 'undefined') {
                    obj.printStatusError();
                    obj.$details.html('<span class="text-danger"><i class="fa fa-times"></i> ' + data.error + '</span>');
                }
            },
            error: function(x) {
                obj.printStatusError();
            }
        });
    });
};

/**
 * Handles the delete request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.handlerDelete = function() {
    var obj = this;

    if (obj.selectedItems.length > 0) {

        swal({
            title: obj.helpers.delete_title,
            text: (obj.selectedItems.length == 1 ? obj.helpers.delete_desc_singular : obj.helpers.delete_desc_plural),
            type: "warning",
            showCancelButton: true,
            animation: "slide-from-top",
            closeOnConfirm: false,
            confirmButtonText: obj.helpers.button_ok,
            cancelButtonText: obj.helpers.button_cancel
        }, function(){

            var paths = [];
            for (var i = 0; i < obj.selectedItems.length; i++) {
                if (typeof obj.selectedItems[i].path != 'undefined') {
                    paths.push(obj.selectedItems[i].path);
                }
            }
            swal.close();

            if (paths.length > 0) {
                $.ajax({
                    url: obj.url.remove,
                    type: 'POST',
                    data: {path: paths},
                    beforeSend: function () {
                        obj.printStatusBeforeSend();
                        obj.$details.html('<span>' + obj.helpers.deleting + '</span>');
                    },
                    success: function (data) {
                        if (typeof data.success != 'undefined') {
                            obj.printStatusSuccess();
                            obj.$details.html('<span class="text-success"><i class="fa fa-check"></i> ' + data.success + '</span>');
                            obj.sendLoad();
                        } else if (typeof data.error != 'undefined') {
                            obj.printStatusError();
                            obj.$details.html('<span class="text-danger"><i class="fa fa-times"></i> ' + data.error + '</span>');
                        }
                    },
                    error: function (x) {
                        obj.printStatusError();
                    }
                });
            } else {
                obj.printStatusError();
            }

        });
    }
};

/**
 * Handles rename request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.handlerRename = function() {
    var obj = this;
    obj.$modal.css('overflow-y', 'hidden');
    if (obj.selectedItems.length == 1) {
        var name = obj.selectedItems[0].name.replace(' ', '').split('.');
        if (name.length > 1) {
            name.pop();
        }
        name = name.join('');

        swal({
            title: obj.helpers.rename_title,
            text: obj.helpers.rename_desc,
            type: "input",
            showCancelButton: true,
            animation: "slide-from-top",
            inputPlaceholder: obj.helpers.rename_placeholder,
            inputValue: name,
            closeOnConfirm: false,
            confirmButtonText: obj.helpers.button_ok,
            cancelButtonText: obj.helpers.button_cancel
        }, function (inputValue) {
            if (inputValue === false || inputValue.trim() === "" || inputValue.trim().length < 3 || inputValue.trim().length > 128 || obj.selectedItems[0].name == inputValue.trim()) {
                swal.showInputError(obj.helpers.error_rename);
                return false
            } else {
                obj.$modal.css('overflow-y', 'auto');
                swal.close();
            }

            $.ajax({
                url: obj.url.rename,
                type: 'POST',
                data: {
                    directory: obj.directory.join('/'),
                    oldName: obj.selectedItems[0].name.replace(' ', ''),
                    newName: inputValue.trim()
                },
                beforeSend: function () {
                    obj.printStatusBeforeSend();
                    obj.$details.html('<span>' + obj.helpers.renaming + '</span>');
                },
                success: function (data) {
                    if (typeof data.success != 'undefined') {
                        obj.printStatusSuccess();
                        obj.$details.html('<span class="text-success"><i class="fa fa-check"></i> ' + data.success + '</span>');
                        obj.sendLoad();
                    } else if (typeof data.error != 'undefined') {
                        obj.printStatusError();
                        obj.$details.html('<span class="text-danger"><i class="fa fa-times"></i> ' + data.error + '</span>');
                    }
                },
                error: function (x) {
                    obj.printStatusError();
                }
            });
        });
    }
};

/**
 * Handles the move file request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 * @param newDirectory
 */
PHFileManager.prototype.handlerMove = function(newDirectory) {
    var obj = this;

    var parent = this.selectedItems.indexOf('parent');
    if (parent > -1) {
        this.selectedItems.splice(parent, 1);
    }

    if (this.selectedItems.length > 0) {

        var oldDirectory = obj.directory.join('/');
        if (newDirectory.trim() == '') {
            var element = obj.directory.pop();
            newDirectory = obj.directory.join('/');
            obj.directory.push(element);
        }

        $.ajax({
            url: obj.url.move,
            type: 'POST',
            data: {
                selected: obj.selectedItems,
                oldDirectory: oldDirectory,
                newDirectory: newDirectory.trim()
            },
            beforeSend: function () {
                obj.printStatusBeforeSend();
                obj.$details.html('<span>' + obj.helpers.moving + '</span>');
            },
            success: function (data) {
                obj.hasDropped = false;
                if (typeof data.success != 'undefined') {
                    obj.printStatusSuccess();
                    obj.$details.html('<span class="text-success"><i class="fa fa-check"></i> ' + data.success + '</span>');
                    obj.sendLoad();
                } else if (typeof data.error != 'undefined') {
                    obj.printStatusError();
                    obj.$details.html('<span class="text-danger"><i class="fa fa-times"></i> ' + data.error + '</span>');
                }
            },
            error: function (x) {
                obj.hasDropped = true;
                obj.printStatusError();
            }
        });
    }
};

/**
 * Handles a search request
 *
 * @author Gustavo Fernandes
 * @since 16/05/2020
 */
PHFileManager.prototype.handlerSearch = function() {
    this.searchTerm = $('input[name="search"]').val();
    this.selectedItems = [];
    this.formatSelectItems();
    this.sendLoad();
};