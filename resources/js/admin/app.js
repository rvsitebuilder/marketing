/**
 * Edit
 */

$(document).ready(function() {
    var items_datatable = $("#items-table").DataTable({
        dom: "lfrtip",
        processing: false,
        serverSide: false,
        autoWidxh: false,

        order: [[0, "asc"]],
        searchDelay: 500
    });
});

$(document).ready(function() {
    /* Submit create form */
    $(".crud-submit-create").on("click", function() {
        if ($("#create_item_form").valid() == false) {
            return false;
        }

        var form_action = routeAppStore;

        var name = $("#create_item_form input[name=name]").val();
        var detail = $("#create_item_form textarea[name=detail]").val();

        /* Start ajax loading */

        $.ajax({
            type: "POST",
            url: form_action,
            data: {
                name: name,
                detail: detail
            },
            success: function(data) {
                if (!data.errors) {
                    alert(data.msg);
                    item_id = data.item_id;
                    action_button =
                        '<button class="uk-button edit-post-modal" data-uk-modal="{target:\'#editItemModal\'}" data-id="' +
                        item_id +
                        '">edit</button>' +
                        '<button type="button" class="uk-button" onclick="UIkit.modal.confirm(\'Are you sure to delete <b>' +
                        item_id +
                        "</b> ?' , function(){ crud_post_delete('" +
                        item_id +
                        "'); });\">x</button>";

                    var items_datatable = $("#items-table").DataTable();
                    items_datatable.row
                        .add([name, detail, action_button])
                        .draw(false);
                    $("#createItemModal").remove();

                    let modal = UIkit.modal("#createItemModal");
                    modal.hide();
                }
                /* Stop ajax loading */
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert("Have some error from backend");
                alert(thrownError);
                /* Stop ajax loading */
            }
        });
    });

    // Load data to EDIT Form
    $(".edit-post-modal").on("click", function() {
        var item_id = $(this).data("id");

        var name = $(this)
            .parent()
            .parent()
            .find(".item_name")
            .text();
        var detail = $(this)
            .parent()
            .parent()
            .find(".item_detail")
            .text();

        $("#update_item_form input[name=id]").val(item_id);

        $("#update_item_form input[name=name]").val(name);
        $("#update_item_form textarea[name=detail]").val(detail);
    });

    /* Submit update form */
    $(".crud-submit-update").on("click", function() {
        if ($("#update_item_form").valid() == false) {
            return false;
        }

        var item_id = $("#update_item_form input[name=id]").val();

        var form_action = routeAppUpdate;
        form_action = form_action.replace(/itemid/, item_id);

        var name = $("#update_item_form input[name=name]").val();
        var detail = $("#update_item_form textarea[name=detail]").val();

        /* Start ajax loading */

        $.ajax({
            type: "POST",
            url: form_action,
            data: {
                name: name,
                detail: detail
            },
            success: function(data) {
                if (!data.errors) {
                    alert(data.msg);

                    var rowID = "#tr_" + item_id;
                    $("#items-table " + rowID + " .item_name").html(name);
                    $("#items-table " + rowID + " .item_detail").html(detail);

                    let modal = UIkit.modal("#editItemModal");
                    modal.hide();
                }
                /* Stop ajax loading */
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert("Have some error from backend");
                alert(thrownError);
                /* Stop ajax loading */
            }
        });
    });

    //TODO: raise error function
});

function crud_post_delete(item_id) {
    post_action = routeAppDestroy;
    post_action = post_action.replace(/itemid/, item_id);

    var rowID = "#tr_" + item_id;
    tr_parents = $("#items-table " + rowID);

    $.ajax({
        url: post_action,
        type: "post",
        data: {},
        success: function(data) {
            if (!data.errors) {
                alert(data.msg);
                var items_datatable = $("#items-table").DataTable();
                items_datatable
                    .row(tr_parents)
                    .remove()
                    .draw();
            }
            /* Stop ajax loading */
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert("Have some error from backend");
            alert(thrownError);
            /* Stop ajax loading */
        }
    });
}
