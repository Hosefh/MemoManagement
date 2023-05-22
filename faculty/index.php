<?php
include "../dbcon.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo Management</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />

</head>

<body class="fixed-left">

    <!-- Top Bar Start -->
    <?php include('./includes/navbar.php'); ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include('./includes/sidebar.php'); ?>
    <!-- Left Sidebar End -->

    <main class="mt-5 pt-3 px-4">
        <div class="row">
            <div class="col-md-18 mb-2">
                <div class="card mb-3 shadow-lg">
                    <div class="row g-0">
                        <div class="col-md-1" style="background-color: #04293A;">
                            <img src="https://cdn-icons-png.flaticon.com/512/3209/3209265.png" class="img-fluid"
                                width="100" height="150" center alt="...">
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <h5 class="card-title">Memo Recieved</h5>
                                <?php
                                $query = mysqli_query($conn, "SELECT COUNT(*) as `count` from memo_route where faculty_name = '" . $_SESSION['user_name'] . "';");
                                $number = mysqli_fetch_array($query);
                                ?>
                                <h1 class="card-text fw-bold">
                                    <?php echo $number['count'] ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datatable for memo records -->
        <div class="card shadow-lg">
            <div class="card-header">
                <span><i class="bi bi-file-text-fill me-2"></i></span> Memorandums
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover data-table" style="width: 100%">
                        <div class="m-2">
                            <thead class>
                                <tr>
                                    <th>Memo #</th>
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT DISTINCT(m.`id`),(m.`from`),(m.`subject`),(m.`content`),(m.`additional_info`),(m.`memo_number`), DATE_FORMAT(`date_from`, '%M %d, %Y ') AS `date`, DATE_FORMAT(`date_to`, '%M %d, %Y ') AS `date2` FROM `memo` m
                                INNER JOIN `memo_route` mr ON mr.`memo_id` = m.`id`
                                WHERE m.`is_void` = 0 AND mr.`faculty_name`= '" . $_SESSION['user_name'] . "';";
                                $actresult = mysqli_query($conn, $sql);

                                while ($result = mysqli_fetch_assoc($actresult)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $result['memo_number'] ?>
                                        </td>
                                        <td>
                                            <?php echo $result['from'] ?>
                                        </td>
                                        <td class="text-truncate" style="max-width: 300px;">
                                            <?php echo $result['subject'] ?>
                                        </td>
                                        <td>
                                            <?php echo $result['date'] ?>
                                        </td>
                                        <td>
                                            <?php echo $result['date2'] ?>
                                        </td>
                                        
                                        <td>
                                            <a href="./generateMemo.php?id=<?php echo $result['id'] ?>" target=”_blank”
                                                class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i
                                                        class="bi bi-folder2-open"></i></span> View Memo</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end of memo datatable -->
    </main>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#myBtn").click(function () {
                $("#myModal").modal("toggle");
            });
        });
    </script>

</body>

</html>