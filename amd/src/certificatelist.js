// Put this file in path/to/plugin/amd/src
// You can call it anything you like

define(['jquery', 'block_customcertificates/utils'],
    function ($, Utils) {
        var init = function () {
            $('.delete').on('click', function (event) {
                event.preventDefault();
                $btn = $(this);
                var certificateid = $btn.data('certificateid');
                var title = "¿Realmente quieres eliminar este certificado?";
                var text = "¡No será posible recuperar este certificado después de eliminarlo!";
                Utils.confirmMessage(title, text)
                    .then(function (result) {
                        if (result.value) {
                            deleteCertificate(certificateid);
                            $btn.parent().parent().remove();
                        }
                    });
            });
        }
        function deleteCertificate(certificateid) {
            if (certificateid === undefined || certificateid === "" || certificateid === null) return;

            try {
                var methodname = 'block_customcertificates_delete_certificate';
                var data = { certificateid: certificateid };
                var promises = Utils.ajaxCall(methodname, data);
                promises[0].then(function (data) {
                    console.log(data);
                    var title = 'Excluído!';
                    var text = 'Certificado ' + certificateid + ' excluído.';
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