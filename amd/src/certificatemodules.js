
// Put this file in path/to/plugin/amd/src
// You can call it anything you like

define(['jquery', 'block_customcertificates/utils'],
    function ($, Utils) {
        var init = function () {
            $("#btn-add").on("click", function () {
                var $options = $('#available-modules option:selected').sort().clone();
                $('#available-modules option:selected').remove();
                $('#selected-modules').append($options);
                save();

            });
            $("#btn-remove").on("click", function () {
                var $options = $('#selected-modules option:selected').sort().clone();
                $('#selected-modules option:selected').remove();
                $('#available-modules').append($options);
                save();
            });

            function save() {
                var certificate = { id: $("#hdf_certificate_id").val(), moduleids: getSelectedCourses() };
                if (certificate.id === undefined || certificate.id === "" || certificate.id === null) return;

                try {
                    var methodname = 'block_customcertificates_associate_modules_with_certificate';
                    var data = { certificateid: certificate.id, moduleids: certificate.moduleids };
                    var promises = Utils.ajaxCall(methodname, data);
                    promises[0].then(function (data) { });
                } catch (e) {
                    console.log(e.message);
                }
            }
            function getSelectedCourses() {
                var options = $('#selected-modules option');

                var arrayIds = $.map(options, function (option) {
                    return option.value;
                });

                var moduleids = arrayIds.join("|");
                return moduleids;
            }
        }
        return {
            init: init
        };
    });