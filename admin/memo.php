<?php
session_start();
include "../dbcon.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="google" value="notranslate">
  <title>Memorandum Management</title>

  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
  <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#facdep').change(function() {
        var facdepartment = $(this).val();
        $.ajax({
          url: "action.php",
          method: "post",
          data: {
            department: facdepartment
          },
          success: function(data) {
            $("#facnames").html(data);
          }
        });
      });
    });
  </script>

  <!-- <script>
  $('select').selectpicker();
</script> -->

</head>

<body class="fixed-left">

  <!-- Top Bar Start -->
  <?php include('includes/navbar.php'); ?>
  <!-- ========== Left Sidebar Start ========== -->
  <?php include('includes/sidebar.php'); ?>
  <!-- Left Sidebar End -->

  <main class="mt-5 pt-3 px-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-header">
              <span><i class="bi bi-file-text-fill me-2"></i></span> Memorandums
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-hover data-table" style="width: 100%">

                  <div class="m-2">
                    <!-- Button HTML (to Trigger Modal) -->


                    <div class="row justify-content-start">
                      <div class="col-sm-2">
                        <button type="button" id="myBtn" class="btn btn-outline-success">
                          <span class="me-2"><i class="bi bi-file-earmark-plus"></i></span>
                          Add Memo
                        </button>
                      </div>
                    </div>
                  </div>
              </div>

              <thead>
                <tr>
                  <th>Memo #</th>
                  <!-- <th>To</th> -->
                  <th>From</th>
                  <th>Subject</th>
                  <th>Date Created</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody style="cursor: pointer" id="myBtn">
                <?php
                //query sa table nga kuhaon tanan memo nga same ug from sa user_name
                $sql = "SELECT *, DATE_FORMAT(`date_created`, '%M %d, %Y ') as `date_created` FROM `memo` where is_void = 0 and `from` = '" . $_SESSION['user_name'] . "' order by memo_number asc;";
                $actresult = mysqli_query($conn, $sql);

                while ($result = mysqli_fetch_assoc($actresult)) {
                ?>
                  <tr>
                    <td>
                      <?php echo $result['memo_number'] ?>
                    </td>
                    <!-- <td>
               <?php echo $result['send_to'] ?>
               </td> -->
                    <td>
                      <?php echo $result['from'] ?>
                    </td>
                    <td class="text-truncate" style="max-width: 500px;">
                      <?php echo $result['subject'] ?>
                    </td>
                    <td>
                      <?php echo $result['date_created'] ?>
                    </td>
                    <td>
                      <div class="d-grid gap-2 d-md-flex">
                        <a href="./generateMemo.php?id=<?php echo $result['id'] ?>" target=”_blank” class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-folder2-open"></i></span> View Memo</a>
                        ||
                        <a href="#edit<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-pen"></i></span>
                          Edit</a>
                        ||
                        <a href="#del<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="me-2"><i class="bi bi-trash"></i></span> Delete
                        </a>
                      </div>
                    </td>
                  </tr>

                  <div class="modal fade" id="del<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <center>
                            <h4 class="modal-title" id="myModalLabel">Delete</h4>
                          </center>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                          <?php
                          $del = mysqli_query($conn, "select * from memo where id='" . $result['id'] . "'");
                          $drow = mysqli_fetch_array($del);
                          ?>
                          <div class="container-fluid">
                            <h5>
                              <center>Are you sure to delete <strong>
                                  <?php echo ucwords($drow['subject']); ?>
                                </strong> from Memo list? This method cannot be undone.</center>
                            </h5>
                          </div>
                        </div>
                        <form method="POST">
                          <input type="hidden" id="id_u" name="deleteid" value="<?php echo $drow['id']; ?>" class="form-control" required>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                            <button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>
                              Delete</button>
                          </div>
                          <?php
                          if (isset($_POST['deleteid'])) {
                            $sql = "DELETE FROM memo WHERE id='" . $_POST['deleteid'] . "'";
                            if ($conn->query($sql) === TRUE) {
                              echo '<script>alert("Deleted Successfully!") 
window.location.href="memo.php"</script>';
                            } else {
                              echo '<script>alert("Deleting Memo Details Failed!\n Please Check SQL Connection String!") 
window.location.href="memo.php"</script>';
                            }
                          }
                          ?>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- /.modal -->
                  <div id="edit<?php echo $result['id']; ?>" class="modal fade" data-bs-backdrop="static" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Memo</h5>
                          <?php
                          $edit = mysqli_query($conn, "select *,date(`date_created`) as `date`,date(`date_from`) as `date_from`,date(`date_to`) as `date_to` from memo where id='" . $result['id'] . "'");
                          $erow = mysqli_fetch_array($edit);
                          ?>
                        </div>
                        <div class="modal-body">

                          <form class="needs-validation" method="POST" enctype="multipart/form-data">
                            <div class="form-row">
                              <div class="row">

                                <input type="number" class="form-control" id="" name="edit_id" value="<?php echo $result['id']; ?>" hidden>
                                <!-- <div class="col-md-6 mb-2">
                                  <label for="validationCustom01">Memo Number:</label>
                                  <input type="number" class="form-control" id="" name="edit_memo_number" value="<?php echo $erow['memo_number']; ?>" placeholder="<?php echo $erow['memo_number']; ?>" readonly>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div> -->
                                <div class="col-md-4 mb-2">
                                  <label for="validationCustom01">Date Created:</label>
                                  <input type="date" class="form-control" id="" name="edit_date" value="<?php echo $erow['date']; ?>" readonly>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                  <label for="validationCustom01">Date From:</label>
                                  <input type="date" class="form-control" id="" name="edit_date_from" value="<?php echo $erow['date_from']; ?>" readonly>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                  <label for="validationCustom01">Date To:</label>
                                  <input type="date" class="form-control" id="" name="edit_date_to" value="<?php echo $erow['date_to']; ?>" readonly>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12 mb-2">
                                <label for="validationCustom01">Subject:</label>
                                <input type="text" class="form-control" id="" name="edit_subject" autocomplete="off" value="<?php echo $erow['subject']; ?>" required>
                                <div class="valid-feedback">
                                  Looks good!
                                </div>
                              </div>
                              <div class="col-md-12 mb-2">
                                <label for="validationCustom01">Content(Activity, Date, Place)</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="edit_content"><?php echo $erow['content']; ?></textarea>
                                <div class="valid-feedback">
                                  Looks good!
                                </div>
                              </div>
                              <div class="col-md-12 mb-2">
                                <label for="validationCustom01">Additional Information:</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="edit_add_info"><?php echo $erow['additional_info']; ?></textarea>
                                <div class="valid-feedback">
                                  Looks good!
                                </div>
                              </div>
                            </div>
                            <div class="row">

                              <div class="dropdown col-md-6 mb-2">
                                <label for="validationCustom01">From:</label>
                                <input type="text" class="form-control" id="" name="edit_from" readonly value="<?php echo $_SESSION['user_name'] ?>">
                              </div>
                              <div class="dropdown col-md-6 mb-2">
                                <label for="validationCustom01">To:</label>
                                <select class="form-select" multiple placeholder="Select Faculty" aria-label="Default select example" name="editsendtofac[]" required>
                                  <?php
                                  $sql5 = "SELECT * FROM `faculty` order by `name` asc;";
                                  $actresult5 = mysqli_query($conn, $sql5);
                                  ?>
                                  <?php while ($result5 = mysqli_fetch_assoc($actresult5)) { ?>
                                    <option value=" <?php echo $result5['name'] ?>"> <?php echo $result5['name'] ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="modal-footer">
                                <input type="reset" class="btn btn-secondary">
                                <button class="btn btn-primary">Save</button>
                              </div>
                          </form>
                          <!-- php code here backend sa edit nga modal -->
                          <?php
                          if (isset($_POST['editsendtofac'])) {
                            $sqlroutedelete = "DELETE FROM memo_route where memo_id = " . $_POST['edit_id'] . ";";
                            $conn->query($sqlroutedelete);
                            foreach ($_POST['editsendtofac'] as $editfacu) {
                              $query1 = mysqli_query($conn, "SELECT count(*) as `count` FROM `memo_route` WHERE faculty_name='" . trim($editfacu) . "' and memo_id=" . $_POST['edit_id'] . ";");
                              $number2 = mysqli_fetch_array($query1);
                              $countchecker = $number2['count'];
                              if ($countchecker == 0) {
                                $sqlroute = "INSERT INTO `memo_route` (memo_id, faculty_name)
                VALUES (" . $_POST['edit_id'] . ",'" . trim($editfacu) . "');";
                                $conn->query($sqlroute);
                                $countchecker = 1;
                              }
                            }

                            $flag = false;
                            $counter = strlen($erow['from']) - strlen($_POST['edit_from']);
                            if ($counter == 0) {
                              if ($flag == false) {
                                $sqledit = "UPDATE `memo` SET `from` = '" . $_POST['edit_from'] . "', `date_created` = '" . $_POST['edit_date'] . "', `subject` = '" . $_POST['edit_subject'] . "',
                    additional_info= '" . $_POST['edit_add_info'] . "' WHERE id = " . $_POST['edit_id'] . ";";
                                $sqledit1 = "UPDATE `memo` SET content='" . $_POST['edit_content'] . "' WHERE id = " . $_POST['edit_id'] . ";";
                                $conn->query($sqledit);
                                if ($conn->query($sqledit1) === true) {
                                  echo '<script>alert("Editing Memo Successful!") 
                        window.location.href="memo.php"</script>';
                                }
                                $flag = true;
                              }
                            } else {
                              if ($flag == false) {
                                $getcount = mysqli_query($conn, "SELECT count(*) as count FROM memo WHERE `from` = '" . trim($_POST['edit_from']) . "';");
                                $count = mysqli_fetch_array($getcount);
                                $number = "0001";
                                $counterget = $count['count'];
                                if ($counterget != 0) {
                                  $number = $count['count'] + 1;
                                  $number = "000" . $number;
                                  $sqledit = "UPDATE `memo` SET `memo_number` = '$number',`from` = '" . $_POST['edit_from'] . "', `date_created` = '" . $_POST['edit_date'] . "', `subject` = '" . $_POST['edit_subject'] . "',
                      content='" . $_POST['edit_content'] . "', additional_info= '" . $_POST['edit_add_info'] . "' WHERE id = " . $_POST['edit_id'] . ";";
                                  if ($conn->query($sqledit) === true) {
                                    echo $counterget;
                                  }
                                } else {
                                  $sqledit = "UPDATE `memo` SET `memo_number` = '0001',`from` = '" . $_POST['edit_from'] . "', `date_created` = '" . $_POST['edit_date'] . "', `subject` = '" . $_POST['edit_subject'] . "',
                      content='" . $_POST['edit_content'] . "', additional_info= '" . $_POST['edit_add_info'] . "' WHERE id = " . $_POST['edit_id'] . ";";
                                  if ($conn->query($sqledit) === true) {
                                    echo $counterget;
                                  }
                                }


                                $flag = true;
                              }
                              echo '<script>alert("Editing Memo Successful!") 
                    window.location.href="memo.php"</script>';
                            }
                          }

                          ?>


                          <!-- Delete -->

                        <?php } ?>
              </tbody>
              <tfoot></tfoot>
              </table>

              <!-- for add modal -->
              <div id="myModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Create Memo</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                      <form class="needs-validation" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                          <div class="row">
                            <!-- <div class="col-md-6 mb-2">
                              <label for="validationCustom01">Memo Number:</label>
                              <input type="number" class="form-control" id="" name="memo_number"
                                value="<?php echo $number; ?>" readonly>
                              <div class="valid-feedback">
                                Looks good!
                              </div>
                            </div> -->
                            <div class="col-md-4 mb-2">
                              <label for="validationCustom01">Date Created:</label>
                              <input type="date" class="form-control" id="" name="date_created" required>
                              <div class="valid-feedback">
                                Looks good!
                              </div>
                            </div>
                            <div class="col-md-4 mb-2">
                              <label for="validationCustom01">Date From:</label>
                              <input type="date" class="form-control" id="" name="date_from" required>
                              <div class="valid-feedback">
                                Looks good!
                              </div>
                            </div>
                            <div class="col-md-4 mb-2">
                              <label for="validationCustom01">Date To:</label>
                              <input type="date" class="form-control" id="" name="date_to" required>
                              <div class="valid-feedback">
                                Looks good!
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12 mb-2">
                            <label for="validationCustom01">Subject:</label>
                            <input type="text" class="form-control" id="" name="subject" autocomplete="off" required>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                          </div>
                          <div class="col-md-12 mb-2">
                            <label for="validationCustom01">Content(Activity, Date, Place)</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                          </div>
                          <div class="col-md-12 mb-2">
                            <label for="validationCustom01">Additional Information:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="add_info"></textarea>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <!-- <div class="col-md-4 mb-2">
                                    <label for="validationCustom01">From:</label>
                                    <input type="text" class="form-control" id="" name="from" autocomplete="off" required>
                                    <div class="valid-feedback">
                                      Looks good!
                                    </div>
                                  </div> -->
                          <div class="dropdown col-md-6 mb-2">
                            <label for="validationCustom01">From:</label>
                            <input type="text" class="form-control" id="" name="from" readonly value="<?php echo $_SESSION['user_name'] ?>">
                          </div>

                          <div class="dropdown col-md-6 mb-2">
                            <label for="validationCustom01">To:</label>
                            <select class="form-select" multiple id="multiple-checkboxes" placeholder="Select Faculty" aria-label="Default select example" name="sendtofac[]">
                              <?php
                              $sql = "SELECT * FROM `faculty` order by `name` asc;";
                              $actresult = mysqli_query($conn, $sql);
                              ?>
                              <?php while ($result = mysqli_fetch_assoc($actresult)) { ?>
                                <option value=" <?php echo $result['name'] ?>"> <?php echo $result['name'] ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="modal-footer">
                            <input type="reset" class="btn btn-secondary">
                            <button class="btn btn-primary">Save</button>
                          </div>
                      </form>
                      <!-- Backend sa add with flagging -->
                      <?php
                      if (isset($_POST['date_created'])) {

                        if ($_POST['date_from'] <= $_POST['date_to']) {
                          $checker = 0;
                          $checkerforpres = 0;
                          $presid = 0;
                          $checkformc = 0;
                          $mcid = 0;
                          if ($_POST['from'] == "BISU-MC Director") {
                            $mysql_date1 = date('Y-m-d', strtotime($_POST['date_from']));
                            $mysql_date2 = date('Y-m-d', strtotime($_POST['date_to']));
                            foreach ($_POST['sendtofac'] as $facname) {
                              $getcountflag1 = mysqli_query($conn, "SELECT COUNT(*) AS `count` FROM `memo` m INNER JOIN 
                              `memo_route` mr ON mr.`memo_id` = m.`id` WHERE m.`from` = 'University President' 
                              AND mr.`faculty_name` = '$facname' AND 
                              (m.`date_from` BETWEEN DATE('$mysql_date1') AND DATE('$mysql_date2') OR
                               m.`date_to` BETWEEN DATE('$mysql_date1') AND DATE('$mysql_date2'));");
                              $countflag1 = mysqli_fetch_array($getcountflag1);
                              if ($countflag1['count'] != 0) {
                                $checker = 1;
                              }

                              $getcountflag2 = mysqli_query($conn, "SELECT COUNT(*) AS `count`, m.`id` FROM `memo` m INNER JOIN 
                              `memo_route` mr ON mr.`memo_id` = m.`id` WHERE m.`from` = 'College of Engineering, Dean' 
                              AND mr.`faculty_name` = '$facname' AND 
                              (m.`date_from` BETWEEN DATE('$mysql_date1') AND DATE('$mysql_date2') OR
                               m.`date_to` BETWEEN DATE('$mysql_date1') AND DATE('$mysql_date2'))");
                              $countflag2 = mysqli_fetch_array($getcountflag2);
                              if ($countflag2['count'] != 0) {
                                $checkerforpres = 1;
                                $mcid = $countflag2['id'];
                              }
                            }
                          } else if ($_POST['from'] == "University President") {
                            $mysql_date1 = date('Y-m-d', strtotime($_POST['date_from']));
                            $mysql_date2 = date('Y-m-d', strtotime($_POST['date_to']));
                            foreach ($_POST['sendtofac'] as $facname) {
                              $getcountflag1 = mysqli_query($conn, "SELECT COUNT(*) AS `count`, m.`id` FROM `memo` m INNER JOIN 
                              `memo_route` mr ON mr.`memo_id` = m.`id` WHERE m.`from` != 'University President' 
                              AND mr.`faculty_name` = '$facname' AND 
                              (m.`date_from` BETWEEN DATE('$mysql_date1') AND DATE('$mysql_date2') OR
                               m.`date_to` BETWEEN DATE('$mysql_date1') AND DATE('$mysql_date2'))");
                              $countflag1 = mysqli_fetch_array($getcountflag1);
                              if ($countflag1['count'] != 0) {
                                $checkerforpres = 1;
                                $presid = $countflag1['id'];
                              }
                            }
                          } else if ($_POST['from'] == "College of Engineering, Dean") {
                            $mysql_date1 = date('Y-m-d', strtotime($_POST['date_from']));
                            $mysql_date2 = date('Y-m-d', strtotime($_POST['date_to']));
                            foreach ($_POST['sendtofac'] as $facname) {
                              $getcountflag1 = mysqli_query($conn, "SELECT COUNT(*) AS `count` FROM `memo` m INNER JOIN 
                              `memo_route` mr ON mr.`memo_id` = m.`id` WHERE m.`from` != 'College of Engineering, Dean' 
                              AND mr.`faculty_name` = '$facname' AND 
                              (m.`date_from` BETWEEN DATE('$mysql_date1') AND DATE('$mysql_date2') OR
                               m.`date_to` BETWEEN DATE('$mysql_date1') AND DATE('$mysql_date2'));");
                              $countflag1 = mysqli_fetch_array($getcountflag1);
                              if ($countflag1['count'] != 0) {
                                $checker = 1;
                              }
                            }
                          }

                          if ($checker == 0) {
                            if ($checkerforpres == 0 and $checkformc == 0) {
                              $getcount = mysqli_query($conn, "SELECT count(*) as count FROM memo WHERE `from` = '" . trim($_POST['from']) . "';");
                              $count = mysqli_fetch_array($getcount);
                              $number = $count['count'] + 1;
                              $number = "000" . $number;
                              $sql = 'INSERT INTO memo (memo_number, `from`, `date_created`,`date_from`,`date_to`, `subject`, content, additional_info) 
                                        VALUES ("' . $number . '","' . trim($_POST['from']) . '","' . $_POST['date_created'] . '",
                                        "' . $_POST['date_from'] . '","' . $_POST['date_to'] . '",
                                        "' . $_POST['subject'] . '","' . $_POST['content'] . '","' . $_POST['add_info'] . '")';
                              if ($conn->query($sql) === TRUE) {

                                $getid = "SELECT id FROM `memo` ORDER BY id DESC LIMIT 1;";
                                $resultid = mysqli_query($conn, $getid);
                                $id = mysqli_fetch_array($resultid);
                                echo $id['id'];
                                foreach ($_POST['sendtofac'] as $facname) {
                                  $sqlroute = "INSERT INTO `memo_route` (memo_id, faculty_name)
                                        VALUES (" . $id['id'] . ",'" . $facname . "');";
                                  if ($conn->query($sqlroute) === FALSE) {
                                    echo '<script>alert("Adding Memo Failed!\n Please Check SQL Connection String!") 
                                          window.location.href="memo.php"</script>';
                                  }
                                }

                                echo '<script>alert("Memo Addedd Successfully!") 
                                                      window.location.href="memo.php"</script>';
                              } else {
                                echo '<script>alert("Adding Memo Failed!\n Please Check SQL Connection String!") 
                                                        window.location.href="memo.php"</script>';
                              }
                            } else if ($checkerforpres == 1 and $checkformc == 0) {
                              $getcount = mysqli_query($conn, "SELECT count(*) as count FROM memo WHERE `from` = '" . trim($_POST['from']) . "';");
                              $count = mysqli_fetch_array($getcount);
                              $number = $count['count'] + 1;
                              $number = "000" . $number;
                              $sql = 'INSERT INTO memo (memo_number, `from`, `date_created`,`date_from`,`date_to`, `subject`, content, additional_info) 
                                        VALUES ("' . $number . '","' . trim($_POST['from']) . '","' . $_POST['date_created'] . '",
                                        "' . $_POST['date_from'] . '","' . $_POST['date_to'] . '",
                                        "' . $_POST['subject'] . '","' . $_POST['content'] . '","' . $_POST['add_info'] . '")';
                              if ($conn->query($sql) === TRUE) {

                                $getid = "SELECT id FROM `memo` ORDER BY id DESC LIMIT 1;";
                                $resultid = mysqli_query($conn, $getid);
                                $id = mysqli_fetch_array($resultid);
                                echo $id['id'];
                                foreach ($_POST['sendtofac'] as $facname) {
                                  $sqlroute = "INSERT INTO `memo_route` (memo_id, faculty_name)
                                        VALUES (" . $id['id'] . ",'" . $facname . "');";
                                  if ($conn->query($sqlroute) === FALSE) {
                                    echo '<script>alert("Adding Memo Failed!\n Please Check SQL Connection String!") 
                                          window.location.href="memo.php"</script>';
                                  }
                                }

                                $sqledit = "UPDATE `memo` m SET m.`is_void` = 1 WHERE m.`id` = $mcid;";
                                $conn->query($sqledit);

                                $getdetails = "SELECT * FROM `memo` m where m.`id` = $mcid;";
                                $actgetdetails = mysqli_query($conn, $getdetails);
                                $details = mysqli_fetch_array($actgetdetails);
                                echo '<script>alert("Memo Addedd Successfully! Memo from ' . $details['from'] . ' for ' . $details['date_from'] . ' to ' . $details['date_to'] . ' has been voided!") 
                                                      window.location.href="memo.php"</script>';
                              } else {
                                echo '<script>alert("Adding Memo Failed!\n Please Check SQL Connection String!") 
                                                        window.location.href="memo.php"</script>';
                              }
                            } else if ($checkerforpres == 0 and $checkformc == 1) {
                              $getcount = mysqli_query($conn, "SELECT count(*) as count FROM memo WHERE `from` = '" . trim($_POST['from']) . "';");
                              $count = mysqli_fetch_array($getcount);
                              $number = $count['count'] + 1;
                              $number = "000" . $number;
                              $sql = 'INSERT INTO memo (memo_number, `from`, `date_created`,`date_from`,`date_to`, `subject`, content, additional_info) 
                                        VALUES ("' . $number . '","' . trim($_POST['from']) . '","' . $_POST['date_created'] . '",
                                        "' . $_POST['date_from'] . '","' . $_POST['date_to'] . '",
                                        "' . $_POST['subject'] . '","' . $_POST['content'] . '","' . $_POST['add_info'] . '")';
                              if ($conn->query($sql) === TRUE) {

                                $getid = "SELECT id FROM `memo` ORDER BY id DESC LIMIT 1;";
                                $resultid = mysqli_query($conn, $getid);
                                $id = mysqli_fetch_array($resultid);
                                echo $id['id'];
                                foreach ($_POST['sendtofac'] as $facname) {
                                  $sqlroute = "INSERT INTO `memo_route` (memo_id, faculty_name)
                                        VALUES (" . $id['id'] . ",'" . $facname . "');";
                                  if ($conn->query($sqlroute) === FALSE) {
                                    echo '<script>alert("Adding Memo Failed!\n Please Check SQL Connection String!") 
                                          window.location.href="memo.php"</script>';
                                  }
                                }

                                $sqledit = "UPDATE `memo` m SET m.`is_void` = 1 WHERE m.`id` = $presid;";
                                $conn->query($sqledit);

                                $getdetails = "SELECT * FROM `memo` m where m.`id` = $presid;";
                                $actgetdetails = mysqli_query($conn, $getdetails);
                                $details = mysqli_fetch_array($actgetdetails);
                                echo '<script>alert("Memo Addedd Successfully! Memo from ' . $details['from'] . ' for ' . $details['date_from'] . ' to ' . $details['date_to'] . ' has been voided!") 
                                                      window.location.href="memo.php"</script>';
                              } else {
                                echo '<script>alert("Adding Memo Failed!\n Please Check SQL Connection String!") 
                                                        window.location.href="memo.php"</script>';
                              }
                            }
                          } else {
                            echo '<script>alert("Another Memo issued of ' . $mysql_date1 . ' to ' . $mysql_date2 . '!") 
                            window.location.href="memo.php"</script>';
                          }
                        } else {
                          echo '<script>alert("Date To must be later than Date From!") 
                                                window.location.href="memo.php"</script>';
                        }
                      }

                      ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
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
    // function modalOpen(){
    $(document).ready(function() {
      $("#myBtn").click(function() {
        $("#myModal").modal("toggle");
      });
    });
    // }
  </script>
  <script>
    $(document).ready(function() {

      var multipleCancelButton = new Choices('#multiple-checkboxes', {
        removeItemButton: true,
        //  maxItemCount:5,
        //  searchResultLimit:5,
        //  renderChoiceLimit:5
      });


    });
  </script>
  <!-- <script>
    // function modalOpen(){
    $(document).ready(function () {
      $("#department").click(function () {
        $("#courseModal").modal("toggle");
      });
    });
  // }
  </script>
  <script>
    // function modalOpen(){
    $(document).ready(function () {
      $("#course").click(function () {
        $("#memoModal").modal("toggle");
      });
    });
  // }
  </script> -->

  <script>
    //       Array.from(document.getElementsByClassName('showmodal')).forEach( (e) => {
    //   e.addEventListener('click', function(element) {
    //     element.preventDefault();
    //     if (e.hasAttribute('data-show-modal')) {
    //       showModal(e.getAttribute('data-show-modal'));
    //     }
    //   });
    // });
    // // Show modal dialog
    // function showModal(modal) {
    //   const mid = document.getElementById(modal);
    //   let myModal = new bootstrap.Modal(mid);
    //   myModal.show();
    // }
    //   
  </script>

  <script>
    $(document).ready(function() {
      $('#multiple-checkboxes').multiselect({
        includeSelectAllOption: true,
      });
    });
  </script>

</body>

</html>