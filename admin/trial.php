<!DOCTYPE html>
<html>
  <head>
    <title>Title of the Document</title>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
  </head>

  <body>
    <form>
      <label>Select Names:</label>
      <select class="department-select">
        <option value="1">Tom</option>
        <option value="2">John</option>
        <option value="3">James</option>
        <option value="4">Ann</option>
        <option value="5">Maria</option>
      </select>
    </form>
    <script>
      $(document).ready(function() {
          $("select.department-select").change(function() {
              let selectedItem = $(this).children("option:selected").val();
              alert("You have selected the name - " + selectedItem);
            });
        });
    </script>

<form>
      <label>Select Names:</label>
      <select class="course-select">
        <option value="1">Tom</option>
        <option value="2">John</option>
        <option value="3">James</option>
        <option value="4">Ann</option>
        <option value="5">Maria</option>
      </select>
    </form>
    <script>
      $(document).ready(function() {
          $("select.course-select").change(function() {
              let selectedCourse = $(this).children("option:selected").val();
              alert("You have selected the course - " + selectedCourse);
            });
        });
    </script>
  </body>
</html>