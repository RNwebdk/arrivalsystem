<table class="table table-hover">
  <thead>
    <tr class="table-dark">
      <th scope="col">Name</th>
      <th>Grade</th>
      <th>Edit</th>
    </tr>
  </thead>
  <tbody id="pupilsTable">
  </tbody>
</table>

<script>
  let pupilsTable = document.getElementById('pupilsTable');
  pupilsTable.addEventListener('click', (e) => {
    if (e.srcElement.className === "fa fa-times unityCheckIcon") {
      if (confirm("Are you sure you want to delete this student?")) {
        window.location = this.href;
      }else{
        e.preventDefault();
      }
    }
  });
</script>