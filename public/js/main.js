  //$('[data-toggle="tooltip"]').tooltip();
    $('[data-tooltip="tooltip"]').tooltip();
    $('[data-popover="popover"]').popover();
    $('.clockpicker').clockpicker();
    $(".loader").fadeOut("slow");
    $("table thead").addClass('text-uppercase');
    $("select").select2();
    /*-------------------*/
    $(".file_input").change(function() {
        let id = $(this).attr('id');
        let valor = $(this).val().split('\\').pop();
        if (id == '') {
            $(".file_label").text(valor);
        } else {
            $(".file_label_" + id).text(valor);
        }
        if (valor == '' && id == '') {
            $(".file_label").text('Falta archivo');
            $(this).val('')
        } else {
            $(".file_label").text(valor);
        }
        if (valor == '' && id != '') {
            $(".file_label_" + id).text('Falta archivo');
            $('#' + id).val('')
        } else {
            $(".file_label_" + id).text(valor);
        }
    });