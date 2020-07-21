// Put this file in path/to/plugin/amd/src
// You can call it anything you like

define(['jquery', 'block_custommodules/utils'],
    function ($, Utils) {
        var init = function () {
            $('.delete').on('click', function (event) {
                event.preventDefault();
                $btn = $(this);
                var moduleid = $btn.data('moduleid');
                var title = "¿Realmente quieres eliminar este módulo?";
                var text = "¡No será posible recuperar este módulo después de eliminarlo!";
                Utils.confirmMessage(title, text)
                    .then(function (result) {
                        if (result.value) {
                            excluirModulo(moduleid);
                            $btn.parent().parent().remove();
                        }
                    });
            });
        }
        function excluirModulo(moduleid) {
            if (moduleid === undefined || moduleid === "" || moduleid === null) return;

            try {
                var methodname = 'block_custommodules_delete_module';
                var data = { moduleid: moduleid };
                var promises = Utils.ajaxCall(methodname, data);
                promises[0].then(function (data) {
                    console.log(data);
                    var title = 'Excluído!';
                    var text = 'Módulo ' + moduleid + ' excluído.';
                    Utils.successMessage(title, text)
                        .then(function () {
                            var $hidden = $("#hd-url");
                            window.location.replace($hidden.val());
                        });
                });
            } catch (e) {
                console.log(e.message);
            }
        }
        return {
            init: init
        };
    });