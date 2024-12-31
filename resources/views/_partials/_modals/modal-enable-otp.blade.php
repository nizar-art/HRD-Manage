<!-- Add Category Department Modal -->
<div class="modal fade" id="addCategoryDepartment" tabindex="addCategoryDepartment" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-add-category-department modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">Add Category Department</h4>
          <p>Fill out the form below to add a new category.</p>
        </div>
        <form id="addCategoryDepartmentForm" class="row g-5" onsubmit="return false" method="post">
          <div class="col-12">
            <input type="hidden" name="id" id="id" class="form-control">
            <label class="form-label" for="modalAddCategory">Category</label>
            <div class="input-group">
              <input type="text" id="name_department" name="name_department" class="form-control" placeholder="Enter category name" />
            </div>
          </div>
          <div class="col-12">
            <button type="submit" id="type-success" class="btn btn-primary" form="addCategoryDepartmentForm">Submit</button>
            <button type="reset" class="btn btn-label-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Add Category Department Modal -->
