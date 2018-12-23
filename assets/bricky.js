$(document).on('rex:ready', function (e, container) {
    function brickyToggleCtypeContent($grid) {
        $grid = $grid.split('-');
        $ctypes.find('li:not([data-bricky-ctype="locked"])').css('display', 'none');
        for (var i = 0; i < $grid.length; i++) {
            $ctypes.find('li:not([data-bricky-ctype="locked"])').eq(i).css('display', 'block');
        }
        $ctypes.find('li:first-child a').click();
    }

    var $module = container.find('[data-bricky="module"]');
    if ($module.length > 0) {
        var $ctypes = $module.find('[data-bricky="ctypes"]');
        var $ctypesOrder = $module.find('[data-bricky="ctypesOrder"]');
        var $grids = $module.find('[data-bricky="grids"] input[type="radio"]');
        var $selectedGrid = $module.find('[data-bricky="selectedGrid"]').val();
        var $view = $module.find('[data-bricky-view]').data('bricky-view');

        if (typeof $view !== 'undefined' && $view === 'SLICES') {
            // Alle fieldsets display none setzen
            $module.find('[data-bricky-selectable]').each(function(i) {
                $(this).hide();
            });

            $(document).on('rex:ready', function (event, container) {
                $('[data-bricky-select-a-brick] option:selected').each(function () {
                    var value = $(this).val();
                    if (value === '') {
                        $(this).closest('[data-bricky-select-a-brick]').siblings('[data-bricky-selectable]').hide();
                    } else {
                    }
                });
            });

            // only show selected elements on edit
            $module.find('[data-bricky-select-a-brick] option:selected').each(function(i) {
                var value = $(this).val();
                $(this).closest('[data-bricky-select-a-brick]').siblings('[data-bricky-selectable="'+value+'"]').show();

            });

            $(document).on('change', '[data-bricky-select-a-brick] select', function () {
                $(this).closest('[data-bricky-select-a-brick]').siblings('[data-bricky-selectable]').hide();
                $(this).closest('[data-bricky-select-a-brick]').siblings('[data-bricky-selectable="'+$(this).val()+'"]').show();
            });

        }

        if (typeof $ctypesOrder !== 'undefined' && $ctypesOrder.length > 0) {

            $ctypes.sortable({
                axis : "x",
                items: '> li:not([data-bricky-ctype="locked"])',
                update: function (e, ui) {
                    var csv = [];
                    $ctypes.find('li:not([data-bricky-ctype="locked"])').each(function(i){
                        csv.push($(this).attr('data-id'));
                    });
                    $ctypesOrder.val( csv.join() );
                }
            });
        }
        if(typeof $selectedGrid === 'undefined') {
            // Kein Gridauswahl möglich
            // ersten Tab "Einstellungen" oeffnen
            $ctypes.find('[data-id] a').click();
        }
        else {
            if ($grids.length >= 2 && $selectedGrid === '') {
                // Tab "Einstellungen" oeffnen
                $ctypes.find('[data-bricky="ctypeGrid"] a').click();
            }
            if ($grids.length >= 2 && $selectedGrid !== '') {
                brickyToggleCtypeContent($selectedGrid);
            }
            if ($grids.length >= 2) {
                $grids.change(function() {
                    brickyToggleCtypeContent(this.value);
                });
            }

            if ($grids.length === 1 && $selectedGrid === '') {
                $grids.first().prop('checked', true);
                brickyToggleCtypeContent($grids.first().val());
                $ctypes.find('li[data-bricky="ctypeGrid"]').css('display', 'none');
            }
            if ($grids.length === 1 && $selectedGrid !== '') {
                brickyToggleCtypeContent($selectedGrid);
                $ctypes.find('li[data-bricky="ctypeGrid"]').css('display', 'none');
            }
        }
    }
});
