// Put this file in path/to/plugin/amd/src
// You can call it anything you like

define(['jquery', 'block_custommodules/utils'],
    function ($, Utils) {
        var init = function () {
            $("#btn-add").on("click", function () {
                var $options = $('#available-courses option:selected').sort().clone();
                $('#available-courses option:selected').remove();
                $('#selected-courses').append($options);
                save();

            });
            $("#btn-remove").on("click", function () {
                var $options = $('#selected-courses option:selected').sort().clone();
                $('#selected-courses option:selected').remove();
                $('#available-courses').append($options);
                save();
            });

            function save() {
                var module = { id: $("#hdf_module_id").val(), courseids: getSelectedCourses() };

                if (module.id === undefined || module.id === "" || module.id === null) return;

                try {
                    var methodname = 'block_custommodules_associate_courses_with_module';
                    var data = { moduleid: module.id, courseids: module.courseids };
                    var promises = Utils.ajaxCall(methodname, data);
                    promises[0].then(function (data) { });
                } catch (e) {
                    console.log(e.message);
                }
            }
            function getSelectedCourses() {
                var options = $('#selected-courses option');

                var arrayIds = $.map(options, function (option) {
                    return option.value;
                });

                courseids = arrayIds.join("|");
                return courseids;
            }
        }
        return {
            init: init
        };
    });