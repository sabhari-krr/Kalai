<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Management</title>
    <!-- Bootstrap CDN's -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Sweetalert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .add_service {
            display: none;
        }
    </style>
</head>

<body class="d-flex">
    <!-- Left Container -->
    <div class="left vh-100 bg-secondary d-flex flex-column w-25 p-5">
        <h3 class="fw-bolder mb-5 text-light">Server Management</h3>
        <button id="addServerBtn" class="btn btn-warning mb-5">Add Server</button>
        <button id="addServiceBtn" class="btn btn-danger">Add Service</button>
    </div>
    <!-- Right Container -->
    <div class="right vh-100  w-75 p-5">
        <div class="add_server">
            <form id="addServer">
                <div class="mb-3">
                    <label for="server_name" class="form-label">Server Name</label>
                    <input type="text" class="form-control" id="server_name" name="server_name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Server</button>
            </form>
        </div>
        <div class="add_service">
            <form id="addService">
                <div class="mb-3">
                    <label for="server_select" class="form-label">Select Server</label>
                    <select class="form-select" id="server_select" name="server_name">
                        <?php

                        $query = "SELECT server_name FROM server";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['server_name']}'>{$row['server_name']}</option>";
                        }
                        ?>
                    </select>
                    <label for="service_name" class="form-label">Service Name</label>
                    <input type="text" class="form-control" id="service_name" name="service_name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Service</button>
            </form>
        </div>
    </div>
    <!--  -->
    <script>
        $(document).ready(function() {
            $(".add_server").show();
            $(".add_service").hide();

            // Add Server button clicked
            $("#addServerBtn").click(function() {
                $(".add_server").show();
                $(".add_service").hide();
            });

            // Add Service button clicked
            $("#addServiceBtn").click(function() {
                $(".add_server").hide();
                $(".add_service").show();
            });
            // Adding Server
            $('#addServer').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize() + "&action=add_server";
                $.ajax({
                    type: 'POST',
                    url: 'actions.php',
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#addServer")[0].reset();
                        if (res.status == 200) {
                            // alert(res.message);
                            Swal.fire({
                                title: "Success!",
                                text: "Server added!",
                                icon: "success",
                            });
                        } else if (res.status == 400) {
                            Swal.fire({
                                title: "Oops!",
                                text: res.message,
                                icon: "warning",
                            });
                        }
                        // log
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
            // Adding Services to the Server
            $('#addService').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize() + "&action=add_service";
                $.ajax({
                    type: 'POST',
                    url: 'actions.php',
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#addService")[0].reset();
                        if (res.status == 200) {
                            // alert(res.message);
                            Swal.fire({
                                title: "Success!",
                                text: "Service added!",
                                icon: "success",
                            });
                        } else if (res.status == 400) {
                            Swal.fire({
                                title: "Oops!",
                                text: res.message,
                                icon: "warning",
                            });
                        }
                        // log
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>

</html>