$(document).ready(function () {
    // Esto sirve para refrescar el contenido del modal
    // cuando se cierra y se abre uno distinto
    // De otra manera siempre muestra el contenido del primer link cargado
    $('body').on('hidden.bs.modal', '.modal', function () {
        // console.log(this);
        $(this).removeData();
    });

    /**
     * Submit de los formularios con columna de checks  Grid
     */
    $('.checks-submit').on('click', function (ev) {

        setCheckedItems();

        if ($.trim($.cookie('checkedItems')).length <= 0) {
            ev.preventDefault();
            return;
        }

    });

    // Activa los tooltips de las tablas
    $('table').tooltip({'selector': '[rel=tooltip]'});

    /**
     * Anula una compra generando su respectiva NOTA DE CREDITO y asociandola
     */
    $('#cancel_purchase').live('click', function (ev) {
        if (!confirm('Cancelar compra emitiendo un comprobante negativo?')) {
            return;
        }

        $.ajax({
            url: Yii.app.createUrl('purchase/purchase/cancel', {'id': $('#purchase_id').val()}),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status == 0) {
                    alert(data.errors);
                }
                var win = window.open(Yii.app.createUrl('purchase/contract/generatecancellationcontract', {'id': data.purchase_id}), '_blank');
                $.fn.yiiGridView.update('owner-purchase-grid');
                $('#modal-purchase').modal('hide');

            },
            error: function () {
                //console.log('error');
            }
        });
    });

    /** Filtra por status purchase */
    $('input[name*=status_search]').on('click', function () {

        var checked_purchase_statuses = new Array();

        $('input[name*=status_search]:checked').each(function () {
            checked_purchase_statuses.push($(this).val());
        });

        $.cookie('checkedPurchaseStatuses', checked_purchase_statuses, {path: '/'});

        refreshGrid();
    });

    /** Filtra por status dispatchnote */
    $('input[name*=dispatchnote_search]').on('click', function () {

        var checked_statuses = new Array();

        $('input[name*=dispatchnote_search]:checked').each(function () {
            checked_statuses.push($(this).val());
        });

        $.cookie('checkedDispatchnoteStatuses', checked_statuses, {path: '/'});

        refreshGrid();
    });

    // Evita que los links deshabilitados funcionen
    $('.disabled a').on('click', function (ev) {
        ev.preventDefault();
    });

		
    /**
     * Popula un <select class="model_select">
     * Cuando un <select class="brand_select"> dispara el evento "change"
     */
    $('.brand_select').on('change', function () {
        var brand = $(this).find(":selected").val();

        $.ajax({
            url: Yii.app.createUrl('purchase/purchase/getmodelsjson', {'brand': brand}),
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                $('.model_select option').each(function() {
                    if ($(this).val()) {
                        $(this).remove();
                    }
                });

				jQuery.each(data, function(key, val) {

					var o = new Option(val.model);
					o.value = val.model;
					$('.model_select').append(o);
				});
			},
			error: function() {
				//console.log('error');
			}
		});
	});
        

    if ($('#User_company_id').val() != '') {
        $('#User_point_of_sale_id').parent().fadeIn();
    }

    $('#User_company_id').on('change', function () {

        if ($('#User_company_id').val() != '') {
            $('#User_point_of_sale_id').parent().fadeIn();
        } else {
            $('#User_point_of_sale_id').parent().fadeOut();
        }

        var company_id = $(this).val();

        $.ajax({
            url: Yii.app.createUrl('admin/pointofsale/pointsofsale', {'company_id': company_id}),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                $('#User_point_of_sale_id').html('');
                jQuery.each(data, function (key, val) {
                    var o = new Option(val.name, val.id);
                    $('#User_point_of_sale_id').append(o);
                });
            },
            error: function () {
                //console.log('error');
            }
        });
    });

    $('#Authassignment_itemname').on('change', function () {
        console.log($('#Authassignment_itemname').val());
        if ($('#Authassignment_itemname').val() != '') {
            $('.dependent').fadeIn();
        } else {
            $('.dependent').fadeOut();
        }
    });

});

/**
 * DATE FILTER FUNCTIONS
 * @return {[type]} [description]
 */
function refreshGrid() {
    $('.grid-view').each(function () {
        $.fn.yiiGridView.update($(this).attr('id'));
    })
};

function resetDateFilter(prefix) {
    $.removeCookie(prefix + "from");
    $.removeCookie(prefix + "to");
    location.reload();
};

/**
 * Guarda en una cookie los checkbox seleccionados en un Grid
 * Para mantenerlos aunque se pagine
 */
function setCheckedItems() {
    // Si la cookie no esta creada la crea vacia
    if ($.cookie('checkedItems') == undefined) {
        $.cookie('checkedItems', '', {path: '/'});
    }

    // convierte los ids separados por coma en la cookie en un array
    var oldCheckedItems = $.cookie('checkedItems').split(',');

    // Trae los nuevos ids seleccionados
    var newCheckedItems = $.fn.yiiGridView.getChecked("selectableGrid", "purchase_selected");

    var checkedItems = oldCheckedItems.concat(newCheckedItems);

    // Se liminan los duplicados
    checkedItems = uniq(checkedItems);

    // Se les restan los que se deseleccionaron
    checkedItems = arrayDiff(checkedItems, getUncheckeds());

    $.cookie('checkedItems', checkedItems, {path: '/'});
};


/**
 * Recibe un array y devuelve otro sin los datos duplicados del recibido
 * @param  Array a array original
 * @return Array   Array sin items duplicados
 */
function uniq(a) {
    var prims = {"boolean": {}, "number": {}, "string": {}}, objs = [];

    return a.filter(function (item) {
        var type = typeof item;
        if (type in prims)
            return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
        else
            return objs.indexOf(item) >= 0 ? false : objs.push(item);
    });
};


function arrayDiff(a1, a2) {
    return a1.filter(function (i) {
        return a2.indexOf(i) < 0;
    });
};


/**
 * Devuelve los elementos deseleccionados de la columna de checbocks
 * de Grid
 * @return {[type]} [description]
 */
function getUncheckeds() {
    var unch = [];
    $('[name^=purchase_selected]').not(':checked,[name$=all]').each(function () {
        unch.push($(this).val());
    });
    return unch.toString();
};

/**
 * Esta función la invocan los formularios validados por ajax
 * Si tiene errores los muestra
 * Si no tiene errores redirecciona el sitio al action del form
 * @param  form element  form     El formulario que la invoca
 * @param  json  data     Lo que devuelve la validación
 * @param  {Boolean} hasError [description]
 */
function formSend(form, data, hasError)
{
    if (data.error != 0) {
        $.ajax({
            url: Yii.app.createUrl('default/message', {'type': 'alert-error'}),
            type: 'POST',
            data: data.message,
            dataType: 'html',
            success: function (data) {
                $('#messages-wrapper').append(data);
            }
        });
    } else {
        window.location = $(form).attr('action');
    }
}