<?php
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
              <span><i class="bi bi-file-text-fill me-2"></i></span>Signed Memorandums
            </div>
            <div class="card-body">
                    <!-- <button type="button" id="myBtn" class="btn btn-outline-success">
                      <span class="me-2"><i class="bi bi-arrow-right-circle"></i></span>
                      Forward Signed Memo
                    </button> -->

                    <!-- Modal HTML -->
                    <!-- <div id="myModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Return Signed Memo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">

                            <form class="needs-validation" method="POST" enctype="multipart/form-data">
                              <div class="form-row">
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom01">Memo Title:</label>
                                  <input type="text" class="form-control" id="" name="memo_name" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom01">ID:</label>
                                  <input type="number" class="form-control" id="" name="signatories" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                  <label for="validationCustom01">Select a file:</label>
                                  <input type="file" class="form-control" id="" name="image" value="" accept=".jpg,.jpeg,.png" required>
                                  <div class="valid-feedback">
                                    Looks good!
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <input type="reset" class="btn btn-secondary">
                                <button class="btn btn-primary">Upload</button>
                              </div>  
                            </form>
                            <?php
                            if (isset($_POST['memo_name'])) {
                                if (!empty($_FILES["image"]["name"])) {
                                    $fileName = basename($_FILES["image"]["name"]);
                                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                                    // Allow certain file formats 
                                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                                    if (in_array($fileType, $allowTypes)) {
                                        $image = $_FILES['image']['tmp_name'];
                                        $imgContent = addslashes(file_get_contents($image));

                                        $insert = $conn->query("INSERT into `memos` (memo_title, signatories,`image`) VALUES ('" . $_POST['memo_name'] . "', '" . $_POST['signatories'] . "','$imgContent')");
                                        if ($insert) {
                                            echo "<script>window.location.href='memo.php'</script>";
                                        } else {
                                            echo "<script>
                                        alert('Failed');
                                        window.location.href='memo.php';
                                        </script>";
                                        }
                                    }
                                } else {
                                    echo '<script>alert("No image data!") 
                                window.location.href="memo.php"</script>';
                                }
                            }
                            ?>

                          </div>
                        </div>
                      </div>
                    </div> -->

              <div class="table-responsive">
                <table id="example" class="table table-hover data-table" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Memorandum Title</th>
                      <th>Signed?</th>
                      <th>Date Signed</th>
                      <th>Forwarded To</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody style="cursor: pointer" id="myBtn">
                    <?php
                    $sql = "SELECT DISTINCT(m.id), m.memo_title, DATE(m.date_created) AS date_created, m.signatories,m.is_signed, m.user_id  FROM `forwarding_tracking` ft 
                    INNER JOIN `memos` m ON m.`id` = ft.`memo_id`
                    WHERE m.user_id = ".$_SESSION['userid']." and ft.is_signed = 1 and m.ready_for_forwarding = 0 and ft.is_forwarded = 0;";
                    $actresult = mysqli_query($conn, $sql);

                    while ($result = mysqli_fetch_assoc($actresult)) {
                        ?>
                        <tr>
                          <td>
                            <?php echo $result['memo_title']; ?>
                          </td>
                          <td>
                            <?php echo $result['is_signed']; ?>
                          </td>
                          <td>
                            <?php echo $result['date_created']; ?>
                          </td>
                          <td>
                            <?php echo $result['user_id']; ?>
                          </td>
                          <td>
                            <div class="d-grid gap-2 d-md-flex">
                            <!-- <a href="./memorandum.php"<?php echo $result['id']; ?> class="btn btn-primary btn-sm me-md-2"><span
                                  class="me-2"><i class="bi bi-folder2-open"></i></span> View Memo</a> -->
                                <a href="#fwd<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-success btn-sm"><span
                              class="me-2"><i class="bi bi-arrow-right"></i></span> Forward
                          </a> 
                              <!-- ||
                              <a href="#del<?php echo $result['id']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span
                                  class="me-2"><i class="bi bi-trash"></i></span> Delete
                              </a> -->
                            </div>
                          </td>
                        </tr>

                        <!-- Forward Modal -->
                        <div class="modal fade" id="fwd<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="memoModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                              <form id="update_form" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Return Memorandum</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                  <!-- Modal Body with Image -->
                                <div class="modal-body" >
                                  <p>Image Preview</p>
                                    <?php
                                    $id = $result['id'];
                                    $edit = mysqli_query($conn, "select * from memos where id='" . $result['id'] . "'");
                                    $erow = mysqli_fetch_array($edit);
                                    echo '<div>
                                    <img src="data:image/jpeg;base64,' . base64_encode($erow['image']) . '" id="memoImage" class="img-fluid" />';
                                    echo "</div>";
                                    ?>
                                                <!-- <h6>Create Signature</h6>
                                  <canvas id="signatureCanvas" width="300" height="150" style="border: 1px ridge #000;"></canvas> -->
                                          
                                                <div class="form-row pt-2">
                                                  <div class="col-md-12 mb-2">
                                                  <input type="hidden" id="id_m" name="editid" value="<?php echo $result['id']; ?>" class="form-control" required>
                                                  <div class="col-md-12 mb-2">
                                                    <label for="validationCustom01">Memo Title:</label>
                                                    <input type="text" class="form-control" id="memo_name_m" name="memo_name" value="<?php echo $result['memo_title']; ?>"  disabled>
                                                    <div class="valid-feedback">
                                                      Looks good!
                                                    </div>
                                                  </div>
                                                    <label for="validationCustom01">Forward To Signatory:</label>
                                                    <input type="number" class="form-control" id="user_m" name="user" required>
                                                    <div class="valid-feedback">
                                                      Looks good!
                                                    </div>
                                                  </div>
                                                </div>
                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary">Forward to Signatory</button>
                                                </div>
                                              </form>
                                              <?php
                                              if (isset($_POST['user'])) {
                                                $sql = "UPDATE `memos` SET user_id = '" . $_POST['user'] . "'
                                                        WHERE id ='" . $_POST['editid'] . "';";
                                                        
                                                $getid = mysqli_query($conn, "SELECT * FROM `forwarding_tracking` WHERE memo_id = ".$_POST['editid']." ORDER BY id DESC LIMIT 1;");
                                                $idrow = mysqli_fetch_array($getid);
                                                $id = $idrow['id'];
                                                $insert2 = $conn->query("UPDATE forwarding_tracking SET `is_forwarded` = 1 WHERE memo_id = ".$_POST['editid'].";");

                                                $conn->query("INSERT into forwarding_tracking (memo_id, forwarded_to) VALUES (".$_POST['editid'].",'" . $_POST['user'] . "');");

                                                if ($conn->query($sql) === TRUE) {
                                                  echo '<script>alert("Memo Forwarded Successfully!") 
                                                      window.location.href="signed.php"</script>';
                                                } else {
                                                  echo '<script>alert("Forwarding Failed!\n Please Check SQL Connection String!") 
                                                      window.location.href="signed.php"</script>';
                                                }
                                              }
                                              ?>
                                          
                                </div>
                              </div>
                            </div>
                          </div>
                                  <!-- End of Forward Modal -->


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
                    <?php } ?>
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

  <!-- <script>
      function addSignatureOnClick(event) {
  // Get the image element the user clicked on
  const clickedImage = event.target;

  // Create a new canvas element to draw the signature on
  const canvas = document.createElement('canvas');
  canvas.width = clickedImage.width; 
  canvas.height = clickedImage.height;

  // Get the 2D context of the canvas
  const ctx = canvas.getContext('2d');

  // Draw the image on the canvas
  ctx.drawImage(clickedImage, 0, 0);

  // Prompt the user to enter their signature
  const signature = prompt('Please enter your signature:', '');

  // Set the initial position of the signature
  let signatureX = event.offsetX;
  let signatureY = event.offsetY;

  // Draw the signature on the canvas
  ctx.font = 'bold 15px Arial';
  ctx.fillText(signature, signatureX, signatureY);

  // Replace the clicked image with the canvas
  clickedImage.parentNode.replaceChild(canvas, clickedImage);

  // Make the canvas resizable
  const resizable = new ResizeObserver(entries => {
    const { width, height } = entries[0].contentRect;
    canvas.width = width;
    canvas.height = height;
    ctx.drawImage(clickedImage, 0, 0);
    ctx.font = 'bold 15px Arial';
    ctx.fillText(signature, signatureX, signatureY);
  });
  resizable.observe(canvas);

  // Add event listeners for dragging the signature
  let isDragging = false;
  let prevX = 0;
  let prevY = 0;

  canvas.addEventListener('mousedown', e => {
    isDragging = true;
    prevX = e.clientX;
    prevY = e.clientY;
  });

  canvas.addEventListener('mousemove', e => {
    if (isDragging) {
      const deltaX = e.clientX - prevX;
      const deltaY = e.clientY - prevY;
      signatureX += deltaX;
      signatureY += deltaY;
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(clickedImage, 0, 0);
      ctx.font = 'bold 15px Arial';
      ctx.fillText(signature, signatureX, signatureY);
      prevX = e.clientX;
      prevY = e.clientY;
    }
  });

  canvas.addEventListener('mouseup', e => {
    isDragging = false;
  });
}

