$(document).ready(function () {

    var handleCheckboxes = function (html, rowIndex, colIndex, cellNode) {
        var $cellNode = $(cellNode);
        var $check = $cellNode.find(':checked');
        return ($check.length) ? ($check.val() == 1 ? 'Yes' : 'No') : $cellNode.text();
    };

    var activeSub = $(document).find('.active-sub');
    if (activeSub.length > 0) {
        activeSub.parent().show();
        activeSub.parent().parent().find('.arrow').addClass('open');
        activeSub.parent().parent().addClass('open');
    }

    $(document).on('click','.dataTable input[type=checkbox]',function () {
        $(this).parents('tr').toggleClass('selected');
    })
    window.dtDefaultOptions = {
        retrieve: true,
        dom: 'lfBrtip<"actions">',
        columnDefs: [],
        "iDisplayLength": 10,
        "aaSorting": [],
        buttons: [
            // {
            //     extend: 'copy',
            //     exportOptions: {
            //         columns: ':visible',
            //         format: {
            //             body: handleCheckboxes
            //         }
            //     }
            // },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        body: handleCheckboxes
                    }
                }
            },
            // {
            //     extend: 'excel',
            //     exportOptions: {
            //         columns: ':visible',
            //         format: {
            //             body: handleCheckboxes
            //         }
            //     }
            // },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        body: handleCheckboxes
                    }
                }
            },
            // {
            //     extend: 'print',
            //     exportOptions: {
            //         columns: ':visible',
            //         format: {
            //             body: handleCheckboxes
            //         }
            //     }
            // },
            'colvis'
        ]
    };
    $('.datatable, .dataTable').each(function () {
        if ($(this).hasClass('dt-select')) {
            window.dtDefaultOptions.select = {
                style: 'multi',
                selector: 'td:first-child'
            };

            window.dtDefaultOptions.columnDefs.push({
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            });
        }
        $(this).dataTable(window.dtDefaultOptions);
    });
    if (typeof window.route_mass_crud_entries_destroy != 'undefined') {
        console.log($('.datatable, .ajaxTable, .dataTable').siblings('.actions'))
    }

    $(document).on('click', '.js-delete-selected', function (e) {
        if (confirm('Are you sure?')) {
            e.preventDefault();

            var ids = [];

            $(this).closest('.actions').siblings('.datatable,.dataTable, .ajaxTable').find('tbody tr.selected').each(function () {
                ids.push($(this).data('entry-id'));
            });

            $.ajax({
                method: 'POST',
                url: $(this).attr('href'),
                data: {
                    _token: _token,
                    ids: ids
                }
            }).done(function () {
                location.reload();
            });
        }

        return false;
    });

    $(document).on('click', '#select-all', function () {
        var selected = $(this).is(':checked');
        $(this).closest('table.datatable, table.dataTable, table.ajaxTable').find('td:first-child').each(function () {
            if (selected != $(this).closest('tr').hasClass('selected')) {
                $(this).click();
            }
        });
    });

    $('.mass').click(function () {
        if ($(this).is(":checked")) {
            $('.single').each(function () {
                if ($(this).is(":checked") == false) {
                    $(this).click();
                }
            });
        } else {
            $('.single').each(function () {
                if ($(this).is(":checked") == true) {
                    $(this).click();
                }
            });
        }
    });

    $('.page-sidebar').on('click', 'li > a', function (e) {

        if ($('body').hasClass('page-sidebar-closed') && $(this).parent('li').parent('.page-sidebar-menu').size() === 1) {
            return;
        }

        var hasSubMenu = $(this).next().hasClass('sub-menu');

        if ($(this).next().hasClass('sub-menu always-open')) {
            return;
        }

        var parent = $(this).parent().parent();
        var the = $(this);
        var menu = $('.page-sidebar-menu');
        var sub = $(this).next();

        var autoScroll = menu.data("auto-scroll");
        var slideSpeed = parseInt(menu.data("slide-speed"));
        var keepExpand = menu.data("keep-expanded");

        if (keepExpand !== true) {
            parent.children('li.open').children('a').children('.arrow').removeClass('open');
            parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(slideSpeed);
            parent.children('li.open').removeClass('open');
        }

        var slideOffeset = -200;

        if (sub.is(":visible")) {
            $('.arrow', $(this)).removeClass("open");
            $(this).parent().removeClass("open");
            sub.slideUp(slideSpeed, function () {
                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    }
                }
            });
        } else if (hasSubMenu) {
            $('.arrow', $(this)).addClass("open");
            $(this).parent().addClass("open");
            sub.slideDown(slideSpeed, function () {
                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    }
                }
            });
        }
        if (hasSubMenu == true || $(this).attr('href') == '#') {
            e.preventDefault();
        }
    });

    $('.select2').select2();

    setTimeout(function () {
        if (typeof CKEDITOR === 'undefined') {
            return;
        }

        Object.values(CKEDITOR.instances).forEach((editor) => {
            let color = null;
            var observer = new MutationObserver(function(mutations) {
                const newElement = mutations[mutations.length-1].target;

                if(newElement.nodeName === 'SPAN') {
                    const color = newElement?.style.color;

                    if(editor.element.$.changed) {
                        editor.element.$.changed(newElement);
                    }
                    
                    if(color){
                        editor.container.$.querySelector('.cke_button__textcolor_icon').style.setProperty('--text-color', color);
                    }
                }
                
            });
             
            observer.observe(editor.document.$, {attributes: false, childList: true, characterData: false, subtree:true});

            editor.document.$.querySelectorAll('span').forEach((element) => {
                if(element.style.color && !color) {
                    color = element.style.color;
                }
            })

            if(color) {
                editor.container.$.querySelector('.cke_button__textcolor_icon').style.setProperty('--text-color', color);
            }
        });
    }, 1000)
});

function processAjaxTables() {
    $('.ajaxTable').each(function () {
        window.dtDefaultOptions.processing = true;
        window.dtDefaultOptions.serverSide = true;
        if ($(this).hasClass('dt-select')) {
            window.dtDefaultOptions.select = {
                style: 'multi',
                selector: 'td:first-child'
            };

            window.dtDefaultOptions.columnDefs.push({
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            });
        }
        $(this).DataTable(window.dtDefaultOptions);
        if (typeof window.route_mass_crud_entries_destroy != 'undefined') {
            $(this).siblings('.actions').html('<a href="' + window.route_mass_crud_entries_destroy + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
        }
    });

}

function rgb2hex(rgb) {
    rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);

    if(!rgb) {
        return null;
    }
    
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }

    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

