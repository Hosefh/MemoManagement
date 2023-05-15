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

  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

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
                      <!-- <div class="col-sm-2">
                        <select class="form-select" aria-label="Default select example">
                          <option selected>Department</option>
                          <option value="1">Department 1</option>
                          <option value="2">Department 2</option>
                          <option value="3">Department 3</option>
                        </select>
                      </div>
                      <div class="col-sm-2">
                        <select class="form-select" aria-label="Default select example">
                          <option selected>Course</option>
                          <option value="1">Of Course</option>
                          <option value="2">Two Course</option>
                          <option value="3">Inter Course</option>
                        </select>
                      </div> -->
                    </div>

                    <!-- Modal 1 -->
                    <!-- <div id="myModal" class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Select Department</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">

                            <form class="needs-validation" method="POST" enctype="multipart/form-data">
                            <div class="dropdown mb-2">
                                    <label for="validationCustom01">Select Department:</label>
                                      <select class="department-select" aria-label="Default select example" name="department">
                                        <option value=""></option>
                                        <?php
                                        $sql = "SELECT DISTINCT(department) as `department` FROM `faculty`;";
                                        $actresultd = mysqli_query($conn, $sql);
                                        ?>
                                        <?php while ($resultdep = mysqli_fetch_assoc($actresultd)) { ?>
                                            <option value=" <?php echo $resultdep['department'] ?>"> <?php echo $resultdep['department'] ?></option>
                                        <?php } ?>
                                        
                                      </select>
                                  </div>
                              <div class="modal-footer">
                                <input type="reset" class="btn btn-secondary">
                                <button class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#courseModal">
                                  Next
                                </button>
                              </div>  
                            </form>
                            <-- php code here  -->
                            <!-- <script>
                              $(document).ready(function() {
                                  $("select.department-select").change(function() {
                                      let selectedItem = $(this).children("option:selected").val();
                                      document.cookie = "department="+selectedItem;
                                    });
                                });
                            </script>

                          </div>
                        </div>
                      </div>
                    </div> -->
                    <!-- End of Modal 1 -->

                    <!-- Modal 2 -->
                    <!-- <div id="courseModal" class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Select Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">

                            <form class="needs-validation" method="POST" enctype="multipart/form-data">
                            <div class="dropdown mb-2">
                                    <label for="validationCustom01">Select Course:</label>
                                      <select class="course-select" aria-label="Default select example" name="course">
                                        <?php
                                        $sql = "SELECT DISTINCT (course_abb) as course_abb FROM `faculty` WHERE department = '".$_COOKIE['department']."';";
                                        $actresultc = mysqli_query($conn, $sql);
                                        ?>
                                        <?php while ($resultcourse = mysqli_fetch_assoc($actresultc)) { ?>
                                            <option value=" <?php echo $resultcourse['course_abb'] ?>"> <?php echo $resultcourse['course_abb'] ?></option>
                                        <?php } ?>
                                        
                                        <-- <option value="Roselle P. Cimagala">Roselle P. Cimagala</option>
                                        <option value="Dr. Edward C. Anuta">Dr. Edward C. Anuta</option> -->
                                      <!-- </select>
                                  </div>
                              <div class="modal-footer">
                                <input type="reset" class="btn btn-secondary">
                                <button class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#memoModal">
                                  Next
                                </button>
                              </div>  
                            </form> -->
                            <!-- php code here -->
                            <!-- <script>
                              $(document).ready(function() {
                                  $("select.course-select").change(function() {
                                      let selectedCourse = $(this).children("option:selected").val();
                                      // alert("You have selected the name - " + selectedCourse);
                                      document.cookie = "course="+selectedCourse;
                                    });
                                });
                            </script>
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <!-- End of Modal 2 -->

                    <!-- Modal HTML -->
                  
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
                  $sql = "SELECT * FROM `memo`;";
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
                            <td>
                              <?php echo $result['subject'] ?>
                            </td>
                            <td>
                              <?php echo $result['date'] ?>
                            </td>
                            <td>
                              <div class="d-grid gap-2 d-md-flex">
                              <a href="./generateMemo.php?id=<?php echo $result['id'] ?>" target=”_blank” class="btn btn-primary btn-sm me-md-2"><span
                              class="me-2"><i class="bi bi-folder2-open"></i></span> View Memo</a> 
                              ||
                              <a href="#edit<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm me-md-2" ><span
                              class="me-2"><i class="bi bi-pen"></i></span> Edit</a>
                              ||
                                <a href="#del<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span
                                    class="me-2"><i class="bi bi-trash"></i></span> Delete
                                </a>
                              </div>
                            </td>
                          </tr>
                      

                          <!-- Start of Edit Modal -->
                          <div id="edit<?php echo $result['id']; ?>" class="modal fade" data-bs-backdrop="static" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Create Memo</h5>
                                  <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
                                </div>
                                <div class="modal-body">

                                  <form class="needs-validation" method="POST" enctype="multipart/form-data">
                                    <div class="form-row">
                                      <input type="number" class="form-control" id="" name="edit_id" value="<?php echo $result['id']; ?>" hidden>
                                      <?php
                                      $id = $result['id'];
                                      $edit = mysqli_query($conn, "select *, date(`date`) as Edit_Date from memo where id=" . $result['id'] . "");
                                      $erow = mysqli_fetch_array($edit);
                                      ?>
                                      <div class="row">
                                      <div class="col-md-6 mb-2">
                                        <label for="validationCustom01">Memo Number:</label>
                                        <input type="number" class="form-control" id="" name="edit_memo_number" value="<?php echo $erow['memo_number'] ?>" required>
                                        <div class="valid-feedback">
                                          Looks good!
                                        </div>
                                      </div>
                                      <div class="col-md-6 mb-2">
                                        <label for="validationCustom01">Date:</label>
                                        <input type="date" class="form-control" id="" name="edit_date" value="<?php echo $erow['Edit_Date'] ?>" required>
                                        <div class="valid-feedback">
                                          Looks good!
                                        </div>
                                      </div>
                                      </div>
                                      <div class="row">
                                        <div class="dropdown col-md-8 mb-2">
                                            <label for="validationCustom01">To:</label>
                                              <select class="form-select1" id="multiple-checkboxes1" aria-label="Default select example" name="edit_to">
                                                <option value=" <?php echo $erow['send_to'] ?>"> <?php echo $erow['send_to'] ?></option>
                                                <?php
                                                $faculty_name = trim($erow['send_to']);
                                                $sql2 = "SELECT * FROM `faculty` WHERE `name`!='" . $faculty_name . "';";
                                                $actresult1 = mysqli_query($conn, $sql2);
                                                ?>
                                                <?php while ($result1 = mysqli_fetch_assoc($actresult1)) { ?>
                                                    <option value=" <?php echo $result1['name'] ?>"> <?php echo $result1['name'] ?></option>
                                                <?php } ?>
                                              
                                                <!-- <option value="Roselle P. Cimagala">Roselle P. Cimagala</option>
                                              <option value="Dr. Edward C. Anuta">Dr. Edward C. Anuta</option> -->
                                              </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                          <label for="validationCustom01">From:</label>
                                          <input type="text" class="form-control" id="" name="edit_from" value="<?php echo $erow['from'] ?>" required>
                                          <div class="valid-feedback">
                                            Looks good!
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                        <label for="validationCustom01">Subject:</label>
                                        <input type="text" class="form-control" id="" name="edit_subject" value="<?php echo $erow['subject'] ?>" required>
                                        <div class="valid-feedback">
                                          Looks good!
                                        </div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                        <label for="validationCustom01">Content:</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="edit_content" ><?php echo $erow['content'] ?></textarea>
                                        <div class="valid-feedback">
                                          Looks good!
                                        </div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                        <label for="validationCustom01">Additional Information:</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="edit_add_info" ><?php echo $erow['content'] ?></textarea>
                                          <div class="valid-feedback">
                                            Looks good!
                                          </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="reset" class="btn btn-secondary">
                                      <button class="btn btn-primary">Save</button>
                                    </div>  
                                  </form>
                                  <!-- php code here -->
                                  <?php
                                  if (isset($_POST['edit_memo_number'])) {
                                   //echo $test;
                                    $sql = "UPDATE `memo` SET memo_number = '" . $_POST['edit_memo_number'] . "' ,
                                   send_to = '" . $_POST['edit_to'] . "',
                                   `from` = '" . $_POST['edit_from'] . "',
                                   `date` = '" . $_POST['edit_date'] . "',
                                   `subject` = '" . $_POST['edit_subject'] . "',
                                   content = '" . $_POST['edit_content'] . "',
                                   additional_info = '" . $_POST['edit_add_info'] . "'
                                   WHERE id  = " . $_POST['edit_id'] . ";";
                                    if ($conn->query($sql) === TRUE) {
                                      echo '<script>alert("Memo Addedd Successfully!") 
                                                    window.location.href="memo.php"</script>';
                                    } else {
                                      echo '<script>alert("Adding Memo Failed!\n Please Check SQL Connection String!") 
                                                    window.location.href="memo.php"</script>';
                                    }
                                  }
                                  ?>

                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Delete -->
                          <div class="modal fade" id="del<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true">
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
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                        class="glyphicon glyphicon-remove"></span> Cancel</button>
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
                      <?php } ?>
                  </tbody>
                  <tfoot></tfoot>
                </table>
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
                                <div class="col-md-6 mb-2">
                                  <label for="validationCustom01">Memo Number:</label>
                                  <input type="number" class="form-control" id="" name="memo_number" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                  <label for="validationCustom01">Date:</label>
                                  <input type="date" class="form-control" id="" name="date" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                </div>
                                  <div class="col-md-12 mb-2">
                                    <label for="validationCustom01">Subject:</label>
                                    <input type="text" class="form-control" id="" name="subject" required>
                                    <div class="valid-feedback">
                                      Looks good!
                                    </div>
                                  </div>
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom01">Content:</label>
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
                                  <div class="col-md-4 mb-2">
                                    <label for="validationCustom01">From:</label>
                                    <input type="text" class="form-control" id="" name="from" required>
                                    <div class="valid-feedback">
                                      Looks good!
                                    </div>
                                  </div>
                                  <div class="dropdown col-md-8 mb-2">
                                    <label for="validationCustom01">To:</label>
                                    <select class="form-select" multiple id="multiple-checkboxes" placeholder="Select Faculty" aria-label="Default select example" name="sendtofac[]">
                                      <?php
                                        $sql = "SELECT * FROM `faculty`;";
                                        $actresult = mysqli_query($conn, $sql);
                                        ?>
                                        <?php while ($result = mysqli_fetch_assoc($actresult)) { ?>
                                            <option value=" <?php echo $result['name'] ?>"> <?php echo $result['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              <div class="modal-footer">
                                <input type="reset" class="btn btn-secondary">
                                <button class="btn btn-primary">Save</button>
                              </div>  
                            </form>
                            <!-- php code here -->
                            <?php
                            if (isset($_POST['memo_number'])) {
                              if(isset($_POST['sendtofac']))
                              {
                                $sql = "INSERT INTO memo (memo_number, `from`, `date`, `subject`, content, additional_info) 
                                VALUES ('" . $_POST['memo_number'] . "','" . $_POST['from'] . "','" . $_POST['date'] . "','" . $_POST['subject'] . "','" . $_POST['content'] . "','" . $_POST['add_info'] . "')";
                                if ($conn->query($sql) === TRUE) {
                                  $GetID = mysqli_query($conn, "SELECT `id` from memo ORDER BY id DESC LIMIT 1;");
                                  $ID = mysqli_fetch_array($GetID);
                                  foreach ($_POST['sendtofac'] as $tofac){
                                    $sqlroute = "INSERT INTO memo_route(memo_id,faculty_name)
                                    VALUES ('".$ID['id']."','" .$tofac. "')";
                                    $conn->query($sqlroute);
                                  }
                                  echo '<script>alert("Memo Addedd Successfully!") 
                                                  window.location.href="memo.php"</script>';
                                } else {
                                  echo '<script>alert("Adding Memo Failed!\n Please Check SQL Connection String!") 
                                                  window.location.href="memo.php"</script>';
                                }
                              }
                              else
                                echo "Select an option first !!";
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
    $(document).ready(function () {
      $("#myBtn").click(function () {
        $("#myModal").modal("toggle");
      });
    });
  // }
  </script>
  <script>
    $(document).ready(function(){
    
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
//   </script>

  <script>
     $(document).ready(function() {
        $('#multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
        });
    });
  </script>

</body>

</html>