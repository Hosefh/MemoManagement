<?php
include "../dbcon.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Memorandum Management</title>

  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
 
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
                    <button type="button" id="myBtn" class="btn btn-outline-success">
                      <span class="me-2"><i class="bi bi-file-earmark-plus"></i></span>
                      Add Memo
                    </button>

                    <!-- Modal HTML -->
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
                                  <input type="date" class="form-control" id="" name="fwdsignatory" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="dropdown col-md-8 mb-2">
                                <label for="validationCustom01">To:</label>
                                  <select class="form-select" id="multiple-checkboxes" aria-label="Default select example">
                                    <option selected>Select Faculty</option>
                                    <option value="Engr. Julius Castro">Engr. Julius Castro</option>
                                    <option value="Roselle P. Cimagala">Roselle P. Cimagala</option>
                                    <option value="Dr. Edward C. Anuta">Dr. Edward C. Anuta</option>
                                  </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                  <label for="validationCustom01">From:</label>
                                  <input type="text" class="form-control" id="" name="memo_name" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom01">Subject:</label>
                                  <input type="text" class="form-control" id="" name="signatories" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom01">Content:</label>
                                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom01">Additional Information:</label>
                                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
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

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <thead>
                    <tr>
                      <th>Memo #</th>
                      <th>To</th>
                      <th>From</th>
                      <th>Subject</th>
                      <th>Date Created</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody style="cursor: pointer" id="myBtn">
                    
                                  <tr>
                                    <td>
                                      1
                                    </td>
                                    <td>
                                      Max
                                    </td>
                                    <td>
                                      Dog
                                    </td>
                                    <td>
                                      Reunion Meeting
                                    </td>
                                    <td>
                                      05-11-2023
                                    </td>
                                    <td>
                                      <div class="d-grid gap-2 d-md-flex">
                                      <a href="./generateMemo.php" target=”_blank” class="btn btn-primary btn-sm me-md-2"><span
                                      class="me-2"><i class="bi bi-folder2-open"></i></span> View Memo</a> 
                                      ||
                                      <a href="#edit" class="btn btn-primary btn-sm me-md-2"><span
                                      class="me-2"><i class="bi bi-pen"></i></span> Edit</a>
                                      ||
                                        <a href="#del" data-toggle="modal" class="btn btn-danger btn-sm"><span
                                            class="me-2"><i class="bi bi-trash"></i></span> Delete
                                        </a>
                                      </div>
                                    </td>
                                  </tr>

                                  <!-- Start of Edit Modal -->
                                  <!-- Edit Modal HTML -->
                                  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="memoModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xl">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title">Update Memo</h5>
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
                                                <input type="date" class="form-control" id="" name="fwdsignatory" required>
                                                <div class="valid-feedback">
                                                  Looks good!
                                                </div>
                                              </div>
                                              </div>
                                              <div class="row">
                                              <div class="dropdown col-md-8 mb-2">
                                              <label for="validationCustom01">To:</label>
                                                <select class="form-select" aria-label="Default select example">
                                                  <option selected>Select Faculty</option>
                                                  <option value="1">Engr. Julius Castro</option>
                                                  <option value="2">Roselle P. Cimagala</option>
                                                  <option value="3">Dr. Edward C. Anuta</option>
                                                </select>
                                              </div>
                                              <div class="col-md-4 mb-2">
                                                <label for="validationCustom01">From:</label>
                                                <input type="text" class="form-control" id="" name="memo_name" required>
                                                <div class="valid-feedback">
                                                  Looks good!
                                                </div>
                                              </div>
                                              </div>
                                              <div class="col-md-12 mb-2">
                                                <label for="validationCustom01">Subject:</label>
                                                <input type="text" class="form-control" id="" name="signatories" required>
                                                <div class="valid-feedback">
                                                  Looks good!
                                                </div>
                                              </div>
                                              <div class="col-md-12 mb-2">
                                                <label for="validationCustom01">Content:</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                <div class="valid-feedback">
                                                  Looks good!
                                                </div>
                                              </div>
                                              <div class="col-md-12 mb-2">
                                                <label for="validationCustom01">Addittional Information:</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                <div class="valid-feedback">
                                                  Looks good!
                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button class="btn btn-primary">Save</button>
                                            </div>  
                                          </form>
                                          <!-- php code here -->

                                        </div>
                                      </div>
                        </div>
                                  </div>
                                  <!-- End of Edit Modal -->

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
                                          $del = mysqli_query($conn, "select * from memos where id='" . $result['id'] . "'");
                                          $drow = mysqli_fetch_array($del);
                                          ?>
                                          <div class="container-fluid">
                                            <h5>
                                              <center>Are you sure to delete <strong>
                                                <?php echo ucwords($drow['memo_title']); ?>
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
                                            $sql = "DELETE FROM memos WHERE id='" . $_POST['deleteid'] . "'";
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
                   
                  </tbody>
                  <tfoot></tfoot>
                </table>
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
     $(document).ready(function() {
        $('#multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
        });
    });
  </script>

</body>

</html>