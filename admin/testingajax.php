<?php

include "../dbcon.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type ="text/javascript">
    $(document).ready(function(){
        $('#facdep').change(function(){
        var course_id=$(this).val();
        $.ajax({
            url:"action.php",
            method:"post",
            data:{department:course_id},
            success:function(data){
                $("#multiple-checkboxes").html(data);
            }
            });
        });
    });
    </script>
</head>
<body>
    <form action="" method="POST">
        <div class="dropdown col-md-4 mb-2">
            <label for="validationCustom01">To:</label>
            <select class="form-control form-control-lg" name="facdep" id="facdep">
                <option value="" disabled selected> Select Name</option>
            <?php
                $sql = "SELECT distinct(`department`) as `department` FROM `faculty`;";
                $actresult = mysqli_query($conn, $sql);
                ?>
                <?php while ($result = mysqli_fetch_assoc($actresult)) { ?>
                    <option value=" <?php echo $result['department'] ?>"> <?php echo $result['department'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="dropdown col-md-4 mb-2">
            <label for="validationCustom01">names:</label>
            <select class="form-select" multiple id="multiple-checkboxes" placeholder="Select Faculty" aria-label="Default select example" name="facnames">
                    <option value="" disabled selected> Select Name</option>
            </select>
        </div>
    </form>
    
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
