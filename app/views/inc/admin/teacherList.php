<table class="table table-hover" id="teachersTable">
  <thead>
    <tr class="table-dark">
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
     <?php foreach ($data['allTeachers'] as $teacher): ?>
      <tr>
        <th scope="row"><?= $teacher->firstname . " " . $teacher->lastname; ?></th>
        <td><?= $teacher->email; ?></td>
        <td>
          <a href="<?= URLROOT . "/teachers/edit/" . $teacher->id ?>"><i class="fa fa-edit unityCheckIcon"></i></a>
          <a href="<?= URLROOT . "/teachers/remove/" . $teacher->id ?>"><i class="fa fa-times unityCheckIcon"></i></a>
        </td>
      </tr>
     <?php endforeach ?>
  </tbody>
</table>

<script>
  let teachersTable = document.getElementById('teachersTable');

  teachersTable.addEventListener('click', (e) => {

    if (e.srcElement.className === "fa fa-times unityCheckIcon") {
      if (confirm("Are you sure you want to delete this teacher ?")) {
        window.location = this.href;
      }else{
        e.preventDefault();
      }
    }
  });
</script>

