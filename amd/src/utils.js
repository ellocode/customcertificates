// Put this file in path/to/plugin/amd/src
// You can call it anything you like

define(['jquery', 'core/ajax', 'theme_bootstrapbase/sweetalert2'],
    function ($, Ajax, Swal) {

        var init = function () {
            console.log("utils inicializado");
        }
        var ajaxCall = function (methodname, data) {
            return Ajax.call([{
                methodname: methodname,
                args: data,
                fail: function (data) {
                    throw (data);
                }
            }]);
        }
        var confirmMessage = function (title, text) {
            return Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            });

        }
        var successMessage = function (title, text) {
            return Swal.fire(title, text, "success");
        }
        return {
            init: init,
            confirmMessage: confirmMessage,
            successMessage: successMessage,
            ajaxCall: ajaxCall
        };
    });