// Add a click event listener to all images
const images = document.querySelectorAll('img');
images.forEach(image => {
  image.addEventListener('click', addSignatureOnClick);
});

  </script> -->

          <!-- Script to open second modal on image click -->
          <script>
            document.getElementById('imageModal').addEventListener('click', function() {
            $('#secondModal').modal('show');
            });
            </script>

            <!-- Script for signature canvas functionality -->
            <script>
            var canvas = document.getElementById('signatureCanvas');
            var ctx = canvas.getContext('2d');
            var isDrawing = false;

            canvas.addEventListener('mousedown', function(e) {
            isDrawing = true;
            ctx.beginPath();
            ctx.moveTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top);
            });

            canvas.addEventListener('mousemove', function(e) {
            if (!isDrawing) return;
            ctx.lineTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top);
            ctx.stroke();
            });

            canvas.addEventListener('mouseup', function() {
            isDrawing = false;
            });

            document.getElementById('saveSignatureBtn').addEventListener('click', function() {
            // Convert canvas to image data URL
            var dataURL = canvas.toDataURL('image/png');

            // Create a link element to download the image
            var downloadLink = document.createElement('a');
            downloadLink.href = dataURL;
            downloadLink.download = 'signature.png';

            // Trigger the download
            downloadLink.click();

            // Clear the canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Close the second modal
            $('#secondModal').modal('hide');
            });
          </script>

</body>

</html>