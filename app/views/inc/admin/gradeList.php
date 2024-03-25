<table class="table table-hover" id="gradesTable">
  <thead>
    <tr class="table-dark">
      <th scope="col">Grade</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
     <?php foreach ($data['allGrades'] as $grade): ?>
      <tr>
        <td><?= $grade->name; ?></td>
        <td>
          <a href="<?= URLROOT . "/grades/edit/" . $grade->id ?>"><i class="fa fa-edit unityCheckIcon"></i></a>
          <a href="<?= URLROOT . "/grades/remove/" . $grade->id ?>"><i class="fa fa-times unityCheckIcon"></i></a>
        </td>
      </tr>
     <?php endforeach ?>
  </tbody>
</table>

<script>
  let gradesTable = document.getElementById('gradesTable');

  gradesTable.addEventListener('click', (e) => {

    if (e.srcElement.className === "fa fa-times unityCheckIcon") {
      if (confirm("Are you sure you want to delete this grade?")) {
        window.location = this.href;
      }else{
        e.preventDefault();
      }
    }
  });
</script>

