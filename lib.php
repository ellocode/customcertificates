<?php
function block_custommodules_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{
    // Leave this line out if you set the itemid to null in make_pluginfile_url (set $itemid to 0 instead).
    $itemid = array_shift($args); // The first item in the $args array.

    // Use the itemid to retrieve any relevant data records and perform any security checks to see if the
    // user really does have access to the file in question.

    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/' . implode('/', $args) . '/'; // $args contains elements of the filepath
    }

    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'block_custommodules', $filearea, $itemid, $filepath, $filename);

    if (!$file) {
        return false; // The file does not exist.
    }

    // We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering. 
    send_stored_file($file, 86400, 0, $forcedownload, $options);
}
function block_custommodules_get_fontawesome_icon_map()
{
    return  [
        'mod_forum: i / pinned'  =>  'fa-map-pin',
        'mod_forum: t / selected'  =>  'fa-check',
        'mod_forum: t / subscrito'  =>  'fa-envelope-o',
        'mod_forum: t / unsubscribed'  =>  'fa-envelope-open-o',
    ];
}
