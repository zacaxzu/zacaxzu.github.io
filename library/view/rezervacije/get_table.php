<?php

if (file_exists('table_data.json')) {
    echo file_get_contents('table_data.json');
} else {
    echo json_encode([]);
}
