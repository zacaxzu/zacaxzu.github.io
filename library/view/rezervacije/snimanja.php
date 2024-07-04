<?php
if (isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0') {
    require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
} else {
    require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
}
?>
<?php require_once __DIR__ . '/../_header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            color: inherit;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
      /*  $(document).ready(function() {
            var baseUrl = "<?php //echo dirname($_SERVER['SCRIPT_NAME']); ?>";

            function loadTable() {
                $.ajax({
                    url: baseUrl + "/view/rezervacije/get_table.php",
                    method: "GET",
                    success: function(data) {
                        console.log("Success:", data);
                        var tableData = JSON.parse(data);
                        var tableHtml = '<table><thead><tr><th>Vrijeme</th><th>Ponedjeljak</th><th>Utorak</th><th>Srijeda</th><th>Četvrtak</th><th>Petak</th></tr></thead><tbody>';
                        for (var i = 0; i < tableData.length; i++) { // Prolazak po redovima
                            tableHtml += '<tr>';
                            tableHtml += '<td contenteditable="false">' + tableData[i][0] + '</td>'; // Prvi stupac su vremena
                            for (var j = 1; j < tableData[i].length; j++) { // Starta od 1 td. se preskoči prvi stupac
                                tableHtml += '<td contenteditable="true" data-row="' + i + '" data-day="' + (j - 1) + '">' + tableData[i][j] + '</td>';
                            }
                            tableHtml += '</tr>';
                        }
                        tableHtml += '</tbody></table>';
                        $("#liveTable").html(tableHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.error("Response Text:", xhr.responseText);
                        $("#liveTable").html("Error fetching data: " + xhr.responseText);
                    }
                });
            }

            // Učitavanje tablice
            loadTable();

            function saveTableData(row, day, value) {
                $.ajax({
                    url: baseUrl + "/view/rezervacije/save_table.php",
                    method: "POST",
                    data: {
                        row: row,
                        day: day,
                        value: value
                    },
                    success: function(response) {
                        $("#responseMessage").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Save AJAX Error:", status, error);
                        console.error("Response Text:", xhr.responseText);
                        $("#responseMessage").html("Error saving data: " + xhr.responseText);
                    }
                });
            }

            $(document).on('input', 'td[contenteditable="true"]', function() {
                var row = $(this).data('row');
                var day = $(this).data('day');
                var value = $(this).text().trim();
                saveTableData(row, day, value);
            });

            // Refresh tablice svake 3 sek
            /*
            setInterval(function() {
                loadTable();
            }, 3000);
            */
        });*/
    </script>
</head>

<body>
    <h1>Raspored za snimanja</h1>
    <div id="liveTable"></div>
    <div id="snimanja" style="position: relative; overflow: hidden; width: 1300px; height: 750px;">
    <iframe id="iframe" src="http://localhost:8081" scrolling="no" frameborder="no" style="top:-2210px; width: 1300px; height: 3000px; display:hidden; position: absolute; "></iframe>
      </div>
</body>

</html>
