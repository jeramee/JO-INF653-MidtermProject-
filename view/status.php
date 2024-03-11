<!-- ../view/status.php -->
<?php

$created = filter_input(INPUT_GET, "created", FILTER_UNSAFE_RAW);
$updated = filter_input(INPUT_GET, "updated", FILTER_UNSAFE_RAW);
$deleted = filter_input(INPUT_GET, "deleted", FILTER_UNSAFE_RAW);

if ($created) {
    echo "New ToDo item is successfully added";
}
if ($updated) {
    echo "ToDo item is successfully updated";
}
if ($deleted) {
    echo "ToDo item is successfully deleted";
}
?>